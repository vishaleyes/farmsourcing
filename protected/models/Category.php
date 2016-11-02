<?php

/**
 * This is the model class for table "category".
 *
 * The followings are the available columns in table 'category':
 * @property integer $cat_id
 * @property string $category_name
 * @property string $modified
 * @property string $created
 */
class Category extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Category the static model class
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
		return 'category';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		/*return array(
			array('category_name, modified, created', 'required'),
			array('category_name', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('cat_id, category_name, modified, created', 'safe', 'on'=>'search'),
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
			'cat_id' => 'Cat',
			'category_name' => 'Category Name',
			'modified' => 'Modified',
			'created' => 'Created',
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

		$criteria->compare('cat_id',$this->cat_id);
		$criteria->compare('category_name',$this->category_name,true);
		$criteria->compare('modified',$this->modified,true);
		$criteria->compare('created',$this->created,true);

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
	
		
	public function getAllPaginatedCategory($sortType="asc",$sortBy="c.category_name",$keyword=NULL)
	{
		$criteria = new CDbCriteria();
		$search = '';
		$dateSearch = '';
		$keyword = mysql_real_escape_string($keyword);
		if(isset($keyword) && $keyword != NULL )
		{
			$search = " where (c.category_name like '%".$keyword."%')";	
		}
		
		$sql_users = "select * from category c ".$search." order by ".$sortBy." ".$sortType."";
	 
		 $sql_count = "select count(*) from category c ".$search." order by ".$sortBy." ".$sortType."";
		
		$count	=	Yii::app()->db->createCommand($sql_count)->queryScalar();
		
		$item	=	new CSqlDataProvider($sql_users, array(
						'totalItemCount'=>$count,
						'pagination'=>array(
							'pageSize'=>'10',
						),
					));
		$index = 0;	
		
		return array('pagination'=>$item->pagination, 'category'=>$item->getData());
		
	}
	
	function deleteCategory($id)
	{
		$categoryObj=Category::model()->findByPk($id);
		if(is_object($categoryObj))
		{
			$categoryObj->delete();
		}
	}
	
	function getCategoryDetail($id)
	{
		$sql = "select c.*,v.vendor_name,u.unit_name from category c
Left Join vendor v ON (c.vendor_id = v.vendor_id)
Left Join unit u ON (c.unit_id = u.unit_id)
where c.cat_id = ".$id.";";	
		$result	=Yii::app()->db->createCommand($sql)->queryRow();
		return $result;
	}
	
	function getAllCategoryList()
	{
		$sql = "select * from category order by cat_id desc ";	
		$result	=Yii::app()->db->createCommand($sql)->queryAll();
		return $result;
	}
	
	function getAllCategoryListASC()
	{
		$sql = "select * from category order by category_name asc limit 6 ";	
		$result	=Yii::app()->db->createCommand($sql)->queryAll();
		return $result;
	}
	
	function getClientCategoryList($id=NULL)
	{
		$result =array();
		if($id!='')
		{
			$condition='admin_id=:admin_id';
			$params=array(':admin_id'=>$id);
			
			$result = Yii::app()->db->createCommand()
			->select('*')
			->from($this->tableName())
			->where($condition,$params)
			->queryAll();
		}
		return $result;
		
	}
	
	public function getAllPaginatedCategoryforAjax($limit=5,$sortType="asc",$sortBy="category_name",$keyword=NULL,$admin_id,$startDate=NULL,$endDate=NULL)
	{
		
		$criteria = new CDbCriteria();
		$search = '';
		$dateSearch = '';
		$keyword = mysql_real_escape_string($keyword);
		if(isset($keyword) && $keyword != NULL )
		{
			$search = " and (category_name like '%".$keyword."%')";	
		}
		
		 $sql_users = "select * from category where admin_id = ".$admin_id." ".$search." order by ".$sortBy." ".$sortType."";
			$sql_count = "select count(*) from category where admin_id = ".$admin_id." ".$search." order by ".$sortBy." ".$sortType."";
		
		$count	=	Yii::app()->db->createCommand($sql_count)->queryScalar();
		
		$item	=	new CSqlDataProvider($sql_users, array(
						'totalItemCount'=>$count,
						'pagination'=>array(
							'pageSize'=>$count,
						),
					));
		$index = 0;	
		return array('pagination'=>$item->pagination, 'category'=>$item->getData());
	}
	
	function checkCategoryName($category_name)
	{
		$sql = "select cat_id from category where category_name = '".$category_name."';";	
		$result	=Yii::app()->db->createCommand($sql)->queryScalar();
		return $result;
	}
	
	function getUnitForCategory($cat_id)
	{
		$sql = "select unit_name from category c, unit u where c.unit_id = u.unit_id and c.cat_id = ".$cat_id."";	
		$result	=Yii::app()->db->createCommand($sql)->queryScalar();
		return $result;
	}
	
	
	
}