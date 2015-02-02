<?php
    /**
    *
    * @author=>iFlyChatDev Team
    * App Controller for the plugin.
    *
    */
    class IflychatAppController extends AppController {
	private $user_details;
        /**
	*
	* @function get_user_details
	* used internally by the module for getting the user details of the current logged-in user
	* @return array $user_details user details array as depicted.
	* 
	*/
	public function get_user_details() {
	    /**
	    *
	    * sample user detail array for currently logged in user
	    * data can be retreived from database or session
	    *
	    */
//	    $user_details = array(
//		'name' => 'admin',
//		'id' => '1',
//		'is_admin' => TRUE,
//		'avatar_url' => '/path/to/my_picture.jpg',
//		'upl' => 'link_to_profile_of_current_user.php',
//      'relationship_set'=>(boolean)$this->setRelationshipSet(),
//      'user_roles'=>$this->(array)setUserRoles(array('1'=>'manager')),            //represents role of current user
//      'all_user_roles'=>$this->(array)setAllUserRoles(array('12'=>'editor', '13'=>'super', '14'=>'etc'))   // represents all the roles exist
//	    );
	    /**
	    *
	    * Pass empty array if the user is not logged-in/unregistered/guest (anonymous user)
	    *
	    */
	    $user_details = array(
		'name' => '',
		'id' => 0,
		'is_admin' => FALSE,
		'avatar_url' => '',
		'upl' => '',
        'relationship_set' =>(boolean)$this->setRelationshipSet(),
        'user_roles'=>(array)$this->setUserRoles(),
        'all_user_roles'=>(array)$this->setAllUserRoles()
	    );
	    return $user_details;
	}
    public function setRelationshipSet($relationship_set=FALSE) {
        return $relationship_set;
    }
    public function setUserRoles($user_roles=array()) {
        return $user_roles;
    }
    public function setAllUserRoles($all_user_roles=array()){
        return $all_user_roles;
    }
    }

?>
