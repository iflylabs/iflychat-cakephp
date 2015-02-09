<?php

    /**
    *
    * @author iFlyChatDev Team
    * Controller for the iflychat settings.
    * Handles all the request to iflychat plugin.
    * Populates data in iflychat_settings table and handles auth request.
    *
    */

    class IflychatSettingsController extends IflychatAppController
    {
	/**
	*
	* Components
	*
	*/
	public $components = array( 'RequestHandler', 'Session' );

	/**
	*
	* Helpers
	*
	*/
	public $helpers = array( 'Html', 'Form', 'Session', 'Js' );

	/**
	*
	* private variables
	*
	*/
	private $iflychat_user_details, $iflychat_default_user_details,$iflychat_settings;

	/**
	*
	* @function iflychat_populate_default
	* populates default values from database saved before, for chat settings
	*
	*/
	private function iflychat_populate_default()
	{
	    $iflychat_settings=$this->IflychatSetting->find( 'all' );
	    $this->iflychat_settings = array();
	    foreach($iflychat_settings as $row) {
		foreach($row as $model) {
		    $this->iflychat_settings[$model['key_setting']] = $model['key_setting_value'];
		}
	    }
	}

	/**
	*
	* @function iflychat_match_path
	* used to check whether a given string exists inside the second string with escaping of regexp characters.
	* @param String $path the string to be checked.
	* @param String $patterns the string in which given $path is to be searched.
	* @return boolean $page_match true when
	*
	*/
	private function iflychat_match_path($path, $patterns) {
	    $to_replace = array(
		'/(\r\n?|\n)/',
		'/\\\\\*/',
	    );
	    $replacements = array(
		'|',
		'.*',
	    );
	    $patterns_quoted = preg_quote($patterns, '/');
	    $regexps[$patterns] = '/^(' . preg_replace($to_replace, $replacements, $patterns_quoted) . ')$/';
	    return (bool) preg_match($regexps[$patterns], $path);
	}

	/**
	*
	* @function iflychat_path_check
	* checks whether the incoming url is allowed or not.
	* @param String $url url of the requesting page.
	* @return boolean true when the incoming url is allowed.
	*
	*/
	private function iflychat_path_check($url) {
	    $page_match = FALSE;
	    if (trim($this->iflychat_settings['Iflychat_path_pages']) != '') {
		if(function_exists('mb_strtolower')) {
		    $pages = mb_strtolower($this->iflychat_settings['Iflychat_path_pages']);
		    $path = mb_strtolower($url);
		}
		else {
		    $pages = strtolower($this->iflychat_settings['Iflychat_path_pages']);
		    $path = strtolower($url);
		}
		$page_match = $this->iflychat_match_path($path, $pages);
		$page_match = ($this->iflychat_settings['Iflychat_path_visibility'] == '1')?(!$page_match):$page_match;
	    }
	    else if($this->iflychat_settings['Iflychat_path_visibility'] == '1'){
		$page_match = TRUE;
	    }
	    return $page_match;
	}

    /*
    * @function is_ssl
    * checks protocol
    * @returns true if https
    *
    * */
    private function is_ssl(){

        return ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']) || ( isset($request_headers['X-Forwarded-Proto']) && $request_headers['X-Forwarded-Proto'] == 'https' ))?TRUE:FALSE;

    }

	/**
	*
	* @function iflychat_check_chat_admin
	* checks iflychat admin
	* @return boolean true when
	*
	*/
	private function iflychat_check_chat_admin() {
	    return $this->iflychat_user_details['is_admin'];
	}

	/**
	*
	* @function iflychat_get_user_name
	* Returns the current username if exists otherwise creates a random guest name
	* @return String name of the current user
	*
	*/
	private function iflychat_get_user_name() {
	    if($this->iflychat_user_details['name']) {
		return $this->iflychat_user_details['name'];
	    }
	    else {
		return $this->iflychat_get_current_guest_name();
	    }
	}

	/**
	*
	* @function iflychat_check_plain
	* converts predefined html characters to html entities including single and double quotes in UTF-8 character-set
	* @param String $text the text to be converted
	* @return String converted string.
	*
	*/
	private function iflychat_check_plain($text) {
	    return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
	}

	/**
	*
	* @function iflychat_compute_guest_session
	* returns the current session string for the guest.
	* @param String $id current guest user id.
	* @return String md5 hash of part of api key and guest id.
	*
	*/
	private function iflychat_compute_guest_session($id) {
	    return md5(substr($this->iflychat_settings['Iflychat_external_api_key'],0,5) . $id);
	}

	/**
	*
	* @function iflychat_get_random_name
	* returns a random guest name.
	* @return String random generated guest name.
	*
	*/
	private function iflychat_get_random_name() {
	    $path = Router::url('/', true) . 'iflychat/' . "guest_names/iflychat_guest_random_names.txt";
	    $f_contents = file($path);
	    $line = trim($f_contents[rand(0, count($f_contents) - 1)]);
	    return $line;
	}

	/**
	*
	* @function iflychat_get_current_guest_name
	* generates the current guest name using some random string if no cookie exist otherwise assigns the same previous name using cookies.
	* assigns a cookie for the generated name.
	* @return String the name of the guest.
	*
	*/
	private function iflychat_get_current_guest_name() {
	    if(isset($_SESSION) && isset($_SESSION['iflychat_guest_name'])) {
		setrawcookie('iflychat_guest_name', rawurlencode($_SESSION['iflychat_guest_name']), time()+60*60*24*365);
	    }
	    else if(isset($_COOKIE) && isset($_COOKIE['iflychat_guest_name']) && isset($_COOKIE['iflychat_guest_session'])&& ($_COOKIE['iflychat_guest_session']==$this->iflychat_compute_guest_session($this->iflychat_get_current_guest_id()))) {
		$_SESSION['iflychat_guest_name'] = $this->iflychat_check_plain($_COOKIE['iflychat_guest_name']);
	    }
	    else {
		if($this->iflychat_settings['Iflychat_anon_use_name']=='1') {
		    $_SESSION['iflychat_guest_name'] = $this->iflychat_check_plain($this->iflychat_settings['Iflychat_anon_prefix'] . ' ' . $this->iflychat_get_random_name());
		}
		else {
		    $_SESSION['iflychat_guest_name'] = $this->iflychat_check_plain($this->iflychat_settings['Iflychat_anon_prefix'] . time());
		}
		setrawcookie('iflychat_guest_name', rawurlencode($_SESSION['iflychat_guest_name']), time()+60*60*24*365);
	    }
	    return $_SESSION['iflychat_guest_name'];
	}

	/**
	*
	* @function iflychat_get_current_guest_id
	* generates the current guest id using some random string, if no cookie exist otherwise assigns the same previous id using cookies.
	* assigns a cookie for the generated id.
	* @return String generated guest id.
	*
	*/
	private function iflychat_get_current_guest_id() {
	    if(isset($_SESSION) && isset($_SESSION['iflychat_guest_id'])) {
		//if(!isset($_COOKIE) || !isset($_COOKIE['drupalchat_guest_id'])) {
		setrawcookie('iflychat_guest_id', rawurlencode($_SESSION['iflychat_guest_id']), time()+60*60*24*365);
		setrawcookie('iflychat_guest_session', rawurlencode($_SESSION['iflychat_guest_session']), time()+60*60*24*365);
		//}
	    }
	    else if(isset($_COOKIE) && isset($_COOKIE['iflychat_guest_id']) && isset($_COOKIE['iflychat_guest_session']) && ($_COOKIE['iflychat_guest_session']==$this->iflychat_compute_guest_session($_COOKIE['iflychat_guest_id']))) {
		$_SESSION['iflychat_guest_id'] = $this->iflychat_check_plain($_COOKIE['iflychat_guest_id']);
		$_SESSION['iflychat_guest_session'] = $this->iflychat_check_plain($_COOKIE['iflychat_guest_session']);
	    }
	    else {
		$characters = 'abcdefghijklmnopqrstuvwxyz0123456789';
		$iflychatId = time();
		for ($i = 0; $i < 5; $i++) {
		    $iflychatId .= $characters[rand(0, strlen($characters) - 1)];
		}
		$_SESSION['iflychat_guest_id'] = $iflychatId;
		$_SESSION['iflychat_guest_session'] = $this->iflychat_compute_guest_session($_SESSION['iflychat_guest_id']);
		setrawcookie('iflychat_guest_id', rawurlencode($_SESSION['iflychat_guest_id']), time()+60*60*24*365);
		setrawcookie('iflychat_guest_session', rawurlencode($_SESSION['iflychat_guest_session']), time()+60*60*24*365);
	    }
	    return $_SESSION['iflychat_guest_id'];
	}

	/**
	*
	* @function iflychat_get_user_id
	* returns the current user id if guest returns a random generated id
	* @return String current user id.
	*
	*/
	private function iflychat_get_user_id() {
	    if($this->iflychat_user_details['id']) {
		return strval($this->iflychat_user_details['id']);
	    }
	    else {
		    return "0-". $this->iflychat_get_current_guest_id();
	    }
	}

	/**
	*
	* @function iflychat_init
	* used to initialize iflychat controller.
	* @param String $url the url of the requesting page.
	* @return array of settings
	*
	*/
	private function iflychat_init($url) {
	    if($this->iflychat_path_check($url) && (($this->iflychat_settings['Iflychat_only_loggedin'] == "2") || $this->iflychat_user_details['id']!=0)) {
		$iflychat_theme = $this->iflychat_settings['Iflychat_theme']==1?'light':'dark';
		$iflychat_settings = array(
		    'current_timestamp' => time(),
		    'polling_method' => "3",
		    'pollUrl' => " ",
		    'sendUrl' => " ",
		    'statusUrl' => " ",
		    'status' => "1",
		    'goOnline' => __d('iflychat','Go Online'),
		    'goIdle' => __d('iflychat','Go Idle'),
		    'newMessage' => __d('iflychat','New chat message!'),
		    'images' => Router::url('/', true)  . 'iflychat/' . 'themes/'. $iflychat_theme.'/images/',
		    'sound' => Router::url('/', true)  . 'iflychat/swf/sound.swf',
		    'soundFile' => Router::url('/', true)  . 'iflychat/wav/notification.mp3',
		    'noUsers' => "<div class=\"item-list\"><ul><li class=\"drupalchatnousers even first last\">No users online</li></ul></div>",
		    'smileyURL' => Router::url('/', true)  . 'iflychat/' . 'smileys/very_emotional_emoticons-png/png-32x32/',
		    'addUrl' => " ",
		    'notificationSound' => $this->iflychat_settings['Iflychat_notification_sound'],
		    'basePath' => Router::url('/', true),
		    'useStopWordList' => $this->iflychat_settings['Iflychat_use_stop_word_list'],
		    'blockHL' => $this->iflychat_settings['Iflychat_stop_links'],
		    'allowAnonHL' => $this->iflychat_settings['Iflychat_allow_anon_links'],
		    'iup' => $this->iflychat_settings['Iflychat_user_picture'],
		    'open_chatlist_default' => ($this->iflychat_settings['Iflychat_minimize_chat_user_list']=='2')?'1':'2',
		    'admin' => $this->iflychat_check_chat_admin()?'1':'0',
		    'exurl' => Router::url('/',true).'iflychat/iflychat_settings/auth',
		    'mobileWebUrl' => Router::url('/', true)  . 'iflychat/iflychat_settings/mobileauth',
            'theme' => $iflychat_theme,

		);
		if($this->iflychat_user_details['is_admin']) {
            $iflychat_settings['arole'] = $this->iflychat_user_details['all_user_roles'];
		}
		if($this->iflychat_settings['Iflychat_user_picture'] == '1') {
		    $iflychat_settings['up'] = $this->iflychat_get_user_pic_url();
		    $iflychat_settings['default_up'] = 'http://www.gravatar.com/avatar/00000000000000000000000000000000?d=mm&size=24';
		    $iflychat_settings['default_cr'] = Router::url('/', true)  .'iflychat/'. 'themes/'.$iflychat_theme.'/images/default_room.png';
		    $iflychat_settings['default_team'] = Router::url('/', true)  . 'iflychat/'.'themes/'.$iflychat_theme.'/images/default_room.png';
		}

		if($iflychat_settings['polling_method'] == "3") {
		    if ($this->is_ssl()) {
			$iflychat_settings['external_host'] = IFLYCHAT_EXTERNAL_A_HOST;
			$iflychat_settings['external_port'] = IFLYCHAT_EXTERNAL_A_PORT;
			$iflychat_settings['external_a_host'] = IFLYCHAT_EXTERNAL_A_HOST;
			$iflychat_settings['external_a_port'] = IFLYCHAT_EXTERNAL_A_PORT;
		    }
		    else {
			$iflychat_settings['external_host'] = IFLYCHAT_EXTERNAL_HOST;
			$iflychat_settings['external_port'] = IFLYCHAT_EXTERNAL_PORT;
			$iflychat_settings['external_a_host'] = IFLYCHAT_EXTERNAL_HOST;
			$iflychat_settings['external_a_port'] = IFLYCHAT_EXTERNAL_PORT;
		    }
		}
		$iflychat_settings['text_currently_offline'] = __d('iflychat','iflychat_user is currently offline.');
		$iflychat_settings['text_is_typing'] = __d('iflychat','iflychat_user is typing...');
		$iflychat_settings['text_close'] = __d('iflychat','Close');
		$iflychat_settings['text_minimize'] = __d('iflychat','Minimize');
		$iflychat_settings['text_mute'] = __d('iflychat','Click to Mute');
		$iflychat_settings['text_unmute'] = __d('iflychat','Click to Unmute');
		$iflychat_settings['text_available'] = __d('iflychat','Available');
		$iflychat_settings['text_idle'] = __d('iflychat','Idle');
		$iflychat_settings['text_busy'] = __d('iflychat','Busy');
		$iflychat_settings['text_offline'] = __d('iflychat','Offline');
		$iflychat_settings['text_lmm'] = __d('iflychat','Load More Messages');
		$iflychat_settings['text_nmm'] = __d('iflychat','No More Messages');
		$iflychat_settings['text_clear_room'] = __d('iflychat','Clear all messages');
		$iflychat_settings['msg_p'] = __d('iflychat','Type and Press Enter');
		$iflychat_settings['text_search_bar'] = __d('iflychat','Type here to search');
		$iflychat_settings['searchBar'] = ($this->iflychat_settings['Iflychat_enable_search_bar'] == '1')?'1':'2';
		$iflychat_settings['renderImageInline'] = ($this->iflychat_settings['Iflychat_allow_render_images'] == '1')?'1':'2';
		if($this->iflychat_check_chat_admin()) {
		    $iflychat_settings['text_ban'] = __d('iflychat','Ban');
		    $iflychat_settings['text_ban_ip'] = __d('iflychat','Ban IP');
		    $iflychat_settings['text_kick'] = __d('iflychat','Kick');
		    $iflychat_settings['text_ban_window_title'] = __d('iflychat','Banned Users');
		    $iflychat_settings['text_ban_window_default'] = __d('iflychat','No users have been banned currently.');
		    $iflychat_settings['text_ban_window_loading'] = __d('iflychat','Loading banned user list...');
		    $iflychat_settings['text_manage_rooms'] = __d('iflychat','Manage Rooms');
		    $iflychat_settings['text_unban'] = __d('iflychat','Unban');
		    $iflychat_settings['text_unban_ip'] = __d('iflychat','Unban IP');
		}
		if($this->iflychat_settings['Iflychat_show_admin_list'] == '1') {
		    $iflychat_settings['text_support_chat_init_label'] = $this->iflychat_settings['Iflychat_support_chat_init_label'];
		    $iflychat_settings['text_support_chat_box_header'] = $this->iflychat_settings['Iflychat_support_chat_box_header'];
		    $iflychat_settings['text_support_chat_box_company_name'] = $this->iflychat_settings['Iflychat_support_chat_box_company_name'];
		    $iflychat_settings['text_support_chat_box_company_tagline'] = $this->iflychat_settings['Iflychat_support_chat_box_company_tagline'];
		    $iflychat_settings['text_support_chat_auto_greet_enable'] = $this->iflychat_settings['Iflychat_support_chat_auto_greet_enable'];
		    $iflychat_settings['text_support_chat_auto_greet_message'] = $this->iflychat_settings['Iflychat_support_chat_auto_greet_message'];
		    $iflychat_settings['text_support_chat_auto_greet_time'] = $this->iflychat_settings['Iflychat_support_chat_auto_greet_time'];
		    $iflychat_settings['text_support_chat_offline_message_label'] = $this->iflychat_settings['Iflychat_support_chat_offline_message_label'];
		    $iflychat_settings['text_support_chat_offline_message_contact'] = $this->iflychat_settings['Iflychat_support_chat_offline_message_contact'];
		    $iflychat_settings['text_support_chat_offline_message_send_button'] = $this->iflychat_settings['Iflychat_support_chat_offline_message_send_button'];
		    $iflychat_settings['text_support_chat_offline_message_desc'] = $this->iflychat_settings['Iflychat_support_chat_offline_message_desc'];
		    $iflychat_settings['text_support_chat_init_label_off'] = $this->iflychat_settings['Iflychat_support_chat_init_label_off'];
		}
		$_iflychat_protocol = isset($_SERVER["HTTPS"]) ? 'https://' : 'http://';
		$iflychat_settings['geturl'] = Router::url('/',true).'iflychat/iflychat_settings/auth';
		$iflychat_settings['soffurl'] = Router::url('/',true).'iflychat/iflychat_settings/auth';
		$iflychat_settings['mobileWebUrl'] = Router::url('/', true)  . 'iflychat/iflychat_settings/mobileauth';
		$iflychat_settings['chat_type'] = $this->iflychat_settings['Iflychat_show_admin_list'];
		return $iflychat_settings;

	    }
	}

	/**
	*
	* @function iflychat_get_user_profile_url
	* returns the profile link of the current user
	* @return String current user profile link.
	*
	*/
	private function iflychat_get_user_profile_url() {
	    if ($this->iflychat_user_details['id']) {
	        return $this->iflychat_user_details['upl'];
	    }
	    return 'javascript:void()';
	}

	/**
	*
	* @function iflychat_get_user_pic_url
	* returns the url to the user's pic.
	* @return String current user's pic url.
	*
	*/
	private function iflychat_get_user_pic_url() {
	    $url = '';
	    if ($this->iflychat_user_details['id']) {
		return $this->iflychat_user_details['avatar_url'];
	    }
	    if($this->iflychat_settings['Iflychat_theme'] == 1) {
		$iflychat_theme = 'light';
	    }
	    else {
		$iflychat_theme = 'dark';
	    }
	    $url = Router::url('/', true).'iflychat' . '/themes/' . $iflychat_theme . '/images/default_avatar.png';
	    $pos = strpos($url, ':');
	    if($pos !== false) {
		$url = substr($url, $pos+1);
	    }
	    return $url;
	}

	/**
	*
	* @function iflychat_get_auth returns the auth response from iflychat server
	* @return String $response_data the response data from the server with added user and id fields.
	*
	*/
	private function iflychat_get_auth() {

	    App::uses('HttpSocket', 'Network/Http');
	    $iflychat_uid = $this->iflychat_get_user_id();
	    $iflychat_uname = $this->iflychat_get_user_name();
	    $HttpSocket = new HttpSocket();
	    $data = array(
		'uid' => $iflychat_uid,
		'uname' => $iflychat_uname,
		'api_key' => $this->iflychat_settings['Iflychat_external_api_key'],
		'image_path' => Router::url('/', true)  . 'iflychat/' . 'themes/'.($this->iflychat_settings['Iflychat_theme'] == 1)?'light':'dark'.'/images',
		'isLog' => TRUE,
		'whichTheme' => 'blue',
		'enableStatus' => TRUE,
		'validState' => array('available','offline','busy','idle'),
		'up' => $this->iflychat_get_user_pic_url(),
		'upl' => $this->iflychat_get_user_profile_url()
	    );

        if($this->iflychat_user_details['is_admin']) {
            $data['role'] = "admin";
            $data['allRoles'] = $this->iflychat_user_details['all_user_roles'];
        }
        else {
            $data['role'] = array();
            foreach ($this->iflychat_user_details['user_roles'] as $rkey => $rvalue) {
                $data['role'][$rkey] = $rvalue;
            }
        }
        if($this->iflychat_user_details['relationship_set']) {
            $data['rel'] = '1';
            $data['valid_uids'] = $this->iflychat_user_details['relationship_set'];
        }
        else {
            $data['rel'] = '0';
        }

	    $response = $HttpSocket->post(IFLYCHAT_EXTERNAL_A_HOST . ':' . IFLYCHAT_EXTERNAL_A_PORT .  '/p/', $data);
	    $response_data=json_decode($response);
	    if ( $response && $response->isOk() ) {
		$response_data->name = $iflychat_uname;
		$response_data->uid = $iflychat_uid;
		if($this->iflychat_settings['Iflychat_user_picture'] == 1) {
		    $response_data->up = $this->iflychat_get_user_pic_url();
		}

		$response_data->upl = $this->iflychat_get_user_profile_url();
		Configure::write('debug', 0);
		$this->RequestHandler->respondAs('json');
		$this->autoRender = false;

		$this->IflychatSetting->save( array( 'key_setting' => 'Iflychat_ext_d_i', 'key_setting_value' => $response_data->_i ) );
	    }
	    else {
		$response_data->name = $iflychat_uname;
		$response_data->uid = $iflychat_uid;
	    }
	    return $response_data;
	}

	/** Public methods start */

	/**
	*
	* @constructor initialize various constants used
	*
	*/
	public function __construct(CakeRequest $request = null , CakeResponse $response = null) {
	    parent::__construct($request,$response);
	    $this->iflychat_populate_default();
	    if (!defined('IFLYCHAT_EXTERNAL_HOST')) {
		define('IFLYCHAT_EXTERNAL_HOST', 'http://api'.$this->iflychat_settings['Iflychat_ext_d_i'].'.iflychat.com');
		define('IFLYCHAT_EXTERNAL_PORT', '80');
		define('IFLYCHAT_EXTERNAL_A_HOST', 'https://api'.$this->iflychat_settings['Iflychat_ext_d_i'].'.iflychat.com');
		define('IFLYCHAT_EXTERNAL_A_PORT', '443');
	    }
	    $this->iflychat_default_user_details = array(
		'name' => NULL,
		'id' => 0,
		'avatar_url' => FALSE,
		'is_admin' => FALSE,
		'relationships_set' => FALSE,
		'upl' => FALSE,
	    );
	}

	/** Request action methods start */

	/**
	*
	* @function iflychat_get_html_code sends the html code for starting iflychat application to user.
	* @param String $url the url of the requesting page in order to block or show chat on a given page.
	* @return string the html code for rendering the views with iflychat throgh request action
	*
	*/
	public function iflychat_get_html_code($url) {
	    $user_details = (array)$this->get_user_details();
	    $this->iflychat_user_details = array_merge($this->iflychat_default_user_details, $user_details);
	    $iflychat_settings=$this->iflychat_init(urldecode($url));
	    $iflychat_settings = array_merge((array)$iflychat_settings,$this->iflychat_user_details);
	    $r   = '<script type="text/javascript">';
	    $r .=   'Drupal={};Drupal.settings={};Drupal.settings.drupalchat=' . json_encode($iflychat_settings)  . ';</script>';
	    $r .= '<script type="text/javascript" src="' . Router::url('/', true).'iflychat/js/iflychat.js"></script>';
	    $r  .= '<script>  window.my_var_handle ="' . Router::url('/', true).'iflychat/"</script>';
	    return $r;
	}

	/**   Page request methods start   */

	/**
	*
	* Default page on request
	* Handles post request on form submit
	* validates form fields
	* if true redirects to index view, save form fields and sends a post request to iflychat server with those fields
	* else render errors
	*
	*/
	public function index()
	{
	    if ( $this->request->is( 'post' ) ) {
		if ( $this->IflychatSetting->validates() ) {
		    $this->Session->setFlash(__d('iflychat',"Settings saved"));
		    foreach ( $this->request->data as $data ) {
			foreach ( $data as $key => $value ) {
			    $this->IflychatSetting->create();
			    $this->IflychatSetting->id = $key;
			    $this->IflychatSetting->save( array( 'key_setting' => $key, 'key_setting_value' => $value ) );
			}
		    }
		    $data = $this->request->data['Iflychat'];
		    $iflychat_settings_data = array(
			'api_key' => $data['Iflychat_external_api_key'],
			'enable_chatroom' => $data['Iflychat_enable_chatroom'],
			'theme' => ($data['Iflychat_theme'] == 1)?'light':'dark',
			'notify_sound' => $data['Iflychat_notification_sound'],
			'smileys' => $data['Iflychat_enable_smiley'],
			'log_chat' => $data['Iflychat_log_messages'],
			'chat_topbar_color' => $data['Iflychat_chat_topbar_color'],
			'chat_topbar_text_color' => $data['Iflychat_chat_topbar_text_color'],
			'font_color' => $data['Iflychat_font_color'],
			'chat_list_header' => $data['Iflychat_chat_list_header'],
			'public_chatroom_header' => $data['Iflychat_public_chatroom_header'],
			'rel' => ($this->iflychat_user_details['relationship_set'])?'1':'0',
			'version' => 'cakephp',
			'show_admin_list' => $data['Iflychat_show_admin_list'],
			'clear' => $data['Iflychat_allow_single_message_delete'],
			'delmessage' => $data['Iflychat_allow_clear_room_history'],
			'ufc' => $data['Iflychat_allow_user_font_color'],
			'guest_prefix' => ($data['Iflychat_anon_prefix'] . " "),
			'enable_guest_change_name' => $data['Iflychat_anon_change_name'],
			'use_stop_word_list' => $data['Iflychat_use_stop_word_list'],
			'stop_word_list' => $data['Iflychat_stop_word_list'],
            'file_attachment' => ($data['Iflychat_enable_file_attachment'] == "1")?'1':'2',
            'mobile_browser_app' => ($data['Iflychat_enable_mobile_browser_app'] == "1")?'1':'2'
		    );

		    App::uses('HttpSocket', 'Network/Http');
		    $HttpSocket = new HttpSocket();
		    $response = $HttpSocket->post(IFLYCHAT_EXTERNAL_A_HOST . ':' . IFLYCHAT_EXTERNAL_A_PORT .  '/z/', $iflychat_settings_data);
		    $this->redirect(array(
			'action' => 'index'
		    ));
		}
		else {
		    $this->Session->setFlash(__d('iflychat','Please correct errors before proceeding'));
		}
		$this->iflychat_populate_default();
	    }
	    foreach ($this->iflychat_settings as $key=>$value) {
		$this->request->data['Iflychat'][$key] = $value;
	    }
	    $user_details = (array)$this->get_user_details();
	    $this->set('user_details', $user_details);
	}

	/**
	*
	* Auth page
	* used for authorization with Iflychat servers.
	* displays the response in json format used for rendering iflychat
	*
	*/
	public function auth() {
	    $this->iflychat_user_details = array_merge($this->iflychat_default_user_details, (array)$this->get_user_details());
	    $json = (array)$this->iflychat_get_auth();
	    $json = array_merge($this->iflychat_user_details, $json);
        header('Content-type: application/json');
        print json_encode($json);
	}

	/**
	*
	* Mobile auth page
	* used for loading mobile version of the application.
	*
	*/

	public function mobileAuth() {
	    $data = array('settings' => array());
	    $data['settings']['authUrl'] = Router::url('/',true).'iflychat/iflychat_settings/auth';
	    if ($this->is_ssl()) {
		$data['settings']['host'] = IFLYCHAT_EXTERNAL_A_HOST;
		$data['settings']['port'] = IFLYCHAT_EXTERNAL_A_PORT;
	    }
	    else {
		$data['settings']['host'] = IFLYCHAT_EXTERNAL_HOST;
		$data['settings']['port'] = IFLYCHAT_EXTERNAL_PORT;
	    }
	    App::uses('HttpSocket', 'Network/Http');
	    $HttpSocket = new HttpSocket();
	    $response = $HttpSocket->post(IFLYCHAT_EXTERNAL_A_HOST . ':' . IFLYCHAT_EXTERNAL_A_PORT .  '/m/v1/app/', $data);
	    if ( !$response && $response->isOk() ) {
		$response = $response->code;
	    }
	    return $response;
	}
    }
?>