<link rel="stylesheet" type="text/css" media="all" href="<?php echo Yii::app()->params->base_url;?>css/jquery.fancybox-1.3.1.css"/>
<script type="text/javascript" src="<?php echo Yii::app()->params->base_url;?>js/jquery.fancybox-1.3.1.js"></script>
<script type="text/javascript">

function confirmDelete(id)
{
	bootbox.confirm("Are you sure want to delete this sales order?", function(confirmed) {
		//console.log("Confirmed: "+confirmed);
		if(confirmed == true)
		{
			window.location.href = "<?php echo Yii::app()->params->base_path;?>admin/deleteSalesOrder/id/"+id;
		}else{
			return true;
		}
	});
	
}
function soDetailPopup(id)
{
	$.ajax({
		  type: 'POST',
		  url: '<?php echo Yii::app()->params->base_path ;?>admin/showSoDetail',
		  data: 'id='+id,
		  cache: false,
		  success: function(data)
		  {
			if(data == 0 )
			{
				bootbox.alert("Data not found.");
			}else{
				var str = data ;
				bootbox.modal(str, 'Sales Order Details');
			}	
		  }
		 });
}

function salesOrderListingWithFilters()
	{
	// var upc_code = $("#upc_code").val();
	 var zone_id = $("#zone_id option:selected").val();
	 var status = $("#status option:selected").val();
	 var type = $("#type option:selected").val();
	 var fromDate = $("#fromDate").val();
	 var toDate = $("#toDate").val();
	 
	 if(zone_id == "" && status == "" && type == "" && fromDate == "" && toDate == "")
	 {
		bootbox.alert("Select atleast one parameter.");
		return false;	 
	 }
	 //alert(zone_id);
	 //alert(status);
	 
	 window.location.href="<?php echo Yii::app()->params->base_path;?>admin/salesOrderListingWithFilters&zone_id="+zone_id+"&status="+status+"&type="+type+"&fromDate="+fromDate+"&toDate="+toDate;
	 
	
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
<div class="navbar"><div class="navbar-inner"><h6>All Sales Orders</h6><button type="button" onclick="window.location.href='<?php echo Yii::app()->params->base_path;?>admin/generateOrder'" class="btn btn-large btn-info" style="float:right;">Create Order</button></div></div>
<table width="80%" id="ordertbl" align="center" border="0" cellspacing="5" cellpadding="5" >
        <tr>
            <td width="15%" align="right" >Zone Name:</td>
            <td width="10%">
            <?php 
                $zoneObj =  new Zone();
                $zoneData  =  $zoneObj->getAllZones();
            ?>
            <div class="control-group">
                <div class="controls">
                <select class="select" name="zone_id" id="zone_id" >
                    <option value="">select zone</option>
                    <?php foreach($zoneData as $row) { ?>
                     <option value="<?php echo $row['zone_id']; ?>" <?php if(isset($ext['zone_id']) && $ext['zone_id'] == $row['zone_id']) { ?> selected="selected" <?php } ?> ><?php echo $row['zoneName']; ?></option>
                     <?php } ?>
                </select>
                </div>             
            </div>
            </td>
            <td  width="15%" align="right"><label class="control-label">Order Status:</label></td>
            <td width="15%">
            	<select class="select" name="status" id="status" >
                    <option value="">select order status</option>
                    <option value="0" <?php if(isset($ext['status']) && $ext['status'] == "0") { ?> selected="selected" <?php } ?> >Pending</option>
                    <option value="1" <?php if(isset($ext['status']) && $ext['status'] == "1") { ?> selected="selected" <?php } ?> >Confirm</option>
                    <option value="2" <?php if(isset($ext['status']) && $ext['status'] == "2") { ?> selected="selected" <?php } ?> >Return</option>
                </select>
            </td>
            <td  width="5%" align="center"><label class="control-label">Type:</label></td>
            <td width="15%">
            	<select class="select" name="type" id="type" >
                    <option value="">select order type</option>
                    <option value="0" <?php if(isset($ext['type']) && $ext['type'] == "0") { ?> selected="selected" <?php } ?> >ADMIN</option>
                    <option value="1" <?php if(isset($ext['type']) && $ext['type'] == "1") { ?> selected="selected" <?php } ?> >TABLET</option>
                    <option value="2" <?php if(isset($ext['type']) && $ext['type'] == "2") { ?> selected="selected" <?php } ?> >WEB</option>
                    <option value="3" <?php if(isset($ext['type']) && $ext['type'] == "3") { ?> selected="selected" <?php } ?> >POS</option>
                </select>
            </td>
            
        </tr>
        <tr>
        	<td  width="10%" align="right"><label class="control-label">From Date :</label></td>
            <td align="center">
                    <input type="text" name="fromDate" id="fromDate" class="input-medium" placeholder="From Date" value="<?php if(isset($ext['fromDate'])){ echo $ext['fromDate']; } ?>" />
            </td>
            <td  width="5%" align="right"><label class="control-label">To Date :</label></td>
            <td align="left">
                    <input type="text" name="toDate" id="toDate" class="input-medium" placeholder="To Date" value="<?php if(isset($ext['toDate'])){ echo $ext['toDate']; } ?>" />
            </td>
            <td align="right" colspan="2">
            	<input type="button" onclick="salesOrderListingWithFilters();" class="btn btn-large btn-success" name="submit" value="Search" />&nbsp;&nbsp;
                <input type="button" onclick="window.location.href='<?php echo Yii::app()->params->base_path;?>admin/salesOrderListing'" class="btn btn-large btn-success" name="submit" value="View All" />
            </td>
            
        </tr>
      </table>
<div class="table-overflow">

    <table class="table table-striped table-bordered" id="data-table">
        <thead>
            <tr>
                <th style="text-align:center">No</th>
                <th style="text-align:center">Order ID</th>
                <th style="text-align:center">Customer Id</th>
                <th style="text-align:center">Customer Name</th>
                <th style="text-align:center">Mobile No</th>
                <th style="text-align:center">Zone</th>
                <th style="text-align:center">Total Amount</th>
                <!--<th style="text-align:center">Created By</th>-->
                <th style="text-align:center">Delivery Date</th>
                <th style="text-align:center">Type</th>
                <th style="text-align:center">Created At</th>
                <th style="text-align:center" class="actions-column">Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php
			$i=1;
			//$cnt = $data['pagination']->itemCount;
			foreach($data['soList']  as $row){ 
			
			if($row['status'] == "0") { 
				$class = "info";
				$status = "Pending" ;
			}else if($row['status'] == "1"){
				$class = "info";
				$status = "Confirm" ;
			}else if($row['status'] == "2"){
				$class = "info";
				$status = "Return" ;
			}else if($row['status'] == "6"){
				$class = "info";
				$status = "Cancel" ;
			}
		?>
            <tr class="<?php echo $class; ?>"  >
                <td style="text-align:right">
					<?php 
						///echo $i+($data['pagination']->getCurrentPage()*$data['pagination']->getLimit());
						echo $i;
					?>
                </td>
                <td style="text-align:right;" ><?php echo $row['so_id']; ?></td>
                <td style="text-align:right;" ><?php echo $row['representativeId']; ?></td>
                
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
                
           
                <?php if(trim($row['mobile_no']) != "" ) 
					  {
						  $mobile_noStyle = "text-align:right";
					 	  $mobile_no = $row['mobile_no'] ; 
					  } 
					 else { 
					 	  $mobile_noStyle = "text-align:center";
					 	  $mobile_no = "---" ;
						} 
				?>
                <td style=" <?php echo $mobile_noStyle; ?> " ><?php echo $mobile_no; ?></td>
                
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
                <td style=" <?php echo $zoneNameStyle; ?> " ><?php echo $zoneName; ?></td>
                
                <?php 
				  if($row['type'] == 3)
				  {
					  $soDescObj = new SoDesc();
					  $totalAmount = $soDescObj->getTotalAmountForSoForPos($row['so_id']);
				  }
				  else
				  {
				
					$soDescObj = new SoDesc();
					$totalAmount = $soDescObj->getTotalAmountForSo($row['so_id']);
				  }
				?>
                <td style="text-align:right;" ><?php echo round($totalAmount,0); ?></td>
                
                <?php /*?><?php if(trim($row['total_item']) != "" ) 
					  {
						  $total_itemStyle = "text-align:right";
					 	  $total_item = $row['total_item'] ; 
					  } 
					 else { 
					 	  $total_itemStyle = "text-align:center";
					 	  $total_item = "---" ;
						} 
				?>
                <td style=" <?php echo $total_itemStyle; ?> " ><?php echo $total_item; ?></td><?php */?>
                
               <?php /*?> <td style="text-align:center" ><?php echo $status; ?></td><?php */?>
                
                <?php /*if(trim($row['createBy']) != "" ) 
					  {
						  $createByStyle = "";
					 	  $createBy = $row['createBy'] ; 
					  } 
					 else { 
					 	  $createByStyle = "text-align:center";
					 	  $createBy = "---" ;
						} */
				?>
               <?php /*?> <td style=" <?php echo $createByStyle; ?> " ><?php echo $createBy; ?></td><?php */?>
                
                <td style="text-align:center"><?php if($row['delivery_date'] != "" && $row['delivery_date'] != "0000-00-00" ) { echo date("d-m-Y",strtotime($row['delivery_date'])); } else { echo "---"; } ?></td>
                
                <td style="text-align:center"><?php  if($row['type'] == 0) { echo "ADMIN"; } else if($row['type'] == 1) { echo "TABLET"; } else if($row['type'] == 2) { echo "WEB"; } else if($row['type'] == 3) { echo "POS"; }  ?></td>
                
                <td style="text-align:center"><?php if($row['createdAt'] != "" && $row['createdAt'] != "0000-00-00" ) { echo date("d-m-Y",strtotime($row['createdAt'])); } else { echo "---"; } ?></td>
              <?php /*?>  <td style="text-align:center"><a href="<?php echo Yii::app()->params->base_path;?>admin/changeUserStatus/id/<?php echo $row['id'];?>" title="<?php echo $title ; ?>"><i class="<?php echo $icon; ?>"></i></a></td><?php */?>
                <td style="text-align:center">
                    <ul class="table-controls">
                        <li><a href="#" onclick="soDetailPopup('<?php echo $row['so_id'];?>');" class="tip" title="View Sales Order Details"><i class="fam-zoom"></i></a></li>
                <?php if($row['isPoGenerate'] == 0) { ?>
                        <li><a href="<?php echo Yii::app()->params->base_path ;?>admin/editSalesOrder/so_id/<?php echo $row['so_id'];?>" class="tip" title="Edit"><i class="fam-pencil"></i></a></li>
                        <li><a href="#" onclick="confirmDelete('<?php echo $row['so_id'];?>');" class="tip" title="Remove Sales Order"><i class="fam-cross"></i></a></li>
                        
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