<?php

/**
 * This is the model class for table "delivery_details".
 *
 * The followings are the available columns in table 'delivery_details':
 * @property integer $delivery_id
 * @property integer $admin_id
 * @property integer $driver_id
 * @property double $cash_amount
 * @property double $coupon_amount
 * @property string $createdAt
 * @property string $modifiedAt
 */
class DeliveryDetails extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return DeliveryDetails the static model class
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
		return 'delivery_details';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		/*return array(
			array('admin_id, driver_id', 'numerical', 'integerOnly'=>true),
			array('cash_amount, coupon_amount', 'numerical'),
			array('createdAt, modifiedAt', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('delivery_id, admin_id, driver_id, cash_amount, coupon_amount, createdAt, modifiedAt', 'safe', 'on'=>'search'),
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
			'delivery_id' => 'Delivery',
			'admin_id' => 'Admin',
			'driver_id' => 'Driver',
			'cash_amount' => 'Cash Amount',
			'coupon_amount' => 'Coupon Amount',
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

		$criteria->compare('delivery_id',$this->delivery_id);
		$criteria->compare('admin_id',$this->admin_id);
		$criteria->compare('driver_id',$this->driver_id);
		$criteria->compare('cash_amount',$this->cash_amount);
		$criteria->compare('coupon_amount',$this->coupon_amount);
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
	
	function getDriverListFromDeliveryData($delivery_date)
	{
		$sql = "select a.firstName, a.lastName, d.* from delivery_details d 
				Left Join admin a ON (a.id = d.driver_id)
				where a.type = 2 and d.delivery_date = '".$delivery_date."';";	
		$result	=Yii::app()->db->createCommand($sql)->queryAll();
		return $result;
	}
	
	function getDeliveryList($delivery_date,$driver_id)
	{
		$bool=false;
		if(!empty($delivery_date) && $delivery_date != '')
		{
			$delivery_date = date("Y-m-d",strtotime($delivery_date));
			$filter1 = "where d.delivery_date = '".$delivery_date."'";
			$bool =  true;
		}else{
			$filter1 = "";
		}
		
		if(!empty($driver_id) && $driver_id != '')
		{
			if($bool == true)
			{
				$filter2 = " and d.driver_id = '".$driver_id."'";
			}
			else
			{
				$filter2 = "where d.driver_id = '".$driver_id."'";
			}
		}else{
			$filter2 = "";
		}
		
		$sql = "select CONCAT(COALESCE(a.firstName,''),' ',COALESCE(a.lastName,'')) as driverName,d.driver_id, c.customer_name, c.representativeId, CONCAT(COALESCE(c.block,''), COALESCE(c.house_no,''),', ',COALESCE(c.building_name,''),', ',COALESCE(c.landmark1,''),', ',COALESCE(c.landmark2,''),', ',COALESCE(c.area,'')) as address, des.*  from delivery_desc des
Left Join delivery_details d ON(des.delivery_id = d.delivery_id)
Left Join customers c ON(c.customer_id = des.customer_id)
Left Join admin a ON (a.id = d.driver_id) ".$filter1." ".$filter2." order by des.id desc";	
		$result	=Yii::app()->db->createCommand($sql)->queryAll();
		return $result;
	}
	
	
	function getDeliveryListForPdf($delivery_date,$driver_id)
	{
		$bool=false;
		if(!empty($delivery_date) && $delivery_date != '')
		{
			$delivery_date = date("Y-m-d",strtotime($delivery_date));
			$filter1 = "where des.delivery_date = '".$delivery_date."'";
			$bool =  true;
		}
		if(!empty($driver_id) && $driver_id != '')
		{
			if($bool == true)
			{
				$filter2 = " and d.driver_id = '".$driver_id."'";
			}
			else
			{
				$filter2 = "where d.driver_id = '".$driver_id."'";
			}
		}
		 $sql = "select z.zoneName,CONCAT(COALESCE(a.firstName,''),' ',COALESCE(a.lastName,'')) as driverName,d.driver_id, c.customer_name, c.representativeId, c.mobile_no, CONCAT(COALESCE(c.block,''), COALESCE(c.house_no,''),', ',COALESCE(c.building_name,''),', ',COALESCE(c.landmark1,''),', ',COALESCE(c.landmark2,''),', ',COALESCE(c.area,'')) as address, des.*  from delivery_desc des
Left Join delivery_details d ON(des.delivery_id = d.delivery_id)
Left Join customers c ON(c.customer_id = des.customer_id)
Left Join admin a ON (a.id = d.driver_id)
Left Join zone z ON (z.zone_id = des.zone_id) 
".$filter1." ".$filter2." ORDER BY c.country ASC,  c.city ASC, z.zoneName ASC, c.area ASC,  c.building_name ASC, c.house_no ASC, c.block ASC";	
		$result	=Yii::app()->db->createCommand($sql)->queryAll();
		
		return $result;
	}
	
	
	function getDriverWiseDeliveryList($delivery_date,$driver_id)
	{
		$bool=false;
		if(!empty($delivery_date) && $delivery_date != '')
		{
			$delivery_date = date("Y-m-d",strtotime($delivery_date));
			$filter1 = "where dd.delivery_date = '".$delivery_date."'";
			$bool =  true;
		}else{
			$filter1 = "";
		}
		
		if(!empty($driver_id) && $driver_id != '')
		{
			if($bool == true)
			{
				$filter2 = " and dd.driver_id = '".$driver_id."'";
			}
			else
			{
				$filter2 = "where dd.driver_id = '".$driver_id."'";
			}
		}else{
			$filter2 = "";
		}
		
		 $sql = "select CONCAT(COALESCE(a.firstName,''),' ',COALESCE(a.lastName,'')) as driverName, dd.* from delivery_details dd 
Left Join admin a ON  ( a.id = dd.driver_id ) ".$filter1." ".$filter2." order by dd.delivery_id desc";	
		$result	=Yii::app()->db->createCommand($sql)->queryAll();
		
		return $result;
	}
	
	function deleteOldDeliveryData($delivery_date)
	{
		
		$sql1 = "delete from delivery_details where delivery_date = '".$delivery_date."'" ;
		$count	=	Yii::app()->db->createCommand($sql1)->execute();
		
		$sql2 = "Delete dd.*, dod.* from delivery_desc dd
						Left Join delivery_order_desc dod  On(dd.id = dod.delivery_desc_id) 
						where dd.delivery_date = '".$delivery_date."' ;";

		$count	=	Yii::app()->db->createCommand($sql2)->execute();
		
	}
	
}