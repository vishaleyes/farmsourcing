<script type="text/javascript">
    //var $j = jQuery.noConflict();
</script>

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

function validateoPassword()
{
	$('#opassworderror').removeClass();
	$('#opassworderror').html('');
	var password=document.getElementById('opassword').value;
	if(password=='')
	{
		$('#opassworderror').addClass('false');
		$('#opassworderror').html("<i class='icon-remove' style='margin-top:3px;'></i> &nbsp;&nbsp;<strong style='color:red;'>Please enter password.</strong>");
		return false;
	}
	else if(password.length < 6)
	{
		$('#opassworderror').addClass('false');
		$('#opassworderror').html("<i class='icon-remove' style='margin-top:3px;'></i> &nbsp;&nbsp;<strong style='color:red;'>Password must be greater than 6 character.</strong>");
		return false;
	}
	else
	{
		$('#opassworderror').removeClass();
		$('#opassworderror').addClass('true');
		$('#opassworderror').html('<i class="icon-ok" style="margin-top:3px;"></i> &nbsp;&nbsp;<strong style="color:green;">Ok.</strong>');
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
function validateAll()
{
	var flag=0;
	
	if(!validateoPassword())
	{
		return false;
	}
	if(!validatePassword())
	{
		return false;
	}
	if(!validateCPassword())
	{
		return false;
	}
	return true;
}
</script>  
<!-- Default form -->
<form id="validate" action="<?php echo Yii::app()->params->base_path;?>admin/changeAdminPassword" method="post" onsubmit="return validateAll();" enctype="multipart/form-data">
<div class="widget">
<div class="navbar"><div class="navbar-inner"><h6>Change Password</h6></div></div>

<div class="well">

    <div class="control-group">
    <label class="control-label">Old Password<span class="text-error">* &nbsp;</span>:</label>
    <div class="controls"><input type="password" name="opassword" id="opassword"  onkeyup="validateoPassword()" class="validate[required] span12 input-xlarge" placeholder="Enter your old password" value="" /></div>
    <span id="opassworderror"></span>
    </div>
    
    <div class="control-group">
    <label class="control-label">New Password<span class="text-error">* &nbsp;</span>:</label>
    <div class="controls"><input type="password" name="password" id="password" onkeyup="validatePassword()" class="validate[required] span12 input-xlarge" placeholder="Enter your new password" value="" /></div>
    <span id="passworderror"></span>
    </div>
    
    <div class="control-group">
    <label class="control-label">Confirm Password<span class="text-error">* &nbsp;</span>:</label>
    <div class="controls"><input type="password" name="cpassword" id="cpassword" onkeyup="validateCPassword()" class="validate[required] span12 input-xlarge" placeholder="Enter confirm password" value="" /></div>
    <span id="cpassworderror"></span>
    </div>
    
    <input type="hidden" name="id" value="<?php echo Yii::app()->session['farmsourcing_adminUser'];?>">
<div class="form-actions align-right">
<input type="submit" name="Save" value="Submit" class="btn btn-large btn-info">
<button type="button" onclick="window.location.href='<?php echo Yii::app()->params->base_path;?>admin/dashboard'" class="btn btn-large btn-danger">Cancel</button>
<button type="reset"  class="btn-large btn">Reset</button>
</div>

</div>

</div>
</form>
<!-- /default form -->