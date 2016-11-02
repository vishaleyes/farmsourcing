<?php
error_reporting(0);
set_time_limit(0);
date_default_timezone_set("Asia/Kolkata");
require_once(FILE_PATH."/protected/extensions/mpdf/mpdf.php");
require_once(FILE_PATH."/protected/extensions/phpmailer/class.phpmailer.php");
class AdminController extends Controller {

    public $algo;
    public $adminmsg;
	public $errorCode;
    private $msg;
    private $arr = array("rcv_rest" => 200370,"rcv_rest_expire" => 200371,"send_sms" => 200372,"rcv_sms" => 200373,"send_email" => 200374,"todo_updated" => 200375, "reminder" => 200376, "notify_users" => 200377,"rcv_rest_expire"=>200378,"rcv_android_note"=>200379,"rcv_iphone_note"=>200380);
	
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
	
	public function beforeAction($action=NULL)
	{
		$this->msg = Yii::app()->params->adminmsg;
		$this->errorCode = Yii::app()->params->errorCode;
		return true;
	
	}

	
	/* =============== Content Of Check Login Session =============== */

    function isLogin() {
        if (isset(Yii::app()->session['farmsourcing_adminUser'])) {
            return true;
        } else {
            Yii::app()->user->setFlash("error", "Username or password required");
            header("Location: " . Yii::app()->params->base_path . "admin");
            exit;
        }
    }

    function actionindex() 
	{
		if(isset(Yii::app()->session['farmsourcing_adminUser'])){
			if(Yii::app()->session['type'] == 0)
			{
				$this->redirect(array("admin/userListing"));
			}else if(Yii::app()->session['type'] == 1){
				$this->redirect(array("admin/purchaseOrderListing"));
			}else if(Yii::app()->session['type'] == 2){
				$this->redirect(array("admin/salesOrderListing"));
			}else if(Yii::app()->session['type'] == 3){
				$this->redirect(array("admin/salesOrderListing"));
			}else{
				$this->redirect(array("admin/userListing"));
			}
		} else {
			$this->render("index");
		}
    }
	
	function actionAdminLogin()
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
				$admin_data	=	$adminObj->getAdminDetailsByEmail($email_admin);
				
			}
			if($admin_data['status'] == 0)
			{
				Yii::app()->user->setFlash("error","Your account is deactivated.");
				$this->redirect(array('admin/index'));
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
				Yii::app()->session['farmsourcing_adminUser'] = $admin_data['id'];
				Yii::app()->session['email'] = $admin_data['email'];
				Yii::app()->session['firstName'] = $admin_data['firstName'];
				Yii::app()->session['fullName'] = $admin_data['firstName'] . ' ' . $admin_data['lastName'];
				Yii::app()->session['currency'] = $companyDetails['currency'];
				Yii::app()->session['type'] = $admin_data['type'];
				Yii::app()->session['current']	=	'dashboard';
				
				if(Yii::app()->session['type'] == 0)
				{
					$this->redirect(array("admin/purchaseOrderListing"));
				}else if(Yii::app()->session['type'] == 1){
					$this->redirect(array("admin/productListing"));
				}else if(Yii::app()->session['type'] == 2){
					$this->redirect(array("admin/salesOrderListing"));
				}else if(Yii::app()->session['type'] == 3){
					$this->redirect(array("admin/salesOrderListing"));
				}else {
					$this->redirect(array("admin/userListing"));
				}
				
				//$this->render("dashboard", array("adminData"=>$admin_data));	
				exit;
			} else {
				Yii::app()->user->setFlash("error","Username or Password is not valid");
				$this->redirect(array('admin/index'));
				exit;
			}	
		}
	}

	function actionLogout()
	{
		Yii::app()->session->destroy();
		$this->redirect(array("admin/index"));
	}
	
	function array_sort($array, $on, $order=SORT_ASC)
	{
		
			$new_array = array();
			$sortable_array = array();
		
			if (count($array) > 0) {
				foreach ($array as $k => $v) {
					if (is_array($v)) {
						foreach ($v as $k2 => $v2) {
							if ($k2 == $on) {
								$sortable_array[$k] = $v2;
							}
						}
					} else {
						$sortable_array[$k] = $v;
					}
				}
		
				switch ($order) {
					case SORT_ASC:
						asort($sortable_array);
					break;
					case SORT_DESC:
						arsort($sortable_array);
					break;
				}
		
				foreach ($sortable_array as $k => $v) {
					$new_array[$k] = $array[$k];
				}
			}
			
			return $new_array;
	}
	
	function actionPrefferedLanguage($lang='eng')
	{
		if(isset(Yii::app()->session['farmsourcing_adminUser']) && Yii::app()->session['farmsourcing_adminUser']>0)
		{
			//$userObj=new User();
			//$userObj->setPrefferedLanguage(Yii::app()->session['userId'],$lang);
		}
		
		Yii::app()->session['prefferd_language']=$lang;
		//Yii::app()->language = Yii::app()->user->getState('_lang');
		$this->redirect(Yii::app()->params->base_path."admin/index");
	}

	function actionmyprofile()
	{
		
		
		Yii::app()->session['current']   =   'settings';
		$adminObj	=	new Admin();
		
		if(isset(Yii::app()->session['email'])){
    		$adminId	=	$adminObj->getAdminIdByLoginId(Yii::app()->session['email']);
    		$adminDetails	=	$adminObj->getAdminDetailsById($adminId);
            $data['adminDetails']   =   $adminDetails;
				
			$this->render('myProfile', array('data'=>$data['adminDetails']));
		}else{
            $this->redirect(Yii::app()->params->base_path.'admin/index');
		}
	}
	
	function actioneditProfile()
	{
		
		Yii::app()->session['current']   =   'settings';
		$adminObj	=	new Admin();
		
		if(isset(Yii::app()->session['email'])){
    		$adminId	=	$adminObj->getAdminIdByLoginId(Yii::app()->session['email']);
    		$adminDetails	=	$adminObj->getAdminDetailsById($adminId);
            $data['adminDetails']   =   $adminDetails;
				
			$this->render('editProfile', array('data'=>$data['adminDetails']));
		}else{
            $this->redirect(Yii::app()->params->base_path.'admin/index');
		}
	}
	
	function actionsaveProfile()
	{	
	   error_reporting(0);
	   $adminObj	=	new Admin();
	   $Admin_value['firstName'] = $_POST['firstName'];
	   $Admin_value['lastName'] = $_POST['lastName'];
	   
	   $validationObj = new Validation();
	   $res = $validationObj->updateAdminProfile($Admin_value);	
	   
	   if($res['status'] == 0)
	   {
		 
		 if(isset($_FILES['userFile']['name']) && $_FILES['userFile']['name'] != "")
		 {
			$Admin_value['avatar']="admin_".$_POST['AdminID'].".png";
					
			 move_uploaded_file($_FILES['userFile']["tmp_name"],FILE_UPLOAD."/avatar/".$Admin_value['avatar']);	 
		 }
		 $adminObj->updateProfile($Admin_value,$_POST['AdminID']);
		 
		
		 
		 Yii::app()->session['fullName'] = $Admin_value['firstName'] .' '.$Admin_value['lastName'];
		 Yii::app()->session['firstName'] = $Admin_value['firstName'];
		 Yii::app()->session['lastName'] = $Admin_value['lastName'];
		 Yii::app()->user->setFlash('success', $this->msg['_UPDATE_SUCC_MSG_']);
	   }
	   else
	   {
			Yii::app()->user->setFlash('error',$res['message']);
	   }
	   $this->actionmyprofile();   
	}
	
	
	function actioncompanyProfile()
	{
		error_reporting(0);
		
		Yii::app()->session['current']   =   'settings';
		if(isset(Yii::app()->session['email'])){
    		$companyDetailsObj	=	new CompanyDetails();
			$adminDetails = $companyDetailsObj->getCompanyDetailsByAdminId(Yii::app()->session['farmsourcing_adminUser']);
		    $data['adminDetails']   =   $adminDetails;
			        		
			$this->render('companyProfile', array('data'=>$data['adminDetails']));
		}else{
            $this->redirect(Yii::app()->params->base_path.'admin/index');
		}
	}
	
	function actioneditCompanyProfile()
	{
		error_reporting(0);
		Yii::app()->session['current']   =   'settings';
		
		
		if(isset(Yii::app()->session['email'])){
    		$companyDetailsObj	=	new CompanyDetails();
			$adminDetails = $companyDetailsObj->getCompanyDetailsByAdminId(Yii::app()->session['farmsourcing_adminUser']);
		    $data['adminDetails']   =   $adminDetails;

			$currencyObj = new Currency();
			$currencyList = $currencyObj->getAllCurrencyList();
				
			$this->render('editCompanyProfile', array('data'=>$data['adminDetails'],'currencyList'=>$currencyList));
		}else{
            $this->redirect(Yii::app()->params->base_path.'admin/index');
		}
	}
	
	function actionsaveCompanyProfile()
	{	
	   error_reporting(0);
	   $companyDetailsObj	=	new CompanyDetails();
	   $Admin_value['company_name'] = $_POST['company_name'];
	   $Admin_value['company_address'] = $_POST['company_address'];
	   $Admin_value['currency'] = $_POST['currency'];
	   $Admin_value['modifiedAt'] = date("Y-m-d H:i:s");
	   
		// $validationObj = new Validation();
		//$res = $validationObj->updateAdminProfile($Admin_value);	
		
		//if($res['status'] == 0)
		// {
		 
		 if(isset($_FILES['userFile']['name']) && $_FILES['userFile']['name'] != "")
		 {
			$Admin_value['company_logo']="company_".$_POST['AdminID'].".png";
					
			 move_uploaded_file($_FILES['userFile']["tmp_name"],FILE_UPLOAD."/clientLogo/".$Admin_value['company_logo']);	 
		 }
		 $companyDetailsObj->updateProfile($Admin_value,$_POST['AdminID']);
		 
		 $companyDetailsObj	=	new CompanyDetails();
		 $companyDetailsObj->setData($Admin_value);
		 $companyDetailsObj->insertData($_POST['AdminID']);
		 
		 //Yii::app()->session['fullName'] = $Admin_value['firstName'] .' '.$Admin_value['lastName'];
		 //Yii::app()->session['firstName'] = $Admin_value['firstName'];
		 //Yii::app()->session['lastName'] = $Admin_value['lastName'];
		 Yii::app()->user->setFlash('success', $this->msg['_UPDATE_SUCC_MSG_']);
	  /* }
	   else
	   {
			Yii::app()->user->setFlash('error',$res['message']);
	   }*/
	   $this->redirect(array("admin/companyProfile"));
	}
	
	function actionchangePassword()
	{
		$this->isLogin();
		Yii::app()->session['current']   =   'settings';
		if(!isset($_REQUEST['ajax']))
		{
			$_REQUEST['ajax']='false';
		}
		$resultArray['ajax']=$_REQUEST['ajax'];
		if(isset($_GET['id']) && $_GET['id'] != '')
		{
			$resultArray['id']=$_GET['id'];
		}
		else
		{
			$resultArray['id']=Yii::app()->session['adminUser'];
		}
		if($_REQUEST['ajax']=='true')
		{
			$this->render('change_password',$resultArray);	
		}
		else
		{
			$this->render('change_password',$resultArray);	
		}	
	}
	
	function actionchangeAdminPassword()
	{
		$this->isLogin();
		if(isset($_REQUEST['id']) && $_REQUEST['id'] != '')
		{
			$adminObj = new Admin();
			$adminId = $adminObj->getAdminIdByLoginId(Yii::app()->session['email']);
			$adminDetails = $adminObj->getAdminDetailsById($adminId);
			Yii::app()->session['current'] =   'settings';
			$data['adminDetails']=$adminDetails;
			$data['id']=$adminId;
			$data["settings"]= "Selected";
			$data['TITLE_ADMIN']=$this->msg['_TITLE_FJN_ADMIN_CHANGE_PASSWORD_'];
			$pass_flag = 0;
			if (isset($_POST['Save'])) {
				$adminObj=Admin::model()->findbyPk($adminId);
				$res = $adminObj->attributes;
				
				$generalObj = new General();
				$res = $generalObj->validate_password($_POST['opassword'],$res['password']);

				if($res!=true)
				{	
					Yii::app()->user->setFlash("error","Old Password is wrong.");
				}
				else
				{
					$generalObj = new General();
					$password_flag = $generalObj->check_password($_POST['password'],$_POST['cpassword']);
		
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
						if (isset($_POST['opassword'])) {
							if (strlen($_POST['opassword']) < 1) {
								
								 Yii::app()->user->setFlash("error",$this->msg['WRONG_PASS_MSG']);
							} else if (strlen($_POST['password']) < 5) {
								
								 Yii::app()->user->setFlash("error",$this->msg['_VALIDATE_PASSWORD_GT_6_']);
							} else if ($_POST['password'] != $_POST['cpassword']) {
								
								 Yii::app()->user->setFlash("error",$this->msg['_CONFIRM_PASSWORD_NOT_MATCH_']);
							} else {
								$admin = new admin();
								$result = $admin->changePassword(Yii::app()->session['adminUser'], $_POST);
								Yii::app()->user->setFlash('success',"Successfully Changed Password.");
							}
						}
					}
				}
			}
		}
		
		$this->render("change_password",$data);
	}
	
	function actionforgotPassword() 
	{
		if (isset(Yii::app()->session['farmsourcing_adminUser'])) {
			 Yii::app()->request->redirect( Yii::app()->params->base_path . 'admin');
        }
		
        if (isset($_POST['loginId'])) {
			$AdminObj = new Admin();
			$result = $AdminObj->forgot_password($_POST['loginId']);
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

    function actionresetPassword() 
	{
		$message = '';
        if (isset($_POST['submit_reset_password_btn'])) {
            $adminObj = new Admin();
            $result = $adminObj->resetpassword($_POST);
            $message = $result[1];
			
            if ($result[0] == 'success') {
				Yii::app()->user->setFlash("success",$message);
                header("Location: " . Yii::app()->params->base_path . 'admin/');
                exit;
            }
			else
			{
				Yii::app()->user->setFlash("error",$message);
                header("Location: " . Yii::app()->params->base_path . 'admin/resetpassword');
                exit;
			}
        }
        if ($message != '') {
			Yii::app()->user->setFlash("success",$message);
        }
        if( isset($_REQUEST['token']) ) {
			$data['token']	=	trim($_REQUEST['token']);
		}
		$this->render('password_confirm',$data);
    }
	
	function actiondashboard()
	{
		$this->isLogin();
		
		$adminObj = new Admin();
		$adminData = $adminObj->getAdminDetailsById(Yii::app()->session['farmsourcing_adminUser']);
		
		Yii::app()->session['current']	=	'dashboard';
		$this->render("dashboard", array("adminData"=>$adminData));	
	}
	
	function actionuserListing()
	{
		
		$this->isLogin();
		$adminObj = new Admin();
		$usersList	=	$adminObj->getAllUsers();
		
		$data['users']	=	$usersList;
		Yii::app()->session['current']	=	'users';
		$this->render("userListing", array('data'=>$data));
	}
	
	function actionproductListing()
	{
		
		$this->isLogin();
		$productObj = new Product();
		$productList = $productObj->getAllProductsForMasterListing();
		
		$data['productList']	=	$productList;
		Yii::app()->session['current']	=	'product';
		$this->render("productListing", array('data'=>$data));
	}
	
	function actionproductPriceListing()
	{
		
		$this->isLogin();
		$productObj = new Product();
		$productList = $productObj->getAllProducts();
		
		$data['productList']	=	$productList;
		Yii::app()->session['current']	=	'product_price';
		$this->render("productPriceListing", array('data'=>$data));
	}
	
	function actionshrinkListing()
	{
		
		$this->isLogin();
		$shrinkObj = new ShrinkQuantity();
		$shrinkList = $shrinkObj->getAllDataWithDetail();
		
		$data['shrinkList']	=	$shrinkList;
		Yii::app()->session['current']	=	'shrink';
		$this->render("shrinkListing", array('data'=>$data));
	}
	
	public function actioncustomerListing()
	{
		$this->isLogin();
		$customerObj = new Customers();
		$customerList	=	$customerObj->getAllCustomers();
		
		$data['customerList']	=	$customerList;
		Yii::app()->session['current']	=	'customer';
		$this->render("customerListing", array('data'=>$data));
	}
	
	
	function actioncustomerListingForZone()
	{
		$this->isLogin();
		$customerObj = new Customers();
		$customerList	=	$customerObj->getAllCustomersByZoneId($_REQUEST['zone_id']);
		
		$data['customerList']	=	$customerList;
		Yii::app()->session['current']	=	'customer';
		$this->render("customerListing", array('data'=>$data));
	}
	
	function actionshowProductDetail()
	{
		if($_REQUEST['id'] == "")
		{
			echo 0;
			exit;	
		}
		else
		{
			$this->isLogin();
			
			$productObj = new Product();
			$productData = $productObj->getAllDetailOfProductById($_REQUEST['id']);
			
			if(!empty($productData))
			{
				$this->renderPartial("productDetails",array("productData"=>$productData));
				exit;
			}
			else
			{
				echo 0;
				exit;
			}
		}
	}
	
	
	function actioncategoryListing()
	{
		$this->isLogin();
		$categoryObj = new Category();
		$categoryList	=	$categoryObj->getAllCategoryList();
		
		$data['categoryList']	=	$categoryList;
		Yii::app()->session['current']	=	'category';
		$this->render("categoryListing", array('data'=>$data));
	}
	
	
	function actionproductListingForCategory()
	{
		$this->isLogin();
		$productObj = new Product();
		$productList	=	$productObj->getAllProductsByCatId($_REQUEST['category_id']);
		
		$data['productList']	=	$productList;
		Yii::app()->session['current']	=	'product';
		$this->render("productListing", array('data'=>$data));
	}
	
	function actionproductListingForVendor()
	{
		$this->isLogin();
		$productObj = new Product();
		$productList	=	$productObj->getAllProductsByVendorId($_REQUEST['vendor_id']);
		
		$data['productList']	=	$productList;
		Yii::app()->session['current']	=	'product';
		$this->render("productListing", array('data'=>$data));
	}
	

	function actioneditCategory()
	{
		$data = array();
		$title = "Update Category";
		$categoryObj = new Category();
		$catData = $categoryObj->getCategoryDetail($_GET['id']);
		
		$this->render("addCategory",array('catData'=>$catData,'title'=>$title));
	}

	function actionvendorListing()
	{
		$this->isLogin();
		$vendorObj = new Vendor();
		$vendorList = $vendorObj->getAllVendors();
		
		$data['vendorList']	=	$vendorList;
		Yii::app()->session['current']	=	'vendors';
		$this->render("vendorListing", array('data'=>$data));
	}

	function actionaddCategory()
	{
		/*print "<pre>";
		print_r($_POST);
		exit;*/
		$this->isLogin();
		if(isset($_POST['id']) && $_POST['id'] != '')
		{
			
			
			$data = array();
			//$data['category_name'] = $_POST['category_name'];
			$data['admin_id'] = Yii::app()->session['farmsourcing_adminUser'];
			$data['cat_description'] = $_POST['cat_description'];
			$data['safetyMargin'] = $_POST['safetyMargin'];
			$data['unit_id'] = $_POST['unit_id'];
			$data['vendor_id'] = $_POST['vendor_id'];
			$data['profit_percentage'] = $_POST['profit_percentage'];
			//$data['profit_percentage_id'] = $_POST['profit_percentage_id'];
			
			$data['is_discount'] = $_POST['isDiscount'];
			$data['discount'] = $_POST['discount'];
			$data['discount_from'] = date("Y-m-d",strtotime($_POST['discount_from']));
			$data['discount_to'] = date("Y-m-d",strtotime($_POST['discount_to']));
			$data['discount_desc'] = $_POST['discount_desc'];
			$data['modifiedAt'] = date("Y-m-d H:i:s");
			
			$categoryObj = new Category();
			$categoryObj->setData($data);
			$categoryObj->insertData($_POST['id']);
			
			Yii::app()->user->setFlash("success","Successfully updated category.");
			$this->redirect(array("admin/categoryListing"));
			exit;
		}
		
	    if(isset($_POST) && $_POST['category_name'] != '' && $_POST['id'] == '')
		{
			$data = array();
			$data['admin_id'] = Yii::app()->session['farmsourcing_adminUser'];
			$data['category_name'] = $_POST['category_name'];
			$data['cat_description'] = $_POST['cat_description'];
			$data['safetyMargin'] = $_POST['safetyMargin'];
			$data['unit_id'] = $_POST['unit_id'];
			$data['vendor_id'] = $_POST['vendor_id'];
			$data['profit_percentage'] = $_POST['profit_percentage'];
			//$data['profit_percentage_id'] = $_POST['profit_percentage_id'];
			
			$data['is_discount'] = $_POST['isDiscount'];
			$data['discount'] = $_POST['discount'];
			$data['discount_from'] = date("Y-m-d",strtotime($_POST['discount_from']));
			$data['discount_to'] = date("Y-m-d",strtotime($_POST['discount_to']));
			$data['discount_desc'] = $_POST['discount_desc'];
			$data['createdAt'] = date("Y-m-d H:i:s");
			$data['modifiedAt'] = date("Y-m-d H:i:s");
			
			$categoryObj = new Category();
			$cateogryData = $categoryObj->checkCategoryName($_POST['category_name']);
			if(!empty($cateogryData))
			{
				Yii::app()->user->setFlash("error","Category name already exist.");
				$title = "Create Category";
				$this->render("addCategory",array('catData'=>$_POST,'title'=>$title));
				exit;
			}
			
			$categoryObj = new Category();
			$categoryObj->setData($data);
			$categoryObj->insertData();
			
			Yii::app()->user->setFlash("success","Successfully added category.");
			$this->redirect(array("admin/categoryListing"));
			exit;
		}
		
		$data = array();
		$title = "Create Category";
		$this->render("addCategory",array('title'=>$title));
		exit;
	}
	
	public function actiondeleteCategory()
	{
		$this->isLogin();
		
		$categoryObj = new Category();
		$categoryObj->deleteCategory($_REQUEST['id']);
		
		Yii::app()->user->setFlash("success","Category deleted successfully.");
		header('Location: ' . $_SERVER['HTTP_REFERER']);
	}
	
	public function actiondeleteShrink()
	{
		$this->isLogin();
		
		$shrinkObj = new ShrinkQuantity();
		$shrinkObj->deleteShrink($_REQUEST['id']);
		
		Yii::app()->user->setFlash("success","Shrink deleted successfully.");
		header('Location: ' . $_SERVER['HTTP_REFERER']);
	}
	
	public function actiondeleteProfitPercentage()
	{
		$this->isLogin();
		
		$profitPercentageObj = new ProfitPercentageMaster();
		$profitPercentageObj->deleteProfitPercentage($_REQUEST['id']);
		
		Yii::app()->user->setFlash("success","Profit Percentage deleted successfully.");
		header('Location: ' . $_SERVER['HTTP_REFERER']);
	}
	
	public function actiondeleteProduct()
	{
		$this->isLogin();
		
		$productObj = new Product();
		$productObj->deleteProduct($_REQUEST['id']);
		
		Yii::app()->user->setFlash("success","Product deleted successfully.");
		header('Location: ' . $_SERVER['HTTP_REFERER']);
	}
	
	public function actiondisableProduct()
	{
		$this->isLogin();
		$data['status'] = 0 ;
		$data['modified_date'] = date("Y-m-d H:i:s");
		
		$productObj = new Product();
		$productObj->setData($data);
		$productObj->insertData($_REQUEST['id']);
		
		Yii::app()->user->setFlash("success","Product deleted successfully.");
		header('Location: ' . $_SERVER['HTTP_REFERER']);
	}

	function actionshowVendorDetail()
	{
		if($_REQUEST['id'] == "")
		{
			echo 0;
			exit;	
		}
		else
		{
			$this->isLogin();
			
			$vendorObj = new Vendor();
			$vendorData = $vendorObj->getVendorById($_REQUEST['id']);
			
			if(!empty($vendorData))
			{
				$this->renderPartial("vendorDetail",array("vendorData"=>$vendorData));
				exit;
			}
			else
			{
				echo 0;
				exit;
			}
		}
	}

	public function actiondeleteVendor()
	{
		$this->isLogin();
		
		$vendorObj = new Vendor();
		$vendorObj->deleteVendor($_REQUEST['id']);
		
		Yii::app()->user->setFlash("success","Vendor deleted successfully.");
		header('Location: ' . $_SERVER['HTTP_REFERER']);
	}
	
	function actionaddVendor($id=NULL)
	{
		$this->isLogin();
		
		$vendorObj = new Vendor();
		
        $title = 'Add Vendor';
        $result = array();
        if (isset($id) && $id != NULL) {
            $title = 'Edit Vendor';
			
			$vendorObj=Vendor::model()->findbyPk($id);
			$result = $vendorObj->attributes;
			
            $_POST['id'] = $result['vendor_id'];
        }
		
		if (isset($_POST['FormSubmit'])) 
		{
			$id = NULL;
			$id =  $_POST['id'];
			
			$data['admin_id'] = Yii::app()->session['farmsourcing_adminUser'];
			$data['contact_name'] = $_POST['contact_name'];
			$data['contact_no'] = $_POST['contact_no'];
			$data['address'] = $_POST['address'];
			/*$data['credit'] = $_POST['credit'];
			$data['debit'] = $_POST['debit'];*/
			$data['status'] = 1;
			
			if (isset($id) && $id != NULL) {
				if(isset($_POST['email']) && $_POST['email'] != "")
				{
					$data['email'] = $_POST['email'];
					$emailData = $vendorObj->checkEmailId($_POST['email']);
					
					if(!empty($emailData) && $emailData['vendor_id'] != $_POST['id'] )
					{
						Yii::app()->user->setFlash('error',"Email address already register in vendor list.");
						$_REQUEST['vendor_id'] = $_POST['id'];	
						$data = array('result' => $_REQUEST, 'title' => $title);
						Yii::app()->session['current'] = 'vendors';
						$this->render('addVendor', $data);
						exit;
					}
				}
				if(isset($_POST['vendor_name']) && $_POST['vendor_name'] != "")
				{
					$data['vendor_name'] = $_POST['vendor_name'];
					$nameData = $vendorObj->checkVendorName($_POST['vendor_name']);
					
					if(!empty($nameData) && $nameData['vendor_id'] != $_POST['id'] )
					{
						Yii::app()->user->setFlash('error',"Vendor name already register in vendor list.");
						$_REQUEST['vendor_id'] = $_POST['id'];
						$data = array('result' => $_REQUEST, 'title' => $title);
						Yii::app()->session['current'] = 'vendors';
						$this->render('addVendor', $data);
						exit;
					}
					
				}
				$data['modifiedAt'] = date("Y-m-d H:i:s");
				                
				$vendorObj->setData($data);
                $vendorObj->insertData($id);
            } else {
				$emailData = $vendorObj->checkEmailId($_POST['email']);
				
				if(!empty($emailData))
				{
					 Yii::app()->user->setFlash('error',"Email address already register in vendor list.");	
					 $data = array('result' => $_REQUEST, 'title' => $title);
	                 Yii::app()->session['current'] = 'vendors';
					 $this->render('addVendor', $data);
					 exit;
				}
				
				$nameData = $vendorObj->checkVendorName($_POST['vendor_name']);
					
				if(!empty($nameData) && $nameData['vendor_id'] != $_POST['id'] )
				{
					Yii::app()->user->setFlash('error',"Vendor name already register in vendor list.");	
					$data = array('result' => $_REQUEST, 'title' => $title);
					Yii::app()->session['current'] = 'vendors';
					$this->render('addVendor', $data);
					exit;
				}
				
				$data['email'] = $_POST['email'];
				$data['createdAt'] = date("Y-m-d H:i:s");
				$data['modifiedAt'] = date("Y-m-d H:i:s");
				$data['vendor_name'] = $_POST['vendor_name'];
				
				$vendorObj->setData($data);
                $insertId = $vendorObj->insertData();
				$id = $insertId ;				
            }
			
			if (isset($insertId) && $insertId > 0) {
                Yii::app()->user->setFlash('success',"Vendor inserted successfully.");
                $this->redirect(array("admin/vendorListing"));
                exit;
            } else {
                Yii::app()->user->setFlash('success',"Vendor updated successfully.");
                $this->redirect(array("admin/vendorListing"));
                exit;
            }
        }

        $data = array('result' => $result, 'title' => $title);
        Yii::app()->session['current'] = 'vendors';
		$this->render('addVendor', $data);
        
	}
	
	function actionzoneListing()
	{
		$this->isLogin();
		$zoneObj = new Zone();
		$zoneList = $zoneObj->getAllZones();
		
		$data['zoneList']	=	$zoneList;
		Yii::app()->session['current']	=	'zone';
		$this->render("zoneListing", array('data'=>$data));
	}
	
	function actionshowZoneDetail()
	{
		if($_REQUEST['id'] == "")
		{
			echo 0;
			exit;	
		}
		else
		{
			$this->isLogin();
			
			$zoneObj = new Zone();
			$zoneData = $zoneObj->getZoneById($_REQUEST['id']);
			
			if(!empty($zoneData))
			{
				$this->renderPartial("zoneDetail",array("zoneData"=>$zoneData));
				exit;
			}
			else
			{
				echo 0;
				exit;
			}
		}
	}
	
	public function actiondeleteZone()
	{
		$this->isLogin();
		
		$customerObj = new Customers();
		$id = $customerObj->checkZoneInCusotmer($_REQUEST['id']);
		
		if(!empty($id))
		{
			Yii::app()->user->setFlash("error","There are some customers registered from this zone. So You can not delete this zone.");
			header('Location: ' . $_SERVER['HTTP_REFERER']);
			exit;	
		}
		
		$zoneObj = new Zone();
		$zoneObj->deleteZone($_REQUEST['id']);
		
		Yii::app()->user->setFlash("success","Zone deleted successfully.");
		header('Location: ' . $_SERVER['HTTP_REFERER']);
	}
	
	function actionaddZone($id=NULL)
	{
		
		$this->isLogin();
		
		$zoneObj = new Zone();
		
        $title = 'Add Zone';
        $result = array();
        if (isset($id) && $id != NULL) {
            $title = 'Edit Zone';
			
			$zoneObj=Zone::model()->findbyPk($id);
			$result = $zoneObj->attributes;
			
            $_POST['id'] = $result['zone_id'];
			
        }
		
		if (isset($_POST['FormSubmit'])) 
		{
			$id = NULL;
			$id =  $_POST['id'];
			
            
			$data['admin_id'] = Yii::app()->session['farmsourcing_adminUser'];
			$data['status'] = 1;
			
			
			if (isset($id) && $id != NULL) {
				$zoneObj = new Zone();
				$checkZoneData = $zoneObj->checkZoneName($_POST['zoneName']);
			
				if(!empty($checkZoneData) && $checkZoneData != $id)
				{
					Yii::app()->user->setFlash('error',"Zone name already available.");
					$this->redirect(array("admin/zoneListing"));
					exit;
				}else{
					$data['zoneName'] = $_POST['zoneName'];
				}
				
				
				$data['modifiedAt'] = date("Y-m-d H:i:s");
				                
				$zoneObj->setData($data);
                $zoneObj->insertData($id);
            } else {
				$data['zoneName'] = $_POST['zoneName'];
				$data['createdAt'] = date("Y-m-d H:i:s");
				$data['modifiedAt'] = date("Y-m-d H:i:s");
				
				$zoneObj = new Zone();
				$checkZoneData = $zoneObj->checkZoneName($_POST['zoneName']);
			
				if(!empty($checkZoneData))
				{
					Yii::app()->user->setFlash('error',"Zone name already available.");
					$this->redirect(array("admin/zoneListing"));
					exit;
				}
				
				$zoneObj->setData($data);
                $insertId = $zoneObj->insertData();
				$id = $insertId ;				
            }
			
			if (isset($insertId) && $insertId > 0) {
                Yii::app()->user->setFlash('success',"Zone inserted successfully.");
                $this->redirect(array("admin/zoneListing"));
                exit;
            } else {
                Yii::app()->user->setFlash('success',"Zone updated successfully.");
                $this->redirect(array("admin/zoneListing"));
                exit;
            }
        }

        $data = array('result' => $result, 'title' => $title);
        Yii::app()->session['current'] = 'zone';
		$this->render('addZone', $data);
        
	}
	
	function actionshowJournalEntry()
	{
		$this->isLogin();
		Yii::app()->session['current'] = 'journalEntry';
		$this->render('showGeneralEntry');	
	}
	
	public function actionjournalEntryforCustomer()
	{
		$this->isLogin();
		$this->renderPartial('journalentryForCustomer');
	}
	
	function actionshowReports()
	{
		$this->isLogin();
		Yii::app()->session['current'] = 'reports';
		$this->render('reports');	
	}
	
	function actionshowExportData()
	{
		$this->isLogin();
		Yii::app()->session['current'] = 'export';
		$this->render('showExport');	
	}
	
	public function actionaddGeneralEntryforCustomer()
	{
		$this->isLogin();
		if(!empty($_REQUEST['customer_id'])  &&  $_REQUEST['customer_id'] != "")
		{
			if(empty($_REQUEST['credit']) || $_REQUEST['credit'] == "")
			{
				$_REQUEST['credit'] = 0 ;	
			}
			
			if(empty($_REQUEST['debit']) || $_REQUEST['debit'] == "")
			{
				$_REQUEST['debit'] = 0 ;	
			}
			
			$customer['customer_id'] = $_REQUEST['customer_id'];
			$customer['credit'] = $_REQUEST['credit'];
			$customer['debit'] = $_REQUEST['debit'] ;
			$customer['modifiedAt']=date('Y-m-d:H-m-s');
			
			$customerObj = new Customers();
			$customerObj->updateCustomer($customer['customer_id'],$customer['credit'],$customer['debit'],$customer['modifiedAt']);
			
			$customerGeneral['customer_id'] = $_REQUEST['customer_id'];
			$customerGeneral['admin_id'] = Yii::app()->session['farmsourcing_adminUser'];
			$customerGeneral['credit'] = $_REQUEST['credit'];
			$customerGeneral['debit'] = $_REQUEST['debit'];
			$customerGeneral['paymentType'] = $_REQUEST['paymentType'];
			$customerGeneral['createdAt'] = date('Y-m-d:H-m-s');
			$customerGeneral['modifiedAt'] = date('Y-m-d:H-m-s');
			
			$customerGeneralObj = new CustomerGeneralEntry();
			$customerGeneralObj->setData($customerGeneral);
			$receiptId = $customerGeneralObj->insertData();
			
			/*$this->actiongeneralEntryforAdmin();
			exit;*/
			
			$this->actiongeneratePaymentRecipts($receiptId);
		}else{
			Yii::app()->session['current'] = 'journalEntry';
			$this->render('showGeneralEntry');		
		}
	}
	
	function actiongeneratePaymentRecipts($receiptId)
	{
		$obj = CustomerGeneralEntry::model()->findbyPk($receiptId);
		$adminObj = Admin::model()->findbyPk(Yii::app()->session['farmsourcing_adminUser']);
		
		$customerObj = Customers::model()->findbyPk($obj->customer_id);
		
		if($obj->paymentType == 1)
		{
			$paymentType = "Cash";	
		} else if ($obj->paymentType == 2)
		{
			$paymentType = "Card";
		}else if ($obj->paymentType == 3)
		{
			$paymentType = "Cheque";	
		}
		
		$admin_id = Yii::app()->session['farmsourcing_adminUser'];
		
		$adminObj=Admin::model()->findByPk($admin_id);
		
		$companyDetailsObj	=	new CompanyDetails();
		$adminDetails = $companyDetailsObj->getCompanyDetailsByAdminId($admin_id);
		
		$url = Yii::app()->params->base_url."timthumb/timthumb.php?src=".Yii::app()->params->base_url."assets/upload/clientLogo/".$adminDetails['company_logo']."&h=100&w=150&q=60&zc=0" ;
		
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
		<table width="100%" border="0" cellspacing="0" cellpadding="5">
		  <tr>
			<td align="left"><img src="'.$url.'" /></td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td width="48%" rowspan="2"><b>'.$adminObj->company_name.'</b></td>
			<td width="29%">&nbsp;</td>
			<td width="23%" align="right"><h1> <font color="#808080">Payment Receipt</h1></td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td> [Street Address]</td>
			<td>&nbsp;</td>
			<td align="right">Receipt NO: '. $obj->id.'<br /></td>
		  </tr>
		  <tr>
			<td>[City, ST ZIP Code]</td>
			<td>&nbsp;</td>
			<td align="right">DATE: '. date('F d, Y',strtotime($obj->createdAt)).'</td>
		  </tr>
		  
		  <tr>
			<td>Phone [509.555.0190] Fax [509.555.0191]</td>
			<td>&nbsp;</td>
			<td align="right">TIME: '. date('H:i:s',strtotime($obj->createdAt)).'</td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td>To,</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
		    <td align="left" >Customer : '.$customerObj->customer_name.'</td>
			<td>&nbsp;</td>
			<td align="right" >&nbsp;</td>
		  </tr>
		  
		</table>
		
		<p>&nbsp;</p>
		<table>
			<tr>
				<td>
				Amount Received('.Yii::app()->session['currency'].') '.$obj->debit.'<br><br>
				Amount Paid('.Yii::app()->session['currency'].') '.$obj->credit.'<br><br><br>
				[ by ]'.$paymentType.'<br><br><br>
		
				For: ________________________________________________<br><br>
				
				Money Received by: '.Yii::app()->session['fullname'].'<br>
				<br><br>
				</td>
			</tr>
		</table>
		
		';
		
		$html .= '
		</body>
		</html>';
		
		$mpdf = new mPDF();
		$mpdf->WriteHTML($html);
		$mpdf->Output(FILE_PATH."assets/upload/pdf/recipt".$obj->id.".pdf", 'F'); 
		
		?>
		<script>
		window.open("<?php echo Yii::app()->params->base_url;?>assets/upload/pdf/recipt<?php echo $obj->id ;?>.pdf",'_blank');
		</script>
        
		<?php
		ob_flush();
		ob_clean();
		
		$this->actionshowJournalEntry();
	}
	
	public function actionjournalEntryforVendor()
	{
		$this->isLogin();
		$this->renderPartial('journalentryForVendor');
	}
	
	public function actionaddGeneralEntryforVendor()
	{
		if(!empty($_REQUEST['vendor_id'])  &&  $_REQUEST['vendor_id'] != "")
		{
			if(empty($_REQUEST['credit']) || $_REQUEST['credit'] == "")
			{
				$_REQUEST['credit'] = 0 ;	
			}
			
			if(empty($_REQUEST['debit']) || $_REQUEST['debit'] == "")
			{
				$_REQUEST['debit'] = 0 ;	
			}
			
			
			$vendor['vendor_id'] = $_REQUEST['vendor_id'];
			$vendor['credit'] = $_REQUEST['credit'];
			$vendor['debit'] = $_REQUEST['debit'];
			$vendor['modifiedAt']=date('Y-m-d:H-m-s');
			
			$vendorObj = new Vendor();
			$vendorObj->updateVendor($vendor['vendor_id'],$vendor['credit'],$vendor['debit'],$vendor['modifiedAt']);
			
			$vendorGeneral['vendor_id'] = $_REQUEST['vendor_id'];
			$vendorGeneral['admin_id'] = Yii::app()->session['farmsourcing_adminUser'];
			$vendorGeneral['credit'] = $_REQUEST['credit'];
			$vendorGeneral['debit'] = $_REQUEST['debit'];
			$vendorGeneral['paymentType'] = $_REQUEST['paymentType'];
			$vendorGeneral['createdAt'] = date('Y-m-d:H-m-s');
			$vendorGeneral['modifiedAt'] = date('Y-m-d:H-m-s');
			
			$vendorGeneralObj = new VendorGeneralEntry();
			$vendorGeneralObj->setData($vendorGeneral);
			$receiptId = $vendorGeneralObj->insertData();
			
			$this->actiongenerateVendorPaymentRecipts($receiptId);
		}else{
			Yii::app()->session['current'] = 'journalEntry';
			$this->render('showGeneralEntry');		
		}
	}
	
	function actiongenerateVendorPaymentRecipts($receiptId)
	{
		$obj = VendorGeneralEntry::model()->findbyPk($receiptId);
		$adminObj = Admin::model()->findbyPk(Yii::app()->session['farmsourcing_adminUser']);
		
		$vendorObj = Vendor::model()->findbyPk($obj->vendor_id);
		
		if($obj->paymentType == 1)
		{
			$paymentType = "Cash";	
		} else if ($obj->paymentType == 2)
		{
			$paymentType = "Card";
		}else if ($obj->paymentType == 3)
		{
			$paymentType = "Cheque";	
		}
		
		$admin_id = Yii::app()->session['farmsourcing_adminUser'];
		
		$adminObj=Admin::model()->findByPk($admin_id);
		
		$companyDetailsObj	=	new CompanyDetails();
		$adminDetails = $companyDetailsObj->getCompanyDetailsByAdminId($admin_id);
		
		$url = Yii::app()->params->base_url."timthumb/timthumb.php?src=".Yii::app()->params->base_url."assets/upload/clientLogo/".$adminDetails['company_logo']."&h=100&w=150&q=60&zc=0" ;
		
		//$url = Yii::app()->params->base_url."timthumb/timthumb.php?src=".Yii::app()->params->base_url."assets/upload/clientLogo/".$adminObj->company_logo."&h=100&w=150&q=60&zc=0" ;
		
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
		<table width="100%" border="0" cellspacing="0" cellpadding="5">
		  <tr>
			<td align="left"><img src="'.$url.'" /></td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td width="48%" rowspan="2"><b>'.$adminObj->company_name.'</b></td>
			<td width="29%">&nbsp;</td>
			<td width="23%" align="right"><h1> <font color="#808080">Payment Receipt</h1></td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td> [Street Address]</td>
			<td>&nbsp;</td>
			<td align="right">Receipt NO: '. $obj->id.'<br /></td>
		  </tr>
		  <tr>
			<td>[City, ST ZIP Code]</td>
			<td>&nbsp;</td>
			<td align="right">DATE: '. date('F d, Y',strtotime($obj->createdAt)).'</td>
		  </tr>
		  
		  <tr>
			<td>Phone [509.555.0190] Fax [509.555.0191]</td>
			<td>&nbsp;</td>
			<td align="right">TIME: '. date('H:i:s',strtotime($obj->createdAt)).'</td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td>To,</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
		    <td align="left" >Vendor : '.$vendorObj->vendor_name.'</td>
			<td>&nbsp;</td>
			<td align="right" >&nbsp;</td>
		  </tr>
		  
		</table>
		
		<p>&nbsp;</p>
		<table>
			<tr>
				<td>
				Amount Received('.Yii::app()->session['currency'].') '.$obj->debit.'<br><br>
				Amount Paid('.Yii::app()->session['currency'].') '.$obj->credit.'<br><br><br>
				[ by ]'.$paymentType.'<br><br><br>
		
				For: ________________________________________________<br><br>
				
				Money Received by: '.Yii::app()->session['fullname'].'<br>
				<br><br>
				</td>
			</tr>
		</table>
		
		';
		
		$html .= '
		</body>
		</html>';

			

		$mpdf = new mPDF();
		$mpdf->WriteHTML($html);
		$mpdf->Output(FILE_PATH."assets/upload/pdf/recipt".$obj->id.".pdf", 'F'); ?>
		
		<script>
		window.open("<?php echo Yii::app()->params->base_url;?>assets/upload/pdf/recipt<?php echo $obj->id ;?>.pdf",'_blank');
		</script>
        
		<?php
		ob_flush();
		ob_clean();
		
		$this->actionshowJournalEntry();
		
		
	
	}
	
	function actiongenerateOrder()
	{
		
		$this->isLogin();
			
		if(isset($_POST['customer_id']))
		{
			$data = array();
			$count = $_POST['count'];
			$data['createdAt'] = date("Y-m-d H:i:s");
			
			$so_detail['admin_id'] = Yii::app()->session['farmsourcing_adminUser'];
			$so_detail['customer_id'] = $_POST['customer_id'];
			$so_detail['total_item'] = $count;
			$so_detail['delivery_date'] = date("Y-m-d",strtotime($_POST['delivery_date']));
			$so_detail['status'] = 0 ;
			$so_detail['type'] = 0 ;
			$so_detail['isSynced'] = 0 ;
			$so_detail['createdAt'] = date("Y-m-d H:i:s");
			$so_detail['modifiedAt'] = date("Y-m-d H:i:s");
			
			$SoDetailsObj = new SoDetails();
			$SoDetailsObj->setData($so_detail);
			$soId = $SoDetailsObj->insertData();
			
			$data['so_id'] = $soId;
			$data['admin_id'] = Yii::app()->session['farmsourcing_adminUser'];
			
			$total_packets = 0 ;
			for($i=1;$i<=$count;$i++)
			{	
				$productObj = new Product();
				$priceData = $productObj->getProductById($_POST['product'.$i.'']);
				
				
				
				$data['packaging_scenario'] = $_POST['packaging_scenario'.$i.''];
				$data['no_of_packets'] = $_POST['no_of_packets'.$i.''];	
				$data['product_price'] = $_POST['rate'.$i.''];			
				$data['quantity'] = $data['packaging_scenario'] * $data['no_of_packets'];
				$data['product_id'] = $_POST['product'.$i.''];
				$data['actual_product_price'] = $priceData['product_price'];
				
				$productDiscount = $data['actual_product_price'] - $data['product_price'];
				
				$finalDiscountAmount = ($data['quantity'] * $data['actual_product_price'] * $productDiscount) / $data['actual_product_price'] ;
				
				$data['discount_amount'] = $finalDiscountAmount ;
				$data['discount_desc'] = $_POST['discount_desc'.$i.''];
				$data['delivery_date'] = $so_detail['delivery_date'];
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
			
			
		}
		
		if(isset($_GET['customer_id']) && $_GET['customer_id'] != '')
		{
			$customersObj = new Customers();
			$customerData = $customersObj->getCustomerById($_GET['customer_id']);
			
			Yii::app()->session['current'] = 'orders';
			if($customerData['customer_type'] == 1)
			{
				$this->render('generateOrderWholesale');
				die;	
			}
			$this->render('generateOrder');	
		}
		else
		{
			Yii::app()->session['current'] = 'orders';
			$this->render('generateOrder');	
		}
		exit;
	}
	
	function actioneditGenerateOrder()
	{
		$this->isLogin();
			
		if(isset($_POST['FormSubmit']))
		{
			$data = array();
			$count = $_POST['count'];
			//$data['createdAt'] = date("Y-m-d H:i:s");
			
			$so_detail['admin_id'] = Yii::app()->session['farmsourcing_adminUser'];
			$so_detail['customer_id'] = $_POST['customer_id'];
			$so_detail['total_item'] = $count;
			$so_detail['delivery_date'] = date("Y-m-d",strtotime($_POST['delivery_date']));
			$so_detail['status'] = 0 ;
			$so_detail['type'] = 0 ;
			$so_detail['isSynced'] = 0 ;
			
			if(isset($_POST['so_id']) && $_POST['so_id'] != "")
			{
				$so_detail['modifiedAt'] = date("Y-m-d H:i:s");
			
				$SoDetailsObj = new SoDetails();
				$SoDetailsObj->setData($so_detail);
				$SoDetailsObj->insertData($_POST['so_id']);
				$soId = $_POST['so_id'];
			}else{
				$so_detail['createdAt'] = date("Y-m-d H:i:s");
				$so_detail['modifiedAt'] = date("Y-m-d H:i:s");
				
				$SoDetailsObj = new SoDetails();
				$SoDetailsObj->setData($so_detail);
				$soId = $SoDetailsObj->insertData();
			}
			
			$data['so_id'] = $soId;
			$data['admin_id'] = Yii::app()->session['farmsourcing_adminUser'];
			
			$total_packets = 0 ;
			for($i=1;$i<=$count;$i++)
			{	
				$data['packaging_scenario'] = $_POST['packaging_scenario'.$i.''];
				$data['no_of_packets'] = $_POST['no_of_packets'.$i.''];	
				$data['product_price'] = $_POST['rate'.$i.''];			
				$data['quantity'] = $data['packaging_scenario'] * $data['no_of_packets'];
				$data['product_id'] = $_POST['product'.$i.''];
				$data['delivery_date'] = $so_detail['delivery_date'];
				
				
				$data['actual_product_price'] = $_POST['rate'.$i.''];
				
				$productDiscount = $data['actual_product_price'] - $_POST['rate'.$i.''];
				
				$finalDiscountAmount = ($data['quantity'] * $data['actual_product_price'] * $productDiscount) / $data['actual_product_price'] ;
				
				$data['discount_amount'] = $finalDiscountAmount ;
				
				
				
				if(isset($_POST['rowid'.$i.'']) && $_POST['rowid'.$i.''] != "")
				{
					$data['modifiedAt'] = date("Y-m-d H:i:s");
					$SoDescObj = new SoDesc();
					$SoDescObj->setData($data);
					$SoDescObj->insertData($_POST['rowid'.$i.'']);
				}else{
					$data['createdAt'] = date("Y-m-d H:i:s");
					$data['modifiedAt'] = date("Y-m-d H:i:s");
					$SoDescObj = new SoDesc();
					$SoDescObj->setData($data);
					$SoDescObj->insertData();
				}
				
				$total_packets = $total_packets + $data['no_of_packets'];
			}
			
			$newData['total_packets'] = $total_packets ;
			$newData['modifiedAt'] =  date("Y-m-d H:i:s");
			
			$SoDetailsObj = new SoDetails();
			$SoDetailsObj->setData($newData);
			$SoDetailsObj->insertData($soId);
			
			//$this->actionraiseSalesOrder($soId);
			Yii::app()->user->setFlash('success',"Sales Order created successfully.");
		}
		
		Yii::app()->session['current'] = 'orders';
		$this->redirect(array('admin/salesOrderListing'));	
		exit;
	}
	
	function actioneditSalesOrder()
	{
		$this->isLogin();
		
			
		if(isset($_REQUEST['so_id']) && $_REQUEST['so_id'] != "")
		{
			$SoDetailsObj = new SoDetails();
			$salesOrderData = $SoDetailsObj->getsalesOrderData($_REQUEST['so_id']);
			
			if(!empty($salesOrderData) && $salesOrderData['isPoGenerate'] == 0)
			{
				$SoDescObj = new SoDesc();
				$salesOrderDesc = $SoDescObj->getSoDescDetails($salesOrderData['so_id']);	
				
				Yii::app()->session['current'] = 'orders';
				$this->render('editSalesOrder',array("salesOrderData"=>$salesOrderData,"salesOrderDesc"=>$salesOrderDesc));	
				exit;
			}else{
				Yii::app()->session['current'] = 'orders';
				$this->render('generateOrder');	
				exit;
			}
		}
		
		Yii::app()->session['current'] = 'orders';
		$this->render('generateOrder');	
		exit;
	}
	
	public function actiondeleteSalesOrder()
	{
		$this->isLogin();
		
		$soDetailsObj = SoDetails::model()->findByPk($_REQUEST['id']);
		if($soDetailsObj->isPoGenerate == 0)
		{
			$soDetailsObj->delete();	
		}
		
		$soDescObj = new SoDesc();
		$soDescObj->deleteSoDescBySoId($_REQUEST['id']);
		
		Yii::app()->user->setFlash("success","Sales order deleted successfully.");
		header('Location: ' . $_SERVER['HTTP_REFERER']);
	}
	
	function actionraiseSalesOrderOld($id)
	{
		$SoDescObj = new SoDesc();
		$soData = $SoDescObj->getSoDescDetails($id);
		
		$admin_id = Yii::app()->session['farmsourcing_adminUser'];
		
		$adminObj=Admin::model()->findByPk($admin_id);
		
		$companyDetailsObj	=	new CompanyDetails();
		$adminDetails = $companyDetailsObj->getCompanyDetailsByAdminId($admin_id);
		
		$url = Yii::app()->params->base_url."timthumb/timthumb.php?src=".Yii::app()->params->base_url."assets/upload/clientLogo/".$adminDetails['company_logo']."&h=100&w=150&q=60&zc=0" ;
		
		//$url = Yii::app()->params->base_url."timthumb/timthumb.php?src=".Yii::app()->params->base_url."assets/upload/clientLogo/".$adminObj->company_logo."&h=100&w=150&q=60&zc=0" ;

		$soDetailsObj  = new SoDetails();
		$so_detail = $soDetailsObj->getsalesOrderData($id);
		
		
		if($so_detail['customer_name'] != "")
		{
			$customer = 'CUSTOMER: '.$so_detail['customer_name'] ;
			$to = 'TO,'	;
		}
		
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
		<table width="100%" border="1" cellspacing="0" cellpadding="5">
		  <tr>
		  <td align="left"><img src="'.$url.'" /></td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  </tr>
		  <tr>
			<td width="48%" rowspan="2"><b>'.$adminObj->company_name.'</b></td>
			<td width="23%" colspan="2" align="right" style="margin-right:20px;"><h1> <font color="#808080">SALES ORDER</h1></td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td> [Street Address]</td>
			<td>&nbsp;</td>
			<td align="right">SALES ORDER: '. $id.'<br /></td>
		  </tr>
		  <tr>
			<td>[City, ST ZIP Code]</td>
			<td align="right" colspan="2">ORDER DATE: '. date('F d, Y',strtotime($so_detail['order_date'])).'</td>
		  </tr>
		  <tr>
			<td>Phone [509.555.0190] Fax [509.555.0191]</td>
			<td>&nbsp;</td>
			<td align="right">&nbsp;</td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td>'.$to.'</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td align="left" >'.$customer.'</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		</table>
		<p>&nbsp;</p>
		
		<table width="100%" border="1" cellpadding="5"  cellspacing="0">
		  <tr align="center" valign="middle">
		 	<td align="center" width="5%"><strong>NO</strong></td>
			<td align="center" width="50%"><strong>NAME</strong></td>
			<td align="center" width="10%"><strong>QUANTITY</strong></td>
			<td align="center" width="10%"><strong>UNIT PRICE</strong></td>
			<td align="center" width="10%"><strong>TOTAL</strong></td>
		  </tr>';
		  $i=1;
		 // $finalAmount = 0 ;
	foreach($soData as $row) {
		//$finalAmount = $finalAmount + $row['amount'] ;
		$html .=  '<tr>
			<td align="center">&nbsp;'.$i.'</td>
			<td align="left" height="20">&nbsp;'.$row['product_name'].'</td>
			<td align="right">'.$row['quantity'].'&nbsp;</td>
			<td align="right">&nbsp;'.$row['price'].'</td>
			<td align="right">&nbsp;'.$row['total_price'].'</td>
		  </tr>';
   $i++; } 
		$html .= '</table>
		<table width="100%" border="1" cellpadding="5"  cellspacing="0" class="noborder1">
		  <!--<tr>
			<td colspan="4" align="right" class="noborder"></td>
			<td width="10%">&nbsp;</td>
		  </tr>-->
		  <tr >
			<td colspan="4" align="right" class="noborder1">TOTAL('.Yii::app()->session['currency'].')</td>
			<td width="14%" align="right">&nbsp;'.$so_detail['total_amount'].'</td>
		  </tr>
		</table>
		
		</body>
		</html>';	
		
		$mpdf = new mPDF();
		$mpdf->WriteHTML($html);
		$mpdf->Output(FILE_PATH."assets/upload/salesOrder/salesOrder_".$id."_".$admin_id.".pdf", 'F');
		?>
        <script>
		window.open("<?php echo Yii::app()->params->base_url;?>assets/upload/salesOrder/salesOrder_<?php echo $id;?>_<?php echo $admin_id;?>.pdf",'_blank');
		</script>
        
		<?php
		ob_flush();
		ob_clean();
		
		//$this->redirect(Yii::app()->params->base_url."user");
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
	
	
	public function actiongetProductDetail()
	{
		if($_REQUEST['product_id'] == "")
		{
			echo 0;
			exit;	
		}
		else
		{
			$this->isLogin();
			
			$productObj = new Product();
			$productData = $productObj->getAllDetailOfProductById($_REQUEST['product_id']);
			
			$customersObj = new Customers();
			$custData = $customersObj->getCustomerById($_REQUEST['customer_id']);
			
			
			
			$catPackObj = new CategoryPackagingMaster();
			$catPackData = $catPackObj->getAllPackageScenarioByCatId($_REQUEST['product_id']);
			
			if(!empty($catPackData))
			{
				$str = '<option value="">select package</option>';
				foreach($catPackData as $row)
				{
					$str .= '<option value="'.$row['packaging_scenario'].'">'.$row['display_name'].'</option>';	
				}
			}else{
				$str = '<option value="">select package</option>';
			}
			
			if(!empty($productData))
			{
				if($productData['cat_is_discount'] == 1)
				{
					if($productData['is_discount'] == 1)
					{
						if($productData['cat_discount'] > $productData['discount'])
						{
							$discount = $productData['cat_discount'];
							$fromDate = $productData['cat_discount_from'];
							$toDate = $productData['cat_discount_to'];	
							$discount_desc = $productData['cat_discount_desc'];
						}else{
							$discount = $productData['discount'];
							$fromDate = $productData['discount_from'];
							$toDate = $productData['discount_to'];
							$discount_desc = $productData['discount_desc'];
						}
					}else{
						$discount = $productData['cat_discount'];
						$fromDate = $productData['cat_discount_from'];
						$toDate = $productData['cat_discount_to'];
						$discount_desc = $productData['cat_discount_desc'];
					}
				}else{
					if($productData['is_discount'] == 1)
					{
						$discount = $productData['discount'];
						$fromDate = $productData['discount_from'];
						$toDate = $productData['discount_to'];
						$discount_desc = $productData['discount_desc'];
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
						if($custData['customer_type'] == 0)
						{
						$finalProductAmount = round($productData['product_price'] - ($productData['product_price'] * $discount / 100));
						}
						else
						{
						$finalProductAmount = round($productData['wholesale_price'] - ($productData['wholesale_price'] * $discount / 100));	
						}
					}else{
						if($custData['customer_type'] == 0)
						{
							$finalProductAmount = $productData['product_price'];
						}
						else
						{
							$finalProductAmount = $productData['wholesale_price'];
						}
					}
				}else{
						if($custData['customer_type'] == 0)
						{
							$finalProductAmount = $productData['product_price'];
						}
						else
						{
							$finalProductAmount = $productData['wholesale_price'];	
						}
				}
					
				echo $productData['unit_name'].",".$finalProductAmount.",".$str.",".$productData['product_id'].",".$discount_desc ;
				exit;
			}
			else
			{
				echo 0;
				exit;
			}
		}
	}
	
	public function actiongetProductDetailInJson()
	{
		if($_REQUEST['product_id'] == "")
		{
			echo 0;
			exit;	
		}
		else
		{
			$this->isLogin();
			
			$productObj = new Product();
			$productData = $productObj->getAllDetailOfProductById($_REQUEST['product_id']);
			
			if(!empty($productData))
			{
				echo json_encode($productData) ;
				exit;
			}
			else
			{
				echo 0;
				exit;
			}
		}
	}
	
	public function actiondeleteDescRowFromDatabase()
	{
		if($_REQUEST['sodescId'] == "")
		{
			echo 0;
			exit;	
		}
		else
		{
			//$this->isLogin();
			
			$soDescObj = new SoDesc();
			$res = $soDescObj->deleteSoDescRecord($_REQUEST['sodescId']);
			
			echo true;
			exit;
		}
	}
	
	function actionshowCategoryDetail()
	{
		if($_REQUEST['id'] == "")
		{
			echo 0;
			exit;	
		}
		else
		{
			$this->isLogin();
			
			$categoryObj = new Category();
			$categoryData = $categoryObj->getCategoryDetail($_REQUEST['id']);
			
			if(!empty($categoryData))
			{
				$this->renderPartial("categoryDetails",array("categoryData"=>$categoryData));
				exit;
			}
			else
			{
				echo 0;
				exit;
			}
		}
	}
	
	function actioneditProduct()
	{
		$data = array();
		$title = "Update Product";
		$productObj = new Product();
		$productData = $productObj->getProductById($_GET['id']);
		$this->render("addProduct",array('productData'=>$productData,'title'=>$title));
	}
	
	function actionaddProduct()
	{
		$this->isLogin();
	  	if(isset($_POST['id']) && $_POST['id'] != '')
		{
			$data = array();
			$_POST['product_id'] = $_POST['id'];
			if(!empty($_POST['product_name']) && $_POST['product_name'] != "")
			{
				$productObj = new Product();
				$productData = $productObj->checkProductName($_POST['product_name']);	
				
				if(!empty($productData) && $productData != $_POST['id'])
				{
					$title = "Update Product";
					Yii::app()->user->setFlash("error","Product name already exist.");
					$this->render("addProduct",array('productData'=>$_POST,'title'=>$title));	
					exit;
				}else{
					$data['product_name'] = $_POST['product_name'];
				}
			}
			
			$data['product_desc'] = $_POST['product_desc'];
			//$data['product_image'] = $_POST['product_image'];
			$data['product_price'] = $_POST['product_price'];
			
			$data['wholesale_price'] = $_POST['wholesale_price'];
			
			$data['min_quantity'] = $_POST['min_quantity'];
			$data['unitId'] = $_POST['unit_id'];
			//$data['quantity'] = $_POST['quantity'];
			$data['safetyMargin'] = $_POST['safetyMargin'];
			$data['vendor_id'] = $_POST['vendor_id'];
			$data['profit_percentage'] = $_POST['profit_percentage'];
			//$data['profit_percentage_id'] = $_POST['profit_percentage_id'];
			$data['cat_id'] = $_POST['cat_id'];
			
			$data['is_discount'] = $_POST['isDiscount'];
			$data['discount'] = $_POST['discount'];
			$data['discount_from'] = date("Y-m-d",strtotime($_POST['discount_from']));
			$data['discount_to'] = date("Y-m-d",strtotime($_POST['discount_to']));
			$data['discount_desc'] = $_POST['discount_desc'];
			
			if(isset($_POST['featured']) && $_POST['featured'] == "1")
			{
				$data['featured'] = 1 ; 	
			}else{
				$data['featured'] = 0 ; 
			}
			
			if(isset($_POST['special']) && $_POST['special'] == "1")
			{
				$data['special'] = 1 ; 	
			}else{
				$data['special'] = 0 ; 
			}
			
			$data['admin_id'] = Yii::app()->session['farmsourcing_adminUser'];
			$data['modified_date'] = date("Y-m-d H:i:s");
			
			if(isset($_FILES['userFile']['name']) && $_FILES['userFile']['name'] != "")
			 {
				$text = str_replace(" ", "_", $data['product_name']);
				$data['product_image'] = $text."_".strtotime(date("Y-m-d")).".png";
						
				 move_uploaded_file($_FILES['userFile']["tmp_name"],FILE_UPLOAD."product/".$data['product_image']);	 
			 }
				
			
			$productObj = new Product();
			$productObj->setData($data);
			$productObj->insertData($_POST['id']);
			Yii::app()->user->setFlash("success","Successfully updated product.");
			$this->redirect(array("admin/productListing"));
			exit;
		}
		
	    if(isset($_POST) && isset($_POST['product_name']) &&  $_POST['product_name'] != '' && $_POST['id'] == '')
		{
			if(!empty($_POST['product_name']) && $_POST['product_name'] != "")
			{
				$productObj = new Product();
				$productData = $productObj->checkProductName($_POST['product_name']);	
				
				if(!empty($productData))
				{
					$title = "Create Product";
					Yii::app()->user->setFlash("error","Product name already exist.");
					$this->render("addProduct",array('productData'=>$_POST,'title'=>$title));	
					exit;
				}
			}
			$data = array();
			$data['product_name'] = $_POST['product_name'];
			
			$data['product_desc'] = $_POST['product_desc'];
			//$data['product_image'] = $_POST['product_image'];
			$data['product_price'] = $_POST['product_price'];
			$data['product_price'] = $_POST['product_price'];
			$data['unitId'] = $_POST['unit_id'];
			$data['safetyMargin'] = $_POST['safetyMargin'];
			$data['vendor_id'] = $_POST['vendor_id'];
			$data['profit_percentage'] = $_POST['profit_percentage'];
			//$data['profit_percentage_id'] = $_POST['profit_percentage_id'];
			
			$data['wholesale_price'] = $_POST['wholesale_price'];
			
			$data['is_discount'] = $_POST['isDiscount'];
			$data['discount'] = $_POST['discount'];
			$data['discount_from'] = date("Y-m-d",strtotime($_POST['discount_from']));
			$data['discount_to'] = date("Y-m-d",strtotime($_POST['discount_to']));
			$data['discount_desc'] = $_POST['discount_desc'];
			
			$data['cat_id'] = $_POST['cat_id'];
			$data['admin_id'] = Yii::app()->session['farmsourcing_adminUser'];
			$data['created_date'] = date("Y-m-d H:i:s");
			$data['modified_date'] = date("Y-m-d H:i:s");
			if(isset($_FILES['userFile']['name']) && $_FILES['userFile']['name'] != "")
			 {
				$text = str_replace(" ", "_", $data['product_name']);
				$data['product_image']=$text."_".strtotime(date("Y-m-d")).".png";
						
				 move_uploaded_file($_FILES['userFile']["tmp_name"],FILE_UPLOAD."product/".$data['product_image']);	 
			 }
			 
			if(isset($_POST['featured']) && $_POST['featured'] == "1")
			{
				$data['featured'] = 1 ; 	
			}else{
				$data['featured'] = 0 ; 
			}
			
			if(isset($_POST['special']) && $_POST['special'] == "1")
			{
				$data['special'] = 1 ; 	
			}else{
				$data['special'] = 0 ; 
			}
			
			$productObj = new Product();
			$productObj->setData($data);
			$productObj->insertData();
			Yii::app()->user->setFlash("success","Successfully added product.");
			$this->redirect(array("admin/productListing"));
			exit;
		}
		
		$data = array();
		$title = "Create Product";
		$this->render("addProduct",array('title'=>$title));
		exit;
	}
	
	function actionchangeProductPrice()
	{
		if(!empty($_POST['product_price']) && $_POST['product_price'] != "")
		{
			$data['product_price'] = $_POST['product_price'];
			$data['modified_date'] = date("Y-m-d H:i:s");
			
			$productObj = new Product();
			$productObj->setData($data);
			$productObj->insertData($_POST['product_id']);
			Yii::app()->user->setFlash("success","Product price successfully changed.");
		}
		$this->redirect(array("admin/productPriceListing"));	
	}
	
	function actioneditCustomer()
	{
		$data = array();
		$title = "Update Customer";
		$customerObj = new Customers();
		$customerData = $customerObj->getCustomerById($_GET['id']);
		$this->render("addCustomer",array('customerData'=>$customerData,'title'=>$title));
	}
	
	function actionaddCustomer()
	{
		
		$this->isLogin();
	  	
		if(isset($_POST['id']) && $_POST['id'] != '')
		{
				
			
			$data = array();
			$_POST['customer_id'] = $_POST['id'];
			$data['customer_name'] = $_POST['customer_name'];
			/*if(isset($_POST['mobile_no']) && $_POST['mobile_no'] != "")
			{
				$digit = substr($_POST['mobile_no'],'0','3');
				
				if($digit != "+91")
				{
					$data['mobile_no'] = "+91".$_POST['mobile_no'];		
				}else{
					$data['mobile_no'] = $_POST['mobile_no'];	
				}
				
			}*/
			if(isset($_POST['block']) && $_POST['block'] != "")
			{
				$data['block'] = $_POST['block'];
			}
			if(isset($_POST['membership_no']) && $_POST['membership_no'] != "")
			{
				$data['membership_no'] = $_POST['membership_no'];
			}
			$data['house_no'] = $_POST['house_no'];
			$data['building_name'] = $_POST['building_name'];
			$data['landmark1'] = $_POST['landmark1'];
			$data['landmark2'] = $_POST['landmark2'];
			$data['area'] = $_POST['area'];
			$data['city'] = $_POST['city'];
			$data['country'] = $_POST['country'];
			$data['pincode'] = $_POST['pincode'];
			
			$data['customer_type'] = $_REQUEST['customer_type'];
			
			$digit = substr($_POST['mobile_no'],'0','3');
				
			if($digit != "+91")
			{
				$data['mobile_no'] = "+91".$_POST['mobile_no'];		
			}else{
				$data['mobile_no'] = $_POST['mobile_no'];	
			}
			
			if(isset($_POST['contact_no']) && $_POST['contact_no'] != "")
			{
				$data['contact_no'] = $_POST['contact_no'];
			}
			
			if(isset($_POST['cust_email']) && trim($_POST['cust_email']) != "")
			{
				$data['cust_email'] = trim($_POST['cust_email']);
				$customersObj = new Customers();
				$customerDataByEmail = $customersObj->checkCustomerEmail($data['cust_email']);
				if(!empty($customerDataByEmail) && $customerDataByEmail != $_POST['id'] )
				{
					Yii::app()->user->setFlash("error","Email already exist.");
					$title = "Update Customer";
					$customerData = $_POST ;
					$this->render("addCustomer",array('customerData'=>$customerData,'title'=>$title));
					exit;
					//$this->redirect(array("admin/customerListing"));
					//exit;
				}
			}else{
				$data['cust_email'] = "";
			}
			
			$customersObj = new Customers();
			$customerData = $customersObj->checkCustomerMobile($data['mobile_no']);
			
			if(!empty($customerData) && $customerData != $_POST['id'])
			{
				Yii::app()->user->setFlash("error","Mobile number already exist.");
				$title = "Update Customer";
				$customerData = $_POST ;
				$customerData['customer_id'] = $_POST['id'];
				$this->render("addCustomer",array('customerData'=>$customerData,'title'=>$title));
				exit;
				//$this->redirect(array("admin/customerListing"));
				//exit;
			}else if(empty($customerData)){
				$userObj = new Users();
				$user_Data = $userObj->getUserByCustomerId($_POST['id']);
			
				$userData = array();
				$userData['mobile_no'] = $data['mobile_no'];
				$userData['modifiedAt'] = date("Y-m-d H:i:s");
				
				$userObj = new Users();
				$userObj->setData($userData);
				$userObj->insertData($user_Data['id']);
			}
			
			//$data['cust_email'] = $_POST['cust_email'];
			/*$data['total_purchase'] = $_POST['total_purchase'];
			$data['credit'] = $_POST['credit'];
			$data['debit'] = $_POST['debit'];*/
			$data['zone_id'] = $_POST['zone_id'];
			
			
			if($_POST['zone_id'] < 10){
				$zoneId = str_pad($_POST['zone_id'], 3, '0', STR_PAD_LEFT);
			}
			if($_POST['zone_id'] < 100){
				$zoneId = str_pad($_POST['zone_id'], 3, '0', STR_PAD_LEFT);
			}
			$data['representativeId'] = $zoneId.''.substr($_POST['representativeId'],-4,4);
			
			
			
			$data['admin_id'] = Yii::app()->session['farmsourcing_adminUser'];
			$data['modifiedAt'] = date("Y-m-d H:i:s");
			
			/*$customersObj = new Customers();
			$customerData = $customersObj->checkCustomerEmail($data['cust_email']);
			
			if(!empty($customerData))
			{
				Yii::app()->user->setFlash("error","Email already exist.");
				$title = "Update Customer";
				$customerData = $_POST ;
				$this->render("addCustomer",array('customerData'=>$customerData,'title'=>$title));
				exit;
			}*/
			
			$customersObj = new Customers();
			$customersObj->setData($data);
			$res = $customersObj->insertData($_POST['id']);
			
			Yii::app()->user->setFlash("success","Successfully updated customer.");
			$this->redirect(array("admin/customerListing"));
			exit;
		}
		
	    if(isset($_POST['customer_name']) && $_POST['customer_name'] != '' && empty($_POST['id']))
		{
			
			$data = array();
			$data['customer_name'] = $_POST['customer_name'];
			if(isset($_POST['mobile_no']) && $_POST['mobile_no'] != "")
			{
				$digit = substr($_POST['mobile_no'],'0','3');
				
				if($digit != "+91")
				{
					$data['mobile_no'] = "+91".$_POST['mobile_no'];		
				}else{
					$data['mobile_no'] = $_POST['mobile_no'];	
				}
				
			}
			if(isset($_POST['block']) && $_POST['block'] != "")
			{
				$data['block'] = $_POST['block'];
			}
			if(isset($_POST['membership_no']) && $_POST['membership_no'] != "")
			{
				$data['membership_no'] = $_POST['membership_no'];
			}
			$data['house_no'] = $_POST['house_no'];
			$data['building_name'] = $_POST['building_name'];
			$data['landmark1'] = $_POST['landmark1'];
			$data['landmark2'] = $_POST['landmark2'];
			$data['area'] = $_POST['area'];
			$data['city'] = $_POST['city'];
			$data['country'] = $_POST['country'];
			$data['pincode'] = $_POST['pincode'];
			if(isset($_POST['cust_email']) && trim($_POST['cust_email']) != "")
			{
				$data['cust_email'] = trim($_POST['cust_email']);
				
				$customersObj = new Customers();
				$customerData = $customersObj->checkCustomerEmail($data['cust_email']);
				
				if(!empty($customerData))
				{
					Yii::app()->user->setFlash("error","Email already exist.");
					$title = "Create Customer";
					$customerData = $_POST ;
					$this->render("addCustomer",array('customerData'=>$customerData,'title'=>$title));
					exit;
					//$this->redirect(array("admin/customerListing"));
					//exit;
				}
			}
			
			
			if(isset($_POST['contact_no']) && $_POST['contact_no'] != "")
			{
				$data['contact_no'] = $_POST['contact_no'];
			}
			/*$data['total_purchase'] = $_POST['total_purchase'];
			$data['credit'] = $_POST['credit'];
			$data['debit'] = $_POST['debit'];*/
			$representativeIdsObj = new RepresentativeIds();
			$representativeId = $representativeIdsObj->getRepresentativeId();
			
			
			if($_POST['zone_id'] < 10){
				$zoneId = str_pad($_POST['zone_id'], 3, '0', STR_PAD_LEFT);
			}
			if($_POST['zone_id'] < 100){
				$zoneId = str_pad($_POST['zone_id'], 3, '0', STR_PAD_LEFT);
			}
			$data['representativeId'] =  $zoneId .''.$representativeId['customer_id'];
			$data['zone_id'] = $_POST['zone_id'];
			$data['admin_id'] = Yii::app()->session['farmsourcing_adminUser'];
			$data['createdAt'] = date("Y-m-d H:i:s");
			$data['modifiedAt'] = date("Y-m-d H:i:s");
			
			$customersObj = new Customers();
			$customerData = $customersObj->checkCustomerMobile($data['mobile_no']);
			
			if(!empty($customerData))
			{
				Yii::app()->user->setFlash("error","Mobile number already exist.");
				$title = "Create Customer";
				$customerData = $_POST ;
				$this->render("addCustomer",array('customerData'=>$customerData,'title'=>$title));
				exit;
				//$this->redirect(array("admin/customerListing"));
				//exit;
			}
			
			$data['customer_type'] = $_REQUEST['customer_type'];
			
			$customersObj = new Customers();
			$customersObj->setData($data);
			$Id = $customersObj->insertData();
			
			$dataRep = array();
			$dataRep['customer_id'] = $representativeId['customer_id'] + 1;
			$representativeIdsObj = new RepresentativeIds();
			$representativeIdsObj->setData($dataRep);
			$representativeIdsObj->insertData($representativeId['id']);
			
			$userData = array();
			$userData['customer_id'] = $Id;
			$userData['mobile_no'] = $data['mobile_no'];
			if(isset($_POST['cust_email']) && $_POST['cust_email'] != "")
			{
				$userData['email'] = $_POST['cust_email'];
			}
			$userData['password'] = "MTExMTExODg2NjM4NTUyNw";
			if(isset($_POST['customer_name']) && $_POST['customer_name'] != "")
			{
				$userData['name'] = $_POST['customer_name'];
			}
			$userData['isVerified'] = 1;
			$userData['status'] = 1;
			$userData['sessionId'] = "";
			$userData['fpasswordConfirm'] = "";
			
			$userData['createdAt'] = date("Y-m-d H:i:s");
			$userData['modifiedAt'] = date("Y-m-d H:i:s");
			
			$userObj = new Users();
			$userObj->setData($userData);
			$userObj->insertData();
			
			Yii::app()->user->setFlash("success","Successfully added customer.");
			$this->redirect(array("admin/customerListing"));
			exit;
		}
		
		$data = array();
		$title = "Create Customer";
		$this->render("addCustomer",array('title'=>$title));
		exit;
	}
	
	public function actiondeleteCustomer()
	{
		$this->isLogin();
		
		$customersObj = new Customers();
		$customersObj->deleteCustomer($_REQUEST['id']);
		
		Yii::app()->user->setFlash("success","Customer deleted successfully.");
		header('Location: ' . $_SERVER['HTTP_REFERER']);
	}
	
	public function actionshowCustomerDetail()
	{
		if($_REQUEST['id'] == "")
		{
			echo 0;
			exit;	
		}
		else
		{
			$this->isLogin();
			
			$customersObj = new Customers();
			$customerData = $customersObj->getCustomeDetailrById($_REQUEST['id']);
			
			if(!empty($customerData))
			{
				$this->renderPartial("customerDetails",array("customerData"=>$customerData));
				exit;
			}
			else
			{
				echo 0;
				exit;
			}
		}
	}
	
	function actionraiseCustomerCard()
	{
		//error_reporting(E_ALL);
		if(!isset($_REQUEST['id']) || $_REQUEST['id'] == "" )
		{
			$this->redirect(array("admin/customerListing"));	
			exit;
		}
		
		$customersObj = new Customers();
		$customerData = $customersObj->getCustomeDetailrById($_REQUEST['id']);
		
		$html = '<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Untitled Document</title>
		<style type="text/css">
			body,td,th {
				font-family: Arial, Helvetica, sans-serif;
				font-size: 10px;
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
		<div style="height:35px;">&nbsp;</div>
		<div style="margin-top:25px !important;">
		 <table border="0" cellpadding="3" cellspacing="3" style="width:100%;  margin-left:140px;">
            <tr>
                <td align="left"><b style="color:#1C572B">No. :</b></td>
                <td align="left">'.$customerData['representativeId'].'</td>
            </tr>
			<tr>
                <td align="left"><b style="color:#1C572B">Name :</b></td>
                <td align="left">'.$customerData['customer_name'].'</td>
            </tr>
           <tr>
                <td align="left"><b style="color:#1C572B">Zone :</b></td>
                <td align="left">'.$customerData['zoneName'].'</td>
           </tr>
		   <tr>
                <td align="left" width="70px;"><b style="color:#1C572B">Issue Date :</b></td>
                <td align="left">'.date('d-m-Y',strtotime($customerData['createdAt'])).'</td>
           </tr>
       </table>
	   </div>
       </body>
		</html>';
		
		//echo $html; exit;
		//$mpdf=new mPDF('c','A5'); 
		//$mpdf=new mPDF('c', array(127,81.28));
		$mpdf = new mPDF('',array(86,52),$default_font_size=0,$default_font='',$mgl=0,$mgr=0,$mgt=0,$mgb=0,$mgh=0,$mgf=0, $orientation='P');
		//$mpdf->WriteHTML('<pagebreak sheet-size="127mm 81.28mm" />');
		//$mpdf->WriteHTML('<pagebreak sheet-size="127mm 81.28mm" />');
		$mpdf->WriteHTML($html);
		$mpdf->Output(FILE_PATH."assets/upload/members/members_".$_REQUEST['id'].".pdf", 'F');
		
		return true;
		//$this->redirect(Yii::app()->params->base_url."user");
	}
	
	function actionsalesOrderListing()
	{
		$this->isLogin();
		
		$ext['toDate'] = date("m/d/Y");
		$ext['fromDate'] = date('m/d/Y', strtotime('-3 days', strtotime($ext['toDate'])));
		
		$SoDetailsObj = new SoDetails();
		$soList = $SoDetailsObj->getsalesOrderListingByDate($ext['fromDate'],$ext['toDate']);
		
		$data['soList']	=	$soList;
		Yii::app()->session['current'] = "orders";
		$this->render("soListing", array('data'=>$data,'ext'=>$ext));
	}
	
	function actionsalesOrderListingWithFilters()
	{
		$this->isLogin();
		
		if(isset($_REQUEST['zone_id']) && $_REQUEST['zone_id'] != "")
		{
			$ext['zone_id'] = 	$_REQUEST['zone_id'] ;
		}else{
			$ext['zone_id'] = 	"" ;			
		}
		
		if(isset($_REQUEST['status']) && $_REQUEST['status'] != "")
		{
			$ext['status'] = 	$_REQUEST['status'] ;
		}else{
			$ext['status'] = 	"" ;			
		}
		
		if(isset($_REQUEST['type']) && $_REQUEST['type'] != "")
		{
			$ext['type'] = 	$_REQUEST['type'] ;
		}else{
			$ext['type'] = 	"" ;			
		}
		
		if(isset($_REQUEST['fromDate']) && $_REQUEST['fromDate'] != "")
		{
			$ext['fromDate'] = 	$_REQUEST['fromDate'] ;
		}else{
			$ext['fromDate'] = 	"" ;			
		}
		
		if(isset($_REQUEST['toDate']) && $_REQUEST['toDate'] != "")
		{
			$ext['toDate'] = 	$_REQUEST['toDate'] ;
		}else{
			$ext['toDate'] = 	"" ;			
		}
		
		$SoDetailsObj = new SoDetails();
		$soList = $SoDetailsObj->getsalesOrderListingWithFilters($ext['zone_id'],$ext['status'],$ext['type'],$ext['fromDate'],$ext['toDate']);
		
		$data['soList']	=	$soList;
		Yii::app()->session['current'] = "orders";
		$this->render("soListing", array('data'=>$data,'ext'=>$ext));
	}
	
	function actionshowSoDetail()
	{
		if($_REQUEST['id'] == "")
		{
			echo 0;
			exit;	
		}
		else
		{
			$this->isLogin();
			
			$SoDetailsObj = new SoDetails();
			$soDetailsData = $SoDetailsObj->getsalesOrderData($_REQUEST['id']);
			
			$SoDescObj = new SoDesc();
			$soDescData = $SoDescObj->getSoDescDetails($_REQUEST['id']);
			
			if(!empty($soDescData))
			{
				$this->renderPartial("salesOrderDetails",array("soDescData"=>$soDescData,"soDetailsData"=>$soDetailsData));
				exit;
			}
			else
			{
				echo 0;
				exit;
			}
		}
	}
	
	function actioneditUser()
	{
		$data = array();
		$title = "Update User";
		$adminObj = new Admin();
		$userData = $adminObj->getAdminDetailsById($_GET['id']);
		
		$this->render("addUser",array('userData'=>$userData,'title'=>$title));
	}
	
	function actionaddUser()
	{
		
		$this->isLogin();
	  	
		if(isset($_POST['id']) && $_POST['id'] != '')
		{
			
			$data = array();
			$data['firstName'] = $_POST['firstName'] ;
			$data['lastName'] = $_POST['lastName'];
			//$data['username'] = rand(100000,10000000000).''.strtotime("Y-m-d H:i:s"); 
			//$data['email'] = $_POST['email'];
			$data['isVerified'] = 1;
			if(isset($_FILES['avatar']['name']) && $_FILES['avatar']['name'] != "")
			{
				$data['avatar']="user_".$_POST['id'].".png";
					
				move_uploaded_file($_FILES['avatar']["tmp_name"],FILE_UPLOAD."avatar/".$data['avatar']);	 
			}			
			//$data['password'] = $_POST['password'];
			//$data['phone'] = $_POST['phone'];
			$data['mobile'] = $_POST['mobile'];
			$data['status'] = 1;
			$data['type'] = $_POST['type'];
			
			//$data['admin_id'] = Yii::app()->session['farmsourcing_adminUser'];
			$data['modified_at'] = date("Y-m-d H:i:s");
			
			$adminObj = new Admin();
			$adminObj->setData($data);
			$res = $adminObj->insertData($_POST['id']);
			
			
			
			Yii::app()->user->setFlash("success","Successfully updated user.");
			$this->redirect(array("admin/userListing"));
			exit;
		}
		
	    if(isset($_POST) && $_POST['firstName'] != '' && isset($_POST['id']) && $_POST['id'] == '')
		{
			
			$data = array();
			$data['firstName'] = $_POST['firstName'];
			$data['lastName'] = $_POST['lastName'];
			//$data['username'] = rand(100000,10000000000).''.strtotime("Y-m-d H:i:s"); 
			$data['email'] = $_POST['email'];
			
			$algoObj	=	new General();
			$data['password']	=	$algoObj->encrypt_password($_POST['password']);
			
			$data['mobile'] = $_POST['mobile'];
			$data['avatar'] = $_POST['photo'];
			$data['status'] = 1;
			$data['type'] = $_POST['type'];
			//$data['admin_id'] = Yii::app()->session['farmsourcing_adminUser'];
			$data['created_at'] = date("Y-m-d H:i:s");
			$data['modified_at'] = date("Y-m-d H:i:s");
			
			$adminObj = new Admin();
			$adminData = $adminObj->getAdminIdByLoginId($data['email']);
			
			if(!empty($adminData))
			{
				Yii::app()->user->setFlash("error","Email already exist.");
				$userData = $_POST ;
				$title = "Create User";
				$this->render("addUser",array('userData'=>$userData,'title'=>$title));
				exit;
				//$this->redirect(array("admin/customerListing"));
				//exit;
			}
			
			$adminObj = new Admin();
			$adminObj->setData($data);
			$id = $adminObj->insertData();
			
			if(isset($_FILES['avatar']['name']) && $_FILES['avatar']['name'] != "")
			{
				$userimage['avatar']="user_".$id.".png";
					
				move_uploaded_file($_FILES['avatar']["tmp_name"],FILE_UPLOAD."avatar/".$userimage['avatar']);	 
			}
			
			$adminObj = new Admin();
			$adminObj->setData($userimage);
			$adminObj->insertData($id);
			
			$email = $data['email'];
			
			$companyDetailsObj	=	new CompanyDetails();
			$adminDetails = $companyDetailsObj->getCompanyDetailsByAdminId(Yii::app()->session['farmsourcing_adminUser']);
			
			$subject = "FreshNPack user registration by admin";
				
			$message='<table cellpadding="5" cellspacing="5" style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px;background-color:#E5E5E5;" width="600">
				<tr>
				<td style="background-color:#000">
					<div style="text-align:left"><img src="images/logo/logo.png" style="width:160px; height:40px;"></div>
				</td>
				</tr>
				<tr>
					<td>Welcome to Fresh N Pack system!</td>
				</tr>
				<tr>
					<td>Your account has been successfully created by admin.<br /></td>
				</tr>
				<tr>
					<td>Your email is: '.$email.'</td>
				</tr>
				<tr>
					<td>Password: '.$_POST['password'].'</td>
				</tr>
				<tr>
					<td>
						 Thank you,
					</td>
				</tr>
				<tr>
					<td>
						 Team FreshNPack.
					</td>
				</tr>
				</table>';
			
			//$helperObj	=	new Helper();
			//$mailResponse=$helperObj->sendMail($email,$subject,$message);
			
			Yii::app()->user->setFlash("success","Successfully added user.");
			$this->redirect(array("admin/userListing"));
			exit;
		}
		
		$data = array();
		$title = "Create User";
		$this->render("addUser",array('title'=>$title));
		exit;
	}
	
	public function actionshowUserDetail()
	{
		if($_REQUEST['id'] == "")
		{
			echo 0;
			exit;	
		}
		else
		{
			$this->isLogin();
			
			$adminObj = new Admin();
			$userData = $adminObj->getAdminDetailsById($_REQUEST['id']);
			
			if(!empty($userData))
			{
				$this->renderPartial("userDetail",array("userData"=>$userData));
				exit;
			}
			else
			{
				echo 0;
				exit;
			}
		}
	}
	
	public function actiondeleteUser()
	{
		
		$this->isLogin();
		
		$adminObj = new Admin();
		$adminObj->deleteUser($_REQUEST['id']);
		
		Yii::app()->user->setFlash("success","User deleted successfully.");
		header('Location: ' . $_SERVER['HTTP_REFERER']);
	}
	
	function actionchangeUserStatus()
	{	
		$this->isLogin();
		if(isset($_REQUEST['id']) && $_REQUEST['id'] != "")
		{
			$userId = $_REQUEST['id'];
		}else
		{
			$userId = "";	
		}
		$adminObj = new Admin();
		$data    = $adminObj->getAdminDetailsById($userId);
		
		if($data['status'] == 1)
		{
			$status = 0 ;	
		}else
		{
			$status = 1 ;	
		}
		
		$admin=Admin::model()->findByPk($data['id']);
		$admin->status=$status;
		$admin->modified_at=date("Y-m-d:H-m-s");
		$res =  $admin->save();
		
		Yii::app()->user->setFlash('success', "User status successfully changed.");
		$this->redirect(array("admin/userListing"));
		
	}
	
	function actionchangeProductStatus()
	{	
		error_reporting(0);
		$this->isLogin();
		if(isset($_REQUEST['product_id']) && $_REQUEST['product_id'] != "")
		{
			$productId = $_REQUEST['product_id'];
		}else
		{
			$productId = "";	
		}
		$productObj = new Product();
		$data    = $productObj->getProductById($productId);
		
		if($data['status'] == 1)
		{
			$status = 0 ;	
		}else
		{
			$status = 1 ;	
		}
		
		$product=Product::model()->findByPk($data['product_id']);
		$product->status=$status;
		$product->modified_date=date("Y-m-d:H-m-s");
		$res =  $product->save();
		
		Yii::app()->user->setFlash('success', "Product status successfully changed.");
		$this->redirect(array("admin/productListing"));
		
	}
	
	function actionshowChangePassword()
	{
		if($_REQUEST['id'] == "")
		{
			echo 0;
			exit;	
		}else{
			$this->isLogin();
			
			$this->renderPartial("set_user_password",array("id"=>$_REQUEST['id']));
			exit;
		}
	}
	
	function actionshowCustomerChangePassword()
	{
		if($_REQUEST['id'] == "")
		{
			echo 0;
			exit;	
		}else{
			$this->isLogin();
			
			$this->renderPartial("set_customer_password",array("id"=>$_REQUEST['id']));
			exit;
		}
	}
	
	function actionshowEditProduct()
	{
		if($_REQUEST['id'] == "")
		{
			echo 0;
			exit;	
		}else{
			$this->isLogin();
			
			$productObj = new Product();
			$productData = $productObj->getProductById($_REQUEST['id']);
			
			if(!empty($productData))
			{
				$this->renderPartial("editProductPriceView",array("productData"=>$productData));
				exit;
			}
			else
			{
				echo 0;
				exit;
			}
		}
	}
	
	function actionsetNewPasswordOfUser()
	{
		if($_REQUEST['id'] == "")
		{
			$this->redirect(array("admin/userListing"));
			exit;	
		}else{
			$this->isLogin();
			
			$data['modified_at'] = date("Y-m-d:H-m-s");

			$algoObj	=	new General();
			$data['password']	=	$algoObj->encrypt_password($_POST['password']);
		
			$adminObj = new Admin();
			$adminObj->setData($data);
			$Id = $adminObj->insertData($_REQUEST['id']);
			
			Yii::app()->user->setFlash('success',"User password successfully changed.");
			$this->redirect(array("admin/userListing"));
			exit;
		}
	}
	
	function actionsetNewPasswordOfCustomer()
	{
		if($_REQUEST['id'] == "")
		{
			$this->redirect(array("admin/userListing"));
			exit;	
		}else{
			$this->isLogin();
			
			$userData['modifiedAt'] = date("Y-m-d H:i:s");

			$algoObj	=	new Algoencryption();
			$userData['password']	=	$algoObj->encrypt($_POST['password']);
		
			$userObj = new Users();
			$userObj->setData($userData);
			$Id = $userObj->insertData($_REQUEST['id']);
			
			Yii::app()->user->setFlash('success',"Customer password successfully changed.");
			$this->redirect(array("admin/customerListing"));
			exit;
		}
	}
	
	function actionpoGenerateView()
	{
		$this->isLogin();
		Yii::app()->session['current'] = "PO Generation";
		$this->render("poGenerateView");
	}
	
	
	function actiondeliveryInit()
	{
		$title = "Delivery Slips";
		Yii::app()->session['current'] = "Delivery Slips";
		$this->render("deliveryListInit",array('title'=>$title));
		
	}
	
	function actionregenerateDeliverySlip()
	{
		$this->isLogin();
		$title = "Delivery List";
		Yii::app()->session['current'] = "Delivery List";
		
		if(isset($_POST) && isset($_POST['delivery_date']) != "")
		{
			//$_POST['delivery_date'] = '18-02-2014';
			
			
			$deliveryDetailsObj =  new DeliveryDetails();
			$res = $deliveryDetailsObj->deleteOldDeliveryData(date("Y-m-d",strtotime($_POST['delivery_date'])));
			
			
			Yii::app()->session['delivery_date_for_so'] = $_POST['delivery_date'];
			
			$delivery_date = date("Y-m-d",strtotime($_POST['delivery_date']));
			$soDetailObj = new SoDetails();
			$zoneWiseData = $soDetailObj->getZoneWiseCustomerData($delivery_date);
			
			if(empty($zoneWiseData))
			{
				Yii::app()->user->setFlash('error',"No data found for generate delivery list.");
				$this->redirect(array("admin/generateDeliveryReport"));
				exit;	
			}else
			{
			
				$this->render("deliveryListFirst",array('title'=>$title,'zoneWiseData'=>$zoneWiseData,'delivery_date'=>$delivery_date));
				exit;
			}
		}else{
			$this->render("regenerateDeliveryList");
			exit;
		}
			
		
	}

	function actiondeliverySlip()
	{
		$title = "Delivery List";
		Yii::app()->session['current'] = "Delivery List";
		
		$_POST['delivery_date'] = date("d-m-Y", time() + 86400);
		//$_POST['delivery_date'] = '02-04-2014';
		
		$deliveryDetailsObj =  new DeliveryDetails();
		$res = $deliveryDetailsObj->getDriverListFromDeliveryData(date("Y-m-d",strtotime($_POST['delivery_date'])));
		
		if(empty($res))
		{
			Yii::app()->session['delivery_date_for_so'] = $_POST['delivery_date'];
			$delivery_date = date("Y-m-d",strtotime($_POST['delivery_date']));
			$soDetailObj = new SoDetails();
			$zoneWiseData = $soDetailObj->getZoneWiseCustomerData($delivery_date);
			
			if(empty($zoneWiseData))
			{
				Yii::app()->user->setFlash('error',"No data found for generate delivery list.");
				$this->redirect(array("admin/generateDeliveryReport"));
				exit;	
			}else
			{
			
				$this->render("deliveryListFirst",array('title'=>$title,'zoneWiseData'=>$zoneWiseData,'delivery_date'=>$delivery_date));
				exit;
			}
		}
		else if($res[0]['status'] == 0 )
		{
			$this->actiondeliverySlipstep3();
			exit;
		}
		else if($res[0]['status'] == 1 )
		{
			Yii::app()->user->setFlash('error',"Today's delivery List already generated.");
			$this->redirect(array("admin/generateDeliveryReport"));
			exit;
		}
			
		
	}
	
	function actiondeliverySlipstep2()
	{
		$title = "Delivery List";
		Yii::app()->session['current'] = "Delivery List";
		$adminObj =  new Admin();
		$driverData  =  $adminObj->getAllDrviers();
		
		$delivery_date = date("Y-m-d",strtotime($_POST['delivery_date']));
		
		$soDetailObj = new SoDetails();
		$zoneWiseData = $soDetailObj->getZoneWiseCustomerDataGroup($delivery_date);
		
		$this->render("deliveryListSecond",array('title'=>$title,'zoneWiseData'=>$zoneWiseData,'driverData'=>$driverData,'delivery_date'=>$delivery_date));
		
	}
	
	function actiondeliverySlipstep3()
	{
		$title = "Delivery List";
		Yii::app()->session['current'] = "Delivery List";
		
		$delivery_date = date("Y-m-d",strtotime($_POST['delivery_date']));
		$count = $_POST['count'];
		$allocationData = array();
		$driver = array();
		
		for($i=1;$i<=$count;$i++)
		{
			$key = array_search($_POST['driver_id_'.$i],$driver);
			if(empty($key))
			{
				$driver[$i] =  $_POST['driver_id_'.$i];
				
				$data['admin_id'] = Yii::app()->session['farmsourcing_adminUser'];
				$data['driver_id'] = $_POST['driver_id_'.$i];
				$data['delivery_date'] = $delivery_date ;
				$data['status'] = 0 ;
				$data['createdAt'] = date("Y-m-d H:i:s");
				$data['modifiedAt'] = date("Y-m-d H:i:s");
				
				$deliveryDetailsObj = new DeliveryDetails();
				$deliveryDetailsObj->setData($data);
				$deliveryId[$i] = $deliveryDetailsObj->insertData();
				
				$soDetailsObj = new SoDetails();
				$soData = $soDetailsObj->getAllSoListByZoneId($_POST['zone_id_'.$i],$delivery_date);
				
				foreach($soData as $row)
				{
					
					$sodescData['delivery_id'] = $deliveryId[$i];	
					$sodescData['admin_id'] = Yii::app()->session['farmsourcing_adminUser'];
					$sodescData['customer_id'] = $row['customer_id'];
					$sodescData['zone_id'] = $row['zone_id'];
					$sodescData['so_id'] = $row['so_id'];
					$sodescData['type'] = $row['type'];
					$sodescData['no_of_packets'] = $row['total_packets'];
					$sodescData['coupon_amount'] = $row['coupon_amount'];
					$sodescData['order_date'] = $row['createdAt'];
					$sodescData['delivery_date'] = $delivery_date ;
					$sodescData['status'] = 0;
					$sodescData['createdAt'] = date("Y-m-d H:i:s");
					$sodescData['modifiedAt'] = date("Y-m-d H:i:s");
					
					$deliveryDescObj = new DeliveryDesc();
					$deliveryDescObj->setData($sodescData);
					$deliveryDescObj->insertData();
					
				}
			}else{
				
				$soDetailsObj = new SoDetails();
				$soData = $soDetailsObj->getAllSoListByZoneId($_POST['zone_id_'.$i],$delivery_date);
				
				foreach($soData as $row)
				{
					$sodescData['delivery_id'] = $deliveryId[$key] ;	
					$sodescData['admin_id'] = Yii::app()->session['farmsourcing_adminUser'];
					$sodescData['customer_id'] = $row['customer_id'];
					$sodescData['zone_id'] = $row['zone_id'];
					$sodescData['so_id'] = $row['so_id'];
					$sodescData['type'] = $row['type'];
					$sodescData['no_of_packets'] = $row['total_packets'];
					$sodescData['order_date'] = $row['createdAt'];
					$sodescData['delivery_date'] = $delivery_date ;
					$sodescData['status'] = 0;
					$sodescData['createdAt'] = date("Y-m-d H:i:s");
					$sodescData['modifiedAt'] = date("Y-m-d H:i:s");
					
					$deliveryDescObj = new DeliveryDesc();
					$deliveryDescObj->setData($sodescData);
					$deliveryDescObj->insertData();
				}
			}
		}
		
		$deliveryListObj =  new DeliveryDetails();
		$driverData  =  $deliveryListObj->getDriverListFromDeliveryData($delivery_date);
		
		$this->render("deliveryListThird",array('title'=>$title,'driverData'=>$driverData,'delivery_date'=>$delivery_date));
		
	}
	
	function actionsaveCouponFloat()
	{
		$title = "Delivery Slips";
		$data = array();
		$count = $_POST['count'];
		for($i=1;$i<=$count;$i++)
		{
			if(isset($_POST['cash_amount_'.$i]))
			{
			$data['cash_amount'] = $_POST['cash_amount_'.$i];
			}
			if(isset($_POST['coupon_amount_'.$i]))
			{
			$data['coupon_amount'] = $_POST['coupon_amount_'.$i];
			}
			$data['status'] = 1;
			$data['modifiedAt'] = date("Y-m-d H:i:s");
			
			$deliveryDetailsObj = new DeliveryDetails();
			$deliveryDetailsObj->setData($data);
			$deliveryDetailsObj->insertData($_POST['delivery_id_'.$i]);
			
			$deliveryDescObj = new DeliveryDesc();
			$deliveryDescData = $deliveryDescObj->getDeliveryDescData($_POST['delivery_id_'.$i]);
			
			foreach($deliveryDescData as $row)
			{
				$soDescObj = new SoDesc();
				$soDescData = $soDescObj->getSoDescDetails($row['so_id']);
				
				$so_amount = 0;
				foreach($soDescData as $rand)
				{
					$DeliveryOrderDesc['delivery_desc_id'] = $row['id'];
					$DeliveryOrderDesc['so_id'] = $row['so_id'];
					$DeliveryOrderDesc['admin_id'] = Yii::app()->session['farmsourcing_adminUser'];
					$DeliveryOrderDesc['product_id'] = $rand['product_id'];
					$DeliveryOrderDesc['so_quantity'] = $rand['quantity'];
					$DeliveryOrderDesc['sale_quantity'] = $rand['quantity'];
					$DeliveryOrderDesc['no_of_packets'] = $rand['no_of_packets'];
					$DeliveryOrderDesc['packaging_scenario'] = $rand['packaging_scenario'];
					$DeliveryOrderDesc['actual_product_price'] = $rand['actual_product_price'];
					$DeliveryOrderDesc['discount_amount'] = $rand['discount_amount'];
					$DeliveryOrderDesc['discount_desc'] = $rand['discount_desc'];
					$DeliveryOrderDesc['status'] = 0 ;
					$DeliveryOrderDesc['modifiedAt'] = date("Y-m-d H:i:s");
					$DeliveryOrderDesc['createdAt'] = date("Y-m-d H:i:s");
					
					/*
					$productObj = new Product();
					$productData = $productObj->getProductById($DeliveryOrderDesc['product_id']);
					
					$podescObj = new PoDesc();
					$avg = $podescObj->getProductAvgPrice($DeliveryOrderDesc['product_id']);
					
					if($avg == ""  || empty($avg))
					{
						$avg = 0 ;	
					}
					
					$profitPercentageObj = new ProfitPercentageMaster();
					$profit = $profitPercentageObj->getProductProfit($DeliveryOrderDesc['product_id']);
					
					if($profit == ""  || empty($profit))
					{
						$productObj = new Product();
						$productData = $productObj->getProductById($DeliveryOrderDesc['product_id']);
						
						if($productData['profit_percentage'] != ""  || !empty($productData['profit_percentage']))
						{
							$profit = $productData['profit_percentage'];
						}else{
							$profit = 0;	
						}
						
					}*/
					
					$price = $rand['product_price'];
					$amount = $DeliveryOrderDesc['sale_quantity'] * $price ; 
					
					$DeliveryOrderDesc['price'] = $price;
					$DeliveryOrderDesc['amount'] = $amount;
					
					$DeliveryOrderDescObj = new DeliveryOrderDesc();
					$DeliveryOrderDescObj->setData($DeliveryOrderDesc);
					$DeliveryOrderDescObj->insertData();
					
					$so_amount = $so_amount + $DeliveryOrderDesc['amount'] ;
				}
				
				$newData['so_amount'] = $so_amount ;
				$newData['modifiedAt'] = date("Y-m-d H:i:s");
				
				$DeliveryDescObj = new DeliveryDesc();
				$DeliveryDescObj->setData($newData);
				$DeliveryDescObj->insertData($row['id']);
					
				$this->actionraiseDeliverySlip($row['so_id']);
			}
			
			$deliveryDetailsObj=DeliveryDetails::model()->findByPk($_POST['delivery_id_'.$i]);
			$deliveryDetailsResponse = $deliveryDetailsObj->attributes;
			$this->actionraiseAllDeliverySlips($deliveryDetailsResponse);
			$this->actionraiseDeliveryReport($deliveryDetailsResponse);
			$this->actionraiseCollectionReport($deliveryDetailsResponse);
		}
		//$this->render("deliveryListReport",array('title'=>$title));
		$this->redirect(array("admin/generateDeliveryReport"));
		exit;	
	}
	
	
	
	function actionraiseSalesOrder($id)
	{
		$SoDescObj = new SoDesc();
		$soData = $SoDescObj->getSoDescDetails($id);
		
		$admin_id = Yii::app()->session['farmsourcing_adminUser'];
		
		$adminObj=Admin::model()->findByPk($admin_id);
		
		$companyDetailsObj	=	new CompanyDetails();
		$adminDetails = $companyDetailsObj->getCompanyDetailsByAdminId($admin_id);
		
		$url = Yii::app()->params->base_url."timthumb/timthumb.php?src=".Yii::app()->params->base_url."assets/upload/clientLogo/".$adminDetails['company_logo']."&h=100&w=150&q=60&zc=0" ;
		
		//$url = Yii::app()->params->base_url."timthumb/timthumb.php?src=".Yii::app()->params->base_url."assets/upload/clientLogo/".$adminObj->company_logo."&h=100&w=150&q=60&zc=0" ;

		$soDetailsObj  = new SoDetails();
		$so_detail = $soDetailsObj->getsalesOrderData($id);
		
		
		if($so_detail['customer_name'] != "")
		{
			$customer = 'CUSTOMER: '.$so_detail['customer_name'] ;
			$to = 'TO,'	;
		}
		
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
		<div style="border:2px solid; padding:10px 10px 10px 10px;">
		<table width="100%" border="0" cellspacing="0" cellpadding="5">
		  <tr>
		  <td align="left"><img src="'.$url.'" /><br/><b>www.freshnpack.com</b></td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  </tr>
		  <tr>
			<td colspan="3" align="center">402, 4th floor, Optionz Complex, Opp. Nest Hotel, Off C.G.Road, Navrangpura, Ahmedabad 380009.<br/> Phone : 079 26401101/02/03, URL: www.freshnpack.com</td>
		  </tr>
          </table>
          
         <table width="60%"  height="100px;" style="border:1px solid black; float:left;" cellspacing="0" cellpadding="5">
            <tr>
                <td align="left" width="25%">Name of the customer :</td>
                <td align="left" width="75%">'.$customer.'</td>
            </tr>
            <tr>
                <td align="left" width="25%">Customer Code No. :</td>
                <td align="left" width="75%">'.$so_detail['customer_id'].'</td>
            </tr>
		</table>
        
        <table width="39%" height="100px;" style="border:1px solid black; float:left; margin-left:1%;" cellspacing="0" cellpadding="5">
		  	<tr>
                <td align="left" width="32%">Sales Order No :</td>
                <td align="left" width="68%">'. $id.'</td>
            </tr>
            <tr>
                <td align="left" width="5%">Date :</td>
                <td align="left" width="95%">'. date('F d, Y',strtotime($so_detail['order_date'])).'</td>
            </tr>
       </table>
       
		<p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p>
        
        <table width="100%"  border="1px" cellpadding="5"  cellspacing="0">
            <tr align="center" valign="middle">
                <td align="center" width="5%"><strong>ITEM CODE</strong></td>
                <td align="center" width="50%"><strong>ITEM NAME</strong></td>
                <td align="center" width="10%"><strong>QTY</strong></td>
                <td align="center" width="10%"><strong>RATE</strong></td>
                <td align="center" width="10%"><strong>AMOUNT</strong></td>
            </tr>';
			 $i=1;
		 // $finalAmount = 0 ;
	foreach($soData as $row) {
		//$finalAmount = $finalAmount + $row['amount'] ;
		$html .=  '<tr>
			<td align="center">&nbsp;'.$i.'</td>
			<td align="left" height="20">&nbsp;'.$row['product_name'].'</td>
			<td align="right">'.$row['quantity'].'&nbsp;</td>
			<td align="right">&nbsp;'.$row['price'].'</td>
			<td align="right">&nbsp;'.$row['total_price'].'</td>
		  </tr>';
   $i++; } 
		$html .= '<tr>
						<td align="center">&nbsp;'.$row['product_id'].'</td>
						<td align="left" height="20">&nbsp;'.$row['product_name'].'</td>
						<td align="right">'.$row['quantity'].'&nbsp;</td>
						<td align="right">&nbsp;'.$row['price'].'</td>
						<td align="right">&nbsp;'.$row['total_price'].'</td>
					</tr>';
		$html .= '<tr>
					<td align="right" colspan="4">TOTAL('.Yii::app()->session['currency'].')</td>
					<td align="right">&nbsp;'.$so_detail['total_amount'].'</td>
				</tr>		
       </table>
       <div>
          <p style="margin-left:5px;">Subject to Ahmedabad Jurisdiction &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; E.&amp; O.E.</p>
          <p style="margin-left:5px;" align="right";>For Fresh N Pack System</p>
        </div>
        
        <table width="100%" border="0" cellspacing="0" cellpadding="5">
            <tr>
                <td align="center">Shop Add: 23,24 Ground floor, Management enclave, Opp. Indraprastha bung. Vastrapur - Mansi road, Vastrapur 380015.<br/> Phone :079-40053900 / 079-40056900/td>
            </tr>
        </table>
          
        </div></body>
		</html>';
		
		$mpdf = new mPDF();
		$mpdf->WriteHTML($html);
		$mpdf->Output(FILE_PATH."assets/upload/salesOrder/salesOrder_".$id."_".$admin_id.".pdf", 'F');
		?>
        <script>
		window.open("<?php echo Yii::app()->params->base_url;?>assets/upload/salesOrder/salesOrder_<?php echo $id;?>_<?php echo $admin_id;?>.pdf",'_blank');
		</script>
        
		<?php
		ob_flush();
		ob_clean();
		
		//$this->redirect(Yii::app()->params->base_url."user");
	}
	
	function actionraiseDeliverySlipOld($id)
	{
		//error_reporting(E_ALL);
		
		$deliveryOrderDescObj = new DeliveryOrderDesc();
		$deliveryData = $deliveryOrderDescObj->getDeliveryDescDetails($id);
		
		$admin_id = Yii::app()->session['farmsourcing_adminUser'];
		
		$adminObj=Admin::model()->findByPk($admin_id);
		
		$companyDetailsObj	=	new CompanyDetails();
		$adminDetails = $companyDetailsObj->getCompanyDetailsByAdminId($admin_id);
		
		$url = Yii::app()->params->base_url."timthumb/timthumb.php?src=".Yii::app()->params->base_url."assets/upload/clientLogo/".$adminDetails['company_logo']."&h=100&w=150&q=60&zc=0" ;
		
		//$url = Yii::app()->params->base_url."timthumb/timthumb.php?src=".Yii::app()->params->base_url."assets/upload/clientLogo/".$adminObj->company_logo."&h=100&w=150&q=60&zc=0" ;

		$deliveryDetailsObj  = new DeliveryDesc();
		$delivery_detail = $deliveryDetailsObj->getDeliveryOrderData($id);
		
		if($delivery_detail['customer_name'] != "")
		{
			$customer = $delivery_detail['customer_name']." - ".$delivery_detail['representativeId']."" ;
			$to = 'TO,CUSTOMER: '	;
		}
		
		if($delivery_detail['cust_address'] != "")
		{
			$customer_address = ''.$delivery_detail['cust_address'] ;
		}
		
		if($delivery_detail['type'] == "0")
		{
			$orderType = 'Web' ;
		}else{
			$orderType = 'Mobile' ;
		}
		
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
		<table width="100%" border="0" cellspacing="0" cellpadding="5">
		  <tr>
		  <td align="left"><img src="'.$url.'" /></td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  </tr>
		  <tr>
			<td width="48%" rowspan="2"><b>'.$adminDetails['company_name'].'</b></br><p>'.$adminDetails['company_address'].'</p></td>
			<td width="23%" colspan="2" align="right" style="margin-right:20px;"><h1> <font color="#808080">DELIVERY SLIP</h1></td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td align="left">SALES ORDER: '. $id.'<br /></td>
			<td>&nbsp;</td>
			<td align="right">ORDER TYPE: '.$orderType.'<br /></td>
		  </tr>
		  <tr>
			<td align="left">DELIVERY DATE: '. date('F d, Y',strtotime($delivery_detail['delivery_date'])).'</td>
			<td>&nbsp;</td>
			<td align="right">&nbsp;</td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
			<td align="right" colspan="2">&nbsp;</td>
		  </tr>
		  <tr>
			<td>'.$to.'</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td align="left" ><b>'.$customer.'</b></td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td align="left" >ADDRESS:</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td align="left" ><b>'.$customer_address.'</b></td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		</table>
		<p>&nbsp;</p>
		
		<table width="100%" border="1" cellpadding="5"  cellspacing="0">
		  <tr align="center" valign="middle">
		 	<td align="center" width="5%"><strong>NO</strong></td>
			<td align="center" width="50%"><strong>NAME</strong></td>
			<td align="center" width="10%"><strong>ORDER QTY</strong></td>
			<td align="center" width="10%"><strong>SALE QTY</strong></td>
			<td align="center" width="10%"><strong>PRICE</strong></td>
			<td align="center" width="10%"><strong>TOTAL</strong></td>
		  </tr>';
		  $i=1;
		  $finalAmount = 0 ;
		
		foreach($deliveryData as $row) {
		$finalAmount = $finalAmount + $row['amount'] ;
		$html .=  '<tr>
			<td align="center">&nbsp;'.$i.'</td>
			<td align="left" height="20">&nbsp;'.$row['product_name'].'</td>
			<td align="right">'.$row['so_quantity'].'&nbsp;</td>
			<td align="right">'.$row['sale_quantity'].'&nbsp;</td>
			<td align="right">&nbsp;'.$row['price'].'</td>
			<td align="right">&nbsp;'.$row['amount'].'</td>
		  </tr>';
   $i++; } 
		$html .= '</table>
		<table width="100%" border="1" cellpadding="5"  cellspacing="0" class="noborder1">
		  <!--<tr>
			<td colspan="4" align="right" class="noborder"></td>
			<td width="10%">&nbsp;</td>
		  </tr>-->
		  <tr >
			<td colspan="4" align="right" class="noborder1">TOTAL('.Yii::app()->session['currency'].')</td>
			<td width="12%" align="right">&nbsp;<b>'.$finalAmount.'</b></td>
		  </tr>
		</table>
		
		</body>
		</html>';
		
		//echo $html; exit;
		
		$mpdf = new mPDF();
		$mpdf->WriteHTML($html);
		$mpdf->Output(FILE_PATH."assets/upload/deliverySlip/deliverySlip_".$id."_".$admin_id.".pdf", 'F');
		
		return true;
		//$this->redirect(Yii::app()->params->base_url."user");
	}
	
	
	
	function actionraiseAllDeliverySlips($post)
	{
		//error_reporting(E_ALL);
			
		$deliveryDetailsObj = new DeliveryDetails();
		$deliveryListData = $deliveryDetailsObj->getDeliveryListForPdf($post['delivery_date'],$post['driver_id']);
		
		$admin_id = Yii::app()->session['farmsourcing_adminUser'];
		
		$adminObj=Admin::model()->findByPk($post['driver_id']);
		
		$adminData = $adminObj->attributes;
		
		$companyObj = new CompanyDetails();
		$companyData = $companyObj->getCompanyDetailsByAdminId($admin_id);
		
		
		$url = Yii::app()->params->base_url."timthumb/timthumb.php?src=".Yii::app()->params->base_url."assets/upload/clientLogo/".$companyData['company_logo']."&h=100&w=100&q=60&zc=0" ;
		
		$urlLogo = Yii::app()->params->base_url."timthumb/timthumb.php?src=".Yii::app()->params->base_url."images/logo/farmsource_logo.png&h=100&w=250&q=60&zc=0" ;
		
		//$mpdf = new mPDF('','A5');
		$mpdf = new mPDF('','A5',$default_font_size=0,$default_font='',$mgl=0,$mgr=0,$mgt=0,$mgb=0,$mgh=0,$mgf=0, $orientation='P');
		$i=0;
		
		foreach($deliveryListData as $row1)
		{
		
		$id = $row1['so_id'];
		$deliveryOrderDescObj = new DeliveryOrderDesc();
		$deliveryData = $deliveryOrderDescObj->getDeliveryDescDetails($id);
		
		

		$deliveryDetailsObj  = new DeliveryDesc();
		$delivery_detail = $deliveryDetailsObj->getDeliveryOrderData($id);
		
		if($delivery_detail['customer_name'] != "")
		{
			$customer = $delivery_detail['customer_name'] ;
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
		
		
		if($delivery_detail['customer_id'] != "")
		{
			$deliveryDescObj = new DeliveryDesc();
			$creditData = $deliveryDescObj->getCustomerRemainingAmountOfAllOrder($delivery_detail['customer_id']);
			
			//echo "<pre>";
			//print_r($creditData);
			$SoDetailsObj = new SoDetails();
			$total_credit_amount_by_customer_id = $SoDetailsObj->getSumOfCreditByCustomerId($delivery_detail['customer_id']);
			
			
			if(!empty($creditData))
			{
				$totalRemainingCredit = $creditData['totalAmount'] - ( $creditData['totalCash'] + $creditData['totalCoupon'] + $total_credit_amount_by_customer_id ) ;
			}else{
				$totalRemainingCredit = 0 ;
			}
		}
		
		if($delivery_detail['type'] == "0")
		{
			$orderType = 'Web' ;
		}else{
			$orderType = 'Mobile' ;
		}
		
		if(Yii::app()->session['currency'] == "INR")
		{
			$currency = 'Rs.' ;
		}else{
			$currency = Yii::app()->session['currency'] ;
		}
		
		if($i!=0)
		{
			$mpdf->WriteHTML('<pagebreak />');
		}
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
		<div style="border:2px solid; padding:10px 10px 10px 10px;">
		<table width="100%" border="0" cellspacing="0" cellpadding="2">
		  <tr>
		  <td align="left" width="33%"><img src="'.$url.'" /><br/><b>www.freshnpack.com</b></td>
		  <td width="33%"><img src="'.$urlLogo.'" /></td>
		   <td  align="right" width="33%"><span>Customer Care No.</span><br/><b style="font-size:14px;">079-40053900 / 079-40056900</b></td>
		  </tr>
		  <tr>
			<td colspan="3" align="center">Shop Address: 23,24 Ground floor, Management enclave, Opp. Indraprastha bung. Vastrapur - Mansi road, Vastrapur 380015. <br/> Phone : 079-40053900 / 079-40056900</td>
		  </tr>
          </table>
          
         <table width="100%" style="border:1px solid black;" cellspacing="0" cellpadding="2">
            <tr>
                <td align="left" rowspan="2"  width="20%">Customer :</td>
                <td align="left" rowspan="2"   >'.$customer.'</td>
				<td align="left"  width="25%" style = "border-left:1px solid black;" >Invoice No.:</td>
                <td align="left" >'.$delivery_detail['id'].'</td>
            </tr>
			<tr>
                <td align="left" style = "border-left:1px solid black;">Invoice Date :</td>
                <td align="left">'. date('d-m-Y',strtotime($delivery_detail['delivery_date'])).'</td>
            </tr>
           <tr>
                <td align="left" rowspan="2"  >Customer No. :</td>
                <td align="left" rowspan="2"  >'.$delivery_detail['representativeId'].'</td>
				<td align="left" style = "border-left:1px solid black;">SO No:</td>
                <td align="left">'.$id.'</td>
            </tr>
			<tr>
                <td align="left" style = "border-left:1px solid black;">SO Date :</td>
                <td align="left">'. date('d-m-Y',strtotime($delivery_detail['order_date'])).'</td>
            </tr>
           
       </table>
       
		
        
        <table width="100%"  border="1" cellpadding="2"  cellspacing="0" style="margin-top:5px;">
            <tr align="center" valign="middle">
                <td align="center" width="5%"><strong>ITEM CODE</strong></td>
                <td align="center" width="50%"><strong>ITEM NAME</strong></td>
                <td align="center" width="10%"><strong>QTY</strong></td>
                <td align="center" width="10%"><strong>RATE</strong></td>
				<td align="center" width="10%"><strong>DISCOUNT</strong></td>
                <td align="center" width="10%"><strong>AMOUNT</strong></td>
            </tr>';
		  $i=1;
		  $finalAmount = 0 ;
		
		foreach($deliveryData as $row) {
		$finalAmount = $finalAmount + $row['amount'] ;
		
		/*if(isset($row['discount_desc']) && $row['discount_desc'] != "")
		{
			$discount_desc = '</br>- '.$row['discount_desc'] ;
		}else{
			$discount_desc = "";
		}*/
		
		$html .=  '<tr>
			<td align="center">&nbsp;'.$row['product_id'].'</td>
			<td align="left" height="20">&nbsp;'.$row['product_name'].'</td>
			<td align="right">'.$row['sale_quantity'].'&nbsp;</td>
			<td align="right">&nbsp;'.$row['actual_product_price'].'</td>
			<td align="right">&nbsp;'.$row['discount_amount'].'</td>
			<td align="right">&nbsp;'.$row['amount'].'</td>
		  </tr>';
   $i++; } 
		$html .= '<tr>
					<td align="left" colspan="4">&nbsp;&nbsp;</td>
					<td align="right">COUPON(-)</td>
					<td align="right">&nbsp;'.round($delivery_detail['coupon_amount'], 0).'</td>
				</tr>
		<tr>
					<td align="left" colspan="4" style="font-size:10px;">Subject to Ahmedabad Jurisdiction &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; E.&amp; O.E.</td>
					<td align="right">TOTAL('.$currency.')</td>
					<td align="right">&nbsp;'.(round($finalAmount, 0) - round($delivery_detail['coupon_amount'], 0)).'</td>
				</tr>
				
				  <tr>
					<td colspan="4">&nbsp;</td>
					<td align="right">TOTAL REMAINING CREDIT &nbsp;</td>
					<td align="right">'.round($totalRemainingCredit, 0).'</td>
				</tr>			
       </table>
        </div></body>
		</html>';
		//echo $html; exit;
		$mpdf->WriteHTML($html);
		$i++;
		}
		//echo $html; exit;
		
		$randomStr = date("Y_m_d",strtotime($post['delivery_date'])).'_'.$post['driver_id'];		
		
		//$mpdf->WriteHTML($html);
		$mpdf->Output(FILE_PATH."assets/upload/AlldeliverySlips/AlldeliverySlip_".$randomStr.".pdf", 'F');
		
		//$this->actionraiseCollectionReport($_POST);
		return true;
	}
	
	function actionraiseDeliverySlip($id)
	{
		//error_reporting(E_ALL);
		$deliveryOrderDescObj = new DeliveryOrderDesc();
		$deliveryData = $deliveryOrderDescObj->getDeliveryDescDetails($id);
		
		$admin_id = Yii::app()->session['farmsourcing_adminUser'];
		
		$adminObj=Admin::model()->findByPk($admin_id);
		
		$companyDetailsObj	=	new CompanyDetails();
		$adminDetails = $companyDetailsObj->getCompanyDetailsByAdminId($admin_id);
		
		$url = Yii::app()->params->base_url."timthumb/timthumb.php?src=".Yii::app()->params->base_url."assets/upload/clientLogo/".$adminDetails['company_logo']."&h=100&w=100&q=60&zc=0" ;
		
		$urlLogo = Yii::app()->params->base_url."timthumb/timthumb.php?src=".Yii::app()->params->base_url."images/logo/farmsource_logo.png&h=100&w=200&q=60&zc=0" ;
		
		//$url = Yii::app()->params->base_url."timthumb/timthumb.php?src=".Yii::app()->params->base_url."assets/upload/clientLogo/".$adminObj->company_logo."&h=100&w=150&q=60&zc=0" ;

		$deliveryDetailsObj  = new DeliveryDesc();
		$delivery_detail = $deliveryDetailsObj->getDeliveryOrderData($id);
		
		if($delivery_detail['customer_name'] != "")
		{
			$customer = $delivery_detail['customer_name'];
			$to = 'TO,CUSTOMER: '	;
		}
		else
		{
			$customer = 'Cash Sale';	
		}
		
		
		if($delivery_detail['customer_id'] != "")
		{
			$deliveryDescObj = new DeliveryDesc();
			$creditData = $deliveryDescObj->getCustomerRemainingAmountOfAllOrder($delivery_detail['customer_id']);
			
			$SoDetailsObj = new SoDetails();
			$total_credit_amount_by_customer_id = $SoDetailsObj->getSumOfCreditByCustomerId($delivery_detail['customer_id']);
			
			//echo "<pre>";
			//print_r($creditData);
			
			if(!empty($creditData))
			{
				$totalRemainingCredit = $creditData['totalAmount'] - ( $creditData['totalCash'] + $creditData['totalCoupon'] + $total_credit_amount_by_customer_id ) ;
			}else{
				$totalRemainingCredit = 0 ;
			}
		}
		
		if($delivery_detail['cust_address'] != "")
		{
			$customer_address = ''.$delivery_detail['cust_address'] ;
		}
		
		if(Yii::app()->session['currency'] == "INR")
		{
			$currency = 'Rs.' ;
		}else{
			$currency = Yii::app()->session['currency'] ;
		}
		
		if($delivery_detail['type'] == "0")
		{
			$orderType = 'Web' ;
		}else{
			$orderType = 'Mobile' ;
		}
		
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
		<div style="border:2px solid; padding:10px 10px 10px 10px;">
		<table width="100%" border="0" cellspacing="0" cellpadding="2">
		  <tr>
		  <td align="left" width="33%"><img src="'.$url.'" /><br/><b>www.freshnpack.com</b></td>
		  <td width="33%"><img src="'.$urlLogo.'" /></td>
		   <td  align="right" width="33%"><span>Customer Care No.</span><br/><b style="font-size:14px;">079-40053900 / 079-40056900</b></td>
		  </tr>
		  <tr>
			<td colspan="3" align="center">Shop Address: 23,24 Ground floor, Management enclave, Opp. Indraprastha bung. Vastrapur - Mansi road, Vastrapur 380015. <br/> Phone : 079-40053900 / 079-40056900</td>
		  </tr>
          </table>
          
         <table width="100%" style="border:1px solid black;" cellspacing="0" cellpadding="2">
            <tr>
                <td align="left" rowspan="2"  width="20%">Customer :</td>
                <td align="left" rowspan="2"   >'.$customer.'</td>
				<td align="left"  width="25%" style = "border-left:1px solid black;" >Invoice No.:</td>
                <td align="left" >'.$delivery_detail['id'].'</td>
            </tr>
			<tr>
                <td align="left" style = "border-left:1px solid black;">Invoice Date :</td>
                <td align="left">'. date('d-m-Y',strtotime($delivery_detail['delivery_date'])).'</td>
            </tr>
           <tr>
                <td align="left" rowspan="2"  >Customer No. :</td>
                <td align="left" rowspan="2"  >'.$delivery_detail['representativeId'].'</td>
				<td align="left" style = "border-left:1px solid black;">SO No:</td>
                <td align="left">'.$id.'</td>
            </tr>
			<tr>
                <td align="left" style = "border-left:1px solid black;">SO Date :</td>
                <td align="left">'. date('d-m-Y',strtotime($delivery_detail['order_date'])).'</td>
            </tr>
           
       </table>
       
		
        <table width="100%"  border="1" cellpadding="2"  cellspacing="0" style="margin-top:5px;">
            <tr align="center" valign="middle">
                <td align="center" width="5%"><strong>ITEM CODE</strong></td>
                <td align="center" width="50%"><strong>ITEM NAME</strong></td>
                <td align="center" width="10%"><strong>QTY</strong></td>
                <td align="center" width="10%"><strong>RATE</strong></td>
				<td align="center" width="10%"><strong>DISCOUNT</strong></td>
                <td align="center" width="10%"><strong>AMOUNT</strong></td>
            </tr>';
		  $i=1;
		  $finalAmount = 0 ;
		
		foreach($deliveryData as $row) {
		$finalAmount = $finalAmount + $row['amount'] ;
		
		/*if(isset($row['discount_desc']) && $row['discount_desc'] != "")
		{
			$discount_desc = '</br>- '.$row['discount_desc'] ;
		}else{
			$discount_desc = "";
		}
		*/
		$html .=  '<tr>
			<td align="center">&nbsp;'.$row['product_id'].'</td>
			<td align="left" height="20">&nbsp;'.$row['product_name'].'</td>
			<td align="right">'.$row['sale_quantity'].'&nbsp;</td>
			<td align="right">&nbsp;'.$row['actual_product_price'].'</td>
			<td align="right">&nbsp;'.$row['discount_amount'] * $row['sale_quantity'].'</td>
			<td align="right">&nbsp;'.$row['amount'].'</td>
		  </tr>';
   $i++; } 
		$html .= '<tr>
					<td align="left" colspan="4">&nbsp;&nbsp;</td>
					<td align="right">COUPON(-)</td>
					<td align="right">&nbsp;'.round($delivery_detail['coupon_amount'], 0).'</td>
				</tr>
				
		<tr>
					<td align="left" colspan="4" style="font-size:10px;">Subject to Ahmedabad Jurisdiction &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; E.&amp; O.E.</td>
					<td align="right">TOTAL('.$currency.')</td>
					<td align="right">&nbsp;'.(round($finalAmount, 0) - round($delivery_detail['coupon_amount'], 0)).'</td>
				</tr>	
				
				  <tr>
					<td colspan="4">&nbsp;</td>
					<td align="right">TOTAL REMAINING CREDIT &nbsp;</td>
					<td align="right">'.round($totalRemainingCredit, 0).'</td>
				</tr>	
       </table>
        </div></body>
		</html>';
		
		//echo $html; exit;
		//$mpdf=new mPDF('c','A5'); 
		//$mpdf = new mPDF('','A5');
		$mpdf = new mPDF('','A5',$default_font_size=0,$default_font='',$mgl=0,$mgr=0,$mgt=0,$mgb=0,$mgh=0,$mgf=0, $orientation='P');
		//$mpdf->SetDisplayMode('fullpage');
		$mpdf->WriteHTML($html);
		$mpdf->Output(FILE_PATH."assets/upload/deliverySlip/deliverySlip_".$id."_".$admin_id.".pdf", 'F');
		
		return true;
		//$this->redirect(Yii::app()->params->base_url."user");
	}
	
	function actiondeliveryListing()
	{
		$this->isLogin();
		if(!isset($_REQUEST['delivery_date']))
		{
			$_REQUEST['delivery_date'] = '';
		}
		if(!isset($_REQUEST['driver_id']))
		{
			$_REQUEST['driver_id'] = '';
		}

		
		$deliveryDetailsObj = new DeliveryDetails();
		$deliveryList = $deliveryDetailsObj->getDeliveryList($_REQUEST['delivery_date'],$_REQUEST['driver_id']);
		
		/*echo "<pre>";
		print_r($deliveryList);
		exit;*/
		
		$data['deliveryList']	=	$deliveryList;
		Yii::app()->session['current'] = "Delivery Slips";
		$this->render("deliveryListReport", array('data'=>$data,'driver_id'=>$_REQUEST['driver_id'],'delivery_date'=>$_REQUEST['delivery_date']));
	}
	
	function actionpoGenerate()
	{
		$this->isLogin();
		$_POST['delivery_date'] = date("d-m-Y", time() + 86400);

		$title = "PO Generation";
		Yii::app()->session['current'] = "PO Generation";
		
		/*$soDescObj =  new SoDesc();
		$poData = $soDescObj->getProductsForPO($_POST['delivery_date']);*/
		
		$productObj = new Product();
		$poData = $productObj->getAllProducts();
		
		if(!empty($poData))
		{
			$poDetailObj = new PoDetails();
			$poDetailObjData = $poDetailObj->getPoDataByDeliveryDate($_POST['delivery_date']);
			
			if(empty($poDetailObjData))
			{
				Yii::app()->session['current'] = "PO Generation";
				$deliveryDate = $_POST['delivery_date'] ;
				$this->render("poGenerate",array('title'=>$title,'poData'=>$poData,'deliveryDate'=>$deliveryDate));
			}else{
				Yii::app()->user->setFlash('error',"Already generated purchase order for this delivery date.");
				Yii::app()->session['current'] = "PO Generation";
				$this->redirect(array("admin/purchaseOrderListing"));
			}
		}else{
			Yii::app()->user->setFlash('error',"There is no sales order available for tommorow deliveryDate.");
			Yii::app()->session['current'] = "PO Generation";
			$this->redirect(array("admin/purchaseOrderListing"));	
		}
	}
	
	function actionsavePoOrder()
	{
		
		$data = array();
		$vendor = array();
		$PoDetails = array();
		$po_id = array();
		
		
		for($i=1;$i<=$_POST['count'];$i++)
		{
			$key = array_search($_POST['vendor_id_'.$i],$vendor);
			if(empty($key))
			{
				
				$data[$i]['product_name'] = $_POST['product_name_'.$i];
				$data[$i]['totalquantity'] = $_POST['totalquantity_'.$i];
				$data[$i]['inventoryquantity'] = $_POST['inventoryquantity_'.$i];
				$data[$i]['safetyMargin'] = $_POST['safetyMargin_'.$i];
				$data[$i]['calculatedquantity'] = $_POST['calculatedquantity_'.$i];
				$data[$i]['poquantity'] = $_POST['poquantity_'.$i];
				$data[$i]['price'] = $_POST['price_'.$i];
				$data[$i]['amount'] = $_POST['amount_'.$i];
				$data[$i]['vendor_id'] = $_POST['vendor_id_'.$i];
			
			
				$PoDetails[$i]['vendor_id']  = $_POST['vendor_id_'.$i];
				$PoDetails[$i]['total_amount'] = $_POST['poquantity_'.$i] * $_POST['price_'.$i];
				$PoDetails[$i]['admin_id'] = Yii::app()->session['farmsourcing_adminUser'];
				$PoDetails[$i]['status'] = 0;
				$PoDetails[$i]['delivery_date'] =  date("Y-m-d",strtotime($_POST['delivery_date']));
				$PoDetails[$i]['createdAt'] = date("Y-m-d H:i:s");
				$PoDetails[$i]['modifiedAt'] = date("Y-m-d H:i:s");
			
				
				$vendor[$i] =  $_POST['vendor_id_'.$i];
				$poDetailsObj =  new PoDetails();
				$poDetailsObj->setData($PoDetails[$i]);
				$po_id[$i] = $poDetailsObj->insertData();
			
			
				if(!empty($_POST['poquantity_'.$i]) 
						&& $_POST['poquantity_'.$i] != "" 
						&& $_POST['poquantity_'.$i] != 0)
				{
					$PoDesc[$i]['po_id']  = $po_id[$i];
					$PoDesc[$i]['product_id'] = $_POST['product_id_'.$i];
					$PoDesc[$i]['admin_id'] = Yii::app()->session['farmsourcing_adminUser'];
					$PoDesc[$i]['quantity'] = $_POST['poquantity_'.$i];
					$PoDesc[$i]['received_quantity'] = 0;
					$PoDesc[$i]['accepted_quantity'] = 0;
					$PoDesc[$i]['price'] =  $_POST['price_'.$i];
					$PoDesc[$i]['amount'] = $_POST['amount_'.$i];
					$PoDesc[$i]['createdAt'] = date("Y-m-d H:i:s");
					$PoDesc[$i]['modifiedAt'] = date("Y-m-d H:i:s");
					
					$poDescObj =  new PoDesc();	
					$poDescObj->setData($PoDesc[$i]);
					$podesc_id = $poDescObj->insertData();	
				}
				
			}
			else
			{
				//$poDetailsObj =  new PoDetails();
				$poAllData = PoDetails::model()->findByPk($po_id[$key]);
				
				$totalAmount['total_amount'] =$poAllData->total_amount + ($_POST['poquantity_'.$i] * $_POST['price_'.$i]) ;
				
					
				$poDetailsObj =  new PoDetails();
				$poDetailsObj->setData($totalAmount);
				$po_id[$i] = $poDetailsObj->insertData($po_id[$key]);
				
				if(!empty($_POST['poquantity_'.$i]) 
						&& $_POST['poquantity_'.$i] != "" 
						&& $_POST['poquantity_'.$i] != 0)
				{
					$PoDesc[$i]['po_id']  = $po_id[$key];
					$PoDesc[$i]['product_id'] = $_POST['product_id_'.$i];
					$PoDesc[$i]['admin_id'] = Yii::app()->session['farmsourcing_adminUser'];
					$PoDesc[$i]['quantity'] = $_POST['poquantity_'.$i];
					$PoDesc[$i]['received_quantity'] = 0;
					$PoDesc[$i]['accepted_quantity'] = 0;
					$PoDesc[$i]['price'] =  $_POST['price_'.$i];
					$PoDesc[$i]['amount'] = $_POST['amount_'.$i];
					$PoDesc[$i]['createdAt'] = date("Y-m-d H:i:s");
					$PoDesc[$i]['modifiedAt'] = date("Y-m-d H:i:s");
					
					$poDescObj =  new PoDesc();	
					$poDescObj->setData($PoDesc[$i]);
					$podesc_id = $poDescObj->insertData();	
				}
				
			}
		}
		foreach($po_id as $row)
		{
			if(!empty($row)){
				$this->actionraisePurchaseOrder($row);
			}
		}
		
		$delivery_date =  date("Y-m-d",strtotime($_POST['delivery_date']));
		/*$soDetailsObj =  new SoDetails();
		$soDetailsObj->updateSalesOrderPOStatus($delivery_date);*/
		
		Yii::app()->user->setFlash('success',"Purchase order generated successfully.");
		$this->redirect(array("admin/purchaseOrderListing"));
	}
	
	function actionsaveCustomPoOrder()
	{
		$data = array();
		$vendor = array();
		$PoDetails = array();
		$po_id = array();
		
		/*print "<pre>";
		print_r($_POST);
		exit;*/
		
		for($i=1;$i<=$_POST['count'];$i++)
		{
			$key = array_search($_POST['vendor_id_'.$i],$vendor);
			
			if(empty($key))
			{
				$PoDetails[$i]['vendor_id']  = $_POST['vendor_id_'.$i];
				$PoDetails[$i]['total_amount'] = $_POST['amount_'.$i];
				$PoDetails[$i]['admin_id'] = Yii::app()->session['farmsourcing_adminUser'];
				$PoDetails[$i]['status'] = 0;
				$PoDetails[$i]['delivery_date'] =  date("Y-m-d",strtotime($_POST['delivery_date']));
				$PoDetails[$i]['createdAt'] = date("Y-m-d H:i:s");
				$PoDetails[$i]['modifiedAt'] = date("Y-m-d H:i:s");
			
				if($PoDetails[$i]['total_amount'] !=  "")
				{
					$vendor[$i] =  $_POST['vendor_id_'.$i];
					$poDetailsObj =  new PoDetails();
					$poDetailsObj->setData($PoDetails[$i]);
					$po_id[$i] = $poDetailsObj->insertData();
				
				
					if(!empty($_POST['poquantity_'.$i]) 
							&& $_POST['poquantity_'.$i] != "" 
							&& $_POST['poquantity_'.$i] != 0)
					{
						$PoDesc[$i]['po_id']  = $po_id[$i];
						$PoDesc[$i]['product_id'] = $_POST['product_id_'.$i];
						$PoDesc[$i]['admin_id'] = Yii::app()->session['farmsourcing_adminUser'];
						$PoDesc[$i]['quantity'] = $_POST['poquantity_'.$i];
						$PoDesc[$i]['received_quantity'] = 0;
						$PoDesc[$i]['accepted_quantity'] = 0;
						$PoDesc[$i]['price'] =  $_POST['price_'.$i];
						$PoDesc[$i]['amount'] = $_POST['amount_'.$i];
						$PoDesc[$i]['createdAt'] = date("Y-m-d H:i:s");
						$PoDesc[$i]['modifiedAt'] = date("Y-m-d H:i:s");
						
						$poDescObj =  new PoDesc();	
						$poDescObj->setData($PoDesc[$i]);
						$podesc_id = $poDescObj->insertData();	
					}
				
				}
			}
			else
			{
				//$poDetailsObj =  new PoDetails();
				
				$poAllData = PoDetails::model()->findByPk($po_id[$key]);
				
				$totalAmount['total_amount'] =$poAllData->total_amount + ($_POST['poquantity_'.$i] * $_POST['price_'.$i]) ;
				$poDetailsObj =  new PoDetails();
				$poDetailsObj->setData($totalAmount);
				$po_id[$i] = $poDetailsObj->insertData($po_id[$key]);
				
				
				
				if(!empty($_POST['poquantity_'.$i]) 
						&& $_POST['poquantity_'.$i] != "" 
						&& $_POST['poquantity_'.$i] != 0)
				{
					
					$PoDesc[$i]['po_id']  = $po_id[$key];
					$PoDesc[$i]['product_id'] = $_POST['product_id_'.$i];
					$PoDesc[$i]['admin_id'] = Yii::app()->session['farmsourcing_adminUser'];
					$PoDesc[$i]['quantity'] = $_POST['poquantity_'.$i];
					$PoDesc[$i]['received_quantity'] = 0;
					$PoDesc[$i]['accepted_quantity'] = 0;
					$PoDesc[$i]['price'] =  $_POST['price_'.$i];
					$PoDesc[$i]['amount'] = $_POST['amount_'.$i];
					$PoDesc[$i]['createdAt'] = date("Y-m-d H:i:s");
					$PoDesc[$i]['modifiedAt'] = date("Y-m-d H:i:s");
					
					$poDescObj =  new PoDesc();	
					$poDescObj->setData($PoDesc[$i]);
					$podesc_id = $poDescObj->insertData();	
				}
				
			}
		}
		foreach($po_id as $row)
		{
			if(!empty($row)){
				$this->actionraisePurchaseOrder($row);
			}
		}
		
		//exit;
		Yii::app()->user->setFlash('success',"Purchase order generated successfully.");
		$this->redirect(array("admin/purchaseOrderListing"));
	}
	
	function actioncustomPoGenerate()
	{
		$this->isLogin();
		$title = "PO Generation";
		Yii::app()->session['current'] = "PO Generation";

		$this->render("customPoGenerate",array('title'=>$title));
	}
	
	function actiongoodsReciept()
	{
		$title = "Goods Receipt";
		Yii::app()->session['current'] = "Goods Receipt";
		$poDetailsObj =  new PoDetails();
		$poData = $poDetailsObj->getAllPendingPO();
		
		Yii::app()->session['current'] = "GRN";
		$this->render("goodsReceipt",array('title'=>$title,'poData'=>$poData));
	}

	function actionpurchaseOrderListing()
	{
		$this->isLogin();
		$PoDetailsObj = new PoDetails();
		$poList = $PoDetailsObj->getpurchaseOrderListing();
		
		/*echo "<pre>";
		print_r($poList);
		exit;*/
		
		$data['poList']	=	$poList;
		Yii::app()->session['current'] = "PO Generation";
		$this->render("poListing", array('data'=>$data));
	}
	
	function actionshowPoDetail()
	{
		if($_REQUEST['id'] == "")
		{
			echo 0;
			exit;	
		}
		else
		{
			$this->isLogin();
			
			$PoDetailsObj = new PoDetails();
			$PoDetailsData = $PoDetailsObj->getpurchaseOrderDataById($_REQUEST['id']);
			
			$poDescObj = new PoDesc();
			$poDescData = $poDescObj->getPoDescDetails($_REQUEST['id']);
			
			/*echo "<pre>";
			print_r($PoDetailsData);
			print_r($poDescData);
			exit;*/
			
			if(!empty($poDescData))
			{
				$this->renderPartial("purchaseOrderDetails",array("poDescData"=>$poDescData,"PoDetailsData"=>$PoDetailsData));
				exit;
			}
			else
			{
				echo 0;
				exit;
			}
		}
	}

	function actiongetGoodsRecieptData()
	{
		$title = "Goods Receipt";
		Yii::app()->session['current'] = "Goods Receipt";
		
		$poDetailsObj =  new PoDetails();
		$poData = $poDetailsObj->getAllPendingPO();
		
		$poDetailsObj =  new PoDetails();
		$poDetailsData = $poDetailsObj->getpurchaseOrderDataById($_REQUEST['po_id']);
		
		$poDescObj =  new PoDesc();
		$poDescData = $poDescObj->getGoodsDescData($_REQUEST['po_id']);
		
		Yii::app()->session['current'] = "GRN";
		$this->render("goodsReceipt",array('title'=>$title,'po_id'=>$_REQUEST['po_id'],'poDetailsData'=>$poDetailsData,'poData'=>$poData,'poDescData'=>$poDescData));
	}
	
	function actionsaveGoodsRecieptData()
	{
		if(!empty($_POST['po_id']) && $_POST['po_id'] != "")
		{
			$data['total_amount'] = $_POST['totalPurchase'];
			$data['modifiedAt'] = date("Y-m-d H:m:s");
			$data['status'] = 1 ;
			
			$PoDetailsObj = new PoDetails();
			$PoDetailsObj->setData($data);
			$PoDetailsObj->insertData($_POST['po_id']);
			
			for($i=1;$i<=$_POST['count'];$i++)
			{
				$podata['received_quantity'] = $_POST['received_quantity_'.$i];
				$podata['accepted_quantity'] = $_POST['acceptedQuantity_'.$i];
				$podata['price'] = $_POST['rate_'.$i];
				$podata['amount'] = $_POST['totalAmount_'.$i];
				$podata['modifiedAt'] =date("Y-m-d H:m:s");
				
				$PoDescObj = new PoDesc();
				$PoDescObj->setData($podata);
				$PoDescObj->insertData($_POST['id_'.$i]);
				
/*-------------------------------------Stock Update Start ----------------------------------------------*/
				$productObj = new Product();
				$productData = $productObj->getProductById($_POST['product_id_'.$i]);
				
				$profitPercentageObj = new ProfitPercentageMaster();
				$profit = $profitPercentageObj->getProductProfit($_POST['product_id_'.$i]);
				
				if($profit == ""  || empty($profit))
				{
					if($productData['profit_percentage'] != ""  || !empty($productData['profit_percentage']))
					{
						$profit = $productData['profit_percentage'];
					}else{
						$profit = 0;	
					}
					
				}
				
				$newAmount = $podata['amount'] / $podata['accepted_quantity'] ;
				
				$newProductPrice = $newAmount + ($newAmount * ($profit/100)) ;
				
				$product['quantity'] = $productData['quantity'] + $_POST['acceptedQuantity_'.$i] ;
				//$product['product_price'] = $newProductPrice ;
				$product['modified_date'] = date("Y-m-d H:i:s");
				
				$productObj = new Product();
				$productObj->setData($product);
				$productObj->insertData($productData['product_id']);
				
/*-------------------------------------Stock Update Finish ----------------------------------------------*/
				$rejectedQty = $_POST['received_quantity_'.$i] - $_POST['acceptedQuantity_'.$i];
				
				if($rejectedQty > 0)
				{
					$shrinkStock['product_id'] = $_POST['product_id_'.$i];
					$shrinkStock['admin_id'] = Yii::app()->session['farmsourcing_adminUser'];
					$shrinkStock['system_qnt']	= $_POST['received_quantity_'.$i];
					$shrinkStock['actual_qnt']	= $_POST['acceptedQuantity_'.$i];
					$shrinkStock['qnt_difference']	= $rejectedQty;
					$shrinkStock['createdAt'] = date("Y-m-d H:i:s");
					$shrinkStock['modifiedAt'] = date("Y-m-d H:i:s");
					
					$shrinkStockObj = new ShrinkQuantity();
					$shrinkStockObj->setData($shrinkStock);
					$shrinkStockObj->insertData();
				}
/*--------------------------------------Shrink Quantity Update Start ----------------------------------------*/
				

/*--------------------------------------Shrink Quantity Update End ----------------------------------------*/
			}
			
			$this->actionraiseGoodsReceipt($_POST['po_id']);
			
			Yii::app()->user->setFlash('success',"Goods reciept generated successfully.");
		}
		$this->redirect(array("admin/goodsReciept"));
	}
	
	function actionraiseGoodsReceipt($id)
	{
		$PoDescObj = new PoDesc();
		$purchaseData = $PoDescObj->getPoDescDetails($id);
		
		$admin_id = Yii::app()->session['farmsourcing_adminUser'];
		
		$adminObj=Admin::model()->findByPk($admin_id);
		
		$companyObj = new CompanyDetails();
		$companyData = $companyObj->getCompanyDetailsByAdminId($admin_id);
		
		$url = Yii::app()->params->base_url."timthumb/timthumb.php?src=".Yii::app()->params->base_url."assets/upload/clientLogo/".$companyData['company_logo']."&h=100&w=150&q=60&zc=0" ;

		
		$PoDetailsObj  = new PoDetails();
		$po_detail = $PoDetailsObj->getpurchaseOrderDataById($id);
		
		/*echo "<pre>";
		print_r($purchaseData);
		print_r($po_detail);
		exit;*/
		
		if($po_detail['vendor_name'] != "")
		{
			$supplier = 'VENDOR: '.$po_detail['vendor_name'] ;
			$to = 'TO,'	;
		}
		
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
		<table width="100%" border="0" cellspacing="0" cellpadding="5">
		  <tr>
		  <td align="left"><img src="'.$url.'" /></td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  </tr>
		  <tr>
			<td width="48%" rowspan="2"><b>'.$companyData['company_name'].'</b></td>
			<td width="29%">&nbsp;</td>
			<td width="23%" align="right" style="margin-right:20px;"><h1> <font color="#808080">GOODS RECEIPT</h1></td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td> [Street Address]</td>
			<td>&nbsp;</td>
			<td align="right">Goods Receipt: '. $id.'<br /></td>
		  </tr>
		  <tr>
			<td>[City, ST ZIP Code]</td>
			<td>&nbsp;</td>
			<td align="right">Received DATE: '. date('F d, Y',strtotime($po_detail['modifiedAt'])).'</td>
		  </tr>
		  <tr>
			<td>Phone [509.555.0190] Fax [509.555.0191]</td>
			<td>&nbsp;</td>
			<td align="right">TIME: '. date('H:i:s',strtotime($po_detail['modifiedAt'])).'</td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td>'.$to.'</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td align="left" >'.$supplier.'</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		</table>
		<p>&nbsp;</p>
		
		<table width="100%" border="1" cellpadding="5"  cellspacing="0">
		  <tr align="center" valign="middle">
		 	<td align="center" width="5%"><strong>NO</strong></td>
			<td align="center" width="50%"><strong>NAME</strong></td>
			<td align="center" width="10%"><strong>PO QUANTITY</strong></td>
			<td align="center" width="10%"><strong>RECEIVED QUANTITY</strong></td>
			<td align="center" width="10%"><strong>ACCEPTED QUANTITY</strong></td>
			<td align="center" width="10%"><strong>REJECTED QUANTITY</strong></td>
			<td align="center" width="10%"><strong>UNIT PRICE</strong></td>
			<td align="center" width="10%"><strong>TOTAL</strong></td>
		  </tr>';
		  $i=1;
		 // $finalAmount = 0 ;
	foreach($purchaseData as $row) {
		//$finalAmount = $finalAmount + $row['amount'] ;
		$html .=  '<tr>
			<td align="center">&nbsp;'.$i.'</td>
			<td align="left" height="20">&nbsp;'.$row['product_name'].'</td>
			<td align="right">'.$row['quantity'].'&nbsp;</td>
			<td align="right">'.$row['received_quantity'].'&nbsp;</td>
			<td align="right">'.$row['accepted_quantity'].'&nbsp;</td>
			<td align="right">'.($row['received_quantity'] - $row['accepted_quantity']).'&nbsp;</td>
			<td align="right">&nbsp;'.$row['price'].'</td>
			<td align="right">&nbsp;'.$row['amount'].'</td>
		  </tr>
		  
		  ';
   $i++; } 
		$html .= '
		<tr >
			<td colspan="7" align="right" class="noborder1">TOTAL('.Yii::app()->session['currency'].')</td>
			<td align="right">&nbsp;'.$po_detail['total_amount'].'</td>
		  </tr>
		</table>
		</body>
		</html>';	

		$mpdf = new mPDF();
		$mpdf->WriteHTML($html);
		$mpdf->Output(FILE_PATH."assets/upload/goodsReceipt/goodsReceipt_".$id.".pdf", 'F');
		
		return true ;
		
		//$this->redirect(Yii::app()->params->base_url."user");
	}
	
	function actionraisePurchaseOrder($id)
	{
		$PoDescObj = new PoDesc();
		$purchaseData = $PoDescObj->getPoDescDetails($id);
		
		$admin_id = Yii::app()->session['farmsourcing_adminUser'];
		
		$adminObj=Admin::model()->findByPk($admin_id);
		
		$companyObj = new CompanyDetails();
		$companyData = $companyObj->getCompanyDetailsByAdminId($admin_id);
		
		$url = Yii::app()->params->base_url."timthumb/timthumb.php?src=".Yii::app()->params->base_url."assets/upload/clientLogo/".$companyData['company_logo']."&h=100&w=150&q=60&zc=0" ;

		
		$PoDetailsObj  = new PoDetails();
		$po_detail = $PoDetailsObj->getpurchaseOrderDataById($id);
		
		/*echo "<pre>";
		print_r($purchaseData);
		print_r($po_detail);
		exit;*/
		
		if($po_detail['vendor_name'] != "")
		{
			$supplier = 'VENDOR: '.$po_detail['vendor_name'] ;
			$to = 'TO,'	;
		}
		
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
		<table width="100%" border="0" cellspacing="0" cellpadding="5">
		  <tr>
		  <td align="left"><img src="'.$url.'" /></td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  </tr>
		  <tr>
			<td width="48%" rowspan="2"><b>'.$companyData['company_name'].'</b></td>
			<td width="29%">&nbsp;</td>
			<td width="23%" align="right" style="margin-right:20px;"><h1> <font color="#808080">PURCHASE ORDER</h1></td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td> [Street Address]</td>
			<td>&nbsp;</td>
			<td align="right">PURCHASE ORDER: '. $id.'<br /></td>
		  </tr>
		  <tr>
			<td>[City, ST ZIP Code]</td>
			<td>&nbsp;</td>
			<td align="right">DATE: '. date('F d, Y',strtotime($po_detail['createdAt'])).'</td>
		  </tr>
		  <tr>
			<td>Phone [509.555.0190] Fax [509.555.0191]</td>
			<td>&nbsp;</td>
			<td align="right">TIME: '. date('H:i:s',strtotime($po_detail['createdAt'])).'</td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td>'.$to.'</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td align="left" >'.$supplier.'</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		</table>
		<p>&nbsp;</p>
		
		<table width="100%" border="1" cellpadding="5"  cellspacing="0">
		  <tr align="center" valign="middle">
		 	<td align="center" width="5%"><strong>NO</strong></td>
			<td align="center" width="50%"><strong>NAME</strong></td>
			<td align="center" width="10%"><strong>QUANTITY</strong></td>
			<td align="center" width="10%"><strong>UNIT PRICE</strong></td>
			<td align="center" width="10%"><strong>TOTAL</strong></td>
		  </tr>';
		  $i=1;
		 // $finalAmount = 0 ;
	foreach($purchaseData as $row) {
		//$finalAmount = $finalAmount + $row['amount'] ;
		$html .=  '<tr>
			<td align="center">&nbsp;'.$i.'</td>
			<td align="left" height="20">&nbsp;'.$row['product_name'].'</td>
			<td align="right">'.$row['quantity'].'&nbsp;</td>
			<td align="right">&nbsp;'.$row['price'].'</td>
			<td align="right">&nbsp;'.$row['amount'].'</td>
		  </tr>';
   $i++; } 
		$html .= '
		  <tr >
			<td colspan="4" align="right" class="noborder1">TOTAL('.Yii::app()->session['currency'].')</td>
			<td align="right">&nbsp;'.$po_detail['total_amount'].'</td>
		  </tr>
		</table>
		
		</body>
		</html>';	

		$mpdf = new mPDF();
		$mpdf->WriteHTML($html);
		$mpdf->Output(FILE_PATH."assets/upload/purchaseOrder/purchaseOrder_".$id.".pdf", 'F');
		
		$vendorObj=Vendor::model()->findByPk($po_detail['vendor_id']);
		
		$message='<table cellpadding="5" cellspacing="5" style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px;background-color:#E5E5E5;" width="600">
				<tr>
				<td style="background-color:#000">
					<div style="text-align:left"><img src="assets/upload/clientLogo/'.$companyData['company_logo'].'" style="width:160px; height:40px;"></div>
				</td>
				</tr>
				<tr>
					<td>Hello ,</td>
				</tr>
				<tr>
					<td>Fresh N Pack New Purchase Order PDF - Please find the attachment.<br /></td>
				</tr>
				<tr>
					<td>
						 Thank you,
					</td>
				</tr>
				<tr>
					<td>
						 Team FreshNPack.
					</td>
				</tr>
				</table>';
		
		$mail = new PHPMailer(); // defaults to using php "mail()"
		$mail->SetFrom('support@farmsoucing.com', 'Fresh N Pack Team');
		$mail->AddReplyTo("support@farmsoucing.com","Fresh N Pack Team");
		$mail->AddAddress($adminObj->email, "Fresh N Pack Team");
		$mail->AddAddress($vendorObj->email, "Fresh N Pack Team");
		$mail->Subject    = "You have a new Purchase Order via Fresh N Pack system";
		$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
		$mail->MsgHTML($message);
		$mail->AddAttachment("assets/upload/purchaseOrder/purchaseOrder_".$id.".pdf");      // attachment
		$mail->Send();
			//echo "Message sent!";
		
		return true ;
		
		//$this->redirect(Yii::app()->params->base_url."user");
	}
	
	function actionrejectionList()
	{
		$title = "Rejection List";
		
		$DeliveryDescObj =  new DeliveryDesc();
		$orderdata = $DeliveryDescObj->getAllDeliveryPendingOrders();
		
		Yii::app()->session['current'] = "Rejection List";
		$this->render("rejectionList",array("title"=>$title,'orderdata'=>$orderdata));
	}
	
	function actionrejectionListing()
	{
		
		$title = "Rejection List";
		
		$DeliveryDescObj =  new DeliveryDesc();
		$orderdata = $DeliveryDescObj->getAllDeliveryPendingOrders();
		
		$rejectionObj = new Rejection();
		$rejectionData = $rejectionObj->getAllRejectedOrders();
		
		Yii::app()->session['current'] = "Rejection List";
		$this->render("rejectionListing",array("title"=>$title,'rejectionData'=>$rejectionData,'orderdata'=>$orderdata));
	}
	
	function actiongetSalesOrderData()
	{
		$title = "Rejection List";
		Yii::app()->session['current'] = "Rejection List";
		
		/*$soDetailsObj =  new SoDetails();
		$orderdata = $soDetailsObj->getAllOrders();
		
		$soDetailsObj =  new SoDetails();
		$soDetailsData = $soDetailsObj->getsalesOrderData($_REQUEST['so_id']);
		
		$soDescObj =  new SoDesc();
		$soDescData = $soDescObj->getSoDescDetails($_REQUEST['so_id']);*/
		
		$DeliveryDescObj =  new DeliveryDesc();
		$orderdata = $DeliveryDescObj->getAllDeliveryPendingOrders();
		
		$deliveryDescObj =  new DeliveryDesc();
		$soDetailsData = $deliveryDescObj->getDeliveryOrderData($_REQUEST['so_id']);
		
		$deliveryOrderDescObj =  new DeliveryOrderDesc();
		$soDescData = $deliveryOrderDescObj->getDeliveryDescDetails($_REQUEST['so_id']);
		
		Yii::app()->session['current'] = "Rejection List";
		$this->render("rejectionList",array('title'=>$title,'so_id'=>$_REQUEST['so_id'],'soDetailsData'=>$soDetailsData,'orderdata'=>$orderdata,'soDescData'=>$soDescData));
	}
	
	function actionsaveRejectedData()
	{
		/*print "<pre>";
		print_r($_POST);
		exit;*/
		$title = "Rejection List";
		$rejectedDetails = array();
		$rejectedDesc = array();
		
		
		$rejectedDetails['so_id'] = $_POST['so_id'];
		$rejectedDetails['admin_id'] = Yii::app()->session['farmsourcing_adminUser'];
		$rejectedDetails['delivery_id'] = $_POST['delivery_id'];
		$rejectedDetails['driver_id'] = $_POST['driver_id'];
		$rejectedDetails['customer_id'] = $_POST['customer_id'];
		$rejectedDetails['total_product'] = $_POST['count'];
		$rejectedDetails['total_amount'] = $_POST['totalAmount'];
		$rejectedDetails['createdAt'] = date("Y-m-d H:i:s");
		$rejectedDetails['modifiedAt'] = date("Y-m-d H:i:s");
		
		if($rejectedDetails['total_amount'] != "" && $rejectedDetails['total_amount'] != "0")
		{
			$rejectionObj =  new Rejection();
			$rejectionObj->setData($rejectedDetails);
			$rejectId = $rejectionObj->insertData();
			
			for($i=1;$i<=$_POST['count'];$i++)
			{
				
				if($_POST['rejected_quantity_'.$i] != '0' && $_POST['rejected_quantity_'.$i] != '')
				{
					$rejectedDesc['rejection_id'] = $rejectId;
					$rejectedDesc['product_id'] = $_POST['product_id_'.$i];
					$rejectedDesc['admin_id'] = Yii::app()->session['farmsourcing_adminUser'];
					$rejectedDesc['sale_quantity'] = $_POST['sale_quantity_'.$i];
					$rejectedDesc['rejected_quantity'] = $_POST['rejected_quantity_'.$i];
					$rejectedDesc['price'] = $_POST['price_'.$i];
					$rejectedDesc['amount'] = $_POST['amount_'.$i];
					$rejectedDesc['reason'] = $_POST['reason_'.$i];
					$rejectedDesc['createdAt'] = date("Y-m-d H:i:s");
					$rejectedDesc['modifiedAt'] = date("Y-m-d H:i:s");
					
					$rejectDescObj =  new RejectionDesc();
					$rejectDescObj->setData($rejectedDesc);
					$rejectDescObj->insertData();
					
					$remainingQuantity = $_POST['sale_quantity_'.$i] - $_POST['rejected_quantity_'.$i];
					$productObj = new Product();
					$productObj->minusProductQnt($remainingQuantity,$_POST['product_id_'.$i]);
				}
				
				
			}
			
			$soData = array();
			$soData['status'] = 2;
			$soData['modifiedAt'] = date("Y-m-d H:i:s");
			
			$soDetails =  new SoDetails();
			$soDetails->setData($soData);
			$soDetails->insertData($_POST['so_id']);
			
			$deliveryDescObj =  new DeliveryDesc();
			$deliveryData = $deliveryDescObj->getDeliveryOrderData($rejectedDetails['so_id']);
			if(!empty($deliveryData))
			{
				$delivery['status'] = 2;
				$delivery['modifiedAt'] = date("Y-m-d H:i:s");
				
				$deliveryDescObj =  new DeliveryDesc();
				$deliveryDescObj->setData($delivery);
				$deliveryDescObj->insertData($deliveryData['id']);
			}
			
			$this->actionraiseRejectionSlip($rejectId);
			
			Yii::app()->user->setFlash('success',"Reject order successfully stored.");
			$this->redirect(array("admin/rejectionListing"));
		}else{
			$this->redirect(array("admin/rejectionListing"));	
		}
		
		exit;
	}
	
	function actionraiseRejectionSlip($id)
	{
		//error_reporting(E_ALL);
		$admin_id = Yii::app()->session['farmsourcing_adminUser'];
		
		$adminObj = Admin::model()->findByPk($admin_id);
		
		$companyDetailsObj	=	new CompanyDetails();
		$adminDetails = $companyDetailsObj->getCompanyDetailsByAdminId($admin_id);
		
		$url = Yii::app()->params->base_url."timthumb/timthumb.php?src=".Yii::app()->params->base_url."assets/upload/clientLogo/".$adminDetails['company_logo']."&h=100&w=150&q=60&zc=0" ;
		
		//$url = Yii::app()->params->base_url."timthumb/timthumb.php?src=".Yii::app()->params->base_url."assets/upload/clientLogo/".$adminObj->company_logo."&h=100&w=150&q=60&zc=0" ;
		$rejectionObj  = new Rejection();
		$rejection_detail = $rejectionObj->getRejectionData($id);
		
		$rejectionDescObj = new RejectionDesc();
		$rejectionData = $rejectionDescObj->getRejectionDescDetails($id);

		if($rejection_detail['customer_name'] != "")
		{
			$customer = $rejection_detail['customer_name'] ;
			$to = 'TO,CUSTOMER: '	;
		}
		
		if($rejection_detail['cust_address'] != "")
		{
			$customer_address = ''.$rejection_detail['cust_address'] ;
		}
		
		if($rejection_detail['type'] == "0")
		{
			$orderType = 'Web' ;
		}else{
			$orderType = 'Mobile' ;
		}
		
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
		<table width="100%" border="0" cellspacing="0" cellpadding="5">
		  <tr>
		  <td align="left"><img src="'.$url.'" /></td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  </tr>
		  <tr>
			<td width="48%" rowspan="2"><b>'.$adminDetails['company_name'].'</b></br><p>'.$adminDetails['company_address'].'</p></td>
			<td width="23%" colspan="2" align="right" style="margin-right:20px;"><h1> <font color="#808080">REJECTION SLIP</h1></td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td align="left">REJECTION ID: '. $id.'<br /></td>
			<td>&nbsp;</td>
			<td align="right">ORDER ID: '.$rejection_detail['so_id'].'<br /></td>
		  </tr>
		  <tr>
			<td align="left">DELIVERY DATE: '. date('F d, Y',strtotime($rejection_detail['delivery_date'])).'</td>
			<td>&nbsp;</td>
			<td align="right">ORDER TYPE: '.$orderType.'<br /></td>
		  </tr>
		  <tr>
			<td align="left">DRIVER NAME: <b>'. $rejection_detail['driver'].'</b></td>
			<td align="right" colspan="2">&nbsp;</td>
		  </tr>
		  <tr>
			<td align="left">&nbsp;</td>
			<td align="right" colspan="2">&nbsp;</td>
		  </tr>
		  <tr>
			<td>'.$to.'</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td align="left" ><b>'.$customer.'</b></td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td align="left" >ADDRESS:</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td align="left" ><b>'.$customer_address.'</b></td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		</table>
		<p>&nbsp;</p>
		
		<table width="100%" border="1" cellpadding="5"  cellspacing="0">
		  <tr align="center" valign="middle">
		 	<td align="center" width="5%"><strong>NO</strong></td>
			<td align="center" width="50%"><strong>NAME</strong></td>
			<td align="center" width="10%"><strong>SALE QTY</strong></td>
			<td align="center" width="10%"><strong>REJECTED QTY</strong></td>
			<td align="center" width="10%"><strong>PRICE</strong></td>
			<td align="center" width="10%"><strong>TOTAL</strong></td>
			<td align="center" width="20%"><strong>REASON</strong></td>
		  </tr>';
		  $i=1;
		  $finalAmount = 0 ;
		
		foreach($rejectionData as $row) {
		$finalAmount = $finalAmount + $row['amount'] ;
		$html .=  '<tr>
			<td align="center">&nbsp;'.$i.'</td>
			<td align="left" height="20">&nbsp;'.$row['product_name'].'</td>
			<td align="right">'.$row['sale_quantity'].'&nbsp;</td>
			<td align="right">'.$row['rejected_quantity'].'&nbsp;</td>
			<td align="right">&nbsp;'.$row['price'].'</td>
			<td align="right">&nbsp;'.$row['amount'].'</td>
			<td align="right">&nbsp;'.$row['reason'].'</td>
		  </tr>';
   $i++; } 
		$html .= '
		  <tr >
			<td colspan="5" align="right" class="">TOTAL('.Yii::app()->session['currency'].')</td>
			<td align="right">&nbsp;<b>'.$finalAmount.'</b></td>
			<td align="right">&nbsp;<b>&nbsp;</b></td>
		  </tr>
		</table>
		
		</body>
		</html>';
		
		//echo $html; exit;
		
		$mpdf = new mPDF();
		$mpdf->WriteHTML($html);
		$mpdf->Output(FILE_PATH."assets/upload/rejectionSlip/rejectionSlip_".$id."_".$admin_id.".pdf", 'F');
		
		return true;
		//$this->redirect(Yii::app()->params->base_url."user");
	}
	
	
	function actioncategoryPackagingListing()
	{
		$title = "Category Packaging List";
		Yii::app()->session['current'] = "Category Packaging";
		$categoryPackagingObj = new CategoryPackagingMaster();
		$categoryData = $categoryPackagingObj->getAllCategoryPackagingByUnit();
		
		$this->render("categoryPackagingListing",array('title'=>$title,'categoryData'=>$categoryData));
	}
	
	function actioncategoryPackaging()
	{
		$title = "Add Category Package";
		Yii::app()->session['current'] = "Category Packaging";
		
		/*$categoryObj =  new Category();
		$categoryData = $categoryObj->getAllCategoryList();*/
		
		$unitObj = new Unit();
		$unitData = $unitObj->getAllUnits();
		
		$this->render("addCategoryPackaging",array('title'=>$title,'unitData'=>$unitData));
	}
	
	function actioneditCategoryPackaging()
	{
		$title = "Edit Category Package";
		Yii::app()->session['current'] = "Category Packaging";
		$categoryObj =  new Category();
		$categoryData = $categoryObj->getAllCategoryList();
		
		$categoryPackagingObj = new CategoryPackagingMaster();
		$categoryPackaging = $categoryPackagingObj->getCategoryPackageDetails($_GET['id']);
		
		$this->render("addCategoryPackaging",array('title'=>$title,'categoryData'=>$categoryData,'categoryPackaging'=>$categoryPackaging));
	}
	
	function actionsaveCategoryPackaging()
	{
		
		Yii::app()->session['current'] = "Category Packaging";
		if(isset($_POST['id']) && $_POST['id'] != '')
		{
			$title = "Edit Category Package";
			$data = array();
			
			$arr = explode(',',$_POST['packaging_scenario']);
			
			foreach($arr as $row) {
				//$data['category_id'] = $_POST['category_id'];
				$data['pakaging_type'] = $_POST['pakaging_type'];
				$data['admin_id'] = Yii::app()->session['farmsourcing_adminUser'];
				$data['packaging_scenario'] = $row;
				$data['modifiedAt'] = date("Y-m-d H:i:s");
				
				$categoryPackagingObj = new CategoryPackagingMaster();
				$categoryPackagingObj->setData($data);
				$categoryPackagingObj->insertData($_POST['id']);
			}
			Yii::app()->user->setFlash('success',"Packaging Scenario successfully edited.");
		}
		else
		{
			$title = "Add Category Package";
			$data = array();
			$arr = explode(',',$_POST['packaging_scenario']);
			
			$unitObj = new Unit();
			$unitData = $unitObj->getUnitDataById($_POST['pakaging_type']);
			
			foreach($arr as $row) {
				if($unitData['unit_name'] == "KG")
				{
					
					if($row < 1)
					{
						list($int, $dec) = explode('.', $row);
						$display_name = $dec." "."Gm" ;
					}else{
						$display_name = $row." "."Kg" ;
					}
				}else{
					$display_name = $row." ".$unitData['unit_name'] ;
				}
				//$data['category_id'] = $_POST['category_id'];
				$data['pakaging_type'] = $_POST['pakaging_type'];
				$data['admin_id'] = Yii::app()->session['farmsourcing_adminUser'];
				$data['packaging_scenario'] = $row;
				$data['display_name'] = $display_name;
				$data['createdAt'] = date("Y-m-d H:i:s");
				$data['modifiedAt'] = date("Y-m-d H:i:s");
			
			$categoryPackagingObj = new CategoryPackagingMaster();
			$categoryPackagingObj->setData($data);
			$categoryPackagingObj->insertData();
			}
			Yii::app()->user->setFlash('success',"Packaging Scenario successfully added.");
		}
		
		$this->redirect(array("admin/categoryPackagingListing"));
	}
	
	public function actiondeleteCategoryPackage()
	{
		$this->isLogin();
		
		$categoryObj = new CategoryPackagingMaster();
		$categoryObj->deleteCategoryPackagingMaster($_REQUEST['id']);
		
		Yii::app()->user->setFlash("success","Category package deleted successfully.");
		header('Location: ' . $_SERVER['HTTP_REFERER']);
	}
	
	
	function actiongetCategoryDetailsForProduct()
	{
		
		$categoryObj =  new Category();
		$categoryData = $categoryObj->getCategoryDetail($_REQUEST['cat_id']);
		if(empty($categoryData)){
			echo 0;
		}else
		{
			echo json_encode($categoryData);
		}
		exit;
	}
	
	function actiongetCustomerDetail()
	{
		
		$customersObj = new Customers();
		$customerData = $customersObj->getCustomeDetailrByParam($_REQUEST['mobile_no']);
		
		if(empty($customerData)){
			echo 0;
		}else
		{
			echo json_encode($customerData);
		}
		exit;
	}
	
	function actiongetUnitForCategory()
	{
		$categoryObj =  new Category();
		echo $unitname = $categoryObj->getUnitForCategory($_REQUEST['cat_id']);
		exit;
		
		if(empty($unitname)){
			echo 0;
		}else
		{
			echo $unitname;
		}
		exit;
	}
	
	
	function actionprofitPercentageListing()
	{
		Yii::app()->session['current'] = "Profit Percentage";
		$title = "Profit Percentage List";
		$profitPercentageObj = new ProfitPercentageMaster();
		$profitPercentageData = $profitPercentageObj->getAllProfitPercentage();
		$this->render("profitPercentageListing",array('title'=>$title,'profitPercentageData'=>$profitPercentageData));
	}
	
	function actionaddProfitPercentage()
	{
		Yii::app()->session['current'] = "Profit Percentage";
		$title = "Add Profit Percentage";
		$this->render("addProfitePercentage",array('title'=>$title));
	}
	
	function actioneditProfitPercentage()
	{
		Yii::app()->session['current'] = "Profit Percentage";
		$title = "Edit Profit Percentage";
		Yii::app()->session['current'] = "Profit Percentage";
		
		$profitPercentageObj = new ProfitPercentageMaster();
		$profitPercentageData = $profitPercentageObj->getProductProfitById($_GET['id']);
		
		$this->render("addProfitePercentage",array('title'=>$title,'profitPercentageData'=>$profitPercentageData));
	}
	
	function actionsaveProfitPercentage()
	{
		
		$data = array();
		if(isset($_POST['id']) && $_POST['id'] != '')
		{
			$data['product_id'] = $_POST['product_id'];
			$data['profit_percentage'] = $_POST['profit_percentage'];
			$data['from_date'] = date("Y-m-d",strtotime($_POST['from_date']));
			$data['to_date'] = date("Y-m-d",strtotime($_POST['to_date']));
			$data['status'] = 1;
			$data['admin_id'] = Yii::app()->session['farmsourcing_adminUser'];
			$data['modifiedAt'] = date("Y-m-d H:i:s");
			
			$profitPercentageObj = new ProfitPercentageMaster();
			$profitPercentageObj->setData($data);
			$id = $profitPercentageObj->insertData($_POST['id']);
			Yii::app()->user->setFlash('success',"Profit percentage successfully edited.");
		}
		else
		{
			$data['product_id'] = $_POST['product_id'];
			$data['profit_percentage'] = $_POST['profit_percentage'];
			$data['from_date'] = date("Y-m-d",strtotime($_POST['from_date']));
			$data['to_date'] = date("Y-m-d",strtotime($_POST['to_date']));
			$data['status'] = 1;
			$data['admin_id'] = Yii::app()->session['farmsourcing_adminUser'];
			$data['modifiedAt'] = date("Y-m-d H:i:s");
			$data['createdAt'] = date("Y-m-d H:i:s");
			
			$profitPercentageObj = new ProfitPercentageMaster();
			$profitPercentageObj->setData($data);
			$id = $profitPercentageObj->insertData();
			Yii::app()->user->setFlash('success',"Profit percentage successfully added.");
		}
		
		
		$this->redirect(array("admin/profitPercentageListing"));
		exit;
	}
	
	function actionshowProfitPercentageDetail()
	{
		if($_REQUEST['id'] == "")
		{
			echo 0;
			exit;	
		}
		else
		{
			$this->isLogin();
			
			$profitPercentageMasterObj = new ProfitPercentageMaster();
			$profitPercentageDetailsData = $profitPercentageMasterObj->getProductProfitById($_REQUEST['id']);
			
			/*echo "<pre>";
			print_r($PoDetailsData);
			print_r($poDescData);
			exit;*/
			
			if(!empty($profitPercentageDetailsData))
			{
				$this->renderPartial("profitPercentageDetails",array("profitPercentageDetailsData"=>$profitPercentageDetailsData));
				exit;
			}
			else
			{
				echo 0;
				exit;
			}
		}
	}
	
	
	function actiongenerateDeliveryReport()
	{
		$title = "Delivery List";
		Yii::app()->session['current'] = "Delivery List";
		$deliveryDetailsObj = new DeliveryDetails();
		$deliveryData = $deliveryDetailsObj->getDriverWiseDeliveryList(NULL,NULL);
		
		
		$this->render("generateDeliveryReport",array('deliveryData'=>$deliveryData));
	}
	
	function actionsubmitDeliveryList()
	{
		
		$deliveryDetailsObj = new DeliveryDetails();
		$deliveryData = $deliveryDetailsObj->getDeliveryList($_POST['delivery_date'],$_POST['driver_id']);
		
		print "<pre>";
		print_r($deliveryData);
		exit;
	}
	
	function actionraiseDeliveryReport($post)
	{
		//error_reporting(E_ALL);
		
		
		$deliveryDetailsObj = new DeliveryDetails();
		$deliveryData = $deliveryDetailsObj->getDeliveryListForPdf($post['delivery_date'],$post['driver_id']);
		
		//echo "<pre>"; print_r($deliveryData); exit;
		
		$admin_id = Yii::app()->session['farmsourcing_adminUser'];
		
		$adminObj=Admin::model()->findByPk($post['driver_id']);
		
		$adminData = $adminObj->attributes;
		
		
		$companyObj = new CompanyDetails();
		$companyData = $companyObj->getCompanyDetailsByAdminId($admin_id);
		
		$url = Yii::app()->params->base_url."timthumb/timthumb.php?src=".Yii::app()->params->base_url."assets/upload/clientLogo/".$companyData['company_logo']."&h=100&w=150&q=60&zc=0" ;
		
		//$url = Yii::app()->params->base_url."timthumb/timthumb.php?src=".Yii::app()->params->base_url."assets/upload/clientLogo/".$adminObj->company_logo."&h=100&w=150&q=60&zc=0" ;

		/*if($delivery_detail['customer_name'] != "")
		{
			$customer = $delivery_detail['customer_name'] ;
			$to = 'TO,CUSTOMER: '	;
		}
		
		if($delivery_detail['cust_address'] != "")
		{
			$customer_address = ''.$delivery_detail['cust_address'] ;
		}

		if($delivery_detail['type'] == "0")
		{
			$orderType = 'Web' ;
		}else{
			$orderType = 'Mobile' ;
		}*/
		
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
		<table width="100%" border="0" cellspacing="0" cellpadding="5">
		  <tr>
		  <td align="left"><img src="'.$url.'" /></td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  </tr>
		  <tr>
			<td width="48%" rowspan="2"><b>'.$companyData['company_name'].'</b></br><p>'.$companyData['company_address'].'</p></td>
			<td width="23%" colspan="2" align="right" style="margin-right:20px;"><h1> <font color="#808080">DELIVERY LIST</h1></td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		 
		  <tr>
			<td align="left"><b>DELIVERY DATE:</b> '. date('F d, Y',strtotime($_POST['delivery_date'])).'</td>
			<td colspan="2" align="right"><b>Driver Name : </b>'.$adminData['firstName'].' '.$adminData['lastName']. '</td>
			
		  </tr>
		</table>
		<p>&nbsp;</p>
		
		<table width="100%" border="1" cellpadding="5"  cellspacing="0">
		  <tr align="center" valign="middle">
		  <td align="center" width="5%"><strong>NO</strong></td>
		 	<td align="center" width="5%"><strong>CUSTID</strong></td>
			<td align="center" width="20%"><strong>CUSTOMER NAME</strong></td>
			<td align="center" width="30%"><strong>ADDRESS</strong></td>
			<td align="center" width="10%"><strong>Mobile No</strong></td>
			<td align="center" width="10%"><strong>ZONE</strong></td>
			<td align="center" width="5%"><strong>ORDER ID</strong></td>
			<td align="center" width="10%"><strong>NO OF PACKETS</strong></td>
			<td align="center" width="10%"><strong>TODAYS AMOUNT</strong></td>
			<td align="center" width="10%"><strong>TOTAL AMOUNT DUE</strong></td>
			<td align="center" style="width=100px;"><strong>DELIVERY REMARKS</strong></td>
		  </tr>';
		  $i=1;
		  $finalAmount = 0 ;
		
		foreach($deliveryData as $row) {
			
		$finalAmount = $finalAmount + ( round($row['so_amount'],0) - round($row['coupon_amount'],0)) ;
		$html .=  '<tr>
			<td align="center">&nbsp;'.$i.'</td>
			<td align="right">&nbsp;'.$row['representativeId'].'</td>
			<td align="left" height="20">&nbsp;'.$row['customer_name'].'</td>
			<td align="left">'.$row['address'].'&nbsp;</td>
			<td align="left">'.$row['mobile_no'].'&nbsp;</td>
			<td align="left">'.$row['zoneName'].'&nbsp;</td>
			<td align="right">'.$row['so_id'].'&nbsp;</td>
			<td align="right">'.$row['no_of_packets'].'&nbsp;</td>
			<td align="right">&nbsp;'.(round($row['so_amount'],0) - round($row['coupon_amount'],0)).'</td>
			<td align="right">&nbsp;'.$row['customer_amount_due'].'</td>
			<td align="right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		  </tr>';
   $i++; } 
		$html .= '
			<tr>
				<td colspan="8" align="right" class="noborder">Total</td>
				<td align="right">'.round($finalAmount, 0).'</td>
				<td colspan="2">&nbsp;</td>
		  	</tr>
		</table>

		<table width="100%" border="1" cellpadding="5"  cellspacing="0" class="noborder1">
		  <!--<tr>
			<td colspan="4" align="right" class="noborder"></td>
			<td width="10%">&nbsp;</td>
		  </tr>-->
		  
		</table>
		
		</body>
		</html>';
		
		//echo $html; exit;
		
		$randomStr = date("Y_m_d",strtotime($row['delivery_date'])).'_'.$row['driver_id'];		
		$mpdf = new mPDF();
		$mpdf->WriteHTML($html);
		$mpdf->Output(FILE_PATH."assets/upload/deliveryReports/deliveryReport_".$randomStr.".pdf", 'F');
		
		//$this->actionraiseCollectionReport($_POST);
		return true;
		//$this->redirect(array("admin/generateDeliveryReport"));
	}
	
	
	function actionraiseCollectionReport($post)
	{
		//error_reporting(E_ALL);
		$deliveryDetailsObj = new DeliveryDetails();
		$deliveryData = $deliveryDetailsObj->getDeliveryListForPdf($post['delivery_date'],$post['driver_id']);
		
		
		if(empty($deliveryData))
		{
			Yii::app()->user->setFlash('error',"No data available for pdf generation.");
			$this->redirect(array("admin/generateDeliveryReport"));
			exit;
		}
		
		$admin_id = Yii::app()->session['farmsourcing_adminUser'];
		
		$adminObj=Admin::model()->findByPk($post['driver_id']);
		
		$adminData = $adminObj->attributes;
		
		
		$companyObj = new CompanyDetails();
		$companyData = $companyObj->getCompanyDetailsByAdminId($admin_id);
		
		$url = Yii::app()->params->base_url."timthumb/timthumb.php?src=".Yii::app()->params->base_url."assets/upload/clientLogo/".$companyData['company_logo']."&h=100&w=150&q=60&zc=0" ;
		
		//$url = Yii::app()->params->base_url."timthumb/timthumb.php?src=".Yii::app()->params->base_url."assets/upload/clientLogo/".$adminObj->company_logo."&h=100&w=150&q=60&zc=0" ;

		/*if($delivery_detail['customer_name'] != "")
		{
			$customer = $delivery_detail['customer_name'] ;
			$to = 'TO,CUSTOMER: '	;
		}
		
		if($delivery_detail['cust_address'] != "")
		{
			$customer_address = ''.$delivery_detail['cust_address'] ;
		}
		
		if($delivery_detail['type'] == "0")
		{
			$orderType = 'Web' ;
		}else{
			$orderType = 'Mobile' ;
		}*/
		
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
		<table width="100%" border="0" cellspacing="0" cellpadding="5">
		  <tr>
		  <td align="left"><img src="'.$url.'" /></td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  </tr>
		  <tr>
			<td width="48%" rowspan="2"><b>'.$companyData['company_name'].'</b></br><p>'.$companyData['company_address'].'</p></td>
			<td width="23%" colspan="2" align="right" style="margin-right:20px;"><h1> <font color="#808080">COLLECTION TRANSACTION</h1></td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		 
		  <tr>
			<td align="left"><b>DELIVERY DATE:</b> '. date('F d, Y',strtotime($post['delivery_date'])).'</td>
			<td colspan="2" align="right"><b>Driver Name : </b>'.$adminData['firstName'].' '.$adminData['lastName']. '</td>
			
		  </tr>
		  
		  
		 
		</table>
		<p>&nbsp;</p>
		
		<table width="100%" border="1" cellpadding="5"  cellspacing="0">
		  <tr align="center" valign="middle">
		  	<td align="center" width="5%"><strong>NO</strong></td>
		 	<td align="center" width="5%"><strong>CUSTID</strong></td>
			<td align="center" width="20%"><strong>CUSTOMER NAME</strong></td>
			<td align="center" width="30%"><strong>ADDRESS</strong></td>
			<td align="center" width="5%"><strong>ORDER ID</strong></td>
			<td align="center" width="10%"><strong>NO OF PACKETS</strong></td>
			<td align="center" width="10%"><strong>TODAYS AMOUNT</strong></td>
			<td align="center" width="10%"><strong>TOTAL AMOUNT DUE</strong></td>
			<td align="center" style="width=100px;"><strong>DELIVERY REMARKS</strong></td>
			<td align="center" style="width=100px;"><strong>DELIVER YES/NO/PARTIAL</strong></td>
			<td align="center" style="width=100px;"><strong>AMT PAID</strong></td>
			<td align="center" style="width=100px;"><strong>PAY METHOD (CASH / COUPON / CREDIT)</strong></td>
			<td align="center" style="width=100px;"><strong>REMARKS FROM CUSTOMERS</strong></td>
			<td align="center" style="width=100px;"><strong>SIGNATURE</strong></td>
		  </tr>';
		  $i=1;
		  $finalAmount = 0 ;
		
		foreach($deliveryData as $row) {
		$finalAmount = $finalAmount + ( round($row['so_amount'],0) -  round($row['coupon_amount'],0)) ;
		$html .=  '<tr>
			<td align="center">&nbsp;'.$i.'</td>
			<td align="right">&nbsp;'.$row['representativeId'].'</td>
			<td align="left" height="20">&nbsp;'.$row['customer_name'].'</td>
			<td align="left">'.$row['address'].'&nbsp;</td>
			<td align="right">'.$row['so_id'].'&nbsp;</td>
			<td align="right">'.$row['no_of_packets'].'&nbsp;</td>
			<td align="right">&nbsp;'.(round($row['so_amount'],0) - round($row['coupon_amount'],0)).'</td>
			<td align="right">&nbsp;'.$row['customer_amount_due'].'</td>
			<td align="right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
			<td align="right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
			<td align="right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
			<td align="right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
			<td align="right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
			<td align="right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		  </tr>';
   $i++; } 
		$html .= '
			<tr>
				<td colspan="6" align="right" class="noborder">Total</td>
				<td align="right">'.round($finalAmount, 0).'</td>
				<td colspan="7">&nbsp;</td>
		  	</tr>
		</table>
		<table width="100%" border="1" cellpadding="5"  cellspacing="0" class="noborder1">
		  <!--<tr>
			<td colspan="4" align="right" class="noborder"></td>
			<td width="10%">&nbsp;</td>
		  </tr>-->
		  
		</table>
		
		</body>
		</html>';
		
		//echo $html; exit;
		
		//$randomStr = $deliveryData['delivery_id'].'_'.$post['driver_id']; 
		$randomStr = date("Y_m_d",strtotime($row['delivery_date'])).'_'.$row['driver_id'];		
		$mpdf = new mPDF();
		$mpdf->WriteHTML($html);
		$mpdf->Output(FILE_PATH."assets/upload/collectionReports/collectionReport_".$randomStr.".pdf", 'F');
		
		
		return true;
		//$this->redirect(array("admin/generateDeliveryReport"));
	}
	
	function actionCollectionEntry()
	{
		$this->isLogin();
		$deliveryDescObj = new DeliveryDesc();
		//$soDetailsData = $deliveryDescObj->getAllDeliveryPendingOrders();
		$soDetailsData = $deliveryDescObj->getAllDeliveryOrdersForCollection();
		
		Yii::app()->session['current'] = "customer collection";
		
		$this->render("collectionTransaction",array("soDetailsData"=>$soDetailsData));
	}
	
	function actionsetByOrder()
	{
		$this->isLogin();
	
		if( ( isset($_REQUEST['orderType']) ) && ( $_REQUEST['orderType'] != '' ))
		{
			if( $_REQUEST['orderType'] == 'posOrder' )
			{
				$SoDetailsObj = new SoDetails();
				$soDetailsData = $SoDetailsObj->getAllOrderForCollection();
				
				Yii::app()->session['current'] = "customer collection";
				$this->render("collectionTransactionPos",array("soDetailsData"=>$soDetailsData));
			}
			
			if( $_REQUEST['orderType'] == 'adminOrder' )
			{
				$this->redirect(array("admin/CollectionEntry"));
			}
		}
	}
	
	function actionsaveCollectionPayment()
	{
		if(isset($_POST['FormSubmit']))
		{
			/*echo "<pre>";
			print_r($_POST);
			exit;*/
			
			if((isset($_REQUEST['orderType'])) && $_REQUEST['orderType']=="posOrder")
			{
				if(isset($_REQUEST['so_id']) && ($_REQUEST['so_id']!=''))
				{
					$so_id = $_REQUEST['so_id'];
					$data = array();
					$data['credit_amount'] = $_REQUEST['cash_amount'];
					$SoDetailsObj = new SoDetails();
					//update credit amount
					$SoDetailsObj->updateCreditAmount($so_id,$data['credit_amount']);
				
					Yii::app()->user->setFlash('success',"Successfully added customer collection.");
					$this->redirect(array("admin/CollectionEntry"));
					exit;
				}
			}
			else
			{
			
			if(!empty($_POST['coupon_amount']) && $_POST['coupon_amount'] != 0)
			{
				if($_POST['coupon_id'] == "")
				{
					Yii::app()->user->setFlash('error',"Please insert coupon id.");
					$deliveryDescObj = new DeliveryDesc();
					$soDetailsData = $deliveryDescObj->getAllDeliveryOrdersForCollection();
			
					Yii::app()->session['current'] = "customer collection";
					
					$this->render("collectionTransaction",array("soDetailsData"=>$soDetailsData,"post"=>$_POST));
					exit;	
				}else{
					$couponObj =  new CouponMaster();
					$couponData = $couponObj->getCouponData($_POST['coupon_id'],$_POST['customer_id']);
					if(!empty($couponData))
					{	
						if($couponData['status'] == 1)
						{
							$couponReturnObj =  new CouponTransactions();
							$couponTransactionData = $couponReturnObj->getTotalCountForAmount($couponData['id'],$_POST['customer_id']);
					
							if($couponData['coupon_amount'] > $couponTransactionData['total_used_amount'])
							{
								$couponTransactionsData = array();
								$admin_id = Yii::app()->session['farmsourcing_adminUser'];
								$couponTransactionsData['customer_id'] = $_POST['customer_id'];
								$couponTransactionsData['coupon_master_id'] = $couponData['id'];
								
								$couponTransactionsData['used_amount'] = $_POST['coupon_amount'];
								$couponTransactionsData['admin_id'] = $admin_id;
								$couponTransactionsData['type'] = 0 ;
								$couponTransactionsData['createdAt'] = date("Y-m-d H:i:s");
								$couponTransactionsData['modifiedAt'] = date("Y-m-d H:i:s");
								
								$couponReturnObj =  new CouponTransactions();
								$couponReturnObj->setData($couponTransactionsData);
								$couponReturnObj->insertData();
							}
							else
							{
								Yii::app()->user->setFlash('error',"Your coupon is already used.");
								$deliveryDescObj = new DeliveryDesc();
								$soDetailsData = $deliveryDescObj->getAllDeliveryOrdersForCollection();
						
								Yii::app()->session['current'] = "customer collection";
								$this->render("collectionTransaction",array("soDetailsData"=>$soDetailsData,"post"=>$_POST));
								exit;
							}
						}
						else
						{
							Yii::app()->user->setFlash('error',"Your coupon is Inactive by admin.");
							$deliveryDescObj = new DeliveryDesc();
							$soDetailsData = $deliveryDescObj->getAllDeliveryOrdersForCollection();
					
							Yii::app()->session['current'] = "customer collection";
							$this->render("collectionTransaction",array("soDetailsData"=>$soDetailsData,"post"=>$_POST));
							exit;
						}
					}else
					{
						Yii::app()->user->setFlash('error',"Invalid coupon number you entered.");
						$deliveryDescObj = new DeliveryDesc();
						$soDetailsData = $deliveryDescObj->getAllDeliveryOrdersForCollection();
				
						Yii::app()->session['current'] = "customer collection";
						$this->render("collectionTransaction",array("soDetailsData"=>$soDetailsData,"post"=>$_POST));
						exit;	
					}
				}	
			}
			
			$deliveryDescObj=DeliveryDesc::model()->findByPk($_POST['id']);
			
			$data = array();
			$data['remark'] = $_POST['remarks'];
			if(isset($_POST['delivery_failed']) && $_POST['delivery_failed'] == 1)
			{
				$data['delivery_failed'] = 1 ;	
				$data['cash_amount'] = $deliveryDescObj->cash_amount;
				$data['coupon_amount'] = $deliveryDescObj->coupon_amount;
				$data['credit_amount'] = $deliveryDescObj->credit_amount;
			}else{
				$data['delivery_failed'] = 0 ;
				$data['cash_amount'] = $deliveryDescObj->cash_amount + $_POST['cash_amount'];
				$data['coupon_amount'] = $deliveryDescObj->coupon_amount + $_POST['coupon_amount'];
				//$data['credit_amount'] =  $_POST['credit_amount'];
				$data['credit_amount'] = $deliveryDescObj->so_amount - $data['cash_amount'];
			}
			$data['status'] = 1;
			$data['modifiedAt'] = date("Y-m-d H:i:s");
			$deliveryDescObj = new DeliveryDesc();
			$deliveryDescObj->setData($data);
			$deliveryDescObj->insertData($_POST['id']);
			
			$poGenerate['isPoGenerate'] = 1;
			$poGenerate['modifiedAt'] = date("Y-m-d H:i:s");
			$soDetailsObj = new SoDetails();
			$soDetailsObj->setData($poGenerate);
			$soDetailsObj->insertData($_POST['so_id']);
			
			
			if($data['delivery_failed'] == 0)
			{
				$deliveryOrderDescObj =  new DeliveryOrderDesc();
				$deliveryData = $deliveryOrderDescObj->getDeliveryDescData($_POST['id']);
				
				foreach($deliveryData as $row)
				{
					$productObj = new Product();
					$productObj->minusProductQnt($row['sale_quantity'],$row['product_id']);
				}
			}
			
			Yii::app()->user->setFlash('success',"Successfully added customer collection.");
			$this->redirect(array("admin/CollectionEntry"));
			exit;
		}
		}
		else
		{
			Yii::app()->session['current'] = "customer collection";
			$this->redirect(array("admin/CollectionEntry"));
			exit;
		}	
	}
	
	function actiongetDeliveryDescId()
	{
		//echo "<pre>";
		//print_r($_REQUEST);
		
		
		if((isset($_REQUEST['orderType'])) && ($_REQUEST['orderType']!=''))
		{
			if($_REQUEST['orderType']=='posOrder')
			{
				$SoDetailsObj = new SoDetails();
				$soDetailsData = $SoDetailsObj->getsalesOrderData($_REQUEST['so_id']);
				
				$SoDescObj  = new SoDesc();
				$deliveryData = $SoDescObj->getSoDescDetails($_REQUEST['so_id']);
				
				if($soDetailsData['credit_amount'] != "")
				{
					$credit_amount = $soDetailsData['credit_amount'] ;
				}
				$finalAmount = 0 ;
				
				foreach($deliveryData as $row)
				{
					$finalAmount = $finalAmount + ($row['product_price'] * $row['quantity']) ;
				}
				
				$soDetailsData['so_amount'] = $finalAmount - (ROUND($soDetailsData['discount_amount'], 0)) ;
				
				if($soDetailsData['customer_id'] != "")
				{
					$SoDetailsObj = new SoDetails();
					$total_credit_amount_by_customer_id = $SoDetailsObj->getSumOfCreditByCustomerId($soDetailsData['customer_id']);
					
					if($total_credit_amount_by_customer_id!=0)
					{
						$totalRemainingCredit = round($total_credit_amount_by_customer_id,0) ;
					}else{
						$totalRemainingCredit = 0 ;
					}
					
				}
				else
				{
					$totalRemainingCredit = 0 ;
				}
				
				$soDetailsData['totalRemainingCredit'] = $totalRemainingCredit;
				
				echo json_encode($soDetailsData);
				exit;
		
			}
			if($_REQUEST['orderType']=='adminOrder')
			{
				$deliveryDescObj = new DeliveryDesc();
				$soDetailsData = $deliveryDescObj->getDeliveryOrderData($_REQUEST['so_id']);
				
				$rejectionDescObj = new Rejection();
				$rejectionData = $rejectionDescObj->getRejectionDataBySoId($_REQUEST['so_id']);
				
				if(empty($rejectionData))
				{
					$rejectionData['total_amount'] = 0 ;	
				}
				
				$soDetailsData['so_amount'] = round($soDetailsData['so_amount'],0) - round($rejectionData['total_amount'],0);
				$soDetailsData['rejection_amount'] = round($rejectionData['total_amount'],0);
				
				echo json_encode($soDetailsData);
				exit;
			}		
		}
		
		
	}
	
	function actiongetCustomerRemainingAmount()
	{
		$deliveryDescObj = new DeliveryDesc();
		$creditData = $deliveryDescObj->getCustomerRemainingAmountOfAllOrder($_REQUEST['customer_id']);
		
		if(!empty($creditData))
		{
			$totalRemainingCredit = $creditData['totalAmount'] - ($creditData['totalCash'] + $creditData['totalCoupon']) ;
		}else{
			$totalRemainingCredit = 0 ;
		}
		echo $totalRemainingCredit;
		exit;
	}
	
	function actionrejectionDetail()
	{
		
		if($_REQUEST['id'] == "")
		{
			echo 0;
			exit;	
		}
		else
		{
			
			$rejectionObj =  new Rejection();
			$rejectionData = $rejectionObj->getRejectionData($_REQUEST['id']);
		
			$rejectionDescObj =  new RejectionDesc();
			$rejectionDescData = $rejectionDescObj->getRejectionDescDetails($_REQUEST['id']);
			
			$this->renderPartial("rejectOrderDetails",array("rejectionData"=>$rejectionData,'rejectionDescData'=>$rejectionDescData));
		}
	}
	
	function actionexportCashTransactionReport()
	{
		$this->isLogin();
		Yii::app()->session['current'] = 'export';
		
		$this->render('exportCashReport');	
	}
	
	function actionexportPurchaseOrderReport()
	{
		$this->isLogin();
		Yii::app()->session['current'] = 'export';
		
		$this->render('exportPurchaseOrderReport');	
	}
	
	function actionexportExcelCashTransactionReport()
	{
		if(!empty($_POST['from']) && !empty($_POST['to']))
		{
			$from = date("Y-m-d H:m:s",strtotime($_POST['from'])) ;
			$to = date("Y-m-d H:m:s",strtotime($_POST['to']. ' + 1 day')) ;
			
			include_once('ExportToExcel.class.php'); 
			//$conn=mysql_connect('localhost','root','')or die('Sorry Could not make connection');
			$conn=mysql_connect(DB_SERVER,DB_SERVER_USERNAME,DB_SERVER_PASSWORD)or die('Sorry Could not make connection');
			mysql_select_db(DB_DATABASE); 
	
			$exp=new ExportToExcel();
			
			mysql_query("SET NAMES utf8;");
								
			mysql_query("SET character_set_results = 'utf8'");
			
			$qry="select a.id as DriverId, CONCAT(a.firstName,' ',a.lastName) as Driver,c.representativeId as CustomerId, c.customer_name as CustomerName, dd.so_id as OrderId, 
				dd.cash_amount as CashAmount, dd.modifiedAt as Date 
				from delivery_desc dd
				Left Join customers c ON (c.customer_id = dd.customer_id)
				Left Join delivery_details d ON (d.delivery_id = dd.delivery_id)
				Left Join admin a ON (a.id = d.driver_id)
				where dd.status != 0
				and dd.modifiedAt >= '".$from."' and  dd.modifiedAt < '".$to."'  ;";
			
			$sql = mysql_query($qry);	
			if(mysql_num_rows($sql) > 0)
			{
				$exp->exportWithQuery($qry,"ExportCashData",$conn);
			}else{
				Yii::app()->user->setFlash('error',"Record not found.");
				$this->redirect(array("admin/exportCashTransactionReport"));	
			}
			//Yii::app()->user->setFlash('success',"Report successfully generated.");
			//$this->redirect(array("admin/exportCashTransactionReport"));
		}else{
			$this->redirect(array("admin/exportCashTransactionReport"));
		}

	}
	
	function actionexportExcelPOReport()
	{
		if(!empty($_POST['from']) && !empty($_POST['to']))
		{
			$from = date("Y-m-d H:m:s",strtotime($_POST['from'])) ;
			$to = date("Y-m-d H:m:s",strtotime($_POST['to']. ' + 1 day')) ;
			
			include_once('ExportToExcel.class.php'); 
			//$conn=mysql_connect('localhost','root','')or die('Sorry Could not make connection');
			$conn=mysql_connect(DB_SERVER,DB_SERVER_USERNAME,DB_SERVER_PASSWORD)or die('Sorry Could not make connection');
			mysql_select_db(DB_DATABASE); 
	
			$exp=new ExportToExcel();
			
			mysql_query("SET NAMES utf8;");
								
			mysql_query("SET character_set_results = 'utf8'");
			
			$qry="select  pd.po_id as PO_Id, pd.product_id as ProductId, p.product_name as ProductName, v.vendor_id as VendorId, v.vendor_name as VendorName, pd.admin_id as AdminId, CONCAT(COALESCE(a.firstName,''),' ',COALESCE(a.lastName,'')) as AdminName,
pd.quantity as PO_Quantity, pd.received_quantity as Received_Quantity, pd.accepted_quantity as Accepted_Quantity, 
pd.price as Rate, pd.amount as TotalAmount 
from po_desc pd
Left Join product p ON (p.product_id = pd.product_id) 
Left Join po_details po ON (po.po_id = pd.po_id) 
Left Join vendor v ON  ( v.vendor_id = po.vendor_id ) 
Left Join admin a ON  ( a.id = po.admin_id )
where po.status = 1
and pd.createdAt >= '".$from."' and  pd.createdAt < '".$to."' order by p.product_name asc  ;";
			
			$sql = mysql_query($qry);	
			if(mysql_num_rows($sql) > 0)
			{
				$exp->exportWithQuery($qry,"ExportPurchaseOrdersData",$conn);
			}else{
				Yii::app()->user->setFlash('error',"Record not found.");
				$this->redirect(array("admin/exportPurchaseOrderReport"));	
			}
			//Yii::app()->user->setFlash('success',"Report successfully generated.");
			//$this->redirect(array("admin/exportCashTransactionReport"));
		}else{
			$this->redirect(array("admin/exportPurchaseOrderReport"));
		}

	}
	
	function actionexportCouponTransactionReport()
	{
		$this->isLogin();
		Yii::app()->session['current'] = 'export';
		
		$this->render('exportCouponReport');	
	}
	
	function actionexportExcelCouponTransactionReport()
	{
		if(!empty($_POST['from']) && !empty($_POST['to']))
		{
			$from = date("Y-m-d H:m:s",strtotime($_POST['from'])) ;
			$to = date("Y-m-d H:m:s",strtotime($_POST['to']. ' + 1 day')) ;
			
			include_once('ExportToExcel.class.php'); 
			//$conn=mysql_connect('localhost','root','')or die('Sorry Could not make connection');
			$conn=mysql_connect(DB_SERVER,DB_SERVER_USERNAME,DB_SERVER_PASSWORD)or die('Sorry Could not make connection');
			mysql_select_db(DB_DATABASE); 
	
			$exp=new ExportToExcel();
			
			mysql_query("SET NAMES utf8;");
								
			mysql_query("SET character_set_results = 'utf8'");
			
			$qry="select a.id as DriverId, CONCAT(a.firstName,' ',a.lastName) as Driver,c.representativeId as CustomerId, c.customer_name as CustomerName, dd.so_id as OrderId, 
				dd.coupon_amount as CouponAmount, dd.modifiedAt as Date 
				from delivery_desc dd
				Left Join customers c ON (c.customer_id = dd.customer_id)
				Left Join delivery_details d ON (d.delivery_id = dd.delivery_id)
				Left Join admin a ON (a.id = d.driver_id)
				where dd.status != 0
				and dd.modifiedAt >= '".$from."' and  dd.modifiedAt < '".$to."'  ;";
				
			$sql = mysql_query($qry);	
			if(mysql_num_rows($sql) > 0)
			{
				$exp->exportWithQuery($qry,"ExportCouponData",$conn);
			}else{
				Yii::app()->user->setFlash('error',"Record not found.");
				$this->redirect(array("admin/exportCouponTransactionReport"));	
			}
			//Yii::app()->user->setFlash('success',"Report successfully generated.");
			//$this->redirect(array("admin/exportCashTransactionReport"));
		}else{
			$this->redirect(array("admin/exportCouponTransactionReport"));
		}

	}
	
	
	function actionexportExcelCustomerReport()
	{
		
			//$from = date("Y-m-d H:m:s",strtotime($_POST['from'])) ;
			//$to = date("Y-m-d H:m:s",strtotime($_POST['to']. ' + 1 day')) ;
			
			include_once('ExportToExcel.class.php'); 
			//$conn=mysql_connect('localhost','root','')or die('Sorry Could not make connection');
			$conn=mysql_connect(DB_SERVER,DB_SERVER_USERNAME,DB_SERVER_PASSWORD)or die('Sorry Could not make connection');
			mysql_select_db(DB_DATABASE); 
	
			$exp=new ExportToExcel();
			
			mysql_query("SET NAMES utf8;");
								
			mysql_query("SET character_set_results = 'utf8'");
			
			$qry="select c.RepresentativeId, c.customer_name as Name, a.id as AdminId,  CONCAT(COALESCE(a.firstName,''),' ',COALESCE(a.lastName,'')) as Admin, c.cust_email as Email, c.contact_no as ContactNo, c.mobile_no as MobileNo, c.block as Block, c.house_no as HouseNo, c.building_name as BuildingName, c.landmark1 as Landmark1, c.landmark2 as Landmark2, c.area as Area, z.zoneName , c.city as City, c.country as Country, c.pincode as Pincode, c.createdAt as CreatedDate, c.modifiedAt as ModifiedDate from customers c 
Left Join zone z ON (z.zone_id = c.zone_id) 
Left Join admin a ON (a.id = c.admin_id)
order by c.customer_name asc;";
			
			$sql = mysql_query($qry);	
			if(mysql_num_rows($sql) > 0)
			{
				$exp->exportWithQuery($qry,"ExportCustomerData",$conn);
			}else{
				Yii::app()->user->setFlash('error',"Record not found.");
				$this->redirect(array("admin/exportExcelCustomerReport"));	
			}
			//Yii::app()->user->setFlash('success',"Report successfully generated.");
			//$this->redirect(array("admin/exportCashTransactionReport"));
		

	}
	
	function actionexportExcelProductReport()
	{
		
			//$from = date("Y-m-d H:m:s",strtotime($_POST['from'])) ;
			//$to = date("Y-m-d H:m:s",strtotime($_POST['to']. ' + 1 day')) ;
			
			include_once('ExportToExcel.class.php'); 
			//$conn=mysql_connect('localhost','root','')or die('Sorry Could not make connection');
			$conn=mysql_connect(DB_SERVER,DB_SERVER_USERNAME,DB_SERVER_PASSWORD)or die('Sorry Could not make connection');
			mysql_select_db(DB_DATABASE); 
	
			$exp=new ExportToExcel();
			
			mysql_query("SET NAMES utf8;");
								
			mysql_query("SET character_set_results = 'utf8'");
			
			$qry="select p.product_id as ProductId, p.product_name as ProductName, p.cat_id as CategoryId, c.category_name as CategoryName, p.unitId as UnitId, u.unit_name, a.id as AdminId,  CONCAT(COALESCE(a.firstName,''),' ',COALESCE(a.lastName,'')) as Admin, v.vendor_id as VendorId, v.vendor_name as VendorName, p.product_desc as Description, p.product_image as ImageName, p.product_price as Price, p.quantity as Quantity, p.safetyMargin as SafetyMargin, p.profit_percentage as ProfitPercentage, p.featured as Featured, p.special as Special, p.is_discount as Is_Discount, p.discount as DiscountValue, p.discount_from as DiscountFrom, p.discount_to as DiscountTo, p.discount_desc as DiscountDescription, p.created_date as CreatedDate, p.modified_date as ModifiedDate from product p 
Left Join unit u On (u.unit_id = p.unitId)
Left Join category c On (c.cat_id = p.cat_id) 
Left Join vendor v On (v.vendor_id = p.vendor_id)
Left Join admin a On (a.id = p.admin_id)
order by p.product_name asc";
			
			$sql = mysql_query($qry);	
			if(mysql_num_rows($sql) > 0)
			{
				$exp->exportWithQuery($qry,"ExportProductData",$conn);
			}else{
				Yii::app()->user->setFlash('error',"Record not found.");
				$this->redirect(array("admin/exportExcelProductReport"));	
			}
			//Yii::app()->user->setFlash('success',"Report successfully generated.");
			//$this->redirect(array("admin/exportCashTransactionReport"));
		

	}
	
	function actionshowDailySalesReports()
	{
		//error_reporting(E_ALL);
		//print "<pre>";
		//print_r($_POST);exit;
		$this->isLogin();
		Yii::app()->session['current'] = 'reports';
		
		
		if(isset($_POST['submit']) && $_POST['type'] != "" && $_POST['fromDate'] != "" &&  $_POST['toDate'] != "")
		{
			$ext['type'] = $_POST['type'];
			$ext['fromDate'] = $_POST['fromDate'];
			$ext['toDate'] = $_POST['toDate'];
			
			if(isset($_POST['ordertype']) && $_POST['ordertype'] != "" )
			{
				$ext['ordertype'] = $_POST['ordertype'];
			}else{
				Yii::app()->user->setFlash('error',"Please select order type.");
				$this->render('dailySalesReport',array("ext"=>$ext));
				exit;
			}
			
			$orderDataArr = array();
			$posTypeOrder=0;
			
			if(isset($_POST['ordertype']) && $_POST['ordertype'] != "" )
			{
				foreach($_POST['ordertype'] as $row)
				{
					if($row == 3)
					{
						$posTypeOrder = 3;
					}
					else
					{
						$orderDataArr[] = $row;
					}
				}
				$ext['ordertype'] = implode(',',$_POST['ordertype']);
			}
			
			if($_POST['type'] == 1)
			{
				
				if(isset($_POST['ordertype']) && $posTypeOrder == 3)
				{
					$soDescObj = new SoDesc();
					$data1 = $soDescObj->getDailyProductReportForPOS($ext['fromDate'],$ext['toDate'],$posTypeOrder);
					//echo "<pre>";
//					print_r($data1);
//					exit;
				}
				
				if(!empty($orderDataArr)){
					$deliveryOrderDescObj = new DeliveryOrderDesc();
					$data2 = $deliveryOrderDescObj->getDailyProductReport($ext['fromDate'],$ext['toDate'],implode(',',$orderDataArr));
					/*echo "<pre>";
					print_r($data2);
					exit;*/
				}
				/*else
				{
					$deliveryOrderDescObj = new DeliveryOrderDesc();
					$data2 = $deliveryOrderDescObj->getDailyProductReport($ext['fromDate'],$ext['toDate']);
				}*/
				
				if(!empty($data1) && !empty($data2))
				{
					$data = array_merge($data1,$data2);
				}
				else
				{
					$data = array();
				}
				
				if(empty($data1) && !empty($data2))
				{
					$data = $data2;
				}
				if(empty($data2) && !empty($data1))
				{
					$data = $data1;
				}
				
				
				
				$product_ids = array();	
				$newData = array();
				$k = 1;
				//echo "<pre>";
				//print_r($data);
				//exit;
				
				foreach($data as $dataRow)
				{
					$key = array_search($dataRow['product_id'],$product_ids);
					
					if(empty($key))
					{
						$newData[] =  $dataRow;	
						$product_ids[$k] = $dataRow['product_id'];
						$k++;
					}else{
						$newData[$key - 1]['so_quantity']  = $newData[$key - 1]['so_quantity'] + $dataRow['so_quantity'] ;
						$newData[$key - 1]['amount']  = $newData[$key - 1]['amount'] + $dataRow['amount'] ;
						$newData[$key - 1]['discount_amount']  = $newData[$key - 1]['discount_amount'] + $dataRow['discount_amount'] ;
					}
					
				}
				//echo "<pre>";
				//print_r($newData);
				//exit;
				
				$this->render('dailySalesReport',array("data"=>$newData,"ext"=>$ext));
				exit;
			}
			
			if($_POST['type'] == 2)
			{
				$deliveryDescObj = new DeliveryDesc();
				$data = $deliveryDescObj->getDailyCustomerReport($ext['fromDate'],$ext['toDate'],implode(',',$orderDataArr));
				
				/*echo "<pre>";
				print_r($data);
				exit;*/	
				
				$this->render('dailySalesReport',array("data"=>$data,"ext"=>$ext));
				exit;
			}
			
			if($_POST['type'] == 3)
			{
				if(isset($_POST['ordertype']) && $posTypeOrder == 3)
				{
					$soDescObj = new SoDesc();
					$data1 = $soDescObj->getDailySalesReportByInvoiceIdForPOS($ext['fromDate'],$ext['toDate'],$posTypeOrder);
				}
				
				if(!empty($orderDataArr)){
					$deliveryDescObj = new DeliveryDesc();
					$data2 = $deliveryDescObj->getDailySalesReportByInvoiceId($ext['fromDate'],$ext['toDate'],$orderDataArr);
				}
				
				if(!empty($data1) && !empty($data2))
				{
					$data = array_merge($data1,$data2);
				}
				else
				{
					$data = array();
				}
				
				if(empty($data1) && !empty($data2))
				{
					$data = $data2;
				}
				if(empty($data2) && !empty($data1))
				{
					$data = $data1;
				}
				
				/*echo "<pre>";
				print_r($data1);
				print_r($data2);
				exit;*/
				
				
				$this->render('dailySalesReport',array("data"=>$data,"ext"=>$ext));
				exit;
			}			
		}
		$this->render('dailySalesReport');	
	}
	
	function actionshowDailyRejectionReports()
	{
		$this->isLogin();
		Yii::app()->session['current'] = 'reports';
		
		if(isset($_POST['submit']) && $_POST['type'] != "" && $_POST['fromDate'] != "" && $_POST['toDate'] != "")
		{
			$ext['type'] = $_POST['type'];
			$ext['fromDate'] = $_POST['fromDate'];
			$ext['toDate'] = $_POST['toDate'];
			
			$date = date("Y-m-d",strtotime($ext['delivery_date'])) ;
			if($_POST['type'] == 1)
			{
				$rejectionDescObj = new RejectionDesc();
				$data = $rejectionDescObj->getDailyRejectionProductWiseData($ext['fromDate'],$ext['toDate']);
				
				/*echo "<pre>";
				print_r($data);
				exit;*/	
				
				$this->render('dailyRejectionReport',array("data"=>$data,"ext"=>$ext));
				exit;
			}		
			if($_POST['type'] == 2)
			{
				$rejectionObj = new Rejection();
				$data = $rejectionObj->getCustomerWiseRejectionOrders($ext['fromDate'],$ext['toDate']);
				
				/*echo "<pre>";
				print_r($data);
				exit;*/	
				
				$this->render('dailyRejectionReport',array("data"=>$data,"ext"=>$ext));
				exit;
			}		
		}
		$this->render('dailyRejectionReport');	
	}
	
	function actionshowDailyPurchaseReports()
	{
		$this->isLogin();
		Yii::app()->session['current'] = 'reports';
		
		if(isset($_POST['submit']) && $_POST['type'] != "" && $_POST['fromDate'] != "" && $_POST['toDate'] != "")
		{
			$ext['type'] = $_POST['type'];
			$ext['fromDate'] = $_POST['fromDate'];
			$ext['toDate'] = $_POST['toDate'];
			
			$date = date("Y-m-d",strtotime($ext['order_date'])) ;
			
			if($_POST['type'] == 1)
			{
				$poDescObj = new PoDesc();
				$data = $poDescObj->getDailyProductPurchaseReport($ext['fromDate'],$ext['toDate']);
				
				/*echo "<pre>";
				print_r($data);
				exit;	
				*/
				$this->render('dailyPurchaseReport',array("data"=>$data,"ext"=>$ext));
				exit;
			}
			
			if($_POST['type'] == 2)
			{
				$poDetailsObj = new PoDetails();
				$data = $poDetailsObj->getDailyVendorPurchaseReport($ext['fromDate'],$ext['toDate']);
				
				/*echo "<pre>";
				print_r($data);
				exit;*/	
				
				$this->render('dailyPurchaseReport',array("data"=>$data,"ext"=>$ext));
				exit;
			}		
		}
		$this->render('dailyPurchaseReport');	
	}
	
	function actionshowDailyCollectionReports()
	{
		$this->isLogin();
		Yii::app()->session['current'] = 'reports';
		
		if(isset($_POST['submit']) && $_POST['type'] != "" && $_POST['fromDate'] != "" && $_POST['toDate'] != "")
		{
			$ext['type'] = $_POST['type'];
			$ext['fromDate'] = $_POST['fromDate'];
			$ext['toDate'] = $_POST['toDate'];
			
			$date = date("Y-m-d",strtotime($ext['order_date'])) ;
			
			if($_POST['type'] == 1)
			{
				$deliveryDescObj = new DeliveryDesc();
				$data = $deliveryDescObj->getDailyCollectionReport($ext['fromDate'],$ext['toDate']);
				
				/*echo "<pre>";
				print_r($data);
				exit;*/	
				
				$this->render('dailyCollectionReport',array("data"=>$data,"ext"=>$ext));
				exit;
			}
			
			if($_POST['type'] == 2)
			{
				$deliveryDescObj = new DeliveryDesc();
				$data = $deliveryDescObj->getDailyDriverWiseCollectionReport($ext['fromDate'],$ext['toDate']);
				
				/*echo "<pre>";
				print_r($data);
				exit;*/	
				
				$this->render('dailyCollectionReport',array("data"=>$data,"ext"=>$ext));
				exit;
			}		
		}
		$this->render('dailyCollectionReport');	
	}
	
	function actionshowDailyPackagingReports()
	{
		$this->isLogin();
		Yii::app()->session['current'] = 'reports';
		
		if(isset($_POST['submit']) && $_POST['date'] != "" && $_POST['date'] != "")
		{
			$ext['date'] = $_POST['date'];
			
			$date = date("Y-m-d",strtotime($ext['date'])) ;
			
			$soDescObj = new SoDesc();
			$soDescData = $soDescObj->getAllProductsForPackagingList($date);
			
			if(!empty($soDescData))
			{
				$this->actionraisePackagingReport($date,$soDescData);
			}else{
				Yii::app()->user->setFlash('error',"Record not found.");
				$this->render('dailyPackagingReport',array("date"=>$ext['date']));	
			}
		}
		$this->render('dailyPackagingReport');	
	}
	
	function actionraisePackagingReport($date,$soDescData)
	{
		//error_reporting(E_ALL);
		
		//$date = '2014-03-25';
		
		$html = "";

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
		<table width="100%" border="0" cellspacing="2" cellpadding="5">
		  <tr>
			<td align="left"><b>DELIVERY DATE:</b> '. date('F d, Y',strtotime($date)).'</td>
			<td align="right"><h3> <font color="#808080">DAILY PRODUCT PACKAGING REPORT</h3></td>
		  </tr>
		</table>
		<table width="100%" border="1" cellpadding="5"  cellspacing="0">';
		
		
		
		$packagingObj = new CategoryPackagingMaster();
		$packagingData = $packagingObj->getAllPackagingList();
		/*$soDescObj = new SoDesc();
		$soDescData = $soDescObj->getAllProductsForPackagingList($date);*/
		
		//echo "<pre>"; print_r($packagingData); exit;
		$html .= '<tr align="center" valign="middle">';
		$package = array();
		$productIds = array();
		$html .= '<td align="center" width="20%"><strong>PRODUCT</strong></td>';
		foreach($packagingData as $row)
		{
			$html .=  '<td align="center"><strong>'.$row['display_name'].'</strong></td>';
			$package[] = $row['packaging_scenario'];
			
		}
		$html .= '</tr>';
		
		
		$d=1;
		$i=0;
		
		foreach($soDescData as $product)
		{
			$key = array_search($product['product_id'],$productIds);
			if(empty($key) && $key == '')
			{
				$productIds[$d] = $product['product_id'];
			}
			else
			{
				$i = $i - 1;
			}
				$j=0;
				foreach($packagingData as $row)
				{
					if($row['packaging_scenario'] == $product['packaging_scenario'] && $row['pakaging_type'] == $product['unit_id'])
					{
						$package1[$i][$j]['totalPackets'] = $product['totalPackets'];
					}
					$package1[$i][$j]['product_name'] = $product['product_name'];
					$j++;
				}
				
			$i++;
			$d++;
		}
		$i=0;$j=0;
		foreach($package1 as $row)
		{
			
			$html .= '</tr><tr>';
			$html .=  '<td align="center" ><strong>'.$row[0]['product_name'].'</strong></td>';
			foreach($row as $col)
			{
				
				$totalpacket = 0;
				if(isset($col['totalPackets']))
				{
					$totalpacket = $col['totalPackets'];
				}
				
				$html .=  '<td align="right" ><strong>'.$totalpacket.'</strong></td>';
				
				$j++;
			}
			$i++;
		}
		
		$html .= '
		</table>
		</body>
		</html>';
		
		$randomStr = date("Y_m_d",strtotime($date));
		$filename = "deliveryPackagingReport_".$randomStr.".pdf";
				
		$mpdf = new mPDF('c', 'A4-L'); 
		$mpdf->WriteHTML($html);
		$mpdf->Output(FILE_PATH."assets/upload/pdf/".$filename, 'F');
		$mpdf->Output($filename, 'D');
		
		return true;
		
	}
	
	function actionshrinkStockQuantity()
	{
		$admin_id = Yii::app()->session['farmsourcing_adminUser'];
		
		$shrinkStock['product_id'] = $_REQUEST['product_id'];
		$shrinkStock['admin_id'] = $admin_id;
		$shrinkStock['system_qnt']	= $_REQUEST['systemQnt'];
		$shrinkStock['actual_qnt']	= $_REQUEST['realQnt'];
		$shrinkStock['qnt_difference']	= $_REQUEST['realQnt'] - $_REQUEST['systemQnt'];
		$shrinkStock['createdAt'] = date("Y-m-d H:i:s");
		$shrinkStock['modifiedAt'] = date("Y-m-d H:i:s");
		
		$shrinkStockObj = new ShrinkQuantity();
		$shrinkStockObj->setData($shrinkStock);
		$shrinkStockObj->insertData();
		
		$productData['quantity'] = $shrinkStock['actual_qnt'];
		$productData['modified_date'] = date("Y-m-d H:i:s");
		
		$productObj = new Product();
		$productObj->setData($productData);
		$productObj->insertData($shrinkStock['product_id']);
		echo true;
		exit;
		
	}
	
	function actionpromoCodesListing()
	{
		$title = "Promo Codes";
		Yii::app()->session['current']	=	'Promo Codes';
		
		$promocodesObj = new Promocodes();
		$promoCodesList = $promocodesObj->getAllPromoCodesList();
		
		$this->render('promocodesList',array('title' => $title,'promoCodesList' => $promoCodesList));	
	}
	
	function actioncouponEntry()
	{
		$title = "Coupon Entry";
		Yii::app()->session['current']	=	'Coupon Entry';
		
		$couponObj = new CouponMaster();
		$couponData = $couponObj->getAllAllocatedCoupons();
		
		$this->render('coupons',array('title' => $title,'couponData' => $couponData));	
	}
	
	function actioncouponAllocationEntry()
	{
		$title = "New Coupon Entry";
		Yii::app()->session['current']	=	'Coupon Entry';
		$this->render('couponAllocationEntry',array('title' => $title));	
	}
	
	function actionpromoCodeAllocationEntry()
	{
		$title = "New Promo Code Entry";
		Yii::app()->session['current']	=	'Promo Codes';
		$this->render('generatePromoCode',array('title' => $title));	
	}
	
	function actionpromocodeReturnEntry()
	{
		$title = "Return Promo Code";
		Yii::app()->session['current']	=	'Promo Codes';
		$this->render('promocodeReturnEntry',array('title' => $title));	
	}
	
	function actioncouponReturnEntry()
	{
		$title = "Coupon Entry for return";
		Yii::app()->session['current']	=	'Coupon Entry';
		$this->render('couponReturnEntry',array('title' => $title));	
	}
	
	
	function actionsaveCouponAllocation()
	{
		$couponObj =  new CouponMaster();
		$couponData = $couponObj->checkCouponNoName($_POST['coupon_number']);
		
		if(!empty($couponData))
		{
			Yii::app()->user->setFlash('error',"Coupon number already exist.");
			$title = "New Coupon Entry";
			Yii::app()->session['current']	=	'Coupon Entry';
			$this->render('couponAllocationEntry',array('title'=>$title,"couponData"=>$_POST));
			exit;
		}
		
		$data = array();
		$admin_id = Yii::app()->session['farmsourcing_adminUser'];
		$data['customer_id'] = $_POST['customer_id'];
		$data['coupon_number'] = $_POST['coupon_number'];
		$data['coupon_amount'] = $_POST['coupon_amount'];
		//$data['coupon_type'] = $_POST['promocode_type'];
		
		
		$data['admin_id'] = $admin_id;
		$data['status'] = 1;
		$data['createdAt'] = date("Y-m-d H:i:s");
		$data['modifiedAt'] = date("Y-m-d H:i:s");
		
		
		if(isset($_POST['id']) && $_POST['id']!= "")
		{
			unset($data['createdAt']);
			$couponObj =  new CouponMaster();
			$couponObj->setData($data);
			$couponObj->insertData($_POST['id']);
			Yii::app()->user->setFlash('success',"Successfully updated coupon.");
		}
		else
		{
			$couponObj =  new CouponMaster();
			$couponObj->setData($data);
			$couponObj->insertData();
			Yii::app()->user->setFlash('success',"Successfully allocate coupon.");
		}
		Yii::app()->session['current']	=	'Coupon Entry';
		$this->redirect(array("admin/couponEntry"));
		exit;
		
	}
	
	function actionsavePromocodeAllocation()
	{
		$data = array();
		$admin_id = Yii::app()->session['farmsourcing_adminUser'];
		//$data['customer_id'] = $_POST['customer_id'];
		$data['promocode_uniqueId'] = $_POST['promocode_uniqueId'];
		$data['promocode_amount'] = $_POST['promocode_amount'];
		$data['promocode_type'] = $_POST['promocode_type'];
		$data['admin_id'] = $admin_id;
		$data['isUsed'] = 0 ;
		$data['status'] = 1 ;
		$data['createdAt'] = date("Y-m-d H:i:s");
		$data['modifiedAt'] = date("Y-m-d H:i:s");
		
		
		if(isset($_POST['promocode_id']) && $_POST['promocode_id'] != "")
		{
			unset($data['createdAt']);
			
			$promocodesObj =  new Promocodes();
			$promocodesObj->setData($data);
			$promocodesObj->insertData($_POST['promocode_id']);
			Yii::app()->user->setFlash('success',"Successfully updated promo code.");
		}
		else
		{
			$promocodesObj =  new Promocodes();
			$promocodesData = $promocodesObj->checkPromocodeUniqueId($_POST['promocode_uniqueId']);
			
			if(!empty($promocodesData))
			{
				Yii::app()->user->setFlash('error',"Promo Code Id already exist.");
				$title = "New Promo Code Entry";
				Yii::app()->session['current']	=	'Promo Codes';
				$this->render('generatePromoCode',array('title'=>$title,"promocodeData"=>$_POST));
				exit;
			}
			
			$promocodesObj =  new Promocodes();
			$promocodesObj->setData($data);
			$promocodesObj->insertData();
			Yii::app()->user->setFlash('success',"Successfully allocate promo code.");
		}
		Yii::app()->session['current']	=	'Promo codes';
		$this->redirect(array("admin/promoCodesListing"));
		exit;
		
	}
	
	function actionsaveCouponReturnOld()
	{
		Yii::app()->session['current']	=	'Coupon Entry';
		$couponObj =  new CouponMaster();
		$couponData = $couponObj->getCouponData( $_POST['coupon_number'],$_POST['customer_id']);
		if(!empty($couponData))
		{
			$couponReturnObj =  new CouponTransactions();
			$couponTransactionData = $couponReturnObj->getTotalCountForAmount($couponData['id'],$_POST['customer_id']);
			
			
			if(empty($couponTransactionData['total_used_amount']))
			{
				$couponTransactionData['total_used_amount'] = 0;
			}
			
			if($couponData['coupon_amount'] > $couponTransactionData['total_used_amount'])
			{
				
					if($couponData['coupon_amount'] >= ($couponTransactionData['total_used_amount'] +$_POST['used_amount']))
					{
						
				
						$data = array();
						$admin_id = Yii::app()->session['farmsourcing_adminUser'];
						$data['customer_id'] = $_POST['customer_id'];
						$data['coupon_master_id'] = $couponData['id'];
						
						$data['used_amount'] = $_POST['used_amount'];
						$data['admin_id'] = $admin_id;
						$data['type'] = 1 ;
						$data['createdAt'] = date("Y-m-d H:i:s");
						$data['modifiedAt'] = date("Y-m-d H:i:s");
						$couponReturnObj =  new CouponTransactions();
						$couponReturnObj->setData($data);
						$couponReturnObj->insertData();
						Yii::app()->user->setFlash('success',"Successfully updated coupon return.");
						$this->redirect(array("admin/couponEntry"));
				
					}
					else
					{
						Yii::app()->user->setFlash('error',"Your entered invalid amount.");
						$this->redirect(array("admin/couponEntry"));
					}
				
			}
			else
			{
				Yii::app()->user->setFlash('error',"Your coupon is already used.");
				$this->redirect(array("admin/couponEntry"));
			}
		}
		else
		{
			Yii::app()->user->setFlash('error',"Invalid coupon number you entered.");
			$this->redirect(array("admin/couponEntry"));
		}
		exit;
		
	}
	
	
	function actionsaveCouponReturn()
	{
		Yii::app()->session['current']	=	'Coupon Entry';
		$couponObj =  new CouponMaster();
		$couponData = $couponObj->getCouponData( $_POST['coupon_number'],$_POST['customer_id']);
		if(!empty($couponData))
		{
			//echo $couponData['status']; exit;
			if($couponData['status'] == 1)
			{
				$couponReturnObj =  new CouponTransactions();
				$couponTransactionData = $couponReturnObj->getTotalCountForAmount($couponData['id'],$_POST['customer_id']);
				
				
				if(empty($couponTransactionData['total_used_amount']))
				{
					$couponTransactionData['total_used_amount'] = 0;
				}
				
				if($couponData['coupon_amount'] > $couponTransactionData['total_used_amount'])
				{
					
						if($couponData['coupon_amount'] >= ($couponTransactionData['total_used_amount'] +$_POST['used_amount']))
						{
							
					
							$data = array();
							$admin_id = Yii::app()->session['farmsourcing_adminUser'];
							$data['customer_id'] = $_POST['customer_id'];
							$data['coupon_master_id'] = $couponData['id'];
							
							$data['used_amount'] = $_POST['used_amount'];
							$data['admin_id'] = $admin_id;
							$data['type'] = 1 ;
							$data['createdAt'] = date("Y-m-d H:i:s");
							$data['modifiedAt'] = date("Y-m-d H:i:s");
							$couponReturnObj =  new CouponTransactions();
							$couponReturnObj->setData($data);
							$couponReturnObj->insertData();
							Yii::app()->user->setFlash('success',"Successfully updated coupon return.");
							$this->redirect(array("admin/couponEntry"));
					
						}
						else
						{
							Yii::app()->user->setFlash('error',"Your entered invalid amount.");
							$this->redirect(array("admin/couponEntry"));
						}
					
				}
				else
				{
					Yii::app()->user->setFlash('error',"Your coupon is already used.");
					$this->redirect(array("admin/couponEntry"));
				}
			}else{
				Yii::app()->user->setFlash('error',"Your coupon is deactivated by admin.");
				$this->redirect(array("admin/couponEntry"));
			}
		}
		else
		{
			Yii::app()->user->setFlash('error',"You entered invalid coupon number.");
			$this->redirect(array("admin/couponEntry"));
		}
		exit;
		
	}
	
	function actionsavePromoCodeReturn()
	{
		Yii::app()->session['current']	=	'Promo Codes';
		$promocodesObj =  new Promocodes();
		$promocodeData = $promocodesObj->checkPromocodeUniqueId($_POST['promocode_uniqueId']);
		if(!empty($promocodeData))
		{
			if($promocodeData['isUsed'] == 0)
			{
				if($promocodeData['status'] == 1)
				{
					$data['isUsed'] = 1 ;
					$data['modifiedAt'] = date("Y-m-d H:i:s");
					
					$promocodeObj =  new Promocodes();
					$promocodeObj->setData($data);
					$promocodeObj->insertData($promocodeData['promocode_id']);
							
					Yii::app()->user->setFlash('success',"Successfully updated promocode.");
					$this->redirect(array("admin/promoCodesListing"));
				}else{
					Yii::app()->user->setFlash('error',"Your promo code is deactivated by admin.");
					$this->redirect(array("admin/promoCodesListing"));
				}
			}else{
				Yii::app()->user->setFlash('error',"Your promo code is already used.");
				$this->redirect(array("admin/promoCodesListing"));
			}
		}
		else
		{
			Yii::app()->user->setFlash('error',"You entered invalid promocode id.");
			$this->redirect(array("admin/promoCodesListing"));
		}
		exit;
		
	}
	
	function actioneditCoupon()
	{
		$data = array();
		$title = "Update Coupon";
		$couponObj = new CouponMaster();
		$couponData = $couponObj->getCouponAllDataById($_GET['id']);
		
		$this->render("couponAllocationEntry",array('couponData'=>$couponData,'title'=>$title));
	}
	
	function actioneditPromoCode()
	{
		$data = array();
		$title = "Update Promo Code";
		$promocodeObj = new Promocodes();
		$promocodeData = $promocodeObj->getPromoCodeDataById($_GET['id']);
		
		$this->render("generatePromoCode",array('promocodeData'=>$promocodeData,'title'=>$title));
	}
	
	function actionshowCouponDetail()
	{
		if($_REQUEST['id'] == "")
		{
			echo 0;
			exit;	
		}
		else
		{
			$this->isLogin();
			
			$couponObj = new CouponMaster();
			$couponData = $couponObj->getCouponAllDataById($_REQUEST['id']);
			
			if(!empty($couponData))
			{
				$this->renderPartial("couponDetails",array("couponData"=>$couponData));
				exit;
			}
			else
			{
				echo 0;
				exit;
			}
		}
	}
	
	function actionshowPromoCodeDetail()
	{
		if($_REQUEST['id'] == "")
		{
			echo 0;
			exit;	
		}
		else
		{
			$this->isLogin();
			
			$promocodesObj = new Promocodes();
			$promocodeData = $promocodesObj->getPromoCodeDataById($_REQUEST['id']);
			
			if(!empty($promocodeData))
			{
				$this->renderPartial("promocodeDetails",array("promocodeData"=>$promocodeData));
				exit;
			}
			else
			{
				echo 0;
				exit;
			}
		}
	}
	
	function actionchangeCouponStatus()
	{	
		$this->isLogin();
		if(isset($_REQUEST['id']) && $_REQUEST['id'] != "")
		{
			$userId = $_REQUEST['id'];
		}else
		{
			$userId = "";	
		}
		//$couponObj = new CouponMaster();
		//$data    = $couponObj->getAdminDetailsById($userId);
		
		if($_REQUEST['status'] == 1)
		{
			$status = 0 ;	
		}else
		{
			$status = 1 ;	
		}
		
		$data = array();
		$data['status'] = $status;
		$data['modifiedAt'] = date("Y-m-d:H-i-s");
		
		/*$couponObj=CouponMaster::model()->findByPk($_REQUEST['id']);
		$couponObj->status=$status;
		$couponObj->modifiedAt=date("Y-m-d:H-m-s");
		$res =  $couponObj->save();*/
		
		$couponObj = new CouponMaster();
		$couponObj->setData($data);
		$couponObj->insertData($_REQUEST['id']);
		
		
		
		Yii::app()->user->setFlash('success', "Coupon status successfully changed.");
		$this->redirect(array("admin/couponEntry"));
		
	}
	
	function actionchangePromoCodeStatus()
	{	
		$this->isLogin();
		if(isset($_REQUEST['id']) && $_REQUEST['id'] != "")
		{
			$userId = $_REQUEST['id'];
		}else
		{
			$userId = "";	
		}
		//$couponObj = new CouponMaster();
		//$data    = $couponObj->getAdminDetailsById($userId);
		
		if($_REQUEST['status'] == 1)
		{
			$status = 0 ;	
		}else
		{
			$status = 1 ;	
		}
		
		$data = array();
		$data['status'] = $status;
		$data['modifiedAt'] = date("Y-m-d:H-i-s");
		
		/*$couponObj=CouponMaster::model()->findByPk($_REQUEST['id']);
		$couponObj->status=$status;
		$couponObj->modifiedAt=date("Y-m-d:H-m-s");
		$res =  $couponObj->save();*/
		
		$promocodesObj = new Promocodes();
		$promocodesObj->setData($data);
		$promocodesObj->insertData($_REQUEST['id']);
		
		
		
		Yii::app()->user->setFlash('success', "Promo code status successfully changed.");
		$this->redirect(array("admin/promoCodesListing"));
		
	}
	
	public function actiondeleteCoupon()
	{
		$this->isLogin();
		
		$couponObj = new CouponMaster();
		$couponObj->deleteCoupon($_REQUEST['id']);
		
		Yii::app()->user->setFlash("success","Coupon deleted successfully.");
		header('Location: ' . $_SERVER['HTTP_REFERER']);
	}
	
	public function actiondeletePromoCode()
	{
		$this->isLogin();
		
		$promocodeObj = new Promocodes();
		$promocodeObj->deletePromoCode($_REQUEST['id']);
		
		Yii::app()->user->setFlash("success","Promocode deleted successfully.");
		header('Location: ' . $_SERVER['HTTP_REFERER']);
	}
	
	function actionshowMonthlyCouponReports()
	{
		$this->isLogin();
		Yii::app()->session['current'] = 'reports';
		
		if(isset($_POST['submit']) && $_POST['type'] != "" && $_POST['fromDate'] != "" && $_POST['toDate'] != "")
		{
			$ext['type'] = $_POST['type'];
			$ext['fromDate'] = $_POST['fromDate'];
			$ext['toDate'] = $_POST['toDate'];
			
			$date = date("Y-m-d",strtotime($ext['order_date'])) ;
			
			if($_POST['type'] == 1)
			{
				$deliveryDescObj = new DeliveryDesc();
				$data = $deliveryDescObj->getDailyCouponReport($ext['fromDate'],$ext['toDate']);
				
				/*echo "<pre>";
				print_r($data);
				exit;*/	
				
				$this->render('dailyCouponReport',array("data"=>$data,"ext"=>$ext));
				exit;
			}
			
			if($_POST['type'] == 2)
			{
				$deliveryDescObj = new DeliveryDesc();
				$data = $deliveryDescObj->getDailyDriverWiseCouponReport($ext['fromDate'],$ext['toDate']);
				
				/*echo "<pre>";
				print_r($data);
				exit;*/	
				
				$this->render('dailyCouponReport',array("data"=>$data,"ext"=>$ext));
				exit;
			}		
		}
		$this->render('dailyCouponReport');	
	}
	
	function actionshowMonthlyCashReports()
	{
		$this->isLogin();
		Yii::app()->session['current'] = 'reports';
		
		if(isset($_POST['submit']) && $_POST['type'] != "" && $_POST['fromDate'] != "" && $_POST['toDate'] != "")
		{
			$ext['type'] = $_POST['type'];
			$ext['fromDate'] = $_POST['fromDate'];
			$ext['toDate'] = $_POST['toDate'];
			
			$date = date("Y-m-d",strtotime($ext['order_date'])) ;
			
			if($_POST['type'] == 1)
			{
				$deliveryDescObj = new DeliveryDesc();
				$data = $deliveryDescObj->getDailyCashReport($ext['fromDate'],$ext['toDate']);
				
				/*echo "<pre>";
				print_r($data);
				exit;*/	
				
				$this->render('dailyCashReport',array("data"=>$data,"ext"=>$ext));
				exit;
			}
			
			if($_POST['type'] == 2)
			{
				$deliveryDescObj = new DeliveryDesc();
				$data = $deliveryDescObj->getDailyDriverWiseCashReport($ext['fromDate'],$ext['toDate']);
				
				/*echo "<pre>";
				print_r($data);
				exit;*/	
				
				$this->render('dailyCashReport',array("data"=>$data,"ext"=>$ext));
				exit;
			}		
		}
		$this->render('dailyCashReport');	
	}
	
	function actionshowMonthlyCreditReports()
	{
		$this->isLogin();
		Yii::app()->session['current'] = 'reports';
		
		if(isset($_POST['submit']) && $_POST['type'] != "")
		{
			$ext['type'] = $_POST['type'];
			//$ext['fromDate'] = $_POST['fromDate'];
			//$ext['toDate'] = $_POST['toDate'];
			
			$date = date("Y-m-d",strtotime($ext['order_date'])) ;
			
			if($_POST['type'] == 1)
			{
				$deliveryDescObj = new DeliveryDesc();
				$data = $deliveryDescObj->getDailyCreditReport();
				
				/*echo "<pre>";
				print_r($data);
				exit;*/	
				
				$this->render('dailyCreditReport',array("data"=>$data,"ext"=>$ext));
				exit;
			}
			
			if($_POST['type'] == 2)
			{
				$deliveryDescObj = new DeliveryDesc();
				$data = $deliveryDescObj->getDailyDriverWiseCreditReport($ext['fromDate'],$ext['toDate']);
				
				/*echo "<pre>";
				print_r($data);
				exit;*/	
				
				$this->render('dailyCreditReport',array("data"=>$data,"ext"=>$ext));
				exit;
			}		
		}
		$this->render('dailyCreditReport');	
	}
	
}
//classs