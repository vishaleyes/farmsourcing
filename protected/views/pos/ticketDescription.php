<link rel="stylesheet" href="<?php echo Yii::app()->params->base_url; ?>css/pos/pos.css" type="text/css" />

<link rel="stylesheet" href="<?php echo Yii::app()->params->base_url; ?>css/jquery.fancybox-1.3.1.css" type="text/css" />




<script type="text/javascript">
var $j = jQuery.noConflict();
$j(document).ready(function() {
	
	$j("#editToDo").fancybox(
	{	
		'titlePosition'	 : 'inside',
		'transitionIn'	 : 'none',
		'transitionOut'	 : 'none',		
		'width' : 600,
 		'height' : 400
	});
	
	
	$j('#submit').click(function() {
		var postData	=	$j("#comments").serialize();
		$j.ajax({
			type: "POST",
			url: '<?php echo Yii::app()->params->base_path; ?>user/addComments' ,
			data: postData,
			success: function(response) {
				if(response == 'success'){
					$j('#commentDiv').load("<?php echo Yii::app()->params->base_path;?>user/getComments/id/<?php echo $data[0]['invoiceId'];?>");
					document.getElementById("commentText").value = "";
				}
			}
			
		});
	});
});

</script>
<div style="width:95%; height:100%;">
<?php // echo "<pre>"; print_r($data); print_r($productData); exit; ?>
<?php if(Yii::app()->user->hasFlash('success')): ?>                                
    <div id="msgbox" class="clearmsg"> <?php echo Yii::app()->user->getFlash('success'); ?></div>
    <div class="clear"></div>
<?php endif; ?>
<?php if(Yii::app()->user->hasFlash('error')): ?>
    <div id="msgbox" class="clearmsg errormsg"> <?php echo Yii::app()->user->getFlash('error'); ?></div>
    <div class="clear"></div>
<?php endif; ?>
	<h1 class="popupTitle" style="background-color:#6AA566;">##_Ticket_DESC_PAGE_TICKET_DETAILS_##</h1>
    <ul class="titleList popupTitleList">
    	<li>
        	<label>Sales Order No:</label>
        	<span><?php echo $data['so_id']; ?></span><p class="clear"></p>
        </li>
        <li>
        	<label>Customer Name:</label>
        	<span><?php echo $data['customer_name']; ?></span><p class="clear"></p>
        </li>
		<li>
        	<label>Cashier:</label>
        	<span><?php echo $data['createBy']; ?></span><p class="clear"></p>
        </li> 
		<li>
        	<label>##_Ticket_DESC_PAGE_TOTAL_ITEM_##:</label>
        	<span><?php echo $data['total_item']; ?></span><p class="clear"></p>
        </li> 
        <li>
        	<label>Delivery Date:</label>
        	<span><?php if($data['delivery_date'] == "") { $data['delivery_date'] == 0 ;} echo $data['delivery_date']; ?></span><p class="clear"></p>
        </li>
        
		<li>
        	<label>##_Ticket_DESC_PAGE_CREATED_DATE_##:</label>
        	<span><?php echo $data['createdAt']; ?></span><p class="clear"></p>
        </li> 
	</ul>  
    <table width="100%" border="1" cellpadding="5"  cellspacing="0">
		  <tr height="30" align="center" valign="middle">
			<td width="55%"><strong style="color:#666666;">##_BROWSE_PRODUCT_PRODUCT_NAME_##</strong></td>
			<td width="20%"><strong style="color:#666666;">##_Ticket_DESC_PAGE_UNIT_PRICE_##</strong></td>
            <td width="10%"><strong style="color:#666666;">WEIGHT</strong></td>
			<td width="15%"><strong style="color:#666666;">##_Ticket_DESC_PAGE_TOTAL_##</strong></td>
		  </tr>
         <?php $total = 0;foreach($productData as $row) { ?>
		  <tr style="color:#666666;">
			
			<td align="left"><?php echo $row['product_name'] ;?></td>
			<td align="right"><?php echo $row['product_price'] ?></td>
            <td align="right"><?php echo $row['quantity'] ?></td>
			<td align="right"><?php echo $row['quantity'] * $row['product_price']; ?></td>
		  </tr>
        <?php $total +=  $row['quantity'] * $row['product_price'];}
		 ?>
         <tr>
         	<td colspan="3" align="right">DISCOUNT(-)</td>
            <td align="right"><?php echo $data['discount_amount']; ?></td>
         </tr>
         <tr>
         	<td colspan="3" align="right">TOTAL AMOUNT</td>
            <td align="right"><?php echo ($total - $data['discount_amount']) ; ?></td>
         </tr>
	</table> 
</div>