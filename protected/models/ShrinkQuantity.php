<?php

/**
 * This is the model class for table "shrink_quantity".
 *
 * The followings are the available columns in table 'shrink_quantity':
 * @property integer $id
 * @property integer $admin_id
 * @property integer $product_id
 * @property integer $system_qnt
 * @property integer $actual_qnt
 * @property integer $qnt_difference
 * @property string $createdAt
 * @property string $modifiedAt
 */
class ShrinkQuantity extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ShrinkQuantity the static model class
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
		return 'shrink_quantity';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		/*return array(
			array('admin_id, product_id, system_qnt, actual_qnt, qnt_difference', 'numerical', 'integerOnly'=>true),
			array('createdAt, modifiedAt', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, admin_id, product_id, system_qnt, actual_qnt, qnt_difference, createdAt, modifiedAt', 'safe', 'on'=>'search'),
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
			'admin_id' => 'Admin',
			'product_id' => 'Product',
			'system_qnt' => 'System Qnt',
			'actual_qnt' => 'Actual Qnt',
			'qnt_difference' => 'Qnt Difference',
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
		$criteria->compare('admin_id',$this->admin_id);
		$criteria->compare('product_id',$this->product_id);
		$criteria->compare('system_qnt',$this->system_qnt);
		$criteria->compare('actual_qnt',$this->actual_qnt);
		$criteria->compare('qnt_difference',$this->qnt_difference);
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
	
	function getAllDataWithDetail()
	{
		$sql = "select p.product_name, s.* from shrink_quantity s
Left Join product p ON (p.product_id = s.product_id)";	
		$result	=Yii::app()->db->createCommand($sql)->queryAll();
		return $result;
	}
	
	function deleteShrink($id)
	{
		$shrinkObj=ShrinkQuantity::model()->findByPk($id);
		if(is_object($shrinkObj))
		{
			$shrinkObj->delete();
		}
		return true;
	}
}