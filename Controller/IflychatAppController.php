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
//        'relationship_set'=>$this->setRelationshipSet()
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
        'relationship_set' => $this->setRelationshipSet()
	    );
	    return $user_details;
	}
        public function setRelationshipSet($relationship_set=FALSE) {
            if(isset($relationship_set)){
                //TODO
            return array();
            }
        }
    }

?>
