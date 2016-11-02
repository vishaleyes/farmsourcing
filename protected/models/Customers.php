<?php

/**
 * This is the model class for table "customers".
 *
 * The followings are the available columns in table 'customers':
 * @property integer $customer_id
 * @property integer $admin_id
 * @property string $customer_name
 * @property string $cust_address
 * @property string $cust_email
 * @property string $contact_no
 * @property integer $rating
 * @property integer $total_purchase
 * @property integer $credit
 * @property integer $debit
 * @property string $createdAt
 * @property string $modifiedAt
 * @property string $status
 */
class Customers extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Customers the static model class
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
		return 'customers';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		/*return array(
			array('admin_id, rating, total_purchase, credit, debit', 'numerical', 'integerOnly'=>true),
			array('customer_name, cust_address, cust_email, contact_no', 'length', 'max'=>255),
			array('status', 'length', 'max'=>1),
			array('createdAt, modifiedAt', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('customer_id, admin_id, customer_name, cust_address, cust_email, contact_no, rating, total_purchase, credit, debit, createdAt, modifiedAt, status', 'safe', 'on'=>'search'),
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
			'customer_id' => 'Customer',
			'admin_id' => 'Admin',
			'customer_name' => 'Customer Name',
			'cust_address' => 'Cust Address',
			'cust_email' => 'Cust Email',
			'contact_no' => 'Contact No',
			'rating' => 'Rating',
			'total_purchase' => 'Total Purchase',
			'credit' => 'Credit',
			'debit' => 'Debit',
			'createdAt' => 'Created At',
			'modifiedAt' => 'Modified At',
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

		$criteria->compare('customer_id',$this->customer_id);
		$criteria->compare('admin_id',$this->admin_id);
		$criteria->compare('customer_name',$this->customer_name,true);
		$criteria->compare('cust_address',$this->cust_address,true);
		$criteria->compare('cust_email',$this->cust_email,true);
		$criteria->compare('contact_no',$this->contact_no,true);
		$criteria->compare('rating',$this->rating);
		$criteria->compare('total_purchase',$this->total_purchase);
		$criteria->compare('credit',$this->credit);
		$criteria->compare('debit',$this->debit);
		$criteria->compare('createdAt',$this->createdAt,true);
		$criteria->compare('modifiedAt',$this->modifiedAt,true);
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
	
	
	
	function getAllCustomers()
	{
		$sql = "select z.zoneName , c.* from customers c Left Join zone z ON (z.zone_id = c.zone_id) order by c.customer_id desc;";	
		$result	=Yii::app()->db->createCommand($sql)->queryAll();
		return $result;
	}
	
	function getAllCustomersByZoneId($zone_id)
	{
		$sql = "select z.zoneName , c.* from customers c Left Join zone z ON (z.zone_id = c.zone_id) where c.zone_id = '".$zone_id."';";	
		$result	=Yii::app()->db->createCommand($sql)->queryAll();
		return $result;
	}
	
	
	function getCustomerById($customer_id)
	{
		$result	=	Yii::app()->db->createCommand()
					->select('*')
					->from($this->tableName())
					->where('customer_id=:customer_id', array(':customer_id'=>$customer_id))
					->queryRow();
		
		return $result;
	}
	
	function getCustomerByMobileNo($mobile_no)
	{
		$result	=	Yii::app()->db->createCommand()
					->select('*')
					->from($this->tableName())
					->where('mobile_no=:mobile_no', array(':mobile_no'=>$mobile_no))
					->queryRow();
		
		return $result;
	}
	
	function updateCustomer($customer_id,$credit,$debit,$modifiedAt)
	{
		$sql = "UPDATE customers SET credit = credit + ".$credit." , debit = debit + ".$debit." , modifiedAt= '".$modifiedAt."'  where customer_id= ".$customer_id.";";
		$result	=	Yii::app()->db->createCommand($sql)->execute();
		return true;	
	}
	
	function deleteCustomer($id)
	{
		$customerObj=Customers::model()->findByPk($id);
		if(is_object($customerObj))
		{
			$customerObj->delete();
		}
		return true;
	}
	
	function checkCustomerEmail($cust_email)
	{
		$sql = "select customer_id from customers where cust_email = '".$cust_email."';";	
		$result	=Yii::app()->db->createCommand($sql)->queryScalar();
		return $result;
	}
	
	function checkCustomerMobile($mobile_no)
	{
		$sql = "select customer_id from customers where mobile_no = '".$mobile_no."';";	
		$result	=Yii::app()->db->createCommand($sql)->queryScalar();
		return $result;
	}
	
	function getCustomeDetailrById($id)
	{
		$sql = "select z.zoneName , c.* from customers c Left Join zone z ON (z.zone_id = c.zone_id) where customer_id = '".$id."';";	
		$result	=Yii::app()->db->createCommand($sql)->queryRow();
		return $result;
	}
	
	function getCustomeDetailrByParam($id)
	{
		$sql = "select * from customers where customer_id = '".$id."' or representativeId = '".$id."' 
				or mobile_no = '".$id."';";	
		$result	=Yii::app()->db->createCommand($sql)->queryRow();
		return $result;
	}
	
	function checkZoneInCusotmer($zone_id)
	{
		$sql = "select zone_id from customers where zone_id = '".$zone_id."' Limit 1;";	
		$result	=Yii::app()->db->createCommand($sql)->queryScalar();
		return $result;
	}
	
	public function getPaginatedCustomerList($limit=5,$sortType="desc",$sortBy="customer_id",$keyword=NULL,$searchFrom=NULL,$searchTo=NULL)
	{
		
		$criteria = new CDbCriteria();
		$search = '';
		$dateSearch = '';
		$keyword = mysql_real_escape_string($keyword);
		if(isset($keyword) && $keyword != NULL )
		{
			$search = " where ((customer_name like '%".$keyword."%') or (cust_email like '%".$keyword."%') or (mobile_no like '%".$keyword."%')) ";	
		}
		if(isset($searchFrom) && $searchFrom != NULL && isset($searchTo) && $searchTo != NULL)
		{
			if($search!='')
			{
				$dateSearch = " and credit-debit > ".$searchFrom." and credit-debit < ".$searchTo."";	
			}
			else
			{
				$dateSearch = " and credit-debit > ".$searchFrom." and credit-debit < ".$searchTo."";	
			}
		}
			$userData=Users::model()->findbyPk(Yii::app()->session['userId']);
			
		
			 $sql_users = "select * from customers   ".$search." ".$dateSearch." order by ".$sortBy." ".$sortType."";
			
			$sql_count = "select count(*) from customers   ".$search." ".$dateSearch." ";
		
		$count	=	Yii::app()->db->createCommand($sql_count)->queryScalar();
		
		$item	=	new CSqlDataProvider($sql_users, array(
						'totalItemCount'=>$count,
						'pagination'=>array(
							'pageSize'=>LIMIT_10,
						),
					));
		$index = 0;	
		
		return array('pagination'=>$item->pagination, 'customers'=>$item->getData());			
	}
}