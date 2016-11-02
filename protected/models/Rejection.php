<?php

/**
 * This is the model class for table "rejection".
 *
 * The followings are the available columns in table 'rejection':
 * @property integer $rejection_id
 * @property integer $so_id
 * @property integer $admin_id
 * @property integer $zone_id
 * @property integer $customer_id
 * @property integer $total_product
 * @property double $total_amount
 * @property string $reason
 * @property string $createdAt
 * @property string $modifiedAt
 */
class Rejection extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Rejection the static model class
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
		return 'rejection';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('so_id, admin_id, zone_id, customer_id, total_product', 'numerical', 'integerOnly'=>true),
			array('total_amount', 'numerical'),
			array('reason, createdAt, modifiedAt', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('rejection_id, so_id, admin_id, zone_id, customer_id, total_product, total_amount, reason, createdAt, modifiedAt', 'safe', 'on'=>'search'),
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
			'rejection_id' => 'Rejection',
			'so_id' => 'So',
			'admin_id' => 'Admin',
			'zone_id' => 'Zone',
			'customer_id' => 'Customer',
			'total_product' => 'Total Product',
			'total_amount' => 'Total Amount',
			'reason' => 'Reason',
			'createdAt' => 'Created At',
			'modifiedAt' => 'Modified At',
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

		$criteria->compare('rejection_id',$this->rejection_id);
		$criteria->compare('so_id',$this->so_id);
		$criteria->compare('admin_id',$this->admin_id);
		$criteria->compare('zone_id',$this->zone_id);
		$criteria->compare('customer_id',$this->customer_id);
		$criteria->compare('total_product',$this->total_product);
		$criteria->compare('total_amount',$this->total_amount);
		$criteria->compare('reason',$this->reason,true);
		$criteria->compare('createdAt',$this->createdAt,true);
		$criteria->compare('modifiedAt',$this->modifiedAt,true);

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
	
	function getRejectionData($rejection_id)
	{
		$sql = "select a.firstName as createBy, CONCAT(aa.firstName,' ',aa.lastName) as driver, aa.id as driver_id, c.customer_name,CONCAT(c.house_no,', ',c.building_name,', ',c.landmark1,', ',c.landmark2,', ',c.area) as cust_address, dd.type, d.delivery_date, r.* from rejection r 
Left Join delivery_details d ON  ( d.delivery_id = r.delivery_id )
Left Join delivery_desc dd ON  ( dd.so_id = r.so_id )
Left Join admin aa ON  ( aa.id = d.driver_id )
Left Join customers c ON  ( c.customer_id = r.customer_id )
Left Join admin a ON  ( a.id = r.admin_id ) 
Where r.rejection_id = ".$rejection_id.";";	
		$result	=Yii::app()->db->createCommand($sql)->queryRow();
		return $result;
		
	}
	
	function getAllRejectedOrders()
	{
		$sql = "select r.*,c.customer_name ,c.mobile_no, z.zoneName,a.firstName as driverFirstName,a.lastName as  driverLastName from rejection r,customers c, zone z,admin a where r.customer_id = c.customer_id and  c.zone_id = z.zone_id and r.driver_id = a.id order by r.rejection_id desc";	
		$result	=Yii::app()->db->createCommand($sql)->queryAll();
		return $result;
	}
	
	function getCustomerWiseRejectionOrders($fromDate,$toDate)
	{
		if(isset($fromDate) && $fromDate != NULL && isset($toDate) && $toDate != NULL)
		{
			
			$dateSearch = "where dd.delivery_date >= '".date('Y-m-d',strtotime($fromDate))."' and dd.delivery_date <= '".date('Y-m-d',strtotime($toDate))."' ";	
		}
		
		$sql = "select c.customer_id,c.customer_name,sum(r.total_product) as total_product,sum(r.total_amount) as total_amount from rejection r 
Left Join customers c On (c.customer_id = r.customer_id ) 
Left Join delivery_desc dd On (dd.delivery_id = r.delivery_id ) 
".$dateSearch." group by r.customer_id";
		$result	=Yii::app()->db->createCommand($sql)->queryAll();
		return $result;	
	}
	
	function getRejectionDataBySoId($so_id)
	{
		$sql = "select a.firstName as createBy, CONCAT(aa.firstName,' ',aa.lastName) as driver, aa.id as driver_id, c.customer_name,CONCAT(c.house_no,', ',c.building_name,', ',c.landmark1,', ',c.landmark2,', ',c.area) as cust_address, dd.type, d.delivery_date, r.* from rejection r 
Left Join delivery_details d ON  ( d.delivery_id = r.delivery_id )
Left Join delivery_desc dd ON  ( dd.so_id = r.so_id )
Left Join admin aa ON  ( aa.id = d.driver_id )
Left Join customers c ON  ( c.customer_id = r.customer_id )
Left Join admin a ON  ( a.id = r.admin_id ) 
Where r.so_id = ".$so_id.";";	
		$result	=Yii::app()->db->createCommand($sql)->queryRow();
		return $result;
		
	}
}