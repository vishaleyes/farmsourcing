<script type="text/javascript">
function confirmDelete(id)
{
	bootbox.confirm("Are you sure want to delete??", function(confirmed) {
		//console.log("Confirmed: "+confirmed);
		if(confirmed == true)
		{
			window.location.href = "<?php echo Yii::app()->params->base_path;?>admin/deleteCategoryPackage/id/"+id;
		}else{
			return true;
		}
	});
	
}

function categoryDetailPopup(id)
{
	$.ajax({
		  type: 'POST',
		  url: '<?php echo Yii::app()->params->base_path ;?>admin/showCategoryDetail',
		  data: 'id='+id,
		  cache: false,
		  success: function(data)
		  {
			if(data == 0 )
			{
				bootbox.alert("Data not found.");
			}else{
				var str = data ;
				bootbox.modal(str, 'Category Details');
			}	
		  }
		 });
}

function AddcategoryPopup()
{
		 $.ajax({
		  type: 'POST',
		  url: '<?php echo Yii::app()->params->base_path ;?>admin/addCategory',
		  data: '',
		  cache: false,
		  success: function(data)
		  {
			if(data == 0 )
			{
				bootbox.alert("Data not found.");
			}else{
				var str = data ;
				bootbox.modal(str, 'Create Category');
			}	
		  }
		 });
}
</script>

<!-- Default datatable -->
<div class="widget">
<div class="navbar"><div class="navbar-inner"><h6>All Category Packaging List</h6><button type="button" onclick="window.location.href='<?php echo Yii::app()->params->base_path ;?>admin/categoryPackaging'"  class="btn btn-large btn-info" style="float:right;">Create Category Packaging</button></div></div>
<div class="table-overflow">
    <table class="table table-striped table-bordered" id="data-table">
        <thead>
            <tr>
                <th style="text-align:center">No&nbsp;</th>
                <th style="text-align:center">Unit</th>
                <th style="text-align:center">Packaging Scenario</th>
                <th style="text-align:center">Display Name</th>
                <th style="text-align:center">CreatedAt</th>
                <th style="text-align:center" class="actions-column">Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php
			$i=1;
			$cnt = count($categoryData);
			if($cnt>0){
			foreach($categoryData  as $row){  
		?>
            <tr>
                <td align="center">
					<?php echo $i;?>
                </td>
                <td><?php echo $row['unit_name'];?></td>
                
                 <td align="right"><?php echo $row['packaging_scenario'];?></td>
                 <td align="left"><?php echo $row['display_name'];?></td>
                <td align="center"><?php if(!empty($row['createdAt']) && $row['createdAt'] != "0000-00-00 00:00:00" ) { echo date("d-m-Y",strtotime($row['createdAt'])) ; } else { echo "-NULL-" ; } ?></td>
                <td align="center">
                    <ul class="table-controls">
                        <li><a href="#" onclick="confirmDelete('<?php echo $row['id'];?>');" class="tip" title="Remove entry"><i class="fam-cross"></i></a> </li>
                    </ul>
                </td>
            </tr>
        <?php $i++ ; } }?>    
        </tbody>
    </table>
</div>
</div>
<!-- /default datatable -->