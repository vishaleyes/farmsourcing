<?php

/**
 * This is the model class for table "delivery_order_desc".
 *
 * The followings are the available columns in table 'delivery_order_desc':
 * @property integer $id
 * @property integer $delivery_desc_id
 * @property integer $so_id
 * @property integer $product_id
 * @property integer $so_quantity
 * @property integer $sale_quantity
 * @property integer $no_of_packets
 * @property integer $packaging_scenario
 * @property double $price
 * @property double $amount
 * @property integer $status
 * @property string $modifiedAt
 * @property string $createdAt
 */
class DeliveryOrderDesc extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return DeliveryOrderDesc the static model class
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
		return 'delivery_order_desc';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		/*return array(
			array('delivery_desc_id, so_id, product_id, so_quantity, sale_quantity, no_of_packets, packaging_scenario, status', 'numerical', 'integerOnly'=>true),
			array('price, amount', 'numerical'),
			array('modifiedAt, createdAt', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, delivery_desc_id, so_id, product_id, so_quantity, sale_quantity, no_of_packets, packaging_scenario, price, amount, status, modifiedAt, createdAt', 'safe', 'on'=>'search'),
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
			'delivery_desc_id' => 'Delivery Desc',
			'so_id' => 'So',
			'product_id' => 'Product',
			'so_quantity' => 'So Quantity',
			'sale_quantity' => 'Sale Quantity',
			'no_of_packets' => 'No Of Packets',
			'packaging_scenario' => 'Packaging Scenario',
			'price' => 'Price',
			'amount' => 'Amount',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('delivery_desc_id',$this->delivery_desc_id);
		$criteria->compare('so_id',$this->so_id);
		$criteria->compare('product_id',$this->product_id);
		$criteria->compare('so_quantity',$this->so_quantity);
		$criteria->compare('sale_quantity',$this->sale_quantity);
		$criteria->compare('no_of_packets',$this->no_of_packets);
		$criteria->compare('packaging_scenario',$this->packaging_scenario);
		$criteria->compare('price',$this->price);
		$criteria->compare('amount',$this->amount);
		$criteria->compare('status',$this->status);
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
	
	function getDeliveryDescDetails($so_id)
	{
		$sql = "select p.product_name,p.product_desc,p.product_price,dod.* from delivery_order_desc dod 
				Left Join delivery_desc dd On (dd.id = dod.delivery_desc_id) 
				Left Join product p On (p.product_id = dod.product_id) 
				where dod.so_id = ".$so_id.";";	
		$result	=Yii::app()->db->createCommand($sql)->queryAll();
		return $result;
		
	}
	
	
	function getDeliveryDescData($id)
	{
		$sql = "select dod.* from delivery_order_desc dod 				
				where dod.delivery_desc_id = ".$id.";";	
		$result	=Yii::app()->db->createCommand($sql)->queryAll();
		return $result;
		
	}
	
	function getDailyProductReport($fromDate,$toDate,$order_type=NULL)
	{
		$typeArray = explode(',',$order_type);
		
		if(!empty($typeArray))
		{
			$i = 0;
			$searchType = " ( ";
			foreach($typeArray as $type)
			{	
				if($i == 0)
				{
					$searchType .= " dd.type = ".$type ;	
				}else{
					$searchType .= " OR dd.type = ".$type ;
				}
				$i++;
			}
			
			$searchType .= " ) ";
		}else{
			$searchType = " ";
		}
		
		if(isset($fromDate) && $fromDate != NULL && isset($toDate) && $toDate != NULL)
		{
			
			$dateSearch = " and dd.delivery_date BETWEEN '".date('Y-m-d',strtotime($fromDate))."' and '".date('Y-m-d',strtotime($toDate))."' ";
			
			
		}
		
		$sql = "select u.unit_name,p.product_name, p.product_id, sum(dod.no_of_packets) as no_of_packets, sum(dod.so_quantity) as so_quantity, sum(dod.amount) as amount, sum(dod.discount_amount) as discount_amount from delivery_order_desc dod
Left Join delivery_desc dd ON (dd.id = dod.delivery_desc_id)
Left Join product p ON (p.product_id = dod.product_id)
Left Join unit u ON (u.unit_id = p.unitId) where ".$searchType."
 ".$dateSearch." 
group by dod.product_id order by p.product_name asc;";
		$result	=Yii::app()->db->createCommand($sql)->queryAll();
		return $result;
		
	}
}