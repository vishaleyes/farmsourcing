<?php

/**
 * This is the model class for table "zone".
 *
 * The followings are the available columns in table 'zone':
 * @property integer $zone_id
 * @property string $zoneName
 * @property integer $admin_id
 * @property integer $status
 * @property string $modifiedAt
 * @property string $createdAt
 */
class Zone extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Zone the static model class
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
		return 'zone';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		/*return array(
			array('admin_id, status', 'numerical', 'integerOnly'=>true),
			array('zoneName', 'length', 'max'=>255),
			array('modifiedAt, createdAt', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('zone_id, zoneName, admin_id, status, modifiedAt, createdAt', 'safe', 'on'=>'search'),
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
			'zone_id' => 'Zone',
			'zoneName' => 'Zone Name',
			'admin_id' => 'Admin',
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

		$criteria->compare('zone_id',$this->zone_id);
		$criteria->compare('zoneName',$this->zoneName,true);
		$criteria->compare('admin_id',$this->admin_id);
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
	
	function getAllZones()
	{
		$sql = "select z.* from zone z order by zone_id desc;";	
		$result	=Yii::app()->db->createCommand($sql)->queryAll();
		return $result;
	}
	
	function getZoneById($id)
	{
		$result	=	Yii::app()->db->createCommand()
					->select('*')
					->from($this->tableName())
					->where('zone_id=:zone_id', array(':zone_id'=>$id))
					->queryRow();
		
		return $result;
	}
	
	function deleteZone($id)
	{
		$zoneObj=Zone::model()->findbyPk($id);
		$zoneObj->delete();		
		
		return true;
	}
	
	function checkZoneName($zoneName)
	{
		$sql = "select zone_id from zone where zoneName = '".$zoneName."';";	
		$result	=Yii::app()->db->createCommand($sql)->queryScalar();
		return $result;
	}
}