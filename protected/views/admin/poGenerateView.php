<!-- Default form -->
<form id="validate" action="<?php echo Yii::app()->params->base_path;?>admin/poGenerate" method="post" enctype="multipart/form-data">
<div class="widget">
<div class="navbar"><div class="navbar-inner"><h6><a href="<?php echo Yii::app()->params->base_path;?>admin/purchaseOrderListing">PO Listing</a>&nbsp;&nbsp;<img src="<?php echo Yii::app()->params->base_url;?>images/path-arrow.png" alt="" border="0" />&nbsp;&nbsp;Create New Purchase Order</h6></div></div>

<div class="well">

<div class="control-group">
<label class="control-label">Enter a delivery date for generate Purchase Order<span class="text-error">* &nbsp;</span>:</label>
<div class="controls"><input type="text" id="fromDate" name="delivery_date" class="validate[required]" placeholder="select delivery date" /></div>
</div>


<div class="form-actions align-right">
<button type="submit" name="FormSubmit" class="btn btn-large btn-success">Submit</button>
<button type="button" onclick="window.location.href='<?php echo Yii::app()->params->base_path;?>admin/purchaseOrderListing'" class="btn btn-large btn-danger">Cancel</button>
<button type="reset" class="btn btn-large btn-info">Reset</button>
</div>

</div>

</div>
</form>
<!-- /default form -->

