<script type="text/javascript">
	
	function calculateTotal(id) {
		
		var received_quantity = $("#received_quantity_"+id).val();
		var quantity = $("#acceptedQuantity_"+id).val();
		if(Number(quantity) > Number(received_quantity))
		{
			$("#acceptedQuantity_"+id).val(Number(received_quantity));
			quantity = Number(received_quantity) ;				
		}
		var rate = $("#rate_"+id).val();

		if(rate == " ")
		{
			return false;	
		}
		
		totalAmount = Number(received_quantity) * Number(rate) ;
		$("#totalAmount_"+id).val(Number(totalAmount).toFixed(2));
		
		totalRejectedQuantity = Number(received_quantity) - Number(quantity) ;
		$("#rejectedQuantity_"+id).val(totalRejectedQuantity);
		calculateTotalPurchase();
	}
	
	function calculateTotalPurchase()
	{
		var count = $("#count").val();
		var total=0;
		
		for( i=1 ; i<=count ; i++)
		{
			var amount = $("#totalAmount_"+i).val();

			total = total + Number(amount);
		}
		$("#totalPurchase").val(Number(total).toFixed(2));
	}
	
	function validateForm() {
		$('#error').removeClass();
		$('#error').html('');
		
		var customer_id = $("#customer_id option:selected").val();
		 
		if(customer_id == '' || customer_id == 0)
		{
			$('#error').addClass('false');
			$('#error').html("<strong class='icon-remove' style='color:red; margin-top:10px; font-weight:bold;'>&nbsp; Please select customer.</strong>");
			return false;
		}
		else
		{
			$('#error').removeClass();
			$('#error').addClass('true');
			$('#error').html("");
			
			if(confirm("Are you sure ?"))
			{
				return true;
			}
			else
			{
				return false;
			}
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
		if (charCode > 31 && charCode != 46  && (charCode < 48 || charCode > 57))
		return false;
		}
		return true;
	}
	
	function getPODataFromDB(po_id)
	{
		window.location.href = "<?php echo Yii::app()->params->base_path;?>admin/getGoodsRecieptData/po_id/"+po_id;
	}


</script>
<!-- Default form -->


  <div class="widget">
    <div class="navbar">
      <div class="navbar-inner">
        <h6>Goods Receipt</h6>
      </div>
    </div>
    <div class="well">
 <form id="validate" onsubmit="return validateForm();" action="<?php echo Yii::app()->params->base_path;?>admin/saveGoodsRecieptData"  method="post" enctype="multipart/form-data">
      <table width="80%" id="ordertbl" align="center" border="0" cellspacing="5" cellpadding="5" >
        <tr>
            <td>
                <div class="control-group">
                    <div class="controls">
                        <label class="control-label">PO No. : </label>
                            <select data-placeholder="Choose a PO..."  name="po_id" id="po_id" class="select validate[required]" tabindex="2" onchange="getPODataFromDB(this.value);">
                                <option value=""></option>
                                <?php foreach($poData as $row ) { ?>
                                <option value="<?php echo $row['po_id']; ?>" <?php if($po_id == $row['po_id']) { ?> selected="selected" <?php } ?> ><?php echo $row['po_id']; ?></option> 
                                <?php } ?>	 
                            </select>
                    </div>             
                </div>
            </td>
            
            <td>
                <div class="control-group">
                    <div class="controls">
                        <label class="control-label">PO Date and Time :</label>
                        <input type="text" name="createdAt" class="validate[required] span12 input-large" placeholder="PO date" readonly="readonly" value="<?php if(isset($poDetailsData['createdAt']) && $poDetailsData['createdAt'] != "0000-00-00 00:00:00") { echo $poDetailsData['createdAt']; } ?>" />
                    </div>             
                </div>
            </td>
        </tr>
        
        <tr>
            <td>
                <div class="control-group">
                    <div class="controls">
                        <label class="control-label">Vendor Name:</label>
                        <input type="text" name="vendor_name" class="validate[required] span12 input-large" placeholder="vendor name" readonly="readonly" value="<?php if(isset($poDetailsData['vendor_name']) && $poDetailsData['vendor_name'] != "0000-00-00 00:00:00") { echo $poDetailsData['vendor_name']; } ?>" />
                    </div>             
                </div>
            </td>
            
            <td>&nbsp;</td>
        </tr>
      </table>
     
      
      
    
      <table class="table table-striped table-bordered">
      	<thead>
        <tr>
          <th style="text-align:center;">No</th>
          <th style="text-align:center;">Product</th>
          <th style="text-align:center;">PO Quantity</th>
          <th style="text-align:center;">Received Quantity</th>
          <th style="text-align:center;">Rejected Quantity</th>
          <th style="text-align:center;">Accepted Quantity</th>
          <th style="text-align:center;">Rate</th>
          <th style="text-align:center;">Amount</th>
        </tr>
        </thead>
        <?php $i=1;
		//print "<pre>";
		//print_r($poData);
		//exit;
		if(count($poData) > 0){
		foreach($poDescData as $row) { ?>
        
        <tr id="tabletr1">
          <td style="text-align:right;"><?php echo $i; ?></td>
          <td><input style="text-align:left;" type="text" class="input-xlarge textbox text-input" value="<?php echo $row['product_name']; ?>"  name="product_name_<?php echo $i;?>" id="product_name_<?php echo $i;?>" readonly="readonly" /></td>
          <input type="hidden" name="product_id_<?php echo $i;?>" id="product_id_<?php echo $i;?>" value="<?php if(isset($row['product_id']) && $row['product_id'] != "") { echo $row['product_id']; } ?>" /> 
          <td><input style="text-align:right;" type="text" class="input-mini textbox validate[required,custom[number]] text-input" value="<?php echo $row['quantity']; ?>" name="quantity_<?php echo $i;?>"  onkeypress="return isNumberKey(event);" id="quantity_<?php echo $i;?>" size="8" readonly="readonly" /></td>
         <td><input style="text-align:right;" type="text" class="input-mini textbox text-input" value="<?php echo $row['quantity']; ?>"  name="received_quantity_<?php echo $i;?>" onkeyup="calculateTotal(<?php echo $i;?>);" onkeypress="return isNumberKey(event);" id="received_quantity_<?php echo $i;?>"  /></td>
         <td><input style="text-align:right;" type="text" class="input-mini textbox text-input" value="0"  name="rejectedQuantity_<?php echo $i;?>" onkeypress="return isNumberKey(event);" readonly="readonly" id="rejectedQuantity_<?php echo $i;?>"  /></td>
         <td><input style="text-align:right;" type="text" class="input-mini textbox text-input" value="<?php echo $row['quantity']; ?>"  name="acceptedQuantity_<?php echo $i;?>" onkeypress="return isNumberKey(event);" id="acceptedQuantity_<?php echo $i;?>" onkeyup="calculateTotal(<?php echo $i;?>);" /></td>
         <td><input style="text-align:right;" type="text" class="textbox text-input" value="<?php echo $row['price'] ; ?>"  name="rate_<?php echo $i;?>" id="rate_<?php echo $i;?>" onkeypress="return isNumberKey(event);" onkeyup="calculateTotal(<?php echo $i;?>);" /></td>
         <td><input style="text-align:right;" type="text" class="textbox text-input" value="<?php echo $row['amount']; ?>"  name="totalAmount_<?php echo $i;?>" id="totalAmount_<?php echo $i;?>" readonly="readonly" /></td>
        </tr>
        <input type="hidden" name="id_<?php echo $i;?>" id="id_<?php echo $i;?>" value="<?php if(isset($row['id']) && $row['id'] != "") { echo $row['id']; } ?>" />
        <?php  $i++; } ?>
        <tr id="tabletr1">
       		<td colspan="7">&nbsp;</td>
          	<td><input type="text" style="text-align:right;" name="totalPurchase" id="totalPurchase" value="<?php echo $poDetailsData['total_amount']; ?>" readonly="readonly" /></td>
        </tr>
        <?PHP	}else {	 ?>
        <tr id="tabletr1">
          <td colspan="8">No Data Found.</td>
        </tr>
       <?php } ?>
      </table>
     
      
      <input type="hidden" name="count" id="count" value="<?php echo $i - 1; ?>" />
      <input type="hidden" name="po_id" id="po_id" value="<?php if(isset($poDetailsData['po_id']) && $poDetailsData['po_id'] != "") { echo $poDetailsData['po_id']; } ?>" />
      <p>&nbsp;</p>
      <div class="form-actions align-right">
      <span id="error"></span>
        <button type="submit" name="FormSubmit" class="btn btn-large btn-success">Submit</button>
        <button type="button" onclick="window.location.href='<?php echo Yii::app()->params->base_path;?>admin/salesOrderListing'" class="btn btn-large btn-danger">Cancel</button>
        <button type="reset" class="btn btn-large btn-info">Reset</button>
      </div>
    </div>
  </div>
</form>
<!-- /default form --> 
