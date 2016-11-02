<script type="text/javascript">
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

function changePricePopup(id)
{
	$.ajax({
		  type: 'POST',
		  url: '<?php echo Yii::app()->params->base_path ;?>admin/showEditProduct',
		  data: 'id='+id,
		  cache: false,
		  success: function(data)
		  {
			if(data == 0 )
			{
				bootbox.alert("Data not found.");
			}else{
				var str = data ;
				bootbox.modal(str, 'Change Product Price');
			}	
		  }
		 });
}


</script>
<!-- Default datatable -->
<div class="widget">
<div class="navbar"><div class="navbar-inner"><h6>All Products Price</h6></div></div>
<div class="table-overflow">
    <table class="table table-striped table-bordered" id="data-table">
        <thead>
            <tr>
                <th style="text-align:center">No</th>
                <th style="text-align:center">Product Code</th>
                <th style="text-align:center">Name</th>
                <th style="text-align:center">Image</th>
                <th style="text-align:center">Category</th>
                <th style="text-align:center">Price</th>
                <th style="text-align:center">Modified At</th>
                <th style="text-align:center" class="actions-column">Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php
			$i=1;
			//$cnt = $data['pagination']->itemCount;
			foreach($data['productList']  as $row){ 
			
			if($row['status'] == "1") { 
				$class = "info";
				$icon = "fam-tick";
				$title = "Deactive this user";
			}else{
				$class = "info";
				$icon = "fam-cross";
				$title = "Active this user";
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
               
                <td  style="text-align:center" ><a href="<?php echo Yii::app()->params->base_url;?>assets/upload/product/<?php echo $row['product_image'];?>" class="lightbox"><img src="<?php echo Yii::app()->params->base_url;?>assets/upload/product/<?php echo $row['product_image'];?>" width="50" height="50" /></a></td> 
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
                
                <?php if(trim($row['product_price']) != "" ) 
					  {
						  $emailStyle = "text-align:right";
					 	  $product_price = $row['product_price'] ; 
					  } 
					 else { 
					 	  $emailStyle = "text-align:center";
					 	  $product_price = "---" ;
						} 
				?>
                <td style=" <?php echo $emailStyle; ?> " ><?php echo $product_price; ?></td>
                
                <td style="text-align:center"><?php if($row['modified_date'] != "" && $row['modified_date'] != "0000-00-00 00:00:00" ) { echo date("d-m-Y",strtotime($row['modified_date'])); } else { echo "---"; } ?></td>
              
                <td style="text-align:center">
                    <ul class="table-controls">
                        <li><a href="#" onclick="productDetailPopup('<?php echo $row['product_id'];?>');" class="tip" title="View Product"><i class="fam-zoom"></i></a> </li>
                        <li><a href="#" onclick="changePricePopup('<?php echo $row['product_id'];?>');" class="tip" title="Edit Price"><i class="fam-pencil"></i></a> </li>
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