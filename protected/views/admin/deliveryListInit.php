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
	
   
	function addTablerow()
	{  
		var count = $("#count").val();
		var newCount = Number(count) + 1 ;
		
		$('#purchaseTable > tbody > tr:last').after("<tr id='tabletr"+newCount+"' ><td><div class='top-info' style='margin-bottom:-30px;'><a style='width:20px; padding: 0px 5px; margin-left:10px;' href='#'  onclick='removeTablerow("+newCount+");' id='trImg"+newCount+"' title='Cancel'  class='red-square'><i class='icon-remove'></i></a></div><select  onchange='getProductDetail("+newCount+");' data-placeholder='Choose a product...' name='product"+newCount+"' id='product"+newCount+"' class='select' tabindex='2' style='width:200px !important; margin-right:-5px !important;'><option value=''></option><?php foreach($productList as $product){?><option value='<?php echo $product['product_id'] ?>'><?php echo htmlspecialchars($product['product_name']); ?></option><?php } ?></select></td><td><input style='width:100%; height:30px; text-align:center;' type='text' class='textbox text-input' value=''  name='unit"+newCount+"'' id='unit"+newCount+"'' readonly='readonly' /></td><td><input style='width:100%; height:30px; text-align:right;' type='text'  value='' class='textbox validate[required,custom[number]] text-input' id='quantity"+newCount+"' onkeypress='return isNumberKey(event);' onkeyup='calculateTotal("+newCount+");' name='quantity"+newCount+"'></td><td><input style='width:100%; height:30px; text-align:right;' type='text' class='textbox validate[required,custom[number]] text-input' id='rate"+newCount+"'  value='' onkeyup='calculateTotal("+newCount+");'  readonly='readonly'  name='rate"+newCount+"'></td><td><input style='width:100%; height:30px; text-align:right;' type='text'  value='' id='amount"+newCount+"' readonly='readonly' class='textbox validate[required,custom[number]] text-input' name='amount"+newCount+"' onkeypress='return isNumberKey(event);'></td></tr>");
		
		
		$('#count').attr( "value",newCount);
		 $("#ordertbl").trigger("create");
		//$("#ordertbl").table( "refresh" );
	}
	
	function removeTablerow(id)
	{  
		
		var count = $("#count").val();
		var newCount = Number(count) - 1 ;
		
		$("#purchaseTable tbody #tabletr"+id+"").remove();
		
		$('#count').attr( "value",newCount);
		
		var newLoopCount = id + 1 ;
		var newId = id  ;
		
		if(count == id)
		{
			calculateTotalPurchase();
			return true;
		}else{
			
			for( i=newLoopCount ; i<=count ; i++)
			{
				$("#tabletr"+i).attr('id', 'tabletr'+newId);
				
				$("#amount"+i).attr('id', 'amount'+newId);
				$("#amount"+newId).attr('name', 'amount'+newId);
				
				$("#trImg"+i).attr('id', 'trImg'+newId);
				$("#trImg"+newId).attr('onclick', 'removeTablerow('+newId+');');
				
				$("#product"+i).attr('id', 'product'+newId);
				$("#product"+newId).attr('name', 'product'+newId);
				
				$("#quantity"+i).attr('id', 'quantity'+newId);
				$("#quantity"+newId).attr('name', 'quantity'+newId);
				$("#quantity"+newId).attr('onkeyup', 'calculateTotal('+newId+');');
				
				$("#rate"+i).attr('id', 'rate'+newId);
				$("#rate"+newId).attr('name', 'rate'+newId);
				$("#rate"+newId).attr('onkeyup', 'calculateTotal('+newId+');');
				
				//newLoopCount++;
				newId++;
			}
		
			calculateTotalPurchase();
			return true;
		}
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

<form id="validate" onsubmit="return validateForm();" action="<?php echo Yii::app()->params->base_path;?>admin/deliverySlip" method="post" enctype="multipart/form-data">
  <div class="widget">
    <div class="navbar">
      <div class="navbar-inner">
        <h6><a href="<?php echo Yii::app()->params->base_path;?>admin/salesOrderListing">Delivery List</a>&nbsp;&nbsp;<img src="<?php echo Yii::app()->params->base_url;?>images/path-arrow.png" alt="" border="0" />&nbsp;&nbsp;Create Delivery List</h6>
      </div>
    </div>
    <div class="well">
      <table width="90%" id="ordertbl" align="center" border="0" cellspacing="5" cellpadding="5" >
        <tr>
          <td width="21%" align="right" >&nbsp;</td>
           
          <td  align="left"><label class="control-label">Delivery Date<span class="text-error">* &nbsp;</span>:</label></td>
          
          <td align="left"><input type="text" id="fromDate" name="delivery_date"  class="validate[required]" placeholder="select delivery date" /></td>
          
           <td width="21%" align="right" >&nbsp;</td>
          
        </tr>
      </table>
     
      
      <input type="hidden" name="count" id="count" value="1" />
      <p>&nbsp;</p>
      <div class="form-actions align-right">
      <span id="error"></span>
        <button type="submit" name="FormSubmit" class="btn btn-large btn-success">Next</button>
        <button type="button" onclick="window.location.href='<?php echo Yii::app()->params->base_path;?>admin/salesOrderListing'" class="btn btn-large btn-danger">Cancel</button>
        <button type="reset" class="btn btn-large btn-info">Reset</button>
      </div>
    </div>
  </div>
</form>
<!-- /default form --> 
