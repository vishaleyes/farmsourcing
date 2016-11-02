<?php

/**
 * This is the model class for table "shift".
 *
 * The followings are the available columns in table 'shift':
 * @property integer $shift_id
 * @property integer $cashier_id
 * @property string $cash_in
 * @property string $cash_out
 * @property string $time_in
 * @property string $time_out
 */
class Shift extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Shift the static model class
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
		return 'shift';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			/*array('cashier_id, cash_in, cash_out, time_in, time_out', 'required'),
			array('cashier_id', 'numerical', 'integerOnly'=>true),
			array('cash_in, cash_out', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('shift_id, cashier_id, cash_in, cash_out, time_in, time_out', 'safe', 'on'=>'search'),*/
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
			'shift_id' => 'Shift',
			'cashier_id' => 'Cahsier',
			'cash_in' => 'Cash In',
			'cash_out' => 'Cash Out',
			'time_in' => 'Time In',
			'time_out' => 'Time Out',
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

		$criteria->compare('shift_id',$this->shift_id);
		$criteria->compare('cashier_id',$this->cashier_id);
		$criteria->compare('cash_in',$this->cash_in,true);
		$criteria->compare('cash_out',$this->cash_out,true);
		$criteria->compare('time_in',$this->time_in,true);
		$criteria->compare('time_out',$this->time_out,true);

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
	
	function getLastShiftId()
	{
		$sql = "select max(shift_id) as shift_id from shift  limit 1";
		$result	=	Yii::app()->db->createCommand($sql)->queryRow();	
		return $result;
	}
	
	function getShiftSummary()
	{
		$sql = "select * from shift where shift_id = '".Yii::app()->session['shiftId']."' ; ";
		$result	=	Yii::app()->db->createCommand($sql)->queryRow();	
		return $result;
	}
	
	public function getPaginatedshiftList($limit=10,$sortType="desc",$sortBy="invoiceNo",$keyword=NULL,$searchFrom=NULL,$searchTo=NULL,$startdate=NULL,$enddate=NULL,$todayDate=NULL)
	{
		$criteria = new CDbCriteria();
		$keyword = mysql_real_escape_string($keyword);
		
		
		if(isset($keyword) && $keyword != NULL )
		{
			$search = " and (users.firstName like '%".$keyword."%' or stores.store_name like '%".$keyword."%' or shift.fileName like '%".$keyword."%' )";	
		}
		else
		{
			$search = " ";
		}
		
		
		
		if(isset($startdate) && $startdate != NULL && isset($enddate) && $enddate != NULL)
		{
			$dateSearch = " and shift.time_in >= '".date('Y-m-d:H-m-s',strtotime($startdate))."' and shift.time_in <= '".date('Y-m-d:H-m-s',strtotime($enddate))."' ";	
		}else{
			$dateSearch = " ";
		}
		
			$sql_users = "select shift.* , users.firstName , stores.store_name,  (select sum(total_amount) from ticket_details where shift_id = shift.shift_id) as totalsales from shift Left Join users ON (users.id = shift.cashier_id) Left Join stores ON (users.store_id = stores.store_id)   WHERE shift.admin_id =  ".Yii::app()->session['adminUser']." ".$search." ".$dateSearch." order by ".$sortBy." ".$sortType."";
			
			$sql_count = "select count(*)  from shift Left Join users ON (users.id = shift.cashier_id) Left Join stores ON (users.store_id = stores.store_id)   WHERE shift.admin_id =  ".Yii::app()->session['adminUser']." ".$search." ".$dateSearch." order by ".$sortBy." ".$sortType."";
		
		$count	=	Yii::app()->db->createCommand($sql_count)->queryScalar();
		
		$item	=	new CSqlDataProvider($sql_users, array(
						'totalItemCount'=>$count,
						'pagination'=>array(
							'pageSize'=>'10',
						),
					));
		$index = 0;	
		return array('pagination'=>$item->pagination, 'shift'=>$item->getData());
		
	}
}