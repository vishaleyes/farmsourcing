<!-- Default form -->
<form id="validate" action="<?php echo Yii::app()->params->base_path;?>admin/saveCompanyProfile" method="post" enctype="multipart/form-data">
<div class="widget">
<div class="navbar"><div class="navbar-inner"><h6><a href="<?php echo Yii::app()->params->base_path;?>admin/companyProfile">Company Profile</a>&nbsp;&nbsp;<img src="<?php echo Yii::app()->params->base_url;?>images/path-arrow.png" alt="" border="0" />&nbsp;&nbsp;Edit</h6></div></div>

<div class="well">

    <div class="control-group">
    <label class="control-label">Company Name<span class="text-error">* &nbsp;</span>:</label>
    <div class="controls"><input type="text" name="company_name" class="validate[required] span12 input-xlarge" placeholder="Enter first name" value="<?php if(isset($data['company_name']) && $data['company_name'] != "") { echo $data['company_name']; } ?>" /></div>
    </div>
    
    <div class="control-group">
    <label class="control-label">Company Address<span class="text-error">* &nbsp;</span>:</label>
    <div class="controls"><input type="text" name="company_address" class="validate[required] span12 input-xlarge" placeholder="Enter last name" value="<?php if(isset($data['company_address']) && $data['company_address'] != "") { echo $data['company_address']; } ?>" /></div>
    </div>
    
    <div class="control-group">
        <label class="control-label">Company Logo :</label>
        <div class="controls">
            <input type="file" name="userFile" class="styled">
        </div>
        <?php if(isset($data['company_logo']) && $data['company_logo'] != "") { ?>
       <img src="<?php echo Yii::app()->params->base_url; ?>assets/upload/clientLogo/<?php echo $data['company_logo']; ?>" style="width:210px; height:150px;"  /><?php } else { ?><img src="http://placehold.it/210x110" alt="" /><?php } ?>
    </div>
                                            
    <div class="control-group">
    <label class="control-label">Currency<span class="text-error">* &nbsp;</span>:</label>
    
    
    <div class="controls">
    
    <select id="currency" name="currency" style=" width:100px" >
                      <?php foreach($currencyList as $row){ ?>
               <option value="<?php echo  $row['curr'] ; ?>"  <?php if(isset($data['currency']) && $data['currency']==$row['curr']){ ?> selected <?php } ?> ><?php echo $row['curr'];?></option>
               <?php } ?>
                	</select>
                    
                    
   <?php /*?> <input type="text" name="currency" class="validate[required] span12 input-xlarge" placeholder="Enter last name" disabled="disabled" value="<?php if(isset($data['currency']) && $data['currency'] != "") { echo $data['currency']; } ?>" /><?php */?></div>
    </div>
    
    <input type="hidden" <?php if(isset($data['id'])){ ?> value="<?php echo $data['id']; ?>" <?php } ?> name="AdminID"/>
     
<div class="form-actions align-right">
<button type="submit" name="FormSubmit" class="btn btn-large btn-info">Submit</button>
<button type="button" onclick="window.location.href='<?php echo Yii::app()->params->base_path;?>admin/channelListing'" class="btn btn-large btn-danger">Cancel</button>
<button type="reset"  class="btn-large btn">Reset</button>
</div>

</div>

</div>
</form>
<!-- /default form -->