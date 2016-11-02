<?php
error_reporting(0);
require_once(FILE_PATH."/protected/extensions/mpdf/mpdf.php");
class PosController extends Controller
{
	public function actionIndex()
	{
		//$this->loginRedirect();
		if(isset(Yii::app()->session['farmsourcing_posUser']))
		{
			$this->redirect(Yii::app()->params->base_path."pos/home");
			exit;
		}
		else
		{
			$this->render("index");
			exit;
		}
	}
	
	
	function actionLogin()
	{
		error_reporting(0);
		
		if (isset($_POST['submit_login'])) {
			
			$time = time();
			
			if(isset($_POST['remember']) && $_POST['remember'] == 'on')
			{
				setcookie("email_admin", $_POST['email_admin'], $time + 3600);
				setcookie("password_admin", $_POST['password_admin'], $time + 3600);
			}else{
				setcookie("email_admin", "", $time + 3600);
				setcookie("password_admin", "", $time + 3600);
			}
			
			if(isset($_POST['email_admin']))
			{
				$email_admin = $_POST['email_admin'];
				$pwd = $_POST['password_admin'];
					
				$adminObj	=	new Admin();
				$admin_data	=	$adminObj->getAdminDetailsByEmailForPos($email_admin);
				
			}
			
			if(empty($admin_data))
			{
				Yii::app()->user->setFlash("error","Invalid email or password.");
				$this->redirect(array('pos/index'));
				exit;
			}
			
			if($admin_data['status'] == 0)
			{
				Yii::app()->user->setFlash("error","Your account is deactivated.");
				$this->redirect(array('pos/index'));
				exit;
			}
			/*if($admin_data['type'] == 2)
			{
				Yii::app()->user->setFlash("error","You can not login from web panel.");
				$this->redirect(array('admin/index'));
				exit;
			}*/
			$generalObj	=	new General();
			$isValid	=	$generalObj->validate_password($_POST['password_admin'], $admin_data['password']);
			
			if ( $isValid === true ) {
				
				$companyDetailsObj	=	new CompanyDetails();
				$companyDetails = $companyDetailsObj->getCompanyDetailsByAdminId($admin_data['id']);
				Yii::app()->session['farmsourcing_posUser'] = $admin_data['id'];
				Yii::app()->session['email'] = $admin_data['email'];
				Yii::app()->session['firstName'] = $admin_data['firstName'];
				Yii::app()->session['fullName'] = $admin_data['firstName'] . ' ' . $admin_data['lastName'];
				Yii::app()->session['currency'] = $companyDetails['currency'];
				Yii::app()->session['type'] = $admin_data['type'];
				Yii::app()->session['current']	=	'dashboard';
				
				$shiftObj = new Shift();
				$shiftData = $shiftObj->getLastShiftId();
				
				Yii::app()->session['shift_id']	=	$shiftData['shift_id'] + 1;
				
				if(Yii::app()->session['type'] == 5)
				{
					$this->redirect(array("pos/welcome"));
				
				}
				
				$this->redirect(array("pos/welcome"));
				
				//$this->render("dashboard", array("adminData"=>$admin_data));	
				exit;
			} else {
				Yii::app()->user->setFlash("error","Email or Password is not valid");
				$this->redirect(array('pos/index'));
				exit;
			}	
		}
	}
	
	function loginRedirect()
	{
		if(isset(Yii::app()->session['farmsourcing_posUser']))
		{
			$this->redirect(Yii::app()->params->base_path."pos/home");
			exit;
		}
		else
		{
			return true;
		}
	}
	
	function actionwelcome()
	{
		if(isset($_POST['submit']))
		{
						
			$data['cashier_id']	=$_POST['cashier_id'];
			$data['cash_in']=$_POST['cash_in'];
			$data['cash_out']	=$_POST['cash_out'];
			$data['time_in']=date('Y-m-d:H-m-s');
			
			$shiftObj = new Shift();
			$shiftObj->setData($data);
			$lastId = $shiftObj->insertData();
			
			Yii::app()->session['lastId'] = $lastId;
			Yii::app()->session['shiftId'] = $lastId;
			Yii::app()->session['cash_in'] = $_POST['cash_in'];
			if($this->isAjaxRequest())
			{	
				header('location:'.Yii::app()->params->base_path.'pos/home');
				exit;
			}
			else
			{
				header('location:'.Yii::app()->params->base_path.'pos/home');
				exit;
			}
		
		}
		$this->render("welcome");
	}
	
	function isAjaxRequest()
	{
		if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	function actionhome()
	{
		if(isset(Yii::app()->session['farmsourcing_posUser']))
		{
			$this->render("home");
		}
		else
		{
			header('location:'.Yii::app()->params->base_path.'pos/index');
			exit;
		}
	}
	
	function actionbrowse()
	{
		if(isset(Yii::app()->session['farmsourcing_posUser']))
		{
			$productObj = new Product();
			$productList = $productObj->getAllProducts();
			
			$productTotal  = 0 ;
			$i = 0 ;
			
			if(isset($_SESSION['fnp_store_cartData']))
			{
				foreach($_SESSION['fnp_store_cartData'] as $row)
				{
					
					$productObj = new Product();
					$productData[$i] = $productObj->getAllDetailOfProductById($row['product_id']);
					
					/*if($productData[$i]['cat_is_discount'] == 1)
					{
						if($productData[$i]['is_discount'] == 1)
						{
							if($productData[$i]['cat_discount'] > $productData[$i]['discount'])
							{
								$discount = $productData[$i]['cat_discount'];
								$fromDate = $productData[$i]['cat_discount_from'];
								$toDate = $productData[$i]['cat_discount_to'];	
							}else{
								$discount = $productData[$i]['discount'];
								$fromDate = $productData[$i]['discount_from'];
								$toDate = $productData[$i]['discount_to'];
							}
						}else{
							$discount = $productData[$i]['cat_discount'];
							$fromDate = $productData[$i]['cat_discount_from'];
							$toDate = $productData[$i]['cat_discount_to'];
						}
					}else{
						if($productData[$i]['is_discount'] == 1)
						{
							$discount = $productData[$i]['discount'];
							$fromDate = $productData[$i]['discount_from'];
							$toDate = $productData[$i]['discount_to'];
						}else{
							$discount = "";
							$fromDate = "";
							$toDate = "";
						}
					}
					if($discount != "")
					{
						$todayDate = date("Y-m-d");
						
						if($todayDate >= $fromDate && $todayDate <= $toDate)
						{
							$finalProductAmount = round($productData[$i]['product_price'] - ($productData[$i]['product_price'] * $discount / 100));
							$productData[$i]['product_price'] = $finalProductAmount;
						}else{
							$finalProductAmount = $productData[$i]['product_price'];
							$productData[$i]['product_price'] = $finalProductAmount;
						}
					}else{
							$finalProductAmount = $productData[$i]['product_price'];
							$productData[$i]['product_price'] = $finalProductAmount;
					}*/	
					
					if(isset($_SESSION['fnp_store_cartData'][$i]['packaging_scenario']) && $_SESSION['fnp_store_cartData'][$i]['packaging_scenario'] != "") 
					{ 
						$total = $_SESSION['fnp_store_cartData'][$i]['packaging_scenario'] * $_SESSION['fnp_store_cartData'][$i]['qty'] * $productData[$i]['product_price'] ;
						$productTotal = $productTotal + $total ;
					}else{
						$total = $_SESSION['fnp_store_cartData'][$i]['qty'] * $productData[$i]['product_price'] ;
						$productTotal = $productTotal + $total ;
					}
					 
					$i++;
					 
				}
			}else{
				$productData = "";
			}
			
			$this->render("browseproduct",array("productData"=>$productData,"product"=>$productList,"productTotal"=>$productTotal));
		}
		else
		{
			header('location:'.Yii::app()->params->base_path.'pos/index');
			exit;
		}
	}
	
	
	function actionSearchProductAjax()
	{
		$limit = 300;
		if(!isset($_REQUEST['sortType']))
		{
			$_REQUEST['sortType']='asc';
		}
		if(!isset($_REQUEST['sortBy']))
		{
			$_REQUEST['sortBy']='product_name';
		}
		if(!isset($_REQUEST['keyword']))
		{
			$_REQUEST['keyword']='';
		}
		
		$productObj = new Product();
		$res = $productObj->getAllPaginatedProductListing($limit,$_REQUEST['sortType'],$_REQUEST['sortBy'],$_REQUEST['keyword']);
		
		$i = 0 ;
		
		if(isset($_SESSION['fnp_store_cartData']))
		{
			foreach($_SESSION['fnp_store_cartData'] as $row)
			{
				
				$productObj = new Product();
				$productData[$i] = $productObj->getAllDetailOfProductById($row['product_id']);
				
				if(isset($_SESSION['fnp_store_cartData'][$i]['packaging_scenario']) && $_SESSION['fnp_store_cartData'][$i]['packaging_scenario'] != "") 
				{ 
					$total = $_SESSION['fnp_store_cartData'][$i]['packaging_scenario'] * $_SESSION['fnp_store_cartData'][$i]['qty'] * $productData[$i]['product_price'] ;
					$productTotal = $productTotal + $total ;
				}else{
					$total = $_SESSION['fnp_store_cartData'][$i]['qty'] * $productData[$i]['product_price'] ;
					$productTotal = $productTotal + $total ;
				}
			 
			$i++;
				 
			}
		}else{
			$productData = "";
		}
		
		$this->renderPartial('searchproduct_ajax',array('res'=>$res,'productData'=>$productData));	
	}
	
	public function actiongetProductDetail()
	{
		$productObj = new Product();
		$data = $productObj->getAllDetailOfProductById($_REQUEST['product_id']);
		$this->renderpartial('productDescription',array('data'=>$data));
		
	}
	
	function actiongetStockDetail()
	{
		$productObj = new Product();
		$data = $productObj->getAllDetailOfProductById($_POST['productId']);
		
		echo $data['quantity'];
	}
	
	function actionCheckStockDetail()
	{
		
		$quantity1 = $_REQUEST['quantity'];
		$quantity2 = $_REQUEST['quntityOld'];
		$quantity = $quantity1 - $quantity2 ;
		
		$productObj = new Product();
		$result = $productObj->getAllDetailOfProductById($_POST['productId']);
		
		if(empty($result) ||  $result['quantity'] < $quantity)
		{
			echo 0 ;
			exit;
		}
		else
		{
			echo 1 ;
			exit;
		}
	}
	
	function actionaddToCart()
	{
		//unset( $_SESSION['cartData']);exit;
		$productObj = new Product();
		$checkData = $productObj->getAllDetailOfProductById($_REQUEST['id']);
		
		if(!empty($checkData))
		{
			$product_id = $_REQUEST['id'];       
			if(isset($_SESSION['fnp_store_cartData']))
			{
				$bool = 0;				 
				foreach($_SESSION['fnp_store_cartData'] as $arrays){
					if($arrays['product_id'] == $_REQUEST['id'])
					{
						$bool = 1;
					}
				}
				
				if($bool == 0)
				{
					$data['product_id']=$product_id;
					$data['qty']= 1;
					$_SESSION['fnp_store_cartData'][] = $data ;
				}
			}     
			else
			{
				$data['product_id']=$product_id;
				$data['qty']= 1;
				$_SESSION['fnp_store_cartData'][] = $data ;
			}
		}
		
		exit;
		
	}
	
	function actionupdateCartSession()
	{
		$key = $_REQUEST['sessionKey'];	
		$qty = $_REQUEST['no_of_packets']; 

		$_SESSION['fnp_store_cartData'][$key]['qty']= $qty;
			
		return true;
	}
	
	function actionremoveProductFromCart()
	{
		if(isset($_REQUEST['removeId']) && $_REQUEST['removeId'] != "")
		{
			unset($_SESSION['fnp_store_cartData'][$_REQUEST['removeId']]);
		}
		
		$i = 0 ;
		if(isset($_SESSION['fnp_store_cartData']))
		{
			$sessionData = $_SESSION['fnp_store_cartData'];
			unset($_SESSION['fnp_store_cartData']);
			unset($_SESSION['fnp_browse_customer_name']);
			unset($_SESSION['fnp_browse_customer_id']);
			
			foreach($sessionData as $row)
			{
				$data['product_id']=$row['product_id'];
				$data['qty']= $row['qty'];
				$_SESSION['fnp_store_cartData'][$i] = $data ;
				
				$i++;
			}
		}
		return true;
		exit;			
	}
	
	function actionemptyCart()
	{
		if(isset($_SESSION['fnp_store_cartData']))
		{
			unset($_SESSION['fnp_store_cartData']);
			unset($_SESSION['fnp_browse_customer_name']);
			unset($_SESSION['fnp_browse_customer_id']);	
		}
		
		if(isset(Yii::app()->session['order_discout_type']))
		{
			unset(Yii::app()->session['order_discout_type']);	
		}
		
		if(isset(Yii::app()->session['order_discout_amount']))
		{
			unset(Yii::app()->session['order_discout_amount']);	
		}
		
		Yii::app()->user->setFlash('success',"Your cart is empty now.");
			
		$this->redirect(array("pos/home"));
	}
	
	function actionaddDiscountToOrder()
	{
		if(isset(Yii::app()->session['order_discout_type']))
		{
			unset(Yii::app()->session['order_discout_type']);	
		}
		
		if(isset(Yii::app()->session['order_discout_amount']))
		{
			unset(Yii::app()->session['order_discout_amount']);	
		}
		
		Yii::app()->session['order_discout_type'] = $_REQUEST['discountType'];	
		Yii::app()->session['order_discout_amount'] = $_REQUEST['upc_code'];
			
		return true;
	}
	
	function actionaddCreditToOrder()
	{
		if(isset(Yii::app()->session['order_credit_amount']))
		{
			unset(Yii::app()->session['order_discout_type']);	
		}
		
		Yii::app()->session['order_credit_amount'] = $_REQUEST['upc_code'];
			
		return true;
	}
	
	function actionsubmitOrder()
	{
		$data = array();

		$so_detail['admin_id'] = Yii::app()->session['farmsourcing_posUser'] ;
		//$_REQUEST['customer_id']
		$so_detail['customer_id'] = $_SESSION['fnp_browse_customer_id'];
		$so_detail['coupon_amount'] = 0 ;
		$so_detail['shift_id'] = Yii::app()->session['shiftId'] ;
		$so_detail['delivery_date'] =  date("Y-m-d");
		$so_detail['status'] = 1 ;
		$so_detail['type'] = 3 ;
		$so_detail['discount_type'] = Yii::app()->session['order_discout_type'] ;
		$so_detail['discount_amount'] = Yii::app()->session['order_discout_amount'] ;
		$so_detail['credit_amount'] = Yii::app()->session['order_credit_amount'] ;
		$so_detail['isSynced'] = 0 ;
		$so_detail['createdAt'] = date("Y-m-d H:i:s");
		$so_detail['modifiedAt'] = date("Y-m-d H:i:s");
		
		$SoDetailsObj = new SoDetails();
		$SoDetailsObj->setData($so_detail);
		$soId = $SoDetailsObj->insertData();
		
		
		$data['so_id'] = $soId;
		$data['admin_id'] = Yii::app()->session['farmsourcing_posUser'] ;
		
		$total_packets = 0 ;
		$k = 0;
		
		$sessionData = $_SESSION['fnp_store_cartData'];
		
		foreach($sessionData as $row)
		{
			$productObj = new Product();
			$result = $productObj->getAllDetailOfProductById($row['product_id']);
			
			/*if($result['cat_is_discount'] == 1)
			{
				if($result['is_discount'] == 1)
				{
					if($result['cat_discount'] > $result['discount'])
					{
						$discount = $result['cat_discount'];
						$fromDate = $result['cat_discount_from'];
						$toDate = $result['cat_discount_to'];
						$discount_desc = $result['cat_discount_desc'];	
					}else{
						$discount = $result['discount'];
						$fromDate = $result['discount_from'];
						$toDate = $result['discount_to'];
						$discount_desc = $result['discount_desc'];
					}
				}else{
					$discount = $result['cat_discount'];
					$fromDate = $result['cat_discount_from'];
					$toDate = $result['cat_discount_to'];
					$discount_desc = $result['cat_discount_desc'];
				}
			}else{
				if($result['is_discount'] == 1)
				{
					$discount = $result['discount'];
					$fromDate = $result['discount_from'];
					$toDate = $result['discount_to'];
					$discount_desc = $result['discount_desc'];
				}else{
					$discount = "";
					$fromDate = "";
					$toDate = "";
					$discount_desc = "";
				}
			}
			if($discount != "")
			{
				$todayDate = date("Y-m-d");
				
				if($todayDate >= $fromDate && $todayDate <= $toDate)
				{
					$finalProductAmount = round($result['product_price'] - ($result['product_price'] * $discount / 100));
					$result['product_price'] = $finalProductAmount;
				}else{
					$finalProductAmount = $result['product_price'];
					$result['product_price'] = $finalProductAmount;
				}
			}else{
					$finalProductAmount = $result['product_price'];
					$result['product_price'] = $finalProductAmount;
			}*/
			
			$data['packaging_scenario'] = 0;
			$data['no_of_packets'] = 0;	
			$data['product_price'] = $result['product_price'];			
			$data['quantity'] = $row['qty'];
			$data['product_id'] = $row['product_id'];
			$data['delivery_date'] =  date("Y-m-d");
			$data['discount_desc'] = $discount_desc;
			$data['createdAt'] = date("Y-m-d H:i:s");
			$data['modifiedAt'] = date("Y-m-d H:i:s");
			
			$SoDescObj = new SoDesc();
			$SoDescObj->setData($data);
			$SoDescObj->insertData();
			
			
			$productObj = new Product();
			$productObj->minusProductQnt($data['quantity'],$data['product_id']);
			
			$k++;
		}
			
		$newData['total_item'] = $k ;
		$newData['total_packets'] = 0 ;
		$newData['modifiedAt'] =  date("Y-m-d H:i:s");
		
		$SoDetailsObj = new SoDetails();
		$SoDetailsObj->setData($newData);
		$SoDetailsObj->insertData($soId);
		
		//$this->actionraiseSalesOrder($soId);
		Yii::app()->user->setFlash('success',"Sales Order created successfully.");
		
		unset($_SESSION['fnp_store_cartData']);
		unset($_SESSION['fnp_browse_customer_name']);
		unset($_SESSION['fnp_browse_customer_id']);
		
		if(isset(Yii::app()->session['order_discout_type']))
		{
			unset(Yii::app()->session['order_discout_type']);	
		}
		
		if(isset(Yii::app()->session['order_discout_amount']))
		{
			unset(Yii::app()->session['order_discout_amount']);	
		}
		echo $soId;
		return true;
		exit;		
	}
	
	public function actioncustomerList($id=NULL)
	{
		
		$customerObj	=	new Customers();
		$limit = 10;
		if(!isset($_REQUEST['sortType']))
		{
			$_REQUEST['sortType']='desc';
		}
		if(!isset($_REQUEST['sortBy']))
		{
			$_REQUEST['sortBy']='customer_id';
		}
		if(!isset($_REQUEST['keyword']))
		{
			$_REQUEST['keyword']='';
		}
		if(!isset($_REQUEST['searchFrom']))
		{
			$_REQUEST['searchFrom']='';
		}
		if(!isset($_REQUEST['searchTo']))
		{
			$_REQUEST['searchTo']='';
		}
		
		$customerList	=	$customerObj->getPaginatedCustomerList($limit,$_REQUEST['sortType'],$_REQUEST['sortBy'],$_REQUEST['keyword'],$_REQUEST['searchFrom'],$_REQUEST['searchTo']);
		
		/*echo "<pre>";
		print_r($customerList);exit;*/
		if($_REQUEST['sortType'] == 'desc'){
			$ext['sortType']	=	'asc';
			$ext['img_name']	=	'arrow_up.png';
		} else {
			$ext['sortType']	=	'desc';
			$ext['img_name']	=	'arrow_down.png';
		}
		$ext['sortBy']	=	$_REQUEST['sortBy'];
		$ext['keyword'] = $_REQUEST['keyword'];
		if(isset($_REQUEST['invoiceId']))
		{
			$invoiceId = $_REQUEST['invoiceId'];
		}
		else
		{
			$invoiceId = "";	
		}
		
		//echo "<pre>";
		//print_r($customerList['customers']);
		
		$seen=array();
		$i=0;
		$totalItems=0;
		$pendingItems=0;
		$this->renderPartial('customers', array('data'=>$customerList['customers'],'pagination'=>$customerList['pagination'],'ext'=>$ext,'invoiceId'=>$invoiceId));
	
	}
	
	function actiongetAllPackageScenarioByCatId()
	{
		
		$catPackObj = new CategoryPackagingMaster();
		$catPackData = $catPackObj->getAllPackageScenarioByCatId($_REQUEST['productId']);
		
		echo json_encode($catPackData);
		exit;
	}
	public function actionreplaceCustomerName()
	{
		error_reporting(0);
		if(isset($_REQUEST['customer_id']) && $_REQUEST['customer_id'] != "")
		{
			//$invoice['customer_id'] = $_REQUEST['customer_id'] ;
			
			//$ticketdetailObj = new TicketDetails();
			//$ticketdetailObj->setData($invoice);
			//$ticketdetailObj->insertData($invoiceId);
			$Customers	=	new Customers();
			$result	=	$Customers->getCustomerById($_REQUEST['customer_id']); 
			
			$_SESSION['fnp_browse_customer_name'] = $result['customer_name'];
			$_SESSION['fnp_browse_customer_id'] = $result['customer_id'];
		}
			
			$this->redirect(array('pos/browse'));
		
	}
	
	public function actionpaymentTicket()
	{
		$data = array();
		$data['customer_id']=$_REQUEST['customer_id'];
		//$data['discount']	=$_REQUEST['discount'];
		$data['total_amount']	=$_REQUEST['totalPayable'];
		Yii::app()->session['ticketData'] = $data ;

		$this->renderPartial('paymentTicket', array('data'=>$data,'pagination'=>''));	
	}
	
	public function actionVault()
	{
		if(isset($_POST['deposite']))
		{			
			$data['cashier_id']	=Yii::app()->session['farmsourcing_posUser'];
			$data['deposite']=$_POST['deposite'];
			$data['withdraw']=$_POST['withdraw'];
			$data['shift_id']=Yii::app()->session['shiftId'];
			//$data['time']= time(); 
			$data['date']=date('Y-m-d');

			$vaultObj = new Vault();
			$vaultObj->setData($data);
			$lastId = $vaultObj->insertData();

			if($this->isAjaxRequest())
			{	
				Yii::app()->user->setFlash('success',"Record inserted successfully.");
				$this->renderPartial('vault',array("isAjax"=>'true'));
				exit;
				header('location:'.Yii::app()->params->base_path.'pos/Vault');
				exit;
			}
			else
			{
				Yii::app()->user->setFlash('success',"Record inserted successfully.");
				$this->render('vault',array("isAjax"=>'false'));
				exit;
				header('location:'.Yii::app()->params->base_path.'pos/Vault');
				exit;
			}
		}
		else
		{			
			if($this->isAjaxRequest())
			{	
				$this->renderPartial('vault',array("isAjax"=>'true'));
			}
			else
			{
				$this->render('vault',array("isAjax"=>'false'));
			}			
		}
	}
	
	
	/*public function actionLogOut()
	{
		Yii::app()->session->destroy();
		$this->redirect(array('pos/index'));
	}*/
	
	public function actioncategoryListing()
	{
		if(!isset($_REQUEST['sortType']))
		{
			$_REQUEST['sortType']='asc';
		}
		if(!isset($_REQUEST['sortBy']))
		{
			$_REQUEST['sortBy']='category_name';
		}
		if(!isset($_REQUEST['keyword']))
		{
			$_REQUEST['keyword']='';
		}
		

		$res=Users::model()->findbyPk(Yii::app()->session['userId']);
		/*echo "<pre>";
		print_r($res);
		exit;*/
		// $admin_id = $res->admin_id ;
		
		$categoryObj = new Category();
		$res = $categoryObj->getAllPaginatedCategory($_REQUEST['sortType'],$_REQUEST['sortBy'],$_REQUEST['keyword']);
		//echo "<pre>" ; print_r($res); exit; 
		$this->renderPartial('categorylistWithAjax',array('res'=>$res));
	}
	
	function actiongetCategoryProductAjax()
	{
		
		if(!isset($_REQUEST['sortType']))
		{
			$_REQUEST['sortType']='asc';
		}
		if(!isset($_REQUEST['sortBy']))
		{
			$_REQUEST['sortBy']='product_name';
		}
		if(!isset($_REQUEST['keyword']))
		{
			$_REQUEST['keyword']='';
		}
		
		$cat_id = $_REQUEST['cat_id'];
		
		////$userData=Users::model()->findbyPk(Yii::app()->session['userId']);
		///$store_id = $userData->store_id ;
		
		$productObj = new Product();
		$res = $productObj->getAllPaginatedProductListingByCatId(20,$_REQUEST['sortType'],$_REQUEST['sortBy'],$_REQUEST['keyword'],$cat_id);
		
		$i = 0 ;
			
		if(isset($_SESSION['fnp_store_cartData']))
		{
			foreach($_SESSION['fnp_store_cartData'] as $row)
			{
				
				$productObj = new Product();
				$productData[$i] = $productObj->getAllDetailOfProductById($row['product_id']);
				
				if(isset($_SESSION['fnp_store_cartData'][$i]['packaging_scenario']) && $_SESSION['fnp_store_cartData'][$i]['packaging_scenario'] != "") 
			{ 
				$total = $_SESSION['fnp_store_cartData'][$i]['packaging_scenario'] * $_SESSION['fnp_store_cartData'][$i]['qty'] * $productData[$i]['product_price'] ;
				$productTotal = $productTotal + $total ;
			}else{
				$total = $_SESSION['fnp_store_cartData'][$i]['qty'] * $productData[$i]['product_price'] ;
				$productTotal = $productTotal + $total ;
			}
			 
			$i++;
				 
			}
		}else{
			$productData = "";
		}
		
		$this->renderPartial('searchproduct_ajax',array('res'=>$res,'productData'=>$productData,'cat_id'=>$cat_id));	
	}
	
	/******* GET MY ALL LISTS FUNCTION *******/
	public function actionticketList()
	{
		error_reporting(0);
		$soDetailObj	=	new SoDetails();
		$limit = 15;
		
		if(!isset($_REQUEST['sortType']))
		{
			$_REQUEST['sortType']='desc';
		}
		if(!isset($_REQUEST['sortBy']))
		{
			$_REQUEST['sortBy']='s.so_id';
		}
		if(!isset($_REQUEST['keyword']))
		{
			$_REQUEST['keyword']='';
		}
		if(!isset($_REQUEST['searchFrom']))
		{
			$_REQUEST['searchFrom']='';
		}
		if(!isset($_REQUEST['searchTo']))
		{
			$_REQUEST['searchTo']='';
		}
		if(!isset($_REQUEST['startdate']))
		{
			$_REQUEST['startdate']='';
		}
		if(!isset($_REQUEST['enddate']))
		{
			$_REQUEST['enddate']='';
		}
		if(!isset($_REQUEST['todayDate']))
		{
			$_REQUEST['todayDate']='';
		}
		
		$ticketList	=	$soDetailObj->getAllPaginatedOrders($limit,$_REQUEST['sortType'],$_REQUEST['sortBy'],$_REQUEST['keyword'],$_REQUEST['searchFrom'],$_REQUEST['searchTo'],$_REQUEST['startdate'],$_REQUEST['enddate'],$_REQUEST['todayDate']);
		
		/*echo "<pre>";
		print_r($ticketList);exit;*/
		if($_REQUEST['sortType'] == 'desc'){
			$ext['sortType']	=	'asc';
			$ext['img_name']	=	'arrow_up.png';
		} else {
			$ext['sortType']	=	'desc';
			$ext['img_name']	=	'arrow_down.png';
		}
		$ext['sortBy']	=	$_REQUEST['sortBy'];
		$ext['keyword'] = $_REQUEST['keyword'];
		$ext['startdate'] = $_REQUEST['startdate'];
		$ext['enddate'] = $_REQUEST['enddate'];
		$ext['searchFrom'] = $_REQUEST['searchFrom'];
		$ext['searchTo'] = $_REQUEST['searchTo'];
		
		$seen=array();
		$i=0;
		$totalItems=0;
		$pendingItems=0;
		$this->renderPartial('ticketList', array('data'=>$ticketList['listing'],'pagination'=>$ticketList['pagination'],'ext'=>$ext));
	
	}
	
	
	/*********** 	ITEMS ASSIGNED BY ME FUNCTION  ***********/
	
	
	public function actionproductList()
	{
		$productObj	=	new Product();
		$limit = 10;
		
		if(!isset($_REQUEST['sortType']))
		{
			$_REQUEST['sortType']='desc';
		}
		if(!isset($_REQUEST['sortBy']))
		{
			$_REQUEST['sortBy']='product_id';
		}
		if(!isset($_REQUEST['keyword']))
		{
			$_REQUEST['keyword']='';
		}
		if(!isset($_REQUEST['searchFrom']))
		{
			$_REQUEST['searchFrom']='';
		}
		if(!isset($_REQUEST['searchTo']))
		{
			$_REQUEST['searchTo']='';
		}
		
		$productList	=	$productObj->getPaginatedProductList($limit,$_REQUEST['sortType'],$_REQUEST['sortBy'],$_REQUEST['keyword'],$_REQUEST['searchFrom'],$_REQUEST['searchTo']);
		
		/*echo "<pre>";
		print_r($productList);exit;*/
		if($_REQUEST['sortType'] == 'desc'){
			$ext['sortType']	=	'asc';
			$ext['img_name']	=	'arrow_up.png';
		} else {
			$ext['sortType']	=	'desc';
			$ext['img_name']	=	'arrow_down.png';
		}
		$ext['sortBy']	=	$_REQUEST['sortBy'];
		$ext['keyword'] = $_REQUEST['keyword'];
		$ext['searchFrom']	=	$_REQUEST['searchFrom'];
		$ext['searchTo'] = $_REQUEST['searchTo'];
		
		$seen=array();
		$i=0;
		$totalItems=0;
		$pendingItems=0;
		$this->renderPartial('productList', array('data'=>$productList['product'],'pagination'=>$productList['pagination'],'ext'=>$ext));
	
	}
	
	
	
	
	public function actionaboutme()
	{
		error_reporting(E_ALL);
		if(!isset(Yii::app()->session['farmsourcing_posUser']))
		{
			$this->redirect('index');
			exit;
		}
		$adminObj	=	new Admin();
		$data	=	array();
		$res=Admin::model()->findbyPk(Yii::app()->session['farmsourcing_posUser']);
		$data['firstName'] = $res->firstName ;
		$data['lastName'] = $res->lastName ;
		$data['loginId'] = $res->email ;

		$this->renderPartial("aboutme",array('data'=>$data));

	}
	
	function actioneditProfile()
	{
		
		if(isset($_GET['id']))
		{
			$generalObj = new General();
			$adminObj = new Admin();
			$POST = $_POST;
			unset($POST['email']);
			$adminObj->setData($POST);
			$adminObj->insertData(Yii::app()->session['farmsourcing_posUser']);
			
			Yii::app()->session['fullName'] = '';
			Yii::app()->session['fullName'] = $_POST['firstName'] .'&nbsp;'.$_POST['lastName']; 
			
			Yii::app()->user->setFlash('success','Profile successfully updated.');
			$this->renderPartial('aboutme',array("isAjax"=>'true',"data"=>$_POST));
			exit;
		}
		else
		{
			echo Yii::app()->user->setFlash('error', $result['message']); 
		}
	}
	
	
	/*********** 	Logout   ***********/ 
	function actionLogout()
	{
		error_reporting(0);
		if(isset($_POST['submit']))
		{	
			if(!isset(Yii::app()->session['shiftId']) || Yii::app()->session['shiftId'] == "")
			{
				Yii::app()->session->destroy();	
				$this->redirect(array("pos/index"));		
			}
/*------------------------------- Check Closing Shift Detail Start-------------------------------------*/
			$adminObj=Admin::model()->findByPk(Yii::app()->session['farmsourcing_posUser']);
			$url = Yii::app()->params->base_url."timthumb/timthumb.php?src=".Yii::app()->params->base_url."assets/upload/clientLogo/".$adminObj->company_logo."&h=100&w=150&q=60&zc=0" ;

			$admin_id = $adminObj->id ;
			$store_id = $adminObj->email ;
			
			$shiftObj = new Shift();
			$shiftData = $shiftObj->getShiftSummary();
			
			$soDetailsObj = new SoDesc();
			$ticketData = $soDetailsObj->getSoDescDetailsByShiftId(Yii::app()->session['shiftId']);
			
			$totalSalesAmount = 0;
			
			foreach ($ticketData as $tickets)
			{
				$totalSalesAmount = $totalSalesAmount + ( $tickets['quantity'] *   $tickets['product_price'] ) ;
			}
			/*echo "<pre>";
			print_r($shiftData);
			exit;*/
			$vaultObj = new Vault();
			$vaultData = $vaultObj->getVaultDetails($shiftData['shift_id']);
			
			$totalDeposite = ($vaultData['deposite'])-($vaultData['withdraw']);
			
			$finalTotalIncoming = $shiftData['cash_in'] + $vaultData['withdraw'] + $totalSalesAmount;
			$finalTotalOutgoing = $vaultData['deposite'] ;
			
			$finalTotalCash = $finalTotalIncoming - $finalTotalOutgoing ; 
			
			$finalCashShiftOut =  $_POST['cash_out']  ;
			
			$difference = $finalCashShiftOut - $finalTotalCash ;
			
/*------------------------------- Check Closing Shift Detail Finish-------------------------------------*/			
			
			
			$filename = Yii::app()->session['farmsourcing_posUser'].'_SHIFT_'.Yii::app()->session['shiftId']."_".date("Ymd");
				$data['cashier_id']	= Yii::app()->session['farmsourcing_posUser'];
				$data['cash_in']=Yii::app()->session['cash_in'];
				$data['cash_out']	=$_POST['cash_out'];
				$data['time_out']=date('Y-m-d:H-m-s');
				$data['admin_id'] = Yii::app()->session['farmsourcing_posUser'];
				$data['fileName']=$filename;
				
				$shiftObj = new Shift();
				$shiftObj->setData($data);
				$shiftObj->insertData(Yii::app()->session['lastId']);
				
				
				$shiftObj = new Shift();
				$shiftData = $shiftObj->getShiftSummary();
				
				//$ticketDetailsObj = new TicketDetails();
				//$ticketData = $ticketDetailsObj->getDailyTotalSalesAmount();
				
				$cash = $totalSalesAmount;
				
				//echo "CashOut : ".$shiftData['cash_out'];
//				echo "- withdraw : ".$vaultData['withdraw'];
//				echo "+ deposite : ".$vaultData['deposite'];
//				echo "+ returnAmount : ".$returnAmount;
//				echo "- cash : ".$cash;
//				echo "- cash_in : ".$shiftData['cash_in'] ;
//				exit;
//				
				$difference = $shiftData['cash_out'] - $vaultData['withdraw'] +  $vaultData['deposite'] - $cash - $shiftData['cash_in'] ;
				//echo "<pre>";
//				print_r($shiftData);
//				print_r($ticketData);
//				print_r($salesReturnData);
//				print_r($vaultData);
//				print_r($custGeneralData);
//				exit;
				
				
				$html = "
						<table cellpadding='5' cellspacing='5' border='0'>
						<tr>
							<td colspan='4' align='center' style='background-color:#000; color:#FFF;'><b>".$adminObj->company_name."</b></td>
						</tr>
						<tr>
							<td colspan='4' align='right'>date :: ".date('Y-m-d')."</td>
						</tr>
	
						<tr>
							<td colspan='4'>&nbsp;</td>
						</tr>
						<tr>
							<td colspan='4' align='center'><b>SHIFT END REPORT [ <a href='".Yii::app()->params->base_path."pos'>Back</a> ] </b></td>
						</tr>
						<tr bgcolor='#FFFF99'>
							<td>SHIFT ID</td>
							<td>CASHER</td>
							<td>SHIFT IN</td>
							<td>SHIFT OUT</td>
						</tr>
						<tr>
							<td>".$shiftData['shift_id']."</td>
							<td>".Yii::app()->session['fullName']."</td>
							<td>".$shiftData['time_in']."</td>
							<td>".$shiftData['time_out']."</td>
						</tr>
						<tr bgcolor='#FFFF99'>
							<td>NO.</td>
							<td>PARTICULARS</td>
							<td align='right'>AMOUNT*(".Yii::app()->session['currency'].")</td>
							<td></td>
						</tr>
						<tr>
							<td>1</td>
							<td><b>Opening Cash in Cash Counter</b></td>
							<td align='right'><b>".$shiftData['cash_in']."</b></td>
							<td>+</td>
						</tr>
						<tr>
							<td>2</td>
							<td><b>Sales:</b></td>
							<td></td>
							<td></td>
						</tr>
							<tr>
								<td></td>
								<td>Cash</td>
								<td align='right'>".$cash."</td>
								<td></td>
							</tr>
							<tr>
								<td></td>
								<td align='right'><b>TOTAL SALES</b></td>
								<td align='right'><b>".($cash)."</b></td>
								<td>+</td>
							</tr>
						<tr>
							<td>4</td>
							<td><b>Safe Vault:</b></td>
							<td></td>
							<td></td>
						</tr>
							<tr>
								<td></td>
								<td>Cash Withdraw</td>
								<td align='right'>".$vaultData['withdraw']."</td>
								<td></td>
							</tr>
							<tr>
								<td></td>
								<td>Cash Deposit</td>
								<td align='right'>".$vaultData['deposite']."</td>
								<td></td>
							</tr>
							<tr>
								<td></td>
								<td align='right'><b>TOTAL DROPPED IN SAFE</b></td>
								<td align='right'><b>".$totalDeposite."</b></td>
								<td>-</td>
							</tr>
						<tr>
							<td>5</td>
							<td><b>Closing Balance in Cash Counter:</b></td>
							<td></td>
							<td></td>
						</tr>
							<tr>
								<td></td>
								<td>Cash Balance</td>
								<td align='right'>".$shiftData['cash_out']."</td>
								<td></td>
							</tr>
							<tr>
								<td></td>
								<td>Difference In  Balance</td>
								<td align='right'>".$difference."</td>
								<td></td>
							</tr>
					</table>";
				
				$mpdf = new mPDF();
		
				
				$mpdf->WriteHTML($html);
				$mpdf->Output(FILE_PATH."assets/upload/pdf/".$filename.".pdf", 'F');
					
				
				Yii::app()->session->destroy();			
				
				
				Yii::app()->session['prefferd_language']=$temp;		
				header('location:'.Yii::app()->params->base_url."assets/upload/pdf/".$filename.".pdf");
				exit;
			
			
		
		
	}
	else
		{
			if($this->isAjaxRequest())
			{	
				$this->renderPartial('exit',array("isAjax"=>'true'));
			}
			else
			{
				$this->render('exit',array("isAjax"=>'false'));
			}		
		}
}
	
	
	
	

public function actionproductDescription($id=NULL)
{
	
	$productObj	=	new Product();
	$data	=	$productObj->getProductDetails($id);
	$this->renderPartial('productDescription', array('data'=>$data));
}

public function actionproductDescriptionFromProductList($id=NULL)
{
	$productObj	=	new Product();
	$data	=	$productObj->getProductDetails($id);
	$this->renderPartial('productDescriptionFromProduct', array('data'=>$data));
}

/*********** 	ITEMS ASSIGNED BY ME FUNCTION  ***********/
	public function actionticketDetail()
	{
		if(!isset(Yii::app()->session['farmsourcing_posUser']))
		{
			$this->redirect('index');
			exit;
		}
		
		$SoDetailsObj	=	new SoDetails();
		$data	=	$SoDetailsObj->getsalesOrderData($_REQUEST['id']);
		
		$soDescObj	=	new SoDesc();
		$productData	=	$soDescObj->getSoDescDetails($_REQUEST['id']);
		
		$this->renderPartial('ticketDescription', array('data'=>$data,'productData'=>$productData));
	}
	
	function actionraiseDeliverySlip($id)
	{
		//error_reporting(E_ALL);
		$SoDescObj  = new SoDesc();
		$deliveryData = $SoDescObj->getSoDescDetails($id);
		
		$admin_id = Yii::app()->session['farmsourcing_posUser'];
		
		$adminObj=Admin::model()->findByPk($admin_id);
		
		$companyDetailsObj	=	new CompanyDetails();
		$adminDetails = $companyDetailsObj->getCompanyDetailsByAdminId($admin_id);
		
		$url = Yii::app()->params->base_url."timthumb/timthumb.php?src=".Yii::app()->params->base_url."assets/upload/clientLogo/".$adminDetails['company_logo']."&h=100&w=100&q=60&zc=0" ;
		
		$urlLogo = Yii::app()->params->base_url."timthumb/timthumb.php?src=".Yii::app()->params->base_url."images/logo/farmsource_logo.png&h=100&w=200&q=60&zc=0" ;
		
		//$url = Yii::app()->params->base_url."timthumb/timthumb.php?src=".Yii::app()->params->base_url."assets/upload/clientLogo/".$adminObj->company_logo."&h=100&w=150&q=60&zc=0" ;

		$SoDescObj  = new SoDetails();
		$delivery_detail = $SoDescObj->getsalesOrderData($id);
		
		//echo "totalRemainingCredit=".$totalRemainingCredit;
		//exit;
		if($delivery_detail['customer_name'] != "")
		{
			$customer = $delivery_detail['customer_name'];
			$to = 'TO,CUSTOMER: '	;
		
		}
		else
		{
			$customer = 'Cash Sale';	
		}
		
		if($delivery_detail['cust_address'] != "")
		{
			$customer_address = ''.$delivery_detail['cust_address'] ;
		}
		
		/*if($delivery_detail['credit_amount'] != "")
		{
			$credit_amount = $delivery_detail['credit_amount'] ;
		}*/
		
		if($delivery_detail['customer_id'] != "")
		{
			//$deliveryDescObj = new DeliveryDesc();
			//$creditData = $deliveryDescObj->getCustomerRemainingAmountOfAllOrder($delivery_detail['customer_id']);
			
			$SoDetailsObj = new SoDetails();
			$total_credit_amount_by_customer_id = $SoDetailsObj->getSumOfCreditByCustomerId($delivery_detail['customer_id']);
			
			//echo "<pre>";
			//print_r($creditData);
			
			if($delivery_detail['credit_amount'] != "")
			{
				$credit_amount = $delivery_detail['credit_amount'] ;
			}
			
			if($total_credit_amount_by_customer_id!=0)
			{
				$totalRemainingCredit = $total_credit_amount_by_customer_id ;
			}else{
				$totalRemainingCredit = 0 ;
			}
			
			
		}
		else
		{
			$totalRemainingCredit = 0 ;
		}
		
		
		
		if(Yii::app()->session['currency'] == "INR")
		{
			$currency = 'Rs.' ;
		}else{
			$currency = Yii::app()->session['currency'] ;
		}
		
		$orderType = 'FNP store' ;
		
		$html = '<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Untitled Document</title>
		<style type="text/css">
		body,td,th {
			font-family: Arial, Helvetica, sans-serif;
			font-size: 12px;
		}
		
		.border
		{
		   border-left:1px;
		   border-bottom:1px;
		   border-top:1px;
		   border-right:1px;
		}
		
		.noborder
		{
		
		   border-left:0px;
		   border-bottom:0px;
		}
		
		.noborder1
		{
		
		   border-left:0px;
		   border-bottom:0px;
		   border-top:0px;
		}
		</style>
		</head>
		
		<body>
		<div style="border:0px solid; padding:10px 10px 10px 10px;">
		<table width="100%" border="0" cellspacing="0" cellpadding="2">
		  <tr>
		  <td align="left" width="33%"><img src="'.$url.'" /><br/><b>www.freshnpack.com</b></td>
		  <td width="33%"><img src="'.$urlLogo.'" /></td>
		   <td  align="right" width="33%"><span>Customer Care No.</span><br/><b style="font-size:12px;">079-40053900 / 079-40056900</b></td>
		  </tr>
		  <tr>
			<td colspan="3" align="center">Shop Address: 23,24 Ground floor, Management enclave,Opp. Indraprastha bung. Vastrapur - Mansi road, Vastrapur 380015. <br/> Phone : 079-40053900 / 079-40056900</td>
		  </tr>
          </table>
          
         <table width="100%" style="border:0px solid black;" cellspacing="0" cellpadding="2">
            <tr>
                <td align="right" width="25%" style = "border-left:0px solid black;">Invoice No:</td>
                <td align="left">'.$id.'</td>
				<td align="right" width="25%" style = "border-left:0px solid black;">Invoice Date :</td>
                <td align="left">'. date('d-m-Y',strtotime($delivery_detail['delivery_date'])).'</td>
            </tr>
			 <tr>
              
				<td align="right" style = "border-left:0px solid black;">Customer :</td>
                <td align="left" colspan="2" >'. $customer.'</td>
            </tr>
	   </table>
       
		
        <table width="100%"  border="0" cellpadding="2"  cellspacing="0" style="margin-top:5px;">
            <tr align="center" valign="middle">
                <td align="center" width="5%"><strong>ITEM CODE</strong></td>
                <td align="center" width="50%"><strong>ITEM NAME</strong></td>
                <td align="center" width="10%"><strong>WEIGHT</strong></td>
                <td align="center" width="10%"><strong>RATE</strong></td>
                <td align="center" width="10%"><strong>AMOUNT</strong></td>
            </tr>';
		  $i=1;
		  $finalAmount = 0 ;
		
		foreach($deliveryData as $row) {
			
		$finalAmount = $finalAmount + ($row['product_price'] * $row['quantity']) ;
		
		if(isset($row['discount_desc']) && $row['discount_desc'] != "")
		{
			$discount_desc = '</br>- '.$row['discount_desc'] ;
		}else{
			$discount_desc = "";
		}
		
		$html .=  '<tr>
			<td align="center">&nbsp;'.$row['product_id'].'</td>
			<td align="left" height="20">&nbsp;'.$row['product_name'].$discount_desc.'</td>
			<td align="right">'.$row['quantity'].'&nbsp;</td>
			<td align="right">&nbsp;'.round($row['product_price'],0).'</td>
			<td align="right">&nbsp;'.round(($row['product_price'] * $row['quantity']), 0).'</td>
		  </tr>
		 
		  ';
   $i++; } 
   		
		$realAmount = $finalAmount - (round($delivery_detail['discount_amount'], 0)) - (round($credit_amount, 0));
		$html .= '
		 <tr>
					<td align="left" colspan="3">&nbsp;&nbsp;</td>
					<td align="right">CREDIT(-)</td>
					<td align="right">&nbsp;'.round($credit_amount, 0).'</td>
				</tr>
		<tr>
					<td align="left" colspan="3">&nbsp;&nbsp;</td>
					<td align="right">DISCOUNT(-)</td>
					<td align="right">&nbsp;'.round($delivery_detail['discount_amount'], 0).'</td>
				</tr>
				
				
		<tr>
					<td align="left" colspan="3" style="font-size:10px;">Subject to Ahmedabad Jurisdiction &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; E.&amp; O.E.</td>
					<td align="right">TOTAL('.$currency.')</td>
					<td align="right">&nbsp;'.round($realAmount, 0).'</td>
				</tr>	
				<tr>
					<td  colspan="3">&nbsp;</td>
					<td align="right">TOTAL REMAINING CREDIT </td>
					<td align="right">'.$totalRemainingCredit.'</td>
				</tr>
					
       </table>
        </div></body>
		</html>';
		
		//echo $html; exit;
		//$mpdf=new mPDF('c','A5'); 
		//$mpdf = new mPDF('','A5');
		//$mpdf = new mPDF('',array(86,52),$default_font_size=0,$default_font='',$mgl=0,$mgr=0,$mgt=0,$mgb=0,$mgh=0,$mgf=0, $orientation='P');
		
		
		$mpdf = new mPDF('','A6',$default_font_size=0,$default_font='',$mgl=0,$mgr=0,$mgt=0,$mgb=0,$mgh=0,$mgf=0, $orientation='P');
		//$mpdf->SetDisplayMode('fullpage');
		$mpdf->WriteHTML($html);
		$mpdf->Output(FILE_PATH."assets/upload/salesOrder/salesOrder_".$id."_".$admin_id.".pdf", 'F');
		
		$this->actionhome();
		?>
        
        <script>
			window.open("<?php echo Yii::app()->params->base_url;?>assets/upload/salesOrder/salesOrder_<?php echo $id;?>_<?php echo $admin_id;?>.pdf",'_blank');
		</script>
        
		<?php
		
		ob_flush();
		ob_clean();
		//$this->redirect(Yii::app()->params->base_url."pos");
		return true;
	}
	
	function actioneditOrderbyProductCode()
	{
		//unset( $_SESSION['cartData']);exit;
		$productObj = new Product();
		$checkData = $productObj->getAllDetailOfProductById($_REQUEST['id']);
		
		if(!empty($checkData))
		{
			$product_id = $_REQUEST['id'];       
			if(isset($_SESSION['fnp_store_cartData']))
			{
				$bool = 0;				 
				foreach($_SESSION['fnp_store_cartData'] as $arrays){
					if($arrays['product_id'] == $_REQUEST['id'])
					{
						echo -1 ;
						exit;
					}
				}
				
				if($bool == 0)
				{
					$data['product_id']=$product_id;
					$data['qty']= 1;
					$data['packaging_scenario'] = '';
					$_SESSION['fnp_store_cartData'][] = $data ;
					exit;
				}
			}     
			else
			{
				$data['product_id']=$product_id;
				$data['qty']= 1;
				$data['packaging_scenario'] = '';
				$_SESSION['fnp_store_cartData'][] = $data ;
				exit;
			}
		}else{
			echo 0 ;
			exit;
		}
	}
	
	function actionchangePassword()
	{
		error_reporting(E_ALL);
		if(isset($_REQUEST['id']) && $_REQUEST['id'] != '')
		{
			$admin_id = Yii::app()->session['farmsourcing_posUser'];
			
			$adminObj=Admin::model()->findbyPk($admin_id);
			$res = $adminObj->attributes;
			
			$generalObj = new General();
			$res = $generalObj->validate_password($_POST['oldpassword'],$res['password']);
	
			if($res!=true)
			{	
				Yii::app()->user->setFlash("error","Old Password is wrong.");
			}
			else
			{
				$generalObj = new General();
				$password_flag = $generalObj->check_password($_POST['newpassword'],$_POST['confirmpassword']);
	
				switch ($password_flag) {
					case 0:
						$pass_flag = 0;
						break;
					case 1:
						
						Yii::app()->user->setFlash("error","Please don't enter blank password.");
						$pass_flag = 1;
						break;
					case 2:
						
						Yii::app()->user->setFlash("error","Password minimum length need to six character.");
						$pass_flag = 1;
						break;
					case 3:
						Yii::app()->user->setFlash("error","Password is not match with confirm password.");
						$pass_flag = 1;
						break;
				}
			
				if ($pass_flag == 0) {
					if (isset($_POST['oldpassword'])) {
						if (strlen($_POST['oldpassword']) < 1) {
							
							 Yii::app()->user->setFlash("error",$this->msg['WRONG_PASS_MSG']);
						} else if (strlen($_POST['newpassword']) < 5) {
							
							 Yii::app()->user->setFlash("error",$this->msg['_VALIDATE_PASSWORD_GT_6_']);
						} else if ($_POST['newpassword'] != $_POST['confirmpassword']) {
							
							 Yii::app()->user->setFlash("error",$this->msg['_CONFIRM_PASSWORD_NOT_MATCH_']);
						} else {
							$_POST['password'] = $_POST['newpassword'];
							$admin = new admin();
							$result = $admin->changePassword($admin_id, $_POST);
							Yii::app()->user->setFlash('success',"Successfully Changed Password.");
						}
					}
				}
			}
		}
		
		$this->renderpartial("changepassword");
	}
	
	
	
}