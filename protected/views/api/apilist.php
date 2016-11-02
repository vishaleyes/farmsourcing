<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Welcome to Fresh n Pack API</title>
<link href="<?php echo Yii::app()->params->base_url; ?>css/apipage.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.3/jquery.min.js"></script>

<script>
$(document).ready(function(){

	// hide #back-top first
	$("#back-top").hide();
	
	// fade in #back-top
	$(function () {
		$(window).scroll(function () {
			if ($(this).scrollTop() > 100) {
				$('#back-top').fadeIn();
			} else {
				$('#back-top').fadeOut();
			}
		});

		// scroll body to 0px on click
		$('#back-top a').click(function () {
			$('body,html').animate({
				scrollTop: 0
			}, 800);
			return false;
		});
	});

});
</script>


</head>
<body>
<div class="maincontainer">
    <div class="hdr">
                <div class="container">
                    <div class="logo">
                        <img src="images/logo/logo_1.png" style="height:137px;margin-top: 35px;width: 135px;" />
                    </div>
                    
                    <div class="links">
                    
                        <h1 >Welcome to FarmSourcing REST API!</h1>	
                        
                        <ul>
                        
                        
                        <li> <a target="_blank"  href="<?php echo Yii::app()->params->base_path; ?>admin">ADMIN PANEL</a></li>
                       <br />
                        <li> <a href="<?php echo Yii::app()->params->base_path; ?>api">Refresh Page</a> </li>
                    </ul>
                </div>
            
        </div>
    </div>
    <div class="container">
      <div class="txt">
    <p>If you are exploring FarmSourcing REST API for the very first time, you should start by reading the Guide. 	</p>
    </div>
    
      <div style="float:right">
        <ul style="list-style:none">
        
        <a target="_blank" href="<?php echo Yii::app()->params->base_path; ?>api/showLogs"><li class="btn">ShowLog</li></a><br /><li>&nbsp;&nbsp;&nbsp;&nbsp;</li>
        
        <a target="_blank" href="<?php echo Yii::app()->params->base_path; ?>api/clearLogs"><li class="btn">ClearLogs</li></a>
        
        </ul>
      </div>
      
    </div>
    <div class="container">
            <div class="apidetail">
                <table width="940">
                  <tr>
                    <td width="70">Name</td>
                    <td width="10">:</td>
                    <td width="846"><a target="_blank" href="<?php echo Yii::app()->params->base_path; ?>api/login&email=sandeep.patel@bypt.in&password=111111">login</a></td>
                  </tr>
                  <tr>
                    <td>Required Params</td>
                    <td>:</td>
                    <td>email , password</td>
                  </tr>
                  <tr>
                    <td>Optional Params</td>
                    <td>:</td>
                    <td>-</td>
                  </tr>
                  <tr>
                    <td>Method</td>
                    <td>:</td>
                    <td>GET and POST</td>
                  </tr>
                  <tr>
                    <td>Fields</td>
                    <td>:</td>
                    <td>email=frpatel7@gmail.com&password=111111</td>
                  </tr>
                  <tr>
                    <td>Notes</td>
                    <td>:</td>
                    <td>-</td>
                  </tr>
                </table>
            </div>
            <br />
            <div class="apidetail">
                <table width="940">
                  <tr>
                    <td width="70">Name</td>
                    <td width="10">:</td>
                    <td width="846"><a target="_blank" href="<?php echo Yii::app()->params->base_path; ?>api/logout&userId=3&sessionId=SdscSEs">logout</a></td>
                  </tr>
                  <tr>
                    <td>Required Params</td>
                    <td>:</td>
                    <td>userId , sessionId</td>
                  </tr>
                  <tr>
                    <td>Optional Params</td>
                    <td>:</td>
                    <td>-</td>
                  </tr>
                  <tr>
                    <td>Method</td>
                    <td>:</td>
                    <td>GET and POST</td>
                  </tr>
                  <tr>
                    <td>Fields</td>
                    <td>:</td>
                    <td>userId=3&sessionId=SdscSEs</td>
                  </tr>
                  <tr>
                    <td>Notes</td>
                    <td>:</td>
                    <td>-</td>
                  </tr>
                </table>
          </div>
          	<br />
            <div class="apidetail">
                <table width="940">
                  <tr>
                    <td width="70">Name</td>
                    <td width="10">:</td>
                    <td width="846"><a target="_blank" href="<?php echo Yii::app()->params->base_path; ?>api/uploadDataOnServer&userId=3&sessionId=SdscSEs">uploadDataOnServer</a></td>
                  </tr>
                  <tr>
                    <td>Required Params</td>
                    <td>:</td>
                    <td>userId , sessionId , jsonString</td>
                  </tr>
                  <tr>
                    <td>Optional Params</td>
                    <td>:</td>
                    <td>-</td>
                  </tr>
                  <tr>
                    <td>Method</td>
                    <td>:</td>
                    <td>GET and POST</td>
                  </tr>
                  <tr>
                    <td>Fields</td>
                    <td>:</td>
                    <td>userId=3&sessionId=SdscSEs</td>
                  </tr>
                  <tr>
                    <td>Notes</td>
                    <td>:</td>
                    <td>IN jsonString You have to send 4 parameter : 'columnName' , 'value' , 'query' , 'tableName'</td>
                  </tr>
                </table>
          </div>
          	<br />
            <div class="apidetail">
                <table width="940">
                  <tr>
                    <td width="70">Name</td>
                    <td width="10">:</td>
                    <td width="846"><a target="_blank" href="<?php echo Yii::app()->params->base_path; ?>api/downloadDataFromServer&userId=3&sessionId=SdscSEs&tableName=so_details&modifiedAt=2013-09-16 07:15:31">downloadDataFromServer</a></td>
                  </tr>
                  <tr>
                    <td>Required Params</td>
                    <td>:</td>
                    <td>userId , sessionId , modifiedAt , tableName</td>
                  </tr>
                  <tr>
                    <td>Optional Params</td>
                    <td>:</td>
                    <td>-</td>
                  </tr>
                  <tr>
                    <td>Method</td>
                    <td>:</td>
                    <td>GET and POST</td>
                  </tr>
                  <tr>
                    <td>Fields</td>
                    <td>:</td>
                    <td>userId=3&sessionId=SdscSEs&tableName=so_details&modifiedAt=2013-09-16 07:15:31</td>
                  </tr>
                  <tr>
                    <td>Notes</td>
                    <td>:</td>
                    <td>-</td>
                  </tr>
                </table>
          </div>
    </div>
</div>
<div style="height:50px;"></div>
<p id="back-top" style="display: block;">
    <a href="#top"><span></span></a>
</p>
</body>    
</html>