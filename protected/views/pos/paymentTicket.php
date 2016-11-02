<script>
var $j = jQuery.noConflict();	
function card()
{
	$j('#upc_codeP').val($j('#totalRemaining').text());
	$j('#goBtnP').removeAttr( "disabled","disabled");
	$j('#goBtnP').attr("onClick","addCard();");
	$j('#upc_codeP').removeAttr( "disabled","disabled");
	$j("#firstColumnP").text('CARD');
	$j('#firstColumnP').css( "background-color","red");
	//$j('#upc_codeP').attr( "value","0");
	
}

function credite()
{
	$j('#upc_codeP').val($j('#totalRemaining').text());
	$j('#goBtnP').removeAttr( "disabled","disabled");
	$j('#goBtnP').attr("onClick","addCredite();");
	$j('#upc_codeP').removeAttr( "disabled","disabled");
	$j("#firstColumnP").text('CREDIT');
	$j('#firstColumnP').css( "background-color","red");
	//$j('#upc_codeP').attr( "value","0");
}

function bank()
{
	$j('#upc_codeP').val($j('#totalRemaining').text());
	$j('#goBtnP').removeAttr( "disabled","disabled");
	$j('#goBtnP').attr("onClick","addBank();");
	$j('#upc_codeP').removeAttr( "disabled","disabled");
	$j("#firstColumnP").text('CHEQUE');
	$j('#firstColumnP').css( "background-color","red");
	//$j('#upc_codeP').attr( "value","0");
}

function cash()
{
	$j('#upc_codeP').val($j('#totalRemaining').text());
	$j('#goBtnP').removeAttr( "disabled","disabled");
	$j('#goBtnP').attr("onClick","addCash();");
	$j('#upc_codeP').removeAttr( "disabled","disabled");
	$j("#firstColumnP").text('CASH');
	$j('#firstColumnP').css( "background-color","red");
	//$j('#upc_codeP').attr( "value","");
}

function addCash()
{
	var remainingPayment = $("#totalRemaining").text();
	if(remainingPayment == 0 || remainingPayment < 0)
	{
		return false;	
	}
	var cash = null;
	cash = $j("#upc_codeP").val();
	var oldCash = $("#cashAmount").val();
	
	var rem = $j("#totalRemaining").text();
	if(Number(cash) > Number(rem) || Number(cash) < 0)
	{
		jAlert("Please check the amount.","Payment amount problem");
		return false;
	}
	$("#paymentsummary").append("<tr style='font-weight:bold;'><td>&nbsp;Cash : </td><td align='right'>&nbsp;&nbsp; " + cash + "</td><td align='right'>&nbsp;</td></tr>");
	$("#cashAmount").val(Number(oldCash) + Number(cash));
	var totalRemaining = $j("#totalPayableAmount").val();
	var cashAmount = $j("#cashAmount").val();
	var cardAmount = $j("#cardAmount").val();
	var bankAmount = $j("#bankAmount").val();
	var crediteAmount = $j("#crediteAmount").val();
	
	var actualRemaining = (Number(totalRemaining - Number(Number(cashAmount) + Number(cardAmount) + Number(bankAmount) + Number(crediteAmount))));
	$j("#totalRemaining").text(actualRemaining);
	
	
	$j('#goBtnP').removeAttr( "disabled","disabled");
	$j('#goBtnP').attr("onClick","addCash();");
	$j('#upc_codeP').removeAttr( "disabled","disabled");
	$j("#firstColumnP").text('CASH');
	$j('#firstColumnP').css( "background-color","red");
	$j('#upc_codeP').attr( "value",actualRemaining);
}


function credit()
{
	$j('#upc_codeP').val($j('#totalRemaining').text());
	$j('#goBtnP').removeAttr( "disabled","disabled");
	$j('#goBtnP').attr("onClick","addCredit();");
	$j('#upc_codeP').removeAttr( "disabled","disabled");
	$j("#firstColumnP").text('CREDIT');
	$j('#firstColumnP').css( "background-color","red");
	//$j('#upc_codeP').attr( "value","");
}

function addCard()
{
	var remainingPayment = $("#totalRemaining").text();
	if(remainingPayment == 0 || remainingPayment < 0)
	{
		return false;	
	}
	var card = $("#upc_codeP").val();
	var rem = $("#totalRemaining").text();
	var oldCard = $("#cardAmount").val();
	if(Number(card) > Number(rem))
	{
		jAlert("Please check the amount.");
		return false;
	}
	$("#paymentsummary").append("<tr style='font-weight:bold;'><td>&nbsp;Card : </td><td align='right'>&nbsp;&nbsp; " + card + "</td><td widht='20%'>&nbsp;</td></tr>");
	$("#cardAmount").val(Number(card) + Number(oldCard));
	var totalRemaining = $j("#totalPayableAmount").val();
	var cashAmount = $("#cashAmount").val();
	var cardAmount = $("#cardAmount").val();
	var bankAmount = $("#bankAmount").val();
	var crediteAmount = $("#crediteAmount").val();
	
	var actualRemaining = (Number(totalRemaining - Number(Number(cashAmount) + Number(cardAmount) + Number(bankAmount) + Number(crediteAmount))));
	$("#totalRemaining").text(actualRemaining);
	
	$j('#goBtnP').removeAttr( "disabled","disabled");
	$j('#goBtnP').attr("onClick","addCard();");
	$j('#upc_codeP').removeAttr( "disabled","disabled");
	$j("#firstColumnP").text('CARD');
	$j('#firstColumnP').css( "background-color","red");
	$j('#upc_codeP').attr( "value",actualRemaining);
	
}


function addCredite()
{
	var remainingPayment = $("#totalRemaining").text();
	if(remainingPayment == 0 || remainingPayment < 0)
	{
		return false;	
	}
	var customer = '<?php echo $data['customer_id'] ?>' ;
	if(customer == "" || customer == null || customer == "undefined")
	{
		jAlert('Please select customer');
		return false;	
	}
	var credite = $("#upc_codeP").val();
	var rem = $("#totalRemaining").text();
	var oldcredite = $("#crediteAmount").val();
	if(Number(credite) > Number(rem))
	{
		jAlert("Please check the amount.");
		return false;
	}
	$("#paymentsummary").append("<tr style='font-weight:bold;'><td>&nbsp;Credit :</td><td align='right'>&nbsp;&nbsp;" + credite + "</td><td>&nbsp;</td></tr>");
	$("#crediteAmount").val(Number(credite) + Number(oldcredite));
	var totalRemaining = $j("#totalPayableAmount").val();
	var cashAmount = $("#cashAmount").val();
	var cardAmount = $("#cardAmount").val();
	var bankAmount = $("#bankAmount").val();
	var crediteAmount = $("#crediteAmount").val();
	
	var actualRemaining = (Number(totalRemaining - Number(Number(cashAmount) + Number(cardAmount) + Number(bankAmount) + Number(crediteAmount))));
	$("#totalRemaining").text(actualRemaining);
	$("#paybtn").hide();
	$("#tblcredit").css('display','block');
	
	$j('#goBtnP').removeAttr( "disabled","disabled");
	$j('#goBtnP').attr("onClick","addCredite();");
	$j('#upc_codeP').removeAttr( "disabled","disabled");
	$j("#firstColumnP").text('CREDIT');
	$j('#firstColumnP').css( "background-color","red");
	$j('#upc_codeP').attr( "value",actualRemaining);
	
}


function activeCredit()
{
	var remainingPayment =$("#totalRemaining").text();
		if(remainingPayment == 0 || remainingPayment < 0)
		{
			jAlert('Remaining amount is zero.');
			return false;	
		}
		$j('#goBtnP').removeAttr( "disabled","disabled");
		$j('#goBtnP').attr("onClick","addCredit();");
		$j('#upc_codeP').attr( "value","");
		$j('#upc_codeP').removeAttr( "disabled","disabled");
		$j("#firstColumnP").replaceWith('<td id="firstColumnP">CREDIT</td>');
		$j('#firstColumnP').css( "background-color","red");
		
		//$j('#upc_codeP').val($j('#totalRemaining').text());
	
}

function addCredit()
{
	var remainingPayment = $("#totalRemaining").text();
	
	if(remainingPayment == 0 || remainingPayment < 0)
	{
		return false;	
	}
	var customer = '<?php echo $_SESSION['fnp_browse_customer_id'] ?>' ;
	if(customer == "" || customer == null || customer == "undefined")
	{
		jAlert('Please select customer');
		return false;	
	}
	var credit = $("#upc_codeP").val();
	var rem = $("#totalRemaining").text();
	var oldcredit = $("#credit_amount").val();
	
	//alert(Number(credit));
	//alert(Number(rem));
	
	if(Number(credit) > Number(rem))
	{
		jAlert("Please check the amount.");
		return false;
	}
	
	var totalRemaining = $j("#totalPayableAmount").val();
		
		
		$j.ajax({
		  type: 'POST',
		  url: '<?php echo Yii::app()->params->base_path;?>pos/addCreditToOrder',
		  data: '&upc_code='+credit,
		  cache: false,
		  success: function(data)
		  {
			  $("#credit_amount").val(Number(credit) + Number(oldcredit));
	var totalRemaining = $j("#totalPayableAmount").val();
	var cashAmount = $("#cashAmount").val();
	var cardAmount = $("#cardAmount").val();
	var bankAmount = $("#bankAmount").val();
	var credit_amount = $("#credit_amount").val();
	
		var actualRemaining = (Number(totalRemaining - Number(Number(cashAmount) + Number(cardAmount) + Number(bankAmount) + Number(credit_amount))));
		
	$("#totalRemaining").text(actualRemaining);
	//$("#paybtn").hide();
	//$("#tblcredit").css('display','block');
	
	$j('#goBtnP').removeAttr( "disabled","disabled");
	$j('#goBtnP').attr("onClick","addCredit();");
	$j('#upc_codeP').removeAttr( "disabled","disabled");
	$j("#firstColumnP").text('CREDIT');
	$j('#firstColumnP').css( "background-color","red");
	$j('#upc_codeP').attr( "value",actualRemaining);	  
			  
			  
		$("#paymentsummary").append("<tr style='font-weight:bold;'><td>&nbsp;Credit :</td><td align='right'>&nbsp;&nbsp;" + credit + "</td><td>&nbsp;</td></tr>");
	$("#credit_amount").val(Number(credit) + Number(oldcredit));	  
		  
			  
			$j("#totalPayableAmount").val(Number(actualRemaining).toFixed(0)); 
			$j("#totalAmount").val(Number(actualRemaining).toFixed(0));
			$j('#creditBtn').removeAttr( "onClick","addCredit();");
			$j("#cashBtn").trigger('click');
			
		  }
		 });
		 
	
}


function addBank()
{
	var remainingPayment =$("#totalRemaining").text();
	if(remainingPayment == 0 || remainingPayment < 0)
	{
		return false;	
	}
	var bank = $("#upc_codeP").val();
	var oldBank = $("#bankAmount").val();
	var rem = $("#totalRemaining").text();
	
	if(Number(bank) > Number(rem))
	{
		jAlert("Please check the amount.");
		return false;
	}
	$("#paymentsummary").append("<tr style='font-weight:bold;'><td>&nbsp;&nbsp;Bank : </td><td align='right'>&nbsp;&nbsp; " + bank + "</td><td>&nbsp;</td></tr>");
	$("#bankAmount").val(Number(bank) + Number(oldBank));
	var totalRemaining = $j("#totalPayableAmount").val();
	var cashAmount = $("#cashAmount").val();
	var cardAmount = $("#cardAmount").val();
	var bankAmount = $("#bankAmount").val();
	var crediteAmount = $("#crediteAmount").val();
	
	var actualRemaining = (Number(totalRemaining - Number(Number(cashAmount) + Number(cardAmount) + Number(bankAmount) + Number(crediteAmount))));
	$("#totalRemaining").text(actualRemaining);
	
	$j('#goBtnP').removeAttr( "disabled","disabled");
	$j('#goBtnP').attr("onClick","addBank();");
	$j('#upc_codeP').removeAttr( "disabled","disabled");
	$j("#firstColumnP").text('CHEQUE');
	$j('#firstColumnP').css( "background-color","red");
	$j('#upc_codeP').attr( "value",actualRemaining);
	
}

function submitTicketData() {
	$j('#loading').html('<div align="center" style="color:white;"><img src="<?php echo Yii::app()->params->base_url ; ?>images/spinner-small.gif" alt="" border="0" />  Loading...</div>').show();
	var rem = $("#totalRemaining").text();
	
	//alert(rem);
	
	if(rem==0)
	{
		var cashAmount =  $("#cashAmount").val();
		var discount = $("#discount").val();
		var totalAmount = $j("#totalAmount").val();
		
		 $j.ajax({
		  type: 'POST',
		  url: '<?php echo Yii::app()->params->base_path;?>pos/submitOrder',
		  data: 'cashAmount='+cashAmount+'&discount='+discount+'&totalAmount='+totalAmount,
		  cache: false,
		  success: function(data)
		  {
		   window.location.href="<?php echo Yii::app()->params->base_path;?>pos/raiseDeliverySlip/id/"+data;
		   $j("#loading").hide();
		   $j(".content").html(data);
		   setTimeout(function() { $j("#update-message").fadeOut();}, 10000 );
	  	   setTimeout(function() { $j("#update-message1").fadeOut();}, 10000 ); 
		  }
		 });
	}else
	{
		jAlert("Please check the amount.");
		$j("#loading").hide();
		return false;	
	}
}

function grantCredit()
{
	$j('#loading').html('<div align="center" style="color:white;"><img src="<?php echo Yii::app()->params->base_url ; ?>images/spinner-small.gif" alt="" border="0" /> Loading...</div>').show();
	var grantCode = $("#grantCode").val();
	
	$j.ajax({
		  type: 'POST',
		  url: '<?php echo Yii::app()->params->base_path;?>user/grantCreditTransaction',
		  data: 'grantCode='+grantCode,
		  cache: false,
		  success: function(data)
		  {
			if(data==true)
		    {
				var totalRemaining = $j("#totalPayableAmount").val();
				var cashAmount = $("#cashAmount").val();
				var cardAmount = $("#cardAmount").val();
				var bankAmount = $("#bankAmount").val();
				var crediteAmount = $("#crediteAmount").val();
				
				var actualRemaining = (Number(totalRemaining - Number(Number(cashAmount) + Number(cardAmount) + Number(bankAmount) + Number(crediteAmount))));
				$("#totalRemaining").text(actualRemaining);
				$("#paybtn").show();
				$("#tblcredit").css('display','none');
				$("#loading").css('display','none');
			}
			else
			{
				$("#loading").css('display','none');
				jAlert("Invalid Authentication.");
				return false;
			}
			  
		  }
		 });
		
	
}


function activeDiscount()
	{
		var remainingPayment =$("#totalRemaining").text();
		if(remainingPayment == 0 || remainingPayment < 0)
		{
			jAlert('Remaining amount is zero.');
			return false;	
		}
		$j('#goBtnP').removeAttr( "disabled","disabled");
		$j('#goBtnP').attr("onClick","addDiscount();");
		$j('#upc_codeP').attr( "value","");
		$j('#upc_codeP').removeAttr( "disabled","disabled");
		$j("#firstColumnP").replaceWith('<td id="firstColumnP">DISCOUNT: &nbsp;&nbsp;&nbsp;(%) <input type="radio" value="0" name="disc" />(Rs) <input type="radio" value="1" name="disc" /></td>');
		$j('#firstColumnP').css( "background-color","red");
	}

function addDiscount()
	{
		var discountType = $j("input[@name=disc]:checked").val();
		if(discountType == null || discountType == " " )
		{
			jAlert('Please select discount.');
			return false;	
		}
		var upc_code = $j("#upc_codeP").val();
		var totalPayable = $j("#totalPayableAmount").val();
		var totalRemaining = $j("#totalRemaining").text();
		
		if(discountType == 0)
		{
			total = Number(totalPayable) - ((Number(totalPayable) * Number(upc_code)) / 100 ); 
			var remaining =  Number(totalRemaining) - ((Number(totalPayable) * Number(upc_code)) / 100 ) ;
			upc_code = Number((Number(totalPayable) * Number(upc_code)) / 100).toFixed(0) ;
		}
		
		else
		{
			total = Number(totalPayable) - Number(upc_code) ; 
			var remaining =  Number(totalRemaining) - Number(upc_code) ;
		}
		
		$j.ajax({
		  type: 'POST',
		  url: '<?php echo Yii::app()->params->base_path;?>pos/addDiscountToOrder',
		  data: '&upc_code='+upc_code+'&discountType='+discountType,
		  cache: false,
		  success: function(data)
		  {
			$j("#totalRemaining").text(Number(remaining).toFixed(0));
			$j("#totalPayableAmount").val(Number(total).toFixed(0)); 
			$j("#discount").val(Number(upc_code).toFixed(0));
			$j("#totalAmount").val(Number(total).toFixed(0));
			$j('#discBtn').removeAttr( "onClick","discount();");
			$j("#cashBtn").trigger('click');
			$("#paymentsummary").append("<tr style='font-weight:bold;'><td>&nbsp;Discount : </td><td align='right'>&nbsp;&nbsp; " + upc_code + "</td><td align='right' widht='10%'>&nbsp;</td></tr>");
		  }
		 });
		 
		
	}
</script>
<script type="text/javascript">
var n;
function eval1(CalculateP)
{
    try{
	n=eval(CalculateP.upc_codeP.value);
    CalculateP.upc_codeP.value=n;
	}
	catch(err)
	{
		CalculateP.upc_codeP.value=" ";
		jAlert(err);
		return false;
	}
}

function f1(CalculateP)
{
    CalculateP.upc_codeP.value=" ";
}

function isNumberKey(evt)
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
<style>
.calc1{ width:100%; float:left;text-align:center; color:#222; font-weight:bold; height:350px;}

.calc1 td{background-color:#CCC; padding:5px; height:43px;}
.calc1 td:hover{ cursor:pointer; background-color:#C00;}
.calc1 .dark{ background-color:#666}
</style>

<div class="mainContainer" style="width:303%;">
  <div class="" id="mainContainer" style="margin-left:0px; margin-right:0px;">
     <div class="thiredcont" style="padding:0 !important;">
            <div class="topbutton">
                        <!--<a href="#"  class="first"><img src="images/file_icon.png" width="20" height="20" /></a> -->
                        <a style="font-size:14px; width:112px;" href="<?php echo Yii::app()->params->base_path;?>pos/home">##_HOME_HOME_##</a>
                        <a  style="font-size:14px; width:112px;" href="#" id="browseBtn" onClick="javascript:loadBoxContent('<?php echo Yii::app()->params->base_path ; ?>pos/browse','mainContainer');">##_BTN_BROWSE_##</a> 
                        <a style="font-size:14px; width:112px;" href="#" id="categoryBtn" onClick="loadBoxContent('<?php echo Yii::app()->params->base_path ; ?>pos/categoryListing','browsedata');">##_ADMIN_CATEGORY_##</a> 
                        <a style="font-size:14px; width:117px;" href="<?php echo Yii::app()->params->base_path ; ?>pos/logout">##_BTN_LOGOUT_##</a>
                    </div>
  			<div id="loading"></div>	
  
            <div class="clear"></div>
            <div class="greenbox" id="greenbox" style="background-color:#333;">
              <div style="height:30px; color:#FFF;" align="left"><span id="totalRemaining" style="font-size:18px; font-weight:bold;"><?php echo $_POST['totalPayable'];?></span>&nbsp;&nbsp;<span>Remaining to pay</span><br /><br/></div>
             
              <table id="paymentsummary" width="90%" border="0" cellpadding="0" cellspacing="1" style="font-size:14px; color:#FFF;">
                
              </table>
              
              <table id="tblcredit" style="margin-top:20px; display:none;">
              
       	  <tr>
                	<td style="color:white;">Please Grant Credit</td>
                    <td><input style=" width:110px; height:25px;" id="grantCode"  name="grantCode" type="password"/></td>
                     <td><input style=" width:110px; height:30px;" id="grantBtn" name="grantBtn" value="Grant" onclick="grantCredit();" type="button" class="btn"/></td>
                </tr>
                
              </table>
           	 <div style="height:30px; margin-top:30px; color:#FFF;" align="left" id="paybtn"><input style=" width:110px; height:43px;" id="pay" onClick="submitTicketData(<?php echo $_SESSION['fnp_browse_customer_id'] ; ?>);" value="PAY" type="button" class="btn" /><input style=" width:110px; height:43px;" id="pay"onclick="submitTicket(<?php echo $_POST['invoiceId'] ; ?>);" value="CANCEL" type="button" class="btn" /></div>	<!--$_REQUEST['customer_id']-->
            </div>
            <div class="clear"></div>
            <div class="calc1">
            <form name="CalculateP">
              <table width="100%" border="1" cellpadding="0" cellspacing="1" style="font-size:14px;">
                <tr>
                  <td id="firstColumnP">&nbsp;</td>
                  <td colspan="3" align="center"><input style=" width:200px; height:43px; font-size:18px;"  value="<?php if(isset($_POST['upc_code'])) { echo $_POST['upc_code']; }?>" type="text" id="upc_codeP" name="upc_codeP" onkeypress="return isNumberKey(event);"  disabled/></td>
                  <td colspan="2" align="center"><input style=" width:110px; height:43px;" id="goBtnP" onClick="addprice();" value="GO" type="button" class="btn" disabled/></td>
                </tr>
                <tr>
                  <td width="25%" onClick="cash();" id="cashBtn"><b style="color:#333333;">Cash</b></td>
                  <td width="15%" class="dark" name="DIV" OnClick="CalculateP.upc_codeP.value += '/'"><b style="color:#333333;">/</b><input type="hidden" name="DIV" value="/"/></td>
                   <td width="15%" class="dark" name="minus" OnClick="CalculateP.upc_codeP.value += '*'"><b style="color:#333333;">*</b><input type="hidden" name="minus" value="X"/></td>
                 <td width="15%" class="dark" name="point" OnClick="CalculateP.upc_codeP.value += '%'"><b style="color:#333333;">%</b><input type="hidden" name="point" value="%"/></td>
                 <td width="15%" class="dark" name="times" OnClick="CalculateP.upc_codeP.value += '-'"><b style="color:#333333;">-</b><input type="hidden" name="times" value="-"/></td>
                 <td width="15%" class="dark" name="plus" OnClick="CalculateP.upc_codeP.value += '+'"><b style="color:#333333;">+</b><input type="hidden" name="plus" value="+"/></td>
                </tr>
                <tr>
                  <td onClick="activeDiscount();" id="discBtn"><b style="color:#333333;">Discount</b></td>
                  <td name="seven" OnClick="CalculateP.upc_codeP.value += '7'"><b style="color:#333333;">7</b><input type="hidden" name="seven" value="7"/></td>
                  <td name="eight" OnClick="CalculateP.upc_codeP.value += '8'"><b style="color:#333333;">8</b><input type="hidden" name="seven" value="8"/></td>
                  <td name="nine" OnClick="CalculateP.upc_codeP.value += '9'"><b style="color:#333333;">9</b><input type="hidden" name="seven" value="9"/></td>
                  <td colspan="2" class="dark">&nbsp;</td>
                </tr>
                <tr>
<!--                  <td><b style="color:#333333;">&nbsp;</b></td>
-->                    <td onClick="activeCredit();" id="creditBtn"><b style="color:#333333;">Credit</b></td>
                  <td name="four" OnClick="CalculateP.upc_codeP.value += '4'"><b style="color:#333333;">4</b><input type="hidden" name="seven" value="4"/></td>
                  <td name="five" OnClick="CalculateP.upc_codeP.value += '5'"><b style="color:#333333;">5</b><input type="hidden" name="seven" value="5"/></td>
                  <td name="six" OnClick="CalculateP.upc_codeP.value += '6'"><b style="color:#333333;">6</b><input type="hidden" name="seven" value="6"/></td>
                  <td colspan="2" class="dark">&nbsp;</td>
                </tr>
                 <tr>
                   <td><b style="color:#333333;">&nbsp;</b></td>
                  <td name="one" OnClick="CalculateP.upc_codeP.value += '1'"><b style="color:#333333;">1</b><input type="hidden" name="seven" value="1"/></td>
                  <td name="two" OnClick="CalculateP.upc_codeP.value += '2'"><b style="color:#333333;">2</b><input type="hidden" name="seven" value="2"/></td>
                  <td name="three" OnClick="CalculateP.upc_codeP.value += '3'"><b style="color:#333333;">3</b><input type="hidden" name="seven" value="3"/></td>
                  <td colspan="2" class="dark">&nbsp;</td>
                </tr>
               
                <tr>
                  <td><b style="color:#333333;">&nbsp;</b></td>
                  <td OnClick="CalculateP.upc_codeP.value += '.'"><b style="color:#333333;">.</b><input type="hidden" value="."/></td>
                  <td name="zero" OnClick="CalculateP.upc_codeP.value += '0'"><b style="color:#333333;">0</b><input type="hidden" name="zero" value="0"/></td>
                  <td><input type="button" class="" style="width:100% ; height:100%;background-color:#CCCCCC; border:none; cursor:pointer;" OnClick="f1(this.form)" name="point" value="C"/></td>
                  <td colspan="2" class="dark" align="center"><input class="" id="DIV" style="width:100% ; height:100%; background-color:#666666; border:none; cursor:pointer;" type="button" name="DIV" value="Enter" OnClick="eval1(this.form)"/></td>
                </tr>
                <tr>
                  <td id="discBtnMoney"><b style="color:#333333;">&nbsp;</td>
                  <td name="bracket" OnClick="CalculateP.upc_codeP.value += '('" ><b style="color:#333333;">(</b><input type="hidden" name="bracket" value="("/></td>
                  <td name="zero" value=")"  OnClick="CalculateP.upc_codeP.value += ')'"><b style="color:#333333;">)</b><input type="hidden" name="zero" value=")" /></td>
                  <td colspan="2" class="dark" align="center">&nbsp;</td>
                  <td class="dark" align="center">&nbsp;</td>
                </tr>
                 <input type="hidden" name="totalPayableAmount" id="totalPayableAmount" value="<?php echo $_POST['totalPayable'];?>" />
                <input type="hidden" name="cardAmount" id="cardAmount" value="0" />
                <input type="hidden" name="bankAmount" id="bankAmount" value="0" />
                <input type="hidden" name="cashAmount" id="cashAmount" value="0" />
                 <input type="hidden" name="credit_amount" id="credit_amount" value="0" />
                <input type="hidden" name="crediteAmount" id="crediteAmount" value="0" />
                <input type="hidden" name="discount" id="discount" value="0" />
                <input type="hidden" name="totalAmount" id="totalAmount" value="<?php echo $_POST['totalPayable']; ?>" />
               
              </table>
            </form>
            </div>
          </div>
     <div class="clear"></div>
  </div>
</div>
