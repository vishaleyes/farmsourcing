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

	function addTablerow(id)
	{
		
		var product_name = $("#product_name_"+id).val();
		var product_id = $("#product_id_"+id).val();
		var totalquantity = $("#totalquantity_"+id).val();
		var inventoryquantity = $("#inventoryquantity_"+id).val();
		var safetyMargin = $("#safetyMargin_"+id).val();
		var calculatedquantity = $("#calculatedquantity_"+id).val();
		var poquantity = $("#poquantity_"+id).val();
		var unit_name = $("#unit_name"+id).text();
		
		

		if(poquantity == "")
		{
			bootbox.alert("Please enter PO quantity.");
			return false;	
		}
		
		if(Number(poquantity) >= Number(calculatedquantity))
		{
			bootbox.alert("Enough PO quantity.");
			return false;	
		}
		
		
		
		var newSafetyMargin = 	0;
		
		var newTotalQuantity = Number(calculatedquantity) - Number(poquantity);
		var newCalculatedquantity = Number(calculatedquantity) - Number(poquantity);
		
		var count = $("#count").val();
		var newCount = Number(count) + 1 ;
		
		$('#purchaseTable > tbody > tr:last').after("<tr id='tabletr"+newCount+"' ><td align='center'><div class='top-info' style='margin-bottom:0px; cursor:pointer;'><a style='width:20px; padding: 0px 5px; href='#'  onclick='removeTablerow("+newCount+");' id='trImg"+newCount+"' title='Cancel'  class='red-square'><i class='icon-remove'></i></a></div></td><td align='center'><input type='text' class='validate[required] span12 input-small' name='product_name_"+newCount+"' id='product_name_"+newCount+"' readonly='readonly' value='"+product_name+"' /></td><input type='hidden' name='product_id_"+newCount+"' id='product_id_"+newCount+"' readonly='readonly' value='"+product_id+"' /></td><td align='center'><span id='unit_name"+newCount+"'>"+unit_name+"</span></td><td><input style='text-align:right;' type='text' class='input-mini' value='"+newTotalQuantity+"' readonly='readonly' name='totalquantity_"+newCount+"'' id='totalquantity_"+newCount+"'' /></td><td align='center'><input style='text-align:right;' type='text' class='input-mini' value='"+newSafetyMargin+"'  readonly='readonly' name='safetyMargin_"+newCount+"'' id='safetyMargin_"+newCount+"'' /><td align='center'><input style='text-align:right;' type='text' class='input-mini'  readonly='readonly' value='"+inventoryquantity+"'  name='inventoryquantity_"+newCount+"'' id='inventoryquantity_"+newCount+"'' /></td></td><td  align='center'><input style='text-align:right;' type='text' class='input-mini'  readonly='readonly' value='"+newCalculatedquantity+"'  name='calculatedquantity_"+newCount+"'' id='calculatedquantity_"+newCount+"'' /></td><td  align='center'><input style='text-align:right;' type='text' class='input-mini' value='' onkeypress='return isNumberKeyNew(event);' onkeyup='calculateTotal("+newCount+");'  name='poquantity_"+newCount+"'' id='poquantity_"+newCount+"'' /></td><td  align='center'><input style='text-align:right;' type='text' class='input-small validate[required]' value='0'  readonly='readonly'   onkeypress='return isNumberKeyNew(event);' onkeyup='calculateTotal("+newCount+");'  name='price_"+newCount+"'' id='price_"+newCount+"''  /></td><td  align='center'><input style='text-align:right;' type='text' class='input-small' value='' readonly='readonly'  name='amount_"+newCount+"'' id='amount_"+newCount+"'' /></td><td align='center'><select  data-placeholder='Choose a vendor..' name='vendor_id_"+newCount+"' id='vendor_id_"+newCount+"' class='validate[required]' tabindex='2' style='width:130px !important; margin-right:-5px !important;'><option value=''>select vendor</option><?php foreach($vendorList as $vendor ) { ?><option value='<?php echo $vendor['vendor_id'] ?>'><?php echo htmlspecialchars($vendor['vendor_name']); ?></option><?php } ?></select></td><td><div class='top-info' id='top-info"+newCount+"' style='margin-bottom:0px;'><a style='width:20px; padding: 0px 5px; margin-left:10px;' id='plusIcon"+newCount+"' name='plusIcon"+newCount+"' href='#' onclick='addTablerow("+newCount+");' class='blue-square'><i class='icon-plus'></i></a></div><input type='hidden'  name='subRow"+newCount+"' id='subRow"+newCount+"' value='' /></td></tr>");
		
		 $("#subRow"+newCount).attr( "value",id);
		 $("#plusIcon"+id).removeAttr("onclick");
		 $("#plusIcon"+id).attr( "class","red-square");
		 $('#count').attr( "value",newCount);
		
	}
	
	function removeTablerow(id)
	{  
		
		
		bootbox.confirm("Are you sure want to delete this record?", function(confirmed) {
		//console.log("Confirmed: "+confirmed);
		if(confirmed == true)
		{
			var subRow = $("#subRow"+id).val();
			$("#plusIcon"+subRow).attr( "onclick","addTablerow("+subRow+")");
			$("#plusIcon"+subRow).attr( "class","blue-square");
			
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
					
					$("#product_name_"+i).attr('id', 'product_name_'+newId);
					$("#product_name_"+newId).attr('name', 'product_name_'+newId);
					
					$("#product_id_"+i).attr('id', 'product_id_'+newId);
					$("#product_id_"+newId).attr('name', 'product_id_'+newId);
					
					$("#unit_name"+i).attr('id', 'unit_name'+newId);
					
					$("#totalquantity_"+i).attr('id', 'totalquantity_'+newId);
					$("#totalquantity_"+newId).attr('name', 'totalquantity_'+newId);
					
					$("#inventoryquantity_"+i).attr('id', 'inventoryquantity_'+newId);
					$("#inventoryquantity_"+newId).attr('name', 'inventoryquantity_'+newId);
					
					$("#safetyMargin_"+i).attr('id', 'safetyMargin_'+newId);
					$("#safetyMargin_"+newId).attr('name', 'safetyMargin_'+newId);
					
					$("#calculatedquantity_"+i).attr('id', 'calculatedquantity_'+newId);
					$("#calculatedquantity_"+newId).attr('name', 'calculatedquantity_'+newId);
					
					$("#poquantity_"+i).attr('id', 'poquantity_'+newId);
					$("#poquantity_"+newId).attr('name', 'poquantity_'+newId);
					
					$("#price_"+i).attr('id', 'price_'+newId);
					$("#price_"+newId).attr('name', 'price_'+newId);
					
					$("#amount_"+i).attr('id', 'amount_'+newId);
					$("#amount_"+newId).attr('name', 'amount_'+newId);
					
					$("#vendor_id_"+i).attr('id', 'vendor_id_'+newId);
					$("#vendor_id_"+newId).attr('name', 'vendor_id_'+newId);
					
					$("#subRow"+i).attr('id', 'subRow'+newId);
					$("#subRow"+newId).attr('name', 'subRow'+newId);
					
					$("#plusIcon"+i).attr('id', 'plusIcon'+newId);
					$("#plusIcon"+newId).attr('name', 'plusIcon'+newId);
					
					$("#top-info"+i).attr('id', 'top-info'+newId);
					//newLoopCount++;
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
<form id="validate" action="<?php echo Yii::app()->params->base_path;?>admin/savePoOrder" method="post" enctype="multipart/form-data" onsubmit="return validateAll();" >
<div class="widget">
<div class="navbar"><div class="navbar-inner"><h6>Create New Purchase Order</h6></div></div>

    <div class="well">
        <div class="control-group">
            <label class="control-label">Delivery Date:</label>
            <div class="controls"><input type="text" name="delivery_date" class="validate[required] span12 input-large" placeholder="Enter Delivery Date" readonly="readonly" value="<?php if(isset($deliveryDate) && $deliveryDate != "") { echo $deliveryDate; } ?>" />
        </div>
    </div>
    
    <table class="table table-striped table-bordered" id="purchaseTable" >
        <thead>
            <tr>
                <th style="text-align:center;">No</th>
                <th style="text-align:center;">Product</th>
                <th style="text-align:center;">Unit</th>
                <th style="text-align:center;">Ordered Qty</th>
                <th style="text-align:center;">Buffer Qty</th>
                <th style="text-align:center;">Inventory Qty</th>
                <th style="text-align:center;">Suggested Qty</th>
                <th style="text-align:center;">PO Qty</th>
                <th style="text-align:center;">Price</th>
                <th style="text-align:center;">Amount</th>
                <th style="text-align:center;">Vendor</th>
                <th style="text-align:center;">&nbsp;</th>
            </tr>
        </thead>
        <tbody>

        <?php $i=1;
		
		foreach($poData as $row) {
			//print "<pre>";
			//print_r($poData);
			
			$soDescObj =  new SoDesc();
			$soDescData = $soDescObj->getPoDataByProductId($row['product_id'],$deliveryDate);
			
			
			if(!empty($soDescData))
			{
				$totalquantity = $soDescData['totalquantity'] ;	
			}else{
				$totalquantity = 0 ;
			}
			
			$inventoryquantity = $row['quantity'];
			$safetyMargin = $row['safetyMargin'] ;	
			/*$finalquantity =  $totalquantity - $inventoryquantity ;
			if($finalquantity > 0)
			{
				//$safetyMargin = ($finalquantity) * ($row['safetyMargin']/100) ;
				$safetyMargin = $row['safetyMargin'] ;	
			}else{
				$safetyMargin = 0 ;	
			}*/
		
			$finalQuantity = $totalquantity + $row['safetyMargin'] - $inventoryquantity ;
			
			// For PO,
			if($finalQuantity > 0 || $row['safetyMargin'] > 0)
			
			{
		
		?>
        
        <tr id="tabletr<?php echo $i; ?>">
          <td style="text-align:right;"><?php echo $i; ?></td>
          <td align="center"><input type="text" class="validate[required] span12 input-small" name="product_name_<?php echo $i;?>" id="product_name_<?php echo $i;?>" readonly="readonly" value="<?php echo $row['product_name']; ?>" /></td>
          
          <td align="center"><span id="unit_name<?php echo $i;?>"><?php echo $row['unit_name']; ?></span></td>
          <input type="hidden" name="product_id_<?php echo $i;?>" id="product_id_<?php echo $i;?>" readonly="readonly" value="<?php echo $row['product_id']; ?>" />
          <td align="center"><input style="text-align:right;" type="text" class="input-mini"  name="totalquantity_<?php echo $i;?>" id="totalquantity_<?php echo $i;?>" readonly="readonly" value="<?php echo $totalquantity; ?>" /></td>
          
         <td align="center"><input style="text-align:right;" type="text" class="input-mini" value="<?php echo $safetyMargin; ?>"  name="safetyMargin_<?php echo $i;?>" id="safetyMargin_<?php echo $i;?>" readonly="readonly" /></td>
         <td align="center"><input style="text-align:right;" type="text" class="input-mini" value="<?php echo $inventoryquantity; ?>"  name="inventoryquantity_<?php echo $i;?>" id="inventoryquantity_<?php echo $i;?>" readonly="readonly" /></td>
         
         <td align="center"><input style="text-align:right;" type="text" class="input-mini" value="<?php echo $finalQuantity; ?>"  name="calculatedquantity_<?php echo $i;?>" id="calculatedquantity_<?php echo $i;?>" readonly="readonly" /></td>
         <td align="center"><input style="text-align:right;" type="text" class="validate[required] input-mini" value="<?php if($finalQuantity <= 0){ echo "0"; } ?>"  name="poquantity_<?php echo $i;?>" onkeypress='return isNumberKeyNew(event);' onkeyup="calculateTotal(<?php echo $i;?>);" id="poquantity_<?php echo $i;?>"  /></td>
         <td align="center"><input style="text-align:right;" type="text" class="validate[required] input-small" value="0" readonly="readonly"  name="price_<?php echo $i;?>" onkeypress='return isNumberKeyNew(event);' onkeyup="calculateTotal(<?php echo $i;?>);" id="price_<?php echo $i;?>" /></td>
         <td align="center"><input style="text-align:right;" type="text" class="validate[required] input-small" value="<?php if($finalQuantity <= 0){ echo "0"; } ?>"  name="amount_<?php echo $i;?>" id="amount_<?php echo $i;?>" readonly="readonly"  /></td>
         <td align="center">
             <select data-placeholder="Choose a vendor..." name="vendor_id_<?php echo $i;?>" id="vendor_id_<?php echo $i;?>" class="validate[required]" style="width:130px;">
                <option value="">select vendor</option>
                <?php foreach($vendorList as $vendor ) { ?>
                <option value="<?php echo $vendor['vendor_id']; ?>" <?php if(isset($row['vendor_id']) && $row['vendor_id'] == $vendor['vendor_id'] ) { ?> selected="selected" <?php } ?>  ><?php echo $vendor['vendor_name']; ?></option> 
       			<?php } ?>	 
            </select>
        </td>
        <td align="center">
        	<div class="top-info" id='top-info<?php echo $i;?>' style="margin-bottom:0px;">
        		<a id="plusIcon<?php echo $i;?>" name="plusIcon<?php echo $i;?>" style="width:20px; padding: 0px 5px; margin-left:10px;" href="#" onclick="addTablerow(<?php echo $i;?>);" class="blue-square"><i class="icon-plus"></i></a>
            </div>
            <input type='hidden' name='subRow<?php echo $i;?>' id='subRow<?php echo $i;?>' value='' />
        </td>
        </tr>
        <?php  $i++; } }	 ?>
          </tbody>
    </table>
    
<input type="hidden" name="count" id="count" value="<?php echo $i - 1; ?>" />
<div class="form-actions align-right">
<button type="submit" name="FormSubmit" class="btn btn-large btn-success">Submit</button>
<button type="button" onclick="window.location.href='<?php echo Yii::app()->params->base_path;?>admin/purchaseOrderListing'" class="btn btn-large btn-danger">Cancel</button>
<button type="reset" class="btn btn-large btn-info">Reset</button>
</div>
</div>
</div>
</form>