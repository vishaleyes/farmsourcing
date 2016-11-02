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

<form id="validate" action="<?php echo Yii::app()->params->base_path;?>admin/addCategory" method="post" enctype="multipart/form-data">
  <div class="widget">
    <div class="navbar">
      <div class="navbar-inner">
        <h6><a href="<?php echo Yii::app()->params->base_path;?>admin/categoryListing">Category List</a>&nbsp;&nbsp;<img src="<?php echo Yii::app()->params->base_url;?>images/path-arrow.png" alt="" border="0" />&nbsp;&nbsp;<?php echo $title;?></h6>
      </div>
    </div>
    <div class="well">
      <div class="control-group">
        <label class="control-label">Category Name<span class="text-error">* &nbsp;</span>:</label>
        <div class="controls">
          <input type="text" name="category_name" class="validate[required] span12 input-xlarge" placeholder="Enter category name" value="<?php if(isset($catData['category_name']) && $catData['category_name'] != "") { echo $catData['category_name']; } ?>"  <?php if($title == 'Update Category') {  ?>readonly="readonly" <?php } ?>/>
        </div>
      </div>
      <div class="control-group">
        <label class="control-label">Category Description<span class="text-error">* &nbsp;</span>:</label>
        <div class="controls">
          <input type="text" name="cat_description" class="validate[required] span12 input-xlarge" placeholder="Enter category description" value="<?php if(isset($catData['cat_description']) && $catData['cat_description'] != "") { echo $catData['cat_description']; } ?>" />
        </div>
      </div>
      <div class="control-group">
        <label class="control-label">Buffer Quantity<span class="text-error">* &nbsp;</span>:</label>
        <div class="controls">
          <input type="text" name="safetyMargin" id="safetyMargin" class="validate[required] span12 input-xlarge" placeholder="Enter safety margin" value="<?php if(isset($catData['safetyMargin']) && $catData['safetyMargin'] != "") { echo $catData['safetyMargin']; } ?>" onkeypress="return isNumberKey(event);"  />
        </div>
      </div>
      <?php 
	$unitObj = new Unit();
	$unitList = $unitObj->getAllUnits();
  ?>
      <div class="control-group">
        <label class="control-label">Unit ( Kg / Ltr / Pcs)<span class="text-error">* &nbsp;</span>:</label>
        <div class="controls">
          <select data-placeholder="Choose a unit..." name="unit_id"  id="unit_id" class="validate[required]" tabindex="2">
            <option value="">Select Unit</option>
            <?php foreach($unitList as $row ) { ?>
            <option value="<?php echo $row['unit_id']; ?>" <?php if(isset($catData['unit_id']) && $catData['unit_id'] == $row['unit_id'] ) { ?> selected="selected" <?php } ?>  ><?php echo $row['unit_name']; ?></option>
            <?php } ?>
          </select>
        </div>
      </div>
      <?php 
	$vendorObj = new Vendor();
	$vendorList = $vendorObj->getAllVendors();
  ?>
      <div class="control-group">
        <label class="control-label">Vendor<span class="text-error">* &nbsp;</span>:</label>
        <div class="controls">
          <select data-placeholder="Choose a vendor..." name="vendor_id"  id="vendor_id" class="validate[required]" tabindex="2">
            <option value="">Select Vendor</option>
            <?php foreach($vendorList as $row ) { ?>
            <option value="<?php echo $row['vendor_id']; ?>" <?php if(isset($catData['vendor_id']) && $catData['vendor_id'] == $row['vendor_id'] ) { ?> selected="selected" <?php } ?>  ><?php echo $row['vendor_name']; ?></option>
            <?php } ?>
          </select>
        </div>
      </div>
      <?php 
	$profitObj = new ProfitPercentageMaster();
	$profitList = $profitObj->getAllProfitPercentage();
  ?>
      <?php /*?><div class="control-group">
        <label class="control-label">Profit Percentage<span class="text-error">* &nbsp;</span>:</label>
        <div class="controls">
          <select data-placeholder="Choose a profit percentage..." name="profit_percentage_id"  id="profit_percentage_id" class="validate[required]" tabindex="2">
            <option value="">Select Profit Percentage</option>
            <?php foreach($profitList as $row ) { ?>
            <option value="<?php echo $row['id']; ?>" <?php if(isset($catData['profit_percentage_id']) && $catData['profit_percentage_id'] == $row['id']) { ?> selected="selected" <?php } ?>  ><?php echo $row['profit_percentage']; ?></option>
            <?php } ?>
          </select>
        </div>
      </div><?php */?>
      <div class="control-group">
        <label class="control-label">Profit Percentage(in %)<span class="text-error">* &nbsp;</span>:</label>
        <div class="controls">
          <input type="text" name="profit_percentage" id="profit_percentage" class="validate[required] span12 input-xlarge" placeholder="Enter profit percentage" value="<?php if(isset($catData['profit_percentage']) && $catData['profit_percentage'] != "") { echo $catData['profit_percentage']; } ?>" onkeypress="return isNumberKey(event);"  />
        </div>
      </div>
      
      
       <div class="control-group">
        <label class="control-label">Any discount ?<span class="text-error">* &nbsp;</span>:</label>
        <div class="controls">
         Yes &nbsp;<input type="radio" name="isDiscount" onchange="setDiscount(this.value);"  id="isDiscount" value="1" <?Php if(isset($catData['is_discount']) && $catData['is_discount'] == "1") { ?> checked="checked" <?php }?> />
         No &nbsp;<input type="radio" name="isDiscount" onchange="setDiscount(this.value);" id="isDiscount" value="0" <?Php if(isset($catData['is_discount']) && $catData['is_discount'] == "0") { ?> checked="checked" <?php }?>/>
         
          
        </div>
      </div>
      <?php
	  $css = 'none'; 
	  if(isset($catData['is_discount']) && $catData['is_discount'] == "1")
	  {
		$css = 'block';  
	  }
	  ?>
      
      <div id="discountsection" style="display:<?php echo $css; ?>;"> 
      <div class="control-group" >
        <label class="control-label">Discount Percentage<span class="text-error">* &nbsp;</span>:</label>
        <div class="controls">
         <input type="text" name="discount" id="discount" value="<?php if(isset($catData['discount'])) { echo $catData['discount'];} ?>" />
          
        </div>
      </div>
      
      <div class="control-group" >
        <label class="control-label">Discount From Sale Date<span class="text-error">* &nbsp;</span>:</label>
        <div class="controls">
         <input type="text" name="discount_from" id="discount_from" value="<?php if(isset($catData['discount_from'])) { echo $catData['discount_from'];} ?>" />
          
        </div>
     </div>   
     
      <div class="control-group" >
        <label class="control-label">Discount To<span class="text-error">* &nbsp;</span>:</label>
        <div class="controls">
         <input type="text" name="discount_to" id="discount_to" value="<?php if(isset($catData['discount_to'])) { echo date("Y-m-d",strtotime($catData['discount_to']));} ?>" />
          
        </div>
      </div>
      
      <div class="control-group" >
        <label class="control-label">Discount Discription<span class="text-error">* &nbsp;</span>:</label>
        <div class="controls">
         <input type="text" class="span12 input-xlarge" name="discount_desc" id="discount_desc" value="<?php if(isset($catData['discount_desc'])) { echo $catData['discount_desc'];} ?>" />
          
        </div>
      </div>
      
     </div> 
      
      <input type="hidden" <?php if(isset($catData['cat_id'])){ ?> value="<?php echo $catData['cat_id']; ?>" <?php } ?> name="id"/>
      <div class="form-actions align-right">
        <button type="submit" name="FormSubmit" class="btn btn-large btn-success">Submit</button>
        <button type="button" onclick="window.location.href='<?php echo Yii::app()->params->base_path;?>admin/categoryListing'" class="btn btn-large btn-danger">Cancel</button>
        <button type="reset" class="btn btn-large btn-info">Reset</button>
      </div>
    </div>
  </div>
</form>
<!-- /default form -->