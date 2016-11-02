<div class="widget">
<div class="navbar"><div class="navbar-inner"><h6>Company Profile</h6><button type="button" onclick="window.location.href='<?php echo Yii::app()->params->base_path;?>admin/editCompanyProfile'" class="btn btn-large btn-info" style="float:right;">Edit Profile</button></div></div>
<div class="well body">

        	<strong>Company Name:</strong><br/>
            <p><?php if(isset($data['company_name']) && $data['company_name'] != "") { echo $data['company_name'] ; } else { echo "-NOT SET-";} ?></p><br/>
            <strong>Company Address:</strong><br/>
            <p><?php if(isset($data['company_address']) && $data['company_address'] != "") { echo $data['company_address'] ; } else { echo "-NOT SET-";} ?></p><br/>
            <strong>Company Logo:</strong><br/>
            <p><?php if(isset($data['company_logo']) && $data['company_logo'] != "") { ?>
   			<img src="<?php echo Yii::app()->params->base_url; ?>assets/upload/clientLogo/<?php echo $data['company_logo']; ?>" style="width:210px; height:150px;"  /><?php } else { ?><img src="http://placehold.it/210x110" alt="" /><?php } ?></p><br/>
  			<strong>Currency:</strong><br/>
              <p><?php if(isset($data['currency']) && $data['currency'] != "") { echo $data['currency'] ; } ?></p><br/>
   			<strong>Created Date:</strong><br/>
            <p><?php if(isset($data['createdAt']) && $data['createdAt'] != "") { echo $data['createdAt'] ; } ?></p><br/>
      </div>
</div>