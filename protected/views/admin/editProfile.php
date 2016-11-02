<!-- Default form -->
<form id="validate" action="<?php echo Yii::app()->params->base_path;?>admin/saveProfile" method="post" enctype="multipart/form-data">
<div class="widget">
<div class="navbar"><div class="navbar-inner"><h6><a href="<?php echo Yii::app()->params->base_path;?>admin/myprofile">My Profile</a>&nbsp;&nbsp;<img src="<?php echo Yii::app()->params->base_url;?>images/path-arrow.png" alt="" border="0" />&nbsp;&nbsp;Edit</h6></div></div>

<div class="well">

    <div class="control-group">
    <label class="control-label">FirstName<span class="text-error">* &nbsp;</span>:</label>
    <div class="controls"><input type="text" name="firstName" class="validate[required] span12 input-xlarge" placeholder="Enter first name" value="<?php if(isset($data['firstName']) && $data['firstName'] != "") { echo $data['firstName']; } ?>" /></div>
    </div>
    
    <div class="control-group">
    <label class="control-label">LastName<span class="text-error">* &nbsp;</span>:</label>
    <div class="controls"><input type="text" name="lastName" class="validate[required] span12 input-xlarge" placeholder="Enter last name" value="<?php if(isset($data['lastName']) && $data['lastName'] != "") { echo $data['lastName']; } ?>" /></div>
    </div>
    
    <div class="control-group">
        <label class="control-label">Avatar :</label>
        <div class="controls">
            <input type="file" name="userFile" class="styled">
        </div>
        <?php if(isset($data['avatar']) && $data['avatar'] != "") { ?>
       <img src="<?php echo Yii::app()->params->base_url; ?>assets/upload/avatar/<?php echo $data['avatar']; ?>" style="width:210px; height:150px;"  /><?php } else { ?><img src="http://placehold.it/210x110" alt="" /><?php } ?>
    </div>
                                            
    <div class="control-group">
    <label class="control-label">Email<span class="text-error">* &nbsp;</span>:</label>
    <div class="controls"><input type="text" name="lastName" class="validate[required] span12 input-xlarge" placeholder="Enter last name" disabled="disabled" value="<?php if(isset($data['email']) && $data['email'] != "") { echo $data['email']; } ?>" /></div>
    </div>
    
    <input type="hidden" <?php if(isset($data['id'])){ ?> value="<?php echo $data['id']; ?>" <?php } ?> name="AdminID"/>
     
<div class="form-actions align-right">
<button type="submit" name="FormSubmit" class="btn btn-large btn-info">Submit</button>
<button type="button" onclick="window.location.href='<?php echo Yii::app()->params->base_path;?>admin/channelListing'" class="btn btn-large btn-danger">Cancel</button>
<button type="reset"  class="btn-large btn">Reset</button>
</div>

</div>

</div>
</form>
<!-- /default form -->