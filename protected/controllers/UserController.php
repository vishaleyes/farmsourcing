<?php
error_reporting(0);
date_default_timezone_set("Asia/Kolkata");
require_once(FILE_PATH."/protected/extensions/mpdf/mpdf.php");
class UserController extends Controller
{
	public $msg;
	public $errorCode;
	private $arr = array("rcv_rest" => 200370,"rcv_rest_expire" => 200371,"send_sms" => 200372,"rcv_sms" => 200373,"send_email" => 200374,"todo_updated" => 200375, "reminder" => 200376, "notify_users" => 200377,"rcv_rest_expire"=>200378,"rcv_android_note"=>200379,"rcv_iphone_note"=>200380);
	
	public function beforeAction($action=NULL)
	{
		//exit(stop);
		$this->msg = Yii::app()->params->msg;
		$this->errorCode = Yii::app()->params->errorCode;
		if($this->isAjaxRequest())
		{			
			if(!$this->isLogin())
			{
				Yii::app()->user->logout();
				Yii::app()->session->destroy();
				echo "logout";
				exit;							
			}
		}
		else
		{
			//var_dump($this->isLogin());
			//exit;
			if(!$this->isLogin())
			{	
				Yii::app()->user->logout();
				Yii::app()->session->destroy();
				if(isset($_REQUEST['id']) && $_REQUEST['id']!='')
				{					
					Yii::app()->session['todoId']=$_REQUEST['id'];
					$this->redirect(Yii::app()->params->base_path.'site/signin&todoId='.$_REQUEST['id']);
					exit;
				}
				$this->redirect(Yii::app()->params->base_path.'site');
				exit;
			}
			
		}
		return true;
	
	}
	
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}
	
	public function actionIndex()
	{
		$this->isLogin();
		$productObj = new Product();
			$featureProductData = $productObj->getFeaturedProducts();
			
			$featureProductData1[0] =  $featureProductData[0];
			$featureProductData1[1] =  $featureProductData[1];
			$featureProductData1[2] =  $featureProductData[2];
			
			$featureProductData2[3] =  $featureProductData[3];
			$featureProductData2[4] =  $featureProductData[4];
			$featureProductData2[5] =  $featureProductData[5];
			
			$productObj = new Product();
			$recentProductData = $productObj->getRecentProducts();
			
			
			
			$recentProductData1[0] =  $recentProductData[0];
			$recentProductData1[1] =  $recentProductData[1];
			$recentProductData1[2] =  $recentProductData[2];
			
			$recentProductData1[3] =  $recentProductData[3];
			$recentProductData2[4] =  $recentProductData[4];
			$recentProductData2[5] =  $recentProductData[5];
			$recentProductData2[6] =  $recentProductData[6];
			$recentProductData2[7] =  $recentProductData[7];
			
			$productObj = new Product();
			$specialProductData = $productObj->getSpecialProducts();
			
			$specialProductData[0] =  $specialProductData[0];
			$specialProductData[1] =  $specialProductData[1];
			$specialProductData[2] =  $specialProductData[2];
			
			$this->render('index',array("featureProductData1"=>$featureProductData1,"featureProductData2"=>$featureProductData2,"recentProductData1"=>$recentProductData1,"recentProductData2"=>$recentProductData2,"specialProductData"=>$specialProductData));
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
	
	function isLogin()
	{
	   
	 // echo Yii::app()->session['farmsoucing_userId'];
		if(!Yii::app()->session['farmsoucing_userId']){
			//exit("if");
			Yii::app()->session->destroy();
			return false;
		}else{
			
			$userId=Yii::app()->session['farmsoucing_userId'];	
			$user=new Users();
			$data=$user->getUserDataById($userId);
			//print_r($data);
			if(!$data)
			{
				//exit("In else");
				Yii::app()->session->destroy();
				return false;			
			}
			return true;
		}
	
	}
	
	public function actionLogOut()
	{
		Yii::app()->session->destroy();
		$this->redirect(array('site/index'));
	}
	
	
	function actionproductListingGrid()
	{
		$this->isLogin();
		
		if(!isset($_REQUEST['sortType']))
		{
			$_REQUEST['sortType']='desc';
		}
		if(!isset($_REQUEST['sortBy']))
		{
			$_REQUEST['sortBy']='p.product_id';
		}
		if(!isset($_REQUEST['keyword']))
		{
			$_REQUEST['keyword']='';
			
		}

		if(isset($_REQUEST['cat_id']) && $_REQUEST['cat_id'] != "")
		{
			$productObj = new Product();
			$productData = $productObj->getAllPaginatedProductListingByCatId(LIMIT_9,$_REQUEST['sortType'],$_REQUEST['sortBy'],$_REQUEST['keyword'],$_REQUEST['cat_id']);
		}else{
			$productObj = new Product();
			$productData = $productObj->getAllPaginatedProductListing(LIMIT_9,$_REQUEST['sortType'],$_REQUEST['sortBy'],$_REQUEST['keyword']);
			
		}
		
		/*if($_REQUEST['sortType'] == 'desc'){
			$ext['sortType']	=	'asc';
			$ext['img_name']	=	'arrow_up.png';
		} else {
			$ext['sortType']	=	'desc';
			$ext['img_name']	=	'arrow_down.png';
		}*/
		$ext['sortType']	=	$_REQUEST['sortType'];
		$ext['keyword']=$_REQUEST['keyword'];
		$ext['sortBy']=$_REQUEST['sortBy'];
		
		$data['pagination']	=	$productData['pagination'];
        $data['productlisting']	=	$productData['listing'];
		
		$this->render("productListingGrid", array('data'=>$data,'ext'=>$ext));
	}
	
	function actionproductListingList()
	{
		$this->isLogin();
		
		if(!isset($_REQUEST['sortType']))
		{
			$_REQUEST['sortType']='desc';
		}
		if(!isset($_REQUEST['sortBy']))
		{
			$_REQUEST['sortBy']='p.product_id';
		}
		if(!isset($_REQUEST['keyword']))
		{
			$_REQUEST['keyword']='';
			
		}

		if(isset($_REQUEST['cat_id']) && $_REQUEST['cat_id'] != "")
		{
			$productObj = new Product();
			$productData = $productObj->getAllPaginatedProductListingByCatId(LIMIT_9,$_REQUEST['sortType'],$_REQUEST['sortBy'],$_REQUEST['keyword'],$_REQUEST['cat_id']);
		}else{
			$productObj = new Product();
			$productData = $productObj->getAllPaginatedProductListing(LIMIT_9,$_REQUEST['sortType'],$_REQUEST['sortBy'],$_REQUEST['keyword']);
			
		}
		
		
		/*if($_REQUEST['sortType'] == 'desc'){
			$ext['sortType']	=	'asc';
			$ext['img_name']	=	'arrow_up.png';
		} else {
			$ext['sortType']	=	'desc';
			$ext['img_name']	=	'arrow_down.png';
		}*/
		$ext['sortType']	=	$_REQUEST['sortType'];
		$ext['keyword']=$_REQUEST['keyword'];
		$ext['sortBy']=$_REQUEST['sortBy'];
		
		$data['pagination']	=	$productData['pagination'];
        $data['productlisting']	=	$productData['listing'];
		
		$this->render("productListingList", array('data'=>$data,'ext'=>$ext));
	}
	
	function actioncategoryListing()
	{
		$this->isLogin();
		
		if(!isset($_REQUEST['sortType']))
		{
			$_REQUEST['sortType']='asc';
		}
		if(!isset($_REQUEST['sortBy']))
		{
			$_REQUEST['sortBy']='c.category_name';
		}
		if(!isset($_REQUEST['keyword']))
		{
			$_REQUEST['keyword']='';
			
		}

		$categoryObj = new Category();
		$categoryData = $categoryObj->getAllPaginatedCategory($_REQUEST['sortType'],$_REQUEST['sortBy'],$_REQUEST['keyword']);
		
		
		/*if($_REQUEST['sortType'] == 'desc'){
			$ext['sortType']	=	'asc';
			$ext['img_name']	=	'arrow_up.png';
		} else {
			$ext['sortType']	=	'desc';
			$ext['img_name']	=	'arrow_down.png';
		}*/
		$ext['keyword']=$_REQUEST['keyword'];
		$ext['sortBy']=$_REQUEST['sortBy'];
		$ext['sortType']=$_REQUEST['sortType'];
		
		$data['pagination']	=	$categoryData['pagination'];
        $data['categorylisting']	=	$categoryData['category'];
		
		$this->render("categoryListing", array('data'=>$data,'ext'=>$ext));
	}
	
	function actionproductDescription()
	{
		if(isset($_REQUEST['id']) && $_REQUEST['id'] != "")
		{
			$product_id = $_REQUEST['id'];
			$productObj = new Product();
			$productData = $productObj->getAllDetailOfProductById($product_id);
			
			$productObj = new Product();
			$relatedProductData = $productObj->getRelativeProducts($productData['cat_id'],$product_id);
			
			$relatedProductData1[0] =  $relatedProductData[0];
			$relatedProductData1[1] =  $relatedProductData[1];
			$relatedProductData1[2] =  $relatedProductData[2];
			$relatedProductData1[3] =  $relatedProductData[3];
			
			$relatedProductData2[4] =  $relatedProductData[4];
			$relatedProductData2[5] =  $relatedProductData[5];
			$relatedProductData2[6] =  $relatedProductData[6];
			$relatedProductData2[7] =  $relatedProductData[7];
			
			$productObj = new Product();
			$specialProductData = $productObj->getSpecialProducts();
			
			$specialProductData[0] =  $specialProductData[0];
			$specialProductData[1] =  $specialProductData[1];
			$specialProductData[2] =  $specialProductData[2];
			
			$this->render('productDescription',array("specialProductData"=>$specialProductData,"relatedProductData1"=>$relatedProductData1,"relatedProductData2"=>$relatedProductData2,"productData"=>$productData));
		}else{
			header('location:'.Yii::app()->params->base_path.'user/Index');
		}
	}
	
	function actionaddToCartOld()
	{
		//unset( $_SESSION['cartData']);exit;
		if(isset($_REQUEST['id']) && $_REQUEST['id'] != "" )
		{
			$productObj = new Product();
			$checkData = $productObj->getAllDetailOfProductById($_REQUEST['id']);
			
			if(!empty($checkData))
			{
				$product_id = $_REQUEST['id'];       
				if(isset($_SESSION['cartData']))
				{
					$bool = 0;				 
					foreach($_SESSION['cartData'] as $arrays){
					if($arrays['product_id'] == $_REQUEST['id'])
					{
					$bool = 1;
					}
				}
				
				if($bool == 0)
				{
					$data['product_id']=$product_id;
					$data['qty']= 1;
					$data['packaging_scenario'] = '';
					$_SESSION['cartData'][] = $data ;
				}
			}     
			else
			{
				$data['product_id']=$product_id;
				$data['qty']= 1;
				$data['packaging_scenario'] = '';
				$_SESSION['cartData'][] = $data ;
			}
		}
	}
		
		//$cartData = Yii::app()->session['cartData'];
		if(isset($_SESSION['cartData']) && !empty($_SESSION['cartData']))
		{
			foreach($_SESSION['cartData'] as $row)
			{
				
				$productObj = new Product();
				$productData[] = $productObj->getAllDetailOfProductById($row['product_id']);
				
			}
			
			$this->render("cart",array("productData"=>$productData));
		}else{
			$productData = "";
			$this->render("cart",array("productData"=>$productData));
		}
		
	}
	
	function actionaddToCart()
	{
		//unset( $_SESSION['cartData']);exit;
		if(isset($_REQUEST['id']) && $_REQUEST['id'] != "" )
		{
			$productObj = new Product();
			$checkData = $productObj->getAllDetailOfProductById($_REQUEST['id']);
			
			if(!empty($checkData))
			{
				$product_id = $_REQUEST['id'];       
				if(isset($_SESSION['cartData']))
				{
					$bool = 0;				 
					foreach($_SESSION['cartData'] as $arrays){
					if($arrays['product_id'] == $_REQUEST['id'])
					{
					$bool = 1;
					}
				}
				
				if($bool == 0)
				{
					$data['product_id']=$product_id;
					$data['qty']= 1;
					$data['packaging_scenario'] = '';
					$_SESSION['cartData'][] = $data ;
				}
			}     
			else
			{
				$data['product_id']=$product_id;
				$data['qty']= 1;
				$data['packaging_scenario'] = '';
				$_SESSION['cartData'][] = $data ;
			}
		}
	}
		
		Yii::app()->user->setFlash("success","Product added in the cart successfully.");
		header('location:' .  $_SERVER['HTTP_REFERER']);
		exit;
		
	}
	
	function actioncart()
	{
		if(isset($_SESSION['cartData']))
		{
			foreach($_SESSION['cartData'] as $row)
			{
				
				$productObj = new Product();
				$productData[] = $productObj->getAllDetailOfProductById($row['product_id']);
			}
		}else{
			$productData = "";
		}
			
		$this->render("cart",array("productData"=>$productData));
	}
	
	function actionremoveProductFromCart()
	{
		if(isset($_REQUEST['removeId']) && $_REQUEST['removeId'] != "")
		{
			unset($_SESSION['cartData'][$_REQUEST['removeId']]);
		}
		
		$i = 0 ;
		if(isset($_SESSION['cartData']))
		{
			$sessionData = $_SESSION['cartData'];
			unset($_SESSION['cartData']);
			
			foreach($sessionData as $row)
			{
				$data['product_id']=$row['product_id'];
				$data['qty']= $row['qty'];
				$data['packaging_scenario'] = $row['packaging_scenario'];
				$_SESSION['cartData'][$i] = $data ;
				
				$productObj = new Product();
				$productData[] = $productObj->getAllDetailOfProductById($row['product_id']);
				$i++;
			}
		}
			
		$this->redirect(array("user/cart"));
	}
	
	function actioncheckOutCart()
	{
		if(isset($_POST['FormSubmit']) && $_POST['count'] > 0)
		{
			$count = $_POST['count'];
			
			if(isset($_POST['delivery_date']) && $_POST['delivery_date'] == '' )
			{
				Yii::app()->user->setFlash('error',"Please select delivery date of order.");
				$this->redirect(array("user/cart"));
				exit;
			}
			
			for($g=1;$g<=$count;$g++)
			{	
			  if($_POST['packaging_scenario'.$g.''] == '' )
			  {
				  	Yii::app()->user->setFlash('error',"Please select packaging scenario.");
				    $this->redirect(array("user/cart"));
					exit;
			  }
			}
			
			$data = array();
			$data['createdAt'] = date("Y-m-d H:i:s");
			
			if(isset(Yii::app()->session['order_coupon_amount']) && 
				Yii::app()->session['order_coupon_amount'] > 0 && 
				isset(Yii::app()->session['order_coupon_code']))
			{
				$coupon_amount = Yii::app()->session['order_coupon_amount'] ;
			}else{
				$coupon_amount = 0 ;
			}
			
			$so_detail['admin_id'] = 1 ;
			$so_detail['customer_id'] = $_POST['customer_id'];
			$so_detail['total_item'] = $count;
			$so_detail['coupon_amount'] = $coupon_amount ;
			//$so_detail['delivery_date'] =  date("Y-m-d",strtotime($_POST['delivery_date']));
			$so_detail['delivery_date'] =  date("Y-m-d",strtotime($_POST['delivery_date']));
			$so_detail['status'] = 0 ;
			$so_detail['type'] = 2 ;
			$so_detail['isSynced'] = 0 ;
			$so_detail['createdAt'] = date("Y-m-d H:i:s");
			$so_detail['modifiedAt'] = date("Y-m-d H:i:s");
			
			$SoDetailsObj = new SoDetails();
			$SoDetailsObj->setData($so_detail);
			$soId = $SoDetailsObj->insertData();
			
			$data['so_id'] = $soId;
			$data['admin_id'] = 1 ;
			
			$total_packets = 0 ;
			for($i=1;$i<=$count;$i++)
			{	
				$productObj = new Product();
				$priceData = $productObj->getProductById($_POST['product_id'.$i.'']);
				
			  	$data['packaging_scenario'] = $_POST['packaging_scenario'.$i.''];
				$data['no_of_packets'] = $_POST['p_quantity'.$i.''];	
				$data['product_price'] = $_POST['product_price'.$i.''];			
				$data['quantity'] = $data['packaging_scenario'] * $data['no_of_packets'];
				$data['product_id'] = $_POST['product_id'.$i.''];
				$data['delivery_date'] = $so_detail['delivery_date'];
				$data['actual_product_price'] = $priceData['product_price'];
				
				$productDiscount = $data['actual_product_price'] - $data['product_price'];
				
				$finalDiscountAmount = ($data['quantity'] * $data['actual_product_price'] * $productDiscount) / $data['actual_product_price'] ;
				
				$data['discount_amount'] = $finalDiscountAmount;
				$data['discount_desc'] = $_POST['discount_desc'.$i.''];
				$data['createdAt'] = date("Y-m-d H:i:s");
				$data['modifiedAt'] = date("Y-m-d H:i:s");
				
				$SoDescObj = new SoDesc();
				$SoDescObj->setData($data);
				$SoDescObj->insertData();
				
				$total_packets = $total_packets + $data['no_of_packets'];
			  
			}
			
			$newData['total_packets'] = $total_packets ;
			$newData['modifiedAt'] =  date("Y-m-d H:i:s");
			
			$SoDetailsObj = new SoDetails();
			$SoDetailsObj->setData($newData);
			$SoDetailsObj->insertData($soId);
			
			//$this->actionraiseSalesOrder($soId);
			Yii::app()->user->setFlash('success',"Sales Order created successfully.");
			
			$promocodesObj =  new Promocodes();
			$promocodeData = $promocodesObj->checkPromocodeUniqueId(Yii::app()->session['order_coupon_code']);
			if(!empty($promocodeData))
			{
				$data = array();
				$data['isUsed'] = 1;
				$data['status'] = 1;
				$promocodesObj =  new Promocodes();
				$promocodesObj->setData($data);
				$promocodesObj->insertData($promocodeData['promocode_id']);
					
			}
			
			unset($_SESSION['cartData']);
			unset(Yii::app()->session['order_coupon_amount']);
			unset(Yii::app()->session['order_coupon_code']);
		}
			
		$this->redirect(array("user/index"));
	}
	
	function actionupdateCartSession()
	{
		$key = $_REQUEST['sessionKey'];	
		$qty = $_REQUEST['no_of_packets']; 
		$packaging_scenario = $_REQUEST['packaging_scenario']; 

		$_SESSION['cartData'][$key]['qty']= $qty;
		$_SESSION['cartData'][$key]['packaging_scenario']= $packaging_scenario;
			
		return true;
	}
	
	function actionsearchProducts()
	{
		//print "<pre>";
		//print_r($_REQUEST);
		if(!isset($_REQUEST['sortType']))
		{
			$_REQUEST['sortType']='desc';
		}
		if(!isset($_REQUEST['sortBy']))
		{
			$_REQUEST['sortBy']='p.product_id';
		}
		if(!isset($_REQUEST['keyword']))
		{
			$_REQUEST['keyword']='';
			
		}
		if(!isset($_REQUEST['limit']))
		{
			$limit='9';
			
		}

		if(isset($_REQUEST['category']) && $_REQUEST['category'] != "")
		{ 
			$productObj = new Product();
			$productData = $productObj->getAllPaginatedProductListingByCatId($limit,$_REQUEST['sortType'],$_REQUEST['sortBy'],$_REQUEST['keyword'],$_REQUEST['category']);
		}else{
			$productObj = new Product();
			$productData = $productObj->getAllPaginatedProductListing($limit,$_REQUEST['sortType'],$_REQUEST['sortBy'],$_REQUEST['keyword']);
			
		}
		
		if($_REQUEST['sortType'] == 'desc'){
			$ext['sortType']	=	'asc';
			$ext['img_name']	=	'arrow_up.png';
		} else {
			$ext['sortType']	=	'desc';
			$ext['img_name']	=	'arrow_down.png';
		}
		$ext['keyword']=$_REQUEST['keyword'];
		$ext['sortBy']=$_REQUEST['sortBy'];
		
		$data['pagination']	=	$productData['pagination'];
        $data['productlisting']	=	$productData['listing'];
		
		$this->render("productListingGrid", array('data'=>$data,'ext'=>$ext));
		exit;
	}
	
	function actionorderHistoryListing()
	{
		$this->isLogin();
		if(!isset($_REQUEST['sortType']))
		{
			$_REQUEST['sortType']='desc';
		}
		if(!isset($_REQUEST['sortBy']))
		{
			$_REQUEST['sortBy']='so_id';
		}
		if(!isset($_REQUEST['keyword']))
		{
			$_REQUEST['keyword']='';
			
		}
		if(!isset($_REQUEST['limit']))
		{
			$limit='9';
			
		}

		
			$soDetailsObj = new SoDetails();
			$soData = $soDetailsObj->getAllPaginatedOrderHistory($limit,$_REQUEST['sortType'],$_REQUEST['sortBy'],$_REQUEST['keyword'],Yii::app()->session['customer_id']);
		
		
		
		if($_REQUEST['sortType'] == 'desc'){
			$ext['sortType']	=	'asc';
			$ext['img_name']	=	'arrow_up.png';
		} else {
			$ext['sortType']	=	'desc';
			$ext['img_name']	=	'arrow_down.png';
		}
		$ext['keyword']=$_REQUEST['keyword'];
		$ext['sortBy']=$_REQUEST['sortBy'];
		
		$data['pagination']	=	$productData['pagination'];
        $data['orderlisting']	=	$soData['listing'];
		
		$this->render("orderHistory", array('data'=>$data,'ext'=>$ext));
	}
	
	function actionshowSoDetail()
	{
		$this->isLogin();
			
		$SoDetailsObj = new SoDetails();
		$soDetailsData = $SoDetailsObj->getsalesOrderData($_REQUEST['id']);
		
		$SoDescObj = new SoDesc();
		$soDescData = $SoDescObj->getSoDescDetails($_REQUEST['id']);
		
		$this->render("salesOrderDetails",array("soDescData"=>$soDescData,"soDetailsData"=>$soDetailsData));
		exit;
	}
	
	function actionemptyCart()
	{
		if(isset($_SESSION['cartData']))
		{
			unset($_SESSION['cartData']);	
		}
		
		if(isset(Yii::app()->session['order_coupon_amount']))
		{
			unset(Yii::app()->session['order_coupon_amount']);	
		}
		
		if(isset(Yii::app()->session['order_coupon_code']))
		{
			unset(Yii::app()->session['order_coupon_code']);	
		}
		
		Yii::app()->user->setFlash('success',"Your cart is empty now.");
			
		$this->redirect(array("user/cart"));
	}
	
	function actionchangePassword()
	{
		$this->isLogin();
		
		if (isset($_POST['Save'])) {
			
			$userObj = new Users();
			$userData = $userObj->getUserDataById(Yii::app()->session['farmsoucing_userId']);
			
			$algoObj = new Algoencryption();
			$password = $algoObj->decrypt($userData['password']);
			
			if($_POST['opassword'] != $password)
			{	
				Yii::app()->user->setFlash("error","Wrong old password.");
			}
			else
			{
				$generalObj = new General();
				$password_flag = $generalObj->check_password($_POST['password'], $_POST['cpassword']);
	
				switch ($password_flag) {
					case 0:
						$pass_flag = 0;
						break;
					case 1:
						
						Yii::app()->user->setFlash("error","Please enter new password.");
						$pass_flag = 1;
						break;
					case 2:
						
						Yii::app()->user->setFlash("error","Please enter minimum 6 character in new password.");
						$pass_flag = 1;
						break;
					case 3:
						Yii::app()->user->setFlash("error","New password and confirm password does not match.");
						$pass_flag = 1;
						break;
				}
			
				if ($pass_flag == 0) {
					if (isset($_POST['opassword'])) {
						if (strlen($_POST['opassword']) < 1) {
							
							 Yii::app()->user->setFlash("error","Wrong old password.");
						} else if (strlen($_POST['password']) < 5) {
							
							 Yii::app()->user->setFlash("error","Please enter minimum 6 character in new password.");
						} else if ($_POST['password'] != $_POST['cpassword']) {
							
							 Yii::app()->user->setFlash("error","New password and confirm password does not match.");
						} else {
							
							$algoObj	=	new Algoencryption();
							$newpassword	=	$algoObj->encrypt($_POST['password']);
							
							$usernewData['password'] = $newpassword;
							$usernewData['modifiedAt'] = date("Y-m-d H:i:s");
							
							$userObj = new Users();
							$userObj->setData($usernewData);
							$userObj->insertData(Yii::app()->session['farmsoucing_userId']);
							 
							Yii::app()->user->setFlash('success',"Password successfully changed.");
						}
					}
				}
			}
		}
		
		$this->render("change_password");
	}
	
	public function actiongetProductMinimumQuantity()
	{
		if($_REQUEST['product_id'] == "")
		{
			echo -1;
			exit;	
		}
		else
		{
			$this->isLogin();
			
			$productObj = new Product();
			$productData = $productObj->getAllDetailOfProductById($_REQUEST['product_id']);
			
			if(!empty($productData))
			{
				echo $productData['min_quantity'] ;
				exit;
			}
			else
			{
				echo -1 ;
				exit;
			}
		}
	}
	
	function actionuserPromoCode()
	{
		if(isset($_REQUEST['coupon_code']) && $_REQUEST['coupon_code'] != "")
		{
			$coupon_code = $_REQUEST['coupon_code'] ;
			$customer_id  = Yii::app()->session['customer_id'] ;
			
			$promocodesObj =  new Promocodes();
			$promocodeData = $promocodesObj->checkPromocodeUniqueId($coupon_code);	
			
			if(!empty($promocodeData))
			{
				if($promocodeData['isUsed'] == 0)
				{
					if($promocodeData['status'] == 1)
					{
						Yii::app()->session['order_coupon_code'] = $coupon_code;
						
						if($promocodeData['promocode_type'] == 0)
						{
							unset(Yii::app()->session['order_coupon_amount']);
							Yii::app()->session['order_coupon_amount'] = round($promocodeData['promocode_amount']);
						}else{
							unset(Yii::app()->session['order_coupon_amount']);
							Yii::app()->session['order_coupon_amount'] = round($promocodeData['promocode_amount'] * $_REQUEST['total'] /100); 
						}
						
						echo Yii::app()->session['order_coupon_amount'];
						return ;
					}else{
						Yii::app()->session['order_coupon_amount'] = 0 ;
						echo "Promo code is deactivated by admin.";
						return ;
					}
				}else{
					Yii::app()->session['order_coupon_amount'] = 0 ;
					echo "Promo code is already used.";
					return ;
				}
			}
			else
			{
				Yii::app()->session['order_coupon_amount'] = 0 ;
				echo "Promo code is not valid.";
				return ;
			}
			exit;
		}
		else{
			Yii::app()->session['order_coupon_amount'] = 0 ;
			echo "Promo code is not valid.";
			return ;
		}
	}
}