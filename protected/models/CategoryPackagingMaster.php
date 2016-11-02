<?php

/**
 * This is the model class for table "category_packaging_master".
 *
 * The followings are the available columns in table 'category_packaging_master':
 * @property integer $id
 * @property integer $category_id
 * @property integer $pakaging_type
 * @property string $packaging_scenario
 * @property string $modifiedAt
 * @property string $createdAt
 */
class CategoryPackagingMaster extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CategoryPackagingMaster the static model class
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
		return 'category_packaging_master';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('category_id, pakaging_type', 'numerical', 'integerOnly'=>true),
			array('packaging_scenario', 'length', 'max'=>50),
			array('modifiedAt, createdAt', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, category_id, pakaging_type, packaging_scenario, modifiedAt, createdAt', 'safe', 'on'=>'search'),
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
			'category_id' => 'Category',
			'pakaging_type' => 'Pakaging Type',
			'packaging_scenario' => 'Packaging Scenario',
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
		$criteria->compare('category_id',$this->category_id);
		$criteria->compare('pakaging_type',$this->pakaging_type);
		$criteria->compare('packaging_scenario',$this->packaging_scenario,true);
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
	
	function getAllCategoryPackaging()
	{
		$sql = "select c.category_name,cm.* from category_packaging_master cm, category c where cm.category_id = c.cat_id;";	
		$result	=Yii::app()->db->createCommand($sql)->queryAll();
		return $result;
	}
	
	function getAllCategoryPackagingByUnit()
	{
		$sql = "select u.unit_name, cpm.* from category_packaging_master cpm 
Left Join unit u On (u.unit_id = cpm.pakaging_type);";	
		$result	=Yii::app()->db->createCommand($sql)->queryAll();
		return $result;
	}
	
	function getCategoryPackageDetailsOld($id)
	{
		$sql = "select c.category_name,cm.* from category_packaging_master cm, category c where cm.category_id = c.cat_id and cm.id = ".$id." ;";	
		$result	=Yii::app()->db->createCommand($sql)->queryRow();
		
		return $result;
	}
	
	function getCategoryPackageDetails($id)
	{
		$sql = "select u.unit_name, cpm.* from category_packaging_master cpm 
Left Join unit u On (u.unit_id = cpm.pakaging_type) where cpm.id = ".$id." ;";	
		$result	=Yii::app()->db->createCommand($sql)->queryRow();
		
		return $result;
	}
	
	function deleteCategoryPackagingMaster($id)
	{
		$categoryObj=CategoryPackagingMaster::model()->findByPk($id);
		if(is_object($categoryObj))
		{
			$categoryObj->delete();
		}
		return true;
	}
	
	function getAllPackageScenarioByCatIdOld($id)
	{
		$sql = "select cpm.* from category_packaging_master cpm
Left Join category c ON (c.cat_id = cpm.category_id)
Left Join product p ON (p.cat_id = c.cat_id)
where p.product_id = ".$id." ;";	
		$result	=Yii::app()->db->createCommand($sql)->queryAll();
		return $result;
	}
	
	function getAllPackageScenarioByCatId($id)
	{
		$sql = "select cpm.* from category_packaging_master cpm
Left Join product p ON (p.unitId = cpm.pakaging_type)
where p.product_id = ".$id." ;";	
		$result	=Yii::app()->db->createCommand($sql)->queryAll();
		return $result;
	}
	
	function getAllPackagingList()
	{
		$sql = "select * from category_packaging_master order by pakaging_type,packaging_scenario asc;";	
		$result	=Yii::app()->db->createCommand($sql)->queryAll();
		return $result;
	}
}