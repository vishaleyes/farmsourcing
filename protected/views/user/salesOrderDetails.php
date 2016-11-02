<div class="row clearfix"></div>
<div class="container">
  <div class="row">
    <div class="col-md-12">
            <div class="breadcrumb"> <a href="<?php echo Yii::app()->params->base_path;?>user/OrderHistoryListing"> <i class="fa fa-home fa-fw"></i> Order History </a> <i class="fa fa-angle-right fa-fw"></i>Order Details View</div>
      
      <!-- Quick Help for tablets and large screens -->
      <div class="quick-message hidden-xs">
        <div class="quick-box">
          <div class="quick-slide"> <span class="title">Help</span>
            <div class="quickbox slide" id="quickbox">
              <div class="carousel-inner">
                <div class="item active"> <a href="#"> <i class="fa fa-envelope fa-fw"></i> Quick Message</a> </div>
                <div class="item"> <a href="<?php echo Yii::app()->params->base_path;?>site/faq"> <i class="fa fa-question-circle fa-fw"></i> FAQ</a> </div>
                <div class="item"> <a href="#"> <i class="fa fa-phone fa-fw"></i> 079-40165800</a> </div>
              </div>
            </div>
            <a class="left carousel-control" data-slide="prev" href="#quickbox"> <i class="fa fa-angle-left fa-fw"></i> </a> <a class="right carousel-control" data-slide="next" href="#quickbox"> <i class="fa fa-angle-right fa-fw"></i> </a> </div>
        </div>
      </div>
      <!-- end: Quick Help --> 
      
    </div>
  </div>
</div>
<div class="row clearfix f-space10"></div>

<div class="row clearfix f-space10"></div>
<div class="container"> 
  <!-- row -->
  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12 box-block">
    <div class="table-overflow">
     <!-- Span 12 -->
    <table class="table table-striped">
    		<thead>
                <tr>
                    <th>Sales Order No:</th>
                    <th>Zone:</th>
                </tr>
            </thead>
                <tr>
                    <td><?php if(isset($soDetailsData['so_id']) && $soDetailsData['so_id'] != "") { echo $soDetailsData['so_id'] ; } ?></td>
                    <td><?php if(isset($soDetailsData['zoneName']) && $soDetailsData['zoneName'] != "") { echo $soDetailsData['zoneName'] ; } ?></td>
                </tr>
            <thead>
                <tr>
                    <th>Customer Name:</th>
                    <th>Created By:</th>
                </tr>
            </thead>
                <tr>
                    <td><?php if(isset($soDetailsData['customer_name']) && $soDetailsData['customer_name'] != "") { echo $soDetailsData['customer_name'] ; } ?></td>
                    <td><?php if(isset($soDetailsData['createBy']) && $soDetailsData['createBy'] != "") { echo $soDetailsData['createBy'] ; } ?></td>
                </tr>
            <thead>
                <tr>
                    <th>Delivery Date::</th>
                    <th>Total Items:</th>
                </tr>
            </thead>
                <tr>
                    <td><?php if(isset($soDetailsData['delivery_date']) && $soDetailsData['delivery_date'] != "") { echo $soDetailsData['delivery_date'] ; } ?></td>
                    <td><?php if(isset($soDetailsData['total_item']) && $soDetailsData['total_item'] != "") { echo $soDetailsData['total_item'] ; } ?></td>
                </tr>
            <thead>
                <tr>
                    <th>Created Date:</th>
                    <th>Modified Date:</th>
                </tr>
            </thead>
                <tr>
                    <td><?php if(isset($soDetailsData['createdAt']) && $soDetailsData['createdAt'] != "") { echo $soDetailsData['createdAt'] ; } ?></td>
                    <td><?php if(isset($soDetailsData['modifiedAt']) && $soDetailsData['modifiedAt'] != "") { echo $soDetailsData['modifiedAt'] ; } ?></td>
                </tr>
	</table>
 
<div class="row clearfix f-space30"></div>       
        <table class="table table-striped table-bordered" id="data-table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Packaging Scenario</th>
                    <th>No Of Packets</th>
                    <th>Quantity</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($soDescData as $row) { ?>
                <tr>
                    <td><?php echo $row['product_name'] ; ?></td>
                    <td style="text-align:right;"><?php echo $row['product_price'] ; ?></td>
                    <td style="text-align:right;"><?php echo $row['packaging_scenario'] ; ?></td>
                    <td style="text-align:right;"><?php echo $row['no_of_packets'] ; ?></td>
                    <td style="text-align:right;"><?php echo $row['quantity'] ; ?></td>
                </tr>
           <?php } ?>
            </tbody>
        </table>
	<!-- /span 12 -->
    </div>  
    </div>
  </div>
  <!-- end:row --> 
</div>
<!-- end: container-->

<div class="row clearfix f-space30"></div>