<script type="text/javascript" >
function validatePassword()
{
	$('#passworderror').html('');
	var password=document.getElementById('password').value;
	if(password=='')
	{
		$('#passworderror').html("<strong style='color:#EDD155;'>Please enter password.</strong>");
		return false;
	}
	else if(password.length < 6)
	{
		$('#passworderror').html("<strong style='color:#EDD155;'>Password must be greater than 6 character.</strong>");
		return false;
	}
	else
	{
		$('#passworderror').html('<strong>&nbsp;</strong>');
		return true;
	}
}

function validateoPassword()
{
	$('#opassworderror').html('');
	var password=document.getElementById('opassword').value;
	if(password=='')
	{
		$('#opassworderror').html("<strong style='color:#EDD155;'>Please enter password.</strong>");
		return false;
	}
	else if(password.length < 6)
	{
		$('#opassworderror').html("<strong style='color:#EDD155;'>Password must be greater than 6 character.</strong>");
		return false;
	}
	else
	{
		$('#opassworderror').html('<strong>&nbsp;</strong>');
		return true;
	}
}

function validateCPassword()
{
	$('#cpassworderror').html('');
	var cpassword=document.getElementById('cpassword').value;
	var password=document.getElementById('password').value;

	if(password=='')
	{
		$('#cpassworderror').html("<strong style='color:#EDD155;'>Please enter confirm paswword.</strong>");
		return false;
	}
	else if(password!=cpassword)
	{
		$('#cpassworderror').html("<strong style='color:#EDD155;'>Password and confirm paswword not match.</strong>");
		return false;
	}
	else
	{
		$('#cpassworderror').html("<strong>&nbsp;</strong>");
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

<div class="row clearfix"></div>
<div class="container">
  <div class="row">
    <div class="col-md-12">
      <div class="breadcrumb"> <a href="<?php echo Yii::app()->params->base_path;?>user"> <i class="fa fa-home fa-fw"></i> Home </a> <i class="fa fa-angle-right fa-fw"></i>Change Password</div>
      
      <!-- Quick Help for tablets and large screens -->
      <div class="quick-message hidden-xs">
        <div class="quick-box">
          <div class="quick-slide"> <span class="title">Help</span>
            <div class="quickbox slide" id="quickbox">
              <div class="carousel-inner">
               <div class="item active"> <a href="#"> <i class="fa fa-envelope fa-fw"></i> Quick Message</a> </div>
                <div class="item"> <a href="<?php echo Yii::app()->params->base_path;?>site/faq"> <i class="fa fa-question-circle fa-fw"></i> FAQ</a> </div>
                <div class="item"> <a href="#"> <i class="fa fa-phone fa-fw"></i> 079-40165800</a> </div>
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
        <h2>Change Password</h2>
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
        <form action="<?php echo Yii::app()->params->base_path;?>user/changePassword" method="post" role="form"  onsubmit="return validateAll();" >
          <label class="control-label">Old Password:</label>
                    <input class="form-control" placeholder="Enter your old password"  type="password" name="opassword" id="opassword"  onkeyup="validateoPassword()" >
          <span id="opassworderror" style="float:left;"></span>
          <br/>
          <label class="control-label">New Password:</label>
                    <input class="form-control" placeholder="Enter your new password"  type="password" name="password" id="password"  onkeyup="validatePassword()" >
          <span id="passworderror" style="float:left;"></span>
          <br/>
          <label class="control-label">Confirm Password:</label>
                    <input class="form-control" placeholder="Enter your confirm password"  type="password" name="cpassword" id="cpassword"  onkeyup="validateCPassword()" >
          <span id="cpassworderror" style="float:left;"></span>
          <br/><br/>
          <button class="btn medium color2" type="submit" name="Save" value="Submit" >Submit</button>
       </form>
       </div>
      </div>
    </div>
  </div>
</div>
<!-- end: big unit -->