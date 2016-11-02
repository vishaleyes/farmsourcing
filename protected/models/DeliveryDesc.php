<?php

/**
 * This is the model class for table "delivery_desc".
 *
 * The followings are the available columns in table 'delivery_desc':
 * @property integer $id
 * @property integer $delivery_id
 * @property integer $admin_id
 * @property integer $customer_id
 * @property integer $zone_id
 * @property integer $so_id
 * @property integer $no_of_packets
 * @property double $so_amount
 * @property double $customer_amount_due
 * @property double $cash_amount
 * @property double $credit_amount
 * @property double $coupon_amount
 * @property integer $status
 * @property string $createdAt
 * @property string $modifiedAt
 */
class DeliveryDesc extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return DeliveryDesc the static model class
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
		return 'delivery_desc';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		//return array(
//			array('delivery_id, admin_id, customer_id, zone_id, so_id, no_of_packets, status', 'numerical', 'integerOnly'=>true),
//			array('so_amount, customer_amount_due, cash_amount, credit_amount, coupon_amount', 'numerical'),
//			array('createdAt, modifiedAt', 'safe'),
//			// The following rule is used by search().
//			// Please remove those attributes that should not be searched.
//			array('id, delivery_id, admin_id, customer_id, zone_id, so_id, no_of_packets, so_amount, customer_amount_due, cash_amount, credit_amount, coupon_amount, status, createdAt, modifiedAt', 'safe', 'on'=>'search'),
//		);
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
			'delivery_id' => 'Delivery',
			'admin_id' => 'Admin',
			'customer_id' => 'Customer',
			'zone_id' => 'Zone',
			'so_id' => 'So',
			'no_of_packets' => 'No Of Packets',
			'so_amount' => 'So Amount',
			'customer_amount_due' => 'Customer Amount Due',
			'cash_amount' => 'Cash Amount',
			'credit_amount' => 'Credit Amount',
			'coupon_amount' => 'Coupon Amount',
			'status' => 'Status',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('delivery_id',$this->delivery_id);
		$criteria->compare('admin_id',$this->admin_id);
		$criteria->compare('customer_id',$this->customer_id);
		$criteria->compare('zone_id',$this->zone_id);
		$criteria->compare('so_id',$this->so_id);
		$criteria->compare('no_of_packets',$this->no_of_packets);
		$criteria->compare('so_amount',$this->so_amount);
		$criteria->compare('customer_amount_due',$this->customer_amount_due);
		$criteria->compare('cash_amount',$this->cash_amount);
		$criteria->compare('credit_amount',$this->credit_amount);
		$criteria->compare('coupon_amount',$this->coupon_amount);
		$criteria->compare('status',$this->status);
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
	
	function getDeliveryDescData($delivery_id)
	{
		
		$sql = "select * from delivery_desc where delivery_id =  ".$delivery_id."";
		$result	=	Yii::app()->db->createCommand($sql)->queryAll();
		return $result;
	}
	
	function getDeliveryOrderData($so_id)
	{
		$sql = "select a.firstName as createBy, CONCAT(COALESCE(aa.firstName,''),' ',COALESCE(aa.lastName,'')) as driver, aa.id as driver_id, z.zoneName,c.representativeId, c.customer_name,CONCAT(COALESCE(c.house_no,''),', ',COALESCE(c.building_name,''),', ',COALESCE(c.landmark1,''),', ',COALESCE(c.landmark2,''),', ',COALESCE(c.area,'')) as cust_address, c.customer_type, dd.* from delivery_desc dd 
				Left Join delivery_details d ON  ( d.delivery_id = dd.delivery_id )
				Left Join admin aa ON  ( aa.id = d.driver_id )
				Left Join customers c ON  ( c.customer_id = dd.customer_id )
				Left Join zone z ON  ( z.zone_id = dd.zone_id ) 
				Left Join admin a ON  ( a.id = dd.admin_id ) 
				Where dd.so_id = ".$so_id.";";	
		$result	=Yii::app()->db->createCommand($sql)->queryRow();
		return $result;
	}
	
	function getAllDeliveryPendingOrders()
	{
		$sql = "select * from delivery_desc where status = 0 order by so_id desc;";	
		$result	=Yii::app()->db->createCommand($sql)->queryAll();
		return $result;
	}
	
	function getAllDeliveryOrdersForCollection()
	{
		$sql = "select * from delivery_desc order by so_id desc;";	
		$result	=Yii::app()->db->createCommand($sql)->queryAll();
		return $result;
	}
	
	function getDailySalesReportByInvoiceId($fromDate,$toDate,$order_type)
	{
		
		
		if(isset($fromDate) && $fromDate != NULL && isset($toDate) && $toDate != NULL)
		{
			
			$dateSearch = "dd.delivery_date BETWEEN '".date('Y-m-d',strtotime($fromDate))."' and  '".date('Y-m-d',strtotime($toDate))."' ";	
		}
		
		if(isset($order_type) && !empty($order_type))
		{
			$orderTypeSearch = "(";
			$j = 0;
			foreach($order_type as $row)
			{
				if($j == 0)
				{
					$cond = " ";	
				}else{
					$cond = " OR ";
				}
				$orderTypeSearch .= $cond . "dd.type = '".$row."' ";
				$j++;
			}
			$orderTypeSearch .= ")";	
		}
		
		$sql = "select dd.so_id,c.customer_name,c.representativeId, c.customer_id, 
					dd.so_amount as so_amount, 
					sum(dod.discount_amount) as discount_amount from delivery_order_desc dod 
					Left Join delivery_desc dd  ON (dod.delivery_desc_id = dd.id) 
					Left Join customers c ON (c.customer_id = dd.customer_id) 
					where ".$dateSearch." 
					and ".$orderTypeSearch."
					group by dd.so_id order by dd.so_id ASC;";
					
		$result	=Yii::app()->db->createCommand($sql)->queryAll();
		return $result;
		
	}
	
	function getDailyCustomerReport($fromDate,$toDate,$order_type)
	{
		if(isset($fromDate) && $fromDate != NULL && isset($toDate) && $toDate != NULL)
		{
			
			//$dateSearch = "dd.delivery_date >= '".date('Y-m-d',strtotime($fromDate))."' and dd.delivery_date <= '".date('Y-m-d',strtotime($toDate))."' ";	
			
			$dataSearch = "a.delivery_date BETWEEN '".date('Y-m-d',strtotime($fromDate))."' AND '".date('Y-m-d',strtotime($toDate))."'";
		}
		
		
		
	/*$sql = "select c.customer_name,c.representativeId, c.customer_id, sum(dd.no_of_packets) as no_of_packets, sum(dd.so_amount) as so_amount, sum(dd.cash_amount) as cash_amount, sum(dd.credit_amount) as credit_amount, sum(dd.coupon_amount) as coupon_amount  from delivery_desc dd
Left Join customers c ON (c.customer_id = dd.customer_id) where 

".$dateSearch."  and dd.type in (".$order_type.")
group by dd.customer_id; ";	*/

		$sql = "SELECT * FROM (

SELECT c.customer_name,c.representativeId, c.customer_id,dd.delivery_date,  SUM(dd.so_amount) AS so_amount
FROM delivery_desc dd 
LEFT JOIN customers c ON (c.customer_id = dd.customer_id) 
WHERE dd.type IN (".$order_type.")
GROUP BY dd.customer_id ) a WHERE ".$dataSearch." ORDER BY a.delivery_date ASC ";

		$result	=Yii::app()->db->createCommand($sql)->queryAll();
		return $result;
		
	}
	
	function getDailyCollectionReport($fromDate,$toDate)
	{
		if(isset($fromDate) && $fromDate != NULL && isset($toDate) && $toDate != NULL)
		{
			
			$dateSearch = "and dd.delivery_date >= '".date('Y-m-d',strtotime($fromDate))."' and dd.delivery_date <= '".date('Y-m-d',strtotime($toDate))."' ";	
		}
		 $sql = "select c.representativeId,c.customer_name,dd.customer_id,sum(dd.customer_amount_due) as customer_amount_due,sum(dd.so_amount) as so_amount,sum(dd.cash_amount) as cash_amount,sum(dd.coupon_amount) as coupon_amount,sum(dd.credit_amount) as credit_amount from delivery_desc dd,customers c where dd.customer_id = c.customer_id and dd.status != '0' ".$dateSearch." group by customer_id";
		
		$result	=Yii::app()->db->createCommand($sql)->queryAll();
		return $result;
		
	}
	
	function getDailyCouponReport($fromDate,$toDate)
	{
		if(isset($fromDate) && $fromDate != NULL && isset($toDate) && $toDate != NULL)
		{
			
			$dateSearch = "and dd.delivery_date >= '".date('Y-m-d',strtotime($fromDate))."' and dd.delivery_date <= '".date('Y-m-d',strtotime($toDate))."' ";	
		}
		 $sql = "select c.representativeId,c.customer_name,dd.customer_id,sum(dd.customer_amount_due) as customer_amount_due,sum(dd.so_amount) as so_amount,sum(dd.cash_amount) as cash_amount,sum(dd.coupon_amount) as coupon_amount,sum(dd.credit_amount) as credit_amount from delivery_desc dd,customers c where dd.customer_id = c.customer_id and dd.coupon_amount != '' and dd.status != '0' ".$dateSearch." group by customer_id";
		
		$result	=Yii::app()->db->createCommand($sql)->queryAll();
		return $result;
		
	}
	
	function getDailyCashReport($fromDate,$toDate)
	{
		if(isset($fromDate) && $fromDate != NULL && isset($toDate) && $toDate != NULL)
		{
			
			$dateSearch = "and dd.delivery_date >= '".date('Y-m-d',strtotime($fromDate))."' and dd.delivery_date <= '".date('Y-m-d',strtotime($toDate))."' ";	
		}
		 $sql = "select c.representativeId,c.customer_name,dd.customer_id,sum(dd.customer_amount_due) as customer_amount_due,sum(dd.so_amount) as so_amount,sum(dd.cash_amount) as cash_amount,sum(dd.coupon_amount) as coupon_amount,sum(dd.credit_amount) as credit_amount from delivery_desc dd,customers c where dd.customer_id = c.customer_id and dd.cash_amount != '' and dd.status != '0' ".$dateSearch." group by customer_id";
		
		$result	=Yii::app()->db->createCommand($sql)->queryAll();
		return $result;
		
	}
	
	function getDailyCreditReport()
	{
		 $sql = "select c.representativeId,c.customer_name,dd.customer_id,sum(dd.customer_amount_due) as customer_amount_due,sum(dd.so_amount) as so_amount,sum(dd.cash_amount) as cash_amount,sum(dd.coupon_amount) as coupon_amount,sum(dd.credit_amount) as credit_amount from delivery_desc dd,customers c where dd.customer_id = c.customer_id and dd.credit_amount != '' group by customer_id";
		
		$result	=Yii::app()->db->createCommand($sql)->queryAll();
		return $result;
		
	}
	
	
	
	
	
	
	
	function getDailyDriverWiseCollectionReport($fromDate,$toDate)
	{
		if(isset($fromDate) && $fromDate != NULL && isset($toDate) && $toDate != NULL)
		{
			
			$dateSearch = "where dd.delivery_date >= '".date('Y-m-d',strtotime($fromDate))."' and dd.delivery_date <= '".date('Y-m-d',strtotime($toDate))."' ";	
		}
		
		$sql = "select a.id, CONCAT(COALESCE(a.firstName,''),' ',COALESCE(a.lastName,'')) as driverName, sum(dd.cash_amount) as cash_amount, sum(dd.credit_amount) as credit_amount, sum(dd.coupon_amount) as coupon_amount, sum(dd.so_amount) as so_amount from delivery_desc dd
Left Join delivery_details d ON (d.delivery_id = dd.delivery_id)
Left Join admin a ON (a.id = d.driver_id)
".$dateSearch."
group by d.driver_id";
		$result	=Yii::app()->db->createCommand($sql)->queryAll();
		return $result;

	}
	
	function getDailyDriverWiseCouponReport($fromDate,$toDate)
	{
		if(isset($fromDate) && $fromDate != NULL && isset($toDate) && $toDate != NULL)
		{
			
			$dateSearch = "where dd.delivery_date >= '".date('Y-m-d',strtotime($fromDate))."' and dd.delivery_date <= '".date('Y-m-d',strtotime($toDate))."' and dd.coupon_amount != '' ";	
		}
		
		$sql = "select a.id, CONCAT(COALESCE(a.firstName,''),' ',COALESCE(a.lastName,'')) as driverName, sum(dd.cash_amount) as cash_amount, sum(dd.credit_amount) as credit_amount, sum(dd.coupon_amount) as coupon_amount, sum(dd.so_amount) as so_amount from delivery_desc dd
Left Join delivery_details d ON (d.delivery_id = dd.delivery_id)
Left Join admin a ON (a.id = d.driver_id)
".$dateSearch."
group by d.driver_id";
		$result	=Yii::app()->db->createCommand($sql)->queryAll();
		return $result;
	}
	
	function getDailyDriverWiseCashReport($fromDate,$toDate)
	{
		if(isset($fromDate) && $fromDate != NULL && isset($toDate) && $toDate != NULL)
		{
			
			$dateSearch = "where dd.delivery_date >= '".date('Y-m-d',strtotime($fromDate))."' and dd.delivery_date <= '".date('Y-m-d',strtotime($toDate))."' and dd.cash_amount != '' ";	
		}
		
		$sql = "select a.id, CONCAT(COALESCE(a.firstName,''),' ',COALESCE(a.lastName,'')) as driverName, sum(dd.cash_amount) as cash_amount, sum(dd.credit_amount) as credit_amount, sum(dd.coupon_amount) as coupon_amount, sum(dd.so_amount) as so_amount from delivery_desc dd
Left Join delivery_details d ON (d.delivery_id = dd.delivery_id)
Left Join admin a ON (a.id = d.driver_id)
".$dateSearch."
group by d.driver_id";
		$result	=Yii::app()->db->createCommand($sql)->queryAll();
		return $result;
	}
	
	function getDailyDriverWiseCreditReport($fromDate,$toDate)
	{
		if(isset($fromDate) && $fromDate != NULL && isset($toDate) && $toDate != NULL)
		{
			
			$dateSearch = "where dd.delivery_date >= '".date('Y-m-d',strtotime($fromDate))."' and dd.delivery_date <= '".date('Y-m-d',strtotime($toDate))."' and dd.credit_amount != '' ";	
		}
		
		$sql = "select a.id, CONCAT(COALESCE(a.firstName,''),' ',COALESCE(a.lastName,'')) as driverName, sum(dd.cash_amount) as cash_amount, sum(dd.credit_amount) as credit_amount, sum(dd.coupon_amount) as coupon_amount, sum(dd.so_amount) as so_amount from delivery_desc dd
Left Join delivery_details d ON (d.delivery_id = dd.delivery_id)
Left Join admin a ON (a.id = d.driver_id)
".$dateSearch."
group by d.driver_id";
		$result	=Yii::app()->db->createCommand($sql)->queryAll();
		return $result;
	}
	
	
	
	function getCustomerRemainingAmount($customer_id)
	{
		$sql = "select sum(so_amount) as totalAmount, sum(credit_amount) as totalCredit ,sum(cash_amount) as totalCash, sum(coupon_amount) as totalCoupon from delivery_desc where customer_id = ".$customer_id." and status != 0 ;";	
		$result	=Yii::app()->db->createCommand($sql)->queryRow();
		return $result;
	}
	
	function getCustomerRemainingAmountOfAllOrder($customer_id)
	{
		$sql = "select sum(so_amount) as totalAmount, sum(credit_amount) as totalCredit ,sum(cash_amount) as totalCash, sum(coupon_amount) as totalCoupon from delivery_desc where customer_id = ".$customer_id." ;";	
		$result	=Yii::app()->db->createCommand($sql)->queryRow();
		return $result;
	}
	
}