<html><head>

<meta http-equiv="Content-Type" content="text/html" charset="utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">

<link rel="stylesheet" href="<?php echo Yii::app()->params->base_url; ?>css/main.css" type="text/css" />

<!--[if IE 8]><link href="css/ie8.css" rel="stylesheet" type="text/css" /><![endif]-->
<!--[if IE 9]><link href="css/ie9.css" rel="stylesheet" type="text/css" /><![endif]-->
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600,700' rel='stylesheet' type='text/css'>

<script src="<?php echo Yii::app()->params->base_url; ?>js/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->params->base_url; ?>js/jquery.google.1.7.2.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->params->base_url; ?>js/jquery.google.1.9.2.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->params->base_url; ?>js/plugins/charts/excanvas.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->params->base_url; ?>js/plugins/charts/jquery.flot.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->params->base_url; ?>js/plugins/charts/jquery.flot.resize.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->params->base_url; ?>js/plugins/charts/jquery.sparkline.min.js"></script>

<script type="text/javascript" src="<?php echo Yii::app()->params->base_url; ?>js/plugins/ui/jquery.easytabs.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->params->base_url; ?>js/plugins/ui/jquery.collapsible.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->params->base_url; ?>js/plugins/ui/jquery.mousewheel.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->params->base_url; ?>js/plugins/ui/prettify.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->params->base_url; ?>js/plugins/ui/jquery.bootbox.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->params->base_url; ?>js/plugins/ui/jquery.colorpicker.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->params->base_url; ?>js/plugins/ui/jquery.timepicker.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->params->base_url; ?>js/plugins/ui/jquery.jgrowl.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->params->base_url; ?>js/plugins/ui/jquery.fancybox.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->params->base_url; ?>js/plugins/ui/jquery.fullcalendar.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->params->base_url; ?>js/plugins/ui/jquery.elfinder.js"></script>

<script type="text/javascript" src="<?php echo Yii::app()->params->base_url; ?>js/plugins/uploader/plupload.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->params->base_url; ?>js/plugins/uploader/plupload.html4.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->params->base_url; ?>js/plugins/uploader/plupload.html5.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->params->base_url; ?>js/plugins/uploader/jquery.plupload.queue.js"></script>

<script type="text/javascript" src="<?php echo Yii::app()->params->base_url; ?>js/plugins/forms/jquery.uniform.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->params->base_url; ?>js/plugins/forms/jquery.autosize.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->params->base_url; ?>js/plugins/forms/jquery.inputlimiter.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->params->base_url; ?>js/plugins/forms/jquery.tagsinput.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->params->base_url; ?>js/plugins/forms/jquery.inputmask.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->params->base_url; ?>js/plugins/forms/jquery.select2.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->params->base_url; ?>js/plugins/forms/jquery.listbox.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->params->base_url; ?>js/plugins/forms/jquery.validation.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->params->base_url; ?>js/plugins/forms/jquery.validationEngine-en.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->params->base_url; ?>js/plugins/forms/jquery.form.wizard.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->params->base_url; ?>js/plugins/forms/jquery.form.js"></script>

<script type="text/javascript" src="<?php echo Yii::app()->params->base_url; ?>js/plugins/tables/jquery.dataTables.min.js"></script>

<script type="text/javascript" src="<?php echo Yii::app()->params->base_url; ?>js/files/bootstrap.min.js"></script>

<script type="text/javascript" src="<?php echo Yii::app()->params->base_url; ?>js/files/functions.js"></script>

<script type="application/javascript">
$(document).ready(function(){
	var msgBox	=	$('#msgbox');
	msgBox.click(function(){
		msgBox.fadeOut();
	});
});
</script>
<link rel="shortcut icon" href="<?php echo Yii::app()->params->base_url; ?>images/favicon.ico" />
<link rel="apple-touch-icon" href="<?php echo Yii::app()->params->base_url; ?>images/logo/apple-touch-icon.png" />
<title>Farm Sourcing - ADMIN PANEL</title>

</head>
<?php
	if(isset(Yii::app()->session['farmsourcing_adminUser']) && Yii::app()->session['farmsourcing_adminUser'] != ""){
		$adminObj = new Admin();
		$adminData = $adminObj->getAdminDetailsById(Yii::app()->session['farmsourcing_adminUser']);
	}

 if(!isset(Yii::app()->session['farmsourcing_adminUser'])){
		$class = "no-background" ;
	}else {
		$class = "";
	}
?>
<body class="<?php echo $class; ?>">
 <div id="loading" style="background-color:#6AA566;"></div>
    <?php if(!isset(Yii::app()->session['farmsourcing_adminUser'])){?>
        <!-- Fixed top -->
			<div id="top">
		<div class="fixed">
			<a href="<?php echo Yii::app()->params->base_path; ?>admin" class="logo"><img src="<?php echo Yii::app()->params->base_url ; ?>images/logo/logo.png" style="height: 40px;margin-top: -9px;width: 40px;" alt="" /></a>
			<ul class="top-menu">
				<li class="dropdown">
					<a class="login-top" data-toggle="dropdown"></a>
					<ul class="dropdown-menu pull-right">
						<?php /*?><li><a href="#" title=""><i class="icon-group"></i>Change user</a></li>
						<li><a href="#" title=""><i class="icon-plus"></i>New user</a></li>
						<li><a href="#" title=""><i class="icon-cog"></i>Settings</a></li><?php */?>
						<li><a href="<?php echo Yii::app()->params->base_path; ?>site" target="_blank"><i class="icon-remove"></i>Go to the website</a></li>
					</ul>
				</li>
			</ul>
		</div>
	</div>
		<!-- /fixed top -->
	<?php } else { ?>
    	<!-- Fixed top -->
       		<div id="top">
            <div class="fixed">
               <a href="<?php echo Yii::app()->params->base_path; ?>admin" title="" class="logo"><img src="<?php echo Yii::app()->params->base_url ; ?>images/logo/logo.png" style="height: 40px;margin-top: -9px;width: 40px;" alt="" /></a>
                <ul class="top-menu">
                    <li><a class="fullview"></a></li>
                    <li><a class="showmenu" title="Generate Sales Order" href="<?php echo Yii::app()->params->base_path; ?>admin/generateOrder"></a></li>
                    <!--<li><a href="#" title="" class="messages"><i class="new-message"></i></a></li>-->
                    <li class="dropdown">
                        <a class="user-menu" data-toggle="dropdown"><span>Howdy, <?php echo Yii::app()->session['firstName'] ; ?> ! <b class="caret"></b></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="<?php echo Yii::app()->params->base_path; ?>admin/myprofile" title=""><i class="fam-user-suit"></i>Profile</a></li>
                            <?php if(Yii::app()->session['type'] == 0) { ?>
                            <li><a href="<?php echo Yii::app()->params->base_path; ?>admin/companyProfile" title=""><i class="fam-house"></i>Company Profile</a></li>
                            <?php } ?>
                            <li><a href="<?php echo Yii::app()->params->base_path; ?>admin/changePassword" title=""><i class="fam-lock"></i>Change Password</a></li>
                            <?php /*?><li><a href="#" title=""><i class="fam-cog"></i>Settings</a></li><?php */?>
                            <li><a href="<?php echo Yii::app()->params->base_path; ?>admin/logout" title=""><img src="images/logout.png" />&nbsp;&nbsp;Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
        <!-- /fixed top -->
    <?php } ?>
    
    
<?php if(Yii::app()->user->hasFlash('success')): ?>	
<div class="alert alert-success">
    <button type="button" class="close" data-dismiss="alert">×</button>
    <b><?php echo Yii::app()->user->getFlash('success'); ?></b>
</div>							   
<?php endif; ?>
<?php if(Yii::app()->user->hasFlash('error')): ?>
<div class="alert alert-error">
    <button type="button" class="close" data-dismiss="alert">×</button>
   <b><?php echo Yii::app()->user->getFlash('error'); ?></b>
</div>
<?php endif; ?>


<div style="clear:both"></div>
    <?php if(isset(Yii::app()->session['farmsourcing_adminUser'])){?>
   		 <div id="container">
         <!-- Sidebar -->
			<div id="sidebar">

			<div class="sidebar-tabs">
		        <ul class="tabs-nav two-items">
		            <li style="width:100% !important;"><a href="#general" title=""><i class="icon-reorder"></i></a></li>
		            <?php /*?><li><a href="#stuff" title=""><i class="icon-cogs"></i></a></li><?php */?>
		        </ul>

		        <div id="general">

			        <!-- Sidebar user -->
			        <div class="sidebar-user widget">
						<div class="navbar"><div class="navbar-inner"><h6>Welcome, <?php echo Yii::app()->session['fullName'] ; ?>!</h6></div></div>
			            <a href="#" title="" class="user" style="margin-top:25px;"><?php if(isset($adminData['avatar']) && $adminData['avatar'] != "") { ?><img src="<?php echo Yii::app()->params->base_url; ?>assets/upload/avatar/<?php echo $adminData['avatar']; ?>" /><?php } else { ?><img src="http://placehold.it/210x110" alt="" /><?php } ?></a>
			            
			        </div>
			        <!-- /sidebar user -->

			        <!-- Main navigation -->
			        <ul class="navigation widget">
                   
			            <?php /*?><li <?php if(isset(Yii::app()->session['current']) && Yii::app()->session['current'] == "dashboard") { ?>class="active"<?php } ?>><a href="<?php echo Yii::app()->params->base_path; ?>admin" title="Go to dashboard"><i class="icon-home"></i>Dashboard</a></li><?php */?>
                     <?php if(Yii::app()->session['type'] == 0 || Yii::app()->session['type'] == 2  || Yii::app()->session['type'] == 3 ) {  ?>
                        <li <?php if(isset(Yii::app()->session['current']) && Yii::app()->session['current'] == "orders") { ?>class="active"<?php } ?>><a href="<?php echo Yii::app()->params->base_path; ?>admin/salesOrderListing" title="See All Order List"><i class="icon-th"></i>Sales Orders</a></li>
                          <?php } ?>
                        
                      	<?php if(Yii::app()->session['type'] == 0 ) {  ?>  
			            <li <?php if(isset(Yii::app()->session['current']) && Yii::app()->session['current'] == "users") { ?>class="active"<?php } ?>><a href="<?php echo Yii::app()->params->base_path; ?>admin/userListing" title="All Users"><i class="icon-reorder"></i>Users<!--<strong>3</strong>--></a>
			            </li>
                      <?php } ?> 
                        
                       <?php if(Yii::app()->session['type'] == 0 || Yii::app()->session['type'] == 1 ) {  ?>  
                         <li <?php if(isset(Yii::app()->session['current']) && Yii::app()->session['current'] == "zone") { ?>class="active"<?php } ?>><a href="<?php echo Yii::app()->params->base_path; ?>admin/zoneListing" title="All Zone List" ><i class="icon-sitemap"></i>Zone List</a>
			            </li>
                       <?php } ?> 
                       
                       <?php if(Yii::app()->session['type'] == 0 || Yii::app()->session['type'] == 1 ) {  ?>
                       <li <?php if(isset(Yii::app()->session['current']) && Yii::app()->session['current'] == "vendors") { ?>class="active"<?php } ?>><a href="<?php echo Yii::app()->params->base_path; ?>admin/vendorListing" title="All Vendors List" ><i class="icon-sitemap"></i>Vendor List</a>
			            </li>
                         <?php } ?> 
                         
                         <?php if(Yii::app()->session['type'] == 0 || Yii::app()->session['type'] == 1 ) {  ?>
                         <li <?php if(isset(Yii::app()->session['current']) && Yii::app()->session['current'] == "category") { ?>class="active"<?php } ?>><a href="<?php echo Yii::app()->params->base_path; ?>admin/categoryListing" title="See Categories" ><i class="icon-sitemap"></i>Categroies</a>
			            </li>
                        <?php } ?> 
                        
                        <?php if(Yii::app()->session['type'] == 0 || Yii::app()->session['type'] == 1 ) {  ?>
                        <li <?php if(isset(Yii::app()->session['current']) && Yii::app()->session['current'] == "Category Packaging") { ?>class="active"<?php } ?>><a href="<?php echo Yii::app()->params->base_path; ?>admin/categoryPackagingListing" title="See Categories" ><i class="icon-sitemap"></i>Categroies Packaging</a>
			            </li>
                         <?php } ?> 
                        
                         <?php if(Yii::app()->session['type'] == 0 || Yii::app()->session['type'] == 1 ) {  ?>
                        <li <?php if(isset(Yii::app()->session['current']) && Yii::app()->session['current'] == "product") { ?>class="active"<?php } ?>><a href="<?php echo Yii::app()->params->base_path; ?>admin/productListing" title="See Products" ><i class="icon-sitemap"></i>Products</a>
			            </li>
                        <?php } ?> 
                        
                        <?php if(Yii::app()->session['type'] == 0 || Yii::app()->session['type'] == 1 ) {  ?>
                        <li <?php if(isset(Yii::app()->session['current']) && Yii::app()->session['current'] == "product_price") { ?>class="active"<?php } ?>><a href="<?php echo Yii::app()->params->base_path; ?>admin/productPriceListing" title="See Products Price" ><i class="icon-sitemap"></i>Products Price</a>
			            </li>
                        <?php } ?>
                        
                        <?php if(Yii::app()->session['type'] == 0 || Yii::app()->session['type'] == 1 ) {  ?>
                         <li <?php if(isset(Yii::app()->session['current']) && Yii::app()->session['current'] == "Profit Percentage") { ?>class="active"<?php } ?>><a href="<?php echo Yii::app()->params->base_path; ?>admin/profitPercentageListing" title="See Profit Percentage" ><i class="icon-sitemap"></i>Profit Percentage</a>
			            </li>
                        <?php } ?>
                        <?php if(Yii::app()->session['type'] == 0 || Yii::app()->session['type'] == 1 ) {  ?>
                       <li <?php if(isset(Yii::app()->session['current']) && Yii::app()->session['current'] == "shrink") { ?>class="active"<?php } ?>><a href="<?php echo Yii::app()->params->base_path; ?>admin/shrinkListing" title="All Shrink Data"><i class="icon-indent-right"></i>Shrink Listing</a>
			            </li>
                      <?php } ?>
                        
                       <?php if(Yii::app()->session['type'] == 0 || Yii::app()->session['type'] == 1 ) {  ?>
                        <li <?php if(isset(Yii::app()->session['current']) && Yii::app()->session['current'] == "customer") { ?>class="active"<?php } ?>><a href="<?php echo Yii::app()->params->base_path; ?>admin/customerListing" title="All Customers"><i class="icon-reorder"></i>Customers<!--<strong>3</strong>--></a>
			            </li>
                       <?php } ?>
                        
                        <?php if(Yii::app()->session['type'] == 0 || Yii::app()->session['type'] == 2  || Yii::app()->session['type'] == 3 ) {  ?> 
                        <li <?php if(isset(Yii::app()->session['current']) && Yii::app()->session['current'] == "customer collection") { ?>class="active"<?php } ?>><a href="<?php echo Yii::app()->params->base_path; ?>admin/CollectionEntry" title="Customer collection"><i class="icon-reorder"></i>Customer Collection<!--<strong>3</strong>--></a>
			            </li>
                        
                        <li <?php if(isset(Yii::app()->session['current']) && Yii::app()->session['current'] == "Coupon Entry") { ?>class="active"<?php } ?>><a href="<?php echo Yii::app()->params->base_path; ?>admin/couponEntry" title="Coupon Allocation"><i class="icon-reorder"></i>Coupons<!--<strong>3</strong>--></a>
			            </li>
                        <?php } ?>
                        
                           <?php if(Yii::app()->session['type'] == 0 || Yii::app()->session['type'] == 3 ) {  ?>
                         <li <?php if(isset(Yii::app()->session['current']) && Yii::app()->session['current'] == "PO Generation") { ?>class="active"<?php } ?>><a href="<?php echo Yii::app()->params->base_path; ?>admin/purchaseOrderListing" title="PO Generation"><i class="icon-indent-right"></i>PO List</a>
			            </li>
                       <?php } ?>
                       
                        <?php if(Yii::app()->session['type'] == 0 || Yii::app()->session['type'] == 3 ) {  ?>
                        <li <?php if(isset(Yii::app()->session['current']) && Yii::app()->session['current'] == "GRN") { ?>class="active"<?php } ?>><a href="<?php echo Yii::app()->params->base_path; ?>admin/goodsReciept" title="Good Reciept Module"><i class="icon-indent-right"></i>Goods Reciept</a>
			            </li>
                        <?php } ?>
                        
                        <?php if(Yii::app()->session['type'] == 0 || Yii::app()->session['type'] == 3 ) {  ?>
                        <li <?php if(isset(Yii::app()->session['current']) && Yii::app()->session['current'] == "Rejection List") { ?>class="active"<?php } ?>><a href="<?php echo Yii::app()->params->base_path; ?>admin/rejectionListing" title="Rejection List"><i class="icon-indent-right"></i>Rejection List</a>
			            </li>
                         <?php } ?>
                        
                        <?php if(Yii::app()->session['type'] == 0 || Yii::app()->session['type'] == 3 ) {  ?>
			            <li <?php if(isset(Yii::app()->session['current']) && Yii::app()->session['current'] == "Delivery List") { ?>class="active"<?php } ?>><a href="<?php echo Yii::app()->params->base_path; ?>admin/generateDeliveryReport" title="All Delivery List"><i class="icon-indent-right"></i>Delivery List</a>
			            </li>
                        <?php } ?>
                        
                        <?php if(Yii::app()->session['type'] == 0 || Yii::app()->session['type'] == 3 ) {  ?>
                         <li <?php if(isset(Yii::app()->session['current']) && Yii::app()->session['current'] == "Delivery Slips") { ?>class="active"<?php } ?>><a href="<?php echo Yii::app()->params->base_path; ?>admin/deliveryListing" title="All Delivery Slips"><i class="icon-indent-right"></i>Delivery Slips</a>
			            </li>
                         <?php } ?>
                        
                        <?php /*?><?php if(Yii::app()->session['type'] == 0 || Yii::app()->session['type'] == 3 ) {  ?>
                        <li <?php if(isset(Yii::app()->session['current']) && Yii::app()->session['current'] == "journalEntry") { ?>class="active"<?php } ?>><a href="<?php echo Yii::app()->params->base_path; ?>admin/showJournalEntry" title="Journal Entry For All"><i class="icon-indent-right"></i>Journal Entry</a>
			            </li>
                        <?php } ?><?php */?>
                      
                      <?php if(Yii::app()->session['type'] == 0 || Yii::app()->session['type'] == 3 ) {  ?>
                       <li <?php if(isset(Yii::app()->session['current']) && Yii::app()->session['current'] == "reports") { ?>class="active"<?php } ?>><a href="<?php echo Yii::app()->params->base_path; ?>admin/showReports" title="All Reports"><i class="icon-indent-right"></i>Reports</a>
			            </li>
                      <?php } ?>
                      
                      <?php if(Yii::app()->session['type'] == 0 || Yii::app()->session['type'] == 3 ) {  ?>
                       <li <?php if(isset(Yii::app()->session['current']) && Yii::app()->session['current'] == "export") { ?>class="active"<?php } ?>><a href="<?php echo Yii::app()->params->base_path; ?>admin/showExportData" title="Export Transaction Data"><i class="icon-indent-right"></i>Export Data</a>
			            </li>
                      <?php } ?>
			           
			        </ul>
			        <!-- /main navigation -->

		        </div>

		     

		    </div>
		</div>
		<!-- /sidebar -->
        <?php echo $content; ?>
        </div>
    <?php } else { ?>
     <?php echo $content; ?>
    <?php } ?>
        
    
	<!-- Footer -->
	<div id="footer" align="center">
		<div class="copyrights" style="float:none !important;">Copyright &copy; 2013, Farm Sourcing, All Rights Reserved.</div>
		<!--<ul class="footer-links">
			<li><a href="" title=""><i class="icon-cogs"></i>Contact admin</a></li>
			<li><a href="" title=""><i class="icon-screenshot"></i>Report bug</a></li>
		</ul>-->
	</div>
	<!-- /footer -->
</body>
</html>