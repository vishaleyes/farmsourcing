<link href="<?php echo Yii::app()->params->base_url; ?>css/style_home.css" rel="stylesheet" type="text/css" />
<script src="<?php echo Yii::app()->params->base_path_language; ?>languages/<?php echo Yii::app()->session['prefferd_language']?>/global.js" type="text/javascript"></script>

<script type="text/javascript">
var $j = jQuery.noConflict();
var box3; 
 $j(document).ready(function() {
	 
	
	 $j.ajax({ url:'<?php echo Yii::app()->params->base_path ; ?>user/recentTicket',
         type: 'post',
         success: function(data) {
			 $j(".offer").replaceWith(data);
        }
	});
	
	 $j.ajax({ url:'<?php echo Yii::app()->params->base_path ; ?>user/Onlinecollegues',
         type: 'post',
         success: function(data) {
			 $j(".usercont").replaceWith(data);
        }
	});
});
</script>
<script type="text/javascript">
		
		function loadBoxContent(urlData,boxid)
		{
			var bod= $j(".mainContainer").html();
			
			$j(".mainContainer").html(' <div id="loaderDiv" class="ajax_overlay" style="background-color:#d04117;opacity:0.9;position:absolute;z-index:99999; width:100%; height:100%;"><div align="center"><img src="<?php echo Yii::app()->params->base_url;?>images/ajax-loader.gif"  style="margin-top:250px; vertical-align:middle; "></div></div>').show();
			
			$j.ajax({			
			type: 'POST',
			url: urlData,
			data:'',
			cache: true,
			success: function(data)
			{
				
					
				$j(".mainContainer").html(bod);	
			
				if(data=="logout")
				{
					window.location.href = '<?php echo Yii::app()->params->base_path;?>';
					return false;	
				}
				$j("#"+boxid+"").html(data);
				//$j('#update-message').removeClass().html('').hide();
				
				setTimeout(function() { $j("#update-message").fadeOut();}, 10000 );
				setTimeout(function() { $j("#update-message1").fadeOut();}, 10000 );
			}
			});	
	
			
		}
		
function startTime() {
var today=new Date();
var h=today.getHours();
var m=today.getMinutes();
var s=today.getSeconds();
// add a zero in front of numbers<10
m=checkTime(m);
s=checkTime(s);
$j("#txt").html(h+":"+m+":"+s);
//document.getElementById('txt').innerHTML=h+":"+m+":"+s;
t=setTimeout('startTime()',500);

}
function checkTime(i) {
if (i<10) {
i="0" + i;
}
return i;
}
		

function getProductData()
	{
		
	 var upc_code = $j("#upc_code").val();
	 if(upc_code == null || upc_code == 'undefined' || upc_code == '')
	 {
		jAlert(msg['ENTER_UPC_CODE']);
		//$j("#loading").hide();
		return false;	 
	 }
	 var invoiceId = <?php echo $invoiceId ; ?>;
	 $j.ajax({
	  type: 'POST',
	  url: '<?php echo Yii::app()->params->base_path;?>user/submitTicketbyUPCcode',
	  data: 'upc_code='+upc_code+'&invoiceId='+invoiceId,
	  cache: false,
	  success: function(data)
	  {
	   if(data == 0)
	   {
	   		jAlert(msg['PLEASE_ENTER_CORRECT_UPC_CODE']);
			return false;
	   }
	   if(data == -1)
	   {
	   		jAlert(msg['PRODUCT_ALREADY_ADDED']);
			return false;
	   }
	   //$j(".mainContainer").html(data);
	   $j("#browseBtn").trigger('click');
	   setTimeout(function() { $j("#update-message").fadeOut();},10000 );
	   setTimeout(function() { $j("#update-message1").fadeOut();}, 10000 ); 
	  }
	 });
	
	}
	
function searchProduct()
	{
	 $j.ajax({
	  type: 'POST',
	  url: '<?php echo Yii::app()->params->base_path ; ?>user/SearchProduct',
	  cache: false,
	  success: function(data)
	  {
	   $j(".mainContainer").html(data);
	   $j("#searchBtn").trigger('click'); 
	  }
	 });
	
	}
	
function searchInvoice()
	{
		$j('#loading').html('<div align="center" style="color:white;"><img src="<?php echo Yii::app()->params->base_url ; ?>images/spinner-small.gif" alt="" border="0" />  Loading...</div>').show();
		var invoiceId = $j("#upc_code").val();
		if(invoiceId == null || invoiceId == 'undefined' || invoiceId == '')
		{
		jAlert('Please enter invoice id.');
		$j("#loading").hide();
		return false;	 
		}
		$j.ajax({
		  type: 'POST',
		  url: '<?php echo Yii::app()->params->base_path;?>user/ticketDescriptionForSalesReturn',
		  data:'&invoiceId='+invoiceId,
		  cache: false,
		  success: function(data)
		  {
		   if(data == 0)
		   {
			  jAlert('You entered wrong Invoice Id.');  
			  return false; 
		   }
		   $j(".mainContainer").html(data);
		   setTimeout(function() { $j("#update-message").fadeOut();}, 10000 );
		   setTimeout(function() { $j("#update-message1").fadeOut();}, 10000 );
		  }
		 });
		 $j("#loading").hide();		
	}
	
	function getpurchaseReturnView()
	{
		var id = $j("#upc_code").val();
		if(id == null || id == 'undefined' || id == '')
		 {
			jAlert("Please enter purchase order id.");
			//$j("#loading").hide();
			return false;	 
		 }
		
		$j.ajax({
		  type: 'POST',
		  url: '<?php echo Yii::app()->params->base_path ; ?>user/purchaseReturn',
		  data:'&id='+id,
		  cache: false,
		  success: function(data)
		  {
			if ( data == 0)
			{
				jAlert("Purchase order not found.");
				return false;	
			}
		   $j(".mainContainer").html(data);
		   setTimeout(function() { $j("#update-message").fadeOut();}, 10000 );
		   setTimeout(function() { $j("#update-message1").fadeOut();}, 10000 );
		  }
		 });
	}
	
function purchaseReturn()
{
	$j('#goBtn').css( "display","block");
	$j('#goBtn').attr("onClick","getpurchaseReturnView();");
	$j('#upc_code').removeAttr( "disabled","disabled");
	$j("#firstColumn").text('##_HEADER_PURCHASE_RETURN_##');
	$j('#firstColumn').css( "background-color","red");
	$j('#upc_code').attr( "value","");
}
	
function upcCode()
	{
		$j('#goBtn').css( "display","block");
		$j('#goBtn').attr("onClick","getProductData();");
		$j('#upc_code').removeAttr( "disabled","disabled");
		$j("#firstColumn").text('##_HOME_PAGE_UPC_CODE_##');
		$j('#firstColumn').css( "background-color","red");
		$j('#upc_code').attr( "value","");
	}
	
function calculator()
	{
		$j('#goBtn').css( "display","none");
		$j('#upc_code').attr( "value","");
		$j('#upc_code').removeAttr( "disabled","disabled");
		$j("#firstColumn").text('##_HOME_PAGE_CALCULATOR_##');
		$j('#firstColumn').css( "background-color","red");
	}
	
function enableSearch()
	{
		$j('#goBtn').css( "display","block");
		$j('#goBtn').attr("onClick","searchInvoice();");
		$j('#upc_code').attr( "value","");
		$j('#upc_code').removeAttr( "disabled","disabled");
		$j("#firstColumn").text('##_HOME_PAGE_SALES_RETURN_##');
		$j('#firstColumn').css( "background-color","red");
	}
</script>
<script type="text/javascript">
var n;
function eval1(Calculate)
{
    try{
	n=eval(Calculate.upc_code.value);
    Calculate.upc_code.value=n;
	}
	catch(err)
	{
		Calculate.upc_code.value=" ";
		//alert(err);
		jAlert(err);
		return false;
	}
}

function f1(Calculate)
{
    Calculate.upc_code.value=" ";
}

</script>
<a href="#verifycodePopup" id="verifycode"></a>
<!-- End Mouse Scroll Finction -->
<!-- Middle Part -->
<div>
	<?php if(Yii::app()->user->hasFlash('success')): ?>
        <div class="error-msg-area">								   
           <div id="update-message" class="clearmsg"> <?php echo Yii::app()->user->getFlash('success'); ?></div>
        </div>
    <?php endif; ?>
    <?php if(Yii::app()->user->hasFlash('error')): ?>
        <div class="error-msg-area">
            <div  id="update-message1"  class="clearmsg"><?php echo Yii::app()->user->getFlash('error'); ?></div>
         </div>
    <?php endif; ?>
</div>
<div class="clear"></div>
<body onLoad="startTime();">

<div class="mainContainer" style="margin:0px;">
    <div class="content" id="mainContainer" style="width:100%; padding:0px; margin:0px;">
      <input type="hidden" id="mainPageCheker" value="1" />
       <div class="">	
            <div class="clear"></div>
       <div class="middlediv">
       
      
      <div class="container">
         <div style="float:left;">
          <div class="firstcont">
           <a href="<?php echo Yii::app()->params->base_path ; ?>user" style="color:white; cursor:pointer;"> <div class="heading" style="cursor:pointer;">##_HOME_HOME_##</div></a>
            <div style="margin:5px 0px; width:100%; height:200px; float:left;"><img src="images/img.png" width="100%" height="100%" /></div>
            <div class="about">
              <h2>##_WINE_ACEDEMY_##</h2>
              <div class="cont">##_WINE_ACEDEMY_DESC_##</div>
            </div>
            <div class="offer">
              <h2></h2>
              <span><h2 style="color:#292929;">##_NO_PENDING_TICKET_##</h2></span>
              <div class="itemname"></div>
              <div class="price"></div>
           	</div>
          </div>
          
          <div class="secondcontmain" id="secondcont">
            <div class="heading"><?php //echo Yii::app()->session['fullname']; ?>##_TICKET_LIST_CASHIER_##'s ##_HOME_PAGE_WORKSPACE_##</div>
            <div class="usercont" style="height:192px; cursor:pointer;" onClick="loadBoxContent('<?php echo Yii::app()->params->base_path ; ?>user/collegues','secondcont')"><span><h2>##_HOME_PAGE_NO_COLLEGUES_ONLINE_##</h2></span>
			  <div style="clear:both"></div>
            </div>
            <div class="socialvibe">
              <h2>##_HOME_SALES_SUMMARY_##</h2>
              <br />
              <span> <?php if(isset($salesCount) && $salesCount != ''){ echo $salesCount; } else { echo "0"; } ?> &nbsp;##_BTN_TICKETS_##</span><br />
              <span> <?php if(isset($pendingCount) && $pendingCount != ''){ echo $pendingCount; } else { echo "0"; } ?> &nbsp;##_PENDING_TICKETS_##</span><br />
              <span>  <?php if(isset($returnCount) && $returnCount != ''){ echo $returnCount; } else { echo "0"; } ?> &nbsp;##_BROWSE_PRODUCT_RETURN_TICKETS_##</span><br />
              <br />
              </div>
            <div class="colleuge">
              <h2>##_COLLEAGURS_LOCATOR_##</h2>
            </div>
            <div class="store">
              <h2>##_STORE_COMPITION_##</h2>
              <div class="cont">##_STORE_COMPITION_DESC_##</div>
            </div>
            <div class="newarr">
              <h2>##_NEW_ARRIVALS_##</h2>
              <div class="cont">##_NEW_ARRIVALS_DESC_##</div>
            </div>
            <div class="wine">
              <h2>##_WINE_ACEDEMY_##</h2>
 <div class="cont">##_WINE_ACEDEMY_DESC_##</div>

            </div>
          </div>
          <div class="thiredcont">
            <div class="topbutton">
          <!--  <a href="#" title="Hold Ticket" class="first"><img src="images/file_icon.png" width="30" height="20"  /></a> -->
            <a href="<?php echo Yii::app()->params->base_path;?>user/home" style="font-size:14px; width:60px;">##_HOME_HOME_##</a>
            <a href="#" style="font-size:14px; width:60px;" id="browseBtn" onClick="loadBoxContent('<?php echo Yii::app()->params->base_path ; ?>user/BrowseProduct','mainContainer');">##_BTN_BROWSE_##</a> 
            <a href="#" style="font-size:14px; width:60px;">##_BTN_SCAN_##</a> 
            <a style="font-size:14px; width:61px;" href="<?php echo Yii::app()->params->base_path ; ?>user/logout">##_BTN_LOGOUT_##</a></div>
            <div class="greenbox" id="greenbox">
              <div style="height:120px">##_WELCOME_## <?php echo Yii::app()->session['fullname']; ?> (##_TICKET_LIST_CASHIER_##)</div>
              <div style="font-size:25px" id="txt"></div>
              <div><?php echo date("d-m-Y");?></div>
            </div>
            <div class="calc">
            <form name="Calculate">
              <table width="100%" border="0" cellpadding="0" cellspacing="1" style="font-size:12px; height:435px !important; ">
                <tr>
                  <td id="firstColumn">&nbsp;</td>
                  <td colspan="3" align="center"><input style="width:200px; height:43px; font-size:18px;"  value="<?php if(isset($_POST['upc_code'])) { echo $_POST['upc_code']; }?>" type="text" id="upc_code" name="upc_code" disabled/></td>
                  <td colspan="2" align="center"><input style=" width:110px; height:43px; display:none;" id="goBtn" value="GO" type="button" class="btn" /></td>
                </tr>
                <tr>
                  <td width="25%" onClick="enableSearch();"><b style="color:#333333;">##_BTN_SALES_RETURN_##</b></td>
                   <td width="15%" class="dark" name="DIV" OnClick="Calculate.upc_code.value += '/'"><b style="color:#333333;">/</b><input type="hidden" name="DIV" value="/"/></td>
                   <td width="15%" class="dark" name="minus" OnClick="Calculate.upc_code.value += '*'"><b style="color:#333333;">*</b><input type="hidden" name="minus" value="X"/></td>
                 <td width="15%" class="dark" name="point" OnClick="Calculate.upc_code.value += '%'"><b style="color:#333333;">%</b><input type="hidden" name="point" value="%"/></td>
                 <td width="15%" class="dark" name="times" OnClick="Calculate.upc_code.value += '-'"><b style="color:#333333;">-</b><input type="hidden" name="times" value="-"/></td>
                 <td width="15%" class="dark" name="plus" OnClick="Calculate.upc_code.value += '+'"><b style="color:#333333;">+</b><input type="hidden" name="plus" value="+"/></td>
                </tr>
                <tr>
                  <td class="last" onClick="upcCode();"><b style="color:#333333;">##_BTN_UPC_CODE_##</b></td>
                  <td name="seven" OnClick="Calculate.upc_code.value += '7'"><b style="color:#333333;">7</b><input type="hidden" name="seven" value="7"/></td>
                  <td name="eight" OnClick="Calculate.upc_code.value += '8'"><b style="color:#333333;">8</b><input type="hidden" name="seven" value="8"/></td>
                  <td name="nine" OnClick="Calculate.upc_code.value += '9'"><b style="color:#333333;">9</b><input type="hidden" name="seven" value="9"/></td>
                  <td colspan="2" class="dark">&nbsp;</td>
                </tr> 
                <tr>
                  <td onClick="calculator();"><b style="color:#333333;">##_BTN_CALCULATOR_##</b></td>
                  <td name="four" OnClick="Calculate.upc_code.value += '4'"><b style="color:#333333;">4</b><input type="hidden" name="seven" value="4"/></td>
                  <td name="five" OnClick="Calculate.upc_code.value += '5'"><b style="color:#333333;">5</b><input type="hidden" name="seven" value="5"/></td>
                  <td name="six" OnClick="Calculate.upc_code.value += '6'"><b style="color:#333333;">6</b><input type="hidden" name="seven" value="6"/></td>
                  <td colspan="2" class="dark">&nbsp;</td>
                </tr>
                <tr>
                  <td onClick="loadBoxContent('<?php echo Yii::app()->params->base_path ; ?>user/ticketList','secondcont')"><b style="color:#333333;">##_BTN_TICKETS_##</b></td>
                  <td name="one" OnClick="Calculate.upc_code.value += '1'"><b style="color:#333333;">1</b><input type="hidden" name="seven" value="1"/></td>
                  <td name="two" OnClick="Calculate.upc_code.value += '2'"><b style="color:#333333;">2</b><input type="hidden" name="seven" value="2"/></td>
                  <td name="three" OnClick="Calculate.upc_code.value += '3'"><b style="color:#333333;">3</b><input type="hidden" name="seven" value="3"/></td>
                  <td colspan="2" class="dark">&nbsp;</td>
                </tr>
                <tr>
                  <td onClick="loadBoxContent('<?php echo Yii::app()->params->base_path ; ?>user/Messages','secondcont')"><b style="color:#333333;">##_BTN_MESSAGES_##(<?php echo $messageCount ; ?>)</b></td>
                   	<td OnClick="Calculate.upc_code.value += '.'"><b style="color:#333333;">.</b><input type="hidden" value="."/></td>
                  	<td name="zero" OnClick="Calculate.upc_code.value += '0'"><b style="color:#333333;">0</b><input type="hidden" name="zero" value="0"/></td>
                  	<td><input type="button" class="" style="width:100% ; height:100%;background-color:#CCCCCC; border:none; cursor:pointer;" OnClick="f1(this.form)" name="point" value="C"/></td>
                  	<td colspan="2" class="dark" align="center"><input class="" id="DIV" style="width:100% ; height:100%; background-color:#666666; border:none; cursor:pointer;" type="button" name="DIV" value="##_BTN_ENTER_##" OnClick="eval1(this.form)"/></td>
                </tr>
                <tr>
                  <td onClick="loadBoxContent('<?php echo Yii::app()->params->base_path ; ?>user/vault','secondcont')"><b style="color:#333333;">##_BTN_VAULT_##</b></td>
                  <td name="bracket" OnClick="Calculate.upc_code.value += '('" ><b style="color:#333333;">(</b><input type="hidden" name="bracket" value="("/></td>
                  <td name="zero" value=")"  OnClick="Calculate.upc_code.value += ')'"><b style="color:#333333;">)</b><input type="hidden" name="zero" value=")" /></td>
                  <td  onClick="loadBoxContent('<?php echo Yii::app()->params->base_path ; ?>user/customers','secondcont')"><b style="color:#333333;">##_BROWSE_PRODUCT_CUSTOMER_##</b></td>
                  <td  onClick="loadBoxContent('<?php echo Yii::app()->params->base_path ; ?>user/suppliers','secondcont')"><b style="color:#333333;">##_ADMIN_SUPPLIERS_##</b></td>
                  <td  onClick="loadBoxContent('<?php echo Yii::app()->params->base_path ; ?>user/generalEntryOtherList','secondcont')"><b style="color:#333333;">##_OTHER_##</b></td>
                </tr>
                <tr>
                  <td id="aboutmeTd" onClick="loadBoxContent('<?php echo Yii::app()->params->base_path ; ?>user/aboutme','secondcont')"><b style="color:#333333;">##_BROWSE_PRODUCT_ABOUT_ME_##</b></td>
                  <td colspan="2" onClick="loadBoxContent('<?php echo Yii::app()->params->base_path ; ?>user/changePassword','secondcont')"><b style="color:#333333;">##_BROWSE_PRODUCT_CHANGE_PASSWORD_##</b></td>
                  <td onClick="loadBoxContent('<?php echo Yii::app()->params->base_path ; ?>user/productList','secondcont')"><b style="color:#333333;">##_BROWSE_PRODUCT_PRODUCTS_##</b></td>
                  <td colspan="2" onClick="loadBoxContent('<?php echo Yii::app()->params->base_path ; ?>user/returnTicketList','secondcont')"><b style="color:#333333;">##_BROWSE_PRODUCT_RETURN_TICKETS_##</b></td>
                </tr>
                <tr>
                  <?php /*?><td id=""  onClick="loadBoxContent('<?php echo Yii::app()->params->base_path ; ?>user/insertpurchase','mainContainer')"><b style="color:#333333;">##_HEADER_PURCHASE_##</b></td>
                  <td colspan="2" onClick="purchaseReturn();"><b style="color:#333333;">##_HEADER_PURCHASE_RETURN_##</b></td><?php */?>
                  <td  onClick="loadBoxContent('<?php echo Yii::app()->params->base_path ; ?>user/generalEntry','secondcont')"><b style="color:#333333;">##_ADMIN_GENERAL_ENTRY_##</b></td>
                  <td colspan="2" id="ticketDeliveryTab" onClick="loadBoxContent('<?php echo Yii::app()->params->base_path ; ?>user/ticketDeliveryStatus','secondcont')"><b style="color:#333333;">##_TICKETS_DELIVER_##</b></td>
                  <td>&nbsp;</td>
                  <td colspan="2">&nbsp;</td>
                </tr>
              </table>
            </form>
            </div>
          </div>
        </div>
        <div class="clear"></div>
      </div>
    </div>
        </div>
       <div class="clear"></div>	
    </div>
    
    <div class="clear"></div>
    
</div>
<div class="clear"></div>
</body>

	
