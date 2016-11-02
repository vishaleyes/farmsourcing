<script type="text/javascript">
	
	function calculateTotal(id) {
		
		var sale_quantity = $("#sale_quantity_"+id).val();
		var rejected_quantity = $("#rejected_quantity_"+id).val();
		
		if(Number(rejected_quantity) > Number(sale_quantity))
		{
			$("#rejected_quantity_"+id).val(Number(sale_quantity));
			rejected_quantity = Number(sale_quantity) ;				
		}
		
		var price = $("#price_"+id).val();

		if(price == " ")
		{
			return false;	
		}
		
		amount = Number(rejected_quantity) * Number(price) ;
		$("#amount_"+id).val(Number(amount).toFixed(2));
		
		calculateTotalPurchase();
	}
	
	function calculateTotalPurchase()
	{
		var count = $("#count").val();
		var total=0;
		
		for( i=1 ; i<=count ; i++)
		{
			var amount = $("#amount_"+i).val();

			total = total + Number(amount);
		}
		$("#totalAmount").val(Number(total).toFixed(2));
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
		if (charCode > 31 && (charCode < 48 || charCode > 57))
		return false;
		}
		return true;
	}
	
	function getSODataFromDB(so_id)
	{
		window.location.href = "<?php echo Yii::app()->params->base_path;?>admin/getSalesOrderData/so_id/"+so_id;
	}


</script>
<!-- Default form -->


  <div class="widget">
    <div class="navbar">
      <div class="navbar-inner">
        <h6><a href="<?php echo Yii::app()->params->base_path;?>admin/rejectionListing">Rejection List</a>&nbsp;&nbsp;<img src="<?php echo Yii::app()->params->base_url;?>images/path-arrow.png" alt="" border="0" />&nbsp;&nbsp;Rejecton Order</h6>
      </div>
    </div>
    <div class="well">
 <form id="validate" onsubmit="return validateForm();" action="<?php echo Yii::app()->params->base_path;?>admin/saveRejectedData" method="post" enctype="multipart/form-data">
      <table width="80%" id="ordertbl" align="center" border="0" cellspacing="5" cellpadding="5" >
        <tr>
            <td>
                <div class="control-group">
                    <div class="controls">
                        <label class="control-label">Order No. : </label>
                            <select data-placeholder="Choose a Order..."  name="so_id" id="so_id" class="select validate[required]" tabindex="2" onchange="getSODataFromDB(this.value);">
                                <option value=""></option>
                                <?php foreach($orderdata as $row ) { ?>
                                <option value="<?php echo $row['so_id']; ?>" <?php if($_GET['so_id'] == $row['so_id']) { ?> selected="selected" <?php } ?> ><?php echo $row['so_id']; ?></option> 
                                <?php } ?>	 
                            </select>
                    </div>             
                </div>
            </td>
            
            <td>
                <div class="control-group">
                    <div class="controls">
                        <label class="control-label">SO Date and Time :</label>
                        <input type="text" name="delivery_date" class="validate[required] span12 input-large" placeholder="Delivery date" readonly="readonly" value="<?php if(isset($soDetailsData['delivery_date']) && $soDetailsData['delivery_date'] != "0000-00-00 00:00:00") { echo date("d-m-Y",strtotime($soDetailsData['delivery_date'])); } ?>" />
                    </div>             
                </div>
            </td>
        </tr>
        
        <tr>
            <td>
            	<div class="control-group">
                    <div class="controls">
                        <label class="control-label">Customer Name:</label>
                        <input type="text" name="customer_name" class="validate[required] span12 input-large" placeholder="customer name" readonly="readonly" value="<?php if(isset($soDetailsData['customer_name']) && $soDetailsData['customer_name'] != "") { echo $soDetailsData['customer_name']; } ?>" />
                    </div>             
                </div>
            </td>
            
            <td>
            	<div class="control-group">
                    <div class="controls">
                        <label class="control-label">Driver Name:</label>
                        <input type="text" name="driver_name" class="validate[required] span12 input-large" placeholder="driver name" readonly="readonly" value="<?php if(isset($soDetailsData['driver']) && $soDetailsData['driver'] != "") { echo $soDetailsData['driver']; } ?>" />
                    </div>             
                </div>
            </td>
        </tr>
      </table>
     
      
      
    
      <table class="table table-striped table-bordered">
      	<thead>
        <tr>
          <th style="text-align:center;">No</th>
          <th style="text-align:center;">Product</th>
          <th style="text-align:center;">Sale Quantity</th>
          <th style="text-align:center;">Rejected Quantity</th>
          <th style="text-align:center;">Price</th>
          <th style="text-align:center;">Amount</th>
          <th style="text-align:center;">Rejection Reason</th>
        </tr>
        </thead>
        <?php $i=1;
		//print "<pre>";
		//print_r($poData);
		//exit;
		
		if(count($soDescData) > 0){
		foreach($soDescData as $row) { ?>
       
        
        <tr id="tabletr1">
          <td style="text-align:right;"><?php echo $i; ?></td>
          <td><input style="text-align:left;" type="text" class="input-xlarge textbox text-input" value="<?php echo $row['product_name']; ?>"  name="product_name_<?php echo $i;?>" id="product_name_<?php echo $i;?>" readonly="readonly" />
          
           <input type="hidden" name="product_id_<?php echo $i;?>" id="product_id_<?php echo $i;?>" value="<?php  echo $row['product_id'];  ?>" />
          </td> 
          
          <td><input style="text-align:right;" type="text" class="input-small textbox validate[required,custom[number]] text-input" value="<?php echo $row['sale_quantity']; ?>" name="sale_quantity_<?php echo $i;?>"  onkeypress="return isNumberKey(event);" id="sale_quantity_<?php echo $i;?>" size="8" readonly="readonly" /></td>
          
         <td><input style="text-align:right;" type="text" class="input-small textbox text-input" value="0"  name="rejected_quantity_<?php echo $i;?>" onkeyup="calculateTotal(<?php echo $i;?>);" onkeypress="return isNumberKey(event);" id="rejected_quantity_<?php echo $i;?>"  /></td>
         
         
         <td><input style="text-align:right;" type="text" class="input-small textbox text-input" value="<?php echo $row['price']; ?>"  name="price_<?php echo $i;?>" onkeypress="return isNumberKey(event);" id="price_<?php echo $i;?>" onkeyup="calculateTotal(<?php echo $i;?>);" readonly="readonly"/></td>
         
         
         <td><input style="text-align:right;" type="text" class="input-small textbox text-input" value=""  name="amount_<?php echo $i;?>" onkeypress="return isNumberKey(event);" readonly="readonly" id="amount_<?php echo $i;?>"  /></td>
         <td width="30%"><input style="width:100%;" type="text" class="textbox text-input input-xlarge" value=""  name="reason_<?php echo $i;?>" id="reason_<?php echo $i;?>"  /></td>
         
        </tr>
        <input type="hidden" name="id_<?php echo $i;?>" id="id_<?php echo $i;?>" value="<?php if(isset($row['id']) && $row['id'] != "") { echo $row['id']; } ?>" />
        <?php  $i++; } ?>
         <tr id="tabletr1">
       		<td colspan="5">&nbsp;</td>
          	<td><input type="text" style="text-align:right;" class="input-small textbox text-input" name="totalAmount" id="totalAmount" value="0" readonly="readonly" /></td>
            <td>&nbsp;</td>
        </tr>
        <?PHP	}else {	 ?>
        <tr id="tabletr1">
          <td colspan="8">No Data Found.</td>
        </tr>
       <?php } ?>
      </table>
     
      <input type="hidden" name="delivery_id" id="delivery_id" value="<?php if(isset($soDetailsData['delivery_id']) && $soDetailsData['delivery_id'] != "") { echo $soDetailsData['delivery_id']; } ?>" />
      <input type="hidden" name="driver_id" id="driver_id" value="<?php if(isset($soDetailsData['driver_id']) && $soDetailsData['driver_id'] != "") { echo $soDetailsData['driver_id']; } ?>" />
      <input type="hidden" name="count" id="count" value="<?php echo $i - 1; ?>" />
      <input type="hidden" name="so_id" id="so_id" value="<?php if(isset($_GET['so_id']) && $_GET['so_id'] != "") { echo $_GET['so_id']; } ?>" />
       <input type="hidden" name="customer_id" id="customer_id" value="<?php echo $soDetailsData['customer_id']; ?>" />
      <p>&nbsp;</p>
      <div class="form-actions align-right">
      <span id="error"></span>
        <button type="submit" name="FormSubmit" class="btn btn-large btn-success">Submit</button>
        <button type="button" onclick="window.location.href='<?php echo Yii::app()->params->base_path;?>admin/rejectionListing'" class="btn btn-large btn-danger">Cancel</button>
        <button type="reset" class="btn btn-large btn-info">Reset</button>
      </div>
    </div>
  </div>
</form>
<!-- /default form --> 