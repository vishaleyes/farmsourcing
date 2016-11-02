<script type="text/javascript">
	
	function calculateTotal(id) {
		
		var poquantity = $("#poquantity_"+id).val();
		var price = $("#price_"+id).val();

		totalAmount = Number(poquantity) * Number(price) ;

		$("#amount_"+id).val(totalAmount);
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

function getDeliveryDescId(id)
{
	var orderType = "posOrder";
	 $.ajax({
	  type: 'POST',
	  url: '<?php echo Yii::app()->params->base_path;?>admin/getDeliveryDescId',
	  data: 'so_id='+id+'&orderType='+orderType,
	  cache: false,
	  success: function(data)
	  {
		 
		  if(data == 0)
		  {
				alert("data not found.");
				return false;  
		  }else{
			 // alert(data);
			    var obj = jQuery.parseJSON(data);
				//var due_amount = Number(obj.so_amount);
				//if(due_amount <= 0)
				//{
				//	due_amount = 0 ;	
				//}
				//$("#due_amount").text(due_amount); 
				//$("#due_amount1").val(due_amount); 
				//$("#customer_id").val(obj.customer_id);
				//$("#driver_name").val(obj.driver);
				//$("#customer_name").val(obj.customer_name);
				//$("#cash_amount").val(Number(obj.totalRemainingCredit)); 
				$("#credit_amount").val(Number(obj.totalRemainingCredit));  
				//$("#coupon_amount").val(0); 
				$("#totalCredit").val(Number(obj.totalRemainingCredit));
				$("#remainingCredit1").text(Number(obj.totalRemainingCredit));
				$("#id").val(obj.id); 
				//getCustomerRemainingAmount(obj.customer_id,obj.rejection_amount);
		  }
	  }
	 });
}

function getCustomerRemainingAmount(id,rejection_amount)
{
	 $.ajax({
	  type: 'POST',
	  url: '<?php echo Yii::app()->params->base_path;?>admin/getCustomerRemainingAmount',
	  data: 'customer_id='+id,
	  cache: false,
	  success: function(data)
	  {
		var remainingAmount = Number(data).toFixed(2) - rejection_amount ;
		$("#remainingCredit1").text(remainingAmount);
		$("#remainingCredit").val(remainingAmount); 
	  }
	 });
}

function setCreditAmount(value) {
		//alert(CREDIT);
		//var due_amount = $("#remainingCredit1").val(); 
		var totalCredit = $("#totalCredit").val();
		var cash = value ;
		
		//alert(due_amount);
		var credit = Number(totalCredit) -  Number(cash) ;
		
		if(Number(credit) <= 0)
		{
			credit = 0;	
		}
		
		$("#credit_amount").val(credit); 
	}
	
	function setByOrder(orderType)
	{
		//alert(orderType);
		window.location.href = '<?php echo Yii::app()->params->base_path;?>admin/setByOrder/orderType/'+orderType;
	
	}


</script>
<form id="validate" action="<?php echo Yii::app()->params->base_path;?>admin/saveCollectionPayment" method="post" enctype="multipart/form-data">
<div class="widget">
<div class="navbar"><div class="navbar-inner"><h6>Customer Collection Entry</h6></div></div>

    <div class="well">
    
    <div class="control-group">
        <label class="control-label">Order Type<span class="text-error">* &nbsp;</span>:</label>
        <div class="controls">
         Admin Order &nbsp;<input type="radio" name="order_type" id="order_type" value="adminOrder"  onchange="setByOrder(this.value);"  />
         POS &nbsp;<input type="radio" name="order_type" id="order_type" value="posOrder"  onchange="setByOrder(this.value);" checked="checked" />
         
          
        </div>
      </div>
  
        <div class="control-group">
            <label class="control-label">Order ID:</label>
            <div class="controls">
            	<select name="so_id" id="so_id" onchange="getDeliveryDescId(this.value);" class="select">
                <option value="">Select Order</option>
                		<?php foreach($soDetailsData as $row) {
							
							 ?>
                        <option value="<?php echo $row['so_id']; ?>" <?php if(isset($post['so_id']) &&  $post['so_id'] == $row['so_id'] ) { ?> selected="selected" <?php } ?>><?php echo $row['so_id']; ?></option>
                        <?php } ?>
                </select>
            </div>
         </div>
      
      
         <div class="control-group">
         <span>Customer Remaining Credit : <b id="remainingCredit1" style="color:#F00;"><?php if(isset($post['remainingCredit']) &&  $post['remainingCredit'] != '' ) { echo $post['remainingCredit'] ; } ?></b></span><br/>
         <br/>
            <label class="control-label">Amount : </label>
            <div class="controls">
            <input type="text" name="cash_amount" id="cash_amount" class="validate[required] span12 input-large" placeholder="Amount"  value="<?php if(isset($post['cash_amount']) &&  $post['cash_amount'] != '' ) { echo $post['cash_amount'] ; } ?>" onkeyup="setCreditAmount(this.value);" /> &nbsp; 
            <input readonly="readonly" type="text" name="credit_amount" id="credit_amount" class="validate[required] span12 input-large" placeholder="Remaining Credit Amount"  value="<?php if(isset($post['credit_amount']) &&  $post['credit_amount'] != '' ) { echo $post['credit_amount'] ; } ?>" /> &nbsp; 
               
         </div></div>
        

<input type="hidden" id="due_amount1" name="due_amount" value="<?php if(isset($post['due_amount']) &&  $post['due_amount'] != '' ) { echo $post['due_amount'] ; } ?>" />

<input type="hidden" id="remainingCredit" name="remainingCredit" value="<?php if(isset($post['remainingCredit']) &&  $post['remainingCredit'] != '' ) { echo $post['remainingCredit'] ; } ?>" />

<input type="hidden" id="customer_id" name="customer_id" value="<?php if(isset($post['customer_id']) &&  $post['customer_id'] != '' ) { echo $post['customer_id'] ; } ?>" />
   
   <input type="hidden" name="orderType" value="posOrder" />
<input type="hidden" name="totalCredit" id="totalCredit" />
    
<div class="form-actions align-right">
<button type="submit" name="FormSubmit" class="btn btn-large btn-success">Submit</button>
<button type="button" onclick="window.location.href='<?php echo Yii::app()->params->base_path;?>admin/salesOrderListing'" class="btn btn-large btn-danger">Cancel</button>
<button type="reset" class="btn btn-large btn-info">Reset</button>
</div>
</div>
</div>
</form>