<script type="text/javascript">
function confirmDelete(id)
{
	bootbox.confirm("Are you sure want to delete this vendor?", function(confirmed) {
		//console.log("Confirmed: "+confirmed);
		if(confirmed == true)
		{
			window.location.href = "<?php echo Yii::app()->params->base_path;?>admin/deleteVendor/id/"+id;
		}else{
			return true;
		}
	});
	
}

function vendorDetailPopup(id)
{
	$.ajax({
		  type: 'POST',
		  url: '<?php echo Yii::app()->params->base_path ;?>admin/showVendorDetail',
		  data: 'id='+id,
		  cache: false,
		  success: function(data)
		  {
			if(data == 0 )
			{
				bootbox.alert("Data not found.");
			}else{
				var str = data ;
				bootbox.modal(str, 'Vendor Details');
			}	
		  }
		 });
}


</script>
<!-- Default datatable -->
<div class="widget">
<div class="navbar"><div class="navbar-inner"><h6>All Vendors</h6><button type="button" onclick="window.location.href='<?php echo Yii::app()->params->base_path;?>admin/addVendor'" class="btn btn-large btn-info" style="float:right;">Create Vendor</button></div></div>
<div class="table-overflow">
    <table class="table table-striped table-bordered" id="data-table">
        <thead>
            <tr>
                <th style="text-align:center">No</th>
                <th style="text-align:center">Vendor Name</th>
                <th style="text-align:center">Contact Name</th>
                <th style="text-align:center">Email</th>
                <th style="text-align:center">Contact No</th>
                <th style="text-align:center">Created At</th>
                <th style="text-align:center" class="actions-column">Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php
			$i=1;
			//$cnt = $data['pagination']->itemCount;
			foreach($data['vendorList']  as $row){ 
			
			$class = "info";
		?>
            <tr class="<?php echo $class; ?>"  >
                <td style="text-align:right">
					<?php 
						///echo $i+($data['pagination']->getCurrentPage()*$data['pagination']->getLimit());
						echo $i;
					?>
                </td>
                
                <?php if(trim($row['vendor_name']) != "" ) 
					  {
						  $nameStyle = "";
					 	  $name = $row['vendor_name'] ; 
					  } 
					 else { 
					 	  $nameStyle = "text-align:center";
					 	  $name = "---" ;
						} 
				?>
                <td style=" <?php echo $nameStyle; ?> " ><a href="<?php echo Yii::app()->params->base_path ;?>admin/productListingForVendor/vendor_id/<?php echo $row['vendor_id'];?>/vendor_name/<?php echo $row['vendor_name'];?>" class="tip" title="View Product List Of This Vendor"><?php echo $name;?></a></td>
                
           
                
                
                <?php if(trim($row['contact_name']) != "" ) 
					  {
						  $contact_nameStyle = "";
					 	  $contact_name = $row['contact_name'] ; 
					  } 
					 else { 
					 	  $contact_nameStyle = "text-align:center";
					 	  $contact_name = "---" ;
						} 
				?>
                <td style=" <?php echo $contact_nameStyle; ?> " ><?php echo $contact_name; ?></td>
                
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
                
                 <?php if(trim($row['contact_no']) != "" ) 
					  {
						  $contact_noStyle = "text-align:right";
					 	  $contact_no = $row['contact_no'] ; 
					  } 
					 else { 
					 	  $contact_noStyle = "text-align:center";
					 	  $contact_no = "---" ;
						} 
				?>
                <td style=" <?php echo $contact_noStyle; ?> " ><?php echo $contact_no; ?></td>
                
                <td style="text-align:center"><?php if($row['createdAt'] != "" && $row['createdAt'] != "0000-00-00 00:00:00" ) { echo date("d-m-Y",strtotime($row['createdAt'])); } else { echo "---"; } ?></td>
              <?php /*?>  <td style="text-align:center"><a href="<?php echo Yii::app()->params->base_path;?>admin/changeUserStatus/id/<?php echo $row['id'];?>" title="<?php echo $title ; ?>"><i class="<?php echo $icon; ?>"></i></a></td><?php */?>
                <td style="text-align:center">
                    <ul class="table-controls">
                        <li><a href="#" onclick="vendorDetailPopup('<?php echo $row['vendor_id'];?>');" class="tip" title="View Vendor"><i class="fam-zoom"></i></a> </li>
                        <li><a href="<?php echo Yii::app()->params->base_path ;?>admin/addVendor/id/<?php echo $row['vendor_id'];?>" class="tip" title="Edit"><i class="fam-pencil"></i></a> </li>
                       
                        <li><a href="#" onclick="confirmDelete('<?php echo $row['vendor_id'];?>');" class="tip" title="Remove Vendor"><i class="fam-cross"></i></a> </li>
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