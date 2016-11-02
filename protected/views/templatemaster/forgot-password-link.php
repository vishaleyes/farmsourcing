<table cellpadding="5" cellspacing="5" style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px;background-color:#E5E5E5;" width="600">
<tr>
<td style="background-color:#000">
    <div style="text-align:left"><img src="images/logo/logo.png" style="width:160px; height:40px;"></div>
</td>
</tr>
  <tr>
    <td>##_EMAIL_TMP_FORGOT_PASSWORD_HELLO_##,</td>
  </tr>
  <tr>
    <td>##_EMAIL_TMP_FORGOT_PASSWORD_VERIFICATION_CODE_##:<b> _PASSWORD_CODE_ </b><br /></td>
  </tr>
  <tr>
    <td>##_EMAIL_TMP_FORGOT_PASSWORD_RESET_## <br /><?php echo Yii::app()->params->base_path ; ?>admin/resetpassword/token/_PASSWORD_CODE_
    </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
   <tr>
        <td> ##_EMAIL_TEMP_THANKS_MESSAGE_## </td>
  </tr>
   <tr>
        <td>
        ##_FROMNAME_##
        </td>
  </tr>
  <tr>
    <td>
    ##_EMAIL_TEMP_DO_NOT_REPLY_## 
    </td>
  </tr>
</table>
