<!-- Span 12 -->
    <div class="widget">
        
        <div class="well body">
        	<strong>Purchase Order No :</strong><br/>
            <p><?php if(isset($PoDetailsData['po_id']) && $PoDetailsData['po_id'] != "") { echo $PoDetailsData['po_id'] ; } ?></p>
            
           	<strong>Vendor Name:</strong><br/>
            <p><?php if(isset($PoDetailsData['vendor_name']) && $PoDetailsData['vendor_name'] != "") { echo $PoDetailsData['vendor_name'] ; } ?></p>
            
            <strong>Created By:</strong><br/>
            <p><?php if(isset($PoDetailsData['createBy']) && $PoDetailsData['createBy'] != "") { echo $PoDetailsData['createBy'] ; } ?></p>
            
            <strong>SO Delivery Date:</strong><br/>
            <p><?php if(isset($PoDetailsData['delivery_date']) && $PoDetailsData['delivery_date'] != "") { echo $PoDetailsData['delivery_date'] ; } ?></p>
            
            <strong>Created Date:</strong><br/>
            <p><?php if(isset($PoDetailsData['createdAt']) && $PoDetailsData['createdAt'] != "") { echo $PoDetailsData['createdAt'] ; } ?></p>
            
            <strong>Modified Date:</strong><br/>
            <p><?php if(isset($PoDetailsData['modifiedAt']) && $PoDetailsData['modifiedAt'] != "") { echo $PoDetailsData['modifiedAt'] ; } ?></p>
            
            <strong>Status:</strong><br/>
            <p><?php if(isset($PoDetailsData['status']) && $PoDetailsData['status'] == 0) { echo "Not Recieved" ; } else { echo "Recieved";} ?></p>
            
            <strong>Total Amounts:</strong><br/>
            <p><?php if(isset($PoDetailsData['total_amount']) && $PoDetailsData['total_amount'] != "") { echo $PoDetailsData['total_amount'] ; } ?></p>
            
            
        </div>
        
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Qty</th>
                    <th>Recieved Qty</th>
                    <th>Accepted Qty</th>
                    <th>Price</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($poDescData as $row) { ?>
                <tr>
                    <td><?php echo $row['product_name'] ; ?></td>
                    <td style="text-align:right;"><?php echo $row['quantity'] ; ?></td>
                    <td style="text-align:right;"><?php echo $row['received_quantity'] ; ?></td>
                    <td style="text-align:right;"><?php echo $row['accepted_quantity'] ; ?></td>
                    <td style="text-align:right;"><?php echo $row['price'] ; ?></td>
                    <td style="text-align:right;"><?php echo $row['amount'] ; ?></td>
                </tr>
           <?php } ?>
            </tbody>
        </table>
                        
    </div>
<!-- /span 12 -->