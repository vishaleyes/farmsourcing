<?php 
		$productObj = new Product();
		$productList = $productObj->getAllProducts();
?>


<script type="text/javascript">
	
	function calculateTotal(productId) {
		
		var quantity = $("#quantity"+productId).val();
		var rate = $("#rate"+productId).val();

		if(rate == " ")
		{
			return false;	
		}

		totalAmount = Number(quantity) * Number(rate) ;

		$("#amount"+productId).val(totalAmount);
		calculateTotalPurchase();

	}
	
	function calculateTotalPurchase()
	{
		var count = $("#count").val();
		var total=0;
		
		for( i=1 ; i<=count ; i++)
		{
			var amount = $("#amount"+i).val();

			total = total + Number(amount);
		}
		$("#totalPurchase").val(total);
	}
	
   
	function getProductDetail(count)
	{
	// var upc_code = $("#upc_code").val();
	 var product_id = $("#product"+count+" option:selected").val();
	 
	 $.ajax({
	  type: 'POST',
	  url: '<?php echo Yii::app()->params->base_path;?>admin/getProductDetail',
	  data: 'product_id='+product_id,
	  cache: false,
	  success: function(data)
	  {
		  if(data == 0)
		  {
				alert("data not found.");
				return false;  
		  }else{
			   var arr = data.split(',');
			   
			   $('#unit'+count).attr( "value",arr[0]);
			   $('#rate'+count).attr( "value",arr[1]);
			   return true;
		  }
	  }
	 });
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


</script>
<!-- Default form -->

<form id="validate" onsubmit="return validateForm();" action="<?php echo Yii::app()->params->base_path;?>admin/saveCouponFloat" method="post" enctype="multipart/form-data">
  <div class="widget">
    <div class="navbar">
      <div class="navbar-inner">
        <h6><a href="<?php echo Yii::app()->params->base_path;?>admin/deliverySlip">Delivery Slip</a>&nbsp;&nbsp;<img src="<?php echo Yii::app()->params->base_url;?>images/path-arrow.png" alt="" border="0" />&nbsp;&nbsp;Cash / Coupon Float to Driver</h6>
                
      <label style="float:right; margin-right:20px; margin-top:10px; vertical-align:middle; font-weight:bolder;"><?php if(isset($delivery_date) && $delivery_date != '') { echo "Delivery Date: &nbsp;".date("d-m-Y",strtotime($delivery_date)) ; } ?></label>
        
        
        <input type="hidden" id="delivery_date" name="delivery_date" class="validate[required]" placeholder="select delivery date" value="<?php if(isset(Yii::app()->session['delivery_date_for_so']) && Yii::app()->session['delivery_date_for_so'] != '') { echo Yii::app()->session['delivery_date_for_so']; } ?>"  readonly="readonly" />
        
      </div>
      
    </div>
    <div class="well">
      <table  id="ordertbl" class="table table-striped" align="center" border="0" cellspacing="5" cellpadding="5" >
      
      <thead>
            <tr>
          <th align="center" ><strong>Driver Name</strong></th>
          <th align="center"><strong>Cash Amount</strong></th>
          <?php /*?><th align="center"><strong>Coupon Amount</strong></th><?php */?>
          
        </tr>
        </thead>
      <tbody>
      <?php
	  
	   $i = 1 ; 	
	   foreach($driverData as $row) { ?>
          <tr>
          
          <td>
          
           <input type="text" id="driver_name_<?php echo $i; ?>" name="driver_name_<?php echo $i; ?>" class="input-xlarge validate[required]"  value="<?php echo $row['firstName'].' '.$row['lastName']; ?>"  readonly="readonly" />
           <input type="hidden" name="driver_id_<?php echo $i; ?>" id="driver_id_<?php echo $i; ?>" value="<?php echo $row['driver_id']; ?>" />
           </td>
          
          
          <td>
          <input type="text" name="cash_amount_<?php echo $i; ?>" id="cash_amount_<?php echo $i; ?>" value="" />
            
           </td>
          <td>
          	<?php /*?><input type="text" name="coupon_amount_<?php echo $i; ?>" id="coupon_amount_<?php echo $i; ?>" value="" /><?php */?>
          </td>
        </tr>
        <input type="hidden" name="delivery_id_<?php echo $i; ?>" id="delivery_id_<?php echo $i; ?>" value="<?php echo $row['delivery_id']; ?>" />
        
         <?php $i++ ; } ?>
        
        
            
        </tbody>
      </table>
	  	
      <input type="hidden" name="count" id="count" value="<?php echo $i - 1; ?>" />

      <p>&nbsp;</p>

      <div class="form-actions align-right">
      <span id="error"></span>
        <button type="submit" name="FormSubmit" class="btn btn-large btn-success">Generate Report</button>
        <button type="button" onclick="window.location.href='<?php echo Yii::app()->params->base_path;?>admin/salesOrderListing'" class="btn btn-large btn-danger">Cancel</button>
        <button type="reset" class="btn btn-large btn-info">Reset</button>
      </div>
    </div>
  </div>
</form>
<!-- /default form --> 
