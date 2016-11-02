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
		var product_id = $("#product"+id+" option:selected").val();

		if(no_of_packets == " ")
		{
			return false;	
		}
		
		totalQuantity = Number(packaging_scenario) * Number(no_of_packets) ;

		totalAmount = Number(packaging_scenario) * Number(rate) * Number(no_of_packets) ;

		$("#no_of_packets"+id).css( "border-color","");
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
		
		$('#purchaseTable > tbody > tr:last').after("<tr id='tabletr"+newCount+"' ><td><div class='top-info' style='margin-bottom:-30px;'><a style='width:20px; padding: 0px 5px; margin-left:10px;' href='#'  onclick='removeTablerow("+newCount+");' id='trImg"+newCount+"' title='Cancel'  class='red-square'><i class='icon-remove'></i></a></div><input style='width:40%; height:30px; margin-top: 3px; text-align:right;' type='text' onkeyup='selectProduct("+newCount+");' onkeypress='return isNumberKey(event);' class='textbox text-mini' value=''  name='product_id"+newCount+"' id='product_id"+newCount+"'/></td><td align='center'><select  onchange='getProductDetail("+newCount+");' data-placeholder='Choose a product...' name='product"+newCount+"' id='product"+newCount+"' class='select' tabindex='2' style='width:250px !important; margin-right:-5px !important;'><option value=''>select product</option><?php foreach($productList as $product){?><option value='<?php echo $product['product_id'] ?>'><?php echo htmlspecialchars($product['product_name']); ?></option><?php } ?></select></td><td><input style='width:100%; height:30px; text-align:center;' type='text' class='textbox text-input' value=''  name='unit"+newCount+"'' id='unit"+newCount+"'' readonly='readonly' /></td><td><input style='width:100%; height:30px; text-align:center;' type='text' class='textbox text-input' value=''  name='rate"+newCount+"'' id='rate"+newCount+"'' /></td><td align='center'><select data-placeholder='Choose a package...' name='packaging_scenario"+newCount+"' id='packaging_scenario"+newCount+"' style='width:150px;'  class='validate[required]' tabindex='2' onchange='calculateTotal("+newCount+");'><option value=''>select package</option></select></td><td><input style='width:100%; height:30px; text-align:right;' type='text'  value='1' class='textbox validate[required,custom[number]] text-input' id='no_of_packets"+newCount+"' onkeypress='return isDecimalKey(event,this.value);' name='no_of_packets"+newCount+"' onkeyup='calculateTotal("+newCount+");'></td><td><input style='width:100%; height:30px; text-align:right;' type='text'  value='' id='amount"+newCount+"' readonly='readonly' class='textbox validate[required,custom[number]] text-input' name='amount"+newCount+"' ><input type='hidden' name='discount_desc"+newCount+"' id='discount_desc"+newCount+"' value='' /></td></tr>");
		
		
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
					
					$("#discount_desc"+i).attr('id', 'discount_desc'+newId);
					$("#discount_desc"+newId).attr('name', 'discount_desc'+newId);
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
	
	function getProductDetail(count)
	{
	// var upc_code = $("#upc_code").val();
	 var product_id = $("#product"+count+" option:selected").val();
	// alert(count);
	 var customer_id = $("#customer_id").val();
	 
	 $.ajax({
	  type: 'POST',
	  url: '<?php echo Yii::app()->params->base_path;?>admin/getProductDetail',
	  data: 'product_id='+product_id+'&customer_id='+customer_id,
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
			   $('#discount_desc'+count).val(arr[4]);
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
	
	function validateForm() 
	{
		$('#error').removeClass();
		$('#error').html('');
		
		var date = new Date();
		
		var todayDate = ("0" + (date.getMonth() + 1)).slice(-2)+'/'+ ("0" + date.getDate()).slice(-2) +'/'+date.getFullYear();
		date.setDate(date.getDate() + 7);
		
		var weekDate = ("0" + (date.getMonth() + 1)).slice(-2)+'/'+ ("0" + date.getDate()).slice(-2) +'/'+date.getFullYear();
		var delivery_date = $("#frDate").val();
		
		if(new Date(delivery_date) > new Date(weekDate) || new Date(delivery_date)  <  new Date(todayDate) )
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
			$('#formSubmitBtn').attr('disabled',true);
			$('#validate').submit();
			return true;
		}
		
		
		/*var totalPurchase = $("#totalPurchase").val();
		
		if(Number(totalPurchase) < 100)
		{
			$('#error').addClass('false');
			$('#error').html("<strong class='icon-remove' style='color:red; margin-top:10px; font-weight:bold;'>&nbsp; Order value must be atleast 100.</strong>");
			return false;
		}
		else
		{
			$('#error').removeClass();
			$('#error').addClass('true');
			$('#error').html("");
			return true;
		}*/
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
	
	function refreshPage(customer_id)
	{
		
		window.location.href = "<?php echo Yii::app()->params->base_path;?>admin/generateOrder&customer_id="+customer_id;
	}
	

</script>
<!-- Default form -->

<form id="validate"  action="<?php echo Yii::app()->params->base_path;?>admin/generateOrder"  method="post" enctype="multipart/form-data">
  <div class="widget">
    <div class="navbar">
      <div class="navbar-inner">
        <h6><a href="<?php echo Yii::app()->params->base_path;?>admin/salesOrderListing">Whole Sale Order List</a>&nbsp;&nbsp;<img src="<?php echo Yii::app()->params->base_url;?>images/path-arrow.png" alt="" border="0" />&nbsp;&nbsp;Create New Order</h6>
      </div>
    </div>
    <div class="well">
      <table width="90%" id="ordertbl" align="center" border="0" cellspacing="5" cellpadding="5" >
        <tr>
          <td width="21%" align="right" ><label class="control-label">Customer Name<span class="text-error">* &nbsp;</span>:</label></td>
          <td width="40%">
          <?php 
			$customerObj = new Customers();
			$customerList = $customerObj->getAllCustomers();
		  ?>
            <div class="control-group">
                <div class="controls">
                    <select data-placeholder="Choose a customer..." name="customer_id" id="customer_id" class="validate[required]" onchange="refreshPage(this.value);" tabindex="2" style="width:150px;">
                        <option value="">select customer</option>
						<?php foreach($customerList as $row ) { ?>
                        <option value="<?php echo $row['customer_id']; ?>" <?php if($_GET['customer_id'] == $row['customer_id']) {?> selected="selected" <?php }?>><?php echo $row['customer_name']; ?></option> 
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
                <li><input type="text" id="frDate" name="delivery_date" class="validate[required]" placeholder="select delivery date" value="<?php echo date("m/d/Y", time() + 86400); ?>"  /></li>
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
        <tr id="tabletr1">
          <td><input style="width:100%; height:30px; text-align:right;" type="text" class="textbox text-mini" value=""  name="product_id1" onkeyup="selectProduct(1);" id="product_id1"   onkeypress="return isNumberKey(event);" />
          </td>
          <td align="center">
            <select data-placeholder="Choose a product..." name="product1" id="product1" class="validate[required]" tabindex="2" onchange="getProductDetail(1);" style="width:250px !important; ">
                <option value="">select product</option>
                <?php foreach($productList as $row ) { ?>
                <option value="<?php echo $row['product_id']; ?>"  ><?php echo htmlspecialchars($row['product_name']); ?></option> 
                <?php } ?>	 
            </select>
          </td>
          <td><input style="width:100%; height:30px; text-align:center;" type="text" class="textbox text-input" value=""  name="unit1" id="unit1" readonly="readonly" /></td>
          <td><input style="width:100%; height:30px; text-align:center;" type="text" class="textbox text-input" value=""  name="rate1" id="rate1"  /></td>
          <td align="center">
          <select data-placeholder="Choose a package..." name="packaging_scenario1" id="packaging_scenario1" class="validate[required]" style="width:150px;" tabindex="2" onchange="calculateTotal(1);">
                <option value="">select package</option>
            </select>
         </td>
         <td>
           <input style="width:100%; height:30px; text-align:right;" type="text" class="textbox validate[required,custom[number]] text-input" value="1" name="no_of_packets1" onkeyup="calculateTotal(1);"   onkeypress="return isDecimalKey(event,this.value);" id="no_of_packets1" size="8"/>
          </td>
          <td><input style="width:100%; height:30px; text-align:right;" type="text" class="textbox validate[required,custom[number]] text-input" value=""  name="amount1" id="amount1" readonly="readonly" />
           <input type="hidden" name="discount_desc1" id="discount_desc1" value="" />
           </td>
        </tr>
       
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
          <td width="13%" align="center" valign="middle"><input style="width:100%; height:40px; text-align:right;" class="textbox" id="totalPurchase" name="totalPurchase" type="text"  value="0" readonly="readonly" /></td>
        </tr>
      </table>
      <input type="hidden" name="count" id="count" value="1" />
      <p>&nbsp;</p>
      <div class="form-actions align-right">
      <span id="error"></span>
        <button type="button" name="FormSubmit" onclick="validateForm();" id="formSubmitBtn" class="btn btn-large btn-success">Submit</button>
        <button type="button" onclick="window.location.href='<?php echo Yii::app()->params->base_path;?>admin/salesOrderListing'" class="btn btn-large btn-danger">Cancel</button>
        <button type="reset" class="btn btn-large btn-info">Reset</button>
      </div>
    </div>
  </div>
</form>
<!-- /default form --> 