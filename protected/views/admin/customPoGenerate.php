<?php 
		$productObj = new Product();
		$productList = $productObj->getAllProducts();
		
		$vendorObj = new Vendor();
		$vendorList = $vendorObj->getAllVendors();
?>
<script type="text/javascript">
	
	function calculateTotal(id) 
	{
		
		var poquantity = $("#poquantity_"+id).val();
		var price = $("#price_"+id).val();

		totalAmount = Number(poquantity) * Number(price) ;

		$("#amount_"+id).val(Number(totalAmount).toFixed(2));
	}
   
	function validateForm() 
	{
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
	
	function isNumberKeyNew(evt)
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
	
	function selectProduct(id)
	{
		var proVal = $('#product_id'+id).val();
		
		var productId = "#product_id_"+id ;
		
		$(productId+" option[value="+proVal+"]").prop("selected", true);
		
		getProductDetail(id);
	}
	
	function getProductDetail(count)
	{
	// var upc_code = $("#upc_code").val();
	 var product_id = $("#product_id_"+count+" option:selected").val();
	// alert(count);
	 $.ajax({
	  type: 'POST',
	  url: '<?php echo Yii::app()->params->base_path;?>admin/getProductDetailInJson',
	  data: 'product_id='+product_id,
	  cache: false,
	  success: function(data)
	  {
		  if(data == 0)
		  {
				alert("data not found.");
				return false;  
		  }else{
			   var obj = jQuery.parseJSON(data);
			  
			   $('#unit_name'+count).text(obj.unit_name);
			   $('#product_id'+count).val(obj.product_id);
			   $('#inventoryquantity_'+count).val(obj.quantity);
			   //$("#vendor_id_"+count+" option:selected").val(obj.vendor_id);
			   var vendor_id = "#vendor_id_"+count ;
			   $(vendor_id+" option[value="+obj.vendor_id+"]").prop("selected", true);
			   return true;
		  }
	  }
	 });
	}

	function addTablerow()
	{
		var count = $("#count").val();
		var newCount = Number(count) + 1 ;
		
		$('#purchaseTable > tbody > tr:last').after("<tr id='tabletr"+newCount+"' ><td><div class='top-info' style='margin-bottom:-30px;'><a style='width:20px; padding: 0px 5px;' href='#'  onclick='removeTablerow("+newCount+");' id='trImg"+newCount+"' title='Cancel'  class='red-square'><i class='icon-remove'></i></a></div><input style='width:57%; height:30px; margin-top: 3px; text-align:right;' type='text' onkeyup='selectProduct("+newCount+");' class='textbox text-mini' value=''  name='product_id"+newCount+"' id='product_id"+newCount+"'/></td><td align='center'><select  onchange='getProductDetail("+newCount+");' data-placeholder='Choose a product...' name='product_id_"+newCount+"' id='product_id_"+newCount+"' class='select' tabindex='2' style='width:150px !important; margin-right:-5px !important;'><option value=''>select product</option><?php foreach($productList as $product){?><option value='<?php echo $product['product_id'] ?>'><?php echo htmlspecialchars($product['product_name']); ?></option><?php } ?></select></td><td align='center'><span id='unit_name"+newCount+"'>&nbsp;</span></td><td align='center'><input style='text-align:right;' type='text' class='input-small'  readonly='readonly' value=''  name='inventoryquantity_"+newCount+"'' id='inventoryquantity_"+newCount+"'' /></td></td><td  align='center'><input style='text-align:right;' type='text' class='input-small' value='' onkeypress='return isNumberKeyNew(event);' onkeyup='calculateTotal("+newCount+");'  name='poquantity_"+newCount+"'' id='poquantity_"+newCount+"'' /></td><td  align='center'><input style='text-align:right;' type='text' class='input-small validate[required]' value='0'  readonly='readonly'  onkeypress='return isNumberKeyNew(event);' onkeyup='calculateTotal("+newCount+");'  name='price_"+newCount+"'' id='price_"+newCount+"'' /></td><td align='center'><input style='text-align:right;' type='text' class='input-small' value='' readonly='readonly'  name='amount_"+newCount+"'' id='amount_"+newCount+"'' /></td><td align='center'><select  data-placeholder='Choose a vendor..' name='vendor_id_"+newCount+"' id='vendor_id_"+newCount+"' class='validate[required]' tabindex='2' style='width:130px !important;'><option value=''>select vendor</option><?php foreach($vendorList as $vendor ) { ?><option value='<?php echo $vendor['vendor_id'] ?>'><?php echo htmlspecialchars($vendor['vendor_name']); ?></option><?php } ?></select></td></tr>");
		
		 $('#count').attr( "value",newCount);
		
	}
	
	function removeTablerow(id)
	{  
		
		
		bootbox.confirm("Are you sure want to delete this record?", function(confirmed) {
		//console.log("Confirmed: "+confirmed);
		if(confirmed == true)
		{
			var count = $("#count").val();
			var newCount = Number(count) - 1 ;
			
			$("#purchaseTable tbody #tabletr"+id+"").remove();
			
			$('#count').attr( "value",newCount);
			
			var newLoopCount = id + 1 ;
			var newId = id  ;
			
			if(count == id)
			{
				//calculateTotalPurchase();
				return true;
			}else{
				
				for(i=newLoopCount ; i<=count ; i++)
				{
					$("#tabletr"+i).attr('id', 'tabletr'+newId);
					
					$("#trImg"+i).attr('id', 'trImg'+newId);
					$("#trImg"+newId).attr('onclick', 'removeTablerow('+newId+');');
					
					$("#product_id"+i).attr('id', 'product_id'+newId);
					$("#product_id"+newId).attr('name', 'product_id'+newId);
					
					$("#product_id_"+i).attr('id', 'product_id_'+newId);
					$("#product_id_"+newId).attr('name', 'product_id_'+newId);
					
					$("#unit_name"+i).attr('id', 'unit_name'+newId);
					
					$("#inventoryquantity_"+i).attr('id', 'inventoryquantity_'+newId);
					$("#inventoryquantity_"+newId).attr('name', 'inventoryquantity_'+newId);
					
					$("#poquantity_"+i).attr('id', 'poquantity_'+newId);
					$("#poquantity_"+newId).attr('name', 'poquantity_'+newId);
					
					$("#price_"+i).attr('id', 'price_'+newId);
					$("#price_"+newId).attr('name', 'price_'+newId);
					
					$("#amount_"+i).attr('id', 'amount_'+newId);
					$("#amount_"+newId).attr('name', 'amount_'+newId);
					
					$("#vendor_id_"+i).attr('id', 'vendor_id_'+newId);
					$("#vendor_id_"+newId).attr('name', 'vendor_id_'+newId);
					
					newId++;
				}
			
				//calculateTotalPurchase();
				return true;
			}
		}else{
			return true;
		}
		});
	}
	
	function validateAll()
	{
		var flag=1;
		var count = $("#count").val();
		
		for(i=1 ; i<=count ; i++)
		{
			var calculatedquantity = $("#calculatedquantity_"+i).val();
			var poquantity = $("#poquantity_"+i).val();
			var subRow = $("#subRow"+i).val();
			var className = $('#plusIcon'+i).attr('class');
			
			if((Number(poquantity) < Number(calculatedquantity)) && className == "blue-square")
			{
				$("#poquantity_"+i).css( "border-color","red");	
				var flag = 0;
			}else{
				$("#poquantity_"+i).css( "border-color","");		
			}
		}
		
		if(flag == 1)
		{
			return true;	
		}else{
			return false;
		}
	}

</script>
<form id="validate" action="<?php echo Yii::app()->params->base_path;?>admin/saveCustomPoOrder" method="post" enctype="multipart/form-data" onsubmit="return validateAll();" >
<div class="widget">
<div class="navbar"><div class="navbar-inner"><h6>Create New Purchase Order</h6></div></div>

    <div class="well">
        <div class="control-group">
            <label class="control-label">Delivery Date:</label>
            <div class="controls"><input type="text" id="frDate" name="delivery_date" class="validate[required] span12 input-large" placeholder="Enter Delivery Date" value="<?php if(isset($deliveryDate) && $deliveryDate != "") { echo $deliveryDate; } ?>" />
        </div>
    </div>
    
    <table class="table table-striped table-bordered" id="purchaseTable" >
        <thead>
            <tr>
                <th style="text-align:center;" width="5%">ProductId</th>
                <th style="text-align:center;">Product</th>
                <th style="text-align:center;">Unit</th>
                <th style="text-align:center;">Inventory Qty</th>
                <th style="text-align:center;">PO Qty</th>
                <th style="text-align:center;">Price</th>
                <th style="text-align:center;">Amount</th>
                <th style="text-align:center;">Vendor</th>
            </tr>
        </thead>
        <tbody>

        <tr id="tabletr1">
          <td><input style="text-align:right;" type="text" class="input-small" value=""  name="product_id1" onkeyup="selectProduct(1);" id="product_id1" />
          <td align="center">
            <select data-placeholder="Choose a product..." name="product_id_1" id="product_id_1" class="validate[required]" tabindex="2" onchange="getProductDetail(1);" style="width:150px !important; ">
                <option value="">select product</option>
                <?php foreach($productList as $row ) { ?>
                <option value="<?php echo $row['product_id']; ?>"  ><?php echo htmlspecialchars($row['product_name']); ?></option> 
                <?php } ?>	 
            </select>
          </td>
          <td align="center"><span id="unit_name1"><?php echo $row['unit_name']; ?></span></td>
         <td align="center"><input style="text-align:right;" type="text" class="input-small" value="0"  name="inventoryquantity_1" id="inventoryquantity_1" readonly="readonly" /></td>
         <td align="center"><input style="text-align:right;" type="text" class="validate[required] input-small" value=""  name="poquantity_1" onkeypress='return isNumberKeyNew(event);' onkeyup="calculateTotal(1);" id="poquantity_1"  /></td>
         <td align="center"><input style="text-align:right;" type="text" class="validate[required] input-small" value="0" readonly="readonly"  name="price_1" onkeypress='return isNumberKeyNew(event);' onkeyup="calculateTotal(1);" id="price_1" /></td>
         <td align="center"><input style="text-align:right;" type="text" class="validate[required] input-small" value=""  name="amount_1" id="amount_1" readonly="readonly"  /></td>
         <td align="center">
             <select data-placeholder="Choose a vendor..." name="vendor_id_1" id="vendor_id_1" class="validate[required]" style="width:130px;">
                <option value="">select vendor</option>
                <?php foreach($vendorList as $vendor ) { ?>
                <option value="<?php echo $vendor['vendor_id']; ?>" <?php if(isset($row['vendor_id']) && $row['vendor_id'] == $vendor['vendor_id'] ) { ?> selected="selected" <?php } ?>  ><?php echo $vendor['vendor_name']; ?></option> 
                <?php } ?>	 
            </select>
        </td>
        </tr>
          </tbody>
    </table>
    <table width="100%" border="0" align="center" cellpadding="2" cellspacing="2" >
        <tr style="background-color:#F8F8F8;">
          <td >
          <div class="top-info" style="margin-bottom:0px;">
            <a style="width:20px; padding: 0px 5px; margin-left:10px;" href="#" onclick="addTablerow();" class="blue-square"><i class="icon-plus"></i></a>
            <strong style="font-size:15px !important;">Click here to add more products</strong>
          </div>
          
          </td>
        </tr>
      </table>
    
<input type="hidden" name="count" id="count" value="1" />
<div class="form-actions align-right">
<button type="submit" name="FormSubmit" class="btn btn-large btn-success">Submit</button>
<button type="button" onclick="window.location.href='<?php echo Yii::app()->params->base_path;?>admin/purchaseOrderListing'" class="btn btn-large btn-danger">Cancel</button>
<button type="reset" class="btn btn-large btn-info">Reset</button>
</div>
</div>
</div>
</form>