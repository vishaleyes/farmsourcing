<script type="text/javascript" >
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
</script> 

<form id="validate" action="<?php echo Yii::app()->params->base_path;?>admin/savePromocodeAllocation" method="post" enctype="multipart/form-data">
  <div class="widget">
    <div class="navbar">
      <div class="navbar-inner">
        <h6><a href="<?php echo Yii::app()->params->base_path;?>admin/promoCodesListing">Promo Codes</a>&nbsp;&nbsp;<img src="<?php echo Yii::app()->params->base_url;?>images/path-arrow.png" alt="" border="0" />&nbsp;&nbsp;<?php echo $title;?></h6>
      </div>
    </div>
    <div class="well">
    
        <?php /*?> <div class="control-group">
      <?php 
			$customerObj = new Customers();
			$customerList = $customerObj->getAllCustomers();
		  ?>
        <label class="control-label">Customer <span class="text-error">* &nbsp;</span>:</label>
        <div class="controls">
           <select data-placeholder="Choose a customer..." name="customer_id" id="customer_id" onchange="selectCustomer1();" class="validate[required]" tabindex="2">
                        <option value="">select customer</option>
						<?php foreach($customerList as $row ) { ?>
                        <option value="<?php echo $row['customer_id']; ?>"  <?php if(isset($promocodeData['customer_id']) &&  $promocodeData['customer_id'] == $row['customer_id'] ) { ?> selected="selected" <?php } ?> ><?php echo $row['customer_name']; ?></option> 
                        <?php } ?>	 
                    </select>
                    <input style="text-align:right;" type="text" class="input-mini" name="customer_id_select" id="customer_id_select" onkeyup="selectCustomer();" value="<?php if(isset($promocodeData['customer_id_select']) &&  $promocodeData['customer_id_select'] != '' ) { echo $promocodeData['customer_id_select'] ; } ?>" />
        </div>
      </div><?php */?>
      <?php
	  	$abc= array("a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z",
											"A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z",
											"0", "1", "2", "3", "4", "5", "6", "7", "8", "9");
		$promocode = $abc[rand(0,61)].$abc[rand(0,61)].$abc[rand(0,61)].$abc[rand(0,61)].$abc[rand(0,61)].$abc[rand(0,61)];
		$promocode = $promocode.$abc[rand(0,61)].$abc[rand(0,61)].$abc[rand(0,61)].$abc[rand(0,61)].$abc[rand(0,61)].$abc[rand(0,61)];
	  ?>
    
      <div class="control-group">
        <label class="control-label">Promo Code Unique Id<span class="text-error">* &nbsp;</span>:</label>
        <div class="controls">
          <input type="text" name="promocode_uniqueId" class="validate[required] span12 input-medium" placeholder="" value="<?php if(isset($promocodeData['promocode_uniqueId']) &&  $promocodeData['promocode_uniqueId'] != '' ) { echo $promocodeData['promocode_uniqueId'] ; } else { echo $promocode ; } ?>"  readonly="readonly" style="font-size:14px !important;" />
        </div>
      </div>
      
  <div class="control-group">
        <label class="control-label">RS OR PERCENTAGE?<span class="text-error">* &nbsp;</span>:</label>
        <div class="controls">
          RS &nbsp;<input type="radio" name="promocode_type" id="promocode_type" <?php if(isset($promocodeData['promocode_type']) &&  $promocodeData['promocode_type'] == '0') { ?> checked="checked"<?php } ?>  value="0" />
          % &nbsp;<input type="radio" name="promocode_type" <?php if(isset($promocodeData['promocode_type']) &&  $promocodeData['promocode_type'] == '1') { ?> checked="checked"<?php } ?>  id="promocode_type" value="1" />
        </div>
      </div>
 
 
      <div class="control-group">
        <label class="control-label">Promo Code Discount<span class="text-error">* &nbsp;</span>:</label>
        <div class="controls">
          <input type="text" name="promocode_amount" id="promocode_amount" class="validate[required] span12 input-medium" placeholder="Enter Promocode amount" value="<?php if(isset($promocodeData['promocode_amount']) &&  $promocodeData['promocode_amount'] != '' ) { echo $promocodeData['promocode_amount'] ; } ?>" onkeypress="return isNumberKey(event);"  />
        </div>
      </div>
      
     <?php /*?> <div class="control-group">
        <label class="control-label">Used Amount<span class="text-error">* &nbsp;</span>:</label>
        <div class="controls">
          <input type="text" name="used_amount" id="used_amount" class="validate[required] span12 input-xlarge" placeholder="Enter used amount" value="<?php if(isset($promocodeData['used_amount']) && $promocodeData['used_amount'] != "") { echo $promocodeData['used_amount']; } ?>" onkeypress="return isNumberKey(event);"  />
        </div>
      </div><?php */?>
     
     
     
      <input type="hidden" value="<?php if(isset($promocodeData['promocode_id']) &&  $promocodeData['promocode_id'] != '' ) { echo $promocodeData['promocode_id'] ; } ?>" name="promocode_id"/>
      <div class="form-actions align-right">
        <button type="submit" name="FormSubmit" class="btn btn-large btn-success">Submit</button>
        <button type="button" onclick="window.location.href='<?php echo Yii::app()->params->base_path;?>admin/promoCodesListing'" class="btn btn-large btn-danger">Cancel</button>
        <button type="reset" class="btn btn-large btn-info">Reset</button>
      </div>
    </div>
  </div>
</form>
<!-- /default form -->