<script type="text/javascript">
function confirmDelete(id)
{
	bootbox.confirm("Are you sure want to delete this zone?", function(confirmed) {
		//console.log("Confirmed: "+confirmed);
		if(confirmed == true)
		{
			window.location.href = "<?php echo Yii::app()->params->base_path;?>admin/deleteZone/id/"+id;
		}else{
			return true;
		}
	});
	
}

function zoneDetailPopup(id)
{
	$.ajax({
		  type: 'POST',
		  url: '<?php echo Yii::app()->params->base_path ;?>admin/showZoneDetail',
		  data: 'id='+id,
		  cache: false,
		  success: function(data)
		  {
			if(data == 0 )
			{
				bootbox.alert("Data not found.");
			}else{
				var str = data ;
				bootbox.modal(str, 'Zone Details');
			}	
		  }
		 });
}

</script>
<!-- Default datatable -->
<div class="widget">
<div class="navbar"><div class="navbar-inner"><h6>All Zone</h6><button type="button" onclick="window.location.href='<?php echo Yii::app()->params->base_path;?>admin/addZone'" class="btn btn-large btn-info" style="float:right;">Create Zone</button></div></div>
<div class="table-overflow">
    <table class="table table-striped table-bordered" id="data-table">
        <thead>
            <tr>
                <th style="text-align:center">No</th>
                <th style="text-align:center">Zone Name</th>
                <th style="text-align:center">Created At</th>
                <th style="text-align:center" class="actions-column">Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php
			$i=1;
			//$cnt = $data['pagination']->itemCount;
			foreach($data['zoneList']  as $row){ 
			
			$class = "info";
		?>
            <tr class="<?php echo $class; ?>"  >
                <td style="text-align:right">
					<?php 
						///echo $i+($data['pagination']->getCurrentPage()*$data['pagination']->getLimit());
						echo $i;
					?>
                </td>
                
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
                <td style=" <?php echo $zoneNameStyle; ?> " ><a href="<?php echo Yii::app()->params->base_path ;?>admin/customerListingForZone/zone_id/<?php echo $row['zone_id'];?>/zoneName/<?php echo $row['zoneName'];?>" class="tip" title="View Customer List Of this Zone"><?php echo $zoneName; ?></a></td>
                
                <td style="text-align:center"><?php if($row['createdAt'] != "" && $row['createdAt'] != "0000-00-00 00:00:00" ) { echo date("d-m-Y",strtotime($row['createdAt'])); } else { echo "---"; } ?></td>
              <?php /*?>  <td style="text-align:center"><a href="<?php echo Yii::app()->params->base_path;?>admin/changeUserStatus/id/<?php echo $row['id'];?>" title="<?php echo $title ; ?>"><i class="<?php echo $icon; ?>"></i></a></td><?php */?>
                <td style="text-align:center">
                    <ul class="table-controls">
                        <li><a href="#" onclick="zoneDetailPopup('<?php echo $row['zone_id'];?>');" class="tip" title="View Zone Detail"><i class="fam-zoom"></i></a> </li>
                        
                        <li><a href="<?php echo Yii::app()->params->base_path ;?>admin/addZone/id/<?php echo $row['zone_id'];?>" class="tip" title="Edit"><i class="fam-pencil"></i></a> </li>
                       
                        <li><a href="#" onclick="confirmDelete('<?php echo $row['zone_id'];?>');" class="tip" title="Remove Zone"><i class="fam-cross"></i></a> </li>
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