<?php

/**
 * This is the model class for table "so_desc".
 *
 * The followings are the available columns in table 'so_desc':
 * @property integer $id
 * @property integer $so_id
 * @property integer $admin_id
 * @property integer $store_id
 * @property integer $product_id
 * @property integer $quantity
 * @property string $price
 * @property integer $discount
 * @property double $total_price
 * @property string $createdAt
 * @property string $modifiedAt
 */
class SoDesc extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SoDesc the static model class
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
		return 'so_desc';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		/*return array(
			array('so_id, admin_id, store_id, product_id, quantity, discount', 'numerical', 'integerOnly'=>true),
			array('total_price', 'numerical'),
			array('price', 'length', 'max'=>255),
			array('createdAt, modifiedAt', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, so_id, admin_id, store_id, product_id, quantity, price, discount, total_price, createdAt, modifiedAt', 'safe', 'on'=>'search'),
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
			'id' => 'ID',
			'so_id' => 'So',
			'admin_id' => 'Admin',
			'store_id' => 'Store',
			'product_id' => 'Product',
			'quantity' => 'Quantity',
			'price' => 'Price',
			'discount' => 'Discount',
			'total_price' => 'Total Price',
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
		$criteria->compare('so_id',$this->so_id);
		$criteria->compare('admin_id',$this->admin_id);
		$criteria->compare('store_id',$this->store_id);
		$criteria->compare('product_id',$this->product_id);
		$criteria->compare('quantity',$this->quantity);
		$criteria->compare('price',$this->price,true);
		$criteria->compare('discount',$this->discount);
		$criteria->compare('total_price',$this->total_price);
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
	
	function getSoDescDetails($so_id=NULL)
	{
		$sql = "select u.unit_name, p.product_name,p.product_desc,p.product_price,sd.* from so_desc sd 
				Left Join product p On (p.product_id = sd.product_id) 
				Left Join unit u On (u.unit_id = p.unitId)
				where sd.so_id = ".$so_id.";";	
		$result	=Yii::app()->db->createCommand($sql)->queryAll();
		return $result;
		
	}
	
	function getSoDescDetailsById($id=NULL)
	{
		$sql = "select sd.* from so_desc sd where sd.id = ".$id.";";	
		$result	=Yii::app()->db->createCommand($sql)->queryRow();
		return $result;
	}
	
	
	function getProductsForPO($delivery_date)
	{
		/*$sql = "select p.product_name,u.unit_name,p.vendor_id,sum(s.quantity) as totalquantity,p.quantity as inventoryquantity,p.safetyMargin ,s.* from so_desc s, so_details sd, product p,unit u  where s.so_id = sd.so_id and s.product_id = p.product_id and p.unitId = u.unit_id and s.delivery_date = '".date("Y-m-d",strtotime($delivery_date))."' and sd.type != '3' group by s.product_id ";	*/
		//$sql = "select p.product_name,u.unit_name,p.vendor_id,sum(s.quantity) as totalquantity,p.quantity as inventoryquantity,p.safetyMargin ,s.* from so_desc s, so_details sd, product p,unit u  where s.so_id = sd.so_id and s.product_id = p.product_id and p.unitId = u.unit_id and s.delivery_date = '".date("Y-m-d",strtotime($delivery_date))."' group by s.product_id ";
		
		$sql = "select p.product_name,u.unit_name,p.vendor_id,sum(s.quantity) as totalquantity,p.quantity as inventoryquantity,p.safetyMargin ,s.* from so_desc s, so_details sd, product p,unit u  where s.so_id = sd.so_id and s.product_id = p.product_id and p.unitId = u.unit_id and ((s.delivery_date = '".date("Y-m-d",strtotime($delivery_date))."' and sd.type != 2) or (sd.type = 2 and s.delivery_date = '".date("Y-m-d")."'))  group by s.product_id";
		$result	=Yii::app()->db->createCommand($sql)->queryAll();
		return $result;
	}
	
	function getPoDataByProductId($product_id,$delivery_date)
	{
		$sql = "select sum(s.quantity) as totalquantity,p.quantity as inventoryquantity,p.safetyMargin ,s.* from so_desc s, so_details sd, product p,unit u  where s.so_id = sd.so_id and s.product_id = p.product_id and p.unitId = u.unit_id and (s.delivery_date = '".date("Y-m-d",strtotime($delivery_date))."' and sd.type != 3)  and s.product_id = ".$product_id." group by s.product_id ";
		/*$sql = "select sum(s.quantity) as totalquantity,p.quantity as inventoryquantity,p.safetyMargin ,s.* from so_desc s, so_details sd, product p,unit u  where s.so_id = sd.so_id and s.product_id = p.product_id and p.unitId = u.unit_id and s.delivery_date = '".date("Y-m-d",strtotime($delivery_date))."' and s.product_id = ".$product_id." group by s.product_id";*/
		$result	=Yii::app()->db->createCommand($sql)->queryRow();
		return $result;
	}
	
	function getAllProductsByDeliveryDate($delivery_date)
	{
		$sql = "select p.product_name,u.unit_name,p.vendor_id,sum(s.quantity) as totalquantity,p.quantity as inventoryquantity,p.safetyMargin ,s.* from so_desc s,product p,unit u  where s.product_id = p.product_id and p.unitId = u.unit_id and s.delivery_date = '".date("Y-m-d",strtotime($delivery_date))."' group by s.product_id ";	
		$result	=Yii::app()->db->createCommand($sql)->queryAll();
		return $result;
	}
	
	
	function deleteSoDescRecord($id)
	{
		$soDescObj=SoDesc::model()->findByPk($id);
		if(is_object($soDescObj))
		{
			$soDescObj->delete();
		}
		return true;
	}
	
	function deleteSoDescBySoId($id)
	{
		$sql = "delete from so_desc where so_id = ".$id." ;";	
		$result	=Yii::app()->db->createCommand($sql)->query();
		return $result;
	}
	
	function getTotalAmountForSo($so_id)
	{
		$sql = "select sum(packaging_scenario * no_of_packets * product_price) as totalAmount from so_desc where so_id = ".$so_id."";
		$result	=Yii::app()->db->createCommand($sql)->queryScalar();	
		return $result;
		
	}
	
	function getTotalAmountForSoForPos($so_id)
	{
		$sql = "select sum(quantity *  product_price) as totalAmount from so_desc where so_id = ".$so_id."";
		$result	=Yii::app()->db->createCommand($sql)->queryScalar();	
		return $result;
		
	}
	
	function getAllProductsForPackagingList($delivery_date)
	{
		$sql = "select p.product_name,u.unit_id,u.unit_name,p.vendor_id,
		s.product_id,s.packaging_scenario,
		sum(s.no_of_packets) as totalPackets,s.delivery_date 
		from so_desc s,product p,unit u  
		where s.product_id = p.product_id 
		and p.unitId = u.unit_id 
		and s.delivery_date = '".$delivery_date."'
		group by s.product_id, s.packaging_scenario 
		order by p.product_name,s.packaging_scenario asc";	
		$result	=Yii::app()->db->createCommand($sql)->queryAll();
		return $result;
	}
	
	function getSoDescDetailsByShiftId($shift_id)
	{
		$sql = "select u.unit_name, p.product_name,p.product_desc,p.product_price,sd.* from so_desc sd 
				Left Join so_details s On (s.so_id = sd.so_id) 
				Left Join product p On (p.product_id = sd.product_id) 
				Left Join unit u On (u.unit_id = p.unitId)
				where s.shift_id = ".$shift_id.";";	
		$result	=Yii::app()->db->createCommand($sql)->queryAll();
		return $result;
		
	}
	
	function getSoTotal($so_id)
	{
		$sql = "select sum(sd.quantity * sd.product_price) as so_amount from so_desc sd where sd.so_id = '".$so_id."' group by sd.so_id ";	
		$result	=Yii::app()->db->createCommand($sql)->queryScalar();
		return $result;
	}
	
	function getDailyProductReportForPOS($fromDate,$toDate,$order_type)
	{
		
		if(isset($fromDate) && $fromDate != NULL && isset($toDate) && $toDate != NULL)
		{
			
			$dateSearch = " and DATE_FORMAT(s.createdAt,'%Y-%m-%d') >= '".date('Y-m-d',strtotime($fromDate))."' and DATE_FORMAT(s.createdAt,'%Y-%m-%d') <= '".date('Y-m-d',strtotime($toDate))."' ";	
		}
		
		$sql = "select u.unit_name,p.product_name, p.product_id, sum(sd.quantity) as so_quantity, sum(sd.quantity * sd.product_price) as amount, sum(sd.discount_amount) as discount_amount from so_desc sd
Left Join so_details s ON (s.so_id = sd.so_id)
Left Join product p ON (p.product_id = sd.product_id)
Left Join unit u ON (u.unit_id = p.unitId) where s.type = '".$order_type."'
 ".$dateSearch." group by sd.product_id;";
 
		$result	=Yii::app()->db->createCommand($sql)->queryAll();
		return $result;
		
	}
	
	function getDailySalesReportByInvoiceIdForPOS($fromDate,$toDate,$order_type)
	{
		
		if(isset($fromDate) && $fromDate != NULL && isset($toDate) && $toDate != NULL)
		{
			
			$dateSearch = " and DATE_FORMAT(s.createdAt,'%Y-%m-%d') >= '".date('Y-m-d',strtotime($fromDate))."' and DATE_FORMAT(s.createdAt,'%Y-%m-%d') <= '".date('Y-m-d',strtotime($toDate))."' ";	
		}
		
		 $sql = "select sd.so_id, c.customer_name,c.representativeId, c.customer_id,
				sum(sd.quantity * sd.product_price) as so_amount, 
				s.discount_amount as discount_amount from so_desc sd 
				Left Join so_details s ON (s.so_id = sd.so_id)
				Left Join customers c ON (c.customer_id = s.customer_id) 
				where s.type = '".$order_type."' ".$dateSearch."
				group by sd.so_id;";
 
		$result	=Yii::app()->db->createCommand($sql)->queryAll();
		return $result;
		
	}
	
}