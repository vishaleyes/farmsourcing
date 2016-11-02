<?php

/**
 * This is the model class for table "po_details".
 *
 * The followings are the available columns in table 'po_details':
 * @property integer $po_id
 * @property integer $vendor_id
 * @property double $total_amount
 * @property integer $admin_id
 * @property integer $status
 * @property string $delivery_date
 * @property string $modifiedAt
 * @property string $createdAt
 */
class PoDetails extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PoDetails the static model class
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
		return 'po_details';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('vendor_id, admin_id, status', 'numerical', 'integerOnly'=>true),
			array('total_amount', 'numerical'),
			array('delivery_date, modifiedAt, createdAt', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('po_id, vendor_id, total_amount, admin_id, status, delivery_date, modifiedAt, createdAt', 'safe', 'on'=>'search'),
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
			'po_id' => 'Po',
			'vendor_id' => 'Vendor',
			'total_amount' => 'Total Amount',
			'admin_id' => 'Admin',
			'status' => 'Status',
			'delivery_date' => 'Delivery Date',
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

		$criteria->compare('po_id',$this->po_id);
		$criteria->compare('vendor_id',$this->vendor_id);
		$criteria->compare('total_amount',$this->total_amount);
		$criteria->compare('admin_id',$this->admin_id);
		$criteria->compare('status',$this->status);
		$criteria->compare('delivery_date',$this->delivery_date,true);
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
	
	function getPoDataByDeliveryDate($delivery_date=NULL)
	{
		$sql = "select * from po_details where delivery_date = '".date("Y-m-d",strtotime($delivery_date))."';";	
		$result	=Yii::app()->db->createCommand($sql)->queryRow();
		return $result;
	}
	
	function getpurchaseOrderListing()
	{
		$sql = "select a.firstName as createBy, v.vendor_name, po.* from po_details po
				Left Join vendor v ON  ( v.vendor_id = po.vendor_id ) 
				Left Join admin a ON  ( a.id = po.admin_id )
				order by po.po_id desc ;";	
		$result	=Yii::app()->db->createCommand($sql)->queryAll();
		return $result;
	}
	
	function getpurchaseOrderDataById($po_id=NULL)
	{
		$sql = "select a.firstName as createBy, v.vendor_name, po.* from po_details po
				Left Join vendor v ON  ( v.vendor_id = po.vendor_id ) 
				Left Join admin a ON  ( a.id = po.admin_id )
				where po.po_id = ".$po_id.";";
		$result	=Yii::app()->db->createCommand($sql)->queryRow();
		return $result;
	}

	function getAllPO()
	{
		$result = Yii::app()->db->createCommand()
		->select("*")
		->from($this->tableName())
		->queryAll();
		
		return $result;
	}
	
	function getAllPendingPO()
	{
		$result = Yii::app()->db->createCommand()
		->select("*")
		->where('status=:status', array(':status'=>0))
		->from($this->tableName())
		->queryAll();
		
		return $result;
	}
	
	function getDailyVendorPurchaseReport($fromDate,$toDate)
	{
		if(isset($fromDate) && $fromDate != NULL && isset($toDate) && $toDate != NULL)
		{
			
			$dateSearch = "where po.createdAt >= '".date('Y-m-d H:i:s',strtotime($fromDate))."' and po.createdAt <= '".date('Y-m-d H:i:s',strtotime($toDate))."' ";	
		}
		
		$sql = "select v.vendor_id, v.vendor_name, sum(total_amount) as total_amount from po_details po
Left Join vendor v ON (v.vendor_id = po.vendor_id)
".$dateSearch."
group by po.vendor_id; ";	
		$result	=Yii::app()->db->createCommand($sql)->queryAll();
		return $result;
		
	}
}