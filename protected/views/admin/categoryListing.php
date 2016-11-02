<script type="text/javascript">
function confirmDelete(id)
{
	bootbox.confirm("Are you sure want to delete??", function(confirmed) {
		//console.log("Confirmed: "+confirmed);
		if(confirmed == true)
		{
			window.location.href = "<?php echo Yii::app()->params->base_path;?>admin/deleteCategory/id/"+id;
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
<div class="navbar"><div class="navbar-inner"><h6>All Category List</h6><button type="button" onclick="window.location.href='<?php echo Yii::app()->params->base_path;?>admin/addCategory'"  class="btn btn-large btn-info" style="float:right;">Create Category</button></div></div>
<div class="table-overflow">
    <table class="table table-striped table-bordered" id="data-table">
        <thead>
            <tr>
                <th style="text-align:center;">No&nbsp;</th>
                <th style="text-align:center;">Name</th>
                <th style="text-align:center;">Description</th>
                <th style="text-align:center;">Created Date</th>
                <th  style="text-align:center;" class="actions-column">Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php
			$i=1;
			$cnt = count($data['categoryList']);
			if($cnt>0){
			foreach($data['categoryList']  as $row){ 
		?>
            <tr>
                <td style="text-align:center;">
					<?php echo $i;?>
                </td>
                <td><a href="<?php echo Yii::app()->params->base_path ;?>admin/productListingForCategory/category_id/<?php echo $row['cat_id'];?>/category_name/<?php echo $row['category_name'];?>" class="tip" title="View Product List"><?php echo $row['category_name'];?></a></td>
                <td><?php echo substr($row['cat_description'],0,100);?></td>
                <td style="text-align:center;"><?php if(!empty($row['createdAt']) && $row['createdAt'] != "0000-00-00 00:00:00" ) { echo date("d-m-Y",strtotime($row['createdAt'])) ; } else { echo "---" ; } ?></td>
                <td style="text-align:center;">
                    <ul class="table-controls">
                        <li><a href="#" onclick="categoryDetailPopup('<?php echo $row['cat_id'];?>');" class="tip" title="Publish"><i class="fam-zoom"></i></a> </li>
                        <li><a href="<?php echo Yii::app()->params->base_path ;?>admin/editCategory/id/<?php echo $row['cat_id'];?>" class="tip" title="Edit entry"><i class="fam-pencil"></i></a> </li>
                        <li><a href="#" onclick="confirmDelete('<?php echo $row['cat_id'];?>');" class="tip" title="Remove entry"><i class="fam-cross"></i></a> </li>
                    </ul>
                </td>
            </tr>
        <?php $i++ ; } }?>    
        </tbody>
    </table>
</div>
</div>
<!-- /default datatable -->