<!-- Span 12 -->
    <div class="widget">
        
        <div class="well body">
        	<strong>Sales Order No :</strong><br/>
            <p><?php if(isset($soDetailsData['so_id']) && $soDetailsData['so_id'] != "") { echo $soDetailsData['so_id'] ; } ?></p>
            
            <strong>Zone:</strong><br/>
            <p><?php if(isset($soDetailsData['zoneName']) && $soDetailsData['zoneName'] != "") { echo $soDetailsData['zoneName'] ; } ?></p>
            
            <strong>Customer Name:</strong><br/>
            <p><?php if(isset($soDetailsData['customer_name']) && $soDetailsData['customer_name'] != "") { echo $soDetailsData['customer_name'] ; } ?></p>
            
            <strong>Created By:</strong><br/>
            <p><?php if(isset($soDetailsData['createBy']) && $soDetailsData['createBy'] != "") { echo $soDetailsData['createBy'] ; } ?></p>
            
            <strong>Delivery Date:</strong><br/>
            <p><?php if(isset($soDetailsData['delivery_date']) && $soDetailsData['delivery_date'] != "") { echo $soDetailsData['delivery_date'] ; } ?></p>
            
            <strong>Created Date:</strong><br/>
            <p><?php if(isset($soDetailsData['createdAt']) && $soDetailsData['createdAt'] != "") { echo $soDetailsData['createdAt'] ; } ?></p>
            
            <strong>Modified Date:</strong><br/>
            <p><?php if(isset($soDetailsData['modifiedAt']) && $soDetailsData['modifiedAt'] != "") { echo $soDetailsData['modifiedAt'] ; } ?></p>
            
            <strong>Total Items:</strong><br/>
            <p><?php if(isset($soDetailsData['total_item']) && $soDetailsData['total_item'] != "") { echo $soDetailsData['total_item'] ; } ?></p>
            
            <strong>Coupon Amount:</strong><br/>
            <p><?php if(isset($soDetailsData['coupon_amount']) && $soDetailsData['coupon_amount'] != "") { echo $soDetailsData['coupon_amount'] ; } ?></p>
            
             <?php 
					$soDescObj = new SoDesc();
					$totalAmount = $soDescObj->getTotalAmountForSo($soDetailsData['so_id'])
				?>
             <strong>Total Amount:</strong><br/>
            <p><?php if(isset($totalAmount) && $totalAmount != "") { echo round($totalAmount,0) ; } ?></p>
           
        </div>
        
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Packaging Scenario</th>
                    <th>No Of Packets</th>
                    <th>Quantity</th>
                    <th>Total Amount</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($soDescData as $row) { 
				$totalAmountSo +=  $row['quantity'] * $row['product_price'];
			?>
                <tr>
                    <td><?php echo $row['product_name'] ; ?></td>
                    <td style="text-align:right;"><?php echo $row['product_price'] ; ?></td>
                    <td style="text-align:right;"><?php echo $row['packaging_scenario'] ; ?></td>
                    <td style="text-align:right;"><?php echo $row['no_of_packets'] ; ?></td>
                    <td style="text-align:right;"><?php echo $row['quantity'] ; ?></td>
                    <td style="text-align:right;" class="lastcolumn"><?php echo $row['quantity'] * $row['product_price']  ; ?></td>
                   	
                </tr>
           <?php } ?>
           		<tr><td colspan="5" style="text-align:right;"><b>TOTAL AMOUNT : </b></td><td colspan="5" style="text-align:right;"><b><?php echo round($totalAmountSo,0)  ; ?></b></td></tr>
            </tbody>
        </table>
                        
    </div>
<!-- /span 12 -->