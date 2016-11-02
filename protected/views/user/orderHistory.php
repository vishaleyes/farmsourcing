<div class="row clearfix"></div>
<div class="container">
  <div class="row">
    <div class="col-md-12">
      <div class="breadcrumb"> <a href="<?php echo Yii::app()->params->base_path;?>user"> <i class="fa fa-home fa-fw"></i> Home </a> <i class="fa fa-angle-right fa-fw"></i>Order History</div>
      
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
      <table class="table table-striped table-bordered" id="data-table">
	
    <tr>
    	 <thead>
            <th style="text-align:center">Order ID</th>
            <th style="text-align:center">Total Items</th>
            <th style="text-align:center">Total Packets</th>
            <th style="text-align:center">Total Amount</th>
            <th style="text-align:center">Coupon Amount</th>
            <th style="text-align:center">Delivery Date</th>
            <th style="text-align:center">Created At</th>
            <th style="text-align:center">Action</th>
         </thead>
    </tr>
    <tbody>
      <?php if(count($data['orderlisting']) > 0) { foreach($data['orderlisting'] as $row){ ?>
        <tr>
    	<td style="text-align:center"><?php echo $row['so_id']; ?></td>
        <td style="text-align:right"><?php echo $row['total_item']; ?></td>
        <td style="text-align:right"><?php echo $row['total_packets']; ?></td>
        <td style="text-align:right"><?php echo $row['so_amount']; ?></td>
        <td style="text-align:right"><?php echo $row['coupon_amount']; ?></td>
        <td style="text-align:center"><?php echo $row['delivery_date']; ?></td>
        <td style="text-align:center"><?php echo date("Y-m-d",strtotime($row['createdAt'])); ?></td>
        <td style="text-align:center">
            <a href="<?php echo Yii::app()->params->base_path ;?>user/showSoDetail/id/<?php echo $row['so_id'];?>" id="detailLink_<?php echo $i;?>" class="detailLink"  data-toggle="tooltip" title="View Order Details">
            	<img src="<?php echo Yii::app()->params->base_url;?>images/icons/icon-search.png" style="width:20px; height:20px; cursor:pointer;" />
            </a>
        </td>
    </tr>
    <?php } } else { ?>
    <tr>
    	<td colspan="7" style="text-align:center;">No orders yet.</td>
    </tr>
    <?php } ?>
    </tbody>
</table>
    </div>  
    </div>
  </div>
  <!-- end:row --> 
</div>
<!-- end: container-->

<div class="row clearfix f-space30"></div>
