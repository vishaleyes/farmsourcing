<?php

/**
 * This is the model class for table "promocodes".
 *
 * The followings are the available columns in table 'promocodes':
 * @property integer $promocode_id
 * @property string $promocode_uniqueId
 * @property integer $promocode_type
 * @property double $promocode_amount
 * @property integer $admin_id
 * @property integer $isSynced
 * @property integer $isUsed
 * @property integer $status
 * @property string $modifiedAt
 * @property string $createdAt
 */
class Promocodes extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Promocodes the static model class
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
		return 'promocodes';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		/*return array(
			array('promocode_type, admin_id, isSynced, isUsed, status', 'numerical', 'integerOnly'=>true),
			array('promocode_amount', 'numerical'),
			array('promocode_uniqueId', 'length', 'max'=>255),
			array('modifiedAt, createdAt', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('promocode_id, promocode_uniqueId, promocode_type, promocode_amount, admin_id, isSynced, isUsed, status, modifiedAt, createdAt', 'safe', 'on'=>'search'),
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
			'promocode_id' => 'Promocode',
			'promocode_uniqueId' => 'Promocode Unique',
			'promocode_type' => 'Promocode Type',
			'promocode_amount' => 'Promocode Amount',
			'admin_id' => 'Admin',
			'isSynced' => 'Is Synced',
			'isUsed' => 'Is Used',
			'status' => 'Status',
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

		$criteria->compare('promocode_id',$this->promocode_id);
		$criteria->compare('promocode_uniqueId',$this->promocode_uniqueId,true);
		$criteria->compare('promocode_type',$this->promocode_type);
		$criteria->compare('promocode_amount',$this->promocode_amount);
		$criteria->compare('admin_id',$this->admin_id);
		$criteria->compare('isSynced',$this->isSynced);
		$criteria->compare('isUsed',$this->isUsed);
		$criteria->compare('status',$this->status);
		$criteria->compare('modifiedAt',$this->modifiedAt,true);
		$criteria->compare('createdAt',$this->createdAt,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
		
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
	
	function getAllPromoCodesList()
	{
		$sql = "select * from promocodes order by promocode_id desc;";	
		
		$result	=Yii::app()->db->createCommand($sql)->queryAll();
		return $result;
	}
	
	function checkPromocodeUniqueId($promocode_uniqueId)
	{
		$sql = "select * from promocodes where promocode_uniqueId = '".$promocode_uniqueId."' ";	
		
		$result	=Yii::app()->db->createCommand($sql)->queryRow();
		return $result;
	}
	
	function getPromoCodeDataById($id)
	{
		$sql = "select p.* from promocodes p where p.promocode_id = '".$id."'";	
		
		$result	=Yii::app()->db->createCommand($sql)->queryRow();
		return $result;
	}
	
	function deletePromoCode($id)
	{
		$promocodeObj=Promocodes::model()->findByPk($id);
		if(is_object($promocodeObj))
		{
			$promocodeObj->delete();
		}
	}
}