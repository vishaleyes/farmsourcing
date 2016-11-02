<?php

/**
 * This is the model class for table "admin".
 *
 * The followings are the available columns in table 'admin':
 * @property integer $id
 * @property string $email
 * @property string $password
 * @property string $first_name
 * @property string $last_name
 * @property string $avatar
 * @property integer $mobile
 * @property string $created_at
 * @property string $modified_at
 */
class Admin extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Admin the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'admin';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			/*array('email, password, first_name, last_name, avatar, mobile, created_at, modified_at', 'required'),
			array('mobile', 'numerical', 'integerOnly'=>true),
			array('email, password, avatar', 'length', 'max'=>50),
			array('first_name, last_name', 'length', 'max'=>100),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, email, password, first_name, last_name, avatar, mobile, created_at, modified_at', 'safe', 'on'=>'search'),*/
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
			'email' => 'Email',
			'password' => 'Password',
			'first_name' => 'First Name',
			'last_name' => 'Last Name',
			'avatar' => 'Avatar',
			'mobile' => 'Mobile',
			'created_at' => 'Created At',
			'modified_at' => 'Modified At',
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
		$criteria->compare('email',$this->email,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('first_name',$this->first_name,true);
		$criteria->compare('last_name',$this->last_name,true);
		$criteria->compare('avatar',$this->avatar,true);
		$criteria->compare('mobile',$this->mobile);
		$criteria->compare('created_at',$this->created_at,true);
		$criteria->compare('modified_at',$this->modified_at,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	function cleanDB()
	{
		
		$command = Yii::app()->db->createCommand();
		$command->truncateTable('alert');
		$command->truncateTable('attachments');
		$command->truncateTable('comments');
		$command->truncateTable('daemon_outgoing_emails');
		$command->truncateTable('daemon_outgoing_sms');
		$command->truncateTable('incoming_rest_calls');
		$command->truncateTable('invites');
		$command->truncateTable('login');
		$command->truncateTable('reminder');
		$command->truncateTable('response_formats');
		$command->truncateTable('todonetwork');
		$command->truncateTable('todo_items');
		$command->truncateTable('todo_item_change_history');
		$command->truncateTable('todo_lists');
		$command->truncateTable('users');

        $attachment = FILE_UPLOAD . 'attachment/';
		$avatar = FILE_UPLOAD . 'avatar/';
		$GeneralObj = new General();
		$GeneralObj->remove_directory($attachment,true);
		$GeneralObj->remove_directory($avatar,true);
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
	
	//GET ADMIN DETAILS BY EMAIL ID
	function getAdminDetailsByEmail($email,$fields="*")
	{
		$admindata	=	Yii::app()->db->createCommand()
						->select($fields)
						->from($this->tableName())
						->where('email=:email', array(':email'=>$email))
						->queryRow();
		
		return $admindata;
	}
	
	//GET ADMIN DETAILS BY EMAIL ID
	function getAdminDetailsByEmailForPos($email,$fields="*")
	{
		$admindata	=	Yii::app()->db->createCommand()
						->select($fields)
						->from($this->tableName())
						->where('email=:email and type=:type', array(':email'=>$email,':type'=>5))
						->queryRow();
		
		return $admindata;
	}
	
	function getAdminIdByLoginId($loginId)
	{
		$admindata = Yii::app()->db->createCommand()
		->select('*')
		->from($this->tableName())
		->where('email=:email', array(':email'=>$loginId))
		->queryScalar();
					
		return $admindata;	
	}
	
	function getAdminDetailsById($id,$fields="*")
	{
		$admindata = Yii::app()->db->createCommand()
		->select($fields)
		->from($this->tableName())
		->where('id=:id', array(':id'=>$id))
		->queryRow();
		
		return $admindata;
	}
	
	function updateProfile($data,$AdminID)
	{
		
		 $this->setData($data);
         return $this->insertData($AdminID);
	}
	
	function changePassword($id,$data) 
	{
		
		if(!empty($data))
		{
			$generalObj	=	new General();
			$password	=	$generalObj->encrypt_password($data['password']);
			$adminObj=Admin::model()->findbyPk($data['id']);
			$adminObj->password = $password;
			$adminObj->modified_at = date("Y-m-d H:i:s");
			$res = $adminObj->save($data['id']);
		}
	}
	
	function changeUserPassword($id,$data)
	{
		
		if(!empty($data))
		{
			$generalObj	=	new General();
			$password	=	$generalObj->encrypt_password($data['password']);
			$loginObj=Login::model()->findbyPk($id);
			$loginObj->password = $password;
			return $res = $loginObj->save($id);
		}
	}
	
	function getAllUsers()
	{
		$sql = "select * from admin where type != '0' order by id desc ";	
		$result	=Yii::app()->db->createCommand($sql)->queryAll();
		return $result;
	}
	
	function getAllDrviers()
	{
		$sql = "select * from admin where type = '2' order by id desc ";	
		$result	=Yii::app()->db->createCommand($sql)->queryAll();
		return $result;
	}
	
	
	
	function forgot_password($loginId,$mobile=0)
	{
		$generalObj=new General();
		
			$id = $this->getAdminIdByLoginId($loginId);
			
			if($id>0)
			{
				$new_password = $this->genPassword();
				$Admin_field['fpasswordConfirm']=$new_password;
				$adminObj=new Admin();
				$this->setData($Admin_field);	
				$this->insertData($id);		
				
			
				$recipients = $loginId;							
				$email =$loginId;
				$subject = Yii::app()->params->msg['FORGOT_PASSWORD_SUBJECT'];
				Yii::app()->session['prefferd_language'] = 'eng';
				Yii::app()->session['prefferd_language']='eng';
				$message = file_get_contents(Yii::app()->params->base_path.'templatemaster/SetTemplate/lng/'.Yii::app()->session['prefferd_language'].'/file/'.Yii::app()->params->msg['_ET_FORGOT_PASSWORD_LINK_TPL_']);
				
				$message = str_replace("_BASEPATHLOGO_",BASE_PATH,$message);
				
				if($mobile==1)
				{
					$message = str_replace("_BASEPATH_",BASE_PATH.'m/',$message);
				}
				else
				{
					$message = str_replace("_BASEPATH_user",Yii::app()->params->base_path.'admin',$message);
				}
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
	
	function resetpassword($data)
	{
		if($data['token']!='')
		{
			if(strlen($data['new_password'])>=6)
			{
				if($data['new_password']==$data['new_password_confirm'])
				{
					$generalObj = new General();
					$id=$this->getIdByfpasswordConfirm($data['token']);
					
					if(!empty($id))
					{
						$new_password =$generalObj->encrypt_password($data['new_password']);
						$admin_field['password'] = $new_password;
						$admin_field['fpasswordConfirm']= '';
						/*echo "<pre>";
						print_r($admin_field);
						echo $id;
						exit;*/
						$this->setData($admin_field);
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
		$sql = "select id from admin where fpasswordConfirm = '".$token."' ";	
		$result	=Yii::app()->db->createCommand($sql)->queryScalar();
		return $result;
	}
	
	function saveToDoStatus($data)
	{
		
		$adminObj=Admin::model()->findbyPk(Yii::app()->session['farmsourcing_adminUser']);
		
		if($data['stat3']!='')
		{
			$adminObj->myDoneStatus = $data['stat3'];
		}
		
		if($data['stat4']!='')
		{
			$adminObj->myCloseStatus = $data['stat4'];
		}
		
		if($data['stat1']!='')
		{
			$adminObj->myOpenStatus = $data['stat1'];
		}
		
		return   $adminObj->save(Yii::app()->session['farmsourcing_adminUser']);
	
	}
	
	function verifyUser($data,$id)
	{
		$this->setData($data);
		return $this->insertData($id);
	}
	
	
	function deleteUser($id)
	{
		$adminObj=Admin::model()->findByPk($id);
		if(is_object($adminObj))
		{
			$adminObj->delete();
		}
		return true;
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
	
	function downloadDataFromServer($tableName,$modifiedAt,$admin_id)
	{
		$sql = " select * from ".$tableName." where modifiedAt > '".$modifiedAt."' and admin_id = '".$admin_id."' ; ";	
		$result	=Yii::app()->db->createCommand($sql)->queryAll();
		return $result;
	}
	
	function downloadDeliveryDetails($tableName,$modifiedAt,$admin_id)
	{
		$sql = " select * from ".$tableName." where modifiedAt > '".$modifiedAt."' and driver_id = '".$admin_id."' ; ";	
		$result	=Yii::app()->db->createCommand($sql)->queryAll();
		return $result;
	}
	
	function downloadDeliveryDescDetails($modifiedAt,$admin_id)
	{
		$sql = "select des.* from delivery_desc des
				Left Join delivery_details dd ON (dd.delivery_id = des.delivery_id)
				where dd.driver_id = '".$admin_id."' and dd.modifiedAt >  '".$modifiedAt."' ;";	
		$result	=Yii::app()->db->createCommand($sql)->queryAll();
		return $result;
	}
	
	function downloadDeliveryOrderDetails($modifiedAt,$admin_id)
	{
		$sql = "select dod.* from delivery_order_desc dod
				Left Join delivery_desc des ON (des.id = dod.delivery_desc_id)
				Left Join delivery_details dd ON (dd.delivery_id = des.delivery_id)
				where dd.driver_id = '".$admin_id."' and dd.modifiedAt >  '".$modifiedAt."' ;";	
		$result	=Yii::app()->db->createCommand($sql)->queryAll();
		return $result;
	}
	
	function downloadDataFromServerWithoutUserId($tableName,$modifiedAt)
	{
		$sql = " select * from ".$tableName." where modifiedAt > '".$modifiedAt."' ; ";	
		$result	=Yii::app()->db->createCommand($sql)->queryAll();
		return $result;
	}
	
	function downloadDataFromServerOfProduct($tableName,$modifiedAt)
	{
		$sql = " select * from ".$tableName." where modified_date > '".$modifiedAt."' ; ";	
		$result	=Yii::app()->db->createCommand($sql)->queryAll();
		return $result;
	}
	
	function uploadDataOnServer($query=NULL)
	{
		$sql = " ".$query." ";	
		$result	= Yii::app()->db->createCommand($sql)->query();
		return Yii::app()->db->lastInsertID ;
	}
}