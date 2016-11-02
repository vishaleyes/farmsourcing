<?php

/**
 * This is the model class for table "coupon_transactions".
 *
 * The followings are the available columns in table 'coupon_transactions':
 * @property integer $coupon_return_id
 * @property integer $coupon_master_id
 * @property integer $customer_id
 * @property double $used_amount
 * @property integer $admin_id
 * @property string $modifiedAt
 * @property string $createdAt
 */
class CouponTransactions extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CouponTransactions the static model class
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
		return 'coupon_transactions';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('coupon_master_id, customer_id, admin_id', 'numerical', 'integerOnly'=>true),
			array('used_amount', 'numerical'),
			array('modifiedAt, createdAt', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('coupon_return_id, coupon_master_id, customer_id, used_amount, admin_id, modifiedAt, createdAt', 'safe', 'on'=>'search'),
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
			'coupon_return_id' => 'Coupon Return',
			'coupon_master_id' => 'Coupon Master',
			'customer_id' => 'Customer',
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

		$criteria->compare('coupon_return_id',$this->coupon_return_id);
		$criteria->compare('coupon_master_id',$this->coupon_master_id);
		$criteria->compare('customer_id',$this->customer_id);
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
	
	function getTotalCountForAmount($coupon_master_id,$customer_id)
	{
		$sql = "select sum(used_amount) as total_used_amount from coupon_transactions where coupon_master_id = '".$coupon_master_id."' and customer_id = ".$customer_id."";	
		
		$result	=Yii::app()->db->createCommand($sql)->queryRow();
		return $result;
	}
	
	function getCouponTransactionDataById($id)
	{
		$sql = "select * from coupon_transactions where coupon_return_id = '".$id."'";	
		
		$result	=Yii::app()->db->createCommand($sql)->queryRow();
		return $result;
	}
	
	
}