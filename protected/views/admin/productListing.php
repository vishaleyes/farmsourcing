<script type="text/javascript">
function confirmDelete(id)
{
	bootbox.confirm("Are you sure want to delete user?", function(confirmed) {
		//console.log("Confirmed: "+confirmed);
		if(confirmed == true)
		{
			window.location.href = "<?php echo Yii::app()->params->base_path;?>admin/disableProduct/id/"+id;
		}else{
			return true;
		}
	});
	
}

function productDetailPopup(id)
{
	$.ajax({
		  type: 'POST',
		  url: '<?php echo Yii::app()->params->base_path ;?>admin/showProductDetail',
		  data: 'id='+id,
		  cache: false,
		  success: function(data)
		  {
			if(data == 0 )
			{
				bootbox.alert("Data not found.");
			}else{
				var str = data ;
				bootbox.modal(str, 'Product Details');
			}	
		  }
	});
}

function isNumberKey(evt)
	{
		if(evt.keyCode == 9)
		{
		
		}
		else
		{
		var charCode = (evt.which) ? evt.which : event.keyCode 
		if (charCode > 31 && charCode != 46  && (charCode < 48 || charCode > 57))
		return false;
		}
		return true;
	}

function changePasswordPopup(id)
{
	$.ajax({
		  type: 'POST',
		  url: '<?php echo Yii::app()->params->base_path ;?>admin/showChangePassword',
		  data: 'id='+id,
		  cache: false,
		  success: function(data)
		  {
			if(data == 0 )
			{
				bootbox.alert("Data not found.");
			}else{
				var str = data ;
				bootbox.modal(str, 'Change Password');
			}	
		  }
		 });
}

function addTextField(id)
{
	//alert(id);
	$("#qnt"+id).html('<input type="textbox" id="shrinkQnt'+id+'" class="input-mini"  onkeypress="return isNumberKey(event);"  /><span id="img'+id+'" ><img onclick="submitShrinkQnt('+id+')" style="float:left; cursor:pointer; margin-top:3px;" src="<?php echo Yii::app()->params->base_url;?>images/success-icon.png" alt="Save" border="0"/></span>');
	return true;
		
}

function submitShrinkQnt(id)
{
	$('#img'+id).html('<img style="float:left; cursor:pointer; margin-left:0px; margin-top:5px;" src="<?php echo Yii::app()->params->base_url;?>images/spinner-mini.gif" border="0"/>');
	realQnt = $("#shrinkQnt"+id).val();
	systemQnt = $("#quantityForStore"+id).text();
	product_id = id ;
	
	var numberRegex = /^(?=.+)(?:[1-9]\d*|0)?(?:\.\d+)?$/;
	var str = $("#shrinkQnt"+id).val();
	if(!numberRegex.test(str)) {
	   alert('Please enter numeric value.');
	   $("#qnt"+id).html('<img src="<?php echo Yii::app()->params->base_url; ?>images/plus.png" onclick="addTextField('+id+')" style="cursor:pointer;" />');	
	   return false;
	  
	}
	
	if(realQnt=='' || realQnt=='undefined')
	{
		$("#qnt"+id).html('<img src="<?php echo Yii::app()->params->base_url; ?>images/plus.png" onclick="addTextField('+id+')" style="cursor:pointer;" />');	
		return false;
	}
	
	$.ajax({
	  type: 'POST',
	  url: '<?php echo Yii::app()->params->base_path;?>admin/shrinkStockQuantity',
	  data: 'realQnt='+realQnt+'&systemQnt='+systemQnt+'&product_id='+product_id,
	  cache: false,
	  success: function(data)
	  {
		$("#qnt"+id).html('<img src="<?php echo Yii::app()->params->base_url; ?>images/plus.png" onclick="addTextField('+id+')" style="cursor:pointer;" />');
		$("#quantityForStore"+id).text(realQnt);
		return true;	
	  }
	 });
}

</script>
<!-- Default datatable -->
<div class="widget">
<div class="navbar"><div class="navbar-inner"><h6>All Products</h6><button type="button" onclick="window.location.href='<?php echo Yii::app()->params->base_path;?>admin/addProduct'" class="btn btn-large btn-info" style="float:right;">Create Product</button></div></div>
<div class="table-overflow">
    <table class="table table-striped table-bordered" id="data-table">
        <thead>
            <tr>
                <th style="text-align:center">No</th>
                <th style="text-align:center">Product Code</th>
                <th style="text-align:center">Name</th>
                <th style="text-align:center">Image</th>
                <th style="text-align:center">Category</th>
                <th style="text-align:center">Vendor</th>
                <th style="text-align:center">Qty</th>
                <th style="text-align:center">Actual Qty</th>
                <th style="text-align:center">Created At</th>
                <th style="text-align:center">Enable/Disable</th>
                <th style="text-align:center" class="actions-column">Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php
			$i=1;
			//$cnt = $data['pagination']->itemCount;
			foreach($data['productList']  as $row){ 
			
			
			if($row['status'] == "1") { 
				$class = "success";
				$icon = "fam-tick";
				$title = "Disable this product";
			}else{
				$class = "error";
				$icon = "fam-cross";
				$title = "Enable this product";
			}
		?>
            <tr class="<?php echo $class; ?>"  >
                <td style="text-align:right">
					<?php 
						///echo $i+($data['pagination']->getCurrentPage()*$data['pagination']->getLimit());
						echo $i;
					?>
                </td>
                <td style="text-align:right" ><?php echo $row['product_id']; ?></td>
                <?php if(trim($row['product_name']) != "" ) 
					  {
						  $firstNameStyle = "";
					 	  $product_name = $row['product_name'] ; 
					  } 
					 else { 
					 	  $firstNameStyle = "text-align:center";
					 	  $product_name = "---" ;
						} 
				?>
                <td style=" <?php echo $firstNameStyle; ?> " ><?php echo $product_name; ?></td>
               
                <td  style="text-align:center" ><a href="<?php echo Yii::app()->params->base_url;?>assets/upload/product/<?php echo $row['product_image'];?>" class="lightbox">
                <?php 
					    	                      
                   $content = file_get_contents(Yii::app()->params->base_url."assets/upload/product/".urlencode($row['product_image']));
				   
			
                    if(!empty($content))
                    {
                        $filePath =  $row['product_image'];
                    }
                    else
                    {
                        $filePath =  "image.png";
                    }
                    ?> 
                <img src="<?php echo Yii::app()->params->base_url;?>assets/upload/product/<?php echo $filePath;?>" width="50" height="50" /></a></td> 
                <?php if(trim($row['category_name']) != "" ) 
					  {
						  $category_nameStyle = "";
					 	  $category_name = $row['category_name'] ; 
					  } 
					 else { 
					 	  $category_nameStyle = "text-align:center";
					 	  $category_name = "---" ;
						} 
				?>
                <td style=" <?php echo $category_nameStyle; ?> " ><?php echo $category_name; ?></td>
                
                <?php if(trim($row['vendor_name']) != "" ) 
					  {
						  $vendor_nameStyle = "";
					 	  $vendor_name = $row['vendor_name'] ; 
					  } 
					 else { 
					 	  $vendor_nameStyle = "text-align:center";
					 	  $vendor_name = "---" ;
						} 
				?>
                <td style=" <?php echo $vendor_nameStyle; ?> " ><?php echo $vendor_name; ?></td>
                
                
           
                
                
                <?php if(trim($row['quantity']) != "" ) 
					  {
						  $emailStyle = "text-align:right";
					 	  $quantity = $row['quantity'] ; 
					  } 
					 else { 
					 	  $emailStyle = "text-align:center";
					 	  $quantity = "---" ;
						} 
				?>
                <td id="quantityForStore<?php echo $row['product_id'];?>" style=" <?php echo $emailStyle; ?> " ><?php echo $quantity; ?></td>
                
                <td id="qnt<?php echo $row['product_id'];?>" style="text-align:center" >
					<img src="<?php echo Yii::app()->params->base_url; ?>images/plus.png" onclick="addTextField(<?php echo $row['product_id'];?>)" title="Add Actual Quantity" style="cursor:pointer;" />
                </td>
                <td style="text-align:center"><?php if($row['created_date'] != "" && $row['created_date'] != "0000-00-00 00:00:00" ) { echo date("d-m-Y",strtotime($row['created_date'])); } else { echo "---"; } ?></td>
              	
                <td style="text-align:center"><a href="<?php echo Yii::app()->params->base_path;?>admin/changeProductStatus/product_id/<?php echo $row['product_id'];?>" title="<?php echo $title ; ?>"><i class="<?php echo $icon; ?>"></i></a></td>
                
                <td style="text-align:center">
                    <ul class="table-controls">
                        <li><a href="#" onclick="productDetailPopup('<?php echo $row['product_id'];?>');" class="tip" title="View Product"><i class="fam-zoom"></i></a> </li>
                        <li><a href="<?php echo Yii::app()->params->base_path ;?>admin/editProduct/id/<?php echo $row['product_id'];?>" class="tip" title="Edit Product"><i class="fam-pencil"></i></a> </li>
                       
                        <?php /*?><li><a href="#" onclick="confirmDelete('<?php echo $row['product_id'];?>');" class="tip" title="Remove Product"><i class="fam-cross"></i></a> </li><?php */?>
                    </ul>
                </td>
            </tr>
	   <?php
        $i++;
        }
	   ?>
        </tbody>
    </table>
</div>
</div>
<!-- /default datatable -->