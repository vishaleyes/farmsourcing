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

<form id="validate" action="<?php echo Yii::app()->params->base_path;?>admin/saveCouponReturn" method="post" enctype="multipart/form-data">
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
                        <option value="<?php echo $row['customer_id']; ?>"  ><?php echo $row['customer_name']; ?></option> 
                        <?php } ?>	 
                    </select>
                    <input style="text-align:right;" type="text" class="input-mini" name="customer_id_select" id="customer_id_select" onkeyup="selectCustomer();" />
        </div>
      </div>
    
      <div class="control-group">
        <label class="control-label">Coupon Number <span class="text-error">* &nbsp;</span>:</label>
        <div class="controls">
          <input type="text" name="coupon_number" class="validate[required] span12 input-xlarge" placeholder="Enter coupon number" value="<?php if(isset($couponData['coupon_number']) && $couponData['coupon_number'] != "") { echo $couponData['coupon_number']; } ?>"  />
        </div>
      </div>
 
      <div class="control-group">
        <label class="control-label">Coupon Return Amount<span class="text-error">* &nbsp;</span>:</label>
        <div class="controls">
          <input type="text" name="used_amount" id="used_amount" class="validate[required] span12 input-xlarge" placeholder="Enter coupon used amount" value="<?php if(isset($couponData['used_amount']) && $couponData['used_amount'] != "") { echo $couponData['used_amount']; } ?>" onkeypress="return isNumberKey(event);"  />
        </div>
      </div>
      
     <?php /*?> <div class="control-group">
        <label class="control-label">Used Amount<span class="text-error">* &nbsp;</span>:</label>
        <div class="controls">
          <input type="text" name="used_amount" id="used_amount" class="validate[required] span12 input-xlarge" placeholder="Enter used amount" value="<?php if(isset($couponData['used_amount']) && $couponData['used_amount'] != "") { echo $couponData['used_amount']; } ?>" onkeypress="return isNumberKey(event);"  />
        </div>
      </div><?php */?>
     
     
     
      <input type="hidden" <?php if(isset($couponData['id'])){ ?> value="<?php echo $couponData['id']; ?>" <?php } ?> name="id"/>
      <div class="form-actions align-right">
        <button type="submit" name="FormSubmit" class="btn btn-large btn-success">Submit</button>
        <button type="button" onclick="window.location.href='<?php echo Yii::app()->params->base_path;?>admin/couponEntry'" class="btn btn-large btn-danger">Cancel</button>
        <button type="reset" class="btn btn-large btn-info">Reset</button>
      </div>
    </div>
  </div>
</form>
<!-- /default form -->