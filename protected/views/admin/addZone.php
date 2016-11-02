<!-- Default form -->
<form id="validate" action="<?php echo Yii::app()->params->base_path;?>admin/addZone" method="post" enctype="multipart/form-data">
<div class="widget">
<div class="navbar"><div class="navbar-inner"><h6><a href="<?php echo Yii::app()->params->base_path;?>admin/zoneListing">Zone List</a>&nbsp;&nbsp;<img src="<?php echo Yii::app()->params->base_url;?>images/path-arrow.png" alt="" border="0" />&nbsp;&nbsp;<?php echo $title;?></h6></div></div>

<div class="well">

<div class="control-group">
<label class="control-label">Zone Name<span class="text-error">* &nbsp;</span>:</label>
<div class="controls"><input type="text" name="zoneName" class="validate[required] span12 input-xlarge" placeholder="Enter zone name" value="<?php if(isset($result['zoneName']) && $result['zoneName'] != "") { echo $result['zoneName']; } ?>" /></div>
</div>

 <input type="hidden" <?php if(isset($result['zone_id'])){ ?> value="<?php echo $result['zone_id']; ?>" <?php } ?> name="id"/>
<div class="form-actions align-right">
<button type="submit" name="FormSubmit" class="btn btn-large btn-success">Submit</button>
<button type="button" onclick="window.location.href='<?php echo Yii::app()->params->base_path;?>admin/zoneListing'" class="btn btn-large btn-danger">Cancel</button>
<button type="reset" class="btn btn-large btn-info">Reset</button>
</div>

</div>

</div>
</form>
<!-- /default form -->
