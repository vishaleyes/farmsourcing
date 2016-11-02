<?php
error_reporting(0); 
require_once(FILE_PATH."/protected/extensions/mpdf/mpdf.php");
date_default_timezone_set("Asia/Kolkata");
/*define('APPKEY','11jRMF_oT3SiQpdvsm1bhg'); 

define('PUSHSECRET','cJK6ie3USkaZppjzIGgHSg'); // Master Secret
// clients urban airhship details

define('PUSHURL','https://go.urbanairship.com/api/push/');

define('IMGURL',"http://".$_SERVER['HTTP_HOST']."/carmode/");*/


class ApiController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	
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
	
	function beforeAction($action=NULL) 
	{
		if(Yii::app()->controller->action->id !="showLogs" && Yii::app()->controller->action->id !="clearLogs")
		{
		$fp = fopen('farmsource.txt', 'a+');
		fwrite($fp, "\r\r\n<div style='background-color:#F2F2F2; color:#222279; font-weight: bold; padding:10px;box-shadow: 0 5px 2px rgba(0, 0, 0, 0.25);'>");
		fwrite($fp,"<b>Function Name</b> : <font size='6' style='color:orange;'><b><i>".Yii::app()->controller->action->id."</i></b></font>" );
		fwrite($fp, "\r\r\n\n");
		fwrite($fp, "<b>PARAMS</b> : " .print_r($_REQUEST,true));
		fwrite($fp, "\r\r\n");
		$link = "http://". $_SERVER['HTTP_HOST'].''.print_r($_SERVER['REQUEST_URI'],true)."";
		fwrite($fp, "<b>URL</b> :<a style='text-decoration:none;color:#4285F4' target='_blank' href='".$link."'> http://" . $_SERVER['HTTP_HOST'].''.print_r($_SERVER['REQUEST_URI'],true)."</a>");
		fwrite($fp, "</div>\r\r\n");
		fclose($fp);
		
		}
		return true;
	}
	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	*/
	public function actionIndex()
	{	
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		$this->renderPartial('apilist');
	}
	
	public function actionlogin()
	{
		if(!empty($_REQUEST) && isset($_REQUEST['email']) && $_REQUEST['email']!='' && isset($_REQUEST['password']) && $_REQUEST['password']!='')
		{
			$data=array();
			$data['email'] 	= $_REQUEST['email'];
			$data['password'] 	= $_REQUEST['password'];
			
			$adminObj	=	new Admin();
			$admin_data	=	$adminObj->getAdminDetailsByEmail($data['email']);
			
			$generalObj	=	new General();
			$isValid	=	$generalObj->validate_password($data['password'], $admin_data['password']);
			
			if($isValid === true)
			{
				//if($admin_data['isVerified'] == 1)
				//{
					$abc= array("a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z",
											"A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z",
											"0", "1", "2", "3", "4", "5", "6", "7", "8", "9");
					$sessionId1 = $abc[rand(0,61)].$abc[rand(0,61)].$abc[rand(0,61)].$abc[rand(0,61)].$abc[rand(0,61)].$abc[rand(0,61)].$abc[rand(0,61)].$abc[rand(0,61)];
					$sessionId2 = $sessionId1.$abc[rand(0,61)].$abc[rand(0,61)].$abc[rand(0,61)].$abc[rand(0,61)].$abc[rand(0,61)].$abc[rand(0,61)].$abc[rand(0,61)].$abc[rand(0,61)];
					$sessionId3 = $sessionId2.$abc[rand(0,61)].$abc[rand(0,61)].$abc[rand(0,61)].$abc[rand(0,61)].$abc[rand(0,61)].$abc[rand(0,61)].$abc[rand(0,61)].$abc[rand(0,61)];
					$sessionId4 = $sessionId3.$abc[rand(0,61)].$abc[rand(0,61)].$abc[rand(0,61)].$abc[rand(0,61)].$abc[rand(0,61)].$abc[rand(0,61)].$abc[rand(0,61)].$abc[rand(0,61)];
					$sessionId5 = $sessionId4.$abc[rand(0,61)].$abc[rand(0,61)].$abc[rand(0,61)].$abc[rand(0,61)].$abc[rand(0,61)].$abc[rand(0,61)].$abc[rand(0,61)].$abc[rand(0,61)];
					$sessionId6 = $sessionId5.$abc[rand(0,61)].$abc[rand(0,61)].$abc[rand(0,61)].$abc[rand(0,61)].$abc[rand(0,61)].$abc[rand(0,61)].$abc[rand(0,61)].$abc[rand(0,61)];
					$sessionId7 = $sessionId6.$abc[rand(0,61)].$abc[rand(0,61)].$abc[rand(0,61)].$abc[rand(0,61)].$abc[rand(0,61)].$abc[rand(0,61)].$abc[rand(0,61)].$abc[rand(0,61)];
					$sessionId = $sessionId7.$abc[rand(0,61)].$abc[rand(0,61)].$abc[rand(0,61)].$abc[rand(0,61)].$abc[rand(0,61)].$abc[rand(0,61)].$abc[rand(0,61)].$abc[rand(0,61)];
					$adminDetail['sessionId'] = $sessionId;
					
					
					$adminObj = new Admin();
					$adminObj->setData($adminDetail);
					$adminObj->insertData($admin_data['id']);
					
					$data = $adminObj->getAdminDetailsById($admin_data['id']);
					
					$result['status'] = 1;
					$result['message'] = "Success";
					$result['data'] = $data ;
					
					echo json_encode($result);	
				//}
				//else
				//{
				//	echo json_encode(array('status'=>'0','message'=>'User not verified.'));
				//}
			}
			else
			{
				echo json_encode(array('status'=>'0','message'=>'Invalid email or password.'));
			}
		}
		else
		{
			echo json_encode(array('status'=>'0','message'=>'permision Denied'));
		}
	}
	
	public function actionlogout()
	{
		if(!empty($_REQUEST) && isset($_REQUEST['userId']) && $_REQUEST['userId']!='' && isset($_REQUEST['sessionId']) && $_REQUEST['sessionId']!='')
		{
			$adminObj = new Admin();
			$user = $adminObj->checksession($_REQUEST['userId'],$_REQUEST['sessionId']);
			if(!empty($user))
			{
				$user=Admin::model()->findByPk($_REQUEST['userId']);
				$user->sessionId='';
				$res =  $user->save(); // save the change to database
				if($res ==  1)
				{
					echo json_encode(array('status'=>'1','message'=>'Successfully Logged Out.'));
				}
				else
				{
					echo json_encode(array('status'=>'0','error'=>'Invalid Parameters.'));
				}
			}
			else
			{
				echo json_encode(array('status'=>'0','error'=>'Invalid Sesssion.'));
			}
		}
		else
		{
			echo json_encode(array('status'=>'-1','error'=>'permision Denied'));
		}
	}
	
	public function actionuploadDataOnServer()
	{
		if(!empty($_REQUEST) && isset($_REQUEST['userId']) && $_REQUEST['userId']!='' 
							&& isset($_REQUEST['sessionId']) && $_REQUEST['sessionId']!=''
							&&  isset($_REQUEST['jsonString']) && $_REQUEST['jsonString']!='')
		{
			$adminObj = new Admin();
			$user = $adminObj->checksession($_REQUEST['userId'],$_REQUEST['sessionId']);
			if(!empty($user))
			{
				$queryArray = json_decode($_REQUEST['jsonString']);
				$errorQuery = array();
				$i=0;
				$Ids = array();
				$idArray = array();
				foreach ($queryArray as $item) 
				{
					 try{
						$adminObj = new Admin();
						$status = $adminObj->uploadDataOnServer($item->query);
						
						if($item->tableName == "so_details")
						{
							$soDetailObj = new SoDetails();
							$soData = $soDetailObj->getsalesOrderData($status);
							
							$idArray['so_id'] = $soData['so_id'];
							$idArray['mob_so_id'] = $soData['mob_so_id'];
							$Ids = $idArray;
							$result['idArray'][] = $Ids;
						}
						
						if($item->tableName == "so_desc")
						{
							$sodescObj = new SoDesc();
							$soDescData = $sodescObj->getSoDescDetailsById($status);
							
							$idArray['id'] = $soDescData['id'];
							$idArray['so_id'] = $soDescData['so_id'];
							$idArray['mob_so_id'] = $soDescData['mob_so_id'];
							$Ids = $idArray;
							$result['idArray'][] = $Ids;
						}
						
						if($item->tableName == "rejection")
						{
							$rejectionObj = new Rejection();
							$rejectionData = $rejectionObj->getRejectionData($status);
							$idArray['rejection_id'] = $rejectionData['rejection_id'];
							$idArray['mob_rejection_id'] = $rejectionData['mob_rejection_id'];
							$Ids = $idArray;
							$result['idArray'][] = $Ids;
						}
						
						if($item->tableName == "rejection_desc")
						{
							$RejectionDescObj = new RejectionDesc();
							$rejectionDescData = $RejectionDescObj->getRejectionDescDetailsById($status);
							$idArray['id'] = $rejectionDescData['id'];
							$idArray['rejection_id'] = $rejectionDescData['rejection_id'];
							$idArray['mob_rejection_id'] = $rejectionDescData['mob_rejection_id'];
							$Ids = $idArray;
							$result['idArray'][] = $Ids;
						}
						
						if($item->tableName == "coupon_master")
						{
							$couponMasterObj = new CouponMaster();
							$couponData = $couponMasterObj->getCouponDataById($status);
							$idArray['id'] = $couponData['id'];
							$idArray['mob_coupon_master_id'] = $couponData['mob_coupon_master_id'];
							$Ids = $idArray;
							$result['idArray'][] = $Ids;
						}
						
						if($item->tableName == "coupon_transactions")
						{
							$couponTransactionsObj = new CouponTransactions();
							$couponTransactionsData = $couponTransactionsObj->getCouponTransactionDataById($status);
							$idArray['coupon_return_id'] = $couponTransactionsData['coupon_return_id'];
							$idArray['mob_coupon_return_id'] = $couponTransactionsData['mob_coupon_return_id'];
							$idArray['coupon_master_id'] = $couponTransactionsData['coupon_master_id'];
							$idArray['mob_coupon_master_id'] = $couponTransactionsData['mob_coupon_master_id'];
							$Ids = $idArray;
							$result['idArray'][] = $Ids;
						}
						
					}catch(Exception $e)
					{
						if(isset($item->id) && $item->id != "")
						{
							$errorQuery[$i]['id'] =  $item->id ;	
						}else{
							$errorQuery[$i]['columnName'] =  $item->columnName ;
							$errorQuery[$i]['value'] =  $item->value ;
							$errorQuery[$i]['tableName'] =  $item->tableName ;
						}
						$i++;
					}
				}
					$result['status'] = 1;
					$result['message'] = "Data successfully inserted.";
					$result['errorQuery'] = $errorQuery;
					echo json_encode($result);
			}
			else
			{
				echo json_encode(array('status'=>'0','error'=>'Invalid Sesssion.'));
			}
		}
		
		else
		{
			echo json_encode(array('status'=>'-1','error'=>'permision Denied'));
		}
	}
	
	public function actiondownloadDataFromServer()
	{
		if(!empty($_REQUEST) && isset($_REQUEST['userId']) && $_REQUEST['userId']!='' 
							&& isset($_REQUEST['sessionId']) && $_REQUEST['sessionId']!=''
							&& isset($_REQUEST['modifiedAt']) && $_REQUEST['modifiedAt']!='' 
			 				&& isset($_REQUEST['tableName']) && $_REQUEST['tableName']!='')
		{
			$adminObj = new Admin();
			$user = $adminObj->checksession($_REQUEST['userId'],$_REQUEST['sessionId']);
			if(!empty($user))
			{
				if($_REQUEST['tableName'] == "category" || $_REQUEST['tableName'] == "category_packaging_master" || $_REQUEST['tableName'] == "currency" || $_REQUEST['tableName'] == "customers"  || $_REQUEST['tableName'] == "unit"  || $_REQUEST['tableName'] == "po_details"  || $_REQUEST['tableName'] == "po_desc"  || $_REQUEST['tableName'] == "rejection_desc" || $_REQUEST['tableName'] == "zone")
				{
					$adminObj = new Admin();
					$data = $adminObj->downloadDataFromServerWithoutUserId($_REQUEST['tableName'],$_REQUEST['modifiedAt']);
				}else if($_REQUEST['tableName'] == "product"){
					$adminObj = new Admin();
					$data = $adminObj->downloadDataFromServerOfProduct($_REQUEST['tableName'],$_REQUEST['modifiedAt']);	
				}else if($_REQUEST['tableName'] == "delivery_details"){
					$adminObj = new Admin();
					$data = $adminObj->downloadDeliveryDetails($_REQUEST['tableName'],$_REQUEST['modifiedAt'],$_REQUEST['userId']);	
				}else if($_REQUEST['tableName'] == "delivery_desc"){
					$adminObj = new Admin();
					$data = $adminObj->downloadDeliveryDescDetails($_REQUEST['modifiedAt'],$_REQUEST['userId']);	
				}else if($_REQUEST['tableName'] == "delivery_order_desc"){
					$adminObj = new Admin();
					$data = $adminObj->downloadDeliveryOrderDetails($_REQUEST['modifiedAt'],$_REQUEST['userId']);	
				}else{
					$adminObj = new Admin();
					$data = $adminObj->downloadDataFromServer($_REQUEST['tableName'],$_REQUEST['modifiedAt'],$_REQUEST['userId']);	
				}
				$result['status'] = 1;
				$result['message'] = "Data successfully downloaded.";
				$result['data'] = $data;
				$result['tableName'] = $_REQUEST['tableName'];

				echo json_encode($result);
			}
			else
			{
				echo json_encode(array('status'=>'0','error'=>'Invalid Sesssion.'));
			}
		}
		else
		{
			echo json_encode(array('status'=>'-1','error'=>'permision Denied'));
		}
	}
	
	function actionshowLogs()
	{
		$handle = @fopen("farmsource.txt", "r");
		if ($handle) {
   		 while (($buffer = fgets($handle, 4096)) !== false) {
        	echo $buffer;
			echo "<br>";
    		}
    	if (!feof($handle)) {
        	echo "Error: unexpected fgets() fail\n";
    	}
		}
    	fclose($handle);
	}

	function actionclearLogs()
	{
		$handle = fopen("farmsource.txt", "w");
		fwrite($handle, '');
		fclose($handle);
	}
}