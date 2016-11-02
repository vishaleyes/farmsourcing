<script type="text/javascript">
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
<!-- Default form -->
<form id="validate" action="<?php echo Yii::app()->params->base_path;?>admin/addVendor" method="post" enctype="multipart/form-data">
<div class="widget">
<div class="navbar"><div class="navbar-inner"><h6><a href="<?php echo Yii::app()->params->base_path;?>admin/vendorListing">Vendor List</a>&nbsp;&nbsp;<img src="<?php echo Yii::app()->params->base_url;?>images/path-arrow.png" alt="" border="0" />&nbsp;&nbsp;<?php echo $title;?></h6></div></div>

<div class="well">

<div class="control-group">
<label class="control-label">Vendor Name<span class="text-error">* &nbsp;</span>:</label>
<div class="controls"><input type="text" name="vendor_name" class="validate[required] span12 input-xlarge" placeholder="Enter vendor name" value="<?php if(isset($result['vendor_name']) && $result['vendor_name'] != "") { echo $result['vendor_name']; } ?>" /></div>
</div>

<div class="control-group">
<label class="control-label">Contact Name<span class="text-error">* &nbsp;</span>:</label>
<div class="controls"><input type="text" name="contact_name" class="validate[required] span12 input-xlarge" placeholder="Enter contact name" value="<?php if(isset($result['contact_name']) && $result['contact_name'] != "") { echo $result['contact_name']; } ?>" /></div>
</div>

<div class="control-group">
<label class="control-label">Email<span class="text-error">* &nbsp;</span>:</label>
<div class="controls"><input type="text" name="email" class="validate[required,custom[email]] span12 input-xlarge" placeholder="Enter email address" value="<?php if(isset($result['email']) && $result['email'] != "") { echo $result['email']; } ?>" /></div>
</div>



<div class="control-group">
<label class="control-label">Contact No<span class="text-error">* &nbsp;</span>:</label>
<div class="controls"><input type="text" name="contact_no" class="validate[required] span12 input-xlarge" placeholder="Enter contact nomber" value="<?php if(isset($result['contact_no']) && $result['contact_no'] != "") { echo $result['contact_no']; } ?>" /></div>
</div>

<div class="control-group">
    <label class="control-label">Address<span class="text-error">* &nbsp;</span>:</label>
    <div class="controls">
    <textarea rows="5" cols="47" name="address" class="validate[required] span12"><?php if(isset($result['address']) && $result['address'] != "") { echo $result['address']; } ?></textarea>
    </div>
</div>

<?php /*?><div class="control-group">
    <label class="control-label">Credit :</label>
    <div class="controls">
    	<input type="text" name="credit" class="span12 input-xlarge" onkeypress="return isNumberKey(event);" placeholder="Enter credit amount" value="<?php if(isset($result['credit']) && $result['credit'] != "") { echo $result['credit']; } ?>" />
    </div>
</div>

<div class="control-group">
    <label class="control-label">Debit :</label>
    <div class="controls">
    	<input type="text" name="debit" class="span12 input-xlarge" onkeypress="return isNumberKey(event);" placeholder="Enter debit amount" value="<?php if(isset($result['debit']) && $result['debit'] != "") { echo $result['debit']; } ?>" />
    </div>
</div><?php */?>


 <input type="hidden" <?php if(isset($result['vendor_id'])){ ?> value="<?php echo $result['vendor_id']; ?>" <?php } ?> name="id"/>
<div class="form-actions align-right">
<button type="submit" name="FormSubmit" class="btn btn-large btn-success">Submit</button>
<button type="button" onclick="window.location.href='<?php echo Yii::app()->params->base_path;?>admin/vendorListing'" class="btn btn-large btn-danger">Cancel</button>
<button type="reset" class="btn btn-large btn-info">Reset</button>
</div>

</div>

</div>
</form>
<!-- /default form -->