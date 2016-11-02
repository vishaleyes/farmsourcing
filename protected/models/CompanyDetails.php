<?php

/**
 * This is the model class for table "company_details".
 *
 * The followings are the available columns in table 'company_details':
 * @property integer $id
 * @property string $company_name
 * @property string $company_address
 * @property string $company_logo
 * @property string $currency
 * @property string $modifiedAt
 * @property string $createdAt
 */
class CompanyDetails extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CompanyDetails the static model class
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
		return 'company_details';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('company_name, company_address, company_logo', 'length', 'max'=>255),
			array('currency', 'length', 'max'=>10),
			array('modifiedAt, createdAt', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, company_name, company_address, company_logo, currency, modifiedAt, createdAt', 'safe', 'on'=>'search'),
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
			'company_name' => 'Company Name',
			'company_address' => 'Company Address',
			'company_logo' => 'Company Logo',
			'currency' => 'Currency',
			'modifiedAt' => 'Modified At',
			'createdAt' => 'Created At',
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
		$criteria->compare('company_name',$this->company_name,true);
		$criteria->compare('company_address',$this->company_address,true);
		$criteria->compare('company_logo',$this->company_logo,true);
		$criteria->compare('currency',$this->currency,true);
		$criteria->compare('modifiedAt',$this->modifiedAt,true);
		$criteria->compare('createdAt',$this->createdAt,true);

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
	
	function updateProfile($data,$AdminID)
	{
		
		 $this->setData($data);
         return $this->insertData($AdminID);
	}
	
	function getCompanyDetailsById($id)
	{
		$admindata = Yii::app()->db->createCommand()
		->select("*")
		->from($this->tableName())
		->where('id=:id', array(':id'=>$id))
		->queryRow();
		
		return $admindata;
	}	
	
	function getCompanyDetailsByAdminId($admin_id)
	{
		$admindata = Yii::app()->db->createCommand()
		->select("*")
		->from($this->tableName())
		//->where('admin_id=:admin_id', array(':admin_id'=>$admin_id))
		->queryRow();
		
		return $admindata;
	}
}