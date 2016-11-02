<!-- Remove select and replace -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo Yii::app()->params->base_url; ?>js/ajaxfileupload.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->params->base_url; ?>js/jquery.jeditable.js" ></script>
<!-- Dialog Popup Js -->
<script type="text/javascript" src="<?php echo Yii::app()->params->base_url; ?>js/j.min.Dialog.js" ></script>		
<script type="text/javascript" src="<?php echo Yii::app()->params->base_url; ?>js/jDialog.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->params->base_url; ?>js/smoothscroll.js"></script>
<link href="<?php echo Yii::app()->params->base_url; ?>css/style_home.css" rel="stylesheet" type="text/css" />
<?php /*?><script type="text/javascript" src="<?php echo Yii::app()->params->base_url; ?>js/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->params->base_url; ?>js/jcarousellite_1.0.1.pack.js"></script><?php */?>

<script type="text/javascript">
		/*$(function() {
    		$(".anyClass").jCarouselLite({
        		btnNext: ".next",
        		btnPrev: ".prev"
    		});
		});*/
	
</script>
<script type="text/javascript">
	function multiply() {
		quantity = document.getElementById('quantity').value;
		price = document.getElementById('price').value;
		document.getElementById('total').value = quantity * price;
		
		$("#total1").html(quantity * price);
		document.getElementById('total1').text = quantity * price;
		$("#totalPayable").html(quantity * price);
	}
	
	function checkStockDetail(productId)
	{
		quntityOld = $("#quantityold"+productId).val();
		quantity = document.getElementById('quantity'+productId).value;
		
		 $j.ajax({
		  type: 'POST',
		  url: '<?php echo Yii::app()->params->base_path;?>pos/CheckStockDetail',
		  data: 'quantity='+quantity+'&quntityOld='+quntityOld+'&productId='+productId,
		  cache: false,
		  success: function(data)
		  {
		  	if( data == 0 ) 
			{
				jAlert(msg['PRODUCT_QUANTITY_NOT_ENOUGH']);
				multiply_product(productId);
			}
			else
			{
				multiply_product(productId);
			}
		  }
		 });
   }
	
	function multiply_product(productId) {
		
		
		quantity = document.getElementById('quantity'+productId).value;
		packaging_scenario = $("#packaging_scenario"+productId+" option:selected").val();
		
		if(packaging_scenario == "" || packaging_scenario == "undefined" || packaging_scenario == null || packaging_scenario == 0 )
		{
			jAlert("Please select package scenario.");
			return false;	
		}
		
		price = $("#price"+productId).text();
		total = $("#total1"+productId).text();
		
		var totalPayable  = $("#totalPayable").text();
		
		var newTotal = Number(quantity) * Number(packaging_scenario) * Number(price);
		
		var FinalTotal = Number(totalPayable) + Number(newTotal) - Number(total);
		
		
		$("#total1"+productId).text(Number(newTotal).toFixed(0));
		
		$("#totalPayable").text(Number(FinalTotal).toFixed(0));
		$j("#pay").text(Number(FinalTotal).toFixed(0) + " /-   Pay");
		
		var sessionKey  = $("#sessionKeyRow"+productId).val();
		
		updateProduct(sessionKey,packaging_scenario,quantity);
		
	}
	
    function submitTicket() {
		 $j('#loading').html('<div align="center" style="color:white;"><img src="<?php echo Yii::app()->params->base_url ; ?>images/spinner-small.gif" alt="" border="0" />  Loading...</div>').show();
		 var totalPayable = $j("#totalPayable").text();
		 var customer_id = $j("#customer_id").val();
		 if(totalPayable=='' || totalPayable== 0)
		 {
			jAlert('Ticket is Empty.');
			$j("#loading").hide();	
			return false;
		 }
		 
		 var sessionKeyCount = $j("#sessionKeyCount").val();
		
		 for(i=0; i < Number(sessionKeyCount); i++)
		 {
		 	var product_id = $j("#productId_"+i).val();
			var package_scenario =  $j("#packaging_scenario"+product_id).val();
			
			if(package_scenario == "" || package_scenario == "undefined" || package_scenario == null )
			{
				jAlert("Please select package scenario.");
				//jAlert('Ticket is Empty.');
				$j("#loading").hide();	
				return false;	
			}
		 }
		 
		 $j.ajax({
		  type: 'POST',
		  url: '<?php echo Yii::app()->params->base_path;?>pos/paymentTicket',
		  data: 'totalPayable='+totalPayable+'&customer_id='+customer_id,
		  cache: false,
		  success: function(data)
		  {
			  
			  
		   $j(".thiredcont").html(data);
		   $j('.browseCalc').css( "display","none");
		   setTimeout(function() { $j("#update-message").fadeOut();}, 10000 );
	  	   setTimeout(function() { $j("#update-message1").fadeOut();}, 10000 ); 
		  }
		 });
		 $j("#loading").hide();		
   }
   
    function submitPendingTicket(invoiceId) {
		 $j('#loading').html('<div align="center" style="color:white;"><img src="<?php echo Yii::app()->params->base_url ; ?>images/spinner-small.gif" alt="" border="0" />  Loading...</div>').show();
		 var totalPayable = $j("#totalPayable").text();
		 var customer_id = $j("#customer_id").val();
		 if(totalPayable=='' || totalPayable== 0)
		 {
			jAlert(msg['TICKET_EMPTY']);
			$j("#loading").hide();	
			return false;
		 }
		 $j.ajax({
		  type: 'POST',
		  url: '<?php echo Yii::app()->params->base_path;?>user/submitPendingTicket',
		  data: 'totalPayable='+totalPayable+'&invoiceId='+invoiceId+'&customer_id='+customer_id,
		  cache: false,
		  success: function(data)
		  {
		   //$j(".mainContainer").html(data);
		   $j("#browseBtn").trigger('click');
		   setTimeout(function() { $j("#update-message").fadeOut();},  10000);
		   setTimeout(function() { $j("#update-message1").fadeOut();},  10000 );
		  }
		 });
		 $j("#loading").hide();	
   }
   /*
   	$j("#viewMore").fancybox({
	  'width' : 800,
	   'height' : 450,
	   'transitionIn' : 'none',
	  'transitionOut' : 'none',
	  'type':'iframe'
	  
	  });*/
	
  function checkStockDetailFromStock(productName,productId,productImg)
	{
		
		$j('#selectbtn'+productId).attr( "onClick", "" ).css( "background-color","gray");
		$j.ajax({
		  type: 'POST',
		  url: '<?php echo Yii::app()->params->base_path;?>pos/getStockDetail',
		  data: '&productId='+productId,
		  cache: false,
		  success: function(data)
		  {
		  	if( data == 0 || data < 0) 
			{
				jAlert(msg['PRODUCT_QUANTITY_NOT_ENOUGH']);
				addrow(productName,productId,productImg);
			}
			else
			{
				addrow(productName,productId,productImg);
			}
		  }
		 });
   }
   
	function addrow(productName,productId,productImg)
	{  
		var productPrice = $j("#product_price_"+productId).val();
		var i = 0;
		var sum = $j("#totalPayable").text();
		var sessionKeyCount  = $j("#sessionKeyCount").val();
		
		$j.ajax({
		  type: 'POST',
		  url: '<?php echo Yii::app()->params->base_path;?>pos/getAllPackageScenarioByCatId',
		  data: '&productId='+productId,
		  cache: false,
		  success: function(data)
		  {
		  	
			var obj = jQuery.parseJSON(data);
			
			var packageList = "<select id='packaging_scenario"+productId+"' onchange='checkStockDetail("+productId+")' ><option value=''>Select Package</option>";
			
			
			$.each(obj, function(index, val) {
				packageList += "<option value='"+val.packaging_scenario+"'>"+val.display_name+"</option>";
			});
			
			packageList += "</select>";
			
			$j('#my_table > tbody > tr:last').after("<tr id='tabletr"+productId+"'><td id='productName"+productId+"' onclick='getProductDetail("+productId+");' style='cursor:pointer;color:#666666;'><b>"+productName+"</b><input type='hidden' id='productId_"+sessionKeyCount+"' name='productId_"+sessionKeyCount+"'  value='"+productId+"' ></td><td align='center' >"+packageList+"</td><td align='center'><select id='quantity"+productId+"' onchange='checkStockDetail("+productId+")' name='quantity' ><option value='1'>1</option><?php for($d=2;$d<=100;$d++) { ?><option value='<?php echo $d ;?>'><?php echo $d ;?></option><?php } ?></select></td><td id='price"+productId+"' align='right'>"+Number(productPrice).toFixed(0)+"</td><td id='total1"+productId+"' align='right'>"+Number(productPrice).toFixed(0)+"</td><td style='cursor:pointer' id='delete"+productId+"'><img src='images/false.png'/></td><input type='hidden' class='sessionKeyRow"+sessionKeyCount+"' name='sessionKeyRow"+productId+"' id='sessionKeyRow"+productId+"' value='"+sessionKeyCount+"' /></tr>");
			
			$j("#delete"+productId).attr("onClick","removeTableRow('"+productId+"','"+productName+"','"+productImg+"');");
			$j('#selectbtn'+productId).attr( "onClick", "" ).css( "background-color","gray");
			
			
			var firstItem = 0;
			var price = 0;
			var quntity = 0;
			price = $("#price").val();
			quntity = $("#quantity").val();
			var total1 = $("#total1"+productId).text();
			
			total = Number(total1) + Number(sum);
			$j("#totalPayable").text(Number(total).toFixed(0));
			$j("#pay").text(Number(total).toFixed(0) + " /-   Pay");
			var quntity = 1;
			
			var newSessionKeyCount = Number(sessionKeyCount) + 1;
			$j("#sessionKeyCount").val(newSessionKeyCount);
			
			addProduct(productId);
		  }
		 });
	}
	
	function addProduct(productId)
	{
		$j('#loading').html('<div align="center" style="color:white;"><img src="<?php echo Yii::app()->params->base_url ; ?>images/spinner-small.gif" alt="" border="0" />  Loading...</div>').show();
		//var quntity = 1;
		
		 $j.ajax({
		  type: 'POST',
		  url: '<?php echo Yii::app()->params->base_path;?>pos/addToCart',
		  data: 'id='+productId,
		  cache: false,
		  success: function(data)
		  {
		   	/*if( data == 0) 
			{
				jAlert(msg['PRODUCT_QUANTITY_NOT_ENOUGH']);
				$("#quantityold"+productId).val(quntityOld);
				$("#quantity"+productId).val(quntityOld);
				multiply_product(productId);
				return false;
				//$("#quantity"+productId).val(data);
			}*/
		  }
		 });
		  $j("#loading").hide();	
	}

	function getSearch(test)
	{
		
		$j('#loading').html('<div align="center"><img src="'+imgPath+'/spinner-small.gif" alt="" border="0" /> Loading...</div>').show();
	
		var keyword = $j("#keyword").val();
		
		$j.ajax({
	
			type: 'POST',
	
			url: '<?php echo Yii::app()->params->base_path;?>user/SearchProductAjax',
	
			data: 'keyword='+keyword,
	
			cache: false,
	
			success: function(data)
	
			{
				$j("#demo").html('');
				$j("#demo").html(data);
	
				$j("#keyword").val(keyword);
				//$('#keyword').focus();
				setTimeout(function() { $j("#update-message").fadeOut();}, 10000 );
	
			}
	
		});
	
	}
	


</script>
<a href="#verifycodePopup" id="verifycode"></a>
<!-- End Mouse Scroll Finction -->
<div id="update-message"></div>
<!-- Middle Part -->
<div>
	<?php if(Yii::app()->user->hasFlash('success')): ?>
        <div class="error-msg-area">								   
           <div id="msgbox" class="clearmsg"> <?php echo Yii::app()->user->getFlash('success'); ?></div>
        </div>
    <?php endif; ?>
    <?php if(Yii::app()->user->hasFlash('error')): ?>
        <div class="error-msg-area">
            <div class="errormsg"><?php echo Yii::app()->user->getFlash('error'); ?></div>
         </div>
    <?php endif; ?>
</div>
<div class="clear"></div>

<div class="mainContainer" style="margin:0px;">
    <div class="content" id="mainContainer" style="width:100%; padding:0px; margin:0px;">
      <input type="hidden" id="mainPageCheker" value="1" />
       <div class="">	
            <div class="clear"></div>
       <div class="middlediv">
       
      
      <div class="container">
        
              <div style="width:100%; float:left;">
          <div class="firstcont">
            <div class="heading">F&B </div>
            <div style="margin:5px 0px; width:100%; float:left;"><span id="productImg"><img src="images/img.png" width="333" height="200" /></span></div>
            <div class="about">
              <h2>Wine Academy</h2>
              <div class="cont">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived only five centuries.</div>
            </div>
            <div class="offer">
              <h2> Today's Offers</h2>
              <div class="itemname">Item 1</div>
              <div class="price">10.50</div>
              <div class="itemname">Item 2</div>
              <div class="price">15.50</div>
              <div class="itemname">Item 3</div>
              <div class="price">20.50</div>
              <div class="itemname">Item 4</div>
              <div class="price">15.50</div>
            </div>
          </div>
          <div class="secondcont">
            <div class="topbutton"><a href="#">Butt</a> <a href="#">Browse</a> <a href="#">Scan</a> <a href="#" onclick="submitTicket();" class="last" id="pay">Pay</a></div>
            <div class="productbox">
              <div class="head">
                <div class="floatLeft width40p" ><?php echo $invoiceId ; ?></div>
                <a href="<?php echo Yii::app()->params->base_path;?>user/customerList" id="viewMore" class="viewIcon noMartb viewMore floatLeft"></a>
                <div id="customer_name1" style="float:left">Customer </div>
                <input type="hidden" id="customer_name" name="customer_name" value="">
                <div id="customer_id1"></div>
                 <input type="hidden" id="customer_id" name="customer_id" value="">
                </div>
              <div style="clear:both">
                <table width="100%" border="0" cellspacing="0" cellpadding="0" class="productdata" id="my_table">
                  <?php if(isset($data['product_name']) && $data['product_name']!= '' && isset($data['product_price']) && $data['product_price'] != ''){ ?>
                  <tr>
                    <td><?php if(isset($data['product_name'])) { echo $data['product_name'] ;} ?></td>
                    <input type="hidden" id="product_name" name="product_name"  value="<?php if(isset($data['product_name'])) { echo $data['product_name'] ;} ?>" size="30px;" height="50px;">
                    <td><input type="text" id="quantity<?php echo $data['product_id'];?>" onblur="multiply_product(<?php echo $data['product_id'];?>)" name="quantity" size="5px;" value="1"><input type="hidden" id="quantityold<?php echo $data['product_id'];?>" name="quantityold" size="5px;" value="1"></td>
                    <td id="price<?php echo $data['product_id'];?>"><?php if(isset($data['product_price'])) { echo $data['product_price'] ;} ?></td>
                    <input type="hidden" id="price" onblur="multiply_product(<?php echo $data['product_id'];?>)" name="price" value="<?php if(isset($data['product_price'])) { echo $data['product_price'] ;} ?>" size="15px;">
                    <td id="total1<?php echo $data['product_id'];?>"><?php if(isset($data['product_price'])) { echo $data['product_price'] ;} ?></td>
                    <input type="hidden" id="total" name="total" value="" size="10px;">
                  </tr>
                 <?php } ?>
                 <tr>
                 </tr>
                 </table>
                 <table width="100%" border="0" cellspacing="0" cellpadding="0" >
                  <tr>
                    <td>Tax 0% * 0 = 0.00</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>TOTAL</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td id="totalPayable"><?php if(isset($data['product_price'])) { echo $data['product_price'] ;} ?></td>
                  </tr>
                </table>
              </div>
            </div>
          </div>
          <div class="thiredcont">
            <div class="topbutton">
            <a href="#" onclick="submitPendingTicket();" class="first"><img src="images/file_icon.png" title="Hold Ticket" width="20" height="20" /></a> 
            <a href="#" onClick="loadBoxContent('<?php echo Yii::app()->params->base_path ; ?>user/BrowseProduct','mainContainer');">Browse</a> 
            <a href="#">Search</a> 
            <a href="#">Scan</a> 
            <a href="<?php echo Yii::app()->params->base_path ; ?>user/logout">Logout</a></div>
            <div class="browsebox" id="demo">
              <table width="100%" border="0" cellspacing="0" cellpadding="0" class="browsedata">
              	<tr>
                  <td>&nbsp;</td>
                  <td>                  	
                	<form id="search" name="search" method="post" action="" onsubmit="return false;">
                		<input type="text" style=" width:200px; height:43px;" name="keyword" id="keyword" onkeyup="getSearch();" />
                    </form>
                  </td>
                  <td>&nbsp;</td>
                </tr>
                <?php foreach($res['product'] as $row ){ ?>
                <tr>
                  <td width="5%">&nbsp;</td>
                  <td width="60%"><?php echo $row['product_name'] ; ?></td>
                  <td width="10%"><?php echo $row['product_price'] ; ?></td>
                  <input id="product_id" type="hidden" value="<?php echo $row['product_id'] ?>" />
                 <?php if($data['product_id'] != $row['product_id']) {  ?>
                  <td width="25%" id="selectbtn<?php echo $row['product_id'] ?>" class="last" onclick="addrow('<?php echo $row['product_name'] ; ?>','<?php echo $row['product_price'] ; ?>','<?php echo $row['product_id'] ?>','<?php echo $row['product_image'] ?>'),'<?php echo $row['unit_name'] ?>');">select</td>
                 <?php } else { ?>
                 <td width="25%" id="selectbtn<?php echo $row['product_id'] ?>" class="last" style="background-color:gray;" >select</td>
                 <?php } ?>
                </tr>
               <?php } ?>
              </table>
            </div>
          </div>
        </div>
        
        <div class="clear"></div>
      </div>
    </div>
        </div>
       <div class="clear"></div>
    </div>
    
    <div class="clear"></div>
    
</div>
<div class="clear"></div>
