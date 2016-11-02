<!-- Span 12 -->
<div class="widget">
    <div class="well body">
     <?php //echo "<pre>"; print_r($productData); exit; ?>
        <strong>Product Name :</strong><br/>
        <p><?php if(isset($productData['product_name']) && $productData['product_name'] != "") { echo $productData['product_name'] ; }else { echo "---";}  ?></p>
        
        <strong>Product Description :</strong><br/>
        <p><?php if(isset($productData['product_desc']) && $productData['product_desc'] != "") { echo $productData['product_desc'] ; } else { echo "---";}  ?></p>
        
        <strong>Product Image:</strong><br/>
        <p><img src="<?php echo Yii::app()->params->base_url; ?>assets/upload/product/<?php echo $productData['product_image']; ?>" width="150" height="150" /></p>
        
        <strong>Product Price :</strong><br/>
        <p><?php if(isset($productData['product_price']) && $productData['product_price'] != "") { echo $productData['product_price'] ; } else { echo "---";}  ?></p>
        
        <strong>Product Wholesale Price :</strong><br/>
        <p><?php if(isset($productData['wholesale_price']) && $productData['wholesale_price'] != "") { echo $productData['wholesale_price'] ; } else { echo "---";}  ?></p>
        
        <strong>Minimum Product Quantity :</strong><br/>
        <p><?php if(isset($productData['min_quantity']) && $productData['min_quantity'] != "") { echo $productData['min_quantity'] ; } else { echo "---";}  ?></p>
        
        <strong>Unit :</strong><br/>
        <p><?php if(isset($productData['unit_name']) && $productData['unit_name'] != "") { echo $productData['unit_name'] ; } else { echo "---";}  ?></p>
        
        <strong>Vendor :</strong><br/>
        <p><?php if(isset($productData['vendor_name']) && $productData['vendor_name'] != "") { echo $productData['vendor_name'] ; } else { echo "---";}  ?></p>
        
        <strong>Safety Margin :</strong><br/>
        <p><?php if(isset($productData['safetyMargin']) && $productData['safetyMargin'] != "") { echo $productData['safetyMargin'] ; } else { echo "---";}  ?></p>
        
        <strong>Profit Percentage :</strong><br/>
        <p><?php if(isset($productData['profit_percentage']) && $productData['profit_percentage'] != "") { echo $productData['profit_percentage'] ; } else { echo "---";}  ?></p>
        
        <strong>Featured Product :</strong><br/>
        <p><?php if(isset($productData['featured']) && $productData['featured'] == "1") { echo "Yes" ; } else { echo "No";}  ?></p>
        
        <strong>Special Product :</strong><br/>
        <p><?php if(isset($productData['special']) && $productData['special'] == "1") { echo "Yes" ; } else { echo "No";}  ?></p>
        
        <strong>Created Date:</strong><br/>
        <p><?php if(isset($productData['created_date']) && $productData['created_date'] != "" && $productData['created_date'] != "0000-00-00 00:00:00") { echo $productData['created_date'] ; } else { echo "---";}  ?></p>
   
        <strong>Last Modified Date:</strong><br/>
        <p><?php if(isset($productData['modified_date']) && $productData['modified_date'] != "" && $productData['modifiedAt'] != "0000-00-00 00:00:00") { echo $productData['modified_date'] ; } else { echo "---";}  ?></p>
   </div>
</div>
<!-- /span 12 -->