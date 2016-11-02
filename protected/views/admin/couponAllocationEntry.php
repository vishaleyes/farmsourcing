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
function selectCustomer()
	{
	 var id = $("#customer_id_select").val();
	
	 $("#customer_id option[value="+id+"]").prop("selected", true);
	}
	
	function selectCustomer1()
	{
	 var customer_id = $("#customer_id option:selected").val();
	
	 $("#customer_id_select").val(customer_id);
	}
</script> 

<form id="validate" action="<?php echo Yii::app()->params->base_path;?>admin/saveCouponAllocation" method="post" enctype="multipart/form-data">
  <div class="widget">
    <div class="navbar">
      <div class="navbar-inner">
        <h6><a href="<?php echo Yii::app()->params->base_path;?>admin/couponEntry">Coupon Entry</a>&nbsp;&nbsp;<img src="<?php echo Yii::app()->params->base_url;?>images/path-arrow.png" alt="" border="0" />&nbsp;&nbsp;<?php echo $title;?></h6>
      </div>
    </div>
    <div class="well">
    
         <div class="control-group">
      <?php 
			$customerObj = new Customers();
			$customerList = $customerObj->getAllCustomers();
		  ?>
        <label class="control-label">Customer <span class="text-error">* &nbsp;</span>:</label>
        <div class="controls">
           <select data-placeholder="Choose a customer..." name="customer_id" id="customer_id" onchange="selectCustomer1();" class="validate[required]" tabindex="2">
                        <option value="">select customer</option>
						<?php foreach($customerList as $row ) { ?>
                        <option value="<?php echo $row['customer_id']; ?>"  <?php if(isset($couponData['customer_id']) &&  $couponData['customer_id'] == $row['customer_id'] ) { ?> selected="selected" <?php } ?> ><?php echo $row['customer_name']; ?></option> 
                        <?php } ?>	 
                    </select>
                    <input style="text-align:right;" type="text" class="input-mini" name="customer_id_select" id="customer_id_select" onkeyup="selectCustomer();" value="<?php if(isset($couponData['customer_id_select']) &&  $couponData['customer_id_select'] != '' ) { echo $couponData['customer_id_select'] ; } ?>" />
        </div>
      </div>
    
      <div class="control-group">
        <label class="control-label">Coupon Number <span class="text-error">* &nbsp;</span>:</label>
        <div class="controls">
          <input type="text" name="coupon_number" class="validate[required] span12 input-xlarge" placeholder="Enter coupon number" value="<?php if(isset($couponData['coupon_number']) &&  $couponData['coupon_number'] != '' ) { echo $couponData['coupon_number'] ; } ?>"  />
        </div>
      </div>
      
  <?php /*?><div class="control-group">
        <label class="control-label">RS OR PERCENTAGE?<span class="text-error">* &nbsp;</span>:</label>
        <div class="controls">
          RS &nbsp;<input type="radio" name="promocode_type" id="promocode_type" <?php if(isset($couponData['coupon_type']) &&  $couponData['coupon_type'] == '0') { ?> checked="checked"<?php } ?>  value="0" />
          % &nbsp;<input type="radio" name="promocode_type" <?php if(isset($couponData['coupon_type']) &&  $couponData['coupon_type'] == '1') { ?> checked="checked"<?php } ?>  id="promocode_type" value="1" />
        </div>
      </div><?php */?>
 
 
      <div class="control-group">
        <label class="control-label">Coupon Amount<span class="text-error">* &nbsp;</span>:</label>
        <div class="controls">
          <input type="text" name="coupon_amount" id="coupon_amount" class="validate[required] span12 input-xlarge" placeholder="Enter coupon amount" value="<?php if(isset($couponData['coupon_amount']) &&  $couponData['coupon_amount'] != '' ) { echo $couponData['coupon_amount'] ; } ?>" onkeypress="return isNumberKey(event);"  />
        </div>
      </div>
      
     <?php /*?> <div class="control-group">
        <label class="control-label">Used Amount<span class="text-error">* &nbsp;</span>:</label>
        <div class="controls">
          <input type="text" name="used_amount" id="used_amount" class="validate[required] span12 input-xlarge" placeholder="Enter used amount" value="<?php if(isset($couponData['used_amount']) && $couponData['used_amount'] != "") { echo $couponData['used_amount']; } ?>" onkeypress="return isNumberKey(event);"  />
        </div>
      </div><?php */?>
     
     
     
      <input type="hidden" value="<?php if(isset($couponData['id']) &&  $couponData['id'] != '' ) { echo $couponData['id'] ; } ?>" name="id"/>
      <div class="form-actions align-right">
        <button type="submit" name="FormSubmit" class="btn btn-large btn-success">Submit</button>
        <button type="button" onclick="window.location.href='<?php echo Yii::app()->params->base_path;?>admin/couponEntry'" class="btn btn-large btn-danger">Cancel</button>
        <button type="reset" class="btn btn-large btn-info">Reset</button>
      </div>
    </div>
  </div>
</form>
<!-- /default form -->