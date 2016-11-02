<script>
	function getUnitForCategory(id)
	{
		$.ajax({
		  type: 'POST',
		  url: '<?php echo Yii::app()->params->base_path;?>admin/getUnitForCategory',
		  data: 'cat_id='+id,
		  cache: false,
		  success: function(data)
		  {
			  if(data == 0)
			  {
					alert("data not found.");
					return false;  
			  }else{
				 
				  $("#unit_name").text(data);
				  $("#unit").val(data);
				  return true;
			  }
		  }
	 });
	}
</script>
<!-- Default form -->
<form id="validate" action="<?php echo Yii::app()->params->base_path;?>admin/saveCategoryPackaging" method="post" enctype="multipart/form-data">
<div class="widget">
<div class="navbar"><div class="navbar-inner"><h6><a href="<?php echo Yii::app()->params->base_path;?>admin/categoryPackagingListing">Category Packaging List</a>&nbsp;&nbsp;<img src="<?php echo Yii::app()->params->base_url;?>images/path-arrow.png" alt="" border="0" />&nbsp;&nbsp;<?php echo $title;?></h6></div></div>

<div class="well">
<?php /*?><div class="control-group">
<label class="control-label">Category Name<span class="text-error">* &nbsp;</span>:</label>
	<div class="controls">
		<select name="category_id" id="category_id" class="validate[required]" onchange="getUnitForCategory(this.value);">
        		<option value="">Select Category</option>
				<?php foreach($categoryData as $row) {  ?>
                	<option value="<?php echo $row['cat_id']; ?>" <?php if($row['cat_id'] == $categoryPackaging['category_id']) { ?> selected="selected" <?php } ?>><?php echo $row['category_name']; ?></option>
        		<?php } ?>
        </select>
	</div>
</div><?php */?>

<div class="control-group">
<label class="control-label">Unit Name<span class="text-error">* &nbsp;</span>:</label>
	<div class="controls">
		<select name="pakaging_type" id="pakaging_type" class="validate[required]" onchange="getUnitForCategory(this.value); >
        		<option value="">Select Unit</option>
				<?php foreach($unitData as $row) {  ?>
                	<option value="<?php echo $row['unit_id']; ?>" <?php if($row['unit_id'] == $unitData['unit_id']) { ?> selected="selected" <?php } ?>><?php echo $row['unit_name']; ?></option>
        		<?php } ?>
        </select>
	</div>
</div>


<?php /*?><div class="control-group">
Unit Name :<label id="unit_name" style="font-size:16px; font-weight:bolder;"></label>
<br />
<label style="color:#F00;">You have to input packaging scenario belongs to above unit name.</label>
</div><?php */?>

<input type="hidden" name="unit" id="unit" value="" />
<div class="control-group">
<label class="control-label">Packaging Scenario<span class="text-error">* &nbsp;</span>:</label>
<div class="controls"><input type="text" name="packaging_scenario" class="validate[required] tags span12 input-xlarge" placeholder="Enter category packaging scenario" value="<?php if(isset($categoryPackaging['packaging_scenario']) && $categoryPackaging['packaging_scenario'] != "") { echo $categoryPackaging['packaging_scenario']; }  ?>" /></div>
</div>

<input type="hidden" <?php if(isset($categoryPackaging['id'])){ ?> value="<?php echo $categoryPackaging['id']; ?>" <?php } ?> name="id"/>
<div class="form-actions align-right">
<button type="submit" name="FormSubmit" class="btn btn-large btn-success">Submit</button>
<button type="button" onclick="window.location.href='<?php echo Yii::app()->params->base_path;?>admin/categoryPackagingListing'" class="btn btn-large btn-danger">Cancel</button>
<button type="reset" class="btn btn-large btn-info">Reset</button>
</div>

</div>

</div>
</form>
<!-- /default form -->