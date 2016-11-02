<!-- Default form -->
<form id="validate" action="<?php echo Yii::app()->params->base_path;?>admin/saveProfitPercentage" method="post" enctype="multipart/form-data">
  <div class="widget">
    <div class="navbar">
      <div class="navbar-inner">
        <h6><a href="<?php echo Yii::app()->params->base_path;?>admin/profitPercentageListing">Profit Percentage</a>&nbsp;&nbsp;<img src="<?php echo Yii::app()->params->base_url;?>images/path-arrow.png" alt="" border="0" />&nbsp;&nbsp;<?php echo $title;?></h6>
      </div>
    </div>
    <div class="well">
    
        <?php 
			$productObj = new Product();
			$productList = $productObj->getAllProducts();
  		?>
      <div class="control-group">
        <label class="control-label">Product<span class="text-error">* &nbsp;</span>:</label>
        <div class="controls">
          <select data-placeholder="Choose a product..."  name="product_id"  id="product_id" class="select validate[required]" tabindex="2">
            <option value="">Select Product</option>
            <?php foreach($productList as $row ) { ?>
            <option value="<?php echo $row['product_id']; ?>" <?php if(isset($profitPercentageData['product_id']) && $profitPercentageData['product_id'] == $row['product_id'] ) { ?> selected="selected" <?php } ?>  ><?php echo $row['product_name']; ?></option>
            <?php } ?>
          </select>
        </div>
      </div>
    
      <div class="control-group">
        <label class="control-label">Profit Percentage<span class="text-error">* &nbsp;</span>:</label>
        <div class="controls">
          <input type="text" name="profit_percentage" class="validate[required] span12 input-xlarge" placeholder="Enter profit percentage" value="<?php if(isset($profitPercentageData['profit_percentage']) && $profitPercentageData['profit_percentage'] != "") { echo $profitPercentageData['profit_percentage']; } ?>"  <?php if($title == 'Update Category') {  ?>readonly="readonly" <?php } ?>/>
        </div>
      </div>
      <div class="control-group">
        <label class="control-label">From Date<span class="text-error">* &nbsp;</span>:</label>
        <div class="controls">
          <input type="text" name="from_date" id="fromDate" class="validate[required] span12 input-xlarge" placeholder="Enter from date" value="<?php if(isset($profitPercentageData['from_date']) && $profitPercentageData['from_date'] != "") { echo $profitPercentageData['from_date']; } ?>" />
        </div>
      </div>
      <div class="control-group">
        <label class="control-label">To Date<span class="text-error">* &nbsp;</span>:</label>
        <div class="controls">
          <input type="text" name="to_date" id="toDate" class="validate[required] span12 input-xlarge" placeholder="Enter to date" value="<?php if(isset($profitPercentageData['to_date']) && $profitPercentageData['to_date'] != "") { echo $profitPercentageData['to_date']; } ?>" />
        </div>
      </div>
    
    
      <input type="hidden" <?php if(isset($profitPercentageData['id'])){ ?> value="<?php echo $profitPercentageData['id']; ?>" <?php } ?> name="id"/>
      <div class="form-actions align-right">
        <button type="submit" name="FormSubmit" class="btn btn-large btn-success">Submit</button>
        <button type="button" onclick="window.location.href='<?php echo Yii::app()->params->base_path;?>admin/profitPercentageListing'" class="btn btn-large btn-danger">Cancel</button>
        <button type="reset" class="btn btn-large btn-info">Reset</button>
      </div>
    </div>
  </div>
</form>
<!-- /default form -->