<div class="row clearfix"></div>
<?php
	  		if(isset($_GET['page']) && $_GET['page'] != '')
			{
				$page = $_GET['page'];
			}
			else
			{
				$page = 1;
			}
			$pageItemCount = $data['pagination']->getItemCount();
			$limit = $data['pagination']->getLimit();
			$var1 =0;$var2=0;
			$var2 = $limit * $page;
			
			$var1 = $var2 - ($limit - 1);
			if($var2 >  $pageItemCount)
			{
				$var2 = $pageItemCount;
			}
			
	  ?>
<div class="container">
  <div class="row">
    <div class="col-md-12">
      <div class="breadcrumb"> <a href="<?php echo Yii::app()->params->base_path;?>site"> <i class="fa fa-home fa-fw"></i> Home </a> <i class="fa fa-angle-right fa-fw"></i> <a href="<?php echo Yii::app()->params->base_path;?>site/productListingList"> Product List </a> </div>
      
      <!-- Quick Help for tablets and large screens -->
      <div class="quick-message hidden-xs">
        <div class="quick-box">
          <div class="quick-slide"> <span class="title">Help</span>
            <div class="quickbox slide" id="quickbox">
              <div class="carousel-inner">
                <div class="item active"> <a href="#"> <i class="fa fa-envelope fa-fw"></i> Quick Message</a> </div>
                <div class="item"> <a href="<?php echo Yii::app()->params->base_path;?>site/faq"> <i class="fa fa-question-circle fa-fw"></i> FAQ</a> </div>
                <div class="item"> <a href="#"> <i class="fa fa-phone fa-fw"></i>079-40165800</a> </div>
              </div>
            </div>
            <a class="left carousel-control" data-slide="prev" href="#quickbox"> <i class="fa fa-angle-left fa-fw"></i> </a> <a class="right carousel-control" data-slide="next" href="#quickbox"> <i class="fa fa-angle-right fa-fw"></i> </a> </div>
        </div>
      </div>
      <!-- end: Quick Help --> 
      
    </div>
  </div>
</div>
<div class="row clearfix f-space10"></div>

<div class="row clearfix f-space10"></div>
<div class="container"> 
  <!-- row -->
  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12 box-block">
      <div class="box-heading category-heading">
      <?php $cnt = $data['pagination']->itemCount; if($cnt > 0 ){ ?>
      <span>Showing <?php echo $var1." - ".$var2; ?> of <?php echo $pageItemCount; ?> Products</span>
      <?php } ?>
         <ul class="nav nav-pills pull-right">
          <li class="dropdown"> <a class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" href="#a"> Sort by <i class="fa fa-sort fa-fw"></i> </a>
            <ul class="dropdown-menu" role="menu">
              <li <?php if(isset($ext['sortBy']) && $ext['sortBy'] == "p.product_name" && $ext['sortType'] == "asc") { ?> class="active" <?php } ?>><a href="<?php echo Yii::app()->params->base_path;?>site/productListingList/cat_id/<?php if(isset($_GET['cat_id']) && $_GET['cat_id'] ) { echo $_GET['cat_id'] ; } ?>/sortType/asc/sortBy/p.product_name">Name (A-Z)</a></li>
              <li <?php if(isset($ext['sortBy']) && $ext['sortBy'] == "p.product_name" && $ext['sortType'] == "desc") { ?> class="active" <?php } ?>><a href="<?php echo Yii::app()->params->base_path;?>site/productListingList/cat_id/<?php if(isset($_GET['cat_id']) && $_GET['cat_id'] ) { echo $_GET['cat_id'] ; } ?>/sortType/desc/sortBy/p.product_name">Name (Z-A)</a></li>
              <li <?php if(isset($ext['sortBy']) && $ext['sortBy'] == "p.product_price" && $ext['sortType'] == "asc") { ?> class="active" <?php } ?>><a href="<?php echo Yii::app()->params->base_path;?>site/productListingList/cat_id/<?php if(isset($_GET['cat_id']) && $_GET['cat_id'] ) { echo $_GET['cat_id'] ; } ?>/sortType/asc/sortBy/p.product_price">Price (Low-High)</a></li>
              <li <?php if(isset($ext['sortBy']) && $ext['sortBy'] == "p.product_price" && $ext['sortType'] == "desc") { ?> class="active" <?php } ?>><a href="<?php echo Yii::app()->params->base_path;?>site/productListingList/cat_id/<?php if(isset($_GET['cat_id']) && $_GET['cat_id'] ) { echo $_GET['cat_id'] ; } ?>/sortType/desc/sortBy/p.product_price">Price (High-Low)</a></li>
             
              <li <?php if(isset($ext['sortBy']) && $ext['sortBy'] == "p.product_id" && $ext['sortType'] == "desc") { ?> class="active" <?php } ?>><a href="<?php echo Yii::app()->params->base_path;?>site/productListingList/cat_id/<?php if(isset($_GET['cat_id']) && $_GET['cat_id'] ) { echo $_GET['cat_id'] ; } ?>/sortType/desc/sortBy/p.product_id">Recent</a></li>
            </ul>
          </li>
          <li class="view-list active"> <a href="<?php echo Yii::app()->params->base_path;?>site/productListingList/cat_id/<?php if(isset($_GET['cat_id']) && $_GET['cat_id'] ) { echo $_GET['cat_id'] ; } ?>"> <i class="fa fa-list-ul fa-fw"></i></a> </li>
          <li class="view-grid"> <a href="<?php echo Yii::app()->params->base_path;?>site/productListingGrid/cat_id/<?php if(isset($_GET['cat_id']) && $_GET['cat_id'] ) { echo $_GET['cat_id'] ; } ?>"> <i class="fa fa-th-large fa-fw"></i></a> </li>
        </ul>
      </div>
      <div class="row clearfix f-space20"></div>
      <div class="box-content">
        <div class="box-products"> 
         <?php 
			$i=1;
			$cnt = $data['pagination']->itemCount;
			if($cnt>0){
		  
			foreach($data['productlisting'] as $row) {
			
			 if($row['cat_is_discount'] == 1)
				{
					if($row['is_discount'] == 1)
					{
						if($row['cat_discount'] > $row['discount'])
						{
							$discount = $row['cat_discount'];
							$fromDate = $row['cat_discount_from'];
							$toDate = $row['cat_discount_to'];	
						}else{
							$discount = $row['discount'];
							$fromDate = $row['discount_from'];
							$toDate = $row['discount_to'];
						}
					}else{
						$discount = $row['cat_discount'];
						$fromDate = $row['cat_discount_from'];
						$toDate = $row['cat_discount_to'];
					}
				}else{
					if($row['is_discount'] == 1)
					{
						$discount = $row['discount'];
						$fromDate = $row['discount_from'];
						$toDate = $row['discount_to'];
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
						$finalProductAmount = round($row['product_price'] - ($row['product_price'] * $discount / 100));
						$oldAmountText = "<span class='price-old'><span class='sym'>&#8377;</span>".$row['product_price']."</span>";	
					}else{
						$finalProductAmount = $row['product_price'];
						$oldAmountText = "";
					}
				}else{
						$finalProductAmount = $row['product_price'];
						$oldAmountText = "";
				}
					
	   ?>  
          <!-- Product Row -->
          <div class="row list-product"> 
            <!-- Product --> 
            <!-- Image -->
            <div class="col-md-4 col-sm-12 col-xs-12 product-image">
              <div class="image">
                <div class="product-label product-sale"><span>SALE</span></div>
                <a class="img" href="<?php echo Yii::app()->params->base_path;?>site/productDescription/id/<?php echo $row['product_id']; ?>">
                <?php 
					    	                      
                   $content = file_get_contents(Yii::app()->params->base_url."assets/upload/product/".urlencode($row['product_image']));
				   
			
                    if(!empty($content))
                    {
                        $filePath =  $row['product_image'];
                    }
                    else
                    {
                        $filePath =  "image.png";
                    }
                    ?> 
                
                <img alt="<?php echo $row['product_name']; ?>" src="<?php echo Yii::app()->params->base_url; ?>assets/upload/product/<?php echo $filePath; ?>" title="<?php echo $row['product_name']; ?>" style="width:276px; height:235px;" class="ani-image"></a> </div>
            </div>
            <!-- end: Image -->
            
            <div class="col-md-8 col-sm-12 col-xs-12 product-title">
              <div class="producttitle">
                <h1><a href="<?php echo Yii::app()->params->base_path;?>user/productDescription/id/<?php echo $row['product_id']; ?>"><?php echo $row['product_name']; ?></a></h1>
                <div class="rating" style="color:#FFF;"><?php echo $row['unit_name']; ?></div>
                <!--<div class="rating"> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star-half-o"></i> <i class="fa fa-star-o"></i> <i class="fa fa-star-o"></i> </div>
                <span class="reviews-info">This product has 30 review(s)</span>--> </div>
            </div>
            <div class="col-md-3 col-sm-4 col-xs-12 product-price">
              <div class="big-price"> <span class="price-new"><span class="sym">&#8377;</span><?php echo $finalProductAmount; ?></span><?php echo $oldAmountText ; ?> </div>
            </div>
            <div class="col-md-5 col-sm-8 col-xs-12 product-meta">
              <div class="productmeta">
                <p><?php echo substr($row['product_desc'],0,100); ?> <a href="<?php echo Yii::app()->params->base_path;?>site/productDescription/id/<?php echo $row['product_id']; ?>">read more</a></p>
                <div class="category-list-btns">
                  <button class="btn normal btn-addtocart pull-left" onclick="window.location.href='<?php echo Yii::app()->params->base_path;?>site/addToCart/id/<?php echo $row['product_id']; ?>'"> <i class="fa fa-shopping-cart fa-fw"></i> Add to Cart </button>
                </div>
              </div>
            </div>
          </div>
          
          <!-- end: Product Row -->
         <?php }  }?> 
          <div class="row clearfix f-space20"></div>
          
          
        </div>
      </div>
      <div class="clearfix f-space30"></div>
      <?php $cnt = $data['pagination']->itemCount; if($cnt > 0 ){ ?>
       <span class="pull-left">Showing <?php echo $var1." - ".$var2; ?> of <?php echo $pageItemCount; ?> products</span>
       <?php } else { ?> 
       <span class="pull-left">Product not found.</span>
       <?php }?>
      <?php
		 if($cnt > 0 && $data['pagination']->getItemCount()  > $data['pagination']->getLimit()){?>
			 <div class="pagination pagination-lg">
			 <?php 
			 $extraPaginationPara='&keyword='.$ext['keyword'];
			 $this->widget('application.extensions.WebPager',
							 array('cssFile'=>Yii::app()->params->base_url.'css/common.css',
									 'extraPara'=>$extraPaginationPara,
									'pages' => $data['pagination'],
									'id'=>'link_pager',
			));
		 ?>	
		 <?php  
		 }?>
      </div>
    </div>
    
    <!-- end:sidebar --> 
  </div>
  <!-- end:row --> 
</div>
<!-- end: container-->

<div class="row clearfix f-space30"></div>

<script>

(function($) {
  "use strict";
  //Mega Menu
 $('#menuMega').menu3d();
             
              //Help/Contact Number/Quick Message
			$('.quickbox').carousel({
				interval: 10000
			});
			
				
			//Filter by Price Slider
$("#price-range").ionRangeSlider({
    min: 100,                        // min value
    max: 1000,                       // max value
    from: 200,                       // overwrite default FROM setting
    to: 600,                         // overwrite default TO setting
    type: "double",                 // slider type
    step: 50,                       // slider step
    postfix: "",             		// postfix text
    hasGrid: false,                  // enable grid
    hideMinMax: false,               // hide Min and Max fields
    hideFromTo: false,               // hide From and To fields
    prettify: false,                 // separate large numbers with space, eg. 10 000
    onChange: function(obj){        // function-callback, is called on every change
        console.log(obj);
    },
    onFinish: function(obj){        // function-callback, is called once, after slider finished it's work
        console.log(obj);
    }
});			
				
				
				
})(jQuery);

 </script>