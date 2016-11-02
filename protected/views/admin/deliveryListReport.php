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

<form id="validate"  action="<?php echo Yii::app()->params->base_path;?>admin/generateOrder" method="post" enctype="multipart/form-data">
  <div class="widget">
    <div class="navbar">
      <div class="navbar-inner">
        <h6>Delivery Slips List</h6>
        <?php /*?><button type="button" onclick="window.location.href='<?php echo Yii::app()->params->base_path;?>admin/deliverySlip'" class="btn btn-large btn-info" style="float:right;">Create Delivery Slip</button><?php */?>
      </div>
    </div>
    <div class="well">
      <table width="90%" id="ordertbl" align="center" border="0" cellspacing="5" cellpadding="5" >
         
          <tr>
          <td width="21%" align="right" >Driver Name:</td>
          <td width="40%">
			<?php 
                $adminObj =  new Admin();
				$driverData  =  $adminObj->getAllDrviers();
            ?>
			

            <div class="control-group">
                <div class="controls">
                <select class="select" name="driver_id" id="driver_id" onchange="getReportListing();">
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
        
        	
        </tr>
        
        
      </table>
  <div class="table-overflow">  
       <table class="table table-striped table-bordered" id="data-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Order ID</th>
                <th>Cust ID</th>
                <th>Customer Name</th>
                <th>Address</th>
                <th>No of packets</th>
                <th>Todays Amount</th>
                <th>Delivery Date</th>
                <th>Action</th>
               
            </tr>
        </thead>
        <tbody>


        <?php $i=1;
		
		foreach($data['deliveryList'] as $row) { ?>
        
        <tr id="tabletr1">
          <td style="text-align:right;"><?php echo $i; ?></td>
           <td style="text-align:right;"><?php echo $row['so_id']; ?></td>
         <td style="text-align:right;"><?php echo $row['representativeId']; ?></td>
         <td><?php echo $row['customer_name']; ?></td>
         <td><?php echo $row['address']; ?></td>
         <td style="text-align:right;"><?php echo $row['no_of_packets']; ?></td>
         <td style="text-align:right;"><?php echo ($row['so_amount'] - $row['coupon_amount'] ); ?></td>
         <td style="text-align:center;" width="15%"><?php echo $row['delivery_date']; ?></td>
         <td style="text-align:center;">
          
          <?php
		  $str = $row['so_id'].'_'. $row['admin_id'];
		  $file  =  'assets/upload/deliverySlip/deliverySlip_'.$str.'.pdf';
		  if(file_exists($file)) {  ?>
          <a href="<?php echo Yii::app()->params->base_url ;?>assets/upload/deliverySlip/deliverySlip_<?php echo $str;?>.pdf" id="pdflink_<?php echo $i;?>" class="pdflink tip" title="See Delivery Slip Pdf"><i class="ico-print"></i></a>
          <?php } ?>
          </td>
         
         
        </tr>
        <?php  $i++; }	 ?>
        </tbody>
    </table>
     </div> 
      <input type="hidden" name="count" id="count" value="1" />
      <p>&nbsp;</p>
      
    </div>
  </div>
</form>
<!-- /default form --> 
