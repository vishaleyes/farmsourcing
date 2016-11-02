  <div class="widget">
    <div class="navbar">
      <div class="navbar-inner">
        <h6><a href="<?php echo Yii::app()->params->base_path;?>admin/showReports">Reports</a>&nbsp;&nbsp;<img src="<?php echo Yii::app()->params->base_url;?>images/path-arrow.png" alt="" border="0" />&nbsp;&nbsp;Daily Collection Report</h6>
      </div>
    </div>
    <div class="well">
<form id="validate" action="<?php echo Yii::app()->params->base_path;?>admin/showDailyCollectionReports" method="post" enctype="multipart/form-data">
      <table width="90%" id="ordertbl" align="center" border="0" cellspacing="5" cellpadding="5" >
        <tr>
            <td width="25%">
                <div class="control-group">
                    <div class="controls">
                        <label class="control-label">Report By :</label>
                            <select name="type" id="type" class="validate[required] input-medium" tabindex="2" >
                                <option value="">select</option>
                                <option value="1" <?php if(isset($ext['type']) && $ext['type'] == 1) { ?> selected="selected" <?php } ?> >Customer wise</option>
                                <option value="2" <?php if(isset($ext['type']) && $ext['type'] == 2) { ?> selected="selected" <?php } ?> >Driver wise</option>
                            </select>
                    </div>             
                </div>
            </td>
            <td width="33%">
                <div class="control-group">
                    <div class="controls" style="margin-top:-15px;">
                       <div style="float:left;">
                       <label class="control-label">From Date :</label>
                        <input type="text" name="fromDate" id="fromDate" class="input-medium" placeholder="From Date" value="<?php if(isset($ext['fromDate'])){ echo $ext['fromDate']; } ?>" />
                        </div>
                        <div style="float:left; margin-left:10px;">
                        <label class="control-label">To Date :</label>
                        <input type="text" name="toDate" id="toDate" class="input-medium" placeholder="To Date" value="<?php if(isset($ext['toDate'])){ echo $ext['toDate']; } ?>" />
                      </div>
                    </div>             
                </div>
            </td>
            <td width="33%">
            	<label class="control-label"> &nbsp; </label>
                 <input class="btn btn-large btn-info" type="submit" name="submit" value="Generate Report" />
            </td>
        </tr>
      </table>
</form>     
      <?php if(isset($ext['type']) && $ext['type'] == 1) { ?>
      	<div class="widget">
                	<div class="navbar"><div class="navbar-inner"><h6>Customer wise report of this date: <b><?php echo $ext['order_date']; ?></b></h6></div></div>
                    <div class="table-overflow">
                        <table class="table table-bordered table-gradient" id="data-table">
                            <thead>
                                <tr>
                                    <th style="text-align:center">No</th>
                                    <th style="text-align:center">Customer ID</th>
                                    <th style="text-align:center">Customer Name</th>
                                    <th style="text-align:center">Cash Amount</th>
                                    <th style="text-align:center">Coupon Amount</th>
                                    <th style="text-align:center">Credit Amount</th>
                                    <th style="text-align:center">Total Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                           <?php 
						   	   $packets = 0 ;
							   $quantity = 0 ;
							   $amount = 0 ;
							   $cash_amount=0;
							   $coupon_amount=0;
							   $credit_amount=0;
							   $so_amount=0;	
							   $i=1; 
							   foreach($data as $row) { 
						   ?>
                                <tr>
                                    <td style="text-align:center"><?php echo $i ; ?></td>
                                    <td style="text-align:right"><?php echo $row['representativeId'] ; ?></td>
                                    <td><?php echo $row['customer_name'] ; ?></td>
                                    <td style="text-align:right"><?php if($row['cash_amount'] != "") { echo $row['cash_amount'] ; } else { echo "0";} ?></td>
                                    <td style="text-align:right"><?php if($row['coupon_amount'] != "") { echo $row['coupon_amount'] ; } else { echo "0";} ?></td>
                                    <td style="text-align:right"><?php if($row['credit_amount'] != "") { echo $row['credit_amount'] ; } else { echo "0";} ?></td>
                                    <td style="text-align:right"><?php if($row['so_amount'] != "") { echo $row['so_amount'] ; } else { echo "0";} ?></td>
                                </tr>
						  <?php 
						  	  $cash_amount = $cash_amount + $row['cash_amount'] ;
							  $coupon_amount = $coupon_amount + $row['coupon_amount'] ;
							  $credit_amount = $credit_amount + $row['credit_amount'] ;
							  $so_amount = $so_amount + $row['so_amount'] ;
							  $i++ ; 
							  } 
							 
							  if(!empty($data)) { 
						  ?>
                          		<?php /*?><tr>
                                	<td colspan="3" style="text-align:center"><strong>TOTAL</strong></td>
                                    <td style="text-align:right"><strong><?php echo $cash_amount ; ?></strong></td>
                                    <td style="text-align:right"><strong><?php echo $coupon_amount ; ?></strong></td>
                                    <td style="text-align:right"><strong><?php echo $so_amount ; ?></strong></td>
                                </tr><?php */?>	
						  <?php }else { ?>
                          		<?php /*?><tr>
                                	<td style="text-align:center;" colspan="7">Data not found.</td>
                                </tr><?php */?>
						  <?php }?>
                            </tbody>
                        </table>
                        <table class="table table-gradient">
                            <tr>
                                <td width="20%" align="right"><b>Total Cash Amount :</b></td>
                                <td><b><?php echo $cash_amount ; ?></b></td>
                            </tr>
                            <tr>
                                <td width="20%" align="right"><b>Total Coupon Amount :</b></td>
                                <td><b><?php echo $coupon_amount ; ?></b></td>
                            </tr>
                            <tr>
                                <td width="20%" align="right"><b>Total Credit Amount :</b></td>
                                <td><b><?php echo $credit_amount ; ?></b></td>
                            </tr>
                            <tr>
                                <td width="20%" align="right"><b>Total Amount :</b></td>
                                <td><b><?php echo $so_amount ; ?></b></td>
                            </tr>
                        </table>
                    </div>
                </div>
      <?php } ?>
      
      <?php if(isset($ext['type']) && $ext['type'] == 2) { ?>
      	<div class="widget">
                	<div class="navbar"><div class="navbar-inner"><h6>Driver wise collection report of this date: <b><?php echo $ext['order_date']; ?></b></h6></div></div>
                    <div class="table-overflow">
                        <table class="table table-bordered table-gradient" id="data-table">
                            <thead>
                                <tr>
                                    <th style="text-align:center">No</th>
                                    <th style="text-align:center">Driver ID</th>
                                    <th style="text-align:center">Driver Name</th>
                                    <th style="text-align:center">Cash Amount</th>
                                    <th style="text-align:center">Coupon Amount</th>
                                    <th style="text-align:center">Total Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                           <?php 
							   $total_amount = 0 ;
							   $cash_amount=0;
							   $coupon_amount=0;
							   $credit_amount=0;
							    $so_amount=0;
							   $i=1; 
							   foreach($data as $row) { 
						   ?>
                                <tr>
                                    <td style="text-align:center"><?php echo $i ; ?></td>
                                    <td style="text-align:right"><?php echo $row['id'] ; ?></td>
                                    <td><?php echo $row['driverName'] ; ?></td>
                                    <td style="text-align:right"><?php if($row['cash_amount'] != "") { echo $row['cash_amount'] ; } else { echo "0";} ?></td>
                                    <td style="text-align:right"><?php if($row['coupon_amount'] != "") { echo $row['coupon_amount'] ; } else { echo "0";} ?></td>
                                    <td style="text-align:right"><?php if($row['so_amount'] != "") { echo $row['so_amount'] ; } else { echo "0";} ?></td>
                                </tr>
						  <?php 
						  	  $cash_amount = $cash_amount + $row['cash_amount'] ;
							  $coupon_amount = $coupon_amount + $row['coupon_amount'] ;
							  $so_amount = $so_amount + $row['so_amount'] ;
							  $i++ ; 
							  } 
							 
							  if(!empty($data)) { 
						  ?>
                          		<?php /*?><tr>
                                	<td colspan="3" style="text-align:center"><strong>TOTAL</strong></td>
                                    <td style="text-align:right"><strong><?php echo $cash_amount ; ?></strong></td>
                                    <td style="text-align:right"><strong><?php echo $coupon_amount ; ?></strong></td>
                                    <td style="text-align:right"><strong><?php echo $so_amount ; ?></strong></td>
                                </tr><?php */?>	
						  <?php }else { ?>
                          		<?php /*?><tr>
                                	<td style="text-align:center;" colspan="4">Data not found.</td>
                                </tr><?php */?>
						  <?php }?>
                            </tbody>
                        </table>
                        <table class="table table-gradient">
                            <tr>
                                <td width="20%" align="right"><b>Total Cash Amount :</b></td>
                                <td><b><?php echo $cash_amount ; ?></b></td>
                            </tr>
                            <tr>
                                <td width="20%" align="right"><b>Total Coupon Amount :</b></td>
                                <td><b><?php echo $coupon_amount ; ?></b></td>
                            </tr>
                            <tr>
                                <td width="20%" align="right"><b>Total Amount :</b></td>
                                <td><b><?php echo $so_amount ; ?></b></td>
                            </tr>
                        </table>
                    </div>
                </div>
      <?php } ?>
    </div>
  </div>

<!-- /default form --> 
