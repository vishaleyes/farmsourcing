<!-- Span 12 -->
    <div class="widget">
        <div class="navbar">
            <div class="navbar-inner"><h6><?php if(isset($vendorData['vendor_name']) && $vendorData['vendor_name'] != "") { echo $vendorData['vendor_name'] ; } else { echo "Vendor" ;} ?></h6></div>
        </div>
        <div class="well body">
        	<strong>Vendor Name:</strong><br/>
            <p><?php if(isset($vendorData['vendor_name']) && $vendorData['vendor_name'] != "") { echo $vendorData['vendor_name'] ; } ?></p>
            <strong>Contact Name:</strong><br/>
            <p><?php if(isset($vendorData['contact_name']) && $vendorData['contact_name'] != "") { echo $vendorData['contact_name'] ; } ?></p>
            <strong>Email:</strong><br/>
            <p><?php if(isset($vendorData['email']) && $vendorData['email'] != "") { echo $vendorData['email'] ; } ?></p>
            <strong>Contact No:</strong><br/>
            <p><?php if(isset($vendorData['contact_no']) && $vendorData['contact_no'] != "") { echo $vendorData['contact_no'] ; } ?></p>
            <strong>Address:</strong><br/>
            <p><?php if(isset($vendorData['address']) && $vendorData['address'] != "") { echo $vendorData['address'] ; } ?></p>
            <?php /*?><strong>Credit:</strong><br/>
            <p><?php if(isset($vendorData['credit']) && $vendorData['credit'] != "") { echo $vendorData['credit'] ; } ?></p>
            <strong>Debit:</strong><br/>
            <p><?php if(isset($vendorData['debit']) && $vendorData['debit'] != "") { echo $vendorData['debit'] ; } ?></p><?php */?>
            <strong>Created Date:</strong><br/>
            <p><?php if(isset($vendorData['createdAt']) && $vendorData['createdAt'] != "") { echo $vendorData['createdAt'] ; } ?></p>
            <strong>Modified Date:</strong><br/>
            <p><?php if(isset($vendorData['modifiedAt']) && $vendorData['modifiedAt'] != "") { echo $vendorData['modifiedAt'] ; } ?></p>
        </div>
    </div>
<!-- /span 12 -->