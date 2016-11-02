<!-- Span 12 -->
    <div class="widget">
        <div class="navbar">
            <div class="navbar-inner"><h6><?php if(isset($customerData['customer_name']) && $customerData['customer_name'] != "") { echo $customerData['customer_name'].""; } else { echo "User" ;} ?></h6></div>
        </div>
        <div class="well body">
           
            <strong>Representative ID:</strong><br/>
            <p><?php if(isset($customerData['representativeId']) && $customerData['representativeId'] != "") { echo $customerData['representativeId'] ; } ?></p>
            
            <strong>Membership Card No:</strong><br/>
            <p><?php if(isset($customerData['membership_no']) && $customerData['membership_no'] != "") { echo $customerData['membership_no'] ; } ?></p>
           
        
        	<strong>Customer Name:</strong><br/>
            <p><?php if(isset($customerData['customer_name']) && $customerData['customer_name'] != "") { echo $customerData['customer_name'] ; } ?></p>
            
            <strong>Customer Email:</strong><br/>
            <p><?php if(isset($customerData['cust_email']) && $customerData['cust_email'] != "") { echo $customerData['cust_email'] ; } ?></p>
            
            <strong>Phone:</strong><br/>
            <p><?php if(isset($customerData['contact_no']) && $customerData['contact_no'] != "") { echo $customerData['contact_no'] ; } ?></p>
            
            <strong>Mobile No:</strong><br/>
            <p><?php if(isset($customerData['mobile_no']) && $customerData['mobile_no'] != "") { echo $customerData['mobile_no'] ; } ?></p>
            
             <strong>Block No:</strong><br/>
            <p><?php if(isset($customerData['block']) && $customerData['block'] != "") { echo $customerData['block'] ; } ?></p>
            
             <strong>House No:</strong><br/>
            <p><?php if(isset($customerData['house_no']) && $customerData['house_no'] != "") { echo $customerData['house_no'] ; } ?></p>
            
            
             <strong>Building Name:</strong><br/>
            <p><?php if(isset($customerData['building_name']) && $customerData['building_name'] != "") { echo $customerData['building_name'] ; } ?></p>
            
            
             <strong>Landmark1:</strong><br/>
            <p><?php if(isset($customerData['landmark1']) && $customerData['landmark1'] != "") { echo $customerData['landmark1'] ; } ?></p>
            
            
             <strong>Landmark2:</strong><br/>
            <p><?php if(isset($customerData['landmark2']) && $customerData['landmark2'] != "") { echo $customerData['landmark2'] ; } ?></p>
            
            
             <strong>Area:</strong><br/>
            <p><?php if(isset($customerData['area']) && $customerData['area'] != "") { echo $customerData['area'] ; } ?></p>
            
            
             <strong>City:</strong><br/>
            <p><?php if(isset($customerData['city']) && $customerData['city'] != "") { echo $customerData['city'] ; } ?></p>
            
            <strong>Country:</strong><br/>
            <p><?php if(isset($customerData['country']) && $customerData['country'] != "") { echo $customerData['country'] ; } ?></p>
            
            <strong>Pincode:</strong><br/>
            <p><?php if(isset($customerData['pincode']) && $customerData['pincode'] != "") { echo $customerData['pincode'] ; } ?></p>
            
            
             <?php /*?><strong>Total Purchase:</strong><br/>
            <p><?php if(isset($customerData['total_purchase']) && $customerData['total_purchase'] != "") { echo $customerData['total_purchase'] ; } ?></p>
            
             <strong>Credit:</strong><br/>
            <p><?php if(isset($customerData['credit']) && $customerData['credit'] != "") { echo $customerData['credit'] ; } ?></p>
             <strong>Debit:</strong><br/>
            <p><?php if(isset($customerData['debit']) && $customerData['debit'] != "") { echo $customerData['debit'] ; } ?></p><?php */?>
            
              <strong>Zone:</strong><br/>
            <p><?php if(isset($customerData['zoneName']) && $customerData['zoneName'] != "") { echo $customerData['zoneName'] ; } ?></p>
            
             <strong>Type:</strong><br/>
            <p><?php if(isset($customerData['customer_type']) && $customerData['customer_type'] != "") {  if($customerData['customer_type'] == 0) { echo "Retail"; } else  { echo "Wholesale"; } } ?></p>
            
             
   			<strong>Created Date:</strong><br/>
            <p><?php if(isset($customerData['createdAt']) && $customerData['createdAt'] != "") { echo $customerData['createdAt'] ; } ?></p>
        </div>
    </div>
<!-- /span 12 -->