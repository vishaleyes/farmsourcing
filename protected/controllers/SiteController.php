<?php
error_reporting(0);
date_default_timezone_set("Asia/Kolkata");
class SiteController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public $msg;
	public $errorCode;
	private $arr = array("rcv_rest" => 200370,"rcv_rest_expire" => 200371,"send_sms" => 200372,"rcv_sms" => 200373,"send_email" => 200374,"todo_updated" => 200375, "reminder" => 200376, "notify_users" => 200377,"rcv_rest_expire"=>200378,"rcv_android_note"=>200379,"rcv_iphone_note"=>200380);
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
		
	}
	

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	 
	public function actionIndex()
	{
		
		if(isset(Yii::app()->session['farmsoucing_userId']))
		{
			$this->redirect(Yii::app()->params->base_path."user/index");
				exit;
		}
		else
		{			
			$options	=	array();
			$genralObj	=	new General();
			$options	=	$genralObj->getTimeZones();
			
			$site=_SITENAME_NO_CAPS_;
			Yii::app()->session['loginflag']	=	0;
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
	}
	
	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
	    if($error=Yii::app()->errorHandler->error)
	    {
	    	if(Yii::app()->request->isAjaxRequest)
	    		echo $error['message'];
	    	else
	        	$this->render('error', $error);
	    }
	}
	
	public function actionMerror()
	{
	    if($error=Yii::app()->errorHandler->error)
	    {
	    	if(Yii::app()->request->isAjaxRequest)
	    		echo $error['message'];
	    	else
	        	$this->render('merror', $error);
	    }
	}

	function loginRedirect()
	{
		if(isset(Yii::app()->session['farmsoucing_userId']))
		{
			$this->redirect(Yii::app()->params->base_path."user");
			exit;
		}
	}

	function actionPrefferedLanguage($lang='eng')
	{
		if(isset(Yii::app()->session['farmsoucing_userId']) && Yii::app()->session['farmsoucing_userId']>0)
		{
			//$userObj=new User();
			//$userObj->setPrefferedLanguage(Yii::app()->session['farmsoucing_userId'],$lang);
		}
		
		Yii::app()->session['prefferd_language']=$lang;
		//Yii::app()->language = Yii::app()->user->getState('_lang');
		$this->redirect(Yii::app()->params->base_path."site/index");
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
	
	function actiontest()
	{

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
			$soDetails = new SoDetails();
			$productData = $productObj->getAllPaginatedProductListingByCatId($limit,$_REQUEST['sortType'],$_REQUEST['sortBy'],$_REQUEST['keyword'],customer_id);
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
		
		$this->render("orderHistory", array('data'=>$data,'ext'=>$ext));
			
	}
	
	function actionlogin()
	{
		if (isset($_POST['submit_login']) && isset($_POST['mobile_no'])) {
			
			$email = $_POST['mobile_no'];
			$pwd = $_POST['password'];
			
			$digit = substr($_POST['mobile_no'],'0','3');
				
			if($digit != "+91")
			{
				$mobile_no = "+91".$_POST['mobile_no'];		
			}else{
				$mobile_no = $_POST['mobile_no'];	
			}
				
			$userObj	=	new Users();
			$userdata	=	$userObj->checkMobileNo($mobile_no);
			
			if(!empty($userdata))
			{
				$algoObj = new Algoencryption();
				$password = $algoObj->decrypt($userdata['password']);
				
				if ( $password === $_POST['password'] ) {
					Yii::app()->session['farmsoucing_userId'] = $userdata['id'];
					Yii::app()->session['customer_id'] = $userdata['customer_id'];
					Yii::app()->session['email'] = $userdata['email'];
					Yii::app()->session['mobile_no'] = $userdata['mobile_no'];
					Yii::app()->session['name'] = $userdata['name'];
					
					header('location:'.Yii::app()->params->base_path.'user/Index');
					exit;
					
				} else {
					Yii::app()->user->setFlash("error","Mobile No or Password is not valid");
					$this->redirect(array('site/index'));
					exit;
				}
			} else {
				Yii::app()->user->setFlash("error","Mobile No or Password is not valid");
				$this->redirect(array('site/index'));
				exit;
			}
		}
	}
	
	function actioncart()
	{
		$toal_amount=0;
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
	
	function actionAboutus()
	{
		$this->render("about");
	}
	
	function actionterms()
	{
		$this->render("termAndConditions");	
	}
	
	function actionContactus($ajax=0)
	{	
		$result['message']='';	
		$captcha = Yii::app()->getController()->createAction('captcha');
		if(isset($_POST['FormSubmit']))
		{			
			if($captcha->validate($_POST['verifyCode'],1)) {
					$validationOBJ = new Validation();
					$result = $validationOBJ->contactUs($_POST);
					if($result['status']==0)
					{
						$userObj=new Users();
						$result=$userObj->contactus($_POST,0,Yii::app()->session['prefferd_language']);
						if($result['status']==0)
						{
							Yii::app()->user->setFlash('success', $result['message']);
						}else{
							Yii::app()->user->setFlash('error', $result['message']);
							$this->render("contact");
							exit;
						}
					}
					else
					{
						Yii::app()->user->setFlash('error', $result['message']);
						$data = array('name'=>$_POST['name'],'email'=>$_POST['email'],'comment'=>$_POST['comment'],'message'=>$result['message']);
						$this->render("contact",$data);
						exit;
					}
				
			}
			else
			{
				Yii::app()->user->setFlash('error', Yii::app()->params->msg['_INVALID_CAPTCHA_']);
				$data = array('name'=>$_POST['name'],'email'=>$_POST['email'],'comment'=>$_POST['comment'],'message'=>Yii::app()->params->msg['_INVALID_CAPTCHA_']);
				$this->render("contact",$data);
				exit;
			}
		}		
		$data = array('name'=>'','email'=>'','comment'=>'','message'=>$result['message']);
		if(!$this->isAjaxRequest())
		{
			$this->render('contact',$data);
		}
		else
		{
			$this->renderPartial('contact',$data);
		}
	}
	
	function actionforgotPassword() 
	{
		error_reporting(0);
		if (isset(Yii::app()->session['farmsoucing_userId'])) {
			 Yii::app()->request->redirect( Yii::app()->params->base_path.'user');
        }
		
        if (isset($_POST['loginId'])) {
			$userObj = new Users();
			$result = $userObj->forgot_password($_POST['loginId']);
			if ($result[0] == 'success') {
				Yii::app()->user->setFlash("success",$result[1]);
				$data['message_static']=$result[1];
				$this->render("password_confirm",array("data"=>$data));
				exit;
			} else {
				Yii::app()->user->setFlash("error",$result[1]);
				$this->render("forgot_password");
				exit;
			}
		}else{
			$this->render("forgot_password");
		}
    }
	
	function actionproductListingGrid()
	{
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

		if(isset($_REQUEST['cat_id']) && $_REQUEST['cat_id'] != "")
		{
			$productObj = new Product();
			$productData = $productObj->getAllPaginatedProductListingByCatId($limit,$_REQUEST['sortType'],$_REQUEST['sortBy'],$_REQUEST['keyword'],$_REQUEST['cat_id']);
		}else{
			$productObj = new Product();
			$productData = $productObj->getAllPaginatedProductListing($limit,$_REQUEST['sortType'],$_REQUEST['sortBy'],$_REQUEST['keyword']);
			
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

		if(isset($_REQUEST['cat_id']) && $_REQUEST['cat_id'] != "")
		{
			$productObj = new Product();
			$productData = $productObj->getAllPaginatedProductListingByCatId($limit,$_REQUEST['sortType'],$_REQUEST['sortBy'],$_REQUEST['keyword'],$_REQUEST['cat_id']);
		}else{
			$productObj = new Product();
			$productData = $productObj->getAllPaginatedProductListing($limit,$_REQUEST['sortType'],$_REQUEST['sortBy'],$_REQUEST['keyword']);
			
		}
		
		
		
		$ext['sortType']	=	$_REQUEST['sortType'];
		$ext['keyword']=$_REQUEST['keyword'];
		$ext['sortBy']=$_REQUEST['sortBy'];
		
		$data['pagination']	=	$productData['pagination'];
        $data['productlisting']	=	$productData['listing'];
		
		$this->render("productListingList", array('data'=>$data,'ext'=>$ext));
	}
	
	function actionresetPassword() 
	{
		$message = '';
        if (isset($_POST['submit_reset_password_btn'])) {
            $userObj = new Users();
            $result = $userObj->resetpassword($_POST);
            $message = $result[1];
			
            if ($result[0] == 'success') {
				Yii::app()->user->setFlash("success",$message);
                header("Location: " . Yii::app()->params->base_path . 'site/');
                exit;
            }
			else
			{
				Yii::app()->user->setFlash("error",$message);
                header("Location: " . Yii::app()->params->base_path . 'site/resetpassword');
                exit;
			}
        }
        if ($message != '') {
			Yii::app()->user->setFlash("success",$message);
        }
        if( isset($_REQUEST['token']) ) {
			$data['token']	=	trim($_REQUEST['token']);
			$this->render('password_confirm',$data);
			exit;
		}
		$this->render('password_confirm');
    }
	
	function actioncategoryListing()
	{
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
			header('location:'.Yii::app()->params->base_path.'site/Index');
		}
	}
	
	function actionaddToCartOld()
	{
		//unset( $_SESSION['cartData']);exit;
		if(isset($_REQUEST['id']) && $_REQUEST['id'] != "")
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
		if(isset($_REQUEST['id']) && $_REQUEST['id'] != "")
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
	
	function actionaddToCartAjax()
	{
		//unset( $_SESSION['cartData']);exit;
		if(isset($_REQUEST['id']) && $_REQUEST['id'] != "")
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
			
		$this->redirect(array("site/cart"));
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
	
	function actioncheckOutCart()
	{
		Yii::app()->user->setFlash('error',"For checkout order, You must have to login.");
			
		$this->redirect(array("site/cart"));
	}
	
	function actionemptyCart()
	{
		if(isset($_SESSION['cartData']))
		{
			unset($_SESSION['cartData']);	
		}
		Yii::app()->user->setFlash('success',"Your cart is empty now.");
			
		$this->redirect(array("site/cart"));
	}
	
	function actionfaq()
	{
		$this->render("faq");
	}
	
	function actionCustomerEntry()
	{
		$sql = "select customer_id,customer_name,cust_email,mobile_no,createdAt from customers where mobile_no != ''";	
		$result	=Yii::app()->db->createCommand($sql)->queryAll();
		
		foreach($result as $row)
		{
			$data = array();
			$data['customer_id'] = $row['customer_id'];
			$data['mobile_no'] = $row['mobile_no'];
			$data['email'] = $row['cust_email'];
			$data['password'] = 'MTExMTExODg2NjM4NTUyNw';
			$data['name'] = $row['customer_name'];
			$data['isVerified'] = 1;
			$data['status'] = 1;
			$data['createdAt'] = $row['createdAt'];
			$data['modifiedAt'] = $row['createdAt'];
			
			$userObj = new Users();
			$userObj->setData($data);
			$userObj->insertData();
			
			
		}
		
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
	
	
}