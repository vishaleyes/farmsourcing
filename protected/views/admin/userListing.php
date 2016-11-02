<script type="text/javascript">
function confirmDelete(id)
{
	bootbox.confirm("Are you sure want to delete user?", function(confirmed) {
		//console.log("Confirmed: "+confirmed);
		if(confirmed == true)
		{
			window.location.href = "<?php echo Yii::app()->params->base_path;?>admin/deleteUser/id/"+id;
		}else{
			return true;
		}
	});
	
}

function userDetailPopup(id)
{
	$.ajax({
		  type: 'POST',
		  url: '<?php echo Yii::app()->params->base_path ;?>admin/showUserDetail',
		  data: 'id='+id,
		  cache: false,
		  success: function(data)
		  {
			if(data == 0 )
			{
				bootbox.alert("Data not found.");
			}else{
				var str = data ;
				bootbox.modal(str, 'User Details');
			}	
		  }
		 });
}

function changePasswordPopup(id)
{
	$.ajax({
		  type: 'POST',
		  url: '<?php echo Yii::app()->params->base_path ;?>admin/showChangePassword',
		  data: 'id='+id,
		  cache: false,
		  success: function(data)
		  {
			if(data == 0 )
			{
				bootbox.alert("Data not found.");
			}else{
				var str = data ;
				bootbox.modal(str, 'Change Password');
			}	
		  }
		 });
}
</script>
<!-- Default datatable -->
<div class="widget">
<div class="navbar"><div class="navbar-inner"><h6>All Users</h6><button type="button" onclick="window.location.href='<?php echo Yii::app()->params->base_path;?>admin/addUser'" class="btn btn-large btn-info" style="float:right;">Create User</button></div></div>
<div class="table-overflow">
    <table class="table table-striped table-bordered" id="data-table">
        <thead>
            <tr>
                <th style="text-align:center">No</th>
                <th style="text-align:center">First Name</th>
                <th style="text-align:center">Last Name</th>
                <th style="text-align:center">Picture</th>
                <th style="text-align:center">Email</th>
                <th style="text-align:center">Created At</th>
                <th style="text-align:center">User Type</th>
                <th style="text-align:center">Approve</th>
                <th style="text-align:center" class="actions-column">Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php
			$i=1;
			//$cnt = $data['pagination']->itemCount;
			foreach($data['users']  as $row){ 
			
			if($row['status'] == "1") { 
				$class = "success";
				$icon = "fam-tick";
				$title = "Deactive this user";
			}else{
				$class = "error";
				$icon = "fam-cross";
				$title = "Active this user";
			}
		?>
            <tr class="<?php echo $class; ?>"  >
                <td style="text-align:right">
					<?php 
						///echo $i+($data['pagination']->getCurrentPage()*$data['pagination']->getLimit());
						echo $i;
					?>
                </td>
                
                <?php if(trim($row['firstName']) != "" ) 
					  {
						  $firstNameStyle = "";
					 	  $firstName = $row['firstName'] ; 
					  } 
					 else { 
					 	  $firstNameStyle = "text-align:center";
					 	  $firstName = "---" ;
						} 
				?>
                <td style=" <?php echo $firstNameStyle; ?> " ><?php echo $firstName; ?></td>
                
                <?php if(trim($row['lastName']) != "" ) 
					  {
						  $lastNameStyle = "";
					 	  $lastName = $row['lastName'] ; 
					  } 
					 else { 
					 	  $lastNameStyle = "text-align:center";
					 	  $lastName = "---" ;
						} 
				?>
                <td style=" <?php echo $lastNameStyle; ?> " ><?php echo $lastName; ?></td>
                <td style="text-align:center" ><a href="<?php echo Yii::app()->params->base_url;?>assets/upload/avatar/<?php echo $row['avatar'];?>" class="lightbox">
                <?php if(isset($row['avatar']) && $row['avatar'] != "") { ?>
                	<img src="<?php echo Yii::app()->params->base_url;?>assets/upload/avatar/<?php echo $row['avatar'];?>" width="50" height="50" />
                 <?php } else { echo "----" ; } ?>
                    </a></td> 
                <?php if(trim($row['email']) != "" ) 
					  {
						  $emailStyle = "";
					 	  $email = $row['email'] ; 
					  } 
					 else { 
					 	  $emailStyle = "text-align:center";
					 	  $email = "---" ;
						} 
				?>
                <td style=" <?php echo $emailStyle; ?> " ><?php echo $email; ?></td>
                <td style="text-align:center"><?php if($row['created_at'] != "" && $row['created_at'] != "0000-00-00 00:00:00" ) { echo date("d-m-Y",strtotime($row['created_at'])); } else { echo "---"; } ?></td>
                <td style="text-align:center">
                <?php if(isset($row['type']) && $row['type'] == "0") { echo "Super Admin" ; } else if(isset($row['type']) && $row['type'] == "1") { echo "WH manager"; } else if(isset($row['type']) && $row['type'] == "2") { echo "Driver"; }else if(isset($row['type']) && $row['type'] == "3") { echo "Operator"; }else if(isset($row['type']) && $row['type'] == "4") { echo "Admin"; }else if(isset($row['type']) && $row['type'] == "5") { echo "POS"; } ?>
                </td>
                <td style="text-align:center"><a href="<?php echo Yii::app()->params->base_path;?>admin/changeUserStatus/id/<?php echo $row['id'];?>" title="<?php echo $title ; ?>"><i class="<?php echo $icon; ?>"></i></a></td>
                <td style="text-align:center">
                    <ul class="table-controls">
                        <li><a href="#" onclick="userDetailPopup('<?php echo $row['id'];?>');" class="tip" title="View Profile"><i class="fam-zoom"></i></a> </li>
                        <li><a href="<?php echo Yii::app()->params->base_path ;?>admin/editUser/id/<?php echo $row['id'];?>" class="tip" title="Edit entry"><i class="fam-pencil"></i></a> </li>
                        <li><a href="#" onclick="changePasswordPopup('<?php echo $row['id'];?>');" class="tip" title="Change Password"><i class="icon-cogs"></i></a> </li>
                        <li><a href="#" onclick="confirmDelete('<?php echo $row['id'];?>');" class="tip" title="Remove User"><i class="fam-cross"></i></a> </li>
                    </ul>
                </td>
            </tr>
	   <?php
        $i++;
        }
	   ?>
        </tbody>
    </table>
</div>
</div>
<!-- /default datatable -->