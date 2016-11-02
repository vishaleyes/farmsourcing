  <div class="widget">
    <div class="navbar">
      <div class="navbar-inner">
        <h6><a href="<?php echo Yii::app()->params->base_path;?>admin/showReports">Reports</a>&nbsp;&nbsp;<img src="<?php echo Yii::app()->params->base_url;?>images/path-arrow.png" alt="" border="0" />&nbsp;&nbsp;Daily Purchase Report</h6>
      </div>
    </div>
    <div class="well">
<form id="validate" action="<?php echo Yii::app()->params->base_path;?>admin/showDailyPurchaseReports" method="post" enctype="multipart/form-data">
      <table width="90%" id="ordertbl" align="center" border="0" cellspacing="5" cellpadding="5" >
        <tr>
            <td width="25%">
                <div class="control-group">
                    <div class="controls">
                        <label class="control-label">Report By :</label>
                            <select name="type" id="type" class="validate[required] input-medium" tabindex="2" >
                                <option value="">select</option>
                                <option value="1" <?php if(isset($ext['type']) && $ext['type'] == 1) { ?> selected="selected" <?php } ?> >Product wise</option>
                                <option value="2" <?php if(isset($ext['type']) && $ext['type'] == 2) { ?> selected="selected" <?php } ?> >Vendor wise</option>
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
                	<div class="navbar"><div class="navbar-inner"><h6>Product purchase report between this dates : <b><?php echo $ext['fromDate']; ?></b>   <i>&nbsp;to&nbsp;</i>  <b><?php echo $ext['toDate']; ?></b></h6></div></div>
                    <div class="table-overflow">
                        <table class="table table-bordered table-gradient" id="data-table">
                            <thead>
                                <tr>
                                    <th style="text-align:center">No</th>
                                    <th style="text-align:center">Product Id</th>
                                    <th style="text-align:center">Product Name</th>
                                    <th style="text-align:center">Unit</th>
                                    <th style="text-align:center">PO Quantity</th>
                                    <th style="text-align:center">Received Quantity</th>
                                    <th style="text-align:center">Accepted Quantity</th>
                                    <th style="text-align:center">Total Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                           <?php 
						   	   $packets = 0 ;
							   $quantity = 0 ;
							   $amount = 0 ;	
							   $i=1; 
							   foreach($data as $row) { 
						   ?>
                                <tr>
                                    <td style="text-align:center"><?php echo $i ; ?></td>
                                    <td style="text-align:right"><?php echo $row['product_id'] ; ?></td>
                                    <td><?php echo $row['product_name'] ; ?></td>
                                    <td><?php echo $row['unit_name'] ; ?></td>
                                    <td style="text-align:right"><?php if($row['quantity'] != "") { echo $row['quantity'] ; } else { echo "0";} ?></td>
                                    <td style="text-align:right"><?php if($row['received_quantity'] != "") { echo $row['received_quantity'] ; } else { echo "0";} ?></td>
                                    <td style="text-align:right"><?php if($row['accepted_quantity'] != "") { echo $row['accepted_quantity'] ; } else { echo "0";} ?></td>
                                    <td style="text-align:right"><?php if($row['amount'] != "") { echo $row['amount'] ; } else { echo "0";} ?></td>
                                </tr>
						  <?php 
						  	  $quantity = $quantity + $row['quantity'] ;
							  $received_quantity = $received_quantity + $row['received_quantity'] ;
							  $accepted_quantity = $accepted_quantity + $row['accepted_quantity'] ;
							  $amount = $amount + $row['amount'] ;
							  $i++ ; 
							  } 
							 
							  if(!empty($data)) { 
						  ?>
                          		<?php /*?><tr>
                                	<td colspan="4" style="text-align:center"><strong>TOTAL</strong></td>
                                    <td style="text-align:center"><strong>-</strong></td>
                                    <td style="text-align:center"><strong>-</strong></td>
                                    <td style="text-align:center"><strong>-</strong></td>
                                    <td style="text-align:right"><strong><?php echo $amount ; ?></strong></td>
                                </tr>	<?php */?>
						  <?php }else { ?>
                          		<?php /*?><tr>
                                	<td style="text-align:center;" colspan="7">Data not found.</td>
                                </tr><?php */?>
						  <?php }?>
                            </tbody>
                        </table>
                        <table class="table table-gradient">
                            <tr>
                                <td width="15%" align="right"><b>Total Amount :</b></td>
                                <td><b><?php echo $amount ; ?></b></td>
                            </tr>
                        </table>
                    </div>
                </div>
      <?php } ?>
      
      <?php if(isset($ext['type']) && $ext['type'] == 2) { ?>
      	<div class="widget">
                	<div class="navbar"><div class="navbar-inner"><h6>Vendor purchase report between this dates : <b><?php echo $ext['fromDate']; ?></b>   <i>&nbsp;to&nbsp;</i>  <b><?php echo $ext['toDate']; ?></b></h6></div></div>
                    <div class="table-overflow">
                        <table class="table table-bordered table-gradient" id="data-table">
                            <thead>
                                <tr>
                                    <th style="text-align:center">No</th>
                                    <th style="text-align:center">Vendor Id</th>
                                    <th style="text-align:center">Vendor Name</th>
                                    <th style="text-align:center">Total Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                           <?php 
							   $total_amount = 0 ;
							   $i=1; 
							   foreach($data as $row) { 
						   ?>
                                <tr>
                                    <td style="text-align:center"><?php echo $i ; ?></td>
                                    <td style="text-align:right"><?php echo $row['vendor_id'] ; ?></td>
                                    <td><?php echo $row['vendor_name'] ; ?></td>
                                    <td style="text-align:right"><?php if($row['total_amount'] != "") { echo $row['total_amount'] ; } else { echo "0";} ?></td>
                                </tr>
						  <?php 
						  	  $total_amount = $total_amount + $row['total_amount'] ;
							  $i++ ; 
							  } 
							 
							  if(!empty($data)) { 
						  ?>
                          		<?php /*?><tr>
                                	<td colspan="3" style="text-align:center"><strong>TOTAL</strong></td>
                                    <td style="text-align:right"><strong><?php echo $total_amount ; ?></strong></td>
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
                                <td width="15%" align="right"><b>Total Amount :</b></td>
                                <td><b><?php echo $total_amount ; ?></b></td>
                            </tr>
                        </table>
                    </div>
                </div>
      <?php } ?>
    </div>
  </div>

<!-- /default form --> 
