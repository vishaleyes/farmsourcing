<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<!-- Dialog Popup Js -->

<link href="<?php echo Yii::app()->params->base_url; ?>css/style_home.css" rel="stylesheet" type="text/css" />

<script type="text/javascript">
 /*$j(document).ready(function() {
	 $j.ajax({ url:'<?php// echo Yii::app()->params->base_path ; ?>user/recentTicket',
         type: 'post',
         success: function(data) {
			 $j(".offer").replaceWith(data);
        }
	});
	
});*/
</script>

<script type="text/javascript">
	
	
	function getSearch(test)
	{
		var keyword = $j("#keyword").val();
		
		$j.ajax({
	
			type: 'POST',
	
			url: '<?php echo Yii::app()->params->base_path;?>pos/categoryListing',
	
			data: 'keyword='+keyword,
	
			cache: false,
	
			success: function(data)
			{
				$j("#browsedata").html('');
				$j("#browsedata").html(data);
				$j('#keyword').focus().val(keyword);
				$j("#keyword").val(keyword);
				setTimeout(function() { $j("#update-message").fadeOut();}, 10000 );
	
			}
		});
	}
	
	function getCategoryProductList(cat_id)
	{
		
		$j.ajax({
	
			type: 'POST',
	
			url: '<?php echo Yii::app()->params->base_path;?>pos/getCategoryProductAjax',
	
			data: 'cat_id='+cat_id,
	
			cache: false,
	
			success: function(data)
			{
				$j("#browsedata").html('');
				$j("#browsedata").html(data);
				setTimeout(function() { $j("#update-message").fadeOut();}, 10000 );
	
			}
		});
	}
	
	 
</script>
<div id="browsedata" class="browsedata" style="">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">   
                        <tr style="background-color:#6AA566;">
                          <td align="center" colspan="3">                  	
                            <form id="search" name="search" method="post" action="" onsubmit="return false;">
                                ##_LBL_SEARCH_## : <input type="text" style=" width:199px; height:43px;" name="keyword" id="keyword" onkeyup="getSearch();" />
                            </form>
                          </td>
                          

                        </tr>
                        <tr style="background-color:#6AA566;">
                                    <td width="5%">&nbsp;</td>
                                    <td width="95%" align="left"><h2>##_CATEGORY_NAME_##</h2></td>
                                    <td>&nbsp;</td>
                                   </tr>
                     </table>
 <div class="browsebox" style=" min-height:10px; max-height:550px; overflow-y:scroll">
             <table width="100%" border="0" cellspacing="0" cellpadding="0" id="browsedata" class="browsedata">
                                
                                 <?php if(!empty($res['category'])) { ?>
								<?php foreach($res['category'] as $row ){ ?>
 <tr id="demo"  onclick="getCategoryProductList(<?php echo $row['cat_id'] ; ?>);" style="cursor:pointer;">
        <td width="5%">&nbsp;</td>
        <td width="65%" align="left"><?php echo $row['category_name'] ; ?></td>
        <td width="28%">&nbsp;</td>
        <input id="cat_id" type="hidden" value="<?php echo $row['cat_id'] ?>" />
  
        <td width="25%" id="selectbtn<?php echo $row['cat_id'] ?>" class="last" ><img src="images/mark-true1.gif"/></td> 
    </tr>
<?php  } ?>
   <?php } else { ?>
    <tr>
    <td colspan="4">##_BROWSE_PRODUCT_NO_PRODUCT_AVAILABLE_##</td>
    </tr>
    <?php } ?>
                                 <?php
            if(!empty($res['pagination']) && $res['pagination']->getItemCount()  > $res['pagination']->getLimit()){?>
                 <div class="pagination"  style="margin-right:0px;">
                    <?php
                    
                    $this->widget('application.extensions.WebPager', 
                                    array('cssFile'=>true,
                                             'pages' => $res['pagination'],
                                             'id'=>'link_pager',
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
                        $j('.mainContainer').html(html);
                    });
                });
            });
        });
    </script>
                            </table>
   </div>
</div>
