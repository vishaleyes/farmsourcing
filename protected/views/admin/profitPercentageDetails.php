<!-- Span 12 -->
<div class="widget">
    <div class="well body">
     <?php //echo "<pre>"; print_r($productData); exit; ?>
        
        
        <strong>Profit Percentage :</strong><br/>
        <p><?php if(isset($profitPercentageDetailsData['profit_percentage']) && $profitPercentageDetailsData['profit_percentage'] != "") { echo $profitPercentageDetailsData['profit_percentage'] ; } else { echo "---";}  ?></p>
        
        <strong>From Date:</strong><br/>
        <p><?php if(isset($profitPercentageDetailsData['from_date']) && $profitPercentageDetailsData['from_date'] != "") { echo $profitPercentageDetailsData['from_date'] ; } else { echo "---";}  ?></p>
        
        <strong>To Date :</strong><br/>
        <p><?php if(isset($profitPercentageDetailsData['to_date']) && $profitPercentageDetailsData['to_date'] != "") { echo $profitPercentageDetailsData['to_date'] ; } else { echo "---";}  ?></p>
        
        <strong>Status :</strong><br/>
        <p><?php if(isset($profitPercentageDetailsData['status']) && $profitPercentageDetailsData['status'] == '0') { echo 'Inactive' ; } else { echo "Active";}  ?></p>
        
        <strong>ModifiedAt :</strong><br/>
        <p><?php if(isset($profitPercentageDetailsData['modifiedAt']) && $profitPercentageDetailsData['modifiedAt'] != "") { echo $profitPercentageDetailsData['modifiedAt'] ; } else { echo "---";}  ?></p>
        
        <strong>CreatedAt :</strong><br/>
        <p><?php if(isset($profitPercentageDetailsData['createdAt']) && $profitPercentageDetailsData['createdAt'] != "") { echo $profitPercentageDetailsData['createdAt'] ; } else { echo "---";}  ?></p>
        
       
   </div>
</div>
<!-- /span 12 -->