<?php 
	if($productData['cat_is_discount'] == 1)
	{
		if($productData['is_discount'] == 1)
		{
			if($productData['cat_discount'] > $productData['discount'])
			{
				$productData_discount = $productData['cat_discount'];
				$productData_fromDate = $productData['cat_discount_from'];
				$productData_toDate = $productData['cat_discount_to'];	
			}else{
				$productData_discount = $productData['discount'];
				$productData_fromDate = $productData['discount_from'];
				$productData_toDate = $productData['discount_to'];
			}
		}else{
			$productData_discount = $productData['cat_discount'];
			$productData_fromDate = $productData['cat_discount_from'];
			$productData_toDate = $productData['cat_discount_to'];
		}
	}else{
		if($row['is_discount'] == 1)
		{
			$productData_discount = $productData['discount'];
			$productData_fromDate = $productData['discount_from'];
			$productData_toDate = $productData['discount_to'];
		}else{
			$productData_discount = "";
			$productData_fromDate = "";
			$productData_toDate = "";
		}
	}
	if($productData_discount != "")
	{
		$productData_todayDate = date("Y-m-d");
		
		if($productData_todayDate >= $productData_fromDate && $productData_todayDate <= $productData_toDate)
		{
			$productData_finalProductAmount = round($productData['product_price'] - ($productData['product_price'] * $productData_discount / 100));
			$productData_oldAmountText = "<span class='price-old'><span class='sym'>&#8377;</span>".$productData['product_price']."</span>";	
		}else{
			$productData_finalProductAmount = $row['product_price'];
			$productData_oldAmountText = "";
		}
	}else{
			$productData_finalProductAmount = $row['product_price'];
			$productData_oldAmountText = "";
	}
?>

<div class="row clearfix"></div>
<div class="container">
  <div class="row">
    <div class="col-md-12">
      <div class="breadcrumb"> <a href="<?php echo Yii::app()->params->base_path;?>user"> <i class="fa fa-home fa-fw"></i> Home </a> <i class="fa fa-angle-right fa-fw"></i> <a href="<?php echo Yii::app()->params->base_path;?>user/productDescription/id/<?php echo $productData['product_id']; ?>"> Product </a> </div>
      
      <!-- Quick Help for tablets and large screens -->
      <div class="quick-message hidden-xs">
        <div class="quick-box">
          <div class="quick-slide"> <span class="title">Help</span>
            <div class="quickbox slide" id="quickbox">
              <div class="carousel-inner">
                <div class="item active"> <a href="#"> <i class="fa fa-envelope fa-fw"></i> Quick Message</a> </div>
                <div class="item"> <a href="<?php echo Yii::app()->params->base_path;?>site/faq"> <i class="fa fa-question-circle fa-fw"></i> FAQ</a> </div>
                <div class="item"> <a href="#"> <i class="fa fa-phone fa-fw"></i> 079-40165800</a> </div>
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
<div class="container"> 
  <!-- row -->
  <div class="row">
    <div class="col-md-12 box-block"> 
      
      <!--  box content -->
      
      <div class="box-content"> 
        <!-- single product -->
        <div class="single-product"> 
          <!-- Images -->
          <div class="images col-md-6 col-sm-12 col-xs-12">
            <div class="row"> 
              <!-- Small Images -->
              <?php /*?><div class="thumbs col-md-3 col-sm-3 col-xs-3"  id="thumbs">
                <ul>
                  <li class=""><a href="#a" data-image="images/products/product1.jpg" data-zoom-image="<?php echo Yii::app()->params->base_url; ?>assets/upload/product/<?php echo $productData['product_image']; ?>" class="elevatezoom-gallery active" ><img src="<?php echo Yii::app()->params->base_url; ?>assets/upload/product/<?php echo $productData['product_image']; ?>" alt="small image" /></a></li>
                  <li class=""> <a href="#a" data-image="images/products/product1-1.jpg" data-zoom-image="<?php echo Yii::app()->params->base_url; ?>assets/upload/product/<?php echo $productData['product_image']; ?>"  class="elevatezoom-gallery" > <img src="<?php echo Yii::app()->params->base_url; ?>assets/upload/product/<?php echo $productData['product_image']; ?>" alt="small image" /></a></li>
                  <li class=""> <a href="#a" data-image="images/products/product1-2.jpg" data-zoom-image="<?php echo Yii::app()->params->base_url; ?>assets/upload/product/<?php echo $productData['product_image']; ?>" class="elevatezoom-gallery"><img src="<?php echo Yii::app()->params->base_url; ?>assets/upload/product/<?php echo $productData['product_image']; ?>" alt="small image" /></a></li>
                </ul>
              </div><?php */?>
              <!-- end: Small Images --> 
              <!-- Big Image and Zoom -->
              <div class="big-image col-md-12 col-sm-12 col-xs-12"> <img id="product-image" src="<?php echo Yii::app()->params->base_url; ?>assets/upload/product/<?php echo $productData['product_image']; ?>" data-zoom-image="<?php echo $productData['product_image']; ?>" alt="big image" /> </div>
              <!-- end: Big Image and Zoom --> 
            </div>
          </div>
          
          <!-- end: Images --> 
          
          <!-- product details -->
          
          <div class="product-details col-md-6 col-sm-12 col-xs-12"> 
            
            <!-- Title and rating info -->
            <div class="title">
              <h1><?php echo $productData['product_name']; ?></h1>
              <?php /*?><div class="rating"> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star-half-o"></i> <i class="fa fa-star-o"></i> <?php /*?><span>This product has 30 review(s) <a href="#a">Add Review</a></span></div><?php */?>
            </div>
            <!-- end: Title and rating info -->
            
            <div class="row"> 
              <!-- Availability, Product Code, Brand and short info -->
              <div class="short-info-wr col-md-12 col-sm-12 col-xs-12">
                <div class="short-info">
                  <div class="product-attr-text">Availability: <span class="available">In Stock</span></div>
                  <div class="product-attr-text">Product Code: <span><?php echo $productData['product_id']; ?></span></div>
                  <div class="product-attr-text">Brand: <span><?php echo $productData['category_name']; ?></span></div>
                  <p class="short-info-p"> <?php echo substr($productData['product_desc'],0,100); ?> </p>
                </div>
              </div>
              <!-- end: Availability, Product Code, Brand and short info --> 
              
            </div>
          
            <div class="row">
              <div class="price-wr col-md-4 col-sm-4 col-xs-12">
                <div class="big-price"> <span class="price-new"><span class="sym">&#8377;</span><?php echo $productData_finalProductAmount; ?></span><?php echo $productData_oldAmountText ; ?> </div>
              </div>
              <div class="product-btns-wr col-md-8 col-sm-8 col-xs-12">
                <div class="product-btns">
                  <div class="product-big-btns">
                    <button class="btn btn-addtocart" onclick="window.location.href='<?php echo Yii::app()->params->base_path;?>user/addToCart/id/<?php echo $productData['product_id']; ?>'"> <i class="fa fa-shopping-cart fa-fw"></i> Add to Cart </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
          
          <!-- end: product details --> 
          
        </div>
        
        <!-- end: single product --> 
        
      </div>
      
      <!-- end: box content --> 
      
    </div>
  </div>
  <!-- end:row --> 
</div>
<!-- end: container-->

<div class="row clearfix f-space30"></div>

<!-- container -->
<div class="container"> 
  <!-- row -->
  <div class="row"> 
    <!-- tabs -->
    <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12 main-column box-block product-details-tabs"> 
      
      <!-- Details Info/Reviews/Tags --> 
      <!-- Nav tabs -->
      <ul class="nav nav-tabs blog-tabs nav-justified">
        <li><a href="#details-info" data-toggle="tab"><i class="fa  fa-th-list fa-fw"></i> Details Info</a></li>
      </ul>
      
      <!-- Tab panes -->
      <div class="tab-content">
        <div class="tab-pane active" id="details-info">
          <p><?php echo $productData['product_desc']; ?></p>
          <div class="table-responsive">
            <table class="table table-striped">
              <tbody>
                <tr>
                  <td>Category:</td>
                  <td> <?php echo $productData['category_name']; ?></td>
                </tr>
                <tr>
                  <td>Product Name:</td>
                  <td> <?php echo $productData['product_name']; ?></td>
                </tr>
                <tr>
                  <td style="width:50px;">Product Desc:</td>
                  <td style="width:643px;"> <?php echo $productData['product_desc']; ?></td>
                </tr>
                <tr>

                  <td>Product Price:</td>
                  <td><?php echo $productData_finalProductAmount; ?></td>
                </tr>
                <tr>
                  <td>Quantity:</td>
                  <td> <?php echo $productData['quantity']; ?></td>
                </tr>
                <tr>
                  <td>Unit:</td>
                  <td> <?php echo $productData['unit_name']; ?></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <!-- end: Tab panes --> 
      <!-- end: Details Info/Reviews/Tags -->
      <div class="clearfix f-space30"></div>
    </div>
    <!-- end: tabs --> 
    
    <!-- sidebar -->
     <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 box-block sidebar">
      <div class="box-heading"><span>Specials</span></div>
      <div class="box-content">
        <div class="box-products slide carousel-fade" id="productc2">
          <ol class="carousel-indicators">
            <li class="active" data-slide-to="0" data-target="#productc2"></li>
            <li class="" data-slide-to="1" data-target="#productc2"></li>
            <li class="" data-slide-to="2" data-target="#productc2"></li>
          </ol>
          <div class="carousel-inner"> 
          
          <?php 
		  		$i=0;
				foreach($specialProductData as $row) { 
				
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
            <!-- item -->
            <?php if($i==0) {  ?>
            <div class="item active">
            <?php }else {  ?>
            <div class="item">
            <?php } ?>
            
              <div class="product-block">
                <div class="image">
                  <div class="product-label product-hot"><span>HOT</span></div>
                  <a class="img" href="<?php echo Yii::app()->params->base_path;?>user/productDescription/id/<?php echo $row['product_id']; ?>">
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
                  <img alt="<?php echo $row['product_name']; ?>" src="<?php echo Yii::app()->params->base_url; ?>assets/upload/product/<?php echo $filePath; ?>" title="<?php echo $row['product_name']; ?>" style="width:100%; height:264px;"></a> </div>
                <div class="product-meta">
                  <div class="name"><a href="<?php echo Yii::app()->params->base_path;?>user/productDescription/id/<?php echo $row['product_id']; ?>"><?php echo $row['product_name']; ?></a></div>
                  <div class="big-price"> <span class="price-new"><span class="sym">&#8377;</span><?php echo $finalProductAmount; ?></span><?php echo $oldAmountText ; ?> </div>
                  <div class="big-btns"> <a class="btn btn-default btn-view pull-left" href="">View</a> <a class="btn btn-default btn-addtocart pull-right" href="">Add to
                    Cart</a> </div>
                </div>
                <div class="meta-back"></div>
              </div>
            </div>
            <!-- end: item -->
            <?php $i++;} ?>
            
            
          
          </div>
        </div>
        <div class="carousel-controls"> <a class="carousel-control left" data-slide="prev" href="#productc2"> <i class="fa fa-angle-left fa-fw"></i> </a> <a class="carousel-control right" data-slide="next" href="#productc2"> <i class="fa fa-angle-right fa-fw"></i> </a> </div>
        <div class="nav-bg"></div>
      </div>
    </div>
  </div>
    
    
    <!-- end: sidebar --> 
    
  </div>
  <!-- row --> 
</div>
<!-- end: container --> 

<!-- Relate Products -->

<div class="container">
  <div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 main-column box-block">
      <div class="box-heading"><span>Related Products</span></div>
      <div class="box-content">
        <div class="box-products slide" id="productc3">
          <div class="carousel-controls"> <a class="carousel-control left" data-slide="prev" href="#productc3"> <i class="fa fa-angle-left fa-fw"></i> </a> <a class="carousel-control right" data-slide="next" href="#productc3"> <i class="fa fa-angle-right fa-fw"></i> </a> </div>
          <div class="carousel-inner"> 
            <!-- Items Row -->
            <div class="item active">
              <div class="row box-product"> 
               <?php 
			   		foreach($relatedProductData1 as $row) {
					
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
                <!-- Product -->
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                  <div class="product-block">
                    <div class="image">
                      <div class="product-label product-sale"><span>SALE</span></div>
                      <a class="img" href="<?php echo Yii::app()->params->base_path;?>user/productDescription/id/<?php echo $row['product_id']; ?>">
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
                      <img alt="<?php echo $row['product_name']; ?>" src="<?php echo Yii::app()->params->base_url; ?>assets/upload/product/<?php echo $filePath; ?>" title="<?php echo $row['product_name']; ?>" style="width:100%; height:40%;"></a> </div>
                    <div class="product-meta">
                      <div class="name"><a href="<?php echo Yii::app()->params->base_path;?>user/productDescription/id/<?php echo $row['product_id']; ?>"><?php echo $row['product_name']; ?></a></div>
                      <div class="big-price"> <span class="price-new"><span class="sym">&#8377;</span><?php echo $finalProductAmount; ?></span><?php echo $oldAmountText ; ?> </div>
                      <div class="big-btns"> <a class="btn btn-default btn-view pull-left" href="">View</a> <a class="btn btn-default btn-addtocart pull-right" href="<?php echo Yii::app()->params->base_path;?>user/addToCart/id/<?php echo $row['product_id']; ?>">Add to
                        Cart</a> </div>
                      <div class="small-price"> <span class="price-new"><span class="sym">&#8377;</span><?php echo $finalProductAmount; ?></span><?php echo $oldAmountText ; ?> </div>
                      <div class="small-btns">
                        <button class="btn btn-default btn-addtocart pull-left" data-toggle="tooltip" title="Add to Cart" onclick="window.location.href='<?php echo Yii::app()->params->base_path;?>user/addToCart/id/<?php echo $row['product_id']; ?>'"> <i class="fa fa-shopping-cart fa-fw"></i> </button>
                      </div>
                    </div>
                    <div class="meta-back"></div>
                  </div>
                </div>
                <!-- end: Product -->
                  <?php } ?> 
              </div>
            </div>
            <!-- end: Items Row --> 
            <!-- Items Row -->
            <div class="item">
              <div class="row box-product"> 
                 <?php 
				 
				 	foreach($relatedProductData2 as $row) { 
					
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
                <!-- Product -->
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                  <div class="product-block">
                    <div class="image">
                      <div class="product-label product-sale"><span>SALE</span></div>
                      <a class="img" href="<?php echo Yii::app()->params->base_path;?>user/productDescription/id/<?php echo $row['product_id']; ?>">
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
                      <img alt="<?php echo $row['product_name']; ?>" src="<?php echo Yii::app()->params->base_url; ?>assets/upload/product/<?php echo $filePath; ?>" title="<?php echo $row['product_name']; ?>" style="width:100%; height:40%;"></a> </div>
                    <div class="product-meta">
                      <div class="name"><a href="<?php echo Yii::app()->params->base_path;?>user/productDescription/id/<?php echo $row['product_id']; ?>"><?php echo $row['product_name']; ?></a></div>
                      <div class="big-price"> <span class="price-new"><span class="sym">&#8377;</span><?php echo $finalProductAmount; ?></span><?php echo $oldAmountText ; ?> </div>
                      <div class="big-btns"> <a class="btn btn-default btn-view pull-left" href="">View</a> <a class="btn btn-default btn-addtocart pull-right" href="<?php echo Yii::app()->params->base_path;?>user/addToCart/id/<?php echo $row['product_id']; ?>">Add to
                        Cart</a> </div>
                      <div class="small-price"> <span class="price-new"><span class="sym">&#8377;</span><?php echo $finalProductAmount; ?></span><?php echo $oldAmountText ; ?> </div>
                      <div class="small-btns">
                        <button class="btn btn-default btn-addtocart pull-left" data-toggle="tooltip" title="Add to Cart" onclick="window.location.href='<?php echo Yii::app()->params->base_path;?>user/addToCart/id/<?php echo $row['product_id']; ?>'"> <i class="fa fa-shopping-cart fa-fw"></i> </button>
                      </div>
                    </div>
                    <div class="meta-back"></div>
                  </div>
                </div>
                <!-- end: Product -->
                  <?php } ?> 
              </div>
            </div>
            <!-- end: Items Row --> 
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- end: Related products -->

<div class="row clearfix f-space30"></div>

<!-- Rectangle Banners -->

<div class="container">
  <div class="row">
    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6">
      <div class="rec-banner blue">
        <div class="banner"> <i class="fa fa-thumbs-up"></i>
          <h3>Guarantee</h3>
          <p>100% Money Back Guarantee*</p>
        </div>
      </div>
    </div>
    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6">
      <div class="rec-banner red">
        <div class="banner"> <i class="fa fa-tags"></i>
          <h3>Affordable</h3>
          <p>Convenient & Affordable Prices for You</p>
        </div>
      </div>
    </div>
    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6">
      <div class="rec-banner orange">
        <div class="banner"> <i class="fa fa-headphones"></i>
          <h3>079-40165800</h3>
          <p>Call Support Helpline</p>
        </div>
      </div>
    </div>
    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6">
      <div class="rec-banner lightblue">
        <div class="banner"> <i class="fa fa-female"></i>
          <h3>Women Friendly</h3>
          <p>Helpful Customer Service Staff</p>
        </div>
      </div>
    </div>
    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6">
      <div class="rec-banner darkblue">
        <div class="banner"> <i class="fa fa-gift"></i>
          <h3>Winter Special</h3>
          <p>Discounted Prices for Seasonal Vegetables</p>
        </div>
      </div>
    </div>
    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6">
      <div class="rec-banner black">
        <div class="banner"> <i class="fa fa-truck"></i>
          <h3>Free Shipping</h3>
          <p>Across Selected Areas of Ahmedabad</p>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- end: Rectangle Banners -->

<div class="row clearfix f-space30"></div>

<script src="js/jquery.elevatezoom.js" type="text/javascript"></script> 
<script>

(function($) {
  "use strict";
  //Mega Menu
 $('#menuMega').menu3d();
             
              //Help/Contact Number/Quick Message
			$('.quickbox').carousel({
				interval: 10000
			});
			
			//SPECIALS
			$('#productc2').carousel({
				interval: 4000
			}); 
			//RELATED PRODUCTS
			$('#productc3').carousel({
				interval: 4000
			}); 
			
			//Zoom Product
			$("#product-image").elevateZoom({
												  zoomType : "inner",
												  cursor : "crosshair",
												  easing: true,
												   gallery: "thumbs",
												   galleryActiveClass: "active",
												  loadingIcon : true
												});	
			$("#product-image").bind("click", function(e) {  
  var ez =   $('#product-image').data('elevateZoom');
  ez.closeAll(); //NEW: This function force hides the lens, tint and window	
	//$.fancybox(ez.getGalleryList());     
  return false;
});
})(jQuery);

 </script>