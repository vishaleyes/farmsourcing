<script type="application/javascript"> 
   	function journalEntryforCustomer() {
	   	 $.ajax({
		  type: 'POST',
		  url: '<?php echo Yii::app()->params->base_path ;?>admin/journalEntryforCustomer',
		  data: '',
		  cache: false,
		  success: function(data)
		  {
			if(data == 0 )
			{
				bootbox.alert("Data not found.");
			}else{
				var str = data ;
				bootbox.modal(str, 'Customer Journal Entry');
			}	
		  }
		 });
   }
   
   function journalEntryforVendor() {
	   	
		 $.ajax({
		  type: 'POST',
		  url: '<?php echo Yii::app()->params->base_path ;?>admin/journalEntryforVendor',
		  data: '',
		  cache: false,
		  success: function(data)
		  {
			if(data == 0 )
			{
				bootbox.alert("Data not found.");
			}else{
				var str = data ;
				bootbox.modal(str, 'Vendor Journal Entry');
			}	
		  }
		 });
   }
   
   function journalEntryforOther() {
	   	 $.ajax({
		  type: 'POST',
		  url: '<?php echo Yii::app()->params->base_path;?>admin/journalEntryforCustomer',
		  data: '',
		  cache: false,
		  success: function(data)
		  {
			   $("#content").html(data);
		  }
		 });
   }

</script>
<!-- Content -->
		<div id="content">

		    <!-- Content wrapper -->
		    <div class="wrapper">

			    <!-- Page header -->
			    <div class="page-header">
			    	<div class="page-title">
				    	<h5>Journal Entry</h5>
				    	<span>Hello, <?php echo Yii::app()->session['fullName'] ; ?> </span>
                        <span>You can insert all journal entry from here.</span>
			    	</div>
			    </div>
			    
   	<div class="widget">
        <div class="well body">
            <div class="controls">
                <ul class="nav nav-pills">
                    <li class="active"><a href="#"><i class="icon-plus"></i>For Driver</a></li>
                    <li class="active" style="margin-left:20px;"><a href="#" onclick="journalEntryforCustomer();"><i class="icon-plus"></i>For Customer</a></li>
                    <li class="active" style="margin-left:20px;"><a href="#" onclick="journalEntryforVendor();"><i class="icon-plus"></i>For Vendor</a></li>
                </ul>                        
            </div>
      </div>
<!-- /span 12 -->  
	</div>
		    <!-- /content wrapper -->
		</div>
        
<!-- /content -->