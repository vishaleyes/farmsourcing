// JavaScript Document
	function multiply()
	 {
		quantity = document.getElementById('quantity').value;
		price = document.getElementById('price').value;
		document.getElementById('total').value = quantity * price;
		
		$("#total1").html(quantity * price);
		document.getElementById('total1').text = quantity * price;
		$("#totalPayable").html(quantity * price);
	}
	
	function multiply_product(productId)
	 {
		
		var quntityOld = $("#quantityold"+productId).val();
		var total1 = $("#totalPayable").text();
		quantity = document.getElementById('quantity'+productId).value;
		$("#quantityold"+productId).val(quantity);
		price = $("#price"+productId).text();
		total = $("#total1"+productId).text();
		
		$("#total1"+productId).text(quantity * price);
		if(quantity==1 || quantity==0)
		{
			
			var sum = 0;
			if(quantity==0)
			{
				
				if(total1==0)
				{
					total1 = 0;
				}
				total1 = Number(total1);
				total1 = Number(total1) - Number(price * (quntityOld));
			}
			else
			{
				
				
				if(total1==0)
				{
					total1 = 0;
				}
				total1 = Number(total1) - Number(price * (quntityOld-1));
			}
			$("#totalPayable").text(Number(total1) + Number(sum));
			$j("#pay").text(Number(total1) + Number(sum) + " /-   Pay");
			
			var productPrice = Number(price) ;
			var quntity = document.getElementById('quantity'+productId).value;
			var total1 = $("#total1"+productId).text(); 
			addProduct(productId,productPrice,quntity,total1);
			
		}
		else
		{
			//alert("quntity OLD : "+quntityOld);
			//alert("quntity NEW : "+quantity);
			if(quntityOld > 0)
			{
				quantity = Number(quantity) - quntityOld ;
			}
			
			
			var sum = quantity * price;
			//alert('total1 :'+total1);
			//alert(sum);
			$("#totalPayable").text(Number(total1) + Number(sum));
			$j("#pay").text(Number(total1) + Number(sum) + " /-   Pay");
			
			
			var productPrice = Number(price) ;
			var quntity = document.getElementById('quantity'+productId).value;
			var total1 = $("#total1"+productId).text(); 
			addProduct(productId,productPrice,quntity,total1);
			
		}
		
	}
	
   	function submitTicket(invoiceId) {
		 var totalPayable = $j("#totalPayable").text();
		 var customer_id = $j("#customer_id").val();
		 if(totalPayable=='' || totalPayable== 0)
		 {
			alert('Ticket is Empty.');
			return false;
		 }
		 $j.ajax({
		  type: 'POST',
		  url: '<?php echo Yii::app()->params->base_path;?>user/submitTicket',
		  data: 'totalPayable='+totalPayable+'&invoiceId='+invoiceId+'&customer_id='+customer_id,
		  cache: false,
		  success: function(data)
		  {
		   $j(".mainContainer").html(data);
		  }
		 });
   }
   
    function submitPendingTicket(invoiceId)
	 {
		 var totalPayable = $j("#totalPayable").text();
		 var customer_id = $j("#customer_id").val();
		 if(totalPayable=='' || totalPayable== 0)
		 {
			alert('Ticket is Empty.');
			return false;
		 }
		 $j.ajax({
		  type: 'POST',
		  url: '<?php echo Yii::app()->params->base_path;?>user/submitPendingTicket',
		  data: 'totalPayable='+totalPayable+'&invoiceId='+invoiceId+'&customer_id='+customer_id,
		  cache: false,
		  success: function(data)
		  {
		   $j(".mainContainer").html(data);
		  }
		 });
   }
   
   	$j("#viewMore").fancybox({
	  'width' : 800,
	   'height' : 450,
	   'transitionIn' : 'none',
	  'transitionOut' : 'none',
	  'type':'iframe'
	  
	  });
	
	function addrow(productName,productPrice,productId,productImg)
	{  
		if(productImg!='')
		{
			$j('#productImg').html('');
			$j('#productImg').html('<img src="assets/upload/product/'+productImg+'" width="333" height="200" />');
		}
		var i = 0;
		var sum = $j("#totalPayable").text();
		$j('#my_table > tbody > tr:last').after("<tr id='tabletr"+productId+"'><td id='productName"+productId+"'>"+productName+"</td><td><input type='text' id='quantity"+productId+"' onkeyup='multiply_product("+productId+")' name='quantity' size='5px;' value='1'><input type='hidden' id='quantityold"+productId+"' name='quantityold' size='5px;' value='1'></td><td id='price"+productId+"'>"+productPrice+"</td><td id='total1"+productId+"'>"+productPrice+"</td><td style='cursor:pointer' onClick='removeTableRow("+productId+");' id='delete"+productId+"'>remove</td></tr>");
		$j('#selectbtn'+productId).attr( "onClick", "" ).css( "background-color","gray");
		
		var firstItem = 0;
		var price = 0;
		var quntity = 0;
		price = $("#price").val();
		quntity = $("#quantity").val();
		var total1 = $("#total1"+productId).text();
		
		total = Number(total1) + Number(sum);
		$j("#totalPayable").text(total);
		$j("#pay").text(total + " /-   Pay");
		var quntity = 1;
		addProduct(productId,productPrice,quntity,total1);
	}
	
	function addProduct(productId,productPrice,quntity,total1)
	{
		quntity = 1;
		var invoiceId = <?php echo $invoiceId ;  ?>;
		 $j.ajax({
		  type: 'POST',
		  url: '<?php echo Yii::app()->params->base_path;?>user/submitProductdesc',
		  data: 'productId='+productId+'&productPrice='+productPrice+'&quntity='+quntity+'&total1='+total1+'&invoiceId='+invoiceId,
		  cache: false,
		  success: function(data)
		  {
		   //$j(".mainContainer").html(data);
		  }
		 });	
	}
	
	function removeTableRow(productId)
	{
		var totalPayable = $j("#totalPayable").text();
		var total = $("#total1"+productId).text();
		var remainingTotal = Number(totalPayable) - Number(total);
		$j("#totalPayable").text(remainingTotal);
		$j("#pay").text(remainingTotal + " /-   Pay");
	
	 $j("#my_table tbody #tabletr"+productId+"").remove();
	 deleteProduct(productId);
	}
	
	function deleteProduct(productId)
	{
		var invoiceId = <?php echo $invoiceId ;  ?>;
		 $j.ajax({
		  type: 'POST',
		  url: '<?php echo Yii::app()->params->base_path;?>user/deleteProductdesc',
		  data: 'productId='+productId+'&invoiceId='+invoiceId,
		  cache: false,
		  success: function(data)
		  {
			  $j("#searchBtn").trigger('click');
		   // $j('#selectbtn'+productId).css( "background-color","#CCCCCC");
		  }
		 });	
	}
	
	function getSearch(test)
	{
		
		$j('#loading').html('<div align="center"><img src="'+imgPath+'/spinner-small.gif" alt="" border="0" /> Loading...</div>').show();
	
		var keyword = $j("#keyword").val();
		
		$j.ajax({
	
			type: 'POST',
	
			url: '<?php echo Yii::app()->params->base_path;?>user/SearchProductAjax/invoiceId/<?php echo $invoiceId; ?>',
	
			data: 'keyword='+keyword,
	
			cache: false,
	
			success: function(data)
	
			{
				$j("#browsedata").html('');
				$j("#browsedata").html(data);
	
				$j("#keyword").val(keyword);
				//$('#keyword').focus();
				setTimeout(function() { $j("#update-message").fadeOut();}, 10000 );
	
			}
	
		});
	
	}
