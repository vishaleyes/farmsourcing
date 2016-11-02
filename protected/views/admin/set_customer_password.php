<!-- Span 12 -->
    <div class="widget">
        <div class="navbar">
            <div class="navbar-inner"><h6>Set New Password For Customer</h6></div>
        </div>
        <!-- Default form -->
<form id="validate" action="<?php echo Yii::app()->params->base_path;?>admin/setNewPasswordOfCustomer" method="post" enctype="multipart/form-data">
    <div class="widget">
    <div class="well">
    
        <div class="control-group">
        <label class="control-label">New Password<span class="text-error">* &nbsp;</span>:</label>
        <div class="controls"><input type="password" id="password" name="password" class="validate[required] span12 input-xlarge" placeholder="Enter new password" /></div>
        </div>
        
        <input type="hidden" <?php if(isset($id)){ ?> value="<?php echo $id ; ?>" <?php } ?> name="id"/>
        <div class="form-actions align-right">
        <button type="submit" name="FormSubmit" class="btn btn-large btn-success">Submit</button>
        </div>
    
    </div>
    
    </div>
</form>
<!-- /default form -->
    </div>
<!-- /span 12 -->