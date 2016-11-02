<?php 
		$productObj = new Product();
		$productList = $productObj->getAllProducts();
?>


<script type="text/javascript">
	
	function calculateTotal(id)
	{
		var packaging_scenario = $("#packaging_scenario"+id+" option:selected").val();
		var rate = $("#rate"+id).val();
		var no_of_packets = $("#no_of_packets"+id).val();

		if(no_of_packets == " ")
		{
			return false;	
		}

		totalAmount = Number(packaging_scenario) * Number(rate) * Number(no_of_packets) ;

		$("#amount"+id).val(Number(totalAmount).toFixed(2));
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
		$("#totalPurchase").val(Number(total).toFixed(2));
	}
	
	function addTablerow()
	{  
		var count = $("#count").val();
		var newCount = Number(count) + 1 ;
		
		$('#purchaseTable > tbody > tr:last').after("<tr id='tabletr"+newCount+"' ><td><div class='top-info' style='margin-bottom:-30px;'><a style='width:20px; padding: 0px 5px; margin-left:10px;' href='#'  onclick='removeTablerow("+newCount+");' id='trImg"+newCount+"' title='Cancel'  class='red-square'><i class='icon-remove'></i></a></div><input style='width:40%; height:30px; margin-top: 3px; text-align:right;' type='text' onkeyup='selectProduct("+newCount+");' class='textbox text-mini' value=''  name='product_id"+newCount+"' id='product_id"+newCount+"'/></td><td align='center'><select  onchange='getProductDetail("+newCount+");' data-placeholder='Choose a product...' name='product"+newCount+"' id='product"+newCount+"' class='select' tabindex='2' style='width:250px !important; margin-right:-5px !important;'><option value=''>select product</option><?php foreach($productList as $product){?><option value='<?php echo $product['product_id'] ?>'><?php echo htmlspecialchars($product['product_name']); ?></option><?php } ?></select></td><td><input style='width:100%; height:30px; text-align:center;' type='text' class='textbox text-input' value=''  name='unit"+newCount+"'' id='unit"+newCount+"'' readonly='readonly' /></td><td><input style='width:100%; height:30px; text-align:center;' type='text' class='textbox text-input' value=''  name='rate"+newCount+"'' id='rate"+newCount+"'' readonly='readonly' /></td><td align='center'><select data-placeholder='Choose a package...' name='packaging_scenario"+newCount+"' id='packaging_scenario"+newCount+"' style='width:150px;'  class='validate[required]' tabindex='2' onchange='calculateTotal("+newCount+");'><option value=''>select package</option></select></td><td><input style='width:100%; height:30px; text-align:right;' type='text'  value='1' class='textbox validate[required,custom[number]] text-input' id='no_of_packets"+newCount+"' onkeypress='return isDecimalKey(event,this.value);' name='no_of_packets"+newCount+"' onkeyup='calculateTotal("+newCount+");'></td><td><input style='width:100%; height:30px; text-align:right;' type='text'  value='' id='amount"+newCount+"' readonly='readonly' class='textbox validate[required,custom[number]] text-input' name='amount"+newCount+"' ></td></tr>");
		
		
		$('#count').attr( "value",newCount);
		 $("#ordertbl").trigger("create");
		//$("#ordertbl").table( "refresh" );
	}
	
	function removeTablerow(id)
	{  
	
		bootbox.confirm("Are you sure want to delete this record?", function(confirmed) {
		//console.log("Confirmed: "+confirmed);
		if(confirmed == true)
		{
			
			deleteDescRowFromDatabase(id);
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
					
					$("#trImg"+i).attr('id', 'trImg'+newId);
					$("#trImg"+newId).attr('onclick', 'removeTablerow('+newId+');');
					
					$("#product_id"+i).attr('id', 'product_id'+newId);
					$("#product_id"+newId).attr('name', 'product_id'+newId);
					
					$("#product"+i).attr('id', 'product'+newId);
					$("#product"+newId).attr('name', 'product'+newId);
					$("#product"+newId).attr('onkeyup', 'getProductDetail('+newId+');');
					$("#product"+newId).attr('onchange', 'getProductDetail('+newId+');');
					
					$("#unit"+i).attr('id', 'unit'+newId);
					$("#unit"+newId).attr('name', 'unit'+newId);
					
					$("#rate"+i).attr('id', 'rate'+newId);
					$("#rate"+newId).attr('name', 'rate'+newId);
					
					$("#packaging_scenario"+i).attr('id', 'packaging_scenario'+newId);
					$("#packaging_scenario"+newId).attr('name', 'packaging_scenario'+newId);
					
					$("#no_of_packets"+i).attr('id', 'no_of_packets'+newId);
					$("#no_of_packets"+newId).attr('name', 'no_of_packets'+newId);
					
					$("#amount"+i).attr('id', 'amount'+newId);
					$("#amount"+newId).attr('name', 'amount'+newId);
					
					$("#rowid"+i).attr('id', 'rowid'+newId);
					$("#rowid"+newId).attr('name', 'rowid'+newId);
					//newLoopCount++;
					newId++;
				}
			
				calculateTotalPurchase();
				return true;
			}
		}else{
			return true;
		}
		});
	}
	
	function deleteDescRowFromDatabase(rowid)
	{
		var sodescId = $("#rowid"+rowid).val();
		
		$.ajax({
		type: 'POST',
		url: '<?php echo Yii::app()->params->base_path;?>admin/deleteDescRowFromDatabase',
		data: 'sodescId='+sodescId,
		cache: false,
		success: function(data)
		{
		  return true;
		}
		});
	}
		  
	function getProductDetail(count)
	{
	// var upc_code = $("#upc_code").val();
	 var product_id = $("#product"+count+" option:selected").val();
	// alert(count);
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
			   $('#packaging_scenario'+count).html(arr[2]);
			   $('#product_id'+count).val(arr[3]);
			   $('#rate'+count).attr( "value",arr[1]);
			   return true;
		  }
	  }
	 });
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
	
	function selectCustomer2()
	{
		var mobile_no = $("#mobile_no").val();

		$.ajax({
		type: 'POST',
		url: '<?php echo Yii::app()->params->base_path;?>admin/getCustomerDetail',
		data: 'mobile_no='+mobile_no,
		cache: false,
		success: function(data)
		{
		  if(data == 0)
		  {
				$("#customer_id option[value='']").prop("selected", true);
				return false;  
		  }else{
			   var obj = jQuery.parseJSON(data);
			   
			   $("#customer_id_select").val(obj.customer_id);
			   $("#customer_id option[value="+obj.customer_id+"]").prop("selected", true);
			  
			   return true;
		  }
		}
		});
	}
	
	function selectProduct(id)
	{
	 var proVal = $('#product_id'+id).val();
	
	 var productId = "#product"+id ;
	 
	 $(productId+" option[value="+proVal+"]").prop("selected", true);
	
	 getProductDetail(id);
	}
	
function validateForm() {
	$('#error').removeClass();
	$('#error').html('');
	
	var d = new Date();
	var curr_date = d.getDate();
	var today_date = d.getDate();
	var seven_date = d.getDate()+7;
	var curr_month = d.getMonth();
	curr_month++;
	if(curr_month < 10){
       curr_month="0"+curr_month;
    } 
	var curr_year = d.getFullYear();
	//var todayDate =(today_date + "/" + curr_month + "/" + curr_year);
	var weekDate =(curr_month + "/" + seven_date + "/" + curr_year);
	
	var delivery_date = $("#fromDate").val();
	
	if(delivery_date > weekDate)
	{
		$('#error').addClass('false');
		$('#error').html("<strong class='icon-remove' style='color:red; margin-top:10px; font-weight:bold;'>&nbsp; Please select delivery date for next 7 days only.</strong>");
		return false;
	}else{
		$('#error').removeClass();
		$('#error').addClass('true');
		$('#error').html("");
		//return true;	
	}
	
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

function isDecimalKey(evt,val)
{
	if(evt.keyCode == 9)
	{
	
	}
	else
	{
		var charCode = (evt.which) ? evt.which : event.keyCode
		if(charCode == 46) 
		{
			var finalvalue = val+".";	
			var checkNumber = isNaN(finalvalue) ;
			if(checkNumber == true)
			{
				return false;
			}
		}
		if (charCode > 31 && charCode != 46 && (charCode < 48 || charCode > 57))
		return false;
	}
	return true;
}


</script>
<!-- Default form -->

<form id="validate" onsubmit="return validateForm();" action="<?php echo Yii::app()->params->base_path;?>admin/editGenerateOrder" method="post" enctype="multipart/form-data">
  <div class="widget">
    <div class="navbar">
      <div class="navbar-inner">
        <h6><a href="<?php echo Yii::app()->params->base_path;?>admin/salesOrderListing">Order List</a>&nbsp;&nbsp;<img src="<?php echo Yii::app()->params->base_url;?>images/path-arrow.png" alt="" border="0" />&nbsp;&nbsp;Update Sales Order</h6>
      </div>
    </div>
    <div class="well">
      <table width="90%" id="ordertbl" align="center" border="0" cellspacing="5" cellpadding="5" >
        <tr>
          <td width="21%" align="right" ><label class="control-label">Customer Name<span class="text-error">* &nbsp;</span>:</label></td>
          <td width="40%">
          <?php 
		  	//echo "<pre>"; print_r($salesOrderDesc); exit;
			$customerObj = new Customers();
			$customerList = $customerObj->getAllCustomers();
		  ?>
            <div class="control-group">
                <div class="controls">
                    <select data-placeholder="Choose a customer..." name="customer_id" id="customer_id" class="validate[required]" tabindex="2" style="width:150px;">
                        <option value="">select customer</option>
						<?php foreach($customerList as $row ) { ?>
                        <option value="<?php echo $row['customer_id']; ?>" <?php if(isset($salesOrderData['customer_id']) && $salesOrderData['customer_id'] == $row['customer_id']) { ?> selected="selected" <?php } ?> ><?php echo $row['customer_name']; ?></option> 
                        <?php } ?>	 
                    </select>
                    <!--<input style="text-align:right;" type="text" class="input-mini" name="customer_id_select" id="customer_id_select" onkeyup="selectCustomer();" placeholder="Id" />-->
                    <input style="text-align:right;" type="text" class="input-medium" name="mobile_no" id="mobile_no" onkeyup="selectCustomer2();" placeholder="Represent Id,Id,Or MobileNo" />
                   
                </div>             
            </div>
           </td>
          <td align="right"><label class="control-label">Delivery Date<span class="text-error">* &nbsp;</span>:</label></td>
          <td width="20%">
          	<ul class="">
                <li><input type="text" id="frDate" name="delivery_date" class="validate[required]" placeholder="select delivery date" value="<?php echo date("m/d/Y",strtotime($salesOrderData['delivery_date'])); ?>"  /></li>
            </ul>
          </td>
        </tr>
      </table>
      <table width="80%" border="1" align="center" cellpadding="2" cellspacing="2" name="purchaseTable" id="purchaseTable">
        <tr style="background-color:#F8F8F8;">
          <td width="5%" align="center" valign="middle" scope="col"><strong>ProductId</strong></td>
          <td width="3%" align="center" valign="middle" scope="col"><strong>Product Name</strong></td>
          <td width="8%" align="center" valign="middle" scope="col"><strong>Unit</strong></td>
          <td width="8%" align="center" valign="middle" scope="col"><strong>Price</strong></td>
          <td width="3%" align="center" valign="middle" scope="col"><strong>Package Type</strong></td>
          <td width="3%" align="center" valign="middle" scope="col"><strong>No of Packets</strong></td>
          <td width="10%" align="center" valign="middle" scope="col"><strong>Amount</strong></td>
        </tr>
        <?php 
			$i = 1;
			$totalPurchase = 0 ;
			$amount = 0 ;
			foreach($salesOrderDesc as $row) { 
			
			$amount = $row['packaging_scenario'] * $row['no_of_packets'] * $row['product_price'] ;
			$totalPurchase = $totalPurchase + $amount ; 
		?>
        <tr id="tabletr<?php echo $i ; ?>">
          <td>
          <?php if($i != 1) { ?>
          	<div class='top-info' style='margin-bottom:-30px;'>
            	<a style='width:20px; padding: 0px 5px; margin-left:10px;' href='#'  onclick='removeTablerow(<?php echo $i ; ?>);' id='trImg<?php echo $i ; ?>' title='Cancel'  class='red-square'>
                	<i class='icon-remove'></i>
                </a>
            </div>
            
            <input style="width:40%; height:30px; text-align:right;" type="text" class="textbox text-mini" value="<?php if(isset($row['product_id']) && $row['product_id'] != "") { echo $row['product_id'] ; } ?>"  name="product_id<?php echo $i ; ?>" onkeyup="selectProduct(<?php echo $i ; ?>);" id="product_id<?php echo $i ; ?>" />
         <?php } else { ?>
            
          <input style="width:100%; height:30px; text-align:right;" type="text" class="textbox text-mini" value="<?php if(isset($row['product_id']) && $row['product_id'] != "") { echo $row['product_id'] ; } ?>"  name="product_id<?php echo $i ; ?>" onkeyup="selectProduct(<?php echo $i ; ?>);" id="product_id<?php echo $i ; ?>" />

          <?php } ?>
          </td>
          <td align="center">
            <select data-placeholder="Choose a product..." name="product<?php echo $i ; ?>" id="product<?php echo $i ; ?>" class="validate[required]" tabindex="2" onchange="getProductDetail(<?php echo $i ; ?>);" style="width:250px !important; ">
                <option value="">select product</option>
                <?php foreach($productList as $raw ) { ?>
                <option value="<?php echo $raw['product_id']; ?>" <?php if(isset($row['product_id']) && $row['product_id'] == $raw['product_id']) { ?> selected="selected" <?php } ?>  ><?php echo htmlspecialchars($raw['product_name']); ?></option> 
                <?php } ?>	 
            </select>
          </td>
          
          <td><input style="width:100%; height:30px; text-align:center;" type="text" class="textbox text-input" value="<?php if(isset($row['unit_name']) && $row['unit_name'] != "") { echo $row['unit_name'] ; } ?>"  name="unit<?php echo $i ; ?>" id="unit<?php echo $i ; ?>" readonly="readonly" /></td>
          
          <td><input style="width:100%; height:30px; text-align:center;" type="text" class="textbox text-input" value="<?php if(isset($row['product_price']) && $row['product_price'] != "") { echo $row['product_price'] ; } ?>"  name="rate<?php echo $i ; ?>" id="rate<?php echo $i ; ?>" readonly="readonly" /></td>
          
          <?php
		  	$catPackObj = new CategoryPackagingMaster();
			$catPackData = $catPackObj->getAllPackageScenarioByCatId($row['product_id']);
		  ?>
          
          <td align="center">
          <select data-placeholder="Choose a package..." name="packaging_scenario<?php echo $i ; ?>" id="packaging_scenario<?php echo $i ; ?>" onchange="calculateTotal(<?php echo $i ; ?>);" class="validate[required]" tabindex="2" style="width:150px !important; ">
                <option value="">select package</option>
                <?php foreach($catPackData as $package) { ?>
                <option value="<?php echo $package['packaging_scenario']; ?>" <?php if(isset($row['packaging_scenario']) && $row['packaging_scenario'] == $package['packaging_scenario']) { ?> selected="selected" <?php } ?> ><?php echo $package['display_name']; ?></option>
                <?php } ?>
            </select>
         </td>
         
         <td>
           <input style="width:100%; height:30px; text-align:right;" type="text" class="textbox validate[required,custom[number]] text-input" value="<?php if(isset($row['no_of_packets']) && $row['no_of_packets'] != "") { echo $row['no_of_packets'] ; } ?>" name="no_of_packets<?php echo $i ; ?>" onkeyup="calculateTotal(<?php echo $i ; ?>);"   onkeypress="return isDecimalKey(event,this.value);" id="no_of_packets<?php echo $i ; ?>" size="8"/>
           
            <input type="hidden" value="<?php if(isset($row['id']) && $row['id'] != "") { echo $row['id'] ; } ?>"  name="rowid<?php echo $i ; ?>" id="rowid<?php echo $i ; ?>" />
            
          </td>
          <td><input style="width:100%; height:30px; text-align:right;" type="text" class="textbox validate[required,custom[number]] text-input" value="<?php echo $amount ; ?>"  name="amount<?php echo $i ; ?>" id="amount<?php echo $i ; ?>" readonly="readonly" /></td>
        </tr>
        <?php 
		
			$i++; } 
		
		?>
      </table>
      <table width="80%" border="" align="center" cellpadding="2" cellspacing="2" >
        <tr style="background-color:#F8F8F8;">
          <td >
          <div class="top-info" style="margin-bottom:0px;">
            <a style="width:20px; padding: 0px 5px; margin-left:10px;" href="#" onclick="addTablerow();" class="blue-square"><i class="icon-plus"></i></a>
            <strong style="font-size:15px !important;">Click here to add more products</strong>
          </div>
          </td>
          <td width="15%" align="center" valign="middle"><strong>Total</strong></td>
          <td width="13%" align="center" valign="middle"><input style="width:100%; height:40px; text-align:right;" class="textbox" id="totalPurchase" name="totalPurchase" type="text"  value="<?php echo $totalPurchase ; ?>" readonly="readonly" /></td>
        </tr>
      </table>
      <input type="hidden" name="count" id="count" value="<?php echo $i-1 ; ?>" />
      <input type="hidden" name="so_id" id="so_id" value="<?php if(isset($salesOrderData['so_id']) && $salesOrderData['so_id'] != "") { echo $salesOrderData['so_id'] ; } ?>" />
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
