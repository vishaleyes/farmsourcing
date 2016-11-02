<script type="text/javascript">
function confirmDelete(id)
{
	bootbox.confirm("Are you sure want to delete??", function(confirmed) {
		//console.log("Confirmed: "+confirmed);
		if(confirmed == true)
		{
			window.location.href = "<?php echo Yii::app()->params->base_path;?>admin/deletePromoCode/id/"+id;
		}else{
			return true;
		}
	});
	
}

function couponDetailPopup(id)
{
	$.ajax({
		  type: 'POST',
		  url: '<?php echo Yii::app()->params->base_path ;?>admin/showPromoCodeDetail',
		  data: 'id='+id,
		  cache: false,
		  success: function(data)
		  {
			
			if(data == 0 )
			{
				bootbox.alert("Data not found.");
			}else{
				var str = data ;
				bootbox.modal(str, 'Promo Code Details');
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
<!-- Content -->
		<div id="content">

		    <!-- Content wrapper -->
		    <div class="wrapper">

			    <!-- Page header -->
			    <div class="page-header">
			    	<div class="page-title">
				    	<h5>Promo Codes</h5>
				    </div>
			    </div>
			    
   	<div class="widget">
        <div class="well body">
            <div class="controls">
                <ul class="nav nav-pills">
                    <li class="active"><a href="<?php echo Yii::app()->params->base_path ;?>admin/promoCodeAllocationEntry"><i class="icon-plus"></i>Promo Codes Allocation</a></li>
                    <li class="active" style="margin-left:20px;"><a href="<?php echo Yii::app()->params->base_path ;?>admin/promocodeReturnEntry"><i class="icon-plus"></i>Promo Codes Return</a></li>
                </ul>                        
            </div>
      </div>
<!-- /span 12 -->  
	</div>
		    <!-- /content wrapper -->
		</div>
            <!-- /content -->
            
        <div class="widget">
<div class="navbar"><div class="navbar-inner"><h6>Allocated Coupons</h6></div></div>
<div class="table-overflow">
    <table class="table table-striped table-bordered" id="data-table">
        <thead>
            <tr>
                <th style="text-align:center">No</th>
                <th style="text-align:center">Promocode Id</th>
                <th style="text-align:center">Promocode Type</th>
                <th style="text-align:center">Promo Code Discount</th>
                <th style="text-align:center">Created At</th>
                <th style="text-align:center">Status</th>
                <th style="text-align:center" class="actions-column">Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php
			$i=1;
			//$cnt = $data['pagination']->itemCount;
			
			foreach($promoCodesList  as $row){ 
			
			if($row['status'] == "0") { 
				$class = "info";
				$status = "Pending" ;
			}else if($row['status'] == "1"){
				$class = "success";
				$status = "Received" ;
			}
		?>
            <tr class="<?php echo $class; ?>"  >
                <td style="text-align:right">
					<?php 
						///echo $i+($data['pagination']->getCurrentPage()*$data['pagination']->getLimit());
						echo $i;
					?>
                </td>
                
                <?php if(trim($row['promocode_uniqueId']) != "" ) 
					  {
						  $total_amountStyle = "text-align:center";
					 	  $promocode_uniqueId = $row['promocode_uniqueId'] ; 
					  } 
					 else { 
					 	  $total_amountStyle = "text-align:center";
					 	  $promocode_uniqueId = "---" ;
						} 
				?>
                <td style=" <?php echo $total_amountStyle; ?> " ><?php echo $promocode_uniqueId; ?></td>
                
           		<?php if(trim($row['promocode_type']) != "" ) 
					  {
						  $promocode_type_style = "text-align:center";
					 	  $promocode_type = $row['promocode_type'] ; 
					  } 
					 else { 
					 	  $promocode_type_style = "text-align:center";
					 	  $promocode_type = "---" ;
						} 
				?>
                <td style=" <?php echo $promocode_type_style; ?> " ><?php if($promocode_type == 0) { echo "RS";} else { echo "%"; } ?></td>
                
               
                <?php if(trim($row['promocode_amount']) != "" ) 
					  {
						  $promocode_amountStyle = "text-align:right";
					 	  $promocode_amount = $row['promocode_amount'] ; 
					  } 
					 else { 
					 	  $promocode_amountStyle = "text-align:center";
					 	  $promocode_amount = "---" ;
						} 
				?>
                <td style=" <?php echo $promocode_amountStyle; ?> " ><?php echo $promocode_amount; ?>&nbsp;&nbsp;<?php if($promocode_type == 0) { echo "RS";} else { echo "%"; } ?></td>
                
                
                <td style="text-align:center"><?php if($row['createdAt'] != "" && $row['createdAt'] != "0000-00-00 00:00:00" ) { echo date("d-m-Y",strtotime($row['createdAt'])); } else { echo "---"; } ?></td>
                <?php
				   if($row['status'] == 0)
				   {
					  $icon = "error-icon.png";
				   }
				   else
				   {
					  $icon = "success-icon.png";
				   }
				?>
                
                <td style="text-align:center;"><a href="<?php echo Yii::app()->params->base_path;?>admin/changePromoCodeStatus/id/<?php echo $row['promocode_id'];?>/status/<?php echo $row['status']; ?>" title="<?php if(isset($row['status']) && $row['status']  == 1 ) { echo "Active"; } else { echo "Inactive";} ?>"><img src="images/<?php echo $icon; ?>" /></a></td>
                 <td style="text-align:center;">
                    <ul class="table-controls">
                        <li><a href="#" onclick="couponDetailPopup('<?php echo $row['promocode_id'];?>');" class="tip" title="Publish"><i class="fam-zoom"></i></a> </li>
                        <li><a href="<?php echo Yii::app()->params->base_path ;?>admin/editPromoCode/id/<?php echo $row['promocode_id'];?>" class="tip" title="Edit entry"><i class="fam-pencil"></i></a> </li>
                        <li><a href="#" onclick="confirmDelete('<?php echo $row['promocode_id'];?>');" class="tip" title="Remove entry"><i class="fam-cross"></i></a> </li>
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

		</div>