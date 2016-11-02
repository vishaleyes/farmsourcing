<?php

/**
 * This is the model class for table "coupon_master".
 *
 * The followings are the available columns in table 'coupon_master':
 * @property integer $id
 * @property string $coupon_number
 * @property integer $customer_id
 * @property double $coupon_amount
 * @property double $used_amount
 * @property integer $admin_id
 * @property string $modifiedAt
 * @property string $createdAt
 */
class CouponMaster extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CouponMaster the static model class
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
		return 'coupon_master';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('customer_id, admin_id', 'numerical', 'integerOnly'=>true),
			array('coupon_amount, used_amount', 'numerical'),
			array('coupon_number', 'length', 'max'=>50),
			array('modifiedAt, createdAt', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, coupon_number, customer_id, coupon_amount, used_amount, admin_id, modifiedAt, createdAt', 'safe', 'on'=>'search'),
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
			'coupon_number' => 'Coupon Number',
			'customer_id' => 'Customer',
			'coupon_amount' => 'Coupon Amount',
			'used_amount' => 'Used Amount',
			'admin_id' => 'Admin',
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
		$criteria->compare('coupon_number',$this->coupon_number,true);
		$criteria->compare('customer_id',$this->customer_id);
		$criteria->compare('coupon_amount',$this->coupon_amount);
		$criteria->compare('used_amount',$this->used_amount);
		$criteria->compare('admin_id',$this->admin_id);
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
	
	function getCouponData($coupon_number,$customer_id)
	{
		$sql = "select * from coupon_master where coupon_number = '".$coupon_number."' and customer_id = ".$customer_id."";	
		
		$result	=Yii::app()->db->createCommand($sql)->queryRow();
		return $result;
	}
	
	function checkCouponNo($coupon_number)
	{
		$sql = "select * from coupon_master where coupon_number = '".$coupon_number."' and status = 1 and isUsed = 0";	
		
		$result	=Yii::app()->db->createCommand($sql)->queryRow();
		return $result;
	}
	
	function checkCouponNoName($coupon_number)
	{
		$sql = "select * from coupon_master where coupon_number = '".$coupon_number."' ";	
		
		$result	=Yii::app()->db->createCommand($sql)->queryRow();
		return $result;
	}
	
	function getCouponDataById($id)
	{
		$sql = "select * from coupon_master where id = '".$id."'";	
		
		$result	=Yii::app()->db->createCommand($sql)->queryRow();
		return $result;
	}
	
	function getAllAllocatedCoupons()
	{
		$sql = "select c.*,cust.customer_name from coupon_master c,customers cust where c.customer_id = cust.customer_id order by c.id desc";	
		
		$result	=Yii::app()->db->createCommand($sql)->queryAll();
		return $result;
	}
	
	function getCouponAllDataById($id)
	{
		$sql = "select c.*,cust.customer_name from coupon_master c,customers cust where c.customer_id = cust.customer_id and  c.id = '".$id."'";	
		
		$result	=Yii::app()->db->createCommand($sql)->queryRow();
		return $result;
	}
	
	function deleteCoupon($id)
	{
		$couponObj=CouponMaster::model()->findByPk($id);
		if(is_object($couponObj))
		{
			$couponObj->delete();
		}
	}
	
}