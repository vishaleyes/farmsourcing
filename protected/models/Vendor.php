<?php

/**
 * This is the model class for table "vendor".
 *
 * The followings are the available columns in table 'vendor':
 * @property integer $vendor_id
 * @property string $vendor_name
 * @property integer $contact_no
 * @property string $contact_name
 * @property double $credit
 * @property double $debit
 * @property string $email
 * @property string $address
 * @property integer $admin_id
 * @property string $createdAt
 * @property string $modifiedAt
 * @property integer $status
 */
class Vendor extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Vendor the static model class
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
		return 'vendor';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		/*return array(
			array('contact_no, admin_id, status', 'numerical', 'integerOnly'=>true),
			array('credit, debit', 'numerical'),
			array('vendor_name, contact_name, email, address', 'length', 'max'=>255),
			array('createdAt, modifiedAt', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('vendor_id, vendor_name, contact_no, contact_name, credit, debit, email, address, admin_id, createdAt, modifiedAt, status', 'safe', 'on'=>'search'),
		);*/
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
			'vendor_id' => 'Vendor',
			'vendor_name' => 'Vendor Name',
			'contact_no' => 'Contact No',
			'contact_name' => 'Contact Name',
			'credit' => 'Credit',
			'debit' => 'Debit',
			'email' => 'Email',
			'address' => 'Address',
			'admin_id' => 'Admin',
			'createdAt' => 'Created At',
			'modifiedAt' => 'Modified At',
			'status' => 'Status',
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

		$criteria->compare('vendor_id',$this->vendor_id);
		$criteria->compare('vendor_name',$this->vendor_name,true);
		$criteria->compare('contact_no',$this->contact_no);
		$criteria->compare('contact_name',$this->contact_name,true);
		$criteria->compare('credit',$this->credit);
		$criteria->compare('debit',$this->debit);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('admin_id',$this->admin_id);
		$criteria->compare('createdAt',$this->createdAt,true);
		$criteria->compare('modifiedAt',$this->modifiedAt,true);
		$criteria->compare('status',$this->status);

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
	
	function getAllVendors()
	{
		$sql = "select v.* from vendor v order by vendor_id desc;";	
		$result	=Yii::app()->db->createCommand($sql)->queryAll();
		return $result;
	}
	
	function getVendorById($id)
	{
		$result	=	Yii::app()->db->createCommand()
					->select('*')
					->from($this->tableName())
					->where('vendor_id=:vendor_id', array(':vendor_id'=>$id))
					->queryRow();
		
		return $result;
	}
	
	function deleteVendor($id)
	{
		$vendorObj=Vendor::model()->findbyPk($id);
		$vendorObj->delete();		
		
		return true;
	}
	
	function checkEmailId($email)
	{			
		$result = Yii::app()->db->createCommand()
		->select("*")
		->from($this->tableName())
		->where('email=:email', array(':email'=>$email))
		->queryRow();
			
		return $result ;
	}
	
	function updateVendor($vendor_id,$credit,$debit,$modifiedAt)
	{
		$sql = "UPDATE vendor SET credit = credit + ".$credit." , debit = debit + ".$debit." , modifiedAt= '".$modifiedAt."'  where vendor_id= ".$vendor_id.";";
		$result	=	Yii::app()->db->createCommand($sql)->execute();
		return true;	
	}
	
	function checkVendorName($vendor_name)
	{
		$sql = "select vendor_id from vendor where vendor_name = '".$vendor_name."';";	
		$result	=Yii::app()->db->createCommand($sql)->queryScalar();
		return $result;
	}
	
}