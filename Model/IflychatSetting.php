<?php
    /**
    *
    * @author => iflychat-rohit
    * Model for the iflychat settings.
    * Handles data Population in iflychat_settings table
    *
    */

    if(!class_exists('IflychatAppModel')) {
	include_once('IflychatAppModel.php');
    }

    class IflychatSetting extends IflychatAppModel{
	public $name = 'IflychatSetting';
	public $primaryKey = 'key_setting';
	public $validate = array(
	    'Iflychat_external_api_key' => array(
		'rule' => 'numeric',
		'message' => 'API key error'
	    ),
	    'Iflychat_anon_prefix' => array(
		'rule' => 'notEmpty',
		'message' => 'Prefix is required!'
	    ),
	    'Iflychat_show_admin_list' => array(
		'rule' => 'notEmpty',
		'message' => 'admin list is required!'
	    ),
	    'Iflychat_theme' => array(
		'rule' => 'notEmpty',
		'message' => 'Theme is required!'
	    ),
	    'Iflychat_notification_sound' => array(
		'rule' => 'notEmpty',
		'message' => 'sound is required!'
	    ),
        'Iflychat_enable_mobile_browser_app' => array(
            'rule' => 'notEmpty',
            'message' => 'Field cannot be empty!'
        ),

	    'Iflychat_user_picture' => array(
		'rule' => 'notEmpty',
		'message' => 'Field cannot be empty!'
	    ),
	    'Iflychat_anon_use_name' => array(
		'rule' => 'notEmpty',
		'message' => 'Field cannot be empty!'
	    ),
	    'Iflychat_enable_smiley' => array(
		'rule' => 'notEmpty',
		'message' => 'Field cannot be empty!'
	    ),
	    'Iflychat_log_messages' => array(
		'rule' => 'notEmpty',
		'message' => 'Field cannot be empty!'
	    ),
	    'Iflychat_anon_change_name' => array(
		'rule' => 'notEmpty',
		'message' => 'Field cannot be empty!'
	    ),
	    'Iflychat_load_chat_async' => array(
		'rule' => 'notEmpty',
		'message' => 'Field cannot be empty!'
	    ),
	    'Iflychat_enable_chatroom' => array(
		'rule' => 'notEmpty',
		'message' => 'Field cannot be empty!'
	    ),
	    'Iflychat_use_stop_word_list' => array(
		'rule' => 'notEmpty',
		'message' => 'Field cannot be empty!'
	    ),
	    'Iflychat_stop_links' => array(
		'rule' => 'notEmpty',
		'message' => 'Field cannot be empty!'
	    ),
	    'Iflychat_allow_anon_links' => array(
		'rule' => 'notEmpty',
		'message' => 'Field cannot be empty!'
	    ),
	    'Iflychat_allow_render_images' => array(
		'rule' => 'notEmpty',
		'message' => 'Field cannot be empty!'
	    ),
        'Iflychat_enable_file_attachment' => array(
            'rule' => 'notEmpty',
            'message' => 'Field cannot be empty!'
        ),
	    'Iflychat_allow_single_message_delete' => array(
		'rule' => 'notEmpty',
		'message' => 'Field cannot be empty!'
	    ),
	    'Iflychat_allow_clear_room_history' => array(
		'rule' => 'notEmpty',
		'message' => 'Field cannot be empty!'
	    ),
	    'Iflychat_allow_user_font_color' => array(
		'rule' => 'notEmpty',
		'message' => 'Field cannot be empty!'
	    ),
	    'Iflychat_path_visibility' => array(
		'rule' => 'notEmpty',
		'message' => 'Field cannot be empty!'
	    ),
	    'Iflychat_path_pages' => array(
		'rule' => 'notEmpty',
		'message' => 'Field cannot be empty!'
	    ),
	    'Iflychat_chat_topbar_color' => array(
		'rule' => 'notEmpty',
		'message' => 'Field cannot be empty!'
	    ),
	    'Iflychat_chat_topbar_text_color' => array(
		'rule' => 'notEmpty',
		'message' => 'Field cannot be empty!'
	    ),
	    'Iflychat_font_color' => array(
		'rule' => 'notEmpty',
		'message' => 'Field cannot be empty!'
	    ),
	    'Iflychat_public_chatroom_header' => array(
		'rule' => 'notEmpty',
		'message' => 'Field cannot be empty!'
	    ),
	    'Iflychat_chat_list_header' => array(
		'rule' => 'notEmpty',
		'message' => 'Field cannot be empty!'
	    ),
	    'Iflychat_minimize_chat_user_list' => array(
		'rule' => 'notEmpty',
		'message' => 'Field cannot be empty!'
	    ),
	    'Iflychat_enable_search_bar' => array(
		'rule' => 'notEmpty',
		'message' => 'Field cannot be empty!'
	    ),
	    'Iflychat_rel' => array(
		'rule' => 'notEmpty',
		'message' => 'Field cannot be empty!'
	    ),
	    'Iflychat_ur_name' => array(
		'rule' => 'notEmpty',
		'message' => 'Field cannot be empty!'
	    ),
	    'Iflychat_support_chat_init_label' => array(
		'rule' => 'notEmpty',
		'message' => 'Field cannot be empty!'
	    ),
	    'Iflychat_support_chat_box_header' => array(
		'rule' => 'notEmpty',
		'message' => 'Field cannot be empty!'
	    ),
	    'Iflychat_support_chat_box_company_name' => array(
		'rule' => 'notEmpty',
		'message' => 'Field cannot be empty!'
	    ),
	    'Iflychat_support_chat_box_company_tagline' => array(
		'rule' => 'notEmpty',
		'message' => 'Field cannot be empty!'
	    ),
	    'Iflychat_support_chat_auto_greet_enable' => array(
		'rule' => 'notEmpty',
		'message' => 'Field cannot be empty!'
	    ),
	    'Iflychat_support_chat_init_label_off' => array(
		'rule' => 'notEmpty',
		'message' => 'Field cannot be empty!'
	    ),
	    'Iflychat_support_chat_offline_message_desc' => array(
		'rule' => 'notEmpty',
		'message' => 'Field cannot be empty!'
	    ),
	    'Iflychat_support_chat_offline_message_label' => array(
		'rule' => 'notEmpty',
		'message' => 'Field cannot be empty!'
	    ),
	    'Iflychat_support_chat_offline_message_contact' => array(
		'rule' => 'notEmpty',
		'message' => 'Field cannot be empty!'
	    ),
	    'Iflychat_support_chat_offline_message_send_button' => array(
		'rule' => 'notEmpty',
		'message' => 'Field cannot be empty!'
	    ),
	    'Iflychat_support_chat_offline_message_email' => array(
		'rule' => 'notEmpty',
		'message' => 'Field cannot be empty!'
	    )
	);
    }
?>