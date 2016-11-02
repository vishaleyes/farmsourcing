<?php

/**
 * This is the model class for table "po_desc".
 *
 * The followings are the available columns in table 'po_desc':
 * @property integer $id
 * @property integer $po_id
 * @property integer $product_id
 * @property integer $quantity
 * @property integer $received_quantity
 * @property integer $price
 * @property double $amount
 * @property string $createdAt
 * @property string $modifiedAt
 */
class PoDesc extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PoDesc the static model class
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
		return 'po_desc';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('po_id, product_id, quantity, received_quantity, price', 'numerical', 'integerOnly'=>true),
			array('amount', 'numerical'),
			array('createdAt, modifiedAt', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, po_id, product_id, quantity, received_quantity, price, amount, createdAt, modifiedAt', 'safe', 'on'=>'search'),
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
			'po_id' => 'Po',
			'product_id' => 'Product',
			'quantity' => 'Quantity',
			'received_quantity' => 'Received Quantity',
			'price' => 'Price',
			'amount' => 'Amount',
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
		$criteria->compare('po_id',$this->po_id);
		$criteria->compare('product_id',$this->product_id);
		$criteria->compare('quantity',$this->quantity);
		$criteria->compare('received_quantity',$this->received_quantity);
		$criteria->compare('price',$this->price);
		$criteria->compare('amount',$this->amount);
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
	
	function getPoDescDetails($po_id)
	{
		$sql = "select p.product_name,p.product_desc,pd.* from po_desc pd 
				Left Join product p On (p.product_id = pd.product_id) 
				where pd.po_id = '".$po_id."' ;";	
		
		$result	=Yii::app()->db->createCommand($sql)->queryAll();
		return $result;
		
	}
	
	function getGoodsDescData($po_id)
	{
		
		$sql = "select pd.*,p.product_name from po_desc pd,product p where  pd.product_id = p.product_id and pd.po_id =  ".$po_id."";
		$result	=	Yii::app()->db->createCommand($sql)->queryAll();
		return $result;
	}
	
	function getProductAvgPrice($product_id)
	{
		$sql = "select avg(price) from po_desc where product_id = '".$product_id."' order by id desc limit 7";
		$result	=	Yii::app()->db->createCommand($sql)->queryScalar();
		return $result;
	}
	
	function getDailyProductPurchaseReport($fromDate,$toDate)
	{
		if(isset($fromDate) && $fromDate != NULL && isset($toDate) && $toDate != NULL)
		{
			
			$dateSearch = "where pod.createdAt >= '".date('Y-m-d H:i:s',strtotime($fromDate))."' and pod.createdAt <= '".date('Y-m-d H:i:s',strtotime($toDate))."' ";	
		}
		
		$sql = "select u.unit_name,p.product_id, p.product_name, sum(pod.quantity) as quantity, sum(pod.received_quantity) as received_quantity, sum(pod.accepted_quantity) as accepted_quantity,
sum(pod.amount) as amount from po_desc pod
Left Join product p ON (p.product_id = pod.product_id)
Left Join unit u ON (u.unit_id = p.unitId)
".$dateSearch."
group by pod.product_id;";	
		$result	=Yii::app()->db->createCommand($sql)->queryAll();
		return $result;
		
	}
}