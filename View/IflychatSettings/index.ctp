<?php 
    $user_details = $this->get('user_details',array());
    if (!$user_details['is_admin']) {
	echo __d('Iflychat',"This page is only meant for admin. Please login as admin to see this page");
	exit;
    }
?>
<?php
    echo $this->Html->script('http://code.jquery.com/jquery.min.js');
?>

<?php
    echo $this->Html->script('/iflychat/js/iflychat_settings');
?>

<fieldset class="collapsible"><legend><h1><?php echo __d('iflychat',"iFlyChat General Settings"); ?> </h1></legend>
    <?php
	/**
	* Form display 
	* Iflychat_settings
	*
	*/
	$seconds = array(1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 6, 7=>7, 8 => 8, 9 => 9, 10 => 10, 11 => 11, 12 => 12, 13 => 13, 14 => 14, 15 => 15, 16 => 16, 17 => 17, 18 => 18, 19 => 19, 20 => 20, 30 => 30, 40 => 40, 50 => 50, 60 => 60, 70 => 70, 80 => 80, 90 => 90, 100 => 100, 110 => 110, 120 => 120, 150 => 150, 180 => 180, 240 => 240, 300 => 300);
	$options_form = array(
	    'id' => 'Iflychat_general_settings',
	);
	echo $this->Form->create('Iflychat',$options_form);
	echo $this->Form->input('Iflychat_external_api_key', array(
	    'id'=>'Iflychat_external_api_key',
	    'label'=>__d('iflychat','iFlyChat API Key'),
	    'type' => 'text',
	    'size'=>'20',
	    'maxlength'=>"128",
	    'required'=>false
	));
	echo $this->Form->input('Iflychat_show_admin_list', array(
	    'id' =>'Iflychat_show_admin_list',
	    'type' => 'select',
	    'label' => array('for'=>"Iflychat_show_admin_list",'text'=>__d('iflychat','Select which chat software to use')),
	    'options'=>array(2 => __d('iflychat','Community Chat'), 1 => __d('iflychat','Support Chat'),),
	),array('empty'=>false));
	echo $this->Form->input('Iflychat_only_loggedin', array(
	    'id' =>'Iflychat_only_loggedin',
	    'type' => 'select',
	    'label' => array('for'=>"Iflychat_only_loggedin",'text'=>__d('iflychat','Allow only logged-in users to access chat')),
	    'options'=>array(2 => __d('iflychat','no'), 1 => __d('iflychat','yes'),),
	),array('empty'=>false));
	echo $this->Form->input('Iflychat_theme', array(
	    'id' =>'Iflychat_theme',
	    'type' => 'select',
	    'label' => array('for'=>"Iflychat_theme",'text'=>__d('iflychat','Theme')),
	    'options'=>array(1=>__d('iflychat','light'),2=>__d('iflychat','dark')),
	),array('empty'=>false));
	echo $this->Form->input('Iflychat_notification_sound', array(
	    'id' =>'Iflychat_notification_sound',
	    'type' => 'select',
	    'label' => array('for'=>"Iflychat_notification_sound",'text'=>__d('iflychat','Notification Sound')),
	    'options'=>array(2=>__d('iflychat','yes'),1=>__d('iflychat','no')),
	),array('empty'=>false));
	echo $this->Form->input('Iflychat_enable_mobile_browser_app', array(
    	    'id' =>'Iflychat_enable_mobile_browser_app',
    	    'type' => 'select',
    	    'label' => array('for'=>"Iflychat_enable_mobile_browser_app",'text'=>__d('iflychat','Enable mobile browser app')),
    	    'options'=>array(2=>__d('iflychat','yes'),1=>__d('iflychat','no')),
    	),array('empty'=>false));
	echo $this->Form->input('Iflychat_user_picture', array(
	    'id' =>'Iflychat_user_picture',
	    'type' => 'select',
	    'label' => array('for'=>"Iflychat_user_picture",'text'=>__d('iflychat','User Pictures')),
	    'options'=>array(1=>__d('iflychat','yes'),2=>__d('iflychat','no')),
	),array('empty'=>false));
	echo $this->Form->input('Iflychat_enable_smiley', array(
	    'id' =>'Iflychat_enable_smiley',
	    'type' => 'select',
	    'label' => array('for'=>"Iflychat_enable_smiley",'text'=>__d('iflychat','Enable Smileys')),
	    'options'=>array(1=>__d('iflychat','yes'),2=>__d('iflychat','no')),
	),array('empty'=>false));
	echo $this->Form->input('Iflychat_log_messages', array(
	    'id' =>'Iflychat_log_messages',
	    'type' => 'select',
	    'label' => array('for'=>"Iflychat_log_messages",'text'=>__d('iflychat','Log chat messages')),
	    'options'=>array(1=>__d('iflychat','yes'),2=>__d('iflychat','no')),
	),array('empty'=>false));
	echo $this->Form->input('Iflychat_anon_prefix', array(
	    'id' =>'Iflychat_anon_prefix',
	    'type' => 'text',
	    'label' => array('for'=>"Iflychat_anon_prefix",'text'=>__d('iflychat','Prefix to be used with anonymous users')),
	),array('empty'=>false));
	echo $this->Form->input('Iflychat_anon_use_name', array(
	  'id' =>'Iflychat_anon_use_name',
	  'type' => 'select',
	  'label' => array('for'=>"Iflychat_anon_use_name",'text'=>__d('iflychat','Use random name or number for anonymous user')),
	  'options'=>array(1=>__d('iflychat','Name'),2=>__d('iflychat','Number')),
	),array('empty'=>false));
	echo $this->Form->input('Iflychat_anon_change_name', array(
	    'id' =>'Iflychat_anon_change_name',
	    'type' => 'select',
	    'label' => array('for'=>"Iflychat_anon_change_name",'text'=>__d('iflychat','Allow anonymous user to set his/her name')),
	    'options'=>array(1=>__d('iflychat','Yes'),2=>__d('iflychat','No')),
	),array('empty'=>false));
    ?>
</fieldset>

<fieldset class="collapsible"><legend><h1><?php echo __d('iflychat','Chat Moderation');?></h1></legend>
    <?php
	echo $this->Form->input('Iflychat_enable_chatroom', array(
	    'id' =>'Iflychat_enable_chatroom',
	    'legend'=>false,
	    'type' => 'radio',
	    'div'=>array('id'=>'radio_label'),
	    'options'=>array(1=>__d('iflychat','Yes'),2=>__d('iflychat','No')),
	),array('empty'=>false));
	echo $this->Form->input('Iflychat_stop_word_list', array(
	    'id' =>'Iflychat_stop_word_list',
	    'label' => array('for'=>"Iflychat_stop_word_list",'text'=>__d('iflychat','Stop Words (separated by comma)')),
	    'type' => 'textarea',
	),array('empty'=>false));
	echo '<br><br>';
	echo $this->Form->input('Iflychat_use_stop_word_list', array(
	    'id' =>'Iflychat_use_stop_word_list',
	    'type' => 'select',
	    'label' => array('for'=>"Iflychat_use_stop_word_list",'text'=>__d('iflychat','Use Stop Words to filter chat')),
	    'options'=>array('1' => __d('iflychat',"Do not filter"), '2' => __d('iflychat','Filter in public chatroom'), '3' => __d('iflychat','Filter in private chats'), '4' => __d('iflychat','Filter in all rooms')),
	),array('empty'=>false));
	echo '<br><br>';
	echo $this->Form->input('Iflychat_stop_links', array(
	    'id' =>'Iflychat_stop_links',
	    'type' => 'select',
	    'label' => array('for'=>"Iflychat_stop_links",'text'=>__d('iflychat','Allow/Block hyperlinks')),
	    'options'=>array('1' => __d('iflychat','Do not block'), '2' => __d('iflychat','Block in public chatroom'), '3' => __d('iflychat','Block in private chats'), '4' => __d('iflychat','Block in all rooms')),
	),array('empty'=>false));
	echo '<br><br>';
	echo $this->Form->input('Iflychat_allow_anon_links', array(
	    'id' =>'Iflychat_allow_anon_links',
	    'type' => 'select',
	    'label' => array('for'=>"Iflychat_allow_anon_links",'text'=>__d('iflychat','Apply above defined block hyperlinks settings only to anonymous users')),
	    'options'=>array('1' => __d('iflychat','Yes, apply only to anonymous users'), '2' => __d('iflychat','No, apply to all users'))
	    ),array('empty'=>false));
	echo '<br><br>';
	echo $this->Form->input('Iflychat_allow_render_images', array(
	    'id' =>'Iflychat_allow_render_images',
	    'type' => 'select',
	    'label' => array('for'=>"Iflychat_allow_render_images",'text'=>__d('iflychat','Render image and video hyperlinks inline')),
	    'options'=>array('1' => __d('iflychat','Yes'), '2' => __d('iflychat','No'),),
	),array('empty'=>false));
	echo '<br><br>';
	echo $this->Form->input('Iflychat_enable_file_attachment', array(
    	    'id' =>'Iflychat_enable_file_attachment',
    	    'type' => 'select',
    	    'label' => array('for'=>"Iflychat_enable_file_attachment",'text'=>__d('iflychat','Enable file attachment ')),
    	    'options'=>array('1' => __d('iflychat','Yes'), '2' => __d('iflychat','No'),),
    	),array('empty'=>false));
    	echo '<br><br>';
	echo $this->Form->input('Iflychat_allow_single_message_delete', array(
	    'id' =>'Iflychat_allow_single_message_delete',
	    'type' => 'select',
	    'label' => array('for'=>"Iflychat_allow_single_message_delete",'text'=>__d('iflychat','Allow users to delete messages selectively when in private conversation')),
	    'options'=>array('1' => __d('iflychat','Allow all users'), '2' => __d('iflychat','Allow only moderators'), '3' => __d('iflychat','Disable'),),
	),array('empty'=>false)); echo '<br><br>';
	echo $this->Form->input('Iflychat_allow_clear_room_history', array(
	    'id' =>'Iflychat_allow_clear_room_history',
	    'type' => 'select',
	    'label' => array('for'=>"Iflychat_allow_clear_room_history",'text'=>__d('iflychat','Allow users to clear all messages in a room')),
	    'options'=>array('1' => __d('iflychat','Allow all users'), '2' => __d('iflychat','Allow only moderators'), '3' => __d('iflychat','Disable'),),
	),array('empty'=>false)); echo '<br><br>';	
	echo $this->Form->input('Iflychat_allow_user_font_color', array(
	    'id' =>'Iflychat_allow_user_font_color',
	    'type' => 'select',
	    'label' => array('for'=>"Iflychat_allow_user_font_color",'text'=>__d('iflychat','Allow users to set color of their name in a room')),
	    'options'=>array(1=>__d('iflychat','Yes'),2=>__d('iflychat','No')),
	),array('empty'=>false));
    ?>
</fieldset>
	
<fieldset class="collapsible"><legend><h1><?php echo __d('iflychat',"iFlyChat Visibility");?></h1></legend>

<?php

echo $this->Form->input('Iflychat_path_visibility', array(
	'id' =>'Iflychat_path_visibility',
	'legend'=>false,
	'type' => 'radio',
	'div'=>array('id'=>'radio_label_2'),
	'options'=>array(1=>__d('iflychat','All pages except those listed'),2=>__d('iflychat','Only the listed pages')),
	),array('empty'=>false)); echo '<br><br>';


echo $this->Form->input('Iflychat_path_pages', array(
	'id' =>'Iflychat_path_pages',
	'legend'=>false,
	    'label' => array('for'=>"Iflychat_path_pages",'text'=>__d('iflychat','Pages')),

	'type' => 'textarea',
	),array('empty'=>false));

?>
</fieldset>
<fieldset class="collapsible"><legend><h1><?php echo __d('iflychat',"Theme Customization");?></h1></legend>
<?php
echo $this->Form->input('Iflychat_chat_topbar_color', array(
	'id' =>'Iflychat_chat_topbar_color',
	'type' => 'text',
    'label' => array('for'=>"Iflychat_chat_topbar_color",'text'=>__d('iflychat','Chat Top Bar Color')),

	),array('empty'=>false)); echo '<br><br>';
echo $this->Form->input('Iflychat_chat_topbar_text_color', array(
	'id' =>'Iflychat_chat_topbar_text_color',
	'type' => 'text',
    'label' => array('for'=>"Iflychat_chat_topbar_text_color",'text'=>__d('iflychat','Chat Top Bar Text Color')),

	),array('empty'=>false)); echo '<br><br>';
echo $this->Form->input('Iflychat_font_color', array(
	'id' =>'Iflychat_font_color',
	'type' => 'text',
    'label' => array('for'=>"Iflychat_font_color",'text'=>__d('iflychat','Chat Font Color')),

	),array('empty'=>false)); echo '<br><br>';
echo $this->Form->input('Iflychat_public_chatroom_header', array(
	'id' =>'Iflychat_public_chatroom_header',
	'type' => 'text',
    'label' => array('for'=>"Iflychat_public_chatroom_header",'text'=>__d('iflychat','Public Chatroom Header')),

	),array('empty'=>false)); echo '<br><br>';
echo $this->Form->input('Iflychat_chat_list_header', array(
	'id' =>'Iflychat_chat_list_header',
	'type' => 'text',
    'label' => array('for'=>"Iflychat_chat_list_header",'text'=>__d('iflychat','Chat List Header')),

	),array('empty'=>false));
?>
</fieldset>
<div id="support_chat">
<fieldset class="collapsible"><legend><h1><?php echo __d('iflychat',"Support Chat Customization");?></h1></legend>

<?php
echo $this->Form->input('Iflychat_support_chat_init_label', array(
	'id' =>'Iflychat_support_chat_init_label',
	'type' => 'text',
    'label' => array('for'=>"Iflychat_support_chat_init_label",'text'=>__d('iflychat','Support Chat - Start Button Label')),

	),array('empty'=>false)); echo '<br><br>';
	

echo $this->Form->input('Iflychat_support_chat_box_header', array(
	'id' =>'Iflychat_support_chat_box_header',
	'type' => 'text',
    'label' => array('for'=>"Iflychat_support_chat_box_header",'text'=>__d('iflychat','Support Chat Box Header')),

	),array('empty'=>false)); echo '<br><br>';
	

echo $this->Form->input('Iflychat_support_chat_box_company_name', array(
	'id' =>'Iflychat_support_chat_box_company_name',
	'type' => 'text',
    'label' => array('for'=>"Iflychat_support_chat_box_company_name",'text'=>__d('iflychat','Support Team/Company Name')),

	),array('empty'=>false)); echo '<br><br>';
	

echo $this->Form->input('Iflychat_support_chat_box_company_tagline', array(
	'id' =>'Iflychat_support_chat_box_company_tagline',
	'type' => 'text',
    'label' => array('for'=>"Iflychat_support_chat_box_company_tagline",'text'=>__d('iflychat','Support Tagline Label')),

	),array('empty'=>false)); echo '<br><br>';
	

echo $this->Form->input('Iflychat_support_chat_auto_greet_enable', array(
	'div'=>array('id'=>'radio_label_3'),
	'legend'=>false,
	'options'=>array(2=>__d('iflychat','Yes'),1=>__d('iflychat','No')),
	'type' => 'radio',
	),array('empty'=>false)); echo '<br><br>';
	

echo $this->Form->input('Iflychat_support_chat_auto_greet_message', array(
	'id' =>'Iflychat_support_chat_auto_greet_message',
	'type' => 'text',
    'label' => array('for'=>"Iflychat_support_chat_auto_greet_message",'text'=>__d('iflychat','Support Chat - Auto Greeting Message')),

	),array('empty'=>false)); echo '<br><br>';
	

echo $this->Form->input('Iflychat_support_chat_auto_greet_time', array(
	'id' =>'Iflychat_support_chat_auto_greet_time',
	'type' => 'select',
    'label' => array('for'=>"Iflychat_support_chat_auto_greet_time",'text'=>__d('iflychat','The delay, in seconds, after which the first time visitors will be shown auto greeting message.')),
    'options' => $seconds,
	),array('empty'=>false)); echo '<br><br>';
	

echo $this->Form->input('Iflychat_support_chat_init_label_off', array(
	'id' =>'Iflychat_support_chat_init_label_off',
	'type' => 'text',
    'label' => array('for'=>"Iflychat_support_chat_init_label_off",'text'=>__d('iflychat','Support Chat - Leave Message Button Label')),

	),array('empty'=>false)); echo '<br><br>';
	

echo $this->Form->input('Iflychat_support_chat_offline_message_desc', array(
	'id' =>'Iflychat_support_chat_offline_message_desc',
	'type' => 'text',
    'label' => array('for'=>"Iflychat_support_chat_offline_message_desc",'text'=>__d('iflychat','Support Chat - Off-line Message Description')),

	),array('empty'=>false)); echo '<br><br>';
	

echo $this->Form->input('Iflychat_support_chat_offline_message_label', array(
	'id' =>'Iflychat_support_chat_offline_message_label',
	'type' => 'text',
    'label' => array('for'=>"Iflychat_support_chat_offline_message_label",'text'=>__d('iflychat','Support Chat - Offline Message Label')),

	),array('empty'=>false)); echo '<br><br>';
	

echo $this->Form->input('Iflychat_support_chat_offline_message_contact', array(
	'id' =>'Iflychat_support_chat_offline_message_contact',
	'type' => 'text',
    'label' => array('for'=>"Iflychat_support_chat_offline_message_contact",'text'=>__d('iflychat','Support Chat - Offline Contact Details Label')),

	),array('empty'=>false)); echo '<br><br>';
	

echo $this->Form->input('Iflychat_support_chat_offline_message_send_button', array(
	'id' =>'Iflychat_support_chat_offline_message_send_button',
	'type' => 'text',
    'label' => array('for'=>"Iflychat_support_chat_offline_message_send_button",'text'=>__d('iflychat','Support Chat - Offline Send Button Label')),

	),array('empty'=>false)); echo '<br><br>';
	

echo $this->Form->input('Iflychat_support_chat_offline_message_email', array(
	'id' =>'Iflychat_support_chat_offline_message_email',
	'type' => 'text',
    'label' => array('for'=>"Iflychat_support_chat_offline_message_email",'text'=>__d('iflychat','Support Chat - Email(s) to which mail offline messages should be sent')),

	),array('empty'=>false)); 
	

?>
</fieldset></div>

<fieldset class="collapsible"><legend><h1><?php echo __d('iflychat',"iFlyChat User Online List Control"); ?></h1></legend>

<?php
echo $this->Form->input('Iflychat_minimize_chat_user_list', array(
	'id' =>'Iflychat_minimize_chat_user_list',
	'type' => 'select',
    'label' => array('for'=>"Iflychat_minimize_chat_user_list",'text'=>__d('iflychat','Minimize online user list by default.')),
    'options' => array(1 => __d('iflychat','Yes'), 2 => __d('iflychat','No')),
	),array('empty'=>false)); echo '<br><br>';
	
echo $this->Form->input('Iflychat_enable_search_bar', array(
	'id' =>'Iflychat_enable_search_bar',
	'type' => 'select',
    'label' => array('for'=>"Iflychat_enable_search_bar",'text'=>__d('iflychat','Show search bar in online user list.')),
    'options' => array(1 => __d('iflychat','Yes'), 2 => __d('iflychat','No')),
	),array('empty'=>false));echo '<br><br>';

/*echo $this->Form->input('Iflychat_rel', array(
	'div' =>array('id'=>'Iflychat_rel'),
	'type' => 'radio',
	'legend'=>false,
    'options' => array(1 => __d('iflychat','All users')),
	),array('empty'=>false));echo '<br><br>';

echo $this->Form->input('Iflychat_ur_name', array(
	'id' =>'Iflychat_ur_name',
	'type' => 'text',
	'label' => array('for'=>"Iflychat_ur_name",'text'=>__d('iflychat','User Relationships Role Names to integrate with.')),

	),array('empty'=>false));*/
?>
</fieldset>
<?php
echo $this->Form->input('Iflychat_ext_d_i',array( 'type'=>'hidden' ));
echo $this->Form->end('Submit',array('formnovalidate' => true));

?> 

<script type = 'text/javascript'>
function description(){
	$('#Iflychat_external_api_key').after('<h4>'+<?php echo __d('iflychat','\'Please enter the API key by registering at <a href="https://iflychat.com">iFlyChat.com.</a>\'')?>+'</h4>')
	$('#Iflychat_show_admin_list').after('<h4>'+<?php echo __d('iflychat','"Community chat is suitable for forums, blogs and social networking websites where you would like to users to be able to chat with each other both in rooms and one-to-one. Whereas Support chat is suitable for sites which need to attend to queries of their visitors. Please select which one to use. In Community chat, users with administer permission are considered as chat moderators/administrators. And, in Support chat, users with administer permission are considered as support staff."');?>+'</h4>');
	$('#Iflychat_only_loggedin').after('<h4>'+<?php echo __d('iflychat','"Chat will be displayed only when <em>user</em> is logged in."');?>+'</h4>');
	$('#Iflychat_theme').after('<h4>'+<?php echo __d('iflychat','"All themes from inside the <em>themes</em> folder will be displayed here."');?>+'</h4>');	
	$('#Iflychat_notification_sound').after('<h4>'+<?php echo __d('iflychat','"Select whether to play notification sound when a new message is received."');?>+'</h4>');
	$('#Iflychat_user_picture').after('<h4>'+<?php echo __d('iflychat','"Select whether to show user pictures in chat."');?>+'</h4>');
	$('#Iflychat_enable_smiley').after('<h4>'+<?php echo __d('iflychat','"Select whether to show smileys."');?>+'</h4>');
	$('#Iflychat_log_messages').after('<h4>'+<?php echo __d('iflychat','"Select whether to log chat messages, which can be later viewed in message inbox."');?>+'</h4>');
	$('#Iflychat_anon_prefix').after('<h4>'+<?php echo __d('iflychat',"\"Please specify the prefix to be used with anonymous users. It shouldn't be long. Ideally it should be between 4 to 7 characters.\"");?>+'</h4>');
	$('#Iflychat_anon_use_name').after("<h4>"+<?php echo __d('iflychat','"Select whether to use random generated name or number to assign to a new anonymous user."');?>+"</h4>");
	$('#Iflychat_anon_change_name').after("<h4>"+<?php echo __d('iflychat',"'Select whether to allow anonymous user to be able to change his/her name.'");?>+"</h4>");
	$('#radio_label').before("<h4>"+<?php echo __d('iflychat','"Enable Public Chatroom"');?>+"</h4>");
	$('#Iflychat_use_stop_word_list').after("<h4>"+<?php echo __d('iflychat',"'Select whether to use stop words(entered above) for filtering'");?>+"</h4>");
	$('#Iflychat_stop_links').after("<h4>"+<?php echo __d('iflychat','"Select whether to allow/block hyperlinks posted in chats"');?>+"</h4>");
	$('#Iflychat_allow_anon_links').after("<h4>"+<?php echo __d('iflychat','"Select whether to apply above defined block hyperlinks setting only to anonymous users."');?>+"</h4>");
	$('#Iflychat_allow_render_images').after("<h4>"+<?php echo __d('iflychat',"'Select whether to render image and video hyperlinks inline in chat.'");?>+"</h4>");
	$('#Iflychat_allow_single_message_delete').after("<h4>"+<?php echo __d('iflychat',"'Select whether to apply above defined block hyperlinks setting only to anonymous users.'");?>+"</h4>");
	$('#Iflychat_allow_clear_room_history').after("<h4>"+<?php echo __d('iflychat','"Select whether to allow users to clear all messages in a room."');?>+"</h4>");
	$('#Iflychat_allow_user_font_color').after("<h4>"+<?php echo __d('iflychat','"Select whether to allow users to set color of their name in a room."');?>+"</h4>");
	$('#radio_label_2').before("<h4>"+<?php echo __d('iflychat','"Show iFlyChat on specific pages"');?>+"</h4>");
	$('#Iflychat_path_pages').after("<h4>"+<?php echo __d('iflychat',"\"Specify pages by using their paths. Enter one path per line. The '*' character is a wildcard. Example paths are blog for the blog page and blog/* for every personal blog. < front > is the front page.\"");?>+"</h4>");
	$('#Iflychat_chat_topbar_color').after("<h4>"+<?php echo __d('iflychat',"'Choose the color of the top bar in the chat.'");?>+"</h4>");
	$('#Iflychat_chat_topbar_text_color').after("<h4>"+<?php echo __d('iflychat',"'Choose the color of the text in top bar in the chat.'");?>+"</h4>");
	$('#Iflychat_font_color').after("<h4>"+<?php echo __d('iflychat','"Choose the color of the text in the chat."');?>+"</h4>");
	$('#Iflychat_public_chatroom_header').after("<h4>"+<?php echo __d('iflychat',"'This is the text that will appear in header of public chatroom.'")?>+"</h4>");
	$('#Iflychat_chat_list_header').after("<h4>"+<?php echo __d('iflychat','"This is the text that will appear in header of chat list."');?>+"</h4>");
	$('#Iflychat_support_chat_init_label').after("<h4>"+<?php echo __d('iflychat','"The label for <i>Start Chat</i> button, which when clicked upon will launch chat."');?>+"</h4>");
	$('#Iflychat_support_chat_box_company_name').after("<h4>"+<?php echo __d('iflychat','"This is the text that will appear as header of chat box."');?>+"</h4>");
	$('#Iflychat_support_chat_box_company_tagline').after("<h4>"+<?php echo __d('iflychat',"'Your team/company tagline.'");?>+"</h4>");
	//$('#radio_label_3').before("<h4>Support Chat - Enable Auto Greeting Message</h4>");
	$('#Iflychat_support_chat_auto_greet_message').after("<h4>"+<?php echo __d('iflychat','"This is the text of an auto greeting message which will be displayed to visitors."');?>+"</h4>");
	$('#Iflychat_support_chat_auto_greet_time').after("<h4>"+<?php echo __d('iflychat',"'The delay, in seconds, after which the first time visitors will be shown auto greeting message.'");?>+"</h4>");
	$('#Iflychat_support_chat_init_label_off').after("<h4>"+<?php echo __d('iflychat','"The label for <i>Leave Message</i> button, which when clicked upon will offline form."');?>+"</h4>");
	$('#Iflychat_support_chat_offline_message_desc').after("<h4>"+<?php echo __d('iflychat','"This is the description shown in Support Chat Offline window."');?>+"</h4>");
	$('#Iflychat_support_chat_offline_message_label').after("<h4>"+<?php echo __d('iflychat','"This is the label for the <i>Message</i> textarea in Support Chat Offline window."');?>+"</h4>");
	$('#Iflychat_support_chat_offline_message_contact').after("<h4>"+<?php echo __d('iflychat','"This is the label for the <i>Contact Details</i> textarea in Support Chat Offline window."');?>+"</h4>");
	$('#Iflychat_support_chat_offline_message_send_button').after("<h4>"+<?php echo __d('iflychat','"This is the label for the <i>Send Button</i> textarea in Support Chat Offline window."');?>+"</h4>");
	$('#Iflychat_support_chat_offline_message_email').after("<h4>"+<?php echo __d('iflychat','"Enter all email ids (separated by comma) to which notification should be sent when a user leaves a message via Offline Form."');?>+"</h4>");
	$('#Iflychat_minimize_chat_user_list').after("<h4>"+<?php echo __d('iflychat',"'Select whether to minimize online user list in chat by default.'");?>+"</h4>");
	$('#Iflychat_enable_search_bar').after("<h4>"+<?php echo __d('iflychat','"Select whether to show search bar in online user list."');?>+"</h4>");
	//Iflychat_rel').before("Relationship method.");
 	$('#Iflychat_rel').after("<h4>"+<?php echo __d('iflychat','"This determines the method for creating the chat buddylist."');?>+"</h4>");
 	$('#Iflychat_ur_name').after("<h4>"+<?php echo __d('iflychat','"The singular form of User Relationships Role Names (e.g. buddy, friend, coworker, spouse) separated by comma."');?>+"</h4>");
 	$('#Iflychat_enable_file_attachment').after("<h4>"+<?php echo __d('iflychat','"Select whether to allow user to share/upload file in chat."');?>+"</h4>");
 	$('#Iflychat_enable_mobile_browser_app').after("<h4>"+<?php echo __d('iflychat','"Select whether to enable browser based mobile app."');?>+"</h4>");


    }
    $(document).ready(function(){ 
	description();
    });
</script>