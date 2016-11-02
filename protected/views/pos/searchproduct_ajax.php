<script type="text/javascript">
 $j("#viewMore").fancybox({
	  'width' : 800,
	   'height' : 450,
	   'transitionIn' : 'none',
	  'transitionOut' : 'none',
	  'type':'iframe'
	  
	  });
	  
	$j("#viewProduct").fancybox({
	  'width' : 800,
	   'height' : 450,
	   'transitionIn' : 'none',
	  'transitionOut' : 'none',
	  'type':'iframe'
	  
	  });	
</script>

<script type="text/javascript">
	
	
	function getSearch(test)
	{
		var keyword = $j("#keyword").val();
		
		
		$j.ajax({
	
			type: 'POST',
	
			url: '<?php echo Yii::app()->params->base_path;?>pos/SearchProductAjax/',
	
			data: 'keyword='+keyword,
	
			cache: false,
	
			success: function(data)
			{
				$j(".browsebox").html('');
				$j(".browsebox").html(data);
				
				setTimeout(function() { $j("#update-message").fadeOut();}, 10000 );
	
			}
		});
	}
	
	 
</script>

<div class="browsebox" style="min-height:0px !important;">
             <table width="100%" border="0" cellspacing="0" cellpadding="0" id="browsedata" class="browsedata">
                                <?php if(!empty($res['listing'])) { ?>
								<?php $ids = array() ;  
                                	foreach($productData as $pData ){ ?>
                                <?php $ids[] = $pData['product_id'] ; ?>
                                <?php  } // echo "<pre>"; print_r($ids); exit;?>
								<?php foreach($res['listing'] as $row ){ 
								
								/*if($row['cat_is_discount'] == 1)
								{
									if($row['is_discount'] == 1)
									{
										if($row['cat_discount'] > $row['discount'])
										{
											$discount = $row['cat_discount'];
											$fromDate = $row['cat_discount_from'];
											$toDate = $row['cat_discount_to'];	
										}else{
											$discount = $row['discount'];
											$fromDate = $row['discount_from'];
											$toDate = $row['discount_to'];
										}
									}else{
										$discount = $row['cat_discount'];
										$fromDate = $row['cat_discount_from'];
										$toDate = $row['cat_discount_to'];
									}
								}else{
									if($row['is_discount'] == 1)
									{
										$discount = $row['discount'];
										$fromDate = $row['discount_from'];
										$toDate = $row['discount_to'];
									}else{
										$discount = "";
										$fromDate = "";
										$toDate = "";
									}
								}
								if($discount != "")
								{
									$todayDate = date("Y-m-d");
									
									if($todayDate >= $fromDate && $todayDate <= $toDate)
									{
										$finalProductAmount = round($row['product_price'] - ($row['product_price'] * $discount / 100));
										$row['product_price'] = $finalProductAmount;
									}else{
										$finalProductAmount = $row['product_price'];
										$row['product_price'] = $finalProductAmount;
									}
								}else{
										$finalProductAmount = $row['product_price'];
										$row['product_price'] = $finalProductAmount;
								}*/
								
								?>
 <tr id="demo" style="cursor:pointer;">
        <td width="5%">&nbsp;</td>
        <td  onclick="getProductDetail(<?php echo $row['product_id'] ; ?>);" width="65%"><?php echo $row['product_name'] ; ?></td>
        <?php /*?><td width="10%"><?php echo $row['product_discount'] ; ?></td><?php */?>
        <td width="25%"  colspan="2" align="right";>
        <?php echo $row['product_price'] ; ?></td>
         <input id="product_price_<?php echo $row['product_id']; ?>" type="hidden" value="<?php echo $row['product_price'] ?>" />
         <input id="product_id<?php echo $row['product_id'] ?>" type="hidden" value="<?php echo $row['product_id'] ?>" />
  <?php if(!in_array($row['product_id'],$ids)) {  ?>
        <td width="10%" id="selectbtn<?php echo $row['product_id'] ?>" class="last" onclick="checkStockDetailFromStock('<?php echo trim(htmlspecialchars($row['product_name'])) ; ?>','<?php echo $row['product_id'] ?>','<?php echo $row['product_image'] ?>','<?php echo $row['unit_name'] ?>');"><img src="images/mark-true1.gif"/></td>
        <?php } else { ?>
        <td width="25%" id="selectbtn<?php echo $row['product_id'] ?>" class="last" style="background-color:gray;" ><img src="images/mark-true1.gif"/></td>
        <?php } ?>
    </tr>
<?php } ?>
   <?php } else { ?>
    <tr>
    <td colspan="4">##_BROWSE_PRODUCT_NO_PRODUCT_AVAILABLE_##</td>
    </tr>
    <?php } ?>
                                 <?php
            if(!empty($res['pagination']) && $res['pagination']->getItemCount()  > $res['pagination']->getLimit()){?>
                 <div class="pagination"  style="margin-right:0px;">
                    <?php
                    $extraPaginationPara='&cat_id='.$cat_id;
                    $this->widget('application.extensions.WebPager', 
                                    array('cssFile'=>true,
                                             'pages' => $res['pagination'],
                                             'id'=>'link_pager',
											 'extraPara'=>$extraPaginationPara
                    )); ?>
                </div>
                <?php
            } ?>
          <script type="text/javascript">
        $j(document).ready(function(){
            $j('#link_pager a').each(function(){
                $j(this).click(function(ev){
                    ev.preventDefault();
                    $j.get(this.href,{ajax:true},function(html){
                        $j('.browsebox').html(html);
                    });
                });
            });
        });
    </script>
    </table>
    		 
</div>
