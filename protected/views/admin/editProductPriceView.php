<script type="text/javascript" >
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
</script> 
<!-- Span 12 -->
<form id="validate" action="<?php echo Yii::app()->params->base_path;?>admin/changeProductPrice" method="post" enctype="multipart/form-data">
<div class="widget">
<div class="well">
	<div class="control-group">
    <label class="control-label">Product Name:</label>
    <div class="controls"><?php if(isset($productData['product_name']) && $productData['product_name'] != "") { echo $productData['product_name'] ; }else { echo "---";}  ?></div>
    </div>
    
    <div class="control-group">
    <label class="control-label">Product Price:</label>
    <div class="controls"><?php if(isset($productData['product_price']) && $productData['product_price'] != "") { echo $productData['product_price'] ; }else { echo "---";}  ?></div>
    </div>
   
    <div class="control-group">
    <label class="control-label">New Price<span class="text-error">* &nbsp;</span>:</label>
    <div class="controls"><input type="text" name="product_price" id="product_price" class="validate[required] span12 input-xlarge" placeholder="Enter new price for product" value="" onkeypress="return isNumberKey(event);"  /></div>
    </div>
    
    <input type="hidden" name="product_id" value="<?php echo $productData['product_id'] ; ?>">
<div class="form-actions align-right">
<input type="submit" name="Save" value="Submit" class="btn btn-large btn-info">
<button type="button" onclick="window.location.href='<?php echo Yii::app()->params->base_path;?>admin/productPriceListing'" class="btn btn-large btn-danger">Cancel</button>
<button type="reset"  class="btn-large btn">Reset</button>
</div>

</div>

</div>
</form>
<!-- /span 12 -->