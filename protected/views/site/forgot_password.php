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
			$('#emailerror').html("<strong style='color:#EDD155;'>Please enter email address.</strong>");
			return false;	
		}
		var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
		if (reg.test(VAL1)) 
		{
			$('#emailerror').html('<strong>&nbsp;</strong>');
			return true;
		}	
		else
		{
			$('#emailerror').html("<strong style='color:#EDD155;'>Please enter valid email address.</strong>");
			return false;
		}
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
                <div class="item"> <a href="#"> <i class="fa fa-question-circle fa-fw"></i> FAQ</a> </div>
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
        <h2>Forgot Password</h2>
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
        <form action="<?php echo Yii::app()->params->base_path;?>site/forgotPassword" method="post" role="form"  onsubmit="return validateform();">
        		<label class="control-label">Enter Email Address:</label>
                    <input class="form-control" id="loginId" placeholder="Enter your email address" name="loginId" type="text" onkeyup="validateEmail()" >
                    <span id="emailerror" style="float:left;"></span>
                  <br/><br/>
                  <button class="btn medium color2" type="submit" name="submit_login">Submit</button>
       </form>
       </div>
      </div>
    </div>
  </div>
</div>
<!-- end: big unit -->
