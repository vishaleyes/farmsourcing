<link rel="stylesheet" type="text/css" media="all" href="<?php echo Yii::app()->params->base_url;?>css/jquery.fancybox-1.3.1.css"/>
<script type="text/javascript" src="<?php echo Yii::app()->params->base_url;?>js/jquery.fancybox-1.3.1.js"></script>
<script type="text/javascript">
	
	function getReportListing()
	{
	// var upc_code = $("#upc_code").val();
	 var driver_id = $("#driver_id option:selected").val();
	 var delivery_date = $("#fromDate").val();
	 
	 //alert(driver_id);
	 //alert(delivery_date);
	 
	 window.location.href="<?php echo Yii::app()->params->base_path;?>admin/deliveryListing&driver_id="+driver_id+"&delivery_date="+delivery_date;
	 
	
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

<form id="validate"  action="<?php echo Yii::app()->params->base_path;?>admin/raiseDeliveryReport" method="post" enctype="multipart/form-data">
  <div class="widget">
    <div class="navbar">
      <div class="navbar-inner">
        <h6>Delivery List</h6>
        <button type="button" onclick="window.location.href='<?php echo Yii::app()->params->base_path;?>admin/regenerateDeliverySlip'" class="btn btn-large btn-info" style="float:right;">Regenerate Delivery Slip</button>
        <button type="button" onclick="window.location.href='<?php echo Yii::app()->params->base_path;?>admin/deliverySlip'" class="btn btn-large btn-info" style="float:right;">Create New Delivery Slip</button>
      </div>
    </div>
    <div class="well">
     <?php /*?> <table width="90%" id="ordertbl" align="center" border="0" cellspacing="5" cellpadding="5" >
         
          <tr>
          <td width="21%" align="right" >Driver Name:</td>
          <td width="40%">
			<?php 
                $adminObj =  new Admin();
				$driverData  =  $adminObj->getAllDrviers();
            ?>
			

            <div class="control-group">
                <div class="controls">
                <select class="select" name="driver_id" id="driver_id" >
         			<option value="">select driver</option>
					<?php foreach($driverData as $row) { ?>
                    
                     <option value="<?php echo $row['id']; ?>" <?php if(isset($driver_id) && $driver_id == $row['id']) { ?> selected="selected" <?php } ?> ><?php echo $row['firstName'].' '.$row['lastName']; ?></option>
                    
                     
                     <?php } ?>
         	 	</select>
                </div>             
            </div>
           </td>
         <td align="right"><label class="control-label">Date:</label></td>
         <td width="20%">
          	<ul class="">
                <li><input type="text" id="fromDate" name="delivery_date" class="validate[required]" placeholder="select delivery date" value=" <?php if(isset($delivery_date) && $driver_id != "") { echo $delivery_date ; } ?>" /></li>
            </ul>
          </td>
        
        	<td><input type="submit" name="submit" class="btn btn-large btn-success"  value="Generate Delivery List" /></td>
        </tr>
        
        
      </table><?php */?>
      
      <table class="table table-striped table-bordered" id="data-table">
        <thead>
            <tr>
                <th style="text-align:center;">No</th>
                <th style="text-align:center;">Delivery ID</th>
                <th style="text-align:center;">Driver Name</th>
                <th style="text-align:center;">Cash Amount</th>
                <!--<th style="text-align:center;">Coupon Amount</th>-->
                <th style="text-align:center;">Delivery Date</th>
                <th style="text-align:center;">Created At</th>
                <th style="text-align:center;">Actions</th>
               
            </tr>
        </thead>
        <tbody>
<?php 
		$vendorObj = new Vendor();
		$vendorList = $vendorObj->getAllVendors();
?>

        <?php $i=1;
		
		foreach($deliveryData as $row) { 
		$str = date("Y_m_d",strtotime($row['delivery_date'])).'_'.$row['driver_id'];
		?>
        
        <tr id="tabletr1">
          <td style="text-align:center;"><?php echo $i; ?></td>
          <td style="text-align:right;"><?php echo $row['delivery_id']; ?></td>
          <td><?php echo $row['driverName']; ?></td>
          <td style="text-align:right;"><?php echo $row['cash_amount']; ?></td>
          <?php /*?><td style="text-align:right;"><?php echo $row['coupon_amount']; ?></td><?php */?>
          
          <td style="text-align:center;"><?php echo $row['delivery_date']; ?></td>
          
          <td style="text-align:center;"><?php echo $row['createdAt']; ?></td>
          <td style="text-align:center;">
          
          <?php 
		  $file  =  'assets/upload/deliveryReports/deliveryReport_'.$str.'.pdf';
		  if(file_exists($file)) {  ?>
          <a href="<?php echo Yii::app()->params->base_url ;?>assets/upload/deliveryReports/deliveryReport_<?php echo $str;?>.pdf" id="pdflink_<?php echo $i;?>" class="pdflink tip" title="See Delivery Report Pdf"><i class="ico-print"></i></a>
          <?php } ?>
          
          <?php 
		  
		   $file  =  'assets/upload/collectionReports/collectionReport_'.$str.'.pdf';
          	if(file_exists($file)) { 
		  ?>
		  <a href="<?php echo Yii::app()->params->base_url ;?>assets/upload/collectionReports/collectionReport_<?php echo $str;?>.pdf" id="pdflink_<?php echo $i;?>" class="pdflink tip" title="See Collection Report Pdf"><i class="ico-print"></i></a>
          
          <?php } ?>
          
          <?php 
		  
		   $file  =  'assets/upload/AlldeliverySlips/AlldeliverySlip_'.$str.'.pdf';
          	if(file_exists($file)) { 
		  ?>
		  <a href="<?php echo Yii::app()->params->base_url ;?>assets/upload/AlldeliverySlips/AlldeliverySlip_<?php echo $str;?>.pdf" id="pdflink_<?php echo $i;?>" class="pdflink tip" title="See All Delivery Slips Pdf"><i class="ico-print"></i></a>
          
          <?php } ?>
          </td>
        </tr>
        <?php  $i++; }	 ?>
        </tbody>
    </table>
    
      <input type="hidden" name="count" id="count" value="1" />
      <p>&nbsp;</p>
      
    </div>
  </div>
</form>
<!-- /default form --> 
