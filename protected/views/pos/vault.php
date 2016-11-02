<script src="<?php echo Yii::app()->params->base_path_language; ?>languages/<?php echo Yii::app()->session['prefferd_language']?>/global.js" type="text/javascript"></script>
<script type="application/javascript"> 
   	function Vault() {
	   	
		 var withdraw = $j("#withdraw").val();
		 var deposite = $j("#deposite").val();
		 
		 if(withdraw == "0" && deposite == "0")
		 {
		 	jAlert(msg['INSERT_ONE_VALUE']);
			return false;
		 }
		 
		 $j.ajax({
		  type: 'POST',
		  url: '<?php echo Yii::app()->params->base_path;?>pos/Vault',
		  data: 'withdraw='+withdraw+'&deposite='+deposite,
		  cache: false,
		  success: function(data)
		  {
		   $j("#firstcont").html(data);
		   setTimeout(function() { $j("#msgbox").fadeOut();}, 2000 );
	  	   setTimeout(function() { $j("#msgbox1").fadeOut();},2000 ); 
		  }
		 });
   }
</script>

<a href="#verifycodePopup" id="verifycode"></a>
<!-- End Mouse Scroll Finction -->
<div id="update-message"></div>
<!-- Middle Part -->

<div class="clear"></div>

<div class="mainContainer">
    
    <!-- RightSide Slide Bar -->    
    <div class="" id="secondcont" >
      <input type="hidden" id="mainPageCheker" value="1" />
       <div class="RightSide">	
            <div class="clear"></div>
                <div class="heading" style="margin-top:2px;">Home</div>
<div>
<?php if(Yii::app()->user->hasFlash('success')): ?>
<div class="error-msg-area">								   
   <div id="msgbox" class="clearmsg"> <?php echo Yii::app()->user->getFlash('success'); ?></div>
</div>
<?php endif; ?>
<?php if(Yii::app()->user->hasFlash('error')): ?>
<div class="error-msg-area">
    <div id="msgbox1" class="errormsg"><?php echo Yii::app()->user->getFlash('error'); ?></div>
</div>
        <?php endif; ?>
        </div>
             <div class="productboxgreen-small">
             
            	<h1 style="color:#333333; margin-left:300px;">##_VAULT_PAGE_VAULT_DETAILS_##</h1>
                	<div style="margin-left:300px;">
                 <div class="field">
                            <label>##_VAULT_PAGE_CASHIER_ID_##</label>
                            <input style="width:240px;" class="textbox" type="text" id="userId" name="userId" value="<?php echo Yii::app()->session['farmsourcing_posUser'];?>" disabled="disabled" />
                        </div>
                 <div class="clear"></div>
                <div class="field">
                            <label>##_VAULT_PAGE_WITHDRAW_##</label>
                            <input style="width:240px;" class="textbox" type="text" id="withdraw" name="withdraw" value="0" />
                            <input type="hidden" name="cashier_id" value="<?php echo Yii::app()->session['farmsourcing_posUser'];?>" />
                        </div>
                 <div class="clear"></div>
                 <div class="field">
                            <label>##_VAULT_PAGE_DEPOSITE_##</label>
                            <input style="width:240px;" class="textbox" type="text" id="deposite" name="deposite" value="0" />
                  </div>
                 <div class="clear"></div>
                
                 <div class="btnfield">   
               		<input type="submit" name="submit" value="##_BTN_SUBMIT_##" style=" background-color:#02356E; color:#FFF; width:100px; height:30px;"  class="btn" onclick="Vault();" />  
                </div>
            </div>
       </div>
    </div>
    
</div>