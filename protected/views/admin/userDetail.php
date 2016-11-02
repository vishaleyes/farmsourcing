<!-- Span 12 -->
    <div class="widget">
        <div class="navbar">
            <div class="navbar-inner"><h6><?php if(isset($userData['firstName']) && $userData['firstName'] != "") { echo $userData['firstName']." ".$userData['lastName'] ; } else { echo "User" ;} ?></h6></div>
        </div>
        <div class="well body">
        	<strong>First Name:</strong><br/>
            <p><?php if(isset($userData['firstName']) && $userData['firstName'] != "") { echo $userData['firstName'] ; } ?></p>
            <strong>Last Name:</strong><br/>
            <p><?php if(isset($userData['lastName']) && $userData['lastName'] != "") { echo $userData['lastName'] ; } ?></p>
            <strong>Email:</strong><br/>
            <p><?php if(isset($userData['email']) && $userData['email'] != "") { echo $userData['email'] ; } ?></p>
            <strong>User Type:</strong><br/>
            <p><?php if(isset($userData['type']) && $userData['type'] == "0") { echo "Super Admin" ; } else if(isset($userData['type']) && $userData['type'] == "1") { echo "WH manager"; } else if(isset($userData['type']) && $userData['type'] == "2") { echo "Driver"; }else if(isset($userData['type']) && $userData['type'] == "3") { echo "Operator"; } else if(isset($userData['type']) && $userData['type'] == "4") { echo "Admin"; }else if(isset($userData['type']) && $userData['type'] == "5") { echo "POS"; } ?></p>
            <strong>Avatar:</strong><br/>
            <p><?php if(isset($userData['avatar']) && $userData['avatar'] != "") { ?>
   			<img src="<?php echo Yii::app()->params->base_url; ?>assets/upload/avatar/<?php echo $userData['avatar']; ?>" style="width:210px; height:110px;"  /><?php } else { ?><img src="http://placehold.it/210x110" alt="" /><?php } ?></p>
   			<strong>Created Date:</strong><br/>
            <p><?php if(isset($userData['created_at']) && $userData['created_at'] != "") { echo $userData['created_at'] ; } ?></p>
        </div>
    </div>
<!-- /span 12 -->