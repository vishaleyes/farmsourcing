<?php

/**
 * This is the model class for table "so_details".
 *
 * The followings are the available columns in table 'so_details':
 * @property integer $so_id
 * @property integer $admin_id
 * @property integer $customer_id
 * @property integer $zone_id
 * @property integer $total_item
 * @property double $total_amount
 * @property integer $total_quantity
 * @property integer $paymentType
 * @property double $cashPayment
 * @property double $creditPayment
 * @property double $bankPayment
 * @property double $coupenPayment
 * @property double $discount
 * @property string $discountType
 * @property string $order_date
 * @property string $delivery_date
 * @property string $createdAt
 * @property string $modifiedAt
 * @property integer $status
 */
class SoDetails extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SoDetails the static model class
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
		return 'so_details';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		/*return array(
			array('admin_id, customer_id, zone_id, total_item, total_quantity, paymentType, status', 'numerical', 'integerOnly'=>true),
			array('total_amount, cashPayment, creditPayment, bankPayment, coupenPayment, discount', 'numerical'),
			array('discountType', 'length', 'max'=>1),
			array('order_date, delivery_date, createdAt, modifiedAt', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('so_id, admin_id, customer_id, zone_id, total_item, total_amount, total_quantity, paymentType, cashPayment, creditPayment, bankPayment, coupenPayment, discount, discountType, order_date, delivery_date, createdAt, modifiedAt, status', 'safe', 'on'=>'search'),
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
			'so_id' => 'So',
			'admin_id' => 'Admin',
			'customer_id' => 'Customer',
			'zone_id' => 'Zone',
			'total_item' => 'Total Item',
			'total_amount' => 'Total Amount',
			'total_quantity' => 'Total Quantity',
			'paymentType' => 'Payment Type',
			'cashPayment' => 'Cash Payment',
			'creditPayment' => 'Credit Payment',
			'bankPayment' => 'Bank Payment',
			'coupenPayment' => 'Coupen Payment',
			'discount' => 'Discount',
			'discountType' => 'Discount Type',
			'order_date' => 'Order Date',
			'delivery_date' => 'Delivery Date',
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

		$criteria->compare('so_id',$this->so_id);
		$criteria->compare('admin_id',$this->admin_id);
		$criteria->compare('customer_id',$this->customer_id);
		$criteria->compare('zone_id',$this->zone_id);
		$criteria->compare('total_item',$this->total_item);
		$criteria->compare('total_amount',$this->total_amount);
		$criteria->compare('total_quantity',$this->total_quantity);
		$criteria->compare('paymentType',$this->paymentType);
		$criteria->compare('cashPayment',$this->cashPayment);
		$criteria->compare('creditPayment',$this->creditPayment);
		$criteria->compare('bankPayment',$this->bankPayment);
		$criteria->compare('coupenPayment',$this->coupenPayment);
		$criteria->compare('discount',$this->discount);
		$criteria->compare('discountType',$this->discountType,true);
		$criteria->compare('order_date',$this->order_date,true);
		$criteria->compare('delivery_date',$this->delivery_date,true);
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
	
	function getsalesOrderData($so_id=NULL)
	{
		$sql = "select a.firstName as createBy, z.zoneName, c.customer_name, sod.* from so_details sod 
				Left Join customers c ON  ( c.customer_id = sod.customer_id )
				Left Join zone z ON  ( z.zone_id = c.zone_id ) 
				Left Join admin a ON  ( a.id = sod.admin_id ) 
				Where sod.so_id = ".$so_id.";";	
		$result	=Yii::app()->db->createCommand($sql)->queryRow();
		return $result;
	}
	
	function getsalesOrderListing()
	{
		$sql = "select a.firstName as createBy, z.zoneName, c.customer_name, 
				c.mobile_no, c.representativeId, sod.* from so_details sod
				Left Join customers c ON  ( c.customer_id = sod.customer_id ) 
				Left Join zone z ON  ( z.zone_id = c.zone_id ) 
				Left Join admin a ON  ( a.id = sod.admin_id )
				order by sod.so_id desc ;";	
		$result	=Yii::app()->db->createCommand($sql)->queryAll();
		return $result;
	}
	
	function getsalesOrderListingByDate($fromDate,$toDate)
	{
		$sql = "select a.firstName as createBy, z.zoneName, c.customer_name, 
				c.mobile_no, c.representativeId, sod.* from so_details sod
				Left Join customers c ON  ( c.customer_id = sod.customer_id ) 
				Left Join zone z ON  ( z.zone_id = c.zone_id ) 
				Left Join admin a ON  ( a.id = sod.admin_id )
				where sod.createdAt >= '".date('Y-m-d H:i:s',strtotime($fromDate))."'
				and sod.createdAt <= '".date('Y-m-d H:i:s', strtotime('+1 days', strtotime($toDate)))."' 
				order by sod.so_id desc ;";	
		$result	=Yii::app()->db->createCommand($sql)->queryAll();
		return $result;
	}
	
	function getsalesOrderListingWithFilters($zone_id,$status,$type,$fromDate,$toDate)
	{
		$bool = "where";
		
		if($zone_id != "")
		{
			$filter1 = $bool." c.zone_id = '".$zone_id."' ";
			$bool = "AND ";	
		}
		else
		{
			$filter1=" ";	
		}
		
		if($status != "")
		{
			$filter2 = $bool." sod.status = '".$status."' ";
			$bool = "AND ";	
		}
		else
		{
			$filter2=" ";	
		}
		
		if($type != "")
		{
			$filter3 = $bool." sod.type = '".$type."' ";
			$bool = "AND ";	
		}
		else
		{
			$filter3=" ";	
		}
		
		if($fromDate != "")
		{
			$filter4 = $bool." sod.createdAt >= '".date('Y-m-d H:i:s',strtotime($fromDate))."'";
			$bool = "AND ";	
		}
		else
		{
			$filter4=" ";	
		}
		
		if($toDate != "")
		{
			$filter5 = $bool." sod.createdAt <= '".date('Y-m-d H:i:s', strtotime('+1 days', strtotime($toDate)))."'";
			$bool = "AND ";	
		}
		else
		{
			$filter5=" ";	
		}
		
		$sql = "select a.firstName as createBy, z.zoneName, c.customer_name,c.representativeId, sod.* from so_details sod
				Left Join customers c ON  ( c.customer_id = sod.customer_id ) 
				Left Join zone z ON  ( z.zone_id = c.zone_id ) 
				Left Join admin a ON  ( a.id = sod.admin_id )
				".$filter1." ".$filter2." ".$filter3." ".$filter4." ".$filter5."
				order by sod.so_id desc ;";	
		$result	=Yii::app()->db->createCommand($sql)->queryAll();
		return $result;
	}
	
	function getZoneWiseCustomerData($delivery_date)
	{
		$sql = "select c.customer_id,c.representativeId,c.representativeId,c.customer_name,z.zone_id,z.zoneName from so_details sd,customers c,zone z where sd.customer_id = c.customer_id and c.zone_id = z.zone_id and delivery_date = '".$delivery_date ."' and sd.type != '3' ";	
		$result	=Yii::app()->db->createCommand($sql)->queryAll();
		return $result;
	}
	
	function getZoneWiseCustomerDataGroup($delivery_date)
	{
		$sql = "select c.customer_id,c.representativeId,c.customer_name,z.zone_id,z.zoneName,count(sd.so_id) as total_delivery from so_details sd,customers c,zone z where sd.customer_id = c.customer_id and c.zone_id = z.zone_id and delivery_date = '".$delivery_date ."' group by z.zone_id";	
		$result	=Yii::app()->db->createCommand($sql)->queryAll();
		return $result;
	}
	
	function getAllOrders()
	{
		$sql = "Select * from so_details;";	
		$result	=Yii::app()->db->createCommand($sql)->queryAll();
		return $result;
	}
	
	function getAllOrderForCollection()
	{
		$sql = "Select * from so_details order by so_id desc;";	
		$result	=Yii::app()->db->createCommand($sql)->queryAll();
		return $result;
	}
	
	
	function getAllOrdersForPayment()
	{
		$sql = "Select * from so_details where status = 0;";	
		$result	=Yii::app()->db->createCommand($sql)->queryAll();
		return $result;
	}
	
	function getAllSoListByZoneId($zone_id,$delivery_date)
	{
		$sql = "select c.customer_id,c.representativeId,c.customer_name,z.zone_id,z.zoneName ,sd.* 
				from so_details sd
				Left Join customers c ON(sd.customer_id = c.customer_id)
				Left Join zone z ON(c.zone_id = z.zone_id) where sd.delivery_date = '".$delivery_date."' and z.zone_id = '".$zone_id."'";	
		$result	=Yii::app()->db->createCommand($sql)->queryAll();
		return $result;
	}
	
	public function getAllPaginatedOrderHistory($limit=9,$sortType="asc",$sortBy="",$keyword=NULL,$customer_id)
	{
		
		$criteria = new CDbCriteria();
		$search = '';
		$dateSearch = '';
		$keyword = mysql_real_escape_string($keyword);
		
		
				
		$sql_users = "select s.*,(select sum(sd.quantity * sd.product_price) as total_amount from so_desc sd where sd.so_id = s.so_id ) as so_amount from so_details s,so_desc sd where s.so_id = sd.so_id and customer_id = ".$customer_id." and type = 2 group by sd.so_id order by ".$sortBy." ".$sortType." "	;	
		$sql_count = "select count(*) from so_details  
				where customer_id = ".$customer_id." and type = 2 ".$search."  order by ".$sortBy." ".$sortType."";
			
		$count	=	Yii::app()->db->createCommand($sql_count)->queryScalar();
		
		$item	=	new CSqlDataProvider($sql_users, array(
						'totalItemCount'=>$count,
						'pagination'=>array(
							'pageSize'=>'12',
						),
					));
		$index = 0;	
		return array('pagination'=>$item->pagination, 'listing'=>$item->getData());
	}
	
	
		public function getAllPaginatedOrders($limit=9,$sortType="asc",$sortBy="",$keyword=NULL,$searchFrom,$searchTo,$startdate,$enddate,$todayDate)
	{
		$criteria = new CDbCriteria();
		$search = '';
		$dateSearch = '';
		$keyword = mysql_real_escape_string($keyword);
		
		
		if(isset($keyword) && $keyword != NULL )
		{
			$search = " and (a.firstName like '%".$keyword."%' or a.lastName like '%".$keyword."%' )";	
		}
		
		if(isset($startdate) && $startdate != NULL && isset($enddate) && $enddate != NULL )
		{
			$dateSearch = " and s.createdAt > '".date("Y-m-d",strtotime($startdate))."' and s.createdAt < '".date("Y-m-d",strtotime($enddate))."'";
		}
		
		if(isset($todayDate) && $todayDate != NULL )
		{
			$dateSearch = " and s.createdAt like '%".date("Y-m-d",strtotime($todayDate))."%' ";
		}
		
		$sql_users = "select a.firstName, a.lastName, s.* from so_details s  Left Join admin a ON (a.id = s.admin_id) where s.type = 3 ".$search." ".$dateSearch." order by ".$sortBy." ".$sortType." "	;
		
		$sql_count = "select count(*) from so_details s Left Join admin a ON (a.id = s.admin_id) where s.type = 3 ".$search." ".$dateSearch." ";
				
		$count	=	Yii::app()->db->createCommand($sql_count)->queryScalar();
		
		$item	=	new CSqlDataProvider($sql_users, array(
						'totalItemCount'=>$count,
						'pagination'=>array(
							'pageSize'=>'12',
						),
					));
		$index = 0;	
		return array('pagination'=>$item->pagination, 'listing'=>$item->getData());
	}
	
	function updateSalesOrderPOStatus($delivery_date)
	{
		$sql = "UPDATE so_details SET isPoGenerate = 1 where delivery_date = '".$delivery_date."';";	
		$result	=Yii::app()->db->createCommand($sql)->query();	
		return $result;
	}
	
	function updateCreditAmount($so_id,$amount)
	{
		$modifiesAt  = date("Y-m-d H:i:s");
		$sql = "UPDATE so_details SET credit_amount=credit_amount-'".$amount."',modifiedAt='".$modifiesAt."' WHERE so_id='".$so_id."'";	
		$result	=Yii::app()->db->createCommand($sql)->query();	
		return $result;
	}
	
	function getSumOfCreditByCustomerId($customer_id)
	{
		$sql = "SELECT SUM(credit_amount) FROM so_details WHERE customer_id='".$customer_id."'";	
		$result	=Yii::app()->db->createCommand($sql)->queryScalar();	
		return $result;
	}
	
	function deleteSoDetailRecord($id)
	{
		$soDescObj = SoDesc::model()->findByPk($id);
		if(is_object($soDescObj))
		{
			$soDescObj->delete();
		}
		return true;
	}
	
}