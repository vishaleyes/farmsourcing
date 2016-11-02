<script type="text/javascript">
function confirmDelete(id)
{
	bootbox.confirm("Are you sure want to delete??", function(confirmed) {
		//console.log("Confirmed: "+confirmed);
		if(confirmed == true)
		{
			window.location.href = "<?php echo Yii::app()->params->base_path;?>admin/deleteProfitPercentage/id/"+id;
		}else{
			return true;
		}
	});
	
}

function profitPercentageDetailPopup(id)
{
	$.ajax({
		  type: 'POST',
		  url: '<?php echo Yii::app()->params->base_path ;?>admin/showProfitPercentageDetail',
		  data: 'id='+id,
		  cache: false,
		  success: function(data)
		  {
			if(data == 0 )
			{
				bootbox.alert("Data not found.");
			}else{
				var str = data ;
				bootbox.modal(str, 'Profit Percentage Details');
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
<div class="navbar"><div class="navbar-inner"><h6>All Profit Percentage List</h6><button type="button" onclick="window.location.href='<?php echo Yii::app()->params->base_path ;?>admin/addProfitPercentage'"  class="btn btn-large btn-info" style="float:right;">Create New</button></div></div>
<div class="table-overflow">
    <table class="table table-striped table-bordered" id="data-table">
        <thead>
            <tr>
                <th style="text-align:center">No&nbsp;</th>
               
                <th style="text-align:center">Profit Percentage</th>
                <th style="text-align:center">From Date</th>
                <th style="text-align:center">To Date</th>
                <th style="text-align:center">Created At</th>
                <th style="text-align:center" class="actions-column">Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php
			$i=1;
			$cnt = count($profitPercentageData);
			if($cnt>0){
			foreach($profitPercentageData  as $row){ 
		?>
            <tr>
                <td style="text-align:center;">
					<?php echo $i;?>
                </td>
               
                <td style="text-align:right;"><?php echo $row['profit_percentage'];?></td>
                <td style="text-align:center;"><?php echo $row['from_date'];?></td>
                <td style="text-align:center;"><?php echo $row['to_date'];?></td>
                <td style="text-align:center;"><?php if(!empty($row['createdAt']) && $row['createdAt'] != "0000-00-00 00:00:00" ) { echo date("d-m-Y",strtotime($row['createdAt'])) ; } else { echo "---" ; } ?></td>
                <td style="text-align:center;">
                    <ul class="table-controls">
                        <li><a href="#" onclick="profitPercentageDetailPopup('<?php echo $row['id'];?>');" class="tip" title="Publish"><i class="fam-zoom"></i></a> </li>
                        <li><a href="<?php echo Yii::app()->params->base_path ;?>admin/editProfitPercentage/id/<?php echo $row['id'];?>" class="tip" title="Edit entry"><i class="fam-pencil"></i></a> </li>
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