<script type="text/javascript">
	 function validateresetform()
	 {
		if($('#token').val() == "")
		{
			$('#topDiv').css("display","block");
			$('#passwordreseterror').html("<i class='icon-remove' style='margin-top:3px;'></i> &nbsp;&nbsp;<strong style='color:red;'>Please enter verification code.</strong>");
			$('#token').focus();
			return false;
		}
		
		if($('#new_password').val() == "" || $('#new_password').val().length < 6)
		{
			$('#topDiv').css("display","block");
			$('#passwordreseterror').html("<i class='icon-remove' style='margin-top:3px;'></i> &nbsp;&nbsp;<strong style='color:red;'>Please enter minimum 6 character in new password.</strong>");
			$('#new_password').focus();
			return false;
		}
		
		if($('#new_password').val() != $('#new_password_confirm').val())
		{
			$('#topDiv').css("display","block");
			$('#passwordreseterror').html("<i class='icon-remove' style='margin-top:3px;'></i> &nbsp;&nbsp;<strong style='color:red;'>New password and Confirm password does not match.</strong>");
			$('#new_password_confirm').focus();
			return false;
		}
		$('#topDiv').css("display","none");
		return true;
	 }
</script>
<!-- block -->
	<div class="login">
    <div class="navbar">
        <div class="navbar-inner">
            <h6><i class="icon-lock"></i>Forgot Password Verification</h6>
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
        <form action="<?php echo Yii::app()->params->base_path;?>admin/resetPassword" method="post" class="row-fluid" onsubmit="return validateresetform();">
       		<div class="control-group" id="topDiv" style="display:none;">
            	<span id="passwordreseterror"></span>
            </div>
            <div class="control-group">
            	
                <label class="control-label">Enter Verification Code:</label>
                <div class="controls"><input class="span12" type="text" name="token" id="token" placeholder="verification code" <?php if( isset($token) ) {?>value="<?php echo $token;?>"<?php }?>/></div>
            </div>
            
            <div class="control-group">
                <label class="control-label">New Password:</label>
                <div class="controls"><input class="span12" type="password" name="new_password" id="new_password"  placeholder="password" /></div>
            </div>
            
            <div class="control-group">
                <label class="control-label">Confirm Password:</label>
                <div class="controls"><input class="span12" type="password" name="new_password_confirm" id="new_password_confirm" placeholder="confirm password" /></div>
            </div>
            
            <div class="login-btn"><input type="submit" name="submit_reset_password_btn" value="Submit" class="btn btn-block btn-success" /></div>
        </form>
    </div>
</div>
<!-- /block -->