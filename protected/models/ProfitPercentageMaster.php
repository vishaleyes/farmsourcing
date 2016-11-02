<?php

/**
 * This is the model class for table "profit_percentage_master".
 *
 * The followings are the available columns in table 'profit_percentage_master':
 * @property integer $id
 * @property integer $product_id
 * @property double $profit_percentage
 * @property string $from_date
 * @property string $to_date
 * @property integer $status
 * @property string $modifiedAt
 * @property string $createdAt
 */
class ProfitPercentageMaster extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ProfitPercentageMaster the static model class
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
		return 'profit_percentage_master';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('product_id, status', 'numerical', 'integerOnly'=>true),
			array('profit_percentage', 'numerical'),
			array('from_date, to_date, modifiedAt, createdAt', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, product_id, profit_percentage, from_date, to_date, status, modifiedAt, createdAt', 'safe', 'on'=>'search'),
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
			'product_id' => 'Product',
			'profit_percentage' => 'Profit Percentage',
			'from_date' => 'From Date',
			'to_date' => 'To Date',
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
		$criteria->compare('product_id',$this->product_id);
		$criteria->compare('profit_percentage',$this->profit_percentage);
		$criteria->compare('from_date',$this->from_date,true);
		$criteria->compare('to_date',$this->to_date,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('modifiedAt',$this->modifiedAt,true);
		$criteria->compare('createdAt',$this->createdAt,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
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
	
	function getAllProfitPercentage()
	{
		$sql = "select * from profit_percentage_master";
		$result	=	Yii::app()->db->createCommand($sql)->queryAll();
		return $result;
	}
	
	function getProductProfit($product_id)
	{
		$sql = "select profit_percentage from profit_percentage_master where product_id = '".$product_id."' and from_date <= '".date("Y-m-d")."' and to_date >= '".date("Y-m-d")."'";
		$result	=	Yii::app()->db->createCommand($sql)->queryScalar();
		return $result;
	}
	
	
	function getProductProfitById($id)
	{
		$sql = "select * from profit_percentage_master  where id = ".$id."";
		$result	=	Yii::app()->db->createCommand($sql)->queryRow();
		return $result;
	}
	
	function deleteProfitPercentage($id)
	{
		$profitObj=ProfitPercentageMaster::model()->findByPk($id);
		if(is_object($profitObj))
		{
			$profitObj->delete();
		}
	}
	
	

}