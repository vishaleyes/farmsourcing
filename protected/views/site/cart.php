<script type="application/javascript">
	
	   
	
	function setProductValue(id)
	{
		
		$("#loader_"+id).css("display","block");
		var width = $(window).width();
		if(width < 990)
		{
			var no_of_packets = $("#mob_p_quantity"+id).val();
			var packaging_scenario = $("#mob_packaging_scenario"+id+" option:selected").val();
		}
		else
		{
			var no_of_packets = $("#p_quantity"+id).val();
			var packaging_scenario = $("#packaging_scenario"+id+" option:selected").val();
		}
		var product_id = $("#product_id"+id).val();
		var totalQuantity = Number(no_of_packets) * Number(packaging_scenario);
		var k = "";
		var idName = "#p_quantity"+id;
		$.ajax({
			  type: 'POST',
			  url: '<?php echo Yii::app()->params->base_path;?>site/getProductMinimumQuantity',
			  data: 'product_id='+product_id,
			  cache: false,
			  success: function(data)
			  {
				  if(data == "-1")
				  {
						alert("Product minimum quantity not found.");
						$("#p_quantity option[value="+k+"]").prop("selected", true);
						$("#loader_"+id).css("display","none");
						return false;
				  }else{
					   if(Number(totalQuantity) < Number(data))
					   {
							alert("Please insert quantity more than minimum product quantity.");
							$(idName+" option[value="+k+"]").prop("selected", true);
							$("#loader_"+id).css("display","none");
							$("#minQuantityTag"+id).val(0);
							return false;
							//return false;
					   }else{
						    $("#minQuantityTag"+id).val(1);
							setProductValueInSession(id);
					   }
				  }
			  }
	  });
	}
	
	function setProductValueInSession(id)
	{
		$("#loader_"+id).css("display","block");
		
		var width = $(window).width();
		if(width < 990)
		{
			var no_of_packets = $("#mob_p_quantity"+id).val();
			var packaging_scenario = $("#mob_packaging_scenario"+id+" option:selected").val();
		}
		else
		{
			var no_of_packets = $("#p_quantity"+id).val();
			var packaging_scenario = $("#packaging_scenario"+id+" option:selected").val();
		}
		
		//var no_of_packets = $("#p_quantity"+id).val();
		//var packaging_scenario = $("#packaging_scenario"+id+" option:selected").val();
		var product_price = $("#product_price"+id).val();
		var amountText = $("#amountText"+id).text();
		var amount = $("#amount"+id).val();
		//var subTotal = $("#subTotal").text();
		var total = $("#total").text();
		
		var newAmount = Number(no_of_packets) * Number(packaging_scenario) * Number(product_price);
		//var newSubTotal = Number(subTotal) - Number(amountText) +  Number(newAmount);
		var newTotal = Number(total) - Number(amountText) +  Number(newAmount);
		
		var sessionKey = Number(id) - 1;
		
		$.ajax({
			type: 'POST',
			url: '<?php echo Yii::app()->params->base_path;?>site/updateCartSession',
			data: 'sessionKey='+sessionKey+'&packaging_scenario='+packaging_scenario+'&no_of_packets='+no_of_packets,
			cache: false,
			success: function(data)
			{
				$("#amountText"+id).text(Number(newAmount).toFixed(2));
				$("#amount"+id).val(Number(newAmount).toFixed(2));
				//$("#subTotal").text(newSubTotal);
				$("#total").text(Number(newTotal).toFixed(2));
				$("#loader_"+id).css("display","none");
				return true;
			}
		});
	}
	
	function validateForm()
	{
		var count = $("#count").val();
		for(var i=1;i<=count;i++)
		{
			//var val = $("#packaging_scenario"+i).val();
			//var no_of_packets = $("#p_quantity"+i).val();
			
			var width = $(window).width();
			if(width < 990)
			{
				var no_of_packets = $("#mob_p_quantity"+i).val();
				var packaging_scenario = $("#mob_packaging_scenario"+i+" option:selected").val();
			}
			else
			{
				var no_of_packets = $("#p_quantity"+i).val();
				var packaging_scenario = $("#packaging_scenario"+i+" option:selected").val();
			}
			
			if(packaging_scenario == '' || packaging_scenario == 'undefined' || packaging_scenario == null)
			{
				alert("Please select all the packaging scenario.");
				return false;
			}
			
			if(no_of_packets == '' || no_of_packets == 'undefined' || no_of_packets == null)
			{
				alert("Please select all the no of packets.");
				return false;
			}
			
			var minQuantityTag = $("#minQuantityTag"+i).val();
			if(minQuantityTag == 0)
			{
				alert("Please select minimum quantity of all product.");
				return false;	
			}
			
		}
		
		var total = $("#total").text();
		if(Number(total) < 100)
		{
			alert("Order value must be atleast 100.");
			return false;
		}
		
		return true;
	}
	
	function isDecimalKey(evt,val,id)
	{
		if(evt.keyCode == 9)
		{
		
		}
		else
		{
			var charCode = (evt.which) ? evt.which : event.keyCode
			if(charCode == 46) 
			{
				var finalvalue = val+".";	
				var checkNumber = isNaN(finalvalue) ;
				if(checkNumber == true)
				{
					return false;
				}
			}
			if (charCode > 31 && charCode != 46 && (charCode < 48 || charCode > 57))
			return false;
		}
		setProductValue(id);
		return true;
	}
</script>
<div class="row clearfix"></div>
<div class="container">
  <div class="row">
    <div class="col-md-12">
      <div class="breadcrumb"> <a href="<?php echo Yii::app()->params->base_path;?>site/"> <i class="fa fa-home fa-fw"></i> Home </a> <i class="fa fa-angle-right fa-fw"></i> Cart</div>
      
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
<form action="<?php echo Yii::app()->params->base_path;?>site/checkOutCart" method="post" onsubmit="return validateForm();">
<div class="container">
  <div class="row">
    <div class="col-md-12">
      <div class="page-title">
      <?php 
		  if(!empty($productData) && $productData != "") {
			  $productCount = count($productData);
		  }else{
			$productCount = 0;
		  } 
	  ?>
        <h2>Cart (<?php echo $productCount;?> Items)<a href="<?php echo Yii::app()->params->base_path;?>site/emptyCart" class="color2" data-toggle="tooltip" data-original-title="Empty cart"><i class="fa fa-trash-o fa-fw color2"></i></a><a href="<?php echo Yii::app()->params->base_path;?>site/productListingGrid" style="float:right; margin-right:32px; color:#E65A4B;">> Back to shopping</a></h2>
      </div>
      
    </div>
  </div>
</div>

<div class="row clearfix f-space10"></div>

<?php
	$total_amount = 0;
	$i=0;
	$j=1;
	foreach($productData as $row){
		
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
<!-- product -->
<div class="container">
  <div class="row">
    <div class="product">
      <div class="col-md-2 col-sm-3 hidden-xs p-wr">
        <div class="product-attrb-wr">
          <div class="product-attrb">
            <div class="image"> <a class="img" href="<?php echo Yii::app()->params->base_path;?>site/productDescription/id/<?php echo $row['product_id']; ?>">
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
            <img alt="<?php echo $row['product_name']; ?>" src="<?php echo Yii::app()->params->base_url; ?>assets/upload/product/<?php echo $filePath; ?>" title="<?php echo $row['product_name']; ?>" style="width:100%; height:100%;"></a> </div>
          </div>
        </div>
      </div>
      <div class="col-md-3 col-sm-7 col-xs-9 p-wr">
        <div class="product-attrb-wr">
          <div class="product-meta">
            <div class="name">
              <h3><a href="<?php echo Yii::app()->params->base_path;?>site/productDescription/id/<?php echo $row['product_id']; ?>"><?php echo $row['product_name']; ?></a></h3>
              <h5><span class="sym">Unit: </span> <span class="sym"><?php echo $row['unit_name']; ?></span></h5>
              <input type="hidden" id="product_id<?php echo $j ;?>" name="product_id<?php echo $j ;?>" value="<?php echo $row['product_id']; ?>"  />
            </div>
            <div class="price"> <span class="price-new"><span class="sym">&#8377;</span><?php echo $finalProductAmount; ?></span><?php echo $oldAmountText ; ?> </div>
            <input type="hidden" id="product_price<?php echo $j ;?>" name="product_price<?php echo $j ;?>" value="<?php echo $finalProductAmount; ?>"  />
            
            <input type="hidden" id="minQuantityTag<?php echo $j ;?>" name="minQuantityTag<?php echo $j ;?>" value="1"  /> 
            
            <?php 
		   		$catPackObj = new CategoryPackagingMaster();
				$catPackData = $catPackObj->getAllPackageScenarioByCatId($row['product_id']);
		   ?>
             <span id="pkg" style="display:none;">  <select data-placeholder="Choose a package..."  name="packaging_scenario<?php echo $j ;?>" id="mob_packaging_scenario<?php echo $j ;?>" class="select" style="font-family:Arial, Helvetica, sans-serif !important; " onchange="setProductValue(<?php echo $j ;?>);">
               <option value="">select a package</option>
				   <?php 
                    foreach($catPackData as $raw)
                    {
                    ?>
                        <option value="<?php echo $raw['packaging_scenario']; ?>" <?php if(isset($_SESSION['cartData'][$i]['packaging_scenario']) && $_SESSION['cartData'][$i]['packaging_scenario'] == $raw['packaging_scenario']) { ?> selected="selected" <?php } ?>><?php echo $raw['display_name']; ?></option>
                   <?php } ?>
               </select>
               <select name="p_quantity<?php echo $j ;?>" id="mob_p_quantity<?php echo $j ;?>" class="select" style="font-family:Arial, Helvetica, sans-serif !important; " onchange="setProductValue(<?php echo $j ;?>);">
                <option value="">No of Packets</option>	
				<?php for($u=1;$u<=100;$u++) { ?>
                    <option value="<?php echo $u ; ?>" <?php if(isset($_SESSION['cartData'][$i]['qty']) && $_SESSION['cartData'][$i]['qty'] == $u) {?> selected="selected" <?php } ?> ><?php echo $u ; ?></option>
                <?php } ?>
                </select></span>
       	
            </div>
        </div>
      </div>
      
      
      <div class="col-md-2 hidden-sm hidden-xs p-wr">
        <div class="product-attrb-wr">
          <div class="product-attrb">
           <span class="sym" >Package Scenario</span>
            <span class="sym">
           <?php 
		   		$catPackObj = new CategoryPackagingMaster();
				$catPackData = $catPackObj->getAllPackageScenarioByCatId($row['product_id']);
		   ?>
               <select data-placeholder="Choose a package..."  name="packaging_scenario<?php echo $j ;?>" id="packaging_scenario<?php echo $j ;?>" class="select" style="font-family:Arial, Helvetica, sans-serif !important; width:100%;" onchange="setProductValue(<?php echo $j ;?>);">
               <option value="">select a package</option>
				   <?php 
                    foreach($catPackData as $raw)
                    {
                    ?>
                        <option value="<?php echo $raw['packaging_scenario']; ?>" <?php if(isset($_SESSION['cartData'][$i]['packaging_scenario']) && $_SESSION['cartData'][$i]['packaging_scenario'] == $raw['packaging_scenario']) { ?> selected="selected" <?php } ?>><?php echo $raw['display_name']; ?></option>
                   <?php } ?>
               </select>
               <?php /*?><button onclick="setProductValue(<?php echo $j ;?>);" type="button" style="float:left;" class="btn small color2">Update</button><?php */?>
           </span>
          
           
          </div>
           
        </div>
      </div>
      <div class="col-md-2 hidden-sm hidden-xs p-wr">
        <div class="product-attrb-wr">
          <div class="product-attrb">
                <?php /*?><input type="text" class="quantity-input" name="p_quantity" id="p_quantity<?php echo $j ;?>" value="<?php if(isset($_SESSION['cartData'][$i]['qty']) && $_SESSION['cartData'][$i]['qty'] != "") { echo $_SESSION['cartData'][$i]['qty']; } else { echo 1 ; } ?>" ><?php */?>
                <span class="sym">No of packets</span>
                <span class="sym">
                <?php /*?><select name="p_quantity<?php echo $j ;?>" id="p_quantity<?php echo $j ;?>" class="select" style="font-family:Arial, Helvetica, sans-serif !important; width:100%;" onchange="setProductValue(<?php echo $j ;?>);">
                <option value="">No of Packets</option>	
				<?php for($u=1;$u<=100;$u++) { ?>
                    <option value="<?php echo $u ; ?>" <?php if(isset($_SESSION['cartData'][$i]['qty']) && $_SESSION['cartData'][$i]['qty'] == $u) {?> selected="selected" <?php } ?> ><?php echo $u ; ?></option>
                <?php } ?>
                </select><?php */?>
                <input type="text" class="form-control" style="text-align:right; width:100%;" name="p_quantity<?php echo $j ;?>" id="p_quantity<?php echo $j ;?>" value="<?php if(isset($_SESSION['cartData'][$i]['qty']) && $_SESSION['cartData'][$i]['qty'] != "") { echo $_SESSION['cartData'][$i]['qty']; } else { echo 1 ; } ?>"  onkeypress="return isDecimalKey(event,this.value,'<?php echo $j ;?>');" /> 
            <img id="loader_<?php echo $j ;?>" src="<?php echo Yii::app()->params->base_url;?>images/spinner-mini.gif" alt="Loading" style="height:16px;width:16px;margin-left: 5px;margin-top: -18px; display:none;" />  
            </span>
             </div>
        </div>
       
      </div>
       
      <div class="col-md-2 hidden-sm hidden-xs p-wr">
        <div class="product-attrb-wr">
          <div class="product-attrb">
            <div class="price">
            	<span class="t-price"><span class="sym">&#8377;</span><span id="amountText<?php echo $j ;?>" ><?php if(isset($_SESSION['cartData'][$i]['qty']) && $_SESSION['cartData'][$i]['qty'] != "" && isset($_SESSION['cartData'][$i]['packaging_scenario']) && $_SESSION['cartData'][$i]['packaging_scenario'] != "" ) { echo $_SESSION['cartData'][$i]['qty'] * $_SESSION['cartData'][$i]['packaging_scenario'] * $finalProductAmount; } else { echo $finalProductAmount ; } ?></span></span>
                <input type="hidden" id="amount<?php echo $j ;?>" name="amount<?php echo $j ;?>" value="<?php if(isset($_SESSION['cartData'][$i]['qty']) && $_SESSION['cartData'][$i]['qty'] != "" && isset($_SESSION['cartData'][$i]['packaging_scenario']) && $_SESSION['cartData'][$i]['packaging_scenario'] != "" ) { echo $_SESSION['cartData'][$i]['qty'] * $_SESSION['cartData'][$i]['packaging_scenario'] * $finalProductAmount; } else { echo $finalProductAmount ; } ?>"  /> 
            </div>
          </div>
        </div>
      </div>
      
      <div class="col-md-1 col-sm-2 col-xs-3 p-wr">
        <div class="product-attrb-wr">

          <div class="product-attrb">
            <div class="remove"> <a href="<?php echo Yii::app()->params->base_path;?>site/removeProductFromCart/removeId/<?php echo $i ; ?>" class="color2" data-toggle="tooltip" data-original-title="Remove"><i class="fa fa-trash-o fa-fw color2"></i></a> </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- end: product -->
<div class="row clearfix f-space30"></div>

<?php 

 	if(isset($_SESSION['cartData'][$i]['qty']) && $_SESSION['cartData'][$i]['qty'] != "" 
		&& isset($_SESSION['cartData'][$i]['packaging_scenario']) && $_SESSION['cartData'][$i]['packaging_scenario'] != "" ) 
		{ 
			$price =  $_SESSION['cartData'][$i]['qty'] * $_SESSION['cartData'][$i]['packaging_scenario'] * $finalProductAmount; 
		} else { 
			$price =  $finalProductAmount ; 
		} 
 
	$total_amount =  $total_amount + $price ; 
	$i++;
	$j++;
} ?>
<input type="hidden" id="count" name="count" value="<?php echo $i; ?>"  /> 
<input type="hidden" id="customer_id" name="customer_id" value="<?php echo Yii::app()->session['farmsoucing_userId']; ?>"  /> 
<div class="row clearfix f-space10"></div>


<div class="container">
  <div class="row"> 
   <?php /*?> <!-- 	Estimate Shipping & Taxes -->
    <div class="col-md-4  col-sm-4 col-xs-12 cart-box-wr">
      <div class="box-heading"><span>Estimate Shipping & Taxes</span></div>
      <div class="clearfix f-space10"></div>
      <div class="box-content cart-box">
        <p>Enter your destination to get a shipping estimate.</p>
        <form>
          <input type="text" value="" placeholder="Country" class="input4" />
          <input type="text" value="" placeholder="Region/State" class="input4" />
          <button class="btn large color2 pull-right">Submit</button>
        </form>
      </div>
      <div class="clearfix f-space30"></div>
    </div>
    
    <!-- end: Estimate Shipping & Taxes --> 
    
    <!-- 	Discount Codes -->
    
    <div class="col-md-4  col-sm-4 col-xs-12 cart-box-wr">
      <div class="box-heading"><span>Discount Codes</span></div>
      <div class="clearfix f-space10"></div>
      <div class="box-content cart-box">
        <p>Enter your coupon code if you have one.</p>
        <form>
          <input type="text" value="" placeholder="Country" class="input4" />
          <input type="text" value="" placeholder="Region/State" class="input4" />
          <button class="btn large color2 pull-right">Submit</button>
        </form>
      </div>
      <div class="clearfix f-space30"></div>
    </div>
    
    <!-- end: Discount Codes --> <?php */?>
    
    <!-- 	Total amount -->
    
    <div class="col-md-4 col-sm-4 col-xs-12 cart-box-wr pull-right">
      <div class="box-content">
      <?php /*?>  <div class="cart-box-tm">
          <div class="tm1">Sub-Total</div>
          <div class="tm2">&#8377;<span id="subTotal"><?php echo $total_amount; ?></span></div>
        </div><?php */?>
        <div class="clearfix f-space10"></div>
      <?php /*?>  <div class="cart-box-tm">
          <div class="tm1">Eco Tax (-2.00) </div>
          <div class="tm2">&#8377;00.00</div>
        </div><?php */?>
      <?php /*?>  <div class="clearfix f-space10"></div><?php */?>
      <?php /*?>  <div class="cart-box-tm">
          <div class="tm1">VAT (18.2%) </div>
          <div class="tm2">$00.00</div>
        </div><?php */?>
        <div class="clearfix f-space10"></div>
        <div class="cart-box-tm">
          <div class="tm3 bgcolor2">Total </div>
          <div class="tm4 bgcolor2">&#8377;<span id="total"><?php echo $total_amount; ?></span></div>
        </div>
        <div class="clearfix f-space10"></div>
        <button type="submit" name="FormSubmit" class="btn large color1 pull-right">Place Order</button>
        <div class="clearfix f-space30"></div>
      </div>
    </div>
    
    <!-- end: Total amount --> 
    
  </div>
  <div class="row clearfix f-space30"></div>
</div>
</form>
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