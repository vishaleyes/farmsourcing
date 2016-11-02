<link rel="stylesheet" href="<?php echo Yii::app()->params->base_url; ?>css/pos/pos.css" type="text/css" />

<link rel="stylesheet" href="<?php echo Yii::app()->params->base_url; ?>css/jquery.fancybox-1.3.1.css" type="text/css" />

<div style="width:100%; height:100%; background-color:white;">
	<h1 class="popupTitle" style="background-color:#6AA566;"><?php echo $data['product_name']; ?></h1>
    <ul class="titleList popupTitleList" >
    	<?php /*?><li>
        	<label>Product Name:</label>
        	<span  style="width:230px;"><?php echo $data['product_name']; ?></span><p class="clear"></p>
        </li><?php */?>
		<li>
        	<label>Name:</label>
        	<span  style="width:300px;"><?php echo strip_tags($data['product_desc']); ?></span><p class="clear"></p>
        </li> 
		<li >
        	<label>##_BROWSE_PRODUCT_PRICE_##:</label>
        	<span  style="width:230px;"><?php echo $data['product_price']; ?></span><p class="clear"></p>
        </li> 
		
        <li>
        	<label>Description:</label>
        	<span style="width:170px;"><?php echo $data['product_desc']; ?></span><p class="clear"></p>
        </li> 
		<li>
        	<label>Quantity:</label>
        	<span  style="width:230px;"><?php echo $data['quantity']; ?></span><p class="clear"></p>
        </li> 
		<li>
        	<label>Is Discount?</label>
        	<span style="width:230px;"><?php if(isset($data['is_discount']) && $data['is_discount'] == '0') { echo "No"; } else { echo "Yes"; }  ?></span><p class="clear"></p>
        </li>
        <?php /*?><li>
        	<label>##_PRODUCT_DESC_PAGE_PRODUCT_PICTURE_##:</label>
        	<span style="width:230px;"><img src="<?php echo Yii::app()->params->base_url; ?>assets/upload/product/<?php echo $data['product_image']; ?>" width="200px" height="200px;" style="margin-right:30px;"/></span><p class="clear"></p>
        </li> <?php */?>
    </ul>  
    <div style="float:right; margin-top:-150px;"><li>
        	<!--<label>##_PRODUCT_DESC_PAGE_PRODUCT_PICTURE_##:</label>-->
        	<span style="width:230px;"><img src="<?php echo Yii::app()->params->base_url; ?>assets/upload/product/<?php echo $data['product_image']; ?>" width="250px" height="250px;" style="margin-right:30px;"/></span><p class="clear"></p>
        </li> </div>
</div>



