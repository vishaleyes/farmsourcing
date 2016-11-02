<script type="text/javascript">
	 function validateresetform()
	 {
		if($('#token').val() == "")
		{
			$('#tokenerror').html("<strong style='color:#EDD155;'>Please enter verification code.</strong>");
			return false;
		}else{
			$('#tokenerror').html("<strong>&nbsp;</strong>");
		}
		
		if($('#new_password').val() == "" || $('#new_password').val().length < 6)
		{
			//$('#topDiv').css("display","block");
			$('#passworderror').html("<strong style='color:#EDD155;'>Please enter minimum 6 character in new password.</strong>");
			//$('#new_password').focus();
			return false;
		}else{
			$('#passworderror').html("<strong>&nbsp;</strong>");
		}
		
		if($('#new_password').val() != $('#new_password_confirm').val())
		{
			//$('#topDiv').css("display","block");
			$('#cpassworderror').html("<strong style='color:#EDD155;'>New password and Confirm password does not match.</strong>");
			//$('#new_password_confirm').focus();
			return false;
		}else{
			$('#cpassworderror').html("<strong>&nbsp;</strong>");
		}
		//$('#topDiv').css("display","none");
		return true;
	 }
</script>

<div class="row clearfix"></div>
<div class="container">
  <div class="row">
    <div class="col-md-12">
      <div class="breadcrumb"> <a href="<?php echo Yii::app()->params->base_path;?>site"> <i class="fa fa-home fa-fw"></i> Home </a> <i class="fa fa-angle-right fa-fw"></i> <a href="<?php echo Yii::app()->params->base_path;?>site/forgotPassword">Forgot Password</a> </div>
      
      <!-- Quick Help for tablets and large screens -->
      <div class="quick-message hidden-xs">
        <div class="quick-box">
          <div class="quick-slide"> <span class="title">Help</span>
            <div class="quickbox slide" id="quickbox">
              <div class="carousel-inner">
                <div class="item active"> <a href="#"> <i class="fa fa-envelope fa-fw"></i> Quick Message</a> </div>
                <div class="item"> <a href="<?php echo Yii::app()->params->base_path;?>site/faq"> <i class="fa fa-question-circle fa-fw"></i> FAQ</a> </div>
                <div class="item"> <a href="#"> <i class="fa fa-phone fa-fw"></i>079-40165800</a> </div>
              </div>
            </div>
            <a class="left carousel-control" data-slide="prev" href="#quickbox"> <i class="fa fa-angle-left fa-fw"></i> </a> <a class="right carousel-control" data-slide="next" href="#quickbox"> <i class="fa fa-angle-right fa-fw"></i> </a> </div>
        </div>
      </div>
      <!-- end: Quick Help --> 
      
    </div>
  </div>
</div>
<div class="row clearfix f-space10"></div>
<div class="container">
  <div class="row">
    <div class="col-md-12">
      <div class="page-title">
        <h2>Forgot Password Verification</h2>
      </div>
    </div>
  </div>
</div>
<div class="row clearfix f-space10"></div>
<!-- big unit -->
<div class="container">
  <div class="row">
    <div class="col-md-12">
     <div class="big-unit" align="center">
      	<div style="width:50%" align="left">
        <form action="<?php echo Yii::app()->params->base_path;?>site/resetPassword" method="post" role="form"  onsubmit="return validateresetform();">
        <label class="control-label" style="float:left">Enter Verification Code:</label>
            <input class="form-control" placeholder="verification code" name="token" id="token" placeholder="verification code" <?php if( isset($token) ) {?>value="<?php echo $token;?>"<?php }?> type="text"  onkeyup="validateresetform()" >
            <span id="tokenerror" style="float:left;"></span>
          <br/>
          <label class="control-label" style="float:left">New Password:</label>
            <input class="form-control" placeholder="password" type="password" name="new_password" id="new_password"  placeholder="password" onkeyup="validateresetform()" >
            <span id="passworderror" style="float:left;"></span>
          <br/>
          <label class="control-label" style="float:left">Confirm Password:</label>
            <input class="form-control" placeholder="confirm password" type="password" name="new_password_confirm" id="new_password_confirm" placeholder="confirm password" onkeyup="validateresetform()" >
            <span id="cpassworderror" style="float:left;"></span>
          <br/>
          <button class="btn medium color2" type="submit" name="submit_reset_password_btn">Submit</button>
       </form>
       </div>
      </div>
    </div>
  </div>
</div>
<!-- end: big unit -->