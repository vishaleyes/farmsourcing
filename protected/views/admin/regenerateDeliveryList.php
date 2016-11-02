 <script type="text/javascript">

	function validateForm() {
		
		var delivery_date = $("#fromDate").val();
		
		if(delivery_date == '')
		{
			alert("Please enter delivery date.");
			return false;
		}
		else
		{
			var r = confirm("Are you sure want to regenerate delivery slip of "+delivery_date+".");
			
			if (r==true)
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		
		return true;
   }
	
</script>
  <div class="widget">
    <div class="navbar">
      <div class="navbar-inner">
        <h6><a href="<?php echo Yii::app()->params->base_path;?>admin/generateDeliveryReport">Delivery List</a>&nbsp;&nbsp;<img src="<?php echo Yii::app()->params->base_url;?>images/path-arrow.png" alt="" border="0" />&nbsp;&nbsp;Regenerate Delivery Slip</h6>
      </div>
    </div>
    <div class="well">
<form id="validate" action="<?php echo Yii::app()->params->base_path;?>admin/regenerateDeliverySlip" method="post" enctype="multipart/form-data" onsubmit="return validateForm();" >
      <table width="90%" id="ordertbl" align="center" border="0" cellspacing="5" cellpadding="5" >
        <tr>
            <td width="10%">
                <div class="control-group">
                    <div class="controls" style="margin-top:-15px;">
                       <div style="float:left;">
                       <label class="control-label">Delivery Date :</label>
                        <input type="text" name="delivery_date" id="fromDate" class="input-medium" placeholder="Select Delivery Date" value="<?php if(isset($ext['delivery_date'])){ echo $ext['delivery_date']; } ?>" />
                        </div>
                    </div>         
                          
                </div>
            </td>
            <td width="33%">
            	<label class="control-label"> &nbsp; </label>
                 <input class="btn btn-large btn-info" type="submit" name="submit" value="Submit" />
            </td>
        </tr>
      </table>
</form>     
    </div>
  </div>

<!-- /default form --> 
