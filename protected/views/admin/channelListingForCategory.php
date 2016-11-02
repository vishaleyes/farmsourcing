<script type="text/javascript">
function confirmDelete(id)
{
	
	bootbox.confirm("Are you sure want to delete??", function(confirmed) {
			//console.log("Confirmed: "+confirmed);
			if(confirmed == true)
			{
				window.location.href = "<?php echo Yii::app()->params->base_path;?>admin/deleteChannel/id/"+id;	
			}else{
				return true;
			}
		});
	
}

function channelDetailPopup(id)
{
	$.ajax({
		  type: 'POST',
		  url: '<?php echo Yii::app()->params->base_path ;?>admin/showChannelDetail',
		  data: 'id='+id,
		  cache: false,
		  success: function(data)
		  {
			if(data == 0 )
			{
				bootbox.alert("Data not found.");
			}else{
				var str = data ;
				bootbox.modal(str, 'Channel Details');
			}	
		  }
		 });
}
</script>

<!-- Default datatable -->
<div class="widget">
<div class="navbar"><div class="navbar-inner"><h6><a href="<?php echo Yii::app()->params->base_path;?>admin/channelCategoryListing"><?php if(isset($ext['category_name']) && $ext['category_name'] != "" ) { echo $ext['category_name'] ; } else { echo "Category List" ; } ?></a>&nbsp;&nbsp;<img src="<?php echo Yii::app()->params->base_url;?>images/path-arrow.png" alt="" border="0" />&nbsp;&nbsp;<?php echo "Channels List" ; ?></h6><button type="button" onclick="window.location.href='<?php echo Yii::app()->params->base_path;?>admin/addChannel'" class="btn btn-large btn-danger" style="float:right;">Add New Channel</button></div></div>
<div class="table-overflow">
    <table class="table table-striped table-bordered" id="data-table">
        <thead>
            <tr>
                <th>No&nbsp;</th>
                <th>Name</th>
                <th>Description</th>
                <th>Category</th>
                <th>Created Date</th>
                <th class="actions-column">Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php
			$i=1;
			$cnt = count($data['channelList']);
			if($cnt>0){
			foreach($data['channelList']  as $row){ 
		?>
            <tr>
                <td>
					<?php echo $i+($data['pagination']->getCurrentPage()*$data['pagination']->getLimit());?>
                </td>
                <td><?php echo $row['name'];?></td>
                <td><?php echo substr($row['description'],0,100);?></td>
                <td><?php echo $row['category_name'];?></td>
                <td><?php if(!empty($row['created']) && $row['created'] != "0000-00-00 00:00:00" ) { echo date("d-m-Y",strtotime($row['created'])) ; } else { echo "-NULL-" ; } ?></td>
                <td>
                    <ul class="table-controls">
                        <li><a href="#" onclick="channelDetailPopup('<?php echo $row['id'];?>');" class="tip" title="Publish"><i class="fam-tick"></i></a> </li>
                        <li><a href="<?php echo Yii::app()->params->base_path ;?>admin/addChannel/id/<?php echo $row['id'];?>" class="tip" title="Edit entry"><i class="fam-pencil"></i></a> </li>
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