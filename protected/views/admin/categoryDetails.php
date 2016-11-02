<!-- Span 12 -->
<div class="widget">
    <div class="well body">
     <?php  //echo "<pre>"; print_r($categoryData); exit; ?>
        <strong>Category Name :</strong><br/>
        <p><?php if(isset($categoryData['category_name']) && $categoryData['category_name'] != "") { echo $categoryData['category_name'] ; }else { echo "---";}  ?></p>
        
        <strong>Category Description :</strong><br/>
        <p><?php if(isset($categoryData['cat_description']) && $categoryData['cat_description'] != "") { echo $categoryData['cat_description'] ; } else { echo "---";}  ?></p>
        
        
        <strong>SafetyMargin :</strong><br/>
        <p><?php if(isset($categoryData['safetyMargin']) && $categoryData['safetyMargin'] != "") { echo $categoryData['safetyMargin'] ; } else { echo "---";}  ?></p>
        
        <strong>Unit :</strong><br/>
        <p><?php if(isset($categoryData['unit_name']) && $categoryData['unit_name'] != "") { echo $categoryData['unit_name'] ; } else { echo "---";}  ?></p>
        
        <strong>Vendor :</strong><br/>
        <p><?php if(isset($categoryData['vendor_name']) && $categoryData['vendor_name'] != "") { echo $categoryData['vendor_name'] ; } else { echo "---";}  ?></p>
        
         <strong>Profit Percentage :</strong><br/>
        <p><?php if(isset($categoryData['profit_percentage']) && $categoryData['profit_percentage'] != "") { echo $categoryData['profit_percentage'] ; } else { echo "---";}  ?></p>
        
        <strong>Created Date:</strong><br/>
        <p><?php if(isset($categoryData['createdAt']) && $categoryData['createdAt'] != "" && $categoryData['createdAt'] != "0000-00-00 00:00:00") { echo $categoryData['createdAt'] ; } else { echo "---";}  ?></p>
   
        <strong>Last Modified Date:</strong><br/>
        <p><?php if(isset($categoryData['modifiedAt']) && $categoryData['modifiedAt'] != "" && $categoryData['modifiedAt'] != "0000-00-00 00:00:00") { echo $categoryData['modifiedAt'] ; } else { echo "---";}  ?></p>
   </div>
</div>
<!-- /span 12 -->