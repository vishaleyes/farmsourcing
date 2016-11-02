<?php

/**
 * This is the model class for table "rejection_desc".
 *
 * The followings are the available columns in table 'rejection_desc':
 * @property integer $id
 * @property integer $rejection_id
 * @property integer $product_id
 * @property integer $quantity
 * @property double $price
 * @property double $total_price
 * @property string $modifiedAt
 * @property string $createdAt
 */
class RejectionDesc extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RejectionDesc the static model class
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
		return 'rejection_desc';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('rejection_id, product_id, quantity', 'numerical', 'integerOnly'=>true),
			array('price, total_price', 'numerical'),
			array('modifiedAt, createdAt', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, rejection_id, product_id, quantity, price, total_price, modifiedAt, createdAt', 'safe', 'on'=>'search'),
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
			'rejection_id' => 'Rejection',
			'product_id' => 'Product',
			'quantity' => 'Quantity',
			'price' => 'Price',
			'total_price' => 'Total Price',
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
		$criteria->compare('rejection_id',$this->rejection_id);
		$criteria->compare('product_id',$this->product_id);
		$criteria->compare('quantity',$this->quantity);
		$criteria->compare('price',$this->price);
		$criteria->compare('total_price',$this->total_price);
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
	
	function getRejectionDescDetails($rejection_id)
	{
		$sql = "select p.product_name,rd.* from rejection_desc rd 
				Left Join product p On (p.product_id = rd.product_id) 
				where rd.rejection_id = ".$rejection_id.";";	
		$result	=Yii::app()->db->createCommand($sql)->queryAll();
		return $result;
		
	}
	
	function getRejectionDescDetailsById($id)
	{
		$sql = "select rd.* from rejection_desc rd 
				where rd.id = ".$id.";";	
		$result	=Yii::app()->db->createCommand($sql)->queryAll();
		return $result;
		
	}
	
	function getDailyRejectionProductWiseData($fromDate,$toDate)
	{
		if(isset($fromDate) && $fromDate != NULL && isset($toDate) && $toDate != NULL)
		{
			
			$dateSearch = "where dd.delivery_date >= '".date('Y-m-d',strtotime($fromDate))."' and dd.delivery_date <= '".date('Y-m-d',strtotime($toDate))."' ";	
		}
		
		$sql = "select u.unit_name, p.product_name, sum(rd.rejected_quantity) as rejected_quantity, sum(rd.amount) as amount from rejection_desc rd
Left Join rejection r ON (r.rejection_id = rd.rejection_id)
Left Join product p ON (p.product_id = rd.product_id)
Left Join delivery_desc dd ON (dd.delivery_id = r.delivery_id)
Left Join unit u ON (u.unit_id = p.unitId)
".$dateSearch." 
group by rd.product_id;";
		$result	=Yii::app()->db->createCommand($sql)->queryAll();
		return $result;	

	}
}