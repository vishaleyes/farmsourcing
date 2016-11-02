var $j = jQuery.noConflict();
function validateAll()
{
	var flag=0;
	if(!validateName())
	{
		return false;
	}
	
	if(!validateEmail())
	{
		return false;
	}
	
	if(!validateComment())
	{
		return false;
	}
	
	return true;
}
function validateName()
{
	$j('#nameerror').removeClass();
	$j('#nameerror').html('');
	var businessName=document.getElementById('name').value;
	
	if(businessName=='')
	{
		$j('#nameerror').addClass('false');
		$j('#nameerror').html("<span style='color:red'>Please enter your name.</span>");
		return false;
	} else if(businessName.length > 25)
	{
		$j('#nameerror').addClass('false');
		$j('#nameerror').html("<span style='color:red'>Max name length is 25 characters.</span>");
		return false;
	} else
	{
		$j('#nameerror').removeClass();
		$j('#nameerror').addClass('true');
		$j('#nameerror').html("");
		return true;
	}
}
function validateEmail()
{
	$j('#emailerror').removeClass();
	$j('#emailerror').html('');
	var VAL1=document.getElementById('email').value;
	if(VAL1=='')
	{
		$j('#emailerror').addClass('false');
		$j('#emailerror').html("<span style='color:red'>Please enter email.</span>");
		return false;	
	}
	var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
	if (reg.test(VAL1)) 
	{
		$j('#emailerror').removeClass();
		$j('#emailerror').addClass('true');
		$j('#emailerror').html("");
		return true;
	}	
	else
	{
		$j('#emailerror').addClass('false');
		$j('#emailerror').html("<span style='color:red'>Please enter valid email.</span>");
		return false;
	}
}
function validateComment()
{
	$j('#commenterror').removeClass();
	$j('#commenterror').html('');
	var comment=document.getElementById('comment').value;
	
	if(comment=='')
	{
		$j('#commenterror').addClass('false');
		$j('#commenterror').html("<span style='color:red'>Please enter comment.</span>");
		return false;
	}
	else if(comment.length<20)
	{
		$j('#commenterror').addClass('false');
		$j('#commenterror').html("<span style='color:red'>Comment contain at least 20 character.</span>");
		return false;
	}
	else
	{
		$j('#commenterror').removeClass();
		$j('#commenterror').addClass('true');
		$j('#commenterror').html('');
		return true;
	}
}

