<script type="text/javascript">
function confirmDelete(id)
{
	bootbox.confirm("Are you sure want to delete??", function(confirmed) {
		//console.log("Confirmed: "+confirmed);
		if(confirmed == true)
		{
			window.location.href = "<?php echo Yii::app()->params->base_path;?>admin/deleteCoupon/id/"+id;
		}else{
			return true;
		}
	});
	
}

function couponDetailPopup(id)
{
	$.ajax({
		  type: 'POST',
		  url: '<?php echo Yii::app()->params->base_path ;?>admin/showCouponDetail',
		  data: 'id='+id,
		  cache: false,
		  success: function(data)
		  {
			
			if(data == 0 )
			{
				bootbox.alert("Data not found.");
			}else{
				var str = data ;
				bootbox.modal(str, 'Coupon Details');
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
				    	<h5>Coupons</h5>
				    </div>
			    </div>
			    
   	<div class="widget">
        <div class="well body">
            <div class="controls">
                <ul class="nav nav-pills">
                    <li class="active"><a href="<?php echo Yii::app()->params->base_path ;?>admin/couponAllocationEntry"><i class="icon-plus"></i>Coupon Allocation</a></li>
                    <li class="active" style="margin-left:20px;"><a href="<?php echo Yii::app()->params->base_path ;?>admin/couponReturnEntry"><i class="icon-plus"></i>Coupon Return</a></li>
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
                <th style="text-align:center">Customer Name</th>
                <th style="text-align:center">Coupon Code</th>
                <!--<th style="text-align:center">Discount Type</th>-->
                <th style="text-align:center">Amount</th>
                <th style="text-align:center">Created At</th>
                <th style="text-align:center">Status</th>
                <th style="text-align:center" class="actions-column">Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php
			$i=1;
			//$cnt = $data['pagination']->itemCount;
			
			foreach($couponData  as $row){ 
			
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
                
                <?php if(trim($row['customer_name']) != "" ) 
					  {
						  $nameStyle = "";
					 	  $name = $row['customer_name'] ; 
					  } 
					 else { 
					 	  $nameStyle = "text-align:center";
					 	  $name = "---" ;
						} 
				?>
                <td style=" <?php echo $nameStyle; ?> " ><?php echo $name; ?></td>
                
                <?php if(trim($row['coupon_number']) != "" ) 
					  {
						  $total_amountStyle = "text-align:right";
					 	  $coupon_number = $row['coupon_number'] ; 
					  } 
					 else { 
					 	  $total_amountStyle = "text-align:center";
					 	  $coupon_number = "---" ;
						} 
				?>
                <td style=" <?php echo $coupon_number; ?> " ><?php echo $coupon_number; ?></td>
                
           		<?php /*?><?php if(trim($row['coupon_type']) != "" ) 
					  {
						  $total_amountStyle = "text-align:right";
					 	  $coupon_type = $row['coupon_type'] ; 
					  } 
					 else { 
					 	  $total_amountStyle = "text-align:center";
					 	  $coupon_type = "---" ;
						} 
				?>
                <td style=" <?php echo $coupon_type; ?> " ><?php if($coupon_type == 0) { echo "RS";} else { echo "%"; } ?></td><?php */?>
                
               
                <?php if(trim($row['coupon_amount']) != "" ) 
					  {
						  $total_amountStyle = "text-align:right";
					 	  $coupon_amount = $row['coupon_amount'] ; 
					  } 
					 else { 
					 	  $total_amountStyle = "text-align:center";
					 	  $coupon_amount = "---" ;
						} 
				?>
                <td style=" <?php echo $total_amountStyle; ?> " ><?php echo $coupon_amount; ?><?php /*?>&nbsp;&nbsp;<?php if($coupon_type == 0) { echo "RS";} else { echo "%"; } ?><?php */?></td>
                
                
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
                
                <td style="text-align:center;"><a href="<?php echo Yii::app()->params->base_path;?>admin/changeCouponStatus/id/<?php echo $row['id'];?>/status/<?php echo $row['status']; ?>" title="<?php if(isset($row['status']) && $row['status']  == 1 ) { echo "Active"; } else { echo "Inactive";} ?>"><img src="images/<?php echo $icon; ?>" /></a></td>
                 <td style="text-align:center;">
                    <ul class="table-controls">
                        <li><a href="#" onclick="couponDetailPopup('<?php echo $row['id'];?>');" class="tip" title="Publish"><i class="fam-zoom"></i></a> </li>
                        <li><a href="<?php echo Yii::app()->params->base_path ;?>admin/editCoupon/id/<?php echo $row['id'];?>" class="tip" title="Edit entry"><i class="fam-pencil"></i></a> </li>
                        <li><a href="#" onclick="confirmDelete('<?php echo $row['id'];?>');" class="tip" title="Remove entry"><i class="fam-cross"></i></a> </li>
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