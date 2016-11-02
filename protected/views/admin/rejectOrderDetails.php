<!-- Span 12 -->
    <div class="widget">
        
        <div class="well body">
        	<strong>Sales Order No :</strong><br/>
            <p><?php if(isset($rejectionData['so_id']) && $rejectionData['so_id'] != "") { echo $rejectionData['so_id'] ; } ?></p>
            
            <strong>Zone:</strong><br/>
            <p><?php if(isset($rejectionData['zoneName']) && $rejectionData['zoneName'] != "") { echo $rejectionData['zoneName'] ; } ?></p>
            
            <strong>Customer Name:</strong><br/>
            <p><?php if(isset($rejectionData['customer_name']) && $rejectionData['customer_name'] != "") { echo $rejectionData['customer_name'] ; } ?></p>
            
            <strong>Created By:</strong><br/>
            <p><?php if(isset($rejectionData['createBy']) && $rejectionData['createBy'] != "") { echo $rejectionData['createBy'] ; } ?></p>
            
            <strong>Delivery Date:</strong><br/>
            <p><?php if(isset($rejectionData['delivery_date']) && $rejectionData['delivery_date'] != "") { echo $rejectionData['delivery_date'] ; } ?></p>
            
             <strong>Total Items:</strong><br/>
            <p><?php if(isset($rejectionData['total_product']) && $rejectionData['total_product'] != "") { echo $rejectionData['total_product'] ; } ?></p>
            
            <strong>Total Amount:</strong><br/>
            <p><?php if(isset($rejectionData['total_amount']) && $rejectionData['total_amount'] != "") { echo $rejectionData['total_amount'] ; } ?></p>
            
             <strong>Driver Name:</strong><br/>
            <p><?php if(isset($rejectionData['driver']) && $rejectionData['driver'] != "") { echo $rejectionData['driver'] ; } ?></p>
            
            <strong>Created Date:</strong><br/>
            <p><?php if(isset($rejectionData['createdAt']) && $rejectionData['createdAt'] != "") { echo $rejectionData['createdAt'] ; } ?></p>
            
            <strong>Modified Date:</strong><br/>
            <p><?php if(isset($rejectionData['modifiedAt']) && $rejectionData['modifiedAt'] != "") { echo $rejectionData['modifiedAt'] ; } ?></p>
            
           
            
            
        </div>
        
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Rejected Quantity</th>
                    <th>Total Price</th>
                    <th>Reason</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($rejectionDescData as $row) { ?>
                <tr>
                    <td><?php echo $row['product_name'] ; ?></td>
                    <td style="text-align:right;"><?php echo $row['rejected_quantity'] ; ?></td>
                    <td style="text-align:right;"><?php echo $row['amount'] ; ?></td>
                    <td style="text-align:left;"><?php echo $row['reason'] ; ?></td>
                </tr>
           <?php } ?>
            </tbody>
        </table>
                        
    </div>
<!-- /span 12 -->