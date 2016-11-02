<!-- Span 12 -->
    <div class="widget">
        
        <div class="well body">
        	<strong>Zone Name:</strong><br/>
            <p><?php if(isset($zoneData['zoneName']) && $zoneData['zoneName'] != "") { echo $zoneData['zoneName'] ; } ?></p>
            <strong>Created Date:</strong><br/>
            <p><?php if(isset($zoneData['createdAt']) && $zoneData['createdAt'] != "") { echo $zoneData['createdAt'] ; } ?></p>
            <strong>Modified Date:</strong><br/>
            <p><?php if(isset($zoneData['modifiedAt']) && $zoneData['modifiedAt'] != "") { echo $zoneData['modifiedAt'] ; } ?></p>
        </div>
    </div>
<!-- /span 12 -->