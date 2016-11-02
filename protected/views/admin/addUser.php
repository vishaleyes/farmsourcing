<script type="text/javascript" >
	function validatePassword()
	{
		$('#passworderror').removeClass();
		$('#passworderror').html('');
		var password=document.getElementById('password').value;
		if(password=='')
		{
			$('#passworderror').addClass('false');
			$('#passworderror').html("<i class='icon-remove' style='margin-top:3px;'></i> &nbsp;&nbsp;<strong style='color:red;'>Please enter password.</strong>");
			return false;
		}
		else if(password.length < 6)
		{
			$('#passworderror').addClass('false');
			$('#passworderror').html("<i class='icon-remove' style='margin-top:3px;'></i> &nbsp;&nbsp;<strong style='color:red;'>Password must be greater than 6 character.</strong>");
			return false;
		}
		else
		{
			$('#passworderror').removeClass();
			$('#passworderror').addClass('true');
			$('#passworderror').html('<i class="icon-ok" style="margin-top:3px;"></i> &nbsp;&nbsp;<strong style="color:green;">Ok.</strong>');
			return true;
		}
	}
	
	function validateCPassword()
	{
		$('#cpassworderror').removeClass();
		$('#cpassworderror').html('');
		var cpassword=document.getElementById('cpassword').value;
		var password=document.getElementById('password').value;
	
		if(password=='')
		{
			$('#cpassworderror').addClass('false');
			$('#cpassworderror').html("<i class='icon-remove' style='margin-top:3px;'></i> &nbsp;&nbsp;<strong style='color:red;'>Please enter confirm paswword.</strong>");
			return false;
		}
		else if(password!=cpassword)
		{
			$('#cpassworderror').addClass('false');
			$('#cpassworderror').html("<i class='icon-remove' style='margin-top:3px;'></i> &nbsp;&nbsp;<strong style='color:red;'>Password and confirm paswword not match.</strong>");
			return false;
		}
		else
		{
			$('#cpassworderror').removeClass();
			$('#cpassworderror').addClass('true');
			$('#cpassworderror').html('<i class="icon-ok" style="margin-top:3px;"></i> &nbsp;&nbsp;<strong style="color:green;">Ok.</strong>');
			return true;
		}
	}
	
	function isNumberKeyNew(evt)
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
</script> 
<!-- Default form -->
<form id="validate" action="<?php echo Yii::app()->params->base_path;?>admin/addUser" method="post" enctype="multipart/form-data">
<div class="widget">
<div class="navbar"><div class="navbar-inner"><h6><a href="<?php echo Yii::app()->params->base_path;?>admin/userListing">Users List</a>&nbsp;&nbsp;<img src="<?php echo Yii::app()->params->base_url;?>images/path-arrow.png" alt="" border="0" />&nbsp;&nbsp;<?php echo $title;?></h6></div></div>

<div class="well">

<div class="control-group">
<label class="control-label">First Name<span class="text-error">* &nbsp;</span>:</label>
<div class="controls"><input type="text" name="firstName" class="validate[required] span12 input-xlarge" placeholder="Enter first name" value="<?php if(isset($userData['firstName']) && $userData['firstName'] != "") { echo $userData['firstName']; } ?>" /></div>
</div>

<div class="control-group">
<label class="control-label">Last Name<span class="text-error">* &nbsp;</span>:</label>
<div class="controls"><input type="text" name="lastName" class="validate[required] span12 input-xlarge" placeholder="Enter last name" value="<?php if(isset($userData['lastName']) && $userData['lastName'] != "") { echo $userData['lastName']; } ?>" /></div>
</div>
<?php if($title == 'Create User') { ?>

<div class="control-group">
<label class="control-label">Email<span class="text-error">* &nbsp;</span>:</label>
<div class="controls"><input type="text" name="email" class="validate[required,custom[email]] span12 input-xlarge" placeholder="Enter email address" value="<?php if(isset($userData['email']) && $userData['email'] != "") { echo $userData['email']; } ?>" /></div>
</div>

<?php } else { ?>

<div class="control-group">
<label class="control-label">Email<span class="text-error">* &nbsp;</span>:</label>
<div class="controls"><input type="text" name="email" readonly="readonly" class="validate[required,custom[email]] span12 input-xlarge" placeholder="Enter email address" value="<?php if(isset($userData['email']) && $userData['email'] != "") { echo $userData['email']; } ?>" <?php if($title == "Update User") { ?> readonly="readonly" <?php } ?> /></div>
</div>

<?php } ?>




<div class="control-group">
    <label class="control-label">User Avatar :</label>
    <div class="controls">
        <input type="file" name="avatar" class="styled">
    </div>
    <?php if(isset($userData['avatar']) && $userData['avatar'] != "") { ?>
   <img src="<?php echo Yii::app()->params->base_url; ?>assets/upload/avatar/<?php echo $userData['avatar']; ?>" style="width:210px; height:110px;"  /><?php } ?>
</div>

<?php if($title == 'Create User') { ?> 
                                       
<div class="control-group">
<label class="control-label">Password<span class="text-error">* &nbsp;</span>:</label>
<div class="controls"><input type="password" id="password" name="password" class="validate[required] span12 input-xlarge" placeholder="Enter password"  onkeyup="validatePassword();" /></div>
<span id="passworderror"></span>
</div>

<div class="control-group">
<label class="control-label">Confirm Password<span class="text-error">* &nbsp;</span>:</label>
<div class="controls"><input type="password" name="cpassword" id="cpassword" class="validate[required,equals[password]] span12 input-xlarge" placeholder="Enter confirm password" onkeyup="validateCPassword();"  /></div>
<span id="cpassworderror"></span>
</div>


<?php } ?>

<div class="control-group">
<label class="control-label">Phone<span class="text-error">* &nbsp;</span>:</label>
<div class="controls"><input type="text" name="mobile" id="mobile" class="validate[required] span12 input-xlarge" placeholder="Enter phone" value="<?php if(isset($userData['mobile']) && $userData['mobile'] != "") { echo $userData['mobile']; } ?>" onkeypress="return isNumberKeyNew(event);"  /></div>
<span id="cpassworderror"></span>
</div>


<div class="control-group">
<label class="control-label">User Type<span class="text-error">* &nbsp;</span>:</label>
<div class="controls">
	<select name="type" class="validate[required]" id="type">
    	<option value="">Select User Type</option>
    	<option value="1" <?php if(isset($userData['type']) && $userData['type'] == "1") { ?> selected="selected" <?php } ?> >Ware house Manager</option>
        <option value="2" <?php if(isset($userData['type']) && $userData['type'] == "2") { ?> selected="selected" <?php } ?> >Driver User</option>
        <option value="3" <?php if(isset($userData['type']) && $userData['type'] == "3") { ?> selected="selected" <?php } ?> >Operator</option>
        <option value="4" <?php if(isset($userData['type']) && $userData['type'] == "4") { ?> selected="selected" <?php } ?> >Admin</option>
        <option value="5" <?php if(isset($userData['type']) && $userData['type'] == "5") { ?> selected="selected" <?php } ?> >POS</option>
    </select>
</div>
</div>



 <input type="hidden" <?php if(isset($userData['id'])){ ?> value="<?php echo $userData['id']; ?>" <?php } ?> name="id"/>
<div class="form-actions align-right">
<button type="submit" name="FormSubmit" class="btn btn-large btn-success">Submit</button>
<button type="button" onclick="window.location.href='<?php echo Yii::app()->params->base_path;?>admin/userListing'" class="btn btn-large btn-danger">Cancel</button>
<button type="reset" class="btn btn-large btn-info">Reset</button>
</div>

</div>

</div>
</form>
<!-- /default form -->