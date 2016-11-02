<script src="<?php echo Yii::app()->params->base_path_language; ?>languages/<?php echo Yii::app()->session['prefferd_language']?>/global.js" type="text/javascript"></script>
<script type="text/javascript">
var BASHPATH='<?php echo Yii::app()->params->base_path; ?>';
var base_path='<?php echo Yii::app()->params->base_path; ?>';
</script>
<script type="text/javascript">


function boxOpen(id)
{
	$j('#'+id).show();
}

function boxClose(id,fieldId)
{
	$j('#'+id).hide();
}


function validateAllAbout()
{
	if(!validatefName())
	{
		return false;
	}
	if(!validatelName())
	{
		return false;
	}
	
	email=document.getElementById('email').value;
	if(email!='')
	{		
		if($j("#eml").html() == "false")
		{
			return false;
		}
	}
	return true;
}

function validatefName()
{
	$j('#fullnameerror').removeClass();
	$j('#fullnameerror').html('');
	var fName=document.getElementById('fName').value;
	if(fName=='')
	{
		$j('#fullnameerror').addClass('false');
		$j('#fullnameerror').html(msg['FNAME_VALIDATE']);
		return false;
	}
	var reg = msg["FIRST_NAME_REG"];
	if(reg.test(fName))
	{
		$j('#fullnameerror').removeClass();
		$j('#fullnameerror').addClass('true');
		$j('#fullnameerror').html('##_BTN_OK_##');
		return true;
	}
	else
	{
		$j('#fullnameerror').addClass('false');
		$j('#fullnameerror').html(msg['FIRST_NAME_REG_SPECIAL_CHARACTER']);
		return false;
	}
}
function validatelName()
{
	$j('#fullnameerror').removeClass();
	$j('#fullnameerror').html('');
	var lName=document.getElementById('lName').value;
	if(lName=='')
	{
		$j('#fullnameerror').addClass('false');
		$j('#fullnameerror').html(msg['LNAME_VALIDATE']);
		return false;
	}
	var reg = msg["LAST_NAME_REG"];
	if(reg.test(lName))
	{
		$j('#fullnameerror').removeClass();
		$j('#fullnameerror').addClass('true');
		$j('#fullnameerror').html('##_BTN_OK_##');
		return true;
	}
	else
	{
		$j('#fullnameerror').addClass('false');
		$j('#fullnameerror').html(msg['LAST_NAME_REG_SPECIAL_CHARACTER']);
		return false;
	}
}
function validateEmail()
{
	$j('#emailerror').removeClass();
	$j('#emailerror').html('');
	var loginType="<?php echo Yii::app()->session['loginIdType']; ?>";
	if(loginType==0)
	{
		$j('#emailerror').addClass('true');
		$j('#emailerror').html(msg['_RESTRIC_TO_CHANGE_EMAIL_']);
		return true;
	}
	var email=document.getElementById('email').value;
	if(email=='')
	{		
		return true;
	}
	else
	{
		var reg = msg['EMAIL_REG'];
		if(reg.test(email))
		{
			$j.ajax({  
			type: "POST",  
			url: '<?php echo Yii::app()->params->base_path;?>pos/checkOtherEmail/type/true' ,  
			data: "email="+email+"&"+csrfToken,  
			success: function(response) 
			{ 
			
				if(response==false)
				{
					$j('#emailerror').removeClass();
					$j('#emailerror').addClass('true');
					$j('#emailerror').html(msg['SUCCESS_EMAIL_VALIDATE_ACCOUNT_MANAGER']);
					$j('#eml').html('true');
				}
				else
				{
					$j('#emailerror').removeClass();
					$j('#emailerror').addClass('false');
					$j('#emailerror').html(msg['EMAIL_NOT_AVAILABLE_VALIDATE_ERROR']);
					$j('#eml').html('false');
				}
			}
			});
			return true;
		}
		else
		{
			$j('#emailerror').removeClass();
			$j('#emailerror').addClass('false');
			$j('#emailerror').html(msg['EMAIL_VALIDATE_VALID_ERROR_ACCOUNT_MANAGER']);
			return false;
		}
	}
}
function editAboutMe()
{
	if(!validateAllAbout())
	{
		$j('#update-message').html('');
		return false;
	}
	var post_data = $j("#frm_edit_profile").serialize();
	var email=document.getElementById('email').value;
	var fName=document.getElementById('fName').value;
	var lName=document.getElementById('lName').value;
	var fullname = fName+'&nbsp;'+lName;
	if(email==''){
		email	=	"<a id='add_email' href='javascript:;' rel='<?php echo Yii::app()->params->base_path;?>pos/aboutme' title='Add email'  onclick=javascript:$j('#headerLinkAboutme').trigger('click');>##_SEEKER_INDEX_ADD_EMAIL_##</a>";
	}
	
	$j("#btn_submit").attr("disabled","disabled");
	$j("#loader_profile").css('display','block');
	$j.ajax({			
		type: 'POST',
		url: base_path+'pos/editProfile&id=1',
		data: post_data,
		cache: false,
		success: function(data)
		{
			setTimeout(function() { $j("#msgbox").fadeOut();}, 2000 );
	  	    setTimeout(function() { $j("#msgbox1").fadeOut();},2000 ); 
			if(data == "logout")
			{
				window.location.href = "<?php echo Yii::app()->params->base_path; ?>";
			}
			else if(data == "userdelete")
			{
				jConfirm("##_ABOUTME_DELETE_EMAIL_ACCOUNT_##", '##_ABOUTME_EMAIL_CONFIRMATION_DIALOG_##', function(response) {
				if(response==true)
				{
					document.getElementById('deleteyes').value=1;
					editAboutMe();
				}
				else
				{
					$j('#update-message').html('');
					$j('#headerLinkAboutme').trigger('click');
					return false;	
				}
				});
				$j("#loader_profile").css('display','none');
			}
			else
			{
				
				$j("#myfullname").html('<b>'+fullname+'</b>');
				$j(".username").html('<b>Hi '+fullname+'</b>');
				var arr = data.split(',');
				if(arr[0] == 'success')
				{
					$j(".secondcont").html(data);
					setTimeout(function() { $j("#msgbox").fadeOut();}, 2000 );
					setTimeout(function() { $j("#msgbox1").fadeOut();},2000 );		
					$j("#btn_submit").attr("disabled",false);
					$j("#loader_profile").css('display','none');	
					$j("#aboutmeTd").trigger('click');
					$j("#email-address").html('<b>'+email+'</b>');
				}	
				else
				{
					$j("#btn_submit").attr("disabled",false);
					$j("#loader_profile").css('display','none');
					$j(".secondcont").html(data);
					$j("#aboutmeTd").trigger('click');
					setTimeout(function() { $j("#msgbox").fadeOut();}, 2000 );
					setTimeout(function() { $j("#msgbox1").fadeOut();},2000 );	
				}
			}
			
		}
	});
}

$j(document).ready(function() {
	$j(".box_open").click(function(){
		if(trim($j(this).attr("title")) != trim($j(this).html()))
		{
			var id = $j(this).attr("rel");
			id = '#'+id;
			$j(id).val(trim($j(this).html()));
			$j(id).focus().select();
		}
	})
	
	
	/* link */
	$j(".ltf_button").click(function() 
	{   
		var base_path = '<?php echo Yii::app()->params->base_path;?>',
			linkName = $j(this).attr("lang"),
			id="#"+linkName,
			value = $j(id).val(),
			name = $j(id).attr("name"),
			imgName = $j(this).attr("lang"),
			title = $j(this).attr("title"),
			boxId = $j(this).parent().parent().attr("id"),
			fToken = $j('#fToken').val(),
			post_data = "link_value="+value+"&link_name="+name+"&fToken="+fToken,
			post_url = base_path+'user/updateLink';
				
			
		$j.ajax(
		{			
			type: 'POST',
			url: post_url,
			data: post_data+"&"+csrfToken,
			cache: false,
			success: function(data)
			{
				if(data=='success')
				{
					if(value=='')
					{
						$j("#"+name).html(title);
						$j(id+'HomeLink').html('');
					}
					else
					{
						$j("#"+linkName+'HomeLink').html('<img src="<?php echo Yii::app()->params->base_url; ?>images/'+imgName+'-icon.png" />');
						$j("#"+linkName+'HomeLink').attr('href', value);
						$j("#"+name).html(value);
					}
					$j('#'+boxId).hide();
					
				}
				else if(trim(data) == "error")
				{
					$j('#update-message').removeClass().addClass('error-msg');
					$j('#update-message').html(msg['_VALIDATE_ID_']+' '+name);
					
					var scrpos=$j("update-message").scrollTop();
					smoothScroll('update-message');
					
					$j('#update-message').fadeIn();
					setTimeout(function() 
					{
						$j('#update-message').fadeOut();
					}, 10000 );
				}
				else if(trim(data) == 'Invalid_token')
				{
					$j('#update-message').removeClass().addClass('error-msg');
					$j('#update-message').html(msg['INVALID_TOKEN']);
					
					var scrpos=$j("update-message").scrollTop();
					smoothScroll('update-message');
					
					$j('#update-message').fadeIn();
					setTimeout(function() 
					{
						$j('#update-message').fadeOut();
					}, 10000 );
				}
				else
				{
					//window.location.href = base_path+"user";
				}
			}
		});
		
	});
});

function addphone()
{
	var smsOk=0;
	if(document.getElementById('smsOk').checked)
	{
		smsOk=1;	
	}
	phone=document.getElementById('phone').value;
	
	if(phone=='' || phone=="Phone Number"){
		$j('#errorAddPhone').addClass('false');
		$j('#errorAddPhone').html(msg['ONLY_PHONE_VALIDATE']);
		return false;
	}
	
	$j.ajax({  
		type: "POST",  
		url: '<?php echo Yii::app()->params->base_path; ?>pos/addUniquePhone' ,  
		data: "userphoneNumber="+phone+"&smsOk="+smsOk+"&"+csrfToken,  
		success: function(response) 
		{
			 if(response=="success")
			 {
				/* $j('#leftphonelist').load(base_path+'user/UserPhoneList',function(){
			 });*/
			 $j('#leftview').load('<?php echo Yii::app()->params->base_path;?>user/leftview',function(){
			 });
				
			    $j('#mainContainer').load(base_path+'user/aboutme',function(){
			 });
			 	$j("#add_phone_box").hide();
				$j("#headerLinkAboutme").trigger('click');	 
			 }
			 else
			 {
				 $j('#errorAddPhone').removeClass().addClass('false');
				 $j("#errorAddPhone").html(response);
			 }
		}
	})
}

function validatePhone()
{
	$j('#errorAddPhone').removeClass();
	$j('#errorAddPhone').html('');
	var VAL1=document.getElementById('phone').value;
	if(VAL1=='' || VAL1=="Phone Number")
	{
		$j('#errorAddPhone').addClass('false');
		$j('#errorAddPhone').html(msg['ONLY_PHONE_VALIDATE']);
		$j('#phn').html('false');
		
		if($j('#eml').html()=='true')
		{
			$j('#errorAddPhone').removeClass();
			$j('#errorAddPhone').html('');
		}
		return false;	
	}
	
	if(!isPhoneNumber(VAL1))
	{	
		$j('#phn').html('false');
		$j('#errorAddPhone').addClass('false');
		$j('#errorAddPhone').html(VAL1+' '+msg['VPHONE_VALIDATE']);
		$j('#verify_now').fadeOut();
		return false;		
	}

	$j('#errorAddPhone').html('<img src="<?php echo Yii::app()->params->base_url; ?>images/spinner-small.gif" alt="Loading">');
	$j.ajax({  
	type: "POST",  
	url: '<?php echo Yii::app()->params->base_path; ?>pos/chkphone' ,  
	data: "phoneNumber="+VAL1+"&"+csrfToken,  
	success: function(response) 
	{ 
		if(response==false)
		{
			$j('#errorAddPhone').removeClass();
			$j('#errorAddPhone').addClass('true');
			$j('#errorAddPhone').html(msg['APHONE_VALIDATE']);
			$j('#phn').html('true');
			return true;
		}
		else
		{
			if(response==2)
			{
				$j('#errorAddPhone').addClass('false');
				$j('#errorAddPhone').html(msg['_DUPLICATE_ENTRY_VALIDATE_']);
				$j('#phn').html('false');
			}
			else
			{
				$j('#errorAddPhone').addClass('false');
				$j('#errorAddPhone').html(msg['NAPHONE_VALIDATE']);
				$j('#phn').html('false');
			}
			return false;
		}
	}
	})		
}

// returns true if the string is a US phone number formatted as...
// (000)000-0000, (000) 000-0000, 000-000-0000, 000.000.0000, 000 000 0000, 0000000000
function isPhoneNumber(str){
	var re = msg['PHONE_REG'];
	return re.test(str);
}

$j(".delete_phone").click( function() {		
	deletedId=$j(this).attr('lang');
	jConfirm('##_ABOUTME_PHONE_MESSAGE_##', '##_ABOUTME_PHONE_CONFIRMATION_DIALOG_##', function(response) {
		if(response==true)
		{
			deletePhone(deletedId);
		}
	});
});

function deletePhone(id)
{
	$j('#update-message').html('<img src="<?php echo Yii::app()->params->base_url; ?>images/spinner-small.gif" alt="Loading">');
	
	$j.ajax({
		url:base_path+'pos/deletePhone/id/'+id,
		type: "POST",
		cache: false,
		data: csrfToken,
		success: function(data){

			data=trim(data);
			if(trim(data)=='success')
			{
				 $j('#leftview').load('<?php echo Yii::app()->params->base_path;?>pos/leftview',function(){
			 });
			  $j('#mainContainer').load(base_path+'pos/aboutme',function(){
			 });
			  $j("#headerLinkAboutme").trigger('click');	 
			}
			else if(data=='logout')
			{		
				window.location='<?php echo Yii::app()->params->base_path; ?>';
				return false;
			}
			else
			{
				$j("#update-message").removeClass().addClass('error-msg');
				$j("#update-message").html(data);
				$j("#update-message").fadeIn();
			}

			$j('#update-message').fadeOut();
		}
	});
}
$j(".verify_now_phone").click(function()
{		
	
	tempPhoneNo = $j(this).attr('title');	
	
	$j.ajax(
	{				
		type: 'POST',
		url: base_path+'pos/getVerifyCode',
		data: "phone="+$j(this).attr("lang")+"&"+csrfToken,
		cache: false,
		success: function(data)
		{
			$j('#vfcationCodePhone' +tempPhoneNo).html(data);			
			$j('#vfcationCodePhone1' +tempPhoneNo).html(data);				
		}
	});
});

function phoneBoxOpen(id)
{
	$j('#'+id).show();
}

function phoneBoxClose(id,fieldId)
{
	$j('#'+id).hide();
	$j('#errorAddPhone').html('');
	$j('#errorAddPhone').removeClass();
}

function trim(stringToTrim) {
	return stringToTrim.replace(/^\s+|\s+$/g,"");
}
function ltrim(stringToTrim) {
	return stringToTrim.replace(/^\s+/,"");
}
function rtrim(stringToTrim) {
	return stringToTrim.replace(/\s+$/,"");
}
</script>

<div class="mainContainer">
<div class="" id="mainContainer">
<div class="RightSide">
<div class="heading" style="margin-top:2px;" >Home</div>

<div style="clear:both;"></div>
<div style="width:620px;">
	<?php if(Yii::app()->user->hasFlash('success')): ?>
        <div id="msgbox" class="error-msg-area">								   
           <div id="update-message" class="clearmsg"> <?php echo Yii::app()->user->getFlash('success'); ?></div>
        </div>
    <?php endif; ?>
    <?php if(Yii::app()->user->hasFlash('error')): ?>
        <div id="msgbox" class="error-msg-area">
            <div id="update-message1"  class="clearmsg"><?php echo Yii::app()->user->getFlash('error'); ?></div>
         </div>
    <?php endif; ?>
        </div> 
        
<div class="productboxgreen-small" style="color:#333333; ">
<h1 style="color:#333333;margin-left:300px;">##_MY_PROFILE_##</h1>
<?php echo CHtml::beginForm(Yii::app()->params->base_path.'pos/editProfile','post',array('id' => 'frm_edit_profile','name' => 'frm_edit_profile','style'=>"padding:0px; margin:0px;")) ?>

    <div>
        <div class="colLeft"  style="margin-left:300px;">
            <div class="field">
                <label>##_MY_PROFILE_FULL_NAME_## <span id="fullnameerror"></span></label>
                <input type="text" name="firstName" maxlength="18" class="textbox width119" id="fName" value="<?php if(isset($data['firstName'])){ echo $data['firstName']; } ?>" onblur="validatefName();" onkeyup="validatefName();"/>
                <input type="text" name="lastName" maxlength="18" class="textbox width119" id="lName" value="<?php if(isset($data['lastName'])){ echo $data['lastName']; } ?>" onblur="validatelName();" onkeyup="validatelName();" />
            </div>
            <div class="field">
                <label>##_MY_PROFILE_EMAIL_## <span id="emailerror"></span></label>
                <div id="eml" style="display:none">true</div>
                <input type="text" name="email" id="email" readonly="readonly" class="textbox readonly width272" value="<?php if(isset($data['loginId'])){ echo $data['loginId']; } ?>" onkeyup="validateEmail()" />
            </div>
            <div class="clear"></div>
            
                 
            <div class="btnfield">
                <input type="button" id="btn_submit" onclick="editAboutMe();" name="btn_submit" value="##_BTN_SUBMIT_##" class="btn" />
                <input type="button"  onclick="javascript:window.location='<?php echo Yii::app()->params->base_path ?>pos/home'"  value="##_BTN_CANCEL_##" class="btn" />
               <span id="edit_profile_error"></span>
            </div>
        </div>
        
        <div class="clear"></div>
    </div>
    
<?php echo CHtml::endForm();?>
</div>
<div class="clear"></div>

</div>
</div>
</div>