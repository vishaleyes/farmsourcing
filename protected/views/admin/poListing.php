<link rel="stylesheet" type="text/css" media="all" href="<?php echo Yii::app()->params->base_url;?>css/jquery.fancybox-1.3.1.css"/>
<script type="text/javascript" src="<?php echo Yii::app()->params->base_url;?>js/jquery.fancybox-1.3.1.js"></script>
<script type="text/javascript">
function confirmDelete(id)
{
	bootbox.confirm("Are you sure want to delete this order?", function(confirmed) {
		//console.log("Confirmed: "+confirmed);
		if(confirmed == true)
		{
			window.location.href = "<?php echo Yii::app()->params->base_path;?>admin/deleteVendor/id/"+id;
		}else{
			return true;
		}
	});
	
}

function poDetailPopup(id)
{
	$.ajax({
		  type: 'POST',
		  url: '<?php echo Yii::app()->params->base_path ;?>admin/showPoDetail',
		  data: 'id='+id,
		  cache: false,
		  success: function(data)
		  {
			if(data == 0 )
			{
				bootbox.alert("Data not found.");
			}else{
				var str = data ;
				bootbox.modal(str, 'Purchase Order Details');
			}	
		  }
		 });
}


</script>

<script language="javascript" type="text/javascript">
<!--
$(document).ready(function(){
	
	$(".pdflink").fancybox({
		 'padding'		 : 0,
		 'width' : 850,
 		'height' : 500,
		'autoScale'		: false,
		'transitionIn'	: 'none',
		'transitionOut'	: 'none',
		'titlePosition'	 : 'inside',
		'transitionIn'	 : 'none',
		'transitionOut'	 : 'none',
		'type':'iframe'	
	  
	  });
});


function o(n, i) {
	document.images['thumb'+n].src = '<?php echo $includeurl; ?>dlf/i.php?f='+i<?php if($memorylimit!==false) echo "+'&ml=".$memorylimit."'"; ?>;

}

function f(n) {
	document.images['thumb'+n].src = 'dlf/trans.gif';
}

	



function popitup(url) {
	newwindow=window.open(url,'name','height=400,width=780,scrollbars=yes,screenX=250,screenY=200,top=150');
	if (window.focus) {newwindow.focus()}
	return false;
}
//-->
</script>
<!-- Default datatable -->
<div class="widget">
<div class="navbar"><div class="navbar-inner"><h6>All Purchase Orders</h6><button type="button" onclick="window.location.href='<?php echo Yii::app()->params->base_path;?>admin/customPoGenerate'" class="btn btn-large btn-info" style="float:right;">Create Custom PO</button><button type="button" onclick="window.location.href='<?php echo Yii::app()->params->base_path;?>admin/poGenerate'" class="btn btn-large btn-info" style="float:right;">Create New PO</button></div></div>
<div class="table-overflow">
    <table class="table table-striped table-bordered" id="data-table">
        <thead>
            <tr>
                <th style="text-align:center">No</th>
                <th style="text-align:center">Vendor Name</th>
                <th style="text-align:center">Total Amount</th>
                <th style="text-align:center">SO Delivery Date</th>
                <th style="text-align:center">Status</th>
                <th style="text-align:center">Created By</th>
                <th style="text-align:center">Created At</th>
                <th style="text-align:center" class="actions-column">Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php
			$i=1;
			//$cnt = $data['pagination']->itemCount;
			foreach($data['poList']  as $row){ 
			
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
                <td style=" <?php echo $nameStyle; ?> " ><?php echo $name; ?></td>
                
           		<?php if(trim($row['total_amount']) != "" ) 
					  {
						  $total_amountStyle = "text-align:right";
					 	  $total_amount = $row['total_amount'] ; 
					  } 
					 else { 
					 	  $total_amountStyle = "text-align:center";
					 	  $total_amount = "---" ;
						} 
				?>
                <td style=" <?php echo $total_amountStyle; ?> " ><?php echo $total_amount; ?></td>
                
                <td style="text-align:center"><?php if($row['delivery_date'] != "" && $row['delivery_date'] != "0000-00-00" ) { echo date("d-m-Y",strtotime($row['delivery_date'])); } else { echo "---"; } ?></td>
                
                <td style="text-align:center" ><?php echo $status; ?></td>
                
                <?php if(trim($row['createBy']) != "" ) 
					  {
						  $createByStyle = "";
					 	  $createBy = $row['createBy'] ; 
					  } 
					 else { 
					 	  $createByStyle = "text-align:center";
					 	  $createBy = "---" ;
						} 
				?>
                <td style=" <?php echo $createByStyle; ?> " ><?php echo $createBy; ?></td>
                
                <td style="text-align:center"><?php if($row['createdAt'] != "" && $row['createdAt'] != "0000-00-00 00:00:00" ) { echo date("d-m-Y",strtotime($row['createdAt'])); } else { echo "---"; } ?></td>
              <?php /*?>  <td style="text-align:center"><a href="<?php echo Yii::app()->params->base_path;?>admin/changeUserStatus/id/<?php echo $row['id'];?>" title="<?php echo $title ; ?>"><i class="<?php echo $icon; ?>"></i></a></td><?php */?>
                <td style="text-align:center">
                    <ul class="table-controls">
                        <li><a href="#" onclick="poDetailPopup('<?php echo $row['po_id'];?>');" class="tip" title="View Purchase Order Details"><i class="fam-zoom"></i></a></li>
                        <li><a href="<?php echo Yii::app()->params->base_url ;?>assets/upload/purchaseOrder/purchaseOrder_<?php echo $row['po_id'];?>.pdf" id="pdflink_<?php echo $i;?>" class="pdflink tip" title="See PO Pdf"><i class="ico-print"></i></a></li>
                      <?php 
					  	if($row['status'] == "1") {
					  ?>  
                      <li><a href="<?php echo Yii::app()->params->base_url ;?>assets/upload/goodsReceipt/goodsReceipt_<?php echo $row['po_id'];?>.pdf" id="pdflink_<?php echo $i;?>" class="pdflink tip" title="See Goods Receipt"><i class="ico-print"></i></a></li>
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