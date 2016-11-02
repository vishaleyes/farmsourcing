<script type="text/javascript">
	function validateform()
	{
		var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
		if(!validateEmail())
		{
			return false;
		}
		
		return true;	
	}
	function validateEmail()
	{
		$('#emailerror').html('');
		var VAL1=document.getElementById('loginId').value;
		if(VAL1=='' || VAL1=='##_FORGOT_EMAIL_PHONE_VAL_##')
		{
			$('#emailerror').html("<i class='icon-remove' style='margin-top:3px;'></i> &nbsp;&nbsp;<strong style='color:red;'>Please enter email address.</strong>");
			return false;	
		}
		var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
		if (reg.test(VAL1)) 
		{
			$('#emailerror').html('<i class="icon-ok" style="margin-top:3px;"></i> &nbsp;&nbsp;<strong style="color:green;">Ok.</strong>');
			return true;
		}	
		else
		{
			$('#emailerror').html("<i class='icon-remove' style='margin-top:3px;'></i> &nbsp;&nbsp;<strong style='color:red;'>Please enter valid email address.</strong>");
			return false;
		}
	}

</script>
<!-- block -->
	<div class="login">
    <div class="navbar">
        <div class="navbar-inner">
            <h6><i class="icon-lock"></i>Forgot Password</h6>
            <div class="nav pull-right">
                <a href="#" class="dropdown-toggle navbar-icon" data-toggle="dropdown"><i class="icon-cog"></i></a>
                <ul class="dropdown-menu pull-right">
                    <!--<li><a href="#"><i class="icon-plus"></i>Register</a></li>-->
                    <li><a href="<?php echo Yii::app()->params->base_path; ?>admin"><i class="icon-home"></i>Home</a></li>
                    <!--<li><a href="#"><i class="icon-cog"></i>Settings</a></li>-->
                </ul>
            </div>
        </div>
    </div>
    <div class="well">
        <form action="<?php echo Yii::app()->params->base_path;?>admin/forgotPassword" method="post" class="row-fluid" onsubmit="return validateform();">
            <div class="control-group">
                <label class="control-label">Enter Email Address:</label>
                <div class="controls"><input class="span12" type="text" name="loginId" id="loginId" onkeyup="validateEmail()" placeholder="email" /></div>
                <span id="emailerror"></span>
            </div>
            
            <div class="login-btn"><input type="submit" name="submit" value="Submit" class="btn btn-block btn-success" /></div>
        </form>
    </div>
</div>
<!-- /block -->