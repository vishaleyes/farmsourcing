<!-- Span 12 -->
<div class="widget">
    <div class="well body">
     <?php  //echo "<pre>"; print_r($categoryData); exit; ?>
        <strong>Customer Name :</strong><br/>
        <p><?php if(isset($couponData['customer_name']) && $couponData['customer_name'] != "") { echo $couponData['customer_name'] ; }else { echo "---";}  ?></p>
        
        <strong>Coupon Code :</strong><br/>
        <p><?php if(isset($couponData['coupon_number']) && $couponData['coupon_number'] != "") { echo $couponData['coupon_number'] ; } else { echo "---";}  ?></p>
        
        
        <strong>Coupon Discount Type :</strong><br/>
        <p><?php if(isset($couponData['coupon_type']) && $couponData['coupon_type'] == "0") { echo "Rs" ; } else { echo "%";}  ?></p>
        
        <strong>Amount :</strong><br/>
        <p><?php if(isset($couponData['coupon_amount']) && $couponData['coupon_amount'] != "") { echo $couponData['coupon_amount'] ; } else { echo "---";}  ?></p>
        
        <strong>IsUsed?</strong><br/>
        <p><?php if(isset($couponData['isUsed']) && $couponData['isUsed'] == "0") { echo "No" ; } else { echo "Yes";}  ?></p>
        
        <strong>Created Date:</strong><br/>
        <p><?php if(isset($couponData['createdAt']) && $couponData['createdAt'] != "" && $couponData['createdAt'] != "0000-00-00 00:00:00") { echo $couponData['createdAt'] ; } else { echo "---";}  ?></p>
   
        <strong>Last Modified Date:</strong><br/>
        <p><?php if(isset($couponData['modifiedAt']) && $couponData['modifiedAt'] != "" && $couponData['modifiedAt'] != "0000-00-00 00:00:00") { echo $couponData['modifiedAt'] ; } else { echo "---";}  ?></p>
   </div>
</div>
<!-- /span 12 -->