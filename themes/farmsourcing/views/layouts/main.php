<html><head>

<meta http-equiv="Content-Type" content="text/html" charset="utf-8"/>


<link rel="shortcut icon" href="<?php echo Yii::app()->params->base_url; ?>images/logo/logo.png" />
<link rel="apple-touch-icon" href="<?php echo Yii::app()->params->base_url; ?>images/logo/apple-touch-icon.png" />

<link href="images/ico.png" rel="shortcut icon">
<title>Fresh n Pack - Online Shop </title>


<!-- Animations -->
<link href="<?php echo Yii::app()->params->base_url; ?>css/common.css" rel="stylesheet" type="text/css"/>

<!-- Custom styles for this template -->
<link href="<?php echo Yii::app()->params->base_url; ?>css/custom.css" rel="stylesheet" type="text/css" />

<!-- Color -->
<link href="<?php echo Yii::app()->params->base_url; ?>css/skin/color.css" id="colorstyle" rel="stylesheet">




<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]> <script src="js/html5shiv.js"></script> <script src="js/respond.min.js"></script> <![endif]-->
<script src="<?php echo Yii::app()->params->base_url; ?>js/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->params->base_url; ?>js/jquery.google.1.7.2.min.js"></script>

<!-- Bootstrap core JavaScript -->
<script src="<?php echo Yii::app()->params->base_url; ?>js/jquery-1.10.2.min.js"></script>
<script src="<?php echo Yii::app()->params->base_url; ?>js/bootstrap.min.js"></script>
<script src="<?php echo Yii::app()->params->base_url; ?>js/bootstrap-select.js"></script>

<!-- Custom Scripts -->
<script src="<?php echo Yii::app()->params->base_url; ?>js/scripts.js"></script>

<!-- MegaMenu -->
<script src="<?php echo Yii::app()->params->base_url; ?>js/menu3d.js" type="text/javascript"></script>

<!-- iView Slider -->
<script src="<?php echo Yii::app()->params->base_url; ?>js/raphael-min.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->params->base_url; ?>js/jquery.easing.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->params->base_url; ?>js/iview.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->params->base_url; ?>js/retina-1.1.0.min.js" type="text/javascript"></script>

<!--Start of Zopim Live Chat Script-->
<script type="text/javascript">
window.$zopim||(function(d,s){var z=$zopim=function(c){z._.push(c)},$=z.s=
d.createElement(s),e=d.getElementsByTagName(s)[0];z.set=function(o){z.set.
_.push(o)};z._=[];z.set._=[];$.async=!0;$.setAttribute('charset','utf-8');
$.src='//v2.zopim.com/?1skTujY0CItrGrQpYJZC4JV2yAUttykk';z.t=+new Date;$.
type='text/javascript';e.parentNode.insertBefore($,e)})(document,'script');
</script>
<!--End of Zopim Live Chat Script-->
</head>
<body>
 
 <!-- Header -->
<header> 
  <!-- Top Heading Bar -->
  <div class="container">
    <div class="row">
     
      <div class="col-md-12">
       
        <div class="topheadrow">
        
          <ul class="nav nav-pills pull-right">
          <?php if(isset(Yii::app()->session['farmsoucing_userId']) && Yii::app()->session['farmsoucing_userId'] != "" ){ ?>
            <li> <a href="<?php echo Yii::app()->params->base_path;?>user/changePassword"> <i class="fa fa-gears fa-fw"></i> <span class="hidden-xs">Change Password</span></a> </li>
            <?php } ?>
          <?php if(!Yii::app()->session['farmsoucing_userId']){ ?>
            
            <li> <a href="<?php echo Yii::app()->params->base_path;?>site/cart"> <i class="fa fa-shopping-cart fa-fw"></i> <span class="hidden-xs">My Cart</span></a> </li>
            <?php } else { ?>
            <li> <a href="<?php echo Yii::app()->params->base_path;?>user/orderHistoryListing/"> <i class="fa fa-book"></i> <span class="hidden-xs">Order History</span></a> </li>
            <li> <a href="<?php echo Yii::app()->params->base_path;?>user/cart"> <i class="fa fa-shopping-cart fa-fw"></i> <span class="hidden-xs">My Cart</span></a> </li>
            <?php } ?>
            <!--<li> <a href="#a"> <i class="fa fa-heart fa-fw"></i> <span class="hidden-xs">Wishlist(0)</span></a> </li>-->
            <?php if(!Yii::app()->session['farmsoucing_userId']){ ?>
            <li class="dropdown"> <a class="dropdown-toggle" data-hover="dropdown" data-toggle="dropdown" href="#a"> <i class="fa fa-user fa-fw"></i> <span class="hidden-xs"> Login</span></a>
              <div class="loginbox dropdown-menu"> <span class="form-header">Login</span>
                <form role="form" action="<?php echo Yii::app()->params->base_path;?>site/login" method="post">
                  <div class="form-group"> <i class="fa fa-user fa-fw"></i>
                    <input class="form-control" id="InputUserName" placeholder="Mobile No" name="mobile_no" type="text">
                  </div>
                  <div class="form-group"> <i class="fa fa-lock fa-fw"></i>
                    <input class="form-control" id="InputPassword" placeholder="Password" name="password" type="password">
                  </div>
                  <?php /*?><div class="form-group">
                  <a href="<?php echo Yii::app()->params->base_path; ?>site/forgotPassword" style=" margin-left:-14px;"><span class="hidden-xs">Forgot Password</span></a>
                  </div><?php */?>
                  <button class="btn medium color1 pull-right" type="submit" name="submit_login">Login</button>
                </form>
              </div>
            </li>
            <?php } else {?>
            <li> <a href="<?php echo Yii::app()->params->base_path; ?>user/logout"> <i class="fa fa-power-off fa-fw"></i> <span class="hidden-xs">Logout</span></a> </li>
            <?php } ?>
          </ul>
          <?php if(isset(Yii::app()->session['farmsoucing_userId']) && Yii::app()->session['name'] != "" ){ ?>
  			<span class="pull-right" style="margin-top: 14px; margin-right: 10px; color:#E65A4B; font-weight:500;">Welcome <?php echo Yii::app()->session['name']; ?> !</span>
		<?php } ?>
        </div>
      </div>
    </div>
  </div>
  <!-- end: Top Heading Bar -->
  
  <div class="f-space20"></div>
  <!-- Logo and Search -->
  <div class="container">
    <div class="row clearfix">
      <div class="col-lg-3 col-xs-12">
        <div class="logo"> <a href="<?php echo Yii::app()->params->base_path; ?>site" title="FRESH N PACK"><!-- <img alt="Flatro - Responsive Metro Inspired Flat ECommerce theme" src="images/logo2.png"> -->
          <div class="logotext"><span><img src="<?php echo Yii::app()->params->base_url; ?>images/logo/logo_1.png" style="width:90px; height:90px; margin-top:-10px;" ></span><br/><br/><span class="slogan" style="margin-left:-20px;">ONLINE STORE</span></div>
          </a></div>
          
      </div>
      
        <div align="right" class="slogan" style="margin-right:10px;	"><span>Phone Order: 079-40053900 <i style="color:#333;">or</i> 079-40056900</span></div>
      <!-- end: logo -->
      <?php $categoryObj = new Category(); 
			$categoryData = $categoryObj->getAllCategoryListASC();	
		?>
      <div class="visible-xs f-space20"></div>
      <!-- search -->
      <div class="col-lg-3 col-md-4 col-sm-5 col-xs-12 pull-right">
        <div class="searchbar">
        <?php if(isset(Yii::app()->session['farmsoucing_userId']) && Yii::app()->session['name'] != "" ){ ?>
          <form method="post" action="<?php echo Yii::app()->params->base_path; ?>user/searchProducts">
          <?php }else { ?>
           <form method="post" action="<?php echo Yii::app()->params->base_path; ?>site/searchProducts">
          <?php } ?>
            <ul class="pull-left">
              <li class="input-prepend dropdown" data-select="true"> <a class="add-on dropdown-toggle" data-hover="dropdown" data-toggle="dropdown" href="#a"> <span class="dropdown-display">All
                Categories</span> <i class="fa fa-sort fa-fw"></i> </a> 
                <!-- this hidden field is used to contain the selected option from the dropdown -->
                <input class="dropdown-field" type="hidden" name="category" value=""/>
                <ul class="dropdown-menu" role="menu">
                  <?php foreach($categoryData as $row) {  ?>
            			<li><a href="#a" data-value="<?php echo $row['cat_id'] ?>"><?php echo $row['category_name'] ?></a></li>
            
            		<?php }  ?> 
                 
                 
                  <li><a href="#a" data-value="All Categories">All Categories</a></li>
                </ul>
              </li>
            </ul>
            <div class="searchbox pull-left">
              <input class="searchinput" id="search" name="keyword" placeholder="Search..." type="search">
              <button class="fa fa-search fa-fw" type="submit"></button>
            </div>
          </form>
        </div>
      </div>
      <!-- end: search --> 
      
    </div>
  </div>
  <!-- end: Logo and Search -->
  <div class="f-space20"></div>
  <!-- Menu -->
  <div class="container">
  <?php if(Yii::app()->user->hasFlash('success')): ?>	
<div class="alert alert-success">
    <button type="button" class="close1" style=" border:none; outline:none; float:right;" data-dismiss="alert">×</button>
    <b><?php echo Yii::app()->user->getFlash('success'); ?></b>
</div>							   
<?php endif; ?>
<?php if(Yii::app()->user->hasFlash('error')): ?>
<div class="alert alert-error">
    <button type="button" class="close1" style=" border:none; outline:none; float:right;" data-dismiss="alert">×</button>
   <b><?php echo Yii::app()->user->getFlash('error'); ?></b>
</div>
<?php endif; ?>
    <div class="row clearfix">
      <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12 menu-col">
        <div class="menu-heading menuHeadingdropdown"> <span> <i class="fa fa-bars"></i> Categories <i class="fa fa-angle-down"></i></span> </div>
        
        <!-- Mega Menu -->
        <?php //print_r($_REQUEST);exit; 
		if($_REQUEST['r'] == 'user' || $_REQUEST['r'] == 'user/' || $_REQUEST['r'] == 'site' || $_REQUEST['r'] == 'site/' || $_REQUEST['r'] == 'user/index' || $_REQUEST['r'] == 'user/Index' || $_REQUEST['r'] == 'site/index' || $_REQUEST['r'] == 'site/Index' || $_REQUEST['r'] == '')
		{ ?>
			 <div class="menu3dmega vertical " id="menuMega">
		<?php } else {  ?>
       		<div class="menu3dmega vertical menuMegasub" id="menuMega">
       <?php } ?>
          <ul>
            <!-- Menu Item Links for Mobiles Only -->
            <li class="visible-xs"> <a href="<?php echo Yii::app()->params->base_path; ?>user"> <i class="fa fa-home"></i> <span>Home</span> <i class="fa fa-angle-right"></i> </a>
             
            </li>
            <!-- end: Menu Item --> 
            <!-- Menu Item for Tablets and Computers Only-->
          
            <!-- end: Menu Item --> 
            <!-- Menu Item -->
            <?php foreach($categoryData as $row) {  ?>
            <?php if(isset(Yii::app()->session['farmsoucing_userId']) && Yii::app()->session['farmsoucing_userId'] != '') {
				  ?>
            <li> <a href="<?php echo Yii::app()->params->base_path;?>user/productListingGrid/cat_id/<?php echo $row['cat_id'] ?>"> <i class="fa fa-expand"></i> <span><?php echo $row['category_name'] ?></span></a> </li>
            
             
             <?php 
			 } else {  ?>
             <li> <a href="<?php echo Yii::app()->params->base_path;?>site/productListingGrid/cat_id/<?php echo $row['cat_id'] ?>"> <i class="fa fa-expand"></i> <span><?php echo $row['category_name'] ?></span></a> </li>
             
             <?php } ?>   
            <?php }  ?>
           <?php if(isset(Yii::app()->session['farmsoucing_userId']) && Yii::app()->session['farmsoucing_userId'] != '') {
				  ?>
             <li> <a href="<?php echo Yii::app()->params->base_path;?>user/categoryListing/"> <i class="fa fa-bars"></i> <span>All Category</span></a> </li>
           
           <?php 
			 } else {  ?>
            <li> <a href="<?php echo Yii::app()->params->base_path;?>site/categoryListing/"> <i class="fa fa-bars"></i> <span>All Category</span></a> </li>
            
            <?php } ?>
            <?php /*?><li> <a href="<?php echo Yii::app()->params->base_path;?>user/orderHistoryListing/"> <i class="fa fa-video-camera"></i> <span>Order History</span></a> </li> 
            <li> <a href="<?php echo Yii::app()->params->base_path;?>site/AboutUs/"> <i class="fa fa-video-camera"></i> <span>About Us</span></a> </li>
            <li> <a href="<?php echo Yii::app()->params->base_path;?>site/contactus/"> <i class="fa fa-video-camera"></i> <span>Contact Us</span></a> </li>  <?php */?>
            <!-- end: Menu Item --> 
            
          </ul>
        </div>
        <!-- end: Mega Menu --> 
      </div>
      <div class="col-lg-9 col-md-9 col-sm-8 col-xs-12 menu-col-2"> 
        <!-- Navigation Buttons/Quick Cart for Tablets and Desktop Only -->
        <div class="menu-links hidden-xs">
          <ul class="nav nav-pills nav-justified">
            <li> <a href="<?php echo Yii::app()->params->base_path;?>site/"> <i class="fa fa-home fa-fw"></i> <span class="hidden-sm">Home</span></a> </li>
            <li> <a href="<?php echo Yii::app()->params->base_path;?>site/Aboutus"> <i class="fa fa-info-circle fa-fw"></i> <span class="hidden-sm">About</span></a> </li>
            <?php if(isset(Yii::app()->session['farmsoucing_userId']) && Yii::app()->session['farmsoucing_userId'] != '') { ?>
            <li> <a href="<?php echo Yii::app()->params->base_path;?>user/productListingGrid"> <i class="fa fa-list fa-fw"></i> <span class="hidden-sm">Products</span></a> </li>
            
         <?php } else {  ?>
          <li> <a href="<?php echo Yii::app()->params->base_path;?>site/productListingGrid"> <i class="fa fa-list fa-fw"></i> <span class="hidden-sm">Products</span></a> </li>
         <?php } ?>   
            <li> <a href="<?php echo Yii::app()->params->base_path;?>site/Contactus"> <i class="fa fa-pencil-square-o fa-fw"></i> <span class="hidden-sm ">Contact</span></a> </li>
           
           <?php
		   $toal_amount=0; 
		   foreach($_SESSION['cartData'] as $row)
			{
				
				$productObj = new Product();
				$pData = $productObj->getAllDetailOfProductById($row['product_id']);
				
				if($row['qty'] != "" && $row['packaging_scenario'] != "" ) 
				{ 
					$price =  $row['qty'] * $row['packaging_scenario'] * $pData['product_price']; 
				} else { 
					$price =  $pData['product_price'] ; 
				} 
		 
				$total_amount =  $total_amount + $price ; 
			}
		   ?>
            <li class="dropdown"> 
            <?php if(isset(Yii::app()->session['farmsoucing_userId']) && Yii::app()->session['farmsoucing_userId'] != '') { ?>
            <a href="<?php echo Yii::app()->params->base_path;?>user/cart"> <i class="fa fa-shopping-cart fa-fw"></i> <span class="hidden-sm" id="cartDropDown"> <?php echo count($_SESSION['cartData'] );?> items | &#8377;<?php echo $total_amount; ?></span></a> 
            <?php } else { ?>
             <a href="<?php echo Yii::app()->params->base_path;?>site/cart"> <i class="fa fa-shopping-cart fa-fw"></i> <span class="hidden-sm"> <?php echo count($_SESSION['cartData'] );?> items | &#8377;<?php echo $total_amount; ?></span></a> 
             <?php } ?>
              <!-- Quick Cart -->
              <div class="dropdown-menu quick-cart">
                <div class="qc-row qc-row-heading"> <span class="qc-col-qty">QTY.</span> <span class="qc-col-name"><?php echo count($_SESSION['cartData'] );?> items in bag</span> <span class="qc-col-price">&#8377;<?php echo $total_amount; ?></span> </div>
           <?php 
		    foreach($_SESSION['cartData'] as $row)
			{
				$productObj = new Product();
				$productData[] = $productObj->getAllDetailOfProductById($row['product_id']);
			}
			$i=0;
		   foreach($productData as $row){ ?>     
                <div class="qc-row qc-row-item"> <span class="qc-col-qty"><?php echo $_SESSION['cartData'][$i]['qty']; ?></span> <span class="qc-col-name"><a href="#a"><?php echo $row['product_name']; ?></a></span> <span class="qc-col-price">&#8377;<?php if(isset($_SESSION['cartData'][$i]['qty']) && $_SESSION['cartData'][$i]['qty'] != "" && isset($_SESSION['cartData'][$i]['packaging_scenario']) && $_SESSION['cartData'][$i]['packaging_scenario'] != "" ) { echo $_SESSION['cartData'][$i]['qty'] * $_SESSION['cartData'][$i]['packaging_scenario'] * $row['product_price']; } else { echo $row['product_price'] ; } ?></span>
                 <?php if(isset(Yii::app()->session['farmsoucing_userId']) && Yii::app()->session['farmsoucing_userId'] != '') { ?>
                 <span class="qc-col-remove" onClick="window.location.href='<?php echo Yii::app()->params->base_path;?>user/removeProductFromCart/removeId/<?php echo $i ; ?>'"> <i class="fa fa-times fa-fw"></i> </span>
                 <?php } else { ?>
                 <span class="qc-col-remove" onClick="window.location.href='<?php echo Yii::app()->params->base_path;?>site/removeProductFromCart/removeId/<?php echo $i ; ?>'"> <i class="fa fa-times fa-fw"></i> </span>
                 <?php } ?>
               </div>
            <?php $i++;} ?>    
                <div class="qc-row-bottom">
                
                <?php if(isset(Yii::app()->session['farmsoucing_userId']) && Yii::app()->session['farmsoucing_userId'] != '') { ?>
                <a class="btn qc-btn-viewcart" href="<?php echo Yii::app()->params->base_path;?>user/cart">view
                  cart</a><a class="btn qc-btn-checkout" href="<?php echo Yii::app()->params->base_path;?>user/cart">check
                  out</a>
                <?php } else { ?>
                <a class="btn qc-btn-viewcart" href="<?php echo Yii::app()->params->base_path;?>site/cart">view
                  cart</a><a class="btn qc-btn-checkout" href="<?php echo Yii::app()->params->base_path;?>site/cart">check
                  out</a>
                <?php } ?>
               </div>
              </div>
              <!-- end: Quick Cart --> 
            </li>
          </ul>
        </div>
        <!-- end: Navigation Buttons/Quick Cart Tablets and large screens Only --> 
       
        
        <div class="clearfix"></div> 
           <!-- Iview Slider -->
        <div class="slider">
          <div id="iview"> 
            <!-- Slide 0 -->
            <div data-iview:image="images/slide0.jpg" data-iview:pausetime="60000">
              <div class="iview-caption metro-box1 orange" data-transition="wipeUp" data-x="95" data-y="209"> <a href="<?php echo Yii::app()->params->base_path;?>site/Aboutus">
                <div class="box-hover"></div>
                <i class="fa fa-info-circle fa-fw"></i> <span>About Us</span></a> </div>
              <div class="iview-caption metro-box1 blue" data-transition="wipeUp" data-x="266" data-y="209"> <a href="<?php echo Yii::app()->params->base_path;?>site/Contactus">
                <div class="box-hover"></div>
                <i class="fa fa-pencil-square-o fa-fw"></i> <span>Contact Us</span></a> </div>
              <div class="iview-caption metro-box2" data-transition="expandLeft" data-x="438" data-y="209">
                <div class="monthlydeals">
                  <div class="monthly-deals slide" id="monthly-deals">
                    <div class="carousel-inner">
                      <div class="item active"> <a href="#a"> <img alt="SliderSubImg1" src="images/SliderSubImg1.png" > </a> </div>
                      <div class="item"> <a href="#a"> <img alt="SliderSubImg2" src="images/SliderSubImg2.png" > </a></div>
                      <div class="item"> <a href="#a"> <img alt="SliderSubImg3" src="images/SliderSubImg3.png"> </a> </div>
                      <div class="item"> <a href="#a"> <img alt="SliderSubImg4" src="images/SliderSubImg4.png"> </a> </div>
                    </div>
                  </div>
                  <a class="left carousel-control" data-slide="prev" href="#monthly-deals"> <i class="fa fa-angle-left fa-fw"></i> </a> <a class="right carousel-control" data-slide="next" href="#monthly-deals"> <i class="fa fa-angle-right fa-fw"></i> </a> </div>
                <!--  <span>Deals of the month</span> --> 
              </div>
              <div class="iview-caption metro-box1 purple" data-transition="wipeDown" data-x="438" data-y="37"> 
              <a href="<?php echo Yii::app()->params->base_path;?>user/OrderHistoryListing">
                <div class="box-hover"></div>
                <i class="fa fa-book fa-fw"></i> <span>Order History</span>
                </a> 
              </div>
               <?php if(isset(Yii::app()->session['farmsoucing_userId']) && Yii::app()->session['farmsoucing_userId'] != '') { ?>
              <div class="iview-caption metro-box1 dark-blue" data-transition="wipeDown" data-x="610" data-y="37"> 
             
              <a href="<?php echo Yii::app()->params->base_path;?>user/cart">
                <div class="box-hover"></div>
                <i class="fa fa-shopping-cart fa-fw"></i> <span>My Cart</span></a> </div>
                <?php } else { ?>
              <div class="iview-caption metro-box1 dark-blue" data-transition="wipeDown" data-x="610" data-y="37"> 
             
              <a href="<?php echo Yii::app()->params->base_path;?>site/cart">
                <div class="box-hover"></div>
                <i class="fa fa-shopping-cart fa-fw"></i> <span>My Cart</span></a> </div>
                <?php } ?>
              <div class="iview-caption metro-heading" data-transition="expandLeft" data-x="95" data-y="40">
                <h1>FRESH N PACK</h1>
              </div>
              <div class="iview-caption metro-heading" data-transition="wipeLeft" data-x="95" data-y="100"> <span>Why Don't You Take Advantage of Inaugural Offer Prices, To Join Call Now 079-40165800.<br>
                <a href="#a"></a></span> </div>
            </div>
            <!-- Slide 1 -->
            <div data-iview:image="images/VegCollage1.jpg">
              <div class="iview-caption caption1" data-transition="wipeUp" data-x="100" data-y="10">Best Value For Your Money</div>
              <div class="iview-caption caption2" data-easing="easeInOutElastic" data-transition="wipeLeft" data-x="100" data-y="140"></div>
              <div class="iview-caption caption3" data-easing="easeInOutElastic" data-transition="wipeLeft" data-x="100" data-y="200"><br>
                </div>
              <div class="iview-caption btn-more" data-transition="fade" data-x="100" data-y="280"><a href="#a">Learn
                more</a></div>
            </div>
            <!-- Slide 2 -->
             <div data-iview:image="images/VegCollage.jpg">
              <div class="iview-caption caption1" data-transition="wipeUp" data-x="100" data-y="10">EVERYDAY</div>
              <div class="iview-caption caption2" data-easing="easeInOutElastic" data-transition="wipeLeft" data-x="100" data-y="140">DELIVERY
                </div>
              <div class="iview-caption caption3" data-easing="easeInOutElastic" data-transition="wipeLeft" data-x="100" data-y="200">Fresh Vegetables<br>
                </div>
            
              <div class="iview-caption btn-more" data-transition="fade" data-x="100" data-y="240"><a href="#a">Learn
                more</a></div>
                
                  <div class="iview-caption caption3 btm-bar" data-height="107px" data-transition="expandRight" data-width="867px" data-x="0" data-y="300">
                <h1><b>Fresh N Pack</b> !</h1>
                <p>Bringing the convenience of direct to home delivery of farm fresh fruits and vegetables for the people of Ahmedabad. The advantages of our direct delivery model include, fresh produce, lower prices and hygenic processes. We also endeavor to keep a full range of regular, seasonal and exotic fruits and vegetables. Fully computerised systems to keep track of your order and deliver accurately. Pay by cash or coupons.</p>
              </div>
            </div>
            
          </div>
        </div>
      </div>
    </div>

  </div>

</header>
<!-- end: Header -->
 
 
  
    <div id="container">
   		
        <?php echo $content; ?>
    </div>
	<div class="row clearfix f-space30"></div>
<!-- footer -->
<footer class="footer">
  <div class="container">
    <div class="row">
      <div class="col-sm-3 col-xs-12 shopinfo">
        <h4 class="title">FRESH n PACK</h4>
        <p> We bring to you fresh, hygenic and value for money green grocery direct to your home. The convenience of getting fruits and vegetables delivered straight to your home is not also available to the citizens of Ahmedabad.</p>
        <p> Removing middle men from the chain, we bring fresh produce straight from the farms to your door step. </p>
      </div>
      <div class="col-sm-3 col-xs-12 footermenu">
        <h4 class="title">Information</h4>
        <ul>
        <li class="item"> <a href="<?php echo Yii::app()->params->base_path;?>site/Aboutus">About Us</a></li>
          <li class="item"> <a href="<?php echo Yii::app()->params->base_path;?>site/Contactus">Contact Us</a></li>
          <li class="item"> <a href="<?php echo Yii::app()->params->base_path;?>site/faq">FAQs</a></li>
         
        </ul>
      </div>
      <div class="col-sm-3 col-xs-12 footermenu">
        <h4 class="title">My account</h4>
        <ul>
          <li class="item"> <a href="<?php echo Yii::app()->params->base_path;?>user/cart">My Cart</a></li>
          <li class="item"> <a href="<?php echo Yii::app()->params->base_path;?>user/OrderHistoryListing">Order History</a></li>
         
        </ul>
      </div>
      <div class="col-sm-3 col-xs-12 getintouch">
        <h4 class="title">get in touch</h4>
        <ul>
          <li>
            <div class="icon"><i class="fa fa-map-marker fa-fw"></i></div>
            <div class="c-info"> <span>23,24 Ground floor, Management enclave,  Opp. Indraprastha bung.<br>
              Vastrapur - Mansi road,<br/> Vastrapur 380015</span></div>
          </li>
          <li>
            <div class="icon"><i class="fa fa-envelope-o fa-fw"></i></div>
            <div class="c-info"> <span>Email Us At:<br>
              <a href="#">sales@freshnpack.com</a></span></div>
          </li>
          <li>
            <div class="icon"><i class="fa fa-phone fa-fw"></i></div>
            <div class="c-info"> <span>Phone Order:<br>
              079-40053900 <br/> 079-40056900</span></div>
          </li>
        </ul>
        <div class="social-icons">
          <ul>
            <li class="icon google-plus"><a href="#"><i class="fa fa-google-plus fa-fw"></i></a></li>
            <li class="icon linkedin"><a href="#"><i class="fa fa-linkedin fa-fw"></i></a></li>
            <li class="icon twitter"><a href="#"><i class="fa fa-twitter fa-fw"></i></a></li>
            <li class="icon facebook"><a href="https://www.facebook.com/pages/Fresh-n-Pack/1528763850681117?ref=hl"><i class="fa fa-facebook fa-fw"></i></a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
  <div class="copyrights">
    <div class="container">
      <div class="row">
        <div class="col-lg-8 col-sm-8 col-xs-12"> <span class="copytxt">&copy; Copyright 2014 by <a href="http://www.farmingsolutions.in">Farming Solutions</a> -  All rights reserved</span> <span class="btmlinks"><a href="<?php echo Yii::app()->params->base_path;?>site/terms">Terms & Conditions</a></span> </div>
        <div class="col-lg-4 col-sm-4 col-xs-12 payment-icons"> <?php /*?><a href="#"> <img src="images/icons/discover.png" alt="discover"> </a> <a href="#"> <img src="images/icons/2co.png" alt="2co"> </a> <a href="#"> <img src="images/icons/paypal.png" alt="paypal"> </a> <a href="#"> <img src="images/icons/mastercard.png" alt="master card"> </a> <a href="#"> <img src="images/icons/visa.png" alt="visa card"> </a> <a href="#"> <img src="images/icons/moneybookers.png" alt="moneybookers"> </a><?php */?> </div>
      </div>
    </div>
  </div>
</footer>
<!-- end: footer --> 
</body>
</html>