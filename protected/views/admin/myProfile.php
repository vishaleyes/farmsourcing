<div class="widget">
<div class="navbar"><div class="navbar-inner"><h6>My Profile</h6><button type="button" onclick="window.location.href='<?php echo Yii::app()->params->base_path;?>admin/editProfile'" class="btn btn-large btn-info" style="float:right;">Edit Profile</button></div></div>
<div class="well body">
        	<strong>FirstName:</strong><br/>
            <p><?php if(isset($data['firstName']) && $data['firstName'] != "") { echo $data['firstName'] ; } else { echo "-NOT SET-";} ?></p><br/>
            <strong>LastName:</strong><br/>
            <p><?php if(isset($data['lastName']) && $data['lastName'] != "") { echo $data['lastName'] ; } else { echo "-NOT SET-";} ?></p><br/>
            <strong>Avatar:</strong><br/>
            <p><?php if(isset($data['avatar']) && $data['avatar'] != "") { ?>
   			<img src="<?php echo Yii::app()->params->base_url; ?>assets/upload/avatar/<?php echo $data['avatar']; ?>" style="width:210px; height:150px;"  /><?php } else { ?><img src="http://placehold.it/210x110" alt="" /><?php } ?></p><br/>
  			<strong>Email:</strong><br/>
              <p><?php if(isset($data['email']) && $data['email'] != "") { echo $data['email'] ; } ?></p><br/>
   			<strong>Created Date:</strong><br/>
            <p><?php if(isset($data['created_at']) && $data['created_at'] != "") { echo $data['created_at'] ; } ?></p><br/>
      </div>
</div>