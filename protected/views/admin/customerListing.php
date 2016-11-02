<script type="text/javascript">
function confirmDelete(id)
{
	bootbox.confirm("Are you sure want to delete user?", function(confirmed) {
		//console.log("Confirmed: "+confirmed);
		if(confirmed == true)
		{
			window.location.href = "<?php echo Yii::app()->params->base_path;?>admin/deleteCustomer/id/"+id;
		}else{
			return true;
		}
	});
	
}

function customerDetailPopup(id)
{
	$.ajax({
		  type: 'POST',
		  url: '<?php echo Yii::app()->params->base_path ;?>admin/showCustomerDetail',
		  data: 'id='+id,
		  cache: false,
		  success: function(data)
		  {
			if(data == 0 )
			{
				bootbox.alert("Data not found.");
			}else{
				var str = data ;
				bootbox.modal(str, 'Customer Details');
			}	
		  }
		 });
}

function changePasswordPopup(id)
{
	$.ajax({
		  type: 'POST',
		  url: '<?php echo Yii::app()->params->base_path ;?>admin/showCustomerChangePassword',
		  data: 'id='+id,
		  cache: false,
		  success: function(data)
		  {
			if(data == 0 )
			{
				bootbox.alert("Data not found.");
			}else{
				var str = data ;
				bootbox.modal(str, "Change Customer's Password");
			}	
		  }
		 });
}

function getCustomerCardPdf(id)
{
	$.ajax({
		  type: 'POST',
		  url: '<?php echo Yii::app()->params->base_path ;?>admin/raiseCustomerCard',
		  data: 'id='+id,
		  cache: false,
		  success: function(data)
		  {
				window.open("<?php echo Yii::app()->params->base_url;?>assets/upload/members/members_"+id+".pdf",'_blank');
				return true;
				//window.location.href='<?php //echo Yii::app()->params->base_path ;?>admin/customerListing';	
		  }
		 });
}
</script>
<!-- Default datatable -->
<div class="widget">
<div class="navbar"><div class="navbar-inner"><h6>All Customers</h6><button type="button" onclick="window.location.href='<?php echo Yii::app()->params->base_path;?>admin/addCustomer'" class="btn btn-large btn-info" style="float:right;">Create Customer</button></div></div>
<div class="table-overflow">
    <table class="table table-striped table-bordered" id="data-table">
        <thead>
            <tr>
                <th style="text-align:center">No</th>
                <!--<th style="text-align:center" title="Customer Id">Customer ID</th>-->
                <th style="text-align:center" title="Representative Id">Customer ID</th>
                <th style="text-align:center">Name</th>
              <!--  <th style="text-align:center">Address</th>-->
                <th style="text-align:center">Email</th>
                <th style="text-align:center">Mobile No</th>
                <th style="text-align:center">Zone</th>
                <th style="text-align:center">CreatedAt</th>
                <th style="text-align:center; width:110px;" class="actions-column">Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php
			$i=1;
			//$cnt = $data['pagination']->itemCount;
			foreach($data['customerList']  as $row){ 
			
			if($row['status'] == "1") { 
				$class = "info";
				$icon = "fam-tick";
				$title = "Deactive this user";
			}else{
				$class = "info";
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
                
                <?php /*?><td style="text-align:right">
					<?php 
						///echo $i+($data['pagination']->getCurrentPage()*$data['pagination']->getLimit());
						echo $row['customer_id'];
					?>
                </td><?php */?>
                
                <td style="text-align:right">
					<?php 
						///echo $i+($data['pagination']->getCurrentPage()*$data['pagination']->getLimit());
						echo $row['representativeId'];
					?>
                </td>
                
                <?php if(trim($row['customer_name']) != "" ) 
					  {
						  $firstNameStyle = "";
					 	  $customer_name = $row['customer_name'] ; 
					  } 
					 else { 
					 	  $firstNameStyle = "text-align:center";
					 	  $customer_name = "---" ;
						} 
				?>
                <td style=" <?php echo $firstNameStyle; ?> " ><?php echo $customer_name; ?></td>
                
                <?php if(trim($row['cust_email']) != "" ) 
					  {
						  $emailStyle = "";
					 	  $cust_email = $row['cust_email'] ; 
					  } 
					 else { 
					 	  $emailStyle = "text-align:center";
					 	  $cust_email = "---" ;
						} 
				?>
                <td style=" <?php echo $emailStyle; ?> " ><?php echo $cust_email; ?></td>
                
                <?php if(trim($row['mobile_no']) != "" ) 
					  {
						  $contact_noStyle = "text-align:right";
					 	  $contact_no = $row['mobile_no'] ; 
					  } 
					 else { 
					 	  $contact_noStyle = "text-align:center";
					 	  $contact_no = "---" ;
						} 
				?>
                <td style=" <?php echo $contact_noStyle; ?> " ><?php echo $contact_no; ?></td>
                
                <?php if(trim($row['zoneName']) != "" ) 
					  {
						  $zoneNameStyle = "";
					 	  $zoneName = $row['zoneName'] ; 
					  } 
					 else { 
					 	  $zoneNameStyle = "text-align:center";
					 	  $zoneName = "---" ;
						} 
				?>
                <td style=" <?php echo $zoneNameStyle; ?> " ><?php echo $zoneName; ?></td>
               
                
                
                <td style="text-align:center"><?php if($row['createdAt'] != "" && $row['createdAt'] != "0000-00-00 00:00:00" ) { echo date("d-m-Y",strtotime($row['createdAt'])); } else { echo "---"; } ?></td>
              <?php /*?>  <td style="text-align:center"><a href="<?php echo Yii::app()->params->base_path;?>admin/changeUserStatus/id/<?php echo $row['id'];?>" title="<?php echo $title ; ?>"><i class="<?php echo $icon; ?>"></i></a></td><?php */?>
                <td style="text-align:center;">
                    <ul class="table-controls">
                        <li><a href="#" onclick="customerDetailPopup('<?php echo $row['customer_id'];?>');" class="tip" title="View Customer"><i class="fam-zoom"></i></a> </li>
                        <?php if(Yii::app()->session['type'] != 3) { ?>
                        
                        <li><a href="<?php echo Yii::app()->params->base_path ;?>admin/editCustomer/id/<?php echo $row['customer_id'];?>" class="tip" title="Edit entry"><i class="fam-pencil"></i></a> </li>
                        <li><a href="#" onclick="changePasswordPopup('<?php echo $row['customer_id'];?>');" class="tip" title="Change Password"><i class="icon-cogs"></i></a></li>
                        <li><a href="#" onclick="getCustomerCardPdf('<?php echo $row['customer_id'];?>');" class="tip" title="Membership Card"><i class="fam-vcard"></i></a></li>
                        <li><a href="#" onclick="confirmDelete('<?php echo $row['customer_id'];?>');" class="tip" title="Remove User"><i class="fam-cross"></i></a></li>
                        
                        <?php } ?>
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