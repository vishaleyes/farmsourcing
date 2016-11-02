<?php

/**
 * This is the model class for table "users".
 *
 * The followings are the available columns in table 'users':
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $email
 * @property string $phone
 * @property string $photo
 * @property integer $gender
 * @property string $birthday
 * @property double $latitude
 * @property double $longitude
 * @property integer $status
 * @property string $modified
 * @property string $created
 */
class Users extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Users the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public $msg;
	public $errorCode;
	
	public function __construct()
	{
		$this->msg = Yii::app()->params->msg;
		$this->errorCode = Yii::app()->params->errorCode;
	}
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'users';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('gender, status', 'numerical', 'integerOnly'=>true),
			array('latitude, longitude', 'numerical'),
			array('username, password, email, photo', 'length', 'max'=>255),
			array('phone', 'length', 'max'=>20),
			array('birthday, modified, created', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, username, password, email, phone, photo, gender, birthday, latitude, longitude, status, modified, created', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'username' => 'Username',
			'password' => 'Password',
			'email' => 'Email',
			'phone' => 'Phone',
			'photo' => 'Photo',
			'gender' => 'Gender',
			'birthday' => 'Birthday',
			'latitude' => 'Latitude',
			'longitude' => 'Longitude',
			'status' => 'Status',
			'modified' => 'Modified',
			'created' => 'Created',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('photo',$this->photo,true);
		$criteria->compare('gender',$this->gender);
		$criteria->compare('birthday',$this->birthday,true);
		$criteria->compare('latitude',$this->latitude);
		$criteria->compare('longitude',$this->longitude);
		$criteria->compare('status',$this->status);
		$criteria->compare('modified',$this->modified,true);
		$criteria->compare('created',$this->created,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	// set the user data
	function setData($data)
	{
		$this->data = $data;
	}
	
	// insert the user
	function insertData($id=NULL)
	{
		if($id!=NULL)
		{
			$transaction=$this->dbConnection->beginTransaction();
			try
			{
				$post=$this->findByPk($id);
				if(is_object($post))
				{
					$p=$this->data;
					
					foreach($p as $key=>$value)
					{
						$post->$key=$value;
					}
					$post->save(false);
				}
				$transaction->commit();
			}
			catch(Exception $e)
			{						
				$transaction->rollBack();
			}
			
		}
		else
		{
			$p=$this->data;
			foreach($p as $key=>$value)
			{
				$this->$key=$value;
			}
			$this->setIsNewRecord(true);
			$this->save(false);
			return Yii::app()->db->getLastInsertID();
		}
		
	}
	
	/*
	DESCRIPTION : ADD USER
	*/
	
	
	
	function checkEmailId($email)
	{			
		$result = Yii::app()->db->createCommand()
		->select("*")
		->from($this->tableName())
		->where('email=:email', array(':email'=>$email))
		->queryRow();
			
		return $result ;
	}
	
	
	function checkMobileNo($mobile_no)
	{			
		$result = Yii::app()->db->createCommand()
		->select("*")
		->from($this->tableName())
		->where('mobile_no=:mobile_no', array(':mobile_no'=>$mobile_no))
		->queryRow();
			
		return $result ;
	}
	
	function getUserByCustomerId($customer_id)
	{			
		$result = Yii::app()->db->createCommand()
		->select("*")
		->from($this->tableName())
		->where('customer_id=:customer_id', array(':customer_id'=>$customer_id))
		->queryRow();
			
		return $result ;
	}
	
	
	function checkUserName($username)
	{			
		$result = Yii::app()->db->createCommand()
		->select("*")
		->from($this->tableName())
		->where('username=:username', array(':username'=>$username))
		->queryRow();
			
		return $result ;
	}
	
	function getUserData($username)
	{
		$result	=	Yii::app()->db->createCommand()
					->select('*')
					->from($this->tableName())
					->where('email=:email',
							 array(':email'=>$username))	
					->queryRow();
		
		return $result;
	}
	
	function getUserDataById($userId)
	{
		$result	=	Yii::app()->db->createCommand()
					->select('*')
					->from($this->tableName())
					->where('id=:id',
							 array(':id'=>$userId))	
					->queryRow();
		
		return $result;
	}
	
	function getUnVerifiedUserById($id,$key)
	{
		$result	=	Yii::app()->db->createCommand()
					->select('*')
					->from($this->tableName())
					->where('id=:id and isVerified=:isVerified',
							 array(':id'=>$id,':isVerified'=>$key))	
					->queryRow();
		
		return $result;
	}
	
	function genPassword()
	{
		$pass_char = array();
		$password = '';
		for($i=65 ; $i < 91 ; $i++)
		{
			$pass_char[] = chr($i);
		}
		for($i=97 ; $i < 123 ; $i++)
		{
			$pass_char[] = chr($i);
		}
		for($i=48 ; $i < 58 ; $i++)
		{
			$pass_char[] = chr($i);
		}
		for($i=0 ; $i<8 ; $i++)
		{
			$password .= $pass_char[rand(0,61)];
		}
		return $password;
	}
	
	function getAllContacts()
	{
		$result	=	Yii::app()->db->createCommand()
					->select('*')
					->from($this->tableName())
					->where('isVerified=:isVerified', array(':isVerified'=>1))
					->queryAll();
		
		return $result;
	}
	
	function getAllUsers()
	{
		$result	=	Yii::app()->db->createCommand()
					->select('*')
					->from($this->tableName())
					->queryAll();
		
		return $result;
	}
	
	//Check Session
	function checksession($id=NULL,$sessionId=NULL)
	{
		$result = Yii::app()->db->createCommand()
		->select("sessionId")
		->from($this->tableName())
		->where('id=:id and sessionId=:sessionId', array(':id'=>$id,':sessionId'=>$sessionId))
		->queryScalar();
		
		return $result;
	}
	
	function getNominatedContacts($userId)
	{
		$result = Yii::app()->db->createCommand()
		->select("*")
		->from('nomination')
		->where('nominatedUserId=:nominatedUserId and status=:status', array(':nominatedUserId'=>$userId,':status'=>0))
		->queryAll();
		
		return $result;
	}
	
	function deleteUser($id)
	{
		$userObj=Users::model()->findByPk($id);
		if(is_object($userObj))
		{
			$userObj->delete();
		}
		return true;
	}
	
	function forgot_password($loginId)
	{
		$generalObj=new General();
		
			$data = $this->checkEmailId($loginId);
			
			if(!empty($data))
			{
				$new_password = $this->genPassword();
				$userData['fpasswordConfirm']=$new_password;
				$userObj=new Users();
				$this->setData($userData);	
				$this->insertData($data['id']);		
				
				$recipients = $loginId;							
				$email =$loginId;
				$subject = Yii::app()->params->msg['FORGOT_PASSWORD_SUBJECT'];
				Yii::app()->session['prefferd_language'] = 'eng';
				Yii::app()->session['prefferd_language']='eng';
				$message = file_get_contents(Yii::app()->params->base_path.'templatemaster/SetTemplate/lng/'.Yii::app()->session['prefferd_language'].'/file/'.Yii::app()->params->msg['_ET_FORGOT_PASSWORD_LINK_SITE_TPL_']);
				
				$message = str_replace("_BASEPATHLOGO_",BASE_PATH,$message);
				
				$message = str_replace("_BASEPATH_user",Yii::app()->params->base_path.'site',$message);
				
				$message = str_replace("_LOGOBASEPATH_",Yii::app()->params->image_path,$message);
				$message = str_replace("_PASSWORD_CODE_",$new_password,$message);
				
				$helperObj	=	new Helper();
				$mailResponse=$helperObj->sendMail($email,$subject,$message);
				
				/*$helperObj=new Helper();
				$helperObj->mailSetup($email,$subject,$message,$data['createdBy'],0);*/
				
				return  array('success',Yii::app()->params->msg['NEW_PASS_MSG']);
			 
				
			
			}
			else
			{
				return array('fail',Yii::app()->params->msg['EMAIL_PHONE_MSG']);
			}
	}
	
	function resetpassword($data)
	{
		if($data['token']!='')
		{
			if(strlen($data['new_password'])>=6)
			{
				if($data['new_password']==$data['new_password_confirm'])
				{
					$id=$this->getIdByfpasswordConfirm($data['token']);
					if(!empty($id))
					{
						$algoObj = new Algoencryption();
						$new_password = $algoObj->encrypt($data['new_password']);

						$userData['password'] = $new_password;
						$userData['fpasswordConfirm']= '';
						/*echo "<pre>";
						print_r($admin_field);
						echo $id;
						exit;*/
						$this->setData($userData);
						$this->insertData($id);
						
						return array('success',Yii::app()->params->msg['_PASSWORD_CHANGE_SUCCESS_']);						
					}
					else
					{
						return array('fail',Yii::app()->params->msg['NO_USER_METCH']);
					}	
				}
				else
				{
					return array('fail',Yii::app()->params->msg['_VALIDATE_PASS_CPASS_MATCH_']);
				}
			}
			else
			{
				return array('fail',Yii::app()->params->msg['_VALIDATE_PASSWORD_GT_6_']);
			}
		}
		else
		{
			return array('fail',Yii::app()->params->msg['VALIDATE_TOKEN']);
		}
	}
	
	function getIdByfpasswordConfirm($token)
	{
		$sql = "select id from users where fpasswordConfirm = '".$token."' ";	
		$result	=Yii::app()->db->createCommand($sql)->queryScalar();
		return $result;
	}
	
	function contactUs($data,$mobile=0,$lng='eng')
	{		
		$recipients = $data['email'];							
		$email =$data['email'];							
		$name =$data['name'];
		$comment = htmlentities($data['comment']);
		$Yii = Yii::app();	
		
		$url=Yii::app()->params->base_path.'templatemaster/setTemplate/lng/'.$lng.'/file/contact-us-link';
		$message = file_get_contents($url);
		$message = str_replace("_BASEPATH_",BASE_PATH,$message);
		$message = str_replace("_LOGOBASEPATH_",Yii::app()->params->image_path,$message);
		$message = str_replace("_NAME_",$name,$message);
		$message = str_replace("_COMMENT_",$comment,$message);
		$message = str_replace("_EMAIL_",$email,$message);
		 
		$subject = $this->msg['CONTACT_US_SUCCESS'];
		$helperObj	=	new Helper();	
		//$mailResponse=$helperObj->sendMail($email,$subject,$message);
		$mailResponse=$helperObj->sendMail("admin@bypt.in",$subject,$message);
		if($mailResponse!=true) {	
			$msg= $mailResponse;
			return array('status'=>$this->errorCode['_USER_MAIL_ERROR_'],'message'=>$this->msg['_USER_MAIL_ERROR_']);
		} else {
		   return array('status'=>0,'message'=>$this->msg['CONTACT_US_SUCCESS']);
		}		
		
	}
	
	
	
	
}