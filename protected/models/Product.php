<?php

/**
 * This is the model class for table "product".
 *
 * The followings are the available columns in table 'product':
 * @property integer $product_id
 * @property string $store_id
 * @property string $product_name
 * @property string $product_desc
 * @property string $product_image
 * @property string $product_discount
 * @property string $product_price
 * @property string $product_price2
 * @property string $product_price3
 * @property string $unitname
 * @property string $upc_code
 * @property integer $quantity
 * @property string $manufacturing_date
 * @property string $expiry_date
 * @property integer $cat_id
 * @property integer $admin_id
 * @property string $created_date
 * @property string $modified_date
 * @property string $status
 */
class Product extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Product the static model class
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
		return 'product';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		/*return array(
			array('quantity, cat_id, admin_id', 'numerical', 'integerOnly'=>true),
			array('store_id, product_name, product_desc, product_image, product_price, product_price2, product_price3, upc_code', 'length', 'max'=>255),
			array('product_discount, unitname', 'length', 'max'=>50),
			array('status', 'length', 'max'=>1),
			array('manufacturing_date, expiry_date, created_date, modified_date', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('product_id, store_id, product_name, product_desc, product_image, product_discount, product_price, product_price2, product_price3, unitname, upc_code, quantity, manufacturing_date, expiry_date, cat_id, admin_id, created_date, modified_date, status', 'safe', 'on'=>'search'),
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
			'product_id' => 'Product',
			'store_id' => 'Store',
			'product_name' => 'Product Name',
			'product_desc' => 'Product Desc',
			'product_image' => 'Product Image',
			'product_discount' => 'Product Discount',
			'product_price' => 'Product Price',
			'product_price2' => 'Product Price2',
			'product_price3' => 'Product Price3',
			'unitname' => 'Unitname',
			'upc_code' => 'Upc Code',
			'quantity' => 'Quantity',
			'manufacturing_date' => 'Manufacturing Date',
			'expiry_date' => 'Expiry Date',
			'cat_id' => 'Cat',
			'admin_id' => 'Admin',
			'created_date' => 'Created Date',
			'modified_date' => 'Modified Date',
			'status' => 'Status',
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

		$criteria->compare('product_id',$this->product_id);
		$criteria->compare('store_id',$this->store_id,true);
		$criteria->compare('product_name',$this->product_name,true);
		$criteria->compare('product_desc',$this->product_desc,true);
		$criteria->compare('product_image',$this->product_image,true);
		$criteria->compare('product_discount',$this->product_discount,true);
		$criteria->compare('product_price',$this->product_price,true);
		$criteria->compare('product_price2',$this->product_price2,true);
		$criteria->compare('product_price3',$this->product_price3,true);
		$criteria->compare('unitname',$this->unitname,true);
		$criteria->compare('upc_code',$this->upc_code,true);
		$criteria->compare('quantity',$this->quantity);
		$criteria->compare('manufacturing_date',$this->manufacturing_date,true);
		$criteria->compare('expiry_date',$this->expiry_date,true);
		$criteria->compare('cat_id',$this->cat_id);
		$criteria->compare('admin_id',$this->admin_id);
		$criteria->compare('created_date',$this->created_date,true);
		$criteria->compare('modified_date',$this->modified_date,true);
		$criteria->compare('status',$this->status,true);

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
	
	function getAllProducts()
	{
		$sql = "select c.category_name, c.is_discount as cat_is_discount, c.discount as cat_discount,
		 		c.discount_from as cat_discount_from, c.discount_to as cat_discount_to, 
				c.discount_desc as cat_discount_desc, 
		 		v.vendor_name,u.unit_name, p.* from product p 
				Left Join category c On (c.cat_id = p.cat_id) 
				Left Join vendor v On (v.vendor_id = p.vendor_id) 
				Left Join unit u On (u.unit_id = p.unitId) where p.status = 1 
				order by  p.product_name asc ;";
					
		$result	=Yii::app()->db->createCommand($sql)->queryAll();
		return $result;
	}
	
	function getAllProductsForMasterListing()
	{
		$sql = "select c.category_name, v.vendor_name, p.* from product p 
				Left Join category c On (c.cat_id = p.cat_id) 
				Left Join vendor v On (v.vendor_id = p.vendor_id) order by product_name asc;";
					
		$result	=Yii::app()->db->createCommand($sql)->queryAll();
		return $result;
	}
	
	
	function getFeaturedProducts()
	{
		$sql = "select c.category_name, c.is_discount as cat_is_discount, c.discount as cat_discount,
		 		c.discount_from as cat_discount_from, c.discount_to as cat_discount_to, 
				c.discount_desc as cat_discount_desc, 
		 		v.vendor_name,u.unit_name, p.* from product p 
				Left Join category c On (c.cat_id = p.cat_id) 
				Left Join vendor v On (v.vendor_id = p.vendor_id) 
				Left Join unit u On (u.unit_id = p.unitId) where p.featured = 1 and p.status = 1 
				order by  p.product_name asc limit 6;";
					
		$result	=Yii::app()->db->createCommand($sql)->queryAll();
		return $result;
	}
	
	function getSpecialProducts()
	{
		$sql = "select c.category_name, c.is_discount as cat_is_discount, c.discount as cat_discount,
		 		c.discount_from as cat_discount_from, c.discount_to as cat_discount_to, 
				c.discount_desc as cat_discount_desc, 
				v.vendor_name,u.unit_name, p.* from product p 
				Left Join category c On (c.cat_id = p.cat_id) 
				Left Join vendor v On (v.vendor_id = p.vendor_id) 
				Left Join unit u On (u.unit_id = p.unitId)
				where p.special = 1 and p.status = 1 order by p.product_name asc limit 3;";
					
		$result	=Yii::app()->db->createCommand($sql)->queryAll();
		return $result;
	}
	
	function getRelativeProducts($cat_id,$product_id)
	{
		$sql = "select c.category_name, c.is_discount as cat_is_discount, c.discount as cat_discount,
		 		c.discount_from as cat_discount_from, c.discount_to as cat_discount_to, 
				c.discount_desc as cat_discount_desc,  
				v.vendor_name,u.unit_name, p.* from product p 
				Left Join category c On (c.cat_id = p.cat_id) 
				Left Join vendor v On (v.vendor_id = p.vendor_id)
				Left Join unit u On (u.unit_id = p.unitId)
				where p.cat_id = ".$cat_id." and p.product_id != ".$product_id."
				and p.status = 1
				order by p.modified_date desc limit 8;";
					
		$result	=Yii::app()->db->createCommand($sql)->queryAll();
		return $result;
	}
	
	function getRecentProducts()
	{
		$sql = "select c.category_name, c.is_discount as cat_is_discount, c.discount as cat_discount,
		 		c.discount_from as cat_discount_from, c.discount_to as cat_discount_to, 
				c.discount_desc as cat_discount_desc,
				v.vendor_name,u.unit_name, p.* from product p 
				Left Join category c On (c.cat_id = p.cat_id) 
				Left Join vendor v On (v.vendor_id = p.vendor_id) 
				Left Join unit u On (u.unit_id = p.unitId) where p.status = 1 order by product_id desc limit 8;";
					
		$result	=Yii::app()->db->createCommand($sql)->queryAll();
		return $result;
	}
	
	function getAllProductsByCatId($cat_id)
	{
		$sql = "select c.category_name, v.vendor_name, p.* from product p 
				Left Join category c On (c.cat_id = p.cat_id) 
				Left Join vendor v On (v.vendor_id = p.vendor_id)
				where p.cat_id = ".$cat_id." and p.status = 1;";	
					
		$result	=Yii::app()->db->createCommand($sql)->queryAll();
		return $result;
	}
	
	function getAllProductsByVendorId($vendor_id)
	{
		$sql = "select c.category_name, v.vendor_name, p.* from product p 
				Left Join category c On (c.cat_id = p.cat_id) 
				Left Join vendor v On (v.vendor_id = p.vendor_id)
				where p.vendor_id = ".$vendor_id." and p.status = 1;";	
					
		$result	=Yii::app()->db->createCommand($sql)->queryAll();
		return $result;
	}
	
	function getProductById($product_id)
	{
		$result	=	Yii::app()->db->createCommand()
					->select('*')
					->from($this->tableName())
					->where('product_id=:product_id', array(':product_id'=>$product_id))
					->queryRow();
		
		return $result;
	}
	
	function getAllDetailOfProductById($product_id)
	{
		$sql = "select u.unit_name, c.category_name, c.is_discount as cat_is_discount, 
				c.discount as cat_discount, c.discount_from as cat_discount_from, 
				c.discount_to as cat_discount_to, c.discount_desc as cat_discount_desc,
				v.vendor_name, p.* from product p 
				Left Join unit u On (u.unit_id = p.unitId)
				Left Join category c On (c.cat_id = p.cat_id) 
				Left Join vendor v On (v.vendor_id = p.vendor_id)
				where p.product_id = ".$product_id.";";	
		$result	=Yii::app()->db->createCommand($sql)->queryRow();
		return $result;
	}
	
	function deleteProduct($id)
	{
		$productObj=Product::model()->findByPk($id);
		if(is_object($productObj))
		{
			$productObj->delete();
		}
		return true;
	}
	
	function minusProductQnt($qnt,$product_id)
	{
		$sql = "UPDATE  `product` SET  `quantity` = quantity - '".$qnt."' WHERE  `product`.`product_id` =".$product_id."";
		$result	=Yii::app()->db->createCommand($sql)->execute();
		
		return $result;
	}
	
	function plusProductQnt($qnt,$product_id)
	{
		$sql = "UPDATE `product` SET  `quantity` = quantity + '".$qnt."' WHERE  `product`.`product_id` =".$product_id."";
		$result	=Yii::app()->db->createCommand($sql)->execute();
		return $result;
	}
	
	function checkProductName($product_name)
	{
		$sql = "select product_id from product where product_name = '".$product_name."';";	
		$result	=Yii::app()->db->createCommand($sql)->queryScalar();
		return $result;
	}
	
	public function getAllPaginatedProductListing($limit=5,$sortType="asc",$sortBy="",$keyword=NULL)
	{
		
		$criteria = new CDbCriteria();
		$search = '';
		$dateSearch = '';
		//$keyword = mysql_real_escape_string($keyword);
		if(isset($keyword) && $keyword != NULL )
		{
			$search = " and (p.product_name like '%".$keyword."%')";	
			
		}
		
		$sql_users = "select c.category_name, c.is_discount as cat_is_discount, 
				c.discount as cat_discount, c.discount_from as cat_discount_from, 
				c.discount_to as cat_discount_to, c.discount_desc as cat_discount_desc,
				v.vendor_name,u.unit_name, p.* from product p 
				Left Join category c On (c.cat_id = p.cat_id) 
				Left Join vendor v On (v.vendor_id = p.vendor_id)
				Left Join unit u On (u.unit_id = p.unitId) where p.status = 1 ".$search."  order by ".$sortBy." ".$sortType."";		
		$sql_count = "select count(*) from product p 
				Left Join category c On (c.cat_id = p.cat_id) 
				Left Join vendor v On (v.vendor_id = p.vendor_id) 
				Left Join unit u On (u.unit_id = p.unitId) where p.status = 1 ".$search."  order by ".$sortBy." ".$sortType."";
			
		$count	=	Yii::app()->db->createCommand($sql_count)->queryScalar();
		
		$item	=	new CSqlDataProvider($sql_users, array(
						'totalItemCount'=>$count,
						'pagination'=>array(
							'pageSize'=>$limit,
						),
					));
		$index = 0;	
		return array('pagination'=>$item->pagination, 'listing'=>$item->getData());
	}
	
	public function getAllPaginatedProductListingByCatId($limit=9,$sortType="asc",$sortBy="",$keyword=NULL,$cat_id)
	{
		
		$criteria = new CDbCriteria();
		$search = '';
		$dateSearch = '';
		$keyword = mysql_real_escape_string($keyword);
		if(isset($keyword) && $keyword != NULL )
		{
			$search = " and (p.product_name like '%".$keyword."%')";	
		}
		
		$sql_users = "select c.category_name, c.is_discount as cat_is_discount, 
				c.discount as cat_discount, c.discount_from as cat_discount_from, 
				c.discount_to as cat_discount_to, c.discount_desc as cat_discount_desc,
				v.vendor_name,u.unit_name,p.* from product p 
				Left Join category c On (c.cat_id = p.cat_id) 
				Left Join vendor v On (v.vendor_id = p.vendor_id)
				Left Join unit u On (u.unit_id = p.unitId) where p.status = 1 and  p.cat_id = ".$cat_id." ".$search."  order by ".$sortBy." ".$sortType."";
		$sql_count = "select count(*) from product p 
				Left Join category c On (c.cat_id = p.cat_id) 
				Left Join vendor v On (v.vendor_id = p.vendor_id) 
				Left Join unit u On (u.unit_id = p.unitId) where p.status = 1 and p.cat_id = ".$cat_id." ".$search."  order by ".$sortBy." ".$sortType."";
			
		$count	=	Yii::app()->db->createCommand($sql_count)->queryScalar();
		
		$item	=	new CSqlDataProvider($sql_users, array(
						'totalItemCount'=>$count,
						'pagination'=>array(
							'pageSize'=>'15',
						),
					));
		$index = 0;	
		return array('pagination'=>$item->pagination, 'listing'=>$item->getData());
	}
	
	public function getPaginatedProductList($limit=7,$sortType="desc",$sortBy="product_id",$keyword=NULL,$searchFrom=NULL,$searchTo=NULL)
	{
			
		$criteria = new CDbCriteria();
		$search = '';
		$dateSearch = '';
		$keyword = mysql_real_escape_string($keyword);
		$bool = "where";
		
		if(isset($keyword) && $keyword != NULL )
		{
			$search = $bool."  (product_name like '%".$keyword."%')";	
			$bool = "and";
		}
		if(isset($startDate) && $startDate != NULL && isset($endDate) && $endDate != NULL)
		{
			if($search!='')
			{
				$dateSearch = $bool." created_date > '".date("Y-m-d",strtotime($startDate))."' and created_date < '".date("Y-m-d",strtotime($endDate))."'";	
				$bool = "and";
			}
			else
			{
			$dateSearch = $bool." created_date > '".date("Y-m-d",strtotime($startDate))."' and created_date < '".date("Y-m-d",strtotime($endDate))."'";	
			$bool = "and";
			}
		}
		if(isset($searchFrom) && $searchFrom != NULL && isset($searchTo) && $searchTo != NULL)
		{
			if($search!='')
			{
				$productSearch = $bool." product_price > ".$searchFrom." and product_price < ".$searchTo."";
				$bool = "and";	
			}
			else
			{
				$productSearch = $bool." product_price > ".$searchFrom." and product_price < ".$searchTo."";
				$bool = "and";	
			}
		}else{
			$productSearch = "";
		}
		
			
			$sql_users = "select * from product ".$search." ".$productSearch."  ".$dateSearch." order by ".$sortBy." ".$sortType."";
			$sql_count = "select count(*) from product ".$search." ".$productSearch."  ".$dateSearch." order by ".$sortBy." ".$sortType."";
		//}
		
		$count	=	Yii::app()->db->createCommand($sql_count)->queryScalar();
		
		$item	=	new CSqlDataProvider($sql_users, array(
						'totalItemCount'=>$count,
						'pagination'=>array(
							'pageSize'=>10,
						),
					));
		$index = 0;	
		return array('pagination'=>$item->pagination, 'product'=>$item->getData());
		
	}
	
	function getProductDetails($product_id=NULL)
	{
	 	$sql = "select c.category_name,p.* from product p left join category c on ( p.cat_id = c.cat_id ) where p.product_id = ".$product_id.";";	
		$result	=Yii::app()->db->createCommand($sql)->queryRow();
		return $result;
		
	}
}