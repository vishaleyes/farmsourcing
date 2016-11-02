<?php

/**
 * This is the model class for table "vault".
 *
 * The followings are the available columns in table 'vault':
 * @property integer $vault_id
 * @property integer $cashier_id
 * @property string $amount
 * @property string $time
 * @property string $date
 */
class Vault extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Vault the static model class
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
		return 'vault';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			/*array('cashier_id, amount, time, date', 'required'),
			array('cashier_id', 'numerical', 'integerOnly'=>true),
			array('amount', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('vault_id, cashier_id, amount, time, date', 'safe', 'on'=>'search'),*/
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
			'vault_id' => 'Vault',
			'cashier_id' => 'Cashier',
			'amount' => 'Amount',
			'time' => 'Time',
			'date' => 'Date',
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

		$criteria->compare('vault_id',$this->vault_id);
		$criteria->compare('cashier_id',$this->cashier_id);
		$criteria->compare('amount',$this->amount,true);
		$criteria->compare('time',$this->time,true);
		$criteria->compare('date',$this->date,true);

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
	
	function getVaultDetails($shift_id)
	{
		
		$sql = "select sum(withdraw) as withdraw,sum(deposite) as deposite from vault where cashier_id = ".Yii::app()->session['farmsourcing_posUser']." and date = '".date("Y-m-d")."' and shift_id = ".$shift_id."";
		$result	=	Yii::app()->db->createCommand($sql)->queryRow();	
		return $result;
	}
}