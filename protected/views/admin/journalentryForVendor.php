<script type="text/javascript"> 
   	function validateForm() {
		$('#error').removeClass();
		$('#error').html('');
		
		var credit = $("#credit").val();
		var debit = $("#debit").val();
		var vendor_id = $("#vendor_id option:selected").val();
		var paymentType = $("#paymentType option:selected").val();
		 
		if(vendor_id == '' || vendor_id == 0)
		{
			$('#error').addClass('false');
			$('#error').html("<strong class='icon-remove' style='color:red; margin-top:10px; font-weight:bold;'>&nbsp; Please select vendor.</strong>");
			return false;
		}
		else if(paymentType == '' || paymentType == 0)
		{
			$('#error').addClass('false');
			$('#error').html("<strong class='icon-remove' style='color:red; margin-top:10px; font-weight:bold;'>&nbsp; Please select payment type.</strong>");
			return false;
		}
		else if((credit == '' || credit == 0) && (debit == '' || debit == 0) )
		{
			$('#error').addClass('false');
			$('#error').html("<strong class='icon-remove' style='color:red; margin-top:10px; font-weight:bold;'>&nbsp; Please enter atleast one value.</strong>");
			return false;
		}
		else
		{
			$('#error').removeClass();
			$('#error').addClass('true');
			$('#error').html("<strong class='icon-ok' style='color:green; margin-top:10px; font-weight:bold;'>&nbsp; Ok.</strong>");
			return true;
		}
   }
   
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
<form id="validate" action="<?php echo Yii::app()->params->base_path;?>admin/addGeneralEntryforVendor" method="post" enctype="multipart/form-data" onsubmit="return validateForm();">
<div class="widget">
<div class="navbar"><div class="navbar-inner"><h6>Create New Entry</h6></div></div>

<div class="well">

	<?php 
	
		$vendorObj = new Vendor();
		$vendorList = $vendorObj->getAllVendors();		

	?>
   
                                            
    <div class="control-group">
        <label class="control-label">Vendor Name<span class="text-error">* &nbsp;</span>:</label>
        <div class="controls">
                <select data-placeholder="Choose a vendor..." name="vendor_id" id="vendor_id" class="validate[required] styled" tabindex="">
                    <option value="">select vendor</option>
                    <?php foreach($vendorList as $row ) { ?>
                    <option value="<?php echo $row['vendor_id']; ?>"  ><?php echo $row['vendor_name']; ?></option> 
                    <?php } ?>
                </select>
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label">Payment Type<span class="text-error">* &nbsp;</span>:</label>
        <div class="controls">
                <select data-placeholder="Choose a payment type..." name="paymentType" id="paymentType" class="validate[required] styled" tabindex="">
                    <option value="0" selected="selected"> Select payment type</option>
                    <option value="1"> Cash</option>
                    <option value="2"> Card</option>
                    <option value="3"> Cheque</option>
                </select>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label">Received<span class="text-error">* &nbsp;</span>:</label>
        <div class="controls">
            <input type="text" style="text-align:right;" name="debit" id="debit" onkeypress="return isNumberKey(event);" class="validate[required] span12 input" placeholder="Enter received amount" />
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label">Paid<span class="text-error">* &nbsp;</span>:</label>
        <div class="controls">
            <input type="text" style="text-align:right;" name="credit" id="credit"  onkeypress="return isNumberKey(event);" class="validate[required] span12 input" placeholder="Enter paid amount"  />
        </div>
    </div>

    <div class="form-actions align-right">
        <span id="error"></span>
            <button type="submit" name="FormSubmit" class="btn btn-large btn-success">Submit</button>
            <button type="button" onclick="window.location.href='<?php echo Yii::app()->params->base_path;?>admin/showJournalEntry'" class="btn btn-large btn-danger">Cancel</button>
    </div>

</div>

</div>
</form>
<!-- /default form -->
