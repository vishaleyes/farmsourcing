<?php
$extraPaginationPara='&keyword='.$ext['keyword'].'&sortType='.$ext['sortType'].'&sortBy='.$ext['sortBy'];
?>
<link href="<?php echo Yii::app()->params->base_url; ?>css/style_home.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
$j(document).ready(function() {
	
	$j(".viewMore").fancybox({
		'width' : 700,
 		'height' : 600,
 		'transitionIn' : 'none',
		'transitionOut' : 'none',
		'type':'iframe'
		
 	});
	
	  $j('.sort').click(function() {
                var url	=	$j(this).attr('lang');
                loadBoxContent('<?php echo Yii::app()->params->base_path;?>'+url+'<?php echo  $extraPaginationPara;?>','firstcont');
	  });
});
	
function getSearch()
{
	var keyword = $j("#keyword").val();
	var searchFrom = $j("#searchFrom").val();
	var searchTo = $j("#searchTo").val();
	
	$j.ajax({
		type: 'POST',
		url: '<?php echo Yii::app()->params->base_path;?>pos/productList',
		data: 'keyword='+keyword+'&searchFrom='+searchFrom+'&searchTo='+searchTo+"&",
		cache: false,
		success: function(data)
		{
			$j("#firstcont").html(data);
			$j("#keyword").val(keyword);
			setTimeout(function() { $j("#update-message").fadeOut();}, 10000 );
		}
	});
}

function getAllSearch()
{
	$j.ajax({
		type: 'POST',
		url: '<?php echo Yii::app()->params->base_path;?>pos/productList',
		data: '',
		cache: false,
		success: function(data)
		{
			$j("#firstcont").html(data);
		}
	});
}


</script>
<div class="mainContainer">
<div class="" id="mainContainer" style="margin-left:0px; margin-right:0px;">
<div class="RightSide" style="margin:0 !important;">
	<div class="clear"></div>
                <div class="heading">Home</div>
    <span id="loading"></span>
    <div class="productboxgreen">
	<h1 style="color:#333333;">##_PRODUCT_LIST_PAGE_PRODUCT_LIST_##</h1>
        <div class="clear"></div>
    <div class="searchArea innerSearch" style="padding-right:50px;">
        <form id="jobSearch" name="jobSearch" action="#" method="post" onsubmit="return false;">        
        	<label style="float:left;margin-right:5px;margin-top:5px;font-size:12px; padding-left: 25px;"><b>##_BROWSE_PRODUCT_PRICE_##</b></label>  	<label class="label floatLeft" style="font-size:12px;">##_TICKET_LIST_FROM_##</label>
    		<select id="searchFrom" style="width:100px;float:left;" name="searchFrom">           	
            	<option value="">##_TICKET_LIST_SELECT_##</option>  
                <option <?php if(isset($ext['searchFrom']) && $ext['searchFrom'] == "10"){ ?> selected="selected" <?php } ?> value="10">10</option>         	            	
            	<option <?php if(isset($ext['searchFrom']) && $ext['searchFrom'] == "100"){ ?> selected="selected" <?php } ?> value="100">100</option>           	
            	<option <?php if(isset($ext['searchFrom']) && $ext['searchFrom'] == "5000"){ ?> selected="selected" <?php } ?> value="5000">5000</option>
                <option <?php if(isset($ext['searchFrom']) && $ext['searchFrom'] == "10000"){ ?> selected="selected" <?php } ?> value="10000">10000</option>
            </select>
        	<label class="label floatLeft" style="font-size:12px;">##_TICKET_LIST_TO_##</label>
    		<select id="searchTo" style="width:100px;float:left;" name="searchTo">            	
            	<option value="">##_TICKET_LIST_SELECT_##</option>           	
            	<option <?php if(isset($ext['searchTo']) && $ext['searchTo'] == "100"){ ?> selected="selected" <?php } ?> value="100">100</option>           	
            	<option <?php if(isset($ext['searchTo']) && $ext['searchTo'] == "5000"){ ?> selected="selected" <?php } ?> value="5000">5000</option>
                <option <?php if(isset($ext['searchTo']) && $ext['searchTo'] == "10000"){ ?> selected="selected" <?php } ?> value="10000">10000</option>
            </select>
           <label class="label floatLeft" style="font-size:12px; padding: 0 5px !important;
}">##_BROWSE_PRODUCT_PRODUCTS_##</label>
            <input type="text" class="textbox floatLeft" name="keyword"  onkeypress="if(event.keyCode==13){getSearch();}" id="keyword" autocomplete="off" style="width:225px !important;" />
            <input type="button" name="searchBtn" class="searchBtn" value="" onclick="getSearch();" />
            <input type="button"  name="" value="##_ADMIN_SHOWALL_##"  onclick="getAllSearch();"  class="btn"  />
        </form>
        
        <div class="clear"></div>
	 </div>
   <table cellpadding="0" cellspacing="0" border="0" class="productdata"  id="list" style="background-color:#FFF;" width="100%">
   
    	<tr style="font-size:14px; font-stretch:normal;">
        	<th width="15%"  style="border-bottom:1px solid #EEEEEE; border-right:1px solid #EEEEEE;">
            	<a href="javascript:;" class="sort" lang='<?php Yii::app()->params->base_path;?>pos/productList/sortType/<?php echo $ext['sortType'];?>/sortBy/product_id' >
                Product Code
				<?php 
				if($ext['img_name'] != '' && $ext['sortBy'] == 'product_id'){ ?>
					<img src="<?php echo Yii::app()->params->base_url;?>images/<?php echo $ext['img_name'];?>" class="sortImage" />
					<?php
				} ?>
                </a>
            </th>
    		<th width="35%"  style="border-bottom:1px solid #EEEEEE; border-right:1px solid #EEEEEE;"> 
            	 
                <a href="javascript:;" class="sort" lang='<?php Yii::app()->params->base_path;?>pos/productList/sortType/<?php echo $ext['sortType'];?>/sortBy/product_name' >
                ##_BROWSE_PRODUCT_PRODUCT_NAME_##
				<?php 
				if($ext['img_name'] != '' && $ext['sortBy'] == 'product_name'){ ?>
					<img src="<?php echo Yii::app()->params->base_url;?>images/<?php echo $ext['img_name'];?>" class="sortImage" />
					<?php
				} ?>
                </a>
            </th>
            
            <?php /*?><th width="29%">
            	<a href="javascript:;" class="sort" lang='<?php Yii::app()->params->base_path;?>pos/productList/sortType/<?php echo $ext['sortType'];?>/sortBy/product_desc' >
                Product Description
				<?php 
				if($ext['img_name'] != '' && $ext['sortBy'] == 'product_desc'){ ?>
					<img src="<?php echo Yii::app()->params->base_url;?>images/<?php echo $ext['img_name'];?>" class="sortImage" />
					<?php
				} ?>
                </a>
            </th><?php */?>
            <th width="16%"  style="border-bottom:1px solid #EEEEEE; border-right:1px solid #EEEEEE;">
            	<a href="javascript:;" class="sort" lang='<?php  Yii::app()->params->base_path;?>pos/productList/sortType/<?php echo $ext['sortType'];?>/sortBy/product_price' >
                ##_BROWSE_PRODUCT_PRICE_##
				<?php 
				if($ext['img_name'] != '' && $ext['sortBy'] == 'product_price'){ ?>
					<img src="<?php echo Yii::app()->params->base_url;?>images/<?php echo $ext['img_name'];?>" class="sortImage" />
					<?php
				} ?>
                </a>
            </th>
            <th width="20%"  style="border-bottom:1px solid #EEEEEE; border-right:1px solid #EEEEEE;">
            	<a href="javascript:;" class="sort" lang='<?php Yii::app()->params->base_path;?>pos/productList/sortType/<?php echo $ext['sortType'];?>/sortBy/quantity' >
                ##_BROWSE_PRODUCT_QUANTITY_##
				<?php 
				if($ext['img_name'] != '' && $ext['sortBy'] == 'quantity'){ ?>
					<img src="<?php echo Yii::app()->params->base_url;?>images/<?php echo $ext['img_name'];?>" class="sortImage" />
					<?php
				} ?>
                </a>
            </th>
            
            <?php /*?><th width="13%">
            	<a href="javascript:;" class="sort" lang='<?php Yii::app()->params->base_path;?>pos/productList/sortType/<?php echo $ext['sortType'];?>/sortBy/manufacturing_date' >
                Manufactured Date
				<?php 
				if($ext['img_name'] != '' && $ext['sortBy'] == 'manufacturing_date'){ ?>
					<img src="<?php echo Yii::app()->params->base_url;?>images/<?php echo $ext['img_name'];?>" class="sortImage" />
					<?php
				} ?>
                </a>
             </th><?php */?>
           <?php /*?> <th width="13%">
            	<a href="javascript:;" class="sort" lang='<?php Yii::app()->params->base_path;?>pos/productList/sortType/<?php echo $ext['sortType'];?>/sortBy/expiry_date' >
                Expiry Date
				<?php 
				if($ext['img_name'] != '' && $ext['sortBy'] == 'expiry_date'){ ?>
					<img src="<?php echo Yii::app()->params->base_url;?>images/<?php echo $ext['img_name'];?>" class="sortImage" />
					<?php
				} ?>
                </a>
             </th><?php */?>
            <th width="9%" class="lastcolumn"  style="border-bottom:1px solid #EEEEEE; border-right:1px solid #EEEEEE;">##_TICKET_LIST_ACTION_##</th>
		</tr>
        <?php  
		if(count($data) > 0){ $i=0;
			foreach($data as $row){ ?> 
            <tr style="font-size:14px; font-stretch:normal;">
            	<td class="" align="right">
                	<?php echo $row['product_id'];?>
                </td>
            	<td class="" align="left">
                <a href="#" onClick="loadBoxContent('<?php echo Yii::app()->params->base_path ; ?>pos/ticketListForProduct/product_id/<?php echo $row['product_id'] ?>/product_name/<?php echo $row['product_name'] ?>','firstcont')">
                	 <?php echo $row['product_name']; ?>
                </a>
				</td>
                
				<?php /*?><td class="">
                	<span><?php echo substr(strip_tags($row['product_desc']),0,50); ?></span>
				</td>	<?php */?>			
                <td class="" align="right">
                	<?php echo $row['product_price'];?>
                </td>				
                <td class="" align="right">
                <a href="#" onClick="loadBoxContent('<?php echo Yii::app()->params->base_path ; ?>pos/quantityDetailForProduct/product_id/<?php echo $row['product_id'] ?>/product_name/<?php echo $row['product_name'] ?>','firstcont')">
                	<?php echo $row['quantity'];?>
                </a>
                </td>				
                
                <?php /*?><td class="alignCenter">
                	<?php if(isset($row['manufacturing_date']) && $row['manufacturing_date']!=''){echo $row['manufacturing_date'];}else{echo "&nbsp";}?>
                </td><?php */?>
                <?php /*?><td class="alignCenter">
                	<?php if(isset($row['expiry_date']) && $row['expiry_date']!=''){echo $row['expiry_date'];}else{echo "&nbsp";}?>
                </td><?php */?>
                <td class=""  align="center">
                	<a href="<?php echo Yii::app()->params->base_path;?>pos/productDescriptionFromProductList/id/<?php echo $row['product_id'];?>" lang="<?php echo $row['product_id'];?>" id="viewMore_<?php echo $row['product_id'];?>" class="viewIcon noMartb viewMore " title="##_MY_LISTS_VIEW_##">
                    </a>
                    <?php /*?><a style="cursor:pointer;" onclick="inviteFromLists('<?php echo $row['product_id'];?>');" class="floatLeft" title="##_REM_INVITES_LOGO_##"><img src="<?php echo Yii::app()->params->base_url;?>images/invite.png" /></a>
                    <a href="javascript:;" lang="<?php echo $row['product_id'];?>" id="remove_<?php echo $row['product_id'];?>" class="various4 deleteIcon noMartb floatLeft" title="##_MY_LISTS_DELETE_##">
                    </a><?php */?>
				</td>
			</tr>
			<?php
           $i++; }
		} else { ?>
			<tr>
            	<td colspan="8" class="lastcolumn alignLeft">
                	##_PRODUCT_LIST_PAGE_NO_PRODUCT_##
				</td>
			</tr>
		<?php
		}?>
        </table>
         <?php
        if(!empty($pagination) && $pagination->getItemCount()  > $pagination->getLimit()){?>
             <div class="pagination"  style="margin-right:65px;">
                <?php
				$extraPaginationPara='&keyword='.$ext['keyword'];
                $this->widget('application.extensions.WebPager', 
                                array('cssFile'=>true,
                                        'extraPara'=>$extraPaginationPara,
										 'pages' => $pagination,
                                         'id'=>'link_pager',
                )); ?>
            </div>
			<?php
		} ?>
        </div>
</div>
 </div>
</div>
<script type="text/javascript">
	$j(document).ready(function(){
		$j('#link_pager a').each(function(){
			$j(this).click(function(ev){
				ev.preventDefault();
				$j.get(this.href,{ajax:true},function(html){
					$j('#firstcont').html(html);
				});
			});
		});
	});
</script>