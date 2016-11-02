<script type="text/javascript">
function confirmDelete(id)
{
	bootbox.confirm("Are you sure want to delete this entry?", function(confirmed) {
		//console.log("Confirmed: "+confirmed);
		if(confirmed == true)
		{
			window.location.href = "<?php echo Yii::app()->params->base_path;?>admin/deleteShrink/id/"+id;
		}else{
			return true;
		}
	});
	
}

</script>
<!-- Default datatable -->
<div class="widget">
<div class="navbar"><div class="navbar-inner"><h6>All Shrink Entries</h6></div></div>
<div class="table-overflow">
    <table class="table table-striped table-bordered" id="data-table">
        <thead>
            <tr>
                <th style="text-align:center">No</th>
                <th style="text-align:center">Product Id</th>
                <th style="text-align:center">Product Name</th>
                <th style="text-align:center">System Qty</th>
                <th style="text-align:center">Actual Qty</th>
                <th style="text-align:center">Qty Difference</th>
                <th style="text-align:center">Created At</th>
                <?php /*?><th style="text-align:center" class="actions-column">Actions</th><?php */?>
            </tr>
        </thead>
        <tbody>
        <?php
			$i=1;
			//$cnt = $data['pagination']->itemCount;
			foreach($data['shrinkList']  as $row){ 
			
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
						echo $i;
					?>
                </td>
                
                <td style="text-align:right">
					<?php 
						echo $row['product_id'];
					?>
                </td>
                
                <?php if(trim($row['product_name']) != "" ) 
					  {
						  $firstNameStyle = "";
					 	  $product_name = $row['product_name'] ; 
					  } 
					 else { 
					 	  $firstNameStyle = "text-align:center";
					 	  $product_name = "---" ;
						} 
				?>
                <td style=" <?php echo $firstNameStyle; ?> " ><?php echo $product_name; ?></td>
                
                <?php if($row['system_qnt'] != "" ) 
					  {
						  $system_qntStyle = "text-align:right";
					 	  $system_qnt = $row['system_qnt'] ; 
					  } 
					 else { 
					 	  $system_qntStyle = "text-align:center";
					 	  $system_qnt = "---" ;
						} 
				?>
                <td style=" <?php echo $system_qntStyle; ?> " ><?php echo $system_qnt; ?></td>
                
                <?php if($row['actual_qnt'] != "" ) 
					  {
						  $actual_qntStyle = "text-align:right";
					 	  $actual_qnt = $row['actual_qnt'] ; 
					  } 
					 else { 
					 	  $actual_qntStyle = "text-align:center";
					 	  $actual_qnt = "---" ;
						} 
				?>
                <td style=" <?php echo $actual_qntStyle; ?> " ><?php echo $actual_qnt; ?></td>
                
                
          		<?php if($row['qnt_difference'] != "" ) 
					  {
						  $qnt_differenceStyle = "text-align:right";
					 	  $qnt_difference = $row['qnt_difference'] ; 
					  } 
					 else { 
					 	  $qnt_differenceStyle = "text-align:center";
					 	  $qnt_difference = "---" ;
						} 
				?>
                <td style=" <?php echo $qnt_differenceStyle; ?> " ><?php echo $qnt_difference; ?></td>
                
                <td style="text-align:center"><?php if($row['createdAt'] != "" && $row['createdAt'] != "0000-00-00 00:00:00" ) { echo date("d-m-Y",strtotime($row['createdAt'])); } else { echo "---"; } ?></td>
              
                <?php /*?><td style="text-align:center">
                    <ul class="table-controls">
                        <li><a href="#" onclick="confirmDelete('<?php echo $row['id'];?>');" class="tip" title="Remove Entry"><i class="fam-cross"></i></a> </li>
                    </ul>
                </td><?php */?>
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