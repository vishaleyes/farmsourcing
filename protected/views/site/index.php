<!-- Products -->
<script type="application/javascript">
	function addTocart(id)
	{
		$.ajax({
			type: 'POST',
			url: '<?php echo Yii::app()->params->base_path;?>site/addToCartAjax',
			data: 'id='+id,
			cache: false,
			success: function(data)
			{
				$("#cartDropDown").html("<b>10  items | &#8377;</b>");
				alert("Product added successfully.")
				return true;
			}
		});
	}
</script>
<div class="row clearfix f-space30"></div>
<div class="container">
        
         <div class="row clearfix f-space30"></div>
<div class="row">
    <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12 main-column box-block">
      <div class="box-heading"><span>Featured Products</span></div>
      <div class="box-content">
        <div class="box-products slide" id="productc1">
          <div class="carousel-controls"> <a class="carousel-control left" data-slide="prev" href="#productc1"> <i class="fa fa-angle-left fa-fw"></i> </a> <a class="carousel-control right" data-slide="next" href="#productc1"> <i class="fa fa-angle-right fa-fw"></i> </a> </div>
          <div class="carousel-inner"> 
            <!-- Items Row -->
            <div class="item active">
              <div class="row box-product"> 
               
               <?php 
					$i = 0;
					foreach($featureProductData1 as $row) { 
					/*echo "<pre>";
					print_r($row);
					exit;*/
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
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                  <div class="product-block">
                    <div class="image">
                      <div class="product-label product-sale"><span>SALE</span></div>
                      <a class="img" href="<?php echo Yii::app()->params->base_path;?>site/productDescription/id/<?php echo $row['product_id']; ?>">
                      
                      <?php  	                      
                   $content = file_get_contents(Yii::app()->params->base_url."assets/upload/product/".$row['product_image']);
			
                    if(!empty($content))
                    {
                        $filePath =  $row['product_image'];
                    }
                    else
                    {
                        $filePath =  "image.png";
                    }
					
					
                    ?> 
                      <img alt="<?php echo $row['product_name']; ?>" src="<?php  echo Yii::app()->params->base_url; ?>timthumb/timthumb.php?src=<?php echo Yii::app()->params->base_url; ?>assets/upload/product/<?php echo $filePath; ?>&h=255&q=60&zc=0" width="255" height="255" title="<?php echo $row['product_name']; ?>" style="width:100%; height:255px;" ></a> </div>
                    <div class="product-meta">
                      <div class="name"><a href="<?php echo Yii::app()->params->base_path;?>site/productDescription/id/<?php echo $row['product_id']; ?>"><?php echo $row['product_name']; ?></a></div>
                      <div class="big-price"> <span class="price-new"><span class="sym">&#8377;</span><?php echo $finalProductAmount; ?></span><?php echo $oldAmountText ; ?> </div>
                      <div class="big-btns"> <a class="btn btn-default btn-view pull-left" href="<?php echo Yii::app()->params->base_path;?>site/productDescription/id/<?php echo $row['product_id']; ?>">View</a> <a class="btn btn-default btn-addtocart pull-right" href="<?php echo Yii::app()->params->base_path;?>site/addToCart/id/<?php echo $row['product_id']; ?>">Add to Cart</a> </div>
                      <div class="small-price"> <span class="price-new"><span class="sym">&#8377;</span><?php echo  $finalProductAmount; ?></span> <?php echo $oldAmountText ; ?> </div>
                      <div class="rating" style="color:#FFF;"><?php echo $row['unit_name']; ?> </div>
                      <div class="small-btns">
                        <button class="btn btn-default btn-addtocart pull-left" data-toggle="tooltip" title="Add to Cart" onclick="window.location.href='<?php echo Yii::app()->params->base_path;?>site/addToCart/id/<?php echo $row['product_id']; ?>'"> <i class="fa fa-shopping-cart fa-fw"></i> </button>
                      </div>
                    </div>
                    <div class="meta-back"></div>
                  </div>
                </div>
                <!-- end: Product --> 
                
                <?php } 
				
				?>
               
              </div>
            </div>
            <!-- end: Items Row --> 
            <!-- Items Row -->
             <div class="item">
              <div class="row box-product"> 
               
               <?php 
			   	foreach($featureProductData2 as $row) { 
				
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
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                  <div class="product-block">
                    <div class="image">
                      <div class="product-label product-sale"><span>SALE</span></div>
                      <a class="img" href="<?php echo Yii::app()->params->base_path;?>site/productDescription/id/<?php echo $row['product_id']; ?>">
                       <?php  	                      
                   $content = file_get_contents(Yii::app()->params->base_url."assets/upload/product/".$row['product_image']);
			
                    if(!empty($content))
                    {
                        $filePath =  $row['product_image'];
                    }
                    else
                    {
                        $filePath =  "image.png";
                    }
					
                    ?> 
                      <img alt="<?php echo $row['product_name']; ?>" src="<?php  echo Yii::app()->params->base_url; ?>timthumb/timthumb.php?src=<?php echo Yii::app()->params->base_url; ?>assets/upload/product/<?php echo $filePath; ?>&h=255&q=60&zc=0"  width="255" height="255" title="<?php echo $row['product_name']; ?>" style="width:100%; height:255px;"></a> </div>
                    <div class="product-meta">
                      <div class="name"><a href="<?php echo Yii::app()->params->base_path;?>site/productDescription/id/<?php echo $row['product_id']; ?>"><?php echo $row['product_name']; ?></a></div>
                      <div class="big-price"> <span class="price-new"><span class="sym">&#8377;</span><?php echo $finalProductAmount; ?></span><?php echo $oldAmountText ; ?></div>
                      <div class="big-btns"> <a class="btn btn-default btn-view pull-left" href="<?php echo Yii::app()->params->base_path;?>site/productDescription/id/<?php echo $row['product_id']; ?>">View</a> <a class="btn btn-default btn-addtocart pull-right" href="<?php echo Yii::app()->params->base_path;?>site/addToCart/id/<?php echo $row['product_id']; ?>">Add to
                        Cart</a> </div>
                      <div class="small-price"> <span class="price-new"><span class="sym">&#8377;</span><?php echo $finalProductAmount; ?></span><?php echo $oldAmountText ; ?> </div>
                       <div class="rating" style="color:#FFF;"><?php echo $row['unit_name']; ?> </div>
                      <div class="small-btns">
                        <button class="btn btn-default btn-addtocart pull-left" data-toggle="tooltip" title="Add to Cart" onclick="window.location.href='<?php echo Yii::app()->params->base_path;?>site/addToCart/id/<?php echo $row['product_id']; ?>'"> <i class="fa fa-shopping-cart fa-fw"></i> </button>
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
		  	
			$i=0;foreach($specialProductData as $row) {
				
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
                  <a class="img" href="<?php echo Yii::app()->params->base_path;?>site/productDescription/id/<?php echo $row['product_id']; ?>">
                  
                  <?php  	                      
                   $content = file_get_contents(Yii::app()->params->base_url."assets/upload/product/".$row['product_image']);
			
                    if(!empty($content))
                    {
                        $filePath =  $row['product_image'];
                    }
                    else
                    {
                        $filePath =  "image.png";
                    }
					
					
                    ?> 
                  <img alt="<?php echo $row['product_name']; ?>" src="<?php  echo Yii::app()->params->base_url; ?>timthumb/timthumb.php?src=<?php echo Yii::app()->params->base_url; ?>assets/upload/product/<?php echo $filePath; ?>&h=255&q=60&zc=0"  width="255" height="255" title="<?php echo $row['product_name']; ?>" style="width:100%;height:255px;"></a> </div>
                <div class="product-meta">
                  <div class="name"><a href="<?php echo Yii::app()->params->base_path;?>site/productDescription/id/<?php echo $row['product_id']; ?>"><?php echo $row['product_name']; ?></a></div>
                  <div class="big-price"> <span class="price-new"><span class="sym">&#8377;</span><?php echo $finalProductAmount; ?></span><?php echo $oldAmountText ; ?> </div>
                  <div class="big-btns"> <a class="btn btn-default btn-view pull-left" href="<?php echo Yii::app()->params->base_path;?>site/productDescription/id/<?php echo $row['product_id']; ?>">View</a> <a class="btn btn-default btn-addtocart pull-right" href="<?php echo Yii::app()->params->base_path;?>site/addToCart/id/<?php echo $row['product_id']; ?>">Add to
                    Cart</a> </div>
                     <div class="rating" style="color:#FFF;"><?php echo $row['unit_name']; ?> </div>
                    <div class="small-btns">
                        <button class="btn btn-default btn-addtocart pull-left" data-toggle="tooltip" title="Add to Cart" onclick="window.location.href='<?php echo Yii::app()->params->base_path;?>site/addToCart/id/<?php echo $row['product_id']; ?>'"> <i class="fa fa-shopping-cart fa-fw"></i> </button>
                      </div>
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
</div>
<div class="row clearfix f-space30"></div>
<div class="container">
  <div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 main-column box-block">
      <div class="box-heading"><span>Recent Products</span></div>
      <div class="box-content">
        <div class="box-products slide" id="productc3">
          <div class="carousel-controls"> <a class="carousel-control left" data-slide="prev" href="#productc3"> <i class="fa fa-angle-left fa-fw"></i> </a> <a class="carousel-control right" data-slide="next" href="#productc3"> <i class="fa fa-angle-right fa-fw"></i> </a> </div>
          <div class="carousel-inner"> 
            <!-- Items Row -->
          
            <div class="item active">
			    <div class="row box-product"> 
                <?php $i=0;foreach($recentProductData1 as $row) { 
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
                      <a class="img" href="<?php echo Yii::app()->params->base_path;?>site/productDescription/id/<?php echo $row['product_id']; ?>">
                      <?php  	                      
                   $content = file_get_contents(Yii::app()->params->base_url."assets/upload/product/".$row['product_image']);
			
                    if(!empty($content))
                    {
                        $filePath =  $row['product_image'];
                    }
                    else
                    {
                        $filePath =  "image.png";
                    }
                    ?> 
                    
                    
                      <img alt="<?php echo $row['product_name']; ?>" src="<?php  echo Yii::app()->params->base_url; ?>timthumb/timthumb.php?src=<?php echo Yii::app()->params->base_url; ?>assets/upload/product/<?php echo $filePath; ?>&h=255&q=60&zc=0"  width="255" height="255" title="<?php echo $row['product_name']; ?>" style="width:100%; height:255px;"></a> </div>
                    <div class="product-meta">
                      <div class="name"><a href="<?php echo Yii::app()->params->base_path;?>site/productDescription/id/<?php echo $row['product_id']; ?>"><?php echo $row['product_name']; ?></a></div>
                      <div class="big-price"> <span class="price-new"><span class="sym">&#8377;</span><?php echo $finalProductAmount; ?></span><?php echo $oldAmountText ; ?> </div>
                      <div class="big-btns"> <a class="btn btn-default btn-view pull-left" href="<?php echo Yii::app()->params->base_path;?>site/productDescription/id/<?php echo $row['product_id']; ?>">View</a> <a class="btn btn-default btn-addtocart pull-right" href="<?php echo Yii::app()->params->base_path;?>site/addToCart/id/<?php echo $row['product_id']; ?>">Add to
                        Cart</a> </div>
                      <div class="small-price"> <span class="price-new"><span class="sym">&#8377;</span><?php echo $finalProductAmount; ?></span><?php echo $oldAmountText ; ?> </div>
                       <div class="rating" style="color:#FFF;"><?php echo $row['unit_name']; ?> </div>
                      <div class="small-btns">
                        <button class="btn btn-default btn-addtocart pull-left" data-toggle="tooltip" title="Add to Cart"  onclick="window.location.href='<?php echo Yii::app()->params->base_path;?>site/addToCart/id/<?php echo $row['product_id']; ?>'"> <i class="fa fa-shopping-cart fa-fw"></i> </button>
                      </div>
                    </div>
                    <div class="meta-back"></div>
                  </div>
                  
                </div> <?php $i++;} ?>
                <!-- end: Product --> 
              </div>
            </div>
            
            <!-- end: Items Row --> 
            <!-- Items Row -->
            <div class="item">
			    <div class="row box-product"> 
                <?php $i=0;foreach($recentProductData2 as $row) { 
				
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
                      <a class="img" href="<?php echo Yii::app()->params->base_path;?>site/productDescription/id/<?php echo $row['product_id']; ?>">
                      <?php  	                      
                   $content = file_get_contents(Yii::app()->params->base_url."assets/upload/product/".$row['product_image']);
			
                    if(!empty($content))
                    {
                        $filePath =  $row['product_image'];
                    }
                    else
                    {
                        $filePath =  "image.png";
                    }
                    ?> 
                      <img alt="<?php echo $row['product_name']; ?>" src="<?php  echo Yii::app()->params->base_url; ?>timthumb/timthumb.php?src=<?php echo Yii::app()->params->base_url; ?>assets/upload/product/<?php echo $filePath; ?>&h=255&q=60&zc=0"  width="255" height="255" title="<?php echo $row['product_name']; ?>" style="width:100%; height:255px;"></a> </div>
                    <div class="product-meta">
                      <div class="name"><a href="<?php echo Yii::app()->params->base_path;?>site/productDescription/id/<?php echo $row['product_id']; ?>"><?php echo $row['product_name']; ?></a></div>
                      <div class="big-price"> <span class="price-new"><span class="sym">&#8377;</span><?php echo $finalProductAmount; ?></span><?php echo $oldAmountText ; ?> </div>
                      <div class="big-btns"> <a class="btn btn-default btn-view pull-left" href="<?php echo Yii::app()->params->base_path;?>site/productDescription/id/<?php echo $row['product_id']; ?>">View</a> <a class="btn btn-default btn-addtocart pull-right" href="<?php echo Yii::app()->params->base_path;?>site/addToCart/id/<?php echo $row['product_id']; ?>">Add to
                        Cart</a> </div>
                      <div class="small-price"> <span class="price-new"><span class="sym">&#8377;</span><?php echo $finalProductAmount; ?></span><?php echo $oldAmountText ; ?> </div>
                       <div class="rating" style="color:#FFF;"><?php echo $row['unit_name']; ?> </div>
                      <div class="small-btns">
                        <button class="btn btn-default btn-addtocart pull-left" data-toggle="tooltip" title="Add to Cart" onclick="window.location.href='<?php echo Yii::app()->params->base_path;?>site/addToCart/id/<?php echo $row['product_id']; ?>'"> <i class="fa fa-shopping-cart fa-fw"></i> </button>
                      </div>
                    </div>
                    <div class="meta-back"></div>
                  </div>
                  
                </div> <?php $i++;} ?>
                <!-- end: Product --> 
              </div>
            </div>
            <!-- end: Items Row --> 
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- end: Products --> 
<!-- Rectangle Banners -->
<div class="row clearfix f-space30"></div>
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

<script>

(function($) {
  "use strict";
 $('#menuMega').menu3d();
                $('#iview').iView({
                    pauseTime: 10000,
                    pauseOnHover: true,
                    directionNavHoverOpacity: 0.6,
                    timer: "360Bar",
                    timerBg: '#2da5da',
                    timerColor: '#fff',
                    timerOpacity: 0.9,
                    timerDiameter: 20,
                    timerPadding: 1,
					touchNav: true,
                    timerStroke: 2,
                    timerBarStrokeColor: '#fff'
                });
				
                $('.quickbox').carousel({
                    interval: 10000
                });
               $('#monthly-deals').carousel({
                    interval: 3000
                });
                $('#productc2').carousel({
                    interval: 4000
                });
                $('#tweets').carousel({
                    interval: 5000
                });
})(jQuery);


          
        </script>