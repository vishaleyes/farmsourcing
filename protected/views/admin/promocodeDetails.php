<!-- Span 12 -->
<div class="widget">
    <div class="well body">
     <?php  //echo "<pre>"; print_r($categoryData); exit; ?>
        <strong>Promo Code Unique Id :</strong><br/>
        <p><?php if(isset($promocodeData['promocode_uniqueId']) && $promocodeData['promocode_uniqueId'] != "") { echo $promocodeData['promocode_uniqueId'] ; } else { echo "---";}  ?></p>
        
        
        <strong>Promocode Type :</strong><br/>
        <p><?php if(isset($promocodeData['promocode_type']) && $promocodeData['promocode_type'] == "0") { echo "Rs" ; } else { echo "%";}  ?></p>
        
        <strong>Amount :</strong><br/>
        <p><?php if(isset($promocodeData['promocode_amount']) && $promocodeData['promocode_amount'] != "") { echo $promocodeData['promocode_amount'] ; } else { echo "---";}  ?></p>
        
        <strong>IsUsed?</strong><br/>
        <p><?php if(isset($promocodeData['isUsed']) && $promocodeData['isUsed'] == "0") { echo "No" ; } else { echo "Yes";}  ?></p>
        
        <strong>Created Date:</strong><br/>
        <p><?php if(isset($promocodeData['createdAt']) && $promocodeData['createdAt'] != "" && $promocodeData['createdAt'] != "0000-00-00 00:00:00") { echo $promocodeData['createdAt'] ; } else { echo "---";}  ?></p>
   
        <strong>Last Modified Date:</strong><br/>
        <p><?php if(isset($promocodeData['modifiedAt']) && $promocodeData['modifiedAt'] != "" && $promocodeData['modifiedAt'] != "0000-00-00 00:00:00") { echo $promocodeData['modifiedAt'] ; } else { echo "---";}  ?></p>
   </div>
</div>
<!-- /span 12 -->