<script type="text/javascript" >
	function isNumberKeyNew(evt)
	{
		
		 if(evt.keyCode == 9)
		 {
		  
		 }
		 else
		 {
		  var charCode = (evt.which) ? evt.which : event.keyCode 
		  if (charCode > 31 && (charCode < 48 || charCode > 57))
		  return false;
		 }
		 return true;
	}
</script> 
<!-- Default form -->
<form id="validate" action="<?php echo Yii::app()->params->base_path;?>admin/addCustomer" method="post" enctype="multipart/form-data">
<div class="widget">
<div class="navbar"><div class="navbar-inner"><h6><a href="<?php echo Yii::app()->params->base_path;?>admin/customerListing">Customer List</a>&nbsp;&nbsp;<img src="<?php echo Yii::app()->params->base_url;?>images/path-arrow.png" alt="" border="0" />&nbsp;&nbsp;<?php echo $title;?></h6></div></div>

<div class="well">
<div class="control-group">
<label class="control-label">Customer Name<span class="text-error">* &nbsp;</span>:</label>
<div class="controls"><input type="text" name="customer_name" class="validate[required] span12 input-xlarge" placeholder="Enter customer name" value="<?php if(isset($customerData['customer_name']) && $customerData['customer_name'] != "") { echo $customerData['customer_name']; } ?>" /></div>

</div>

<div class="control-group">
<label class="control-label">Customer Email:</label>
<div class="controls"><input type="text" name="cust_email" class="span12 input-xlarge" placeholder="Enter customer email" value="<?php if(isset($customerData['cust_email']) && $customerData['cust_email'] != "") { echo $customerData['cust_email']; } ?>" />
</div>
</div>

<div class="control-group">
<label class="control-label">Customer Phone:</label>
<div class="controls"><input type="text" name="contact_no" class="span12 input-xlarge" placeholder="Enter customer phone" value="<?php if(isset($customerData['contact_no']) && $customerData['contact_no'] != "") { echo $customerData['contact_no']; } ?>" /></div>
</div>

<div class="control-group">
<label class="control-label">Mobile Number<span class="text-error">* &nbsp;</span>:</label>
<div class="controls"><input type="text" name="mobile_no" class="validate[required] span12 input-xlarge" placeholder="Enter customer mobile" value="<?php if(isset($customerData['mobile_no']) && $customerData['mobile_no'] != "") { echo $customerData['mobile_no']; } ?>" onkeypress="return isNumberKeyNew(event);" /></div>
</div>

<div class="control-group">
<label class="control-label">Block:</label>
<div class="controls"><input type="text" name="block" class="span12 input-xlarge" placeholder="Enter customer block " value="<?php if(isset($customerData['block']) && $customerData['block'] != "") { echo $customerData['block']; } ?>" /></div>
</div>


<div class="control-group">
<label class="control-label">House Number<span class="text-error">* &nbsp;</span>:</label>
<div class="controls"><input type="text" name="house_no" class="validate[required] span12 input-xlarge" placeholder="Enter customer house number" value="<?php if(isset($customerData['house_no']) && $customerData['house_no'] != "") { echo $customerData['house_no']; } ?>" /></div>
</div>

<div class="control-group">
<label class="control-label">Building Name<span class="text-error">* &nbsp;</span>:</label>
<div class="controls"><input type="text" name="building_name" class="validate[required] span12 input-xlarge" placeholder="Enter customer building name" value="<?php if(isset($customerData['building_name']) && $customerData['building_name'] != "") { echo $customerData['building_name']; } ?>" /></div>
</div>

<div class="control-group">
<label class="control-label">Landmark 1:</label>
<div class="controls"><input type="text" name="landmark1" class="span12 input-xlarge" placeholder="Enter customer landmark 1" value="<?php if(isset($customerData['landmark1']) && $customerData['landmark1'] != "") { echo $customerData['landmark1']; } ?>" /></div>
</div>

<div class="control-group">
<label class="control-label">Landmark 2:</label>
<div class="controls"><input type="text" name="landmark2" class="span12 input-xlarge" placeholder="Enter customer landmark 2" value="<?php if(isset($customerData['landmark2']) && $customerData['landmark2'] != "") { echo $customerData['landmark2']; } ?>" /></div>
</div>

<div class="control-group">
<label class="control-label">Area<span class="text-error">* &nbsp;</span>:</label>
<div class="controls"><input type="text" name="area" class="validate[required] span12 input-xlarge" placeholder="Enter customer area" value="<?php if(isset($customerData['area']) && $customerData['area'] != "") { echo $customerData['area']; } ?>" /></div>
</div>

<div class="control-group">
<label class="control-label">City<span class="text-error">* &nbsp;</span>:</label>
<div class="controls"><input type="text" name="city" class="validate[required] span12 input-xlarge" placeholder="Enter customer city" value="<?php if(isset($customerData['city']) && $customerData['city'] != "") { echo $customerData['city']; } else { echo "Ahmedabad"; } ?>" /></div>
</div>

<div class="control-group">
<label class="control-label">Country<span class="text-error">* &nbsp;</span>:</label>
<div class="controls"><input type="text" name="country" class="validate[required] span12 input-xlarge" placeholder="Enter Country" value="<?php if(isset($customerData['country']) && $customerData['country'] != "") { echo $customerData['country']; }else { echo "India"; }  ?>" /></div>
</div>

<div class="control-group">
<label class="control-label">Pin Code<span class="text-error">* &nbsp;</span>:</label>
<div class="controls"><input type="text" name="pincode" class="validate[required] span12 input-xlarge" placeholder="Enter pincode" value="<?php if(isset($customerData['pincode']) && $customerData['pincode'] != "") { echo $customerData['pincode']; } ?>" /></div>
</div>


<?php /*?><div class="control-group">
<label class="control-label">Total Purchase:</label>
<div class="controls"><input type="text" name="total_purchase" class="span12 input-xlarge" placeholder="Enter customer phone" value="<?php if(isset($customerData['total_purchase']) && $customerData['total_purchase'] != "") { echo $customerData['total_purchase']; } ?>" /></div>
</div>

<div class="control-group">
<label class="control-label">Credit:</label>
<div class="controls"><input type="text" name="credit" class="span12 input-xlarge" placeholder="Enter customer credit" value="<?php if(isset($customerData['credit']) && $customerData['credit'] != "") { echo $customerData['credit']; } ?>" /></div>
</div>

<div class="control-group">
<label class="control-label">Debit:</label>
<div class="controls"><input type="text" name="debit" class="span12 input-xlarge" placeholder="Enter customer debit" value="<?php if(isset($customerData['debit']) && $customerData['debit'] != "") { echo $customerData['debit']; } ?>" /></div>
</div><?php */?>

<?php 
	$zoneObj = new Zone();
	$zoneData = $zoneObj->getAllZones();
?>

<div class="control-group">
		<div class="controls">
        <label class="control-label">Zone<span class="text-error">* &nbsp;</span>:</label>
			<select data-placeholder="Choose a zone..." name="zone_id"  id="zone_id" class="validate[required]" tabindex="2">
				<option value="">select zone</option>
				<?php foreach($zoneData as $row ) { ?>
				<option value="<?php echo $row['zone_id']; ?>" <?php if(isset($customerData['zone_id']) && $customerData['zone_id'] == $row['zone_id'] ) { ?> selected="selected" <?php } ?>  ><?php echo $row['zoneName']; ?></option> 
				<?php } ?>	 
			</select>
		</div>             
	</div>
    
    <div class="control-group">
        <label class="control-label">Customer Type<span class="text-error">* &nbsp;</span>:</label>
        <div class="controls">
         Retail &nbsp;<input type="radio" name="customer_type" id="customer_type" value="0" checked="checked" />
         Wholesale &nbsp;<input type="radio" name="customer_type" id="customer_type" value="1" <?Php if(isset($customerData['customer_type']) && $customerData['customer_type'] == "1") { ?> checked="checked" <?php }?>/>
        </div>
      </div>

<div class="control-group">
<label class="control-label">Membership Card No:</label>
<div class="controls"><input type="text" name="membership_no" class="span12 input-xlarge" placeholder="Enter customer membership card no" value="<?php if(isset($customerData['membership_no']) && $customerData['membership_no'] != "") { echo $customerData['membership_no']; } ?>" /></div>
</div>



<input type="hidden" <?php if(isset($customerData['customer_id'])){ ?> value="<?php echo $customerData['customer_id']; ?>" <?php } ?> name="id"/>

<input type="hidden" <?php if(isset($customerData['representativeId'])){ ?> value="<?php echo $customerData['representativeId']; ?>" <?php } ?> name="representativeId"/>
<div class="form-actions align-right">
<button type="submit" name="FormSubmit" class="btn btn-large btn-success">Submit</button>
<button type="button" onclick="window.location.href='<?php echo Yii::app()->params->base_path;?>admin/customerListing'" class="btn btn-large btn-danger">Cancel</button>
<button type="reset" class="btn btn-large btn-info">Reset</button>
</div>

</div>

</div>
</form>
<!-- /default form -->