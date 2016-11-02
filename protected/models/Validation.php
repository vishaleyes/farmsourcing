<?php
/**
 * Copyright (c) 2011 All Right Reserved, Todooli, Inc.
 *
 * This source is subject to the Todooli Permissive License. Any Modification
 * must not alter or remove any copyright notices in the Software or Package,
 * generated or otherwise. All derivative work as well as any Distribution of
 * this asis or in Modified
form or derivative requires express written consent
 * from Todooli, Inc.
 *
 *
 * THIS CODE AND INFORMATION ARE PROVIDED "AS IS" WITHOUT WARRANTY OF ANY
 * KIND, EITHER EXPRESSED OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE
 * IMPLIED WARRANTIES OF MERCHANTABILITY AND/OR FITNESS FOR A
 * PARTICULAR PURPOSE.
 *
 *
**/ 
class Validation extends CFormModel 
{
	/*
	Validation for Seeker Sign Up Form
	PARAM : Array of Post Data
	*/
	public $msg;
	public $errorCode;
	
	public function __construct()
	{
		$this->msg = Yii::app()->params->msg;
		$this->errorCode = Yii::app()->params->errorCode;
	}
	
	function checkDateTime($data) {
		if (date('Y-m-d', strtotime($data)) == $data && date('Y-m-d', strtotime($data)) >= date('Y-m-d') ) {
			return true;
		} else {
			return false;
		}
	}	
	/*
	DESCRIPTION : VALIDATION FOR SIGN UP USER
	*/
	function addTodoItems($POST)
	{
		$_POST = $POST;
		$validator	=	new FormValidator();
		$validator->addValidation("title","req",'_TODOTITLE_VALIDATE_');
		$validator->addValidation("duedate","req",'_DUEDATE_EMPTY_');
		if( isset($_POST['duedate']) && !$this->checkDateTime($_POST['duedate']) ) {
			$validator->addValidation("duedateError","req",'_DUEDATE_NOT_VALID_FORMATE_');
		}
		$validator->addValidation("priority","req",'_PRIORITY_EMPTY_');
		if(isset($postData['assignerType']) && $postData['assignerType']!='self')
		{
			$validator->addValidation("userlist","req",'_EMAIL_EMPTY_');
			$validator->addValidation("userlist","email",'_EMAIL_NOT_VALID_');
		}
		if( isset($_POST['title']) && $_POST['title'] != '' ) {
			$validator->addValidation("title","todoTitle",'_TODOITEM_TITLE_VALIDATE_SPECIAL_CHAR_');
		}
		if( isset($_POST['description']) && $_POST['description'] != '' ) {
			$validator->addValidation("description","todoTitle",'_TODOITEM_DESCRIPTION_VALIDATE_SPECIAL_CHAR_');
		}
		if(!$validator->ValidateForm())
		{
			
			$error_hash = $validator->GetError();
			$status = array('status'=>$this->errorCode[$error_hash],'message'=>$this->msg[$error_hash]);
			return $status;
		}
		else
		{
			return array('status'=>0,'message'=>'success');
		}
	}
	
	function addItemComments($POST)
	{
		$_POST = $POST;
		$validator	=	new FormValidator();
		$validator->addValidation("itemId","req",'_PLEASE_FILL_ALL_FIELDS_');
		$validator->addValidation("listId","req",'_PLEASE_FILL_ALL_FIELDS_');
		$validator->addValidation("userId","req",'_PLEASE_FILL_ALL_FIELDS_');
		$validator->addValidation("comments","req",'_PLEASE_ADD_COMMENTS_');
		if(!$validator->ValidateForm())
		{
			$error_hash = $validator->GetError();
			$status = array('status'=>$this->errorCode[$error_hash],'message'=>$this->msg[$error_hash]);
			return $status;
		}
		else
		{
			return array('status'=>0,'message'=>'success');
		}
	}
	
	function addReminder($POST)
	{
		$_POST = $POST;
		$validator	=	new FormValidator();
		if( !isset($_POST['todoList']) || empty($_POST['todoList']) ) {
			$validator->addValidation("todoList","req",'_PLEASE_SELECT_ATLEAST_REMINDER_');
		}
		if( isset($_POST['reminderName']) ) {
			$validator->addValidation("reminderName","fullname",'_NO_SPECIAL_CHARACTER_REMINDER_NAME_');
		}
		
		$validator->addValidation("status","req",'_PLEASE_FILL_ALL_FIELDS_');
		$validator->addValidation("dueDate","req",'_PLEASE_FILL_ALL_FIELDS_');
		$validator->addValidation("duration","req",'_PLEASE_FILL_ALL_FIELDS_');
		$validator->addValidation("time","req",'_PLEASE_FILL_ALL_FIELDS_');
		$validator->addValidation("ampm","req",'_PLEASE_FILL_ALL_FIELDS_');
		if(!$validator->ValidateForm())
		{
			$error_hash = $validator->GetError();
			$status = array('status'=>$this->errorCode[$error_hash],'message'=>$this->msg[$error_hash]);
			return $status;
		}
		else
		{
			return array('status'=>0,'message'=>'success');
		}
	}
	
	function assignBack($POST)
	{
		$_POST = $POST;
		$validator	=	new FormValidator();
		$validator->addValidation("id","req",'_PLEASE_FILL_ALL_FIELDS_');
		$validator->addValidation("comments","req",'_PLEASE_ADD_COMMENTS_');
		
		if(!$validator->ValidateForm())
		{
			$error_hash = $validator->GetError();
			$status = array('status'=>$this->errorCode[$error_hash],'message'=>$this->msg[$error_hash]);
			return $status;
		}
		else
		{
			return array('status'=>0,'message'=>'success');
		}
	}
	
	function signup($POST,$isBulkUpload=0)
	{
		$_POST = $POST;
		$validator	=	new FormValidator();
		$userObj	=	new Users();
		$loginObj	=	new Login();
		$generalObj	=	new General();
		if(isset($_POST['phoneNumber']) && is_numeric($_POST['phoneNumber']) && trim($_POST['phoneNumber'])!=trim($this->msg['_PHONE_NUMBER_']) && trim($_POST['phoneNumber'])!='')
		{
			$_POST['phoneNumber']=$generalObj->clearPhone($_POST['phoneNumber']);
		}
		
		$validator->addValidation("fName","req",'_FNAME_VALIDATE_ACCOUNTMANAGER_');
		$validator->addValidation("fName","name",'_FNAME_VALIDATE_SPECIAL_CHAR_');
		$validator->addValidation("fName","maxlen=50",'_FNAME_VALIDATE_LENGTH_');
		$validator->addValidation("lName","req",'_LNAME_VALIDATE_ACCOUNTMANAGER_');
		$validator->addValidation("lName","name",'_LNAME_VALIDATE_SPECIAL_CHAR_');
		$validator->addValidation("lName","maxlen=50",'_LNAME_VALIDATE_LENGTH_');
		$validator->addValidation("password","req",'_PASSWORD_VALIDATE_ACCOUNTMANAGER_');
		$validator->addValidation("password","maxlen=50",'_PASSWORD_VALIDATE_LENGTH_');
		$validator->addValidation("cpassword","req",'_PASSWORD_CVALIDATE_ACCOUNTMANAGER_');
		$validator->addValidation("cpassword","maxlen=50",'_PASSWORD_VALIDATE_LENGTH_');
		$validator->addValidation("password","minlen=6",'_PASSWORD_LENGTH_VALIDATE_ACCOUNTMANAGER_');
		$validator->addValidation("cpassword","minlen=6",'_PASSWORD_LENGTH_VALIDATE_ACCOUNTMANAGER_');
		$validator->addValidation("timezone","req",'_INVALID_TIMEZONE_');
		
		if(!isset($_POST['email']) || !isset($_POST['phoneNumber']))
		{
			if(isset($_POST['email']))
			{			
				$validator->addValidation("email","req",'_EMAIL_VALIDATE_ACCOUNT_MANAGER_');
			}
			if(isset($_POST['phoneNumber']))
			{
				$validator->addValidation("phoneNumber","req",'_EMAIL_VALIDATE_ACCOUNT_MANAGER_');
			}
			if(!isset($_POST['email']) && !isset($_POST['phoneNumber']))
			{						
				$validator->addValidation("email","req",'_EMAIL_VALIDATE_ACCOUNT_MANAGER_');			
			}
		}
		if(isset($_POST['email']) && isset($_POST['phoneNumber']))
		{
			if($_POST['phoneNumber']=='' && $_POST['email']=='')
			{
				$validator->addValidation("email","req",'_EMAIL_VALIDATE_ACCOUNT_MANAGER_');
			}
		}
		if(isset($_POST['email']) && $_POST['email']!='' && trim($_POST['email'])!=$this->msg['_EMAIL_'])
		{
			$validator->addValidation("email","email",'_EMAIL_VALIDATE_ACCOUNTMANAGER_');
			$result = $loginObj->checkOtherEmail($_POST['email'],'',1);
				
			if(!empty($result)){
				$validator->addValidation("email_unique","req",'_EMAIL_ALREADY_AVAILABLE_');
			}
		}	 
		
		if(isset($_POST['phoneNumber']) && $_POST['phoneNumber']!='')
		{
			$validator->addValidation("phoneNumber","usphone",'_PHONE_VALIDATE_NOT_VALID_ACCOUNTMANAGER_');
		}
		
		if(isset($_POST['password']) && isset($_POST['cpassword']))
		{
			if(trim($_POST['password'])!=trim($_POST['cpassword']))
			{
				$validator->addValidation("matchpassword","req",'_PASSWORD_METCH_VALIDATE_ACCOUNTMANAGER_');
			}	
		}
		else
		{
			$validator->addValidation("matchpassword","req",'_PASSWORD_METCH_VALIDATE_ACCOUNTMANAGER_');
		}
		
		if(!$validator->ValidateForm())
		{
			$error_hash = $validator->GetError();
			if($this->errorCode[$error_hash] == 164)
			{
				$status = array('status'=>$this->errorCode[$error_hash],'message'=>$this->msg[$error_hash],'alternate_address'=>$coord['alternate_address']);
			}
			else
			{
				$status = array('status'=>$this->errorCode[$error_hash],'message'=>$this->msg[$error_hash]);
			}			
			return $status;
		}
		else
		{
			return array('status'=>0,'message'=>'success');
		}
		
	}
	
	/*
	For Contact us form validation in both side
	PARAM : Array of Post Data
	*/
	function contactUs($POST)
	{
		 $_POST = $POST;
		 $validator = new FormValidator();
		 $validator->addValidation("name","req",'_CONTACT_US_NAME_VALIDATE_');
		 $validator->addValidation("name","fullname",'_NAME_VALIDATE_SPECIAL_CHAR_');
		 $validator->addValidation("name","maxlen=25",'_NAME_VALIDATE_MAX_LEN_');
		
		 if(!isset($_POST['email']))
		 {
			 $validator->addValidation("email","req",'_CONTACT_US_EMAIL_VALIDATE_');
		 }
		 $validator->addValidation("email","req",'_CONTACT_US_EMAIL_VALIDATE_');
		 $validator->addValidation("email","email",'_CONTACT_US_INVALID_EMAIL_VALIDATE_');
		 $validator->addValidation("comment","req",'_CONTACT_US_COMMENT_VALIDATE_');
		 $validator->addValidation("comment","comment",'_COMMENT_VALIDATE_SPECIAL_CHAR_');
		 $validator->addValidation("comment","minlen=20",'_CONTACT_US_COMMENT_LENGTH_VALIDATE_');
		 
		 if(!$validator->ValidateForm())
		 {
			$error_hash = $validator->GetError();
			$status = array('status'=>$this->errorCode[$error_hash],'message'=>$this->msg[$error_hash]);
			return $status;
		}
		else
		{
			return array('status'=>0,'message'=>'success');
		}
			
	}
	
	/*
	Validation for Forgot Password Form
	PARAM : Array of Post Data
	*/
	function forgot_password($POST)
	{
		 $_POST = $POST;
		 $validator = new FormValidator();
		 $validator->addValidation("loginId","req",'EMAIL_PHONE_MSG');
		 
		 if(!$validator->ValidateForm())
		 {
			$error_hash = $validator->GetError();
			$status = array('status'=>$this->errorCode[$error_hash],'message'=>$this->msg[$error_hash]);
	 		return $status;
		 }
		 else
		 {
			return array('status'=>0,'message'=>'success');
		 } 	
	}
	
	/*
	Validation for Reset Password Form
	PARAM : Array of Post Data
	*/
	function resetpassword($POST)
	{
		 $_POST = $POST;
		 $validator = new FormValidator();
		 $validator->addValidation("token","req",'VALIDATE_TOKEN');
		 $validator->addValidation("new_password","req",'_PASSWORD_VALIDATE_ACCOUNTMANAGER_');
		 $validator->addValidation("new_password","minlen=6",'_VALIDATE_PASSWORD_GT_6_');
		 $validator->addValidation("new_password_confirm","req",'_PASSWORD_CVALIDATE_ACCOUNTMANAGER_');
		 $validator->addValidation("new_password_confirm","minlen=6",'_VALIDATE_PASSWORD_GT_6_');
		
		 if(trim($_POST['new_password'])!=trim($_POST['new_password_confirm']))
  		{
     		$validator->addValidation("matchpassword","req",'_VALIDATE_PASS_CPASS_MATCH_');
  		}
		
		if(!$validator->ValidateForm())
		 {
			$error_hash = $validator->GetError();
			$status = array('status'=>$this->errorCode[$error_hash],'message'=>$this->msg[$error_hash]);
	 		return $status;
		 }
		 else
		 {
			return array('status'=>0,'message'=>'success');
		 } 	 
	}
	
	
	function is_valid_email($email) 
	{
		$result = TRUE;
		 if(!preg_match("/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i", $email)) { 
			  $result = false; 
		  } 
		  else { 
		  $result = true; }
			return $result;
	}
	 
	function checkArrayDiff($dbArray,$chkArray)
	{		 
	
		if(!is_array($dbArray) || !is_array($chkArray) || empty($chkArray))
		{			
			return false; 
		}
		 
		$result = array_diff($dbArray,$chkArray);
		if(count($result)==count($dbArray))
		{
			return false; 
		}
		else
		{			
			return true; 
		}
	
	}
	 
	function sendEmail()
	{
		$validator = new FormValidator();
		$validator->addValidation("seekerId", "req", '_NO_SEEKER_SELECTED_');
		$validator->addValidation("subject", "req", '_EMPTY_EMAIL_SUBJECT_');
		$validator->addValidation("subject", "comment", '_EMAIL_SUBJECT_NO_SPECIAL_CHARACTER_');
		$validator->addValidation("subject", "maxlen=50", '_EMAIL_SUBJECT_');
		$validator->addValidation("body", "req", '_EMPTY_EMAIL_BODY_');
		$validator->addValidation("body", "comment", '_EMPTY_EMAIL_BODY_');
		$validator->addValidation("body", "maxlen=120", '_EMAIL_BODY_NO_SPECIAL_CHARACTER_');
		if(!$validator->ValidateForm())
		{
				$error_hash = $validator->GetError();
				$status = array('status'=>$this->errorCode[$error_hash],'message'=>$this->msg[$error_hash]);
				return $status;
		}
		else
		{
				return array('status'=>0,'message'=>'success');
		}
	 }
	 
	 function editProfile($post)
	 {
		 $validator = new FormValidator();
		 $validator->addValidation("fName","req",'_FNAME_VALIDATE_ACCOUNTMANAGER_');
		 $validator->addValidation("fName","fullname",'_NAME_VALIDATE_SPECIAL_CHAR_');
		 $validator->addValidation("fName","maxlen=25",'_NAME_VALIDATE_MAX_LEN_');
		
		 $validator->addValidation("lName","req",'_LNAME_VALIDATE_ACCOUNTMANAGER_');
		 $validator->addValidation("lName","fullname",'_NAME_VALIDATE_SPECIAL_CHAR_');
		 $validator->addValidation("lName","maxlen=25",'_NAME_VALIDATE_MAX_LEN_');
		
		// $validator->addValidation("timezone","req",'_TIMEZONE_');
		
		if(!$validator->ValidateForm())
		 {
			$error_hash = $validator->GetError();
			$status = array('status'=>$this->errorCode[$error_hash],'message'=>$this->msg[$error_hash]);
	 		return $status;
		 }
		 else
		 {
			return array('status'=>0,'message'=>'success');
		 } 	 
	 }
	 
	 function saveToDoList($POST)
	 {
		 $_POST = $POST;
		 $validator = new FormValidator();
		 $validator->addValidation("todoList","req",'_FNAME_VALIDATE_ACCOUNTMANAGER_');
		 $validator->addValidation("todoList","fullname",'_NAME_VALIDATE_SPECIAL_CHAR_');
		 $validator->addValidation("todoList","maxlen=25",'_NAME_VALIDATE_MAX_LEN_'); 
		 if(!$validator->ValidateForm())
		 {
			$error_hash = $validator->GetError();
			$status = array('status'=>$this->errorCode[$error_hash],'message'=>$this->msg[$error_hash]);
	 		return $status;
		 }
		 else
		 {
			return array('status'=>0,'message'=>'success');
		 } 	 
	 }
	 
	 function updateAdminProfile($post)
	 {
		$validator = new FormValidator();
            
			$validator->addValidation("firstName", "req",'_FNAME_VALIDATE_ACCOUNTMANAGER_');
            $validator->addValidation("lastName", "name",'_LNAME_VALIDATE_SPECIAL_CHAR_');
            
			if (!$validator->ValidateForm()) {
                $error_hash = $validator->GetError();
                $result[1] = $error_hash;
				return array('status'=>$this->errorCode[$error_hash],'message'=>$this->msg[$error_hash]); 	
            }else{	
				return array('status'=>0,'message'=>'success'); 	
			}
	 }
	 
	 
}
