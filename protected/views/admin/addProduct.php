<script>

function getCategoryData(id)
{
	
	 $.ajax({
	  type: 'POST',
	  url: '<?php echo Yii::app()->params->base_path;?>admin/getCategoryDetailsForProduct',
	  data: 'cat_id='+id,
	  cache: false,
	  success: function(data)
	  {
		  if(data == 0)
		  {
				alert("data not found.");
				return false;  
		  }else{
			   var obj = jQuery.parseJSON(data);
			  
			    $("#unit_id option[value="+obj.unit_id+"]").prop("selected", true);
				// $("#unit_id option[value="+obj.unit_id+"]").prop("selected", true);
				$("#vendor_id option[value="+obj.vendor_id+"]").prop("selected", true);
				//$("#profit_percentage_id option[value="+obj.profit_percentage_id+"]").prop("selected", true);
				$("#profit_percentage").val(obj.profit_percentage); 
				$("#safetyMargin").val(obj.safetyMargin); 
		 	   return true;
		  }
	  }
	 });
}

</script>
<script type="text/javascript" >
$(document).ready(function(){
		var dateToday = new Date();
		
		var dates = $( "#discount_from, #discount_to" ).datepicker({
			changeMonth: true,
			showOtherMonths:true,
			numberOfMonths: 3,
			minDate: dateToday,
			
		});
	});
function isNumberKey(evt)
{
	
	 if(evt.keyCode == 9)
	 {
	  
	 }
	 else
	 {
	  var charCode = (evt.which) ? evt.which : event.keyCode 
	  if (charCode > 31 && charCode != 46 && (charCode < 48 || charCode > 57))
	  return false;
	 }
	 return true;
}
function setDiscount(val)
{

	if(val == 1)
	{
		$("#discountsection").css('display','block');
	}
	else
	{
		$("#discountsection").css('display','none');
	}
}
</script> 
<!-- Default form -->
<form id="validate" action="<?php echo Yii::app()->params->base_path;?>admin/addProduct" method="post" enctype="multipart/form-data">
<div class="widget">
<div class="navbar"><div class="navbar-inner"><h6><a href="<?php echo Yii::app()->params->base_path;?>admin/productListing">Product List</a>&nbsp;&nbsp;<img src="<?php echo Yii::app()->params->base_url;?>images/path-arrow.png" alt="" border="0" />&nbsp;&nbsp;<?php echo $title;?></h6></div></div>

<div class="well">
<div class="control-group">
<label class="control-label">Product Name<span class="text-error">* &nbsp;</span>:</label>
<div class="controls"><input type="text" name="product_name" class="validate[required] span12 input-xlarge" placeholder="Enter product name" value="<?php if(isset($productData['product_name']) && $productData['product_name'] != "") { echo $productData['product_name']; } ?>"  /></div>
</div>

<div class="control-group">
<label class="control-label">Product Description<span class="text-error">* &nbsp;</span>:</label>
<div class="controls"><input type="text" name="product_desc" class="validate[required] span12 input-xlarge" placeholder="Enter product description" value="<?php if(isset($productData['product_desc']) && $productData['product_desc'] != "") { echo $productData['product_desc']; } ?>" /></div>
</div>

<?php /*?>
<div class="control-group">
<label class="control-label">Product Image<span class="text-error">* &nbsp;</span>:</label>
<div class="controls"><input type="text" name="product_image" class="validate[required] span12 input-xlarge" placeholder="Enter product description" value="<?php if(isset($productData['product_image']) && $productData['product_image'] != "") { echo $productData['product_image']; } ?>" /></div>
</div><?php */?>

   <div class="control-group">
        <label class="control-label">Product Image :</label>
        <div class="controls">
            <input type="file" name="userFile" class="styled">
        </div>
        <?php if(isset($productData['product_image']) && $productData['product_image'] != "") { ?>
       <img src="<?php echo Yii::app()->params->base_url; ?>assets/upload/product/<?php echo $productData['product_image']; ?>" style="width:210px; height:150px;"  /><?php } else { ?><img src="http://placehold.it/210x110" alt="" /><?php } ?>
    </div>
                           


    <div class="control-group">
        <label class="control-label">Product Price<span class="text-error">* &nbsp;</span>:</label>
        <div class="controls">
            <input type="text" name="product_price" class="validate[required] span12 input-xlarge" placeholder="Enter product price" value="<?php if(isset($productData['product_price']) && $productData['product_price'] != "") { echo $productData['product_price']; } ?>" onkeypress="return isNumberKey(event);"  />
         </div>
    </div>
    
    <div class="control-group">
        <label class="control-label">Product Wholesale Price<span class="text-error">* &nbsp;</span>:</label>
        <div class="controls">
            <input type="text" name="wholesale_price" class="validate[required] span12 input-xlarge" placeholder="Enter product Wholesale price" value="<?php if(isset($productData['wholesale_price']) && $productData['wholesale_price'] != "") { echo $productData['wholesale_price']; } ?>" onkeypress="return isNumberKey(event);"  />
         </div>
    </div>

    <div class="control-group">
        <label class="control-label">Minimum Product Quantity<span class="text-error">* &nbsp;</span>:</label>
        <div class="controls">
            <input type="text" name="min_quantity" class="validate[required] span12 input-xlarge" placeholder="Enter product minimum quantity for sales order" value="<?php if(isset($productData['min_quantity']) && $productData['min_quantity'] != "") { echo $productData['min_quantity']; } ?>" onkeypress="return isNumberKey(event);"  />
         </div>
    </div>

 <?php 
	$categoryObj = new Category();
	$categoryList = $categoryObj->getAllCategoryList();
  ?>
	<div class="control-group">
		<div class="controls">
        <label class="control-label">Categoty<span class="text-error">* &nbsp;</span>:</label>
			<select data-placeholder="Choose a category..." onchange="getCategoryData(this.value);" name="cat_id"  id="cat_id" class="validate[required]" tabindex="2">
				<option value="">Select category</option>
				<?php foreach($categoryList as $row ) { ?>
				<option value="<?php echo $row['cat_id']; ?>" <?php if(isset($productData['cat_id']) && $productData['cat_id'] == $row['cat_id'] ) { ?> selected="selected" <?php } ?>  ><?php echo $row['category_name']; ?></option> 
				<?php } ?>	 
			</select>
		</div>             
	</div>


<?php 
	
	
	$unitObj = new Unit();
	$unitList = $unitObj->getAllUnits();
  ?>
<div class="control-group">
<label class="control-label">Unit Name<span class="text-error">* &nbsp;</span>:</label>
<div class="controls"><select data-placeholder="Choose a unit..." name="unit_id"  id="unit_id" class="validate[required]" tabindex="2">
				<option value="">Select Unit</option>
				<?php foreach($unitList as $row ) { ?>
				<option value="<?php echo $row['unit_id']; ?>" <?php if(isset($productData['unitId']) && $productData['unitId'] == $row['unit_id'] ) { ?> selected="selected" <?php } ?>  ><?php echo $row['unit_name']; ?></option> 
				<?php } ?>	 
			</select></div>
</div>

<div class="control-group">
<label class="control-label">Buffer Quantity<span class="text-error">* &nbsp;</span>:</label>
<div class="controls"><input type="text" name="safetyMargin" id="safetyMargin" class="validate[required] span12 input-small" placeholder="Enter safetyMargin" value="<?php if(isset($productData['safetyMargin']) && $productData['safetyMargin'] != "") { echo $productData['safetyMargin']; } ?>" onkeypress="return isNumberKey(event);"  /></div>
</div>

    
<?php 
	$vendorObj = new Vendor();
	$vendorList = $vendorObj->getAllVendors();
  ?>
	<div class="control-group">
		<div class="controls">
        <label class="control-label">Vendor<span class="text-error">* &nbsp;</span>:</label>
			<select data-placeholder="Choose a vendor..." onchange="validateForm();" name="vendor_id"  id="vendor_id" class="validate[required]" tabindex="2">
				<option value=""></option>
				<?php foreach($vendorList as $row ) { ?>
				<option value="<?php echo $row['vendor_id']; ?>" <?php if(isset($productData['vendor_id']) && $productData['vendor_id'] == $row['vendor_id'] ) { ?> selected="selected" <?php } ?>  ><?php echo $row['vendor_name']; ?></option> 
				<?php } ?>	 
			</select>
		</div>             
	</div>
    
    
    <?php 
	/*$profitObj = new ProfitPercentageMaster();
	$profitList = $profitObj->getAllProfitPercentage();*/
  ?>
<?php /*?><div class="control-group">
<label class="control-label">Profit Percentage<span class="text-error">* &nbsp;</span>:</label>
<div class="controls"><select data-placeholder="Choose a profit percentage..." onchange="validateForm();" name="profit_percentage_id"  id="profit_percentage_id" class="validate[required]" tabindex="2">
				<option value="">Select Profit Percentage</option>
				<?php foreach($profitList as $row ) { ?>
				<option value="<?php echo $row['id']; ?>" <?php if(isset($productData['profit_percentage_id']) && $productData['profit_percentage_id'] == $row['id']) { ?> selected="selected" <?php } ?>  ><?php echo $row['profit_percentage']; ?></option> 
				<?php } ?>	 
			</select></div>
</div><?php */?>
<div class="control-group">
        <label class="control-label">Profit Percentage(in %)<span class="text-error">* &nbsp;</span>:</label>
        <div class="controls">
          <input type="text" name="profit_percentage" id="profit_percentage" class="validate[required] span12 input-xlarge" placeholder="Enter profit percentage" value="<?php if(isset($productData['profit_percentage']) && $productData['profit_percentage'] != "") { echo $productData['profit_percentage']; } ?>" onkeypress="return isNumberKey(event);"  />
        </div>
      </div>
      
<div class="control-group">
	<label class="control-label">Featured Product : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Special Product :</label>
    <div class="controls">
      <input type="checkbox" class="styled" name="featured" id="featured" value="1" <?php if(isset($productData['featured']) && $productData['featured'] == "1") { ?> checked="checked" <?php } ?> />
      <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
      <input type="checkbox" class="styled" name="special" id="special" value="1" <?php if(isset($productData['special']) && $productData['special'] == "1") { ?> checked="checked" <?php } ?>  />
    </div>
</div>

 <div class="control-group">
        <label class="control-label">Any discount ?<span class="text-error">* &nbsp;</span>:</label>
        <div class="controls">
         Yes &nbsp;<input type="radio" name="isDiscount" onchange="setDiscount(this.value);"  id="isDiscount" value="1" <?Php if(isset($productData['is_discount']) && $productData['is_discount'] == "1") { ?> checked="checked" <?php }?> />
         No &nbsp;<input type="radio" name="isDiscount" onchange="setDiscount(this.value);" id="isDiscount" value="0" <?Php if(isset($productData['is_discount']) && $productData['is_discount'] == "0") { ?> checked="checked" <?php }?>/>
         
          
        </div>
      </div>
      <?php
	  $css = 'none'; 
	  if(isset($productData['is_discount']) && $productData['is_discount'] == "1")
	  {
		$css = 'block';  
	  }
	  ?>
      
      <div id="discountsection" style="display:<?php echo $css; ?>;"> 
      <div class="control-group" >
        <label class="control-label">Discount Percentage<span class="text-error">* &nbsp;</span>:</label>
        <div class="controls">
         <input type="text" name="discount" id="discount" value="<?php if(isset($productData['discount'])) { echo $productData['discount'];} ?>" />
          
        </div>
      </div>
      
      <div class="control-group" >
        <label class="control-label">Discount From Sale Date<span class="text-error">* &nbsp;</span>:</label>
        <div class="controls">
         <input type="text" name="discount_from" id="discount_from" value="<?php if(isset($productData['discount_from'])) { echo $productData['discount_from'];} ?>" />
          
        </div>
     </div>   
     
      <div class="control-group" >
        <label class="control-label">Discount To<span class="text-error">* &nbsp;</span>:</label>
        <div class="controls">
         <input type="text" name="discount_to" id="discount_to" value="<?php if(isset($productData['discount_to'])) { echo date("Y-m-d",strtotime($productData['discount_to']));} ?>" />
          
        </div>
      </div>
      
      <div class="control-group" >
        <label class="control-label">Discount Discription<span class="text-error">* &nbsp;</span>:</label>
        <div class="controls">
         <input type="text" class="span12 input-xlarge" name="discount_desc" id="discount_desc" value="<?php if(isset($productData['discount_desc'])) { echo $productData['discount_desc'];} ?>" />
          
        </div>
      </div>
      
     </div> 


<input type="hidden" <?php if(isset($productData['product_id'])){ ?> value="<?php echo $productData['product_id']; ?>" <?php } ?> name="id"/>

<div class="form-actions align-right">
<button type="submit" name="FormSubmit" class="btn btn-large btn-success">Submit</button>
<button type="button" onclick="window.location.href='<?php echo Yii::app()->params->base_path;?>admin/productListing'" class="btn btn-large btn-danger">Cancel</button>
<button type="reset" class="btn btn-large btn-info">Reset</button>
</div>

</div>

</div>
</form>
<!-- /default form -->