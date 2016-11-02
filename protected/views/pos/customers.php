<div class="mainContainer" id="mainContainer">
<?php
$extraPaginationPara='&keyword='.$ext['keyword'].'&sortType='.$ext['sortType'].'&sortBy='.$ext['sortBy'];
?>
<script type="text/javascript" src="<?php echo Yii::app()->params->base_url; ?>js/jquery-1.7.2.min.js"></script>


<link rel="stylesheet" href="<?php echo Yii::app()->params->base_url; ?>css/pos/pos.css" type="text/css" />
<link rel="stylesheet" href="<?php echo Yii::app()->params->base_url; ?>css/style.css" type="text/css" />
<link type="text/css" rel="stylesheet" href="<?php echo Yii::app()->params->base_url; ?>css/registration.css" />
<script type="text/javascript">
var $j = jQuery.noConflict();
var imgPath = "<?php echo Yii::app()->params->base_url;?>images/";
function sortData(sortBy,sortType)
{
	 //var url	=	$j(this).attr('lang');
     loadBoxContent('<?php echo Yii::app()->params->base_path;?>user/customerList/sortType/'+sortBy+'/sortBy/'+sortType+'<?php echo  $extraPaginationPara;?>','mainContainer');
}
function loadBoxContent(urlData,boxid)
{
	//alert(urlData);
	mylist=0;
	mytodoStatus=0;
	//var $j = jQuery.noConflict();
	
		$j.ajax({			
		type: 'POST',
		url: urlData,
		data: '',
		cache: true,
		success: function(data)
		{
			//alert(urlData);
			//alert(boxid);
			//alert(data);
			if(data=="logout")
			{
				window.location.href = '<?php echo Yii::app()->params->base_path;?>';
				return false;	
			}
			
			//window.location.href = '<?php //echo Yii::app()->params->base_path;?>pos/browse';
			
			$j("#"+boxid).html(data);
			$j('#update-message').removeClass().html('').hide();
			
		}
		});	
} 


$j(document).ready(function() {
	
/*	$j(".viewMore").fancybox({
		'width' : 800,
 		'height' : 500,
 		'transitionIn' : 'none',
		'transitionOut' : 'none',
		'type':'iframe'
		
 	});*/
	
	  $j('.sort').click(function() {
                var url	=	$j(this).attr('lang');
                loadBoxContent('<?php echo Yii::app()->params->base_path;?>'+url+'<?php echo  $extraPaginationPara;?>','mainContainer');
	  });
				
				
	$j('.various4').click(function() {
		
		var id	=	$j(this).attr('lang');
		
		jConfirm('Are you sure want delete this TODO list ?', 'Confirmation dialog', function(res){
			if( res == true ) {
				$j('#update-message').html('<div align="center"><img src="'+imgPath+'/spinner-small.gif" alt="" border="0" /> Loading...</div>').show();
				$j('#mainContainer')
					.load('<?php echo Yii::app()->params->base_path;?>user/removeList/id/'+id, function() {
						$j("#update-message").removeClass().addClass('msg_success');
						$j("#update-message").html('List deleted successfully');
						$j("#update-message").fadeIn();
						$j('#listAjaxBox').load('<?php echo Yii::app()->params->base_path;?>user/listAjax');
						$j('#mainContainer').load('<?php echo Yii::app()->params->base_path;?>user/myLists');
						setTimeout(function() {
							$j('#update-message').fadeOut();
						}, 10000 );
					});
			}
		});
		
	});
	
	
	
});
	
function getSearch()
{
	$j('#loading').html('<div align="center"><img src="'+imgPath+'/spinner-small.gif" alt="" border="0" /> Loading...</div>').show();
	var keyword = $j("#keyword").val();
	
	$j.ajax({
		type: 'POST',
		url: '<?php echo Yii::app()->params->base_path;?>pos/customerList',
		data: 'keyword='+keyword,
		cache: false,
		success: function(data)
		{
			$j("#mainContainer").html(data);
			$j("#keyword").val(keyword);
			setTimeout(function() { $j("#update-message").fadeOut();}, 10000 );
		}
	});
}

function getAll()
{
	$j.ajax({
		type: 'POST',
		url: '<?php echo Yii::app()->params->base_path;?>pos/customerList',
		data: '',
		cache: false,
		success: function(data)
		{
			$j("#mainContainer").html(data);
			setTimeout(function() { $j("#update-message").fadeOut();}, 10000 );
		}
	});
}


function inviteFromLists(id)
{
	setUrl('<?php echo Yii::app()->params->base_path; ?>user/addinvite/id/'+id+'/from/myLists');
}



function selectNetworkUser(id,name)
{	
parent.loadBoxContent('<?php echo Yii::app()->params->base_path ; ?>pos/replaceCustomerName/customer_id/'+id+'/name/'+name,'mainContainer');
//customerName
	//mainContainer	
	parent.$j.fancybox.close();	
	
		
}
</script>

<div class="RightSide">
	
    <h1>##_CUSTOMER_LIST_PAGE_CUSTOMER_LIST_##</h1>
    
    <div class="searchArea innerSearch">
        <form id="jobSearch" name="jobSearch" action="#" method="post" onsubmit="return false;">        
        	<label class="label floatLeft">##_CUSTOMER_LIST_PAGE_CUSTOMERS_##</label>
            <input type="text" class="textbox floatleft" style="width:300px;" name="keyword"  onkeypress="if(event.keyCode==13){getSearch();}" id="keyword" autocomplete="off" />
            <input type="button" name="searchBtn" class="searchBtn" value="" onclick="getSearch();" />
            <input type="button" name="searchBtn" class="btn" value="ShowAll" onclick="getAll();" />
        </form>
        <div class="clear"></div>
    </div>
	
	
        <div class="clear"></div>
 
	
    <table cellpadding="0" cellspacing="0" border="0" class="listing width1000" id="list">
    	<tr>
    		<th> 
            	<a href="javascript:;" class="sort" lang='<?php Yii::app()->params->base_path;?>pos/customerList/invoiceId/<?php echo $invoiceId;?>/sortType/<?php echo $ext['sortType'];?>/sortBy/customer_name' >
                ##_CUSTOMER_LIST_PAGE_CUSTOMER_NAME_##
				<?php 
				if($ext['img_name'] != '' && $ext['sortBy'] == 'customer_name'){ ?>
					<img src="<?php echo Yii::app()->params->base_url;?>images/<?php echo $ext['img_name'];?>" class="sortImage" />
					<?php
				} ?>
                </a>
            </th>
            
            <th>
            	<a href="javascript:;" class="sort" lang='<?php Yii::app()->params->base_path;?>pos/customerList/invoiceId/<?php echo $invoiceId;?>/sortType/<?php echo $ext['sortType'];?>/sortBy/cust_email' >
                Email ID
				<?php 
				if($ext['img_name'] != '' && $ext['sortBy'] == 'cust_email'){ ?>
					<img src="<?php echo Yii::app()->params->base_url;?>images/<?php echo $ext['img_name'];?>" class="sortImage" />
					<?php
				} ?>
                </a>
            </th>
            
            <th>
            	<a href="javascript:;" class="sort" lang='<?php Yii::app()->params->base_path;?>pos/customerList/invoiceId/<?php echo $invoiceId;?>/sortType/<?php echo $ext['sortType'];?>/sortBy/mobile_no' >
                Mobile No.
				<?php 
				if($ext['img_name'] != '' && $ext['sortBy'] == 'mobile_no'){ ?>
					<img src="<?php echo Yii::app()->params->base_url;?>images/<?php echo $ext['img_name'];?>" class="sortImage" />
					<?php
				} ?>
                </a>
            </th>
            
            
            
            <th class="lastcolumn">##_TICKET_LIST_ACTION_##</th>
		</tr>
        <?php  
		if(count($data) > 0){ $i=0;
		
			foreach($data as $row){ ?> 
            <tr>
            
            <?php
				if(trim($row['customer_name']) != "" ) 
					  {
					 	  $customer_name = $row['customer_name'] ; 
					  } 
					 else {
					 	  $customer_name = "---" ;
						} 
				?>
            	<td class="alignCenter">
                	 <?php echo $customer_name; ?>
                </td>
              <?php
				if(trim($row['cust_email']) != "" ) 
					  {
					 	  $cust_email = $row['cust_email'] ; 
					  } 
					 else {
					 	  $cust_email = "---" ;
						} 
				?>
                <td class="alignCenter">
                	<?php echo $cust_email;?>
                </td>				
                		<?php
				if(trim($row['mobile_no']) != "" ) 
					  {
					 	  $mobile_no = $row['mobile_no'] ; 
					  } 
					 else {
					 	  $mobile_no = "---" ;
						} 
				?>		
                <td class="alignCenter">
                	<?php echo $mobile_no;?>
                </td>
             
                
                <td style=" text-align:center;" class="lastcolumn">
                	<a href="#" lang="<?php echo $row['id']; ?>" id="myNetwork_<?php echo $row['customer_id']; ?>" onclick="selectNetworkUser('<?php echo $row['customer_id']; ?>','<?php echo $row['customer_name'];?>')" >##_TICKET_LIST_SELECT_##</a>
             	</td>
			</tr>
			<?php
           $i++; }
		} else { ?>
			<tr>
            	<td colspan="8" class="lastcolumn alignLeft">
                	##_CUSTOMER_LIST_PAGE_NO_FOUND_##
				</td>
			</tr>
		<?php
		}?>
        </table>
      
         <?php
        if(!empty($pagination) && $pagination->getItemCount()  > $pagination->getLimit()){?>
            <div class="pagination" style="width:70% !important;">
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
<script type="text/javascript">
	$j(document).ready(function(){
		$j('#link_pager a').each(function(){
			$j(this).click(function(ev){
				ev.preventDefault();
				$j.get(this.href,{ajax:true},function(html){
					$j('#mainContainer').html(html);
				});
			});
		});
	});
</script>
</div>