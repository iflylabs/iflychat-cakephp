<?php 
class IflychatSchema extends CakeSchema {

	public function before($event = array()) {
		return true;
	}

	public function after($event = array()) {
	    if (isset($event['create'])) {
		switch ($event['create']) {
		    case 'iflychat_settings':
			App::uses('ClassRegistry', 'Utility');
			$iflychat_setting = ClassRegistry::init('IflychatSetting');
			$data = array (
			    'Iflychat_external_api_key' => '',
			    'Iflychat_show_admin_list' => '2',
			    'Iflychat_only_loggedin' => '2',
			    'Iflychat_theme' => '1',
			    'Iflychat_notification_sound' => '1',
			    'Iflychat_user_picture' => '1',
			    'Iflychat_enable_smiley' => '1',
			    'Iflychat_log_messages' => '1',
			    'Iflychat_anon_prefix' => 'Guest',
			    'Iflychat_anon_use_name' => '1',
			    'Iflychat_anon_change_name' => '1',
			    'Iflychat_load_chat_async' => '1',
			    'Iflychat_enable_chatroom' => '1',
			    'Iflychat_stop_word_list' => "asshole,assholes,bastard,beastial,beastiality,beastility,bestial,bestiality,bitch,bitcher,bitchers,bitches,bitchin,bitching,blowjob,blowjobs,bullshit,clit,cock,cocks,cocksuck,cocksucked,cocksucker,cocksucking,cocksucks,cum,cummer,cumming,cums,cumshot,cunillingus,cunnilingus,cunt,cuntlick,cuntlicker,cuntlicking,cunts,cyberfuc,cyberfuck,cyberfucked,cyberfucker,cyberfuckers,cyberfucking,damn,dildo,dildos,dick,dink,dinks,ejaculate,ejaculated,ejaculates,ejaculating,ejaculatings,ejaculation,fag,fagging,faggot,faggs,fagot,fagots,fags,fart,farted,farting,fartings,farts,farty,felatio,fellatio,fingerfuck,fingerfucked,fingerfucker,fingerfuckers,fingerfucking,fingerfucks,fistfuck,fistfucked,fistfucker,fistfuckers,fistfucking,fistfuckings,fistfucks,fuck,fucked,fucker,fuckers,fuckin,fucking,fuckings,fuckme,fucks,fuk,fuks,gangbang,gangbanged,gangbangs,gaysex,goddamn,hardcoresex,horniest,horny,hotsex,jism,jiz,jizm,kock,kondum,kondums,kum,kumer,kummer,kumming,kums,kunilingus,lust,lusting,mothafuck,mothafucka,mothafuckas,mothafuckaz,mothafucked,mothafucker,mothafuckers,mothafuckin,mothafucking,mothafuckings,mothafucks,motherfuck,motherfucked,motherfucker,motherfuckers,motherfuckin,motherfucking,motherfuckings,motherfucks,niger,nigger,niggers,orgasim,orgasims,orgasm,orgasms,phonesex,phuk,phuked,phuking,phukked,phukking,phuks,phuq,pis,piss,pisser,pissed,pisser,pissers,pises,pisses,pisin,pissin,pising,pissing,pisof,pissoff,porn,porno,pornography,pornos,prick,pricks,pussies,pusies,pussy,pusy,pussys,pusys,slut,sluts,smut,spunk",
			    'Iflychat_use_stop_word_list' => '1',
			    'Iflychat_stop_links' => '1',
			    'Iflychat_allow_anon_links' => '1',
			    'Iflychat_allow_render_images' => '1',
			    'Iflychat_allow_single_message_delete' => '1',
			    'Iflychat_allow_clear_room_history' => '1',
			    'Iflychat_allow_user_font_color' => "1",
			    'Iflychat_path_visibility' => "1",
			    'Iflychat_path_pages' => "",
			    'Iflychat_chat_topbar_color' => "#222222",
			    'Iflychat_chat_topbar_text_color' => "#FFFFFF",
			    'Iflychat_font_color' => "#222222",
			    'Iflychat_public_chatroom_header' => "Public Chatroom",
			    'Iflychat_chat_list_header' => "Public Chat",
			    'Iflychat_minimize_chat_user_list' => "2",
			    'Iflychat_enable_search_bar' => "1",
			    'Iflychat_ur_name' => "",
			    'Iflychat_support_chat_init_label' => "Chat with us",
			    'Iflychat_support_chat_box_header' => "Support",
			    'Iflychat_support_chat_box_company_name' => "Support Team",
			    'Iflychat_support_chat_box_company_tagline' => "Ask Us Anything....",
			    'Iflychat_support_chat_auto_greet_enable' => "1",
			    'Iflychat_support_chat_auto_greet_message' => "Hi there! Welcome to our website. Let us know if you have any query!",
			    'Iflychat_support_chat_auto_greet_time' => "1",
			    'Iflychat_support_chat_init_label_off' => "Leave Message",
			    'Iflychat_support_chat_offline_message_desc' => "Hello there. We are currently offline. Please leave us a message. Thanks.",
			    'Iflychat_support_chat_offline_message_label' => "Message",
			    'Iflychat_support_chat_offline_message_contact' => "Contact Details",
			    'Iflychat_support_chat_offline_message_send_button' => "Send Message",
			    'Iflychat_support_chat_offline_message_email' => "saheb.preet.singh@iflylabs.com",
			    'Iflychat_rel' => '1',
			    'Iflychat_ext_d_i' => '',
                'Iflychat_enable_file_attachment' =>'1',
                'Iflychat_enable_mobile_browser_app' => '2'
			);
			foreach($data as $key=>$value) {
			    $iflychat_setting->create();
			    $iflychat_setting->save(
				array('IflychatSetting'=>array(
				    'key_setting' =>$key,
				    'key_setting_value'=>$value
				))
			    );
			}
		}
	    }
	}

	public $iflychat_settings = array(
		'key_setting' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 64, 'key' => 'primary', 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'key_setting_value' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'key_setting', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);

}
