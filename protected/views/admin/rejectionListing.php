<link rel="stylesheet" type="text/css" media="all" href="<?php echo Yii::app()->params->base_url;?>css/jquery.fancybox-1.3.1.css"/>
<script type="text/javascript" src="<?php echo Yii::app()->params->base_url;?>js/jquery.fancybox-1.3.1.js"></script>
<script type="text/javascript">
	
	function rejectionDetailPopup(id)
    {
		
		$.ajax({
			  type: 'POST',
			  url: '<?php echo Yii::app()->params->base_path ;?>admin/rejectionDetail',
			  data: 'id='+id,
			  cache: false,
			  success: function(data)
			  {
				  
				if(data == 0 )
				{
					bootbox.alert("Data not found.");
				}else{
					var str = data ;
					bootbox.modal(str, 'Reject Order Details');
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
<!-- Default form -->


  <div class="widget">
    <div class="navbar">
      <div class="navbar-inner">
        <h6><a href="<?php echo Yii::app()->params->base_path;?>admin/rejectionListing">Rejection List</a>&nbsp;&nbsp;<img src="<?php echo Yii::app()->params->base_url;?>images/path-arrow.png" alt="" border="0" />&nbsp;&nbsp;Rejecton Order</h6><button type="button" onclick="window.location.href='<?php echo Yii::app()->params->base_path ;?>admin/rejectionList'"  class="btn btn-large btn-info" style="float:right;">Create New</button>
      </div>
    </div>
    <div class="well">
     
    
      <table class="table table-striped table-bordered" id="data-table">
      	<thead>
        <tr>
          <th style="text-align:center;">No</th>
          <th style="text-align:center;">Order No</th>
          <th style="text-align:center;">Customer Name</th>
          <th style="text-align:center;">Mobile No</th>
          <th style="text-align:center;">Zone</th>
          <th style="text-align:center;">Total Products</th>
          <th style="text-align:center;">Total Amount</th>
          <th style="text-align:center;">Driver</th>
          <th style="text-align:center;">CraetedAt</th>
          <th style="text-align:center;">Actions</th>
        </tr>
        </thead>
        <?php $i=1;
		//print "<pre>";
		//print_r($poData);
		//exit;
		
		if(count($rejectionData) > 0){
		foreach($rejectionData as $row) { ?>
        
        <tr id="tabletr1">
          <td style="text-align:right;"><?php echo $i; ?></td>
          <td style="text-align:right"><?php echo $row['so_id']; ?></td> 
          <td><?php echo $row['customer_name']; ?></td>
          <td style="text-align:right"><?php echo $row['mobile_no']; ?></td>
          <td><?php echo $row['zoneName']; ?></td>
          <td style="text-align:right"><?php echo $row['total_product']; ?></td>
          <td style="text-align:right"><?php echo $row['total_amount']; ?></td>
          <td style="text-align:right"><?php echo $row['driverFirstName'].' '.$row['driverLastName']; ?></td>
          <td style="text-align:center"><?php echo $row['createdAt']; ?></td>
          <td style="text-align:center">
                    <ul class="table-controls">
                        <li><a href="#" onclick="rejectionDetailPopup('<?php echo $row['rejection_id'];?>');" class="tip" title="View Details"><i class="fam-zoom"></i></a> </li>
                          <li>
                          <?php 
						  $randstr = $row['rejection_id'].'_'.$row['admin_id'];
						  $file = "assets/upload/rejectionSlip/rejectionSlip_".$randstr.".pdf";
						  if(file_exists($file)) {  ?>
                          <a href="<?php echo Yii::app()->params->base_url ;?>assets/upload/rejectionSlip/rejectionSlip_<?php echo $randstr;?>.pdf" id="pdflink_<?php echo $i;?>" class="pdflink tip" title="See rejection order Pdf"><i class="ico-print"></i></a>
                          <?php } ?>
                          </li>
                        </ul>
                </td>
        </tr>
        
       
        <input type="hidden" name="id_<?php echo $i;?>" id="id_<?php echo $i;?>" value="<?php if(isset($row['id']) && $row['id'] != "") { echo $row['id']; } ?>" />
        <?php  $i++; } ?>
         
        <?PHP	}	 ?>
        
      </table>
     
     
    </div>
  </div>

<!-- /default form --> 
