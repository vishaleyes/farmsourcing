<script>

function submitSearchForm()
{
		window.searchForm.submit();
	//document.getElementById("searchForm").submit();
}
</script>



  <div class="widget">
    <div class="navbar">
      <div class="navbar-inner">
        <h6><a href="<?php echo Yii::app()->params->base_path;?>admin/showReports">Reports</a>&nbsp;&nbsp;<img src="<?php echo Yii::app()->params->base_url;?>images/path-arrow.png" alt="" border="0" />&nbsp;&nbsp;Daily Sales Report</h6>
      </div>
    </div>
    <div class="well">
<form id="searchForm" name="searchForm" action="<?php echo Yii::app()->params->base_path;?>admin/showDailySalesReports" method="post" enctype="multipart/form-data">
      <table width="90%" id="ordertbl" align="center" border="0" cellspacing="5" cellpadding="5" >
        <tr>
            <td width="15%">
                <div class="control-group">
                    <div class="controls">
                        <label class="control-label">Report By :</label>
                            <select name="type" id="type" class="validate[required] input-medium" tabindex="2" >
                                <option value="">select</option>
                                <option value="1" <?php if(isset($ext['type']) && $ext['type'] == 1) { ?> selected="selected" <?php } ?> >Product wise</option>
                                <option value="2" <?php if(isset($ext['type']) && $ext['type'] == 2) { ?> selected="selected" <?php } ?> >Customer wise</option>
                                <option value="3" <?php if(isset($ext['type']) && $ext['type'] == 3) { ?> selected="selected" <?php } ?> >Invoice Number wise</option>
                            </select>
                    </div>             
                </div>
            </td>
            
            <td width="50%">
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
           
        </tr>
        <tr>
        <td colspan="3">
        <?php 
		  
			  
			 $arrtype = explode(',',$ext['ordertype']);
			 
		?>
        ADMIN ORDERS <input type="checkbox" name="ordertype[]" onchange="submitSearchForm();" id="ordertype" value="0" <?php if(in_array('0',$arrtype)) { ?> checked="checked" <?php } ?>  />&nbsp;&nbsp;&nbsp;
        
        &nbsp;&nbsp;&nbsp;TABLET ORDERS <input type="checkbox" name="ordertype[]" onchange="submitSearchForm();" id="ordertype" value="1"  <?php if(in_array('1',$arrtype))  { ?> checked="checked" <?php } ?>/>
        
        &nbsp;&nbsp;&nbsp;WEB ORDERS <input type="checkbox" name="ordertype[]" onchange="submitSearchForm();" id="ordertype" value="2"  <?php if(in_array('2',$arrtype))  {  ?> checked="checked" <?php } ?>/>
       <?php if($ext['type'] != 2) { ?> 
        &nbsp;&nbsp;&nbsp;POS ORDERS <input type="checkbox" name="ordertype[]" onchange="submitSearchForm();" id="ordertype" value="3" <?php if(in_array('3',$arrtype))  { ?> checked="checked" <?php } ?> />
        <?php } ?>
       
        </td>
        
        </tr>
        
        <tr>
         <td width="33%">
            	<label class="control-label"> &nbsp; </label>
                 <input class="btn btn-large btn-info" type="submit" name="submit" value="Generate Report" />
            </td>
        </tr>
      </table>
</form>     
      <?php if(isset($ext['type']) && $ext['type'] == 1) { ?>
      	<div class="widget">
                	<div class="navbar"><div class="navbar-inner"><h6>Product report of this date: <b><?php echo $ext['fromDate']; ?></b>   <i>&nbsp;to&nbsp;</i>  <b><?php echo $ext['toDate']; ?></b></h6></div></div>
                     
                    <div class="table-overflow">
                   <table class="table table-bordered table-gradient" id="data-table">
                            <thead>
                                <tr>
                                    <th style="text-align:center">No</th>
                                    <th style="text-align:center">Product Id</th>
                                    <th style="text-align:center">Product Name</th>
                                    <th style="text-align:center">Unit</th>
                                    <?php if(isset($ext['order_type']) && $ext['order_type'] != 3) { ?>
                                    <th style="text-align:center">No Of Packets</th>
                                    <?php } ?> 
                                    <th style="text-align:center">SO Quantity</th>
                                    <th style="text-align:center">Total Discount</th>
                                    <th style="text-align:center">Total Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                            
                            <?php //echo "<pre>"; print_r($data);exit;?>
                            
                           <?php 
						   	   $packets = 0 ;
							   $quantity = 0 ;
							   $amount = 0 ;
							   $discount_amount	=0;
							   $i=1; 
							   foreach($data as $row) {
								   /*echo "<pre>"; 
								   print_r($data);
								   exit;*/
						   ?>
                                <tr>
                                    <td style="text-align:center"><?php echo $i ; ?></td>
                                    <td style="text-align:right"><?php echo $row['product_id'] ; ?></td>
                                    <td><?php echo $row['product_name'] ; ?></td>
                                    <td><?php echo $row['unit_name'] ; ?></td>
                                    <?php if(isset($ext['order_type']) && $ext['order_type'] != 3) { ?>
                                    <td style="text-align:right"><?php if(isset($ext['no_of_packets'])) { echo $row['no_of_packets'] ; } ?></td>
                                    <?php } ?>
                                    <td style="text-align:right"><?php echo $row['so_quantity'] ; ?></td>
                                    
                                    
                                    
                                    <td style="text-align:right"><?php if(isset($row['discount_amount'])){echo round($row['discount_amount'],0);} else{echo 0;} ?></td>
                                    <td style="text-align:right"><?php echo round($row['amount'],0) ; ?></td>
                                </tr>
						  <?php 
						      if(isset($ext['no_of_packets'])) {
						  	  	$packets = $packets + $row['no_of_packets'] ;
							  }
							  $quantity = $quantity + $row['so_quantity'] ;
							  $amount = $amount + $row['amount'] ;
							  $discount_amount = $discount_amount + $row['discount_amount'];
							  $i++ ; 
							  } 
							 
							  if(!empty($data)) { 
						  ?>
                          		<?php /*?><tr>
                                	<td colspan="4" style="text-align:center"><strong>TOTAL</strong></td>
                                    <td style="text-align:right"><strong><?php echo $packets ; ?></strong></td>
                                    <td style="text-align:right"><strong>-</strong></td>
                                    <td style="text-align:right"><strong><?php echo $amount ; ?></strong></td>
                                </tr>	<?php */?>
						  <?php }else { ?>
                          		<?php /*?><tr>
                                	<td style="text-align:center;" colspan="5">Data not found.</td>
                                </tr><?php */?>
						  <?php }?>
                            </tbody>
                        </table>
                     <table class="table table-gradient">
                     	<?php if(isset($ext['order_type']) && $ext['order_type'] != 3) { ?>
                        <tr>
                            <td width="15%" align="right"><b>Total Packets :</b></td>
                            <td><b><?php echo $packets ; ?></b></td>
                        </tr>
                        <?php  } ?>
                        <tr>
                            <td width="15%" align="right"><b>Total Amount :</b></td>
                            <td><b><?php echo round($amount,0) ; ?></b></td>
                        </tr>
                        <tr>
                            <td width="15%" align="right"><b>Total Discount :</b></td>
                            <td><b><?php echo round($discount_amount,0) ; ?></b></td>
                        </tr>
                    </table>
                    </div>
                </div>
      <?php } ?>
      
      <?php if(isset($ext['type']) && $ext['type'] == 2) { ?>
      	<div class="widget">
                	<div class="navbar"><div class="navbar-inner"><h6>Customer sales report of this date: <b><?php echo $ext['fromDate']; ?></b>   <i>&nbsp;to&nbsp;</i>  <b><?php echo $ext['toDate']; ?></b></h6></div></div>
                    <div class="table-overflow">
                        <table class="table table-bordered table-gradient" id="data-table">
                            <thead>
                                <tr>
                                    <th style="text-align:center">No</th>
                                    <th style="text-align:center">Customer Id</th>
                                    <th style="text-align:center">Customer Name</th>
                                    <th style="text-align:center">No Of Packets</th>
                                    <th style="text-align:center">SO Amount</th>
                                    <th style="text-align:center">Cash Amount</th>
                                    <th style="text-align:center">Credit Amount</th>
                                    <th style="text-align:center">Coupon Amount</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                           <?php 
						   	   $packets = 0 ;
							   $so_amount = 0 ;
							   $cash_amount = 0 ;	
							   $credit_amount = 0 ;
							   $coupon_amount = 0 ;
							   $i=1; 
							   foreach($data as $row) { 
						   ?>
                                <tr>
                                    <td style="text-align:center"><?php echo $i ; ?></td>
                                    <td style="text-align:right"><?php echo $row['representativeId'] ; ?></td>
                                    <td><?php echo $row['customer_name'] ; ?></td>
                                    <td style="text-align:right"><?php if($row['no_of_packets'] != "") { echo $row['no_of_packets'] ; } else { echo "0";} ?></td>
                                    <td style="text-align:right"><?php if($row['so_amount'] != "") { echo $row['so_amount'] ; } else { echo "0";} ?></td>
                                    <td style="text-align:right"><?php if($row['cash_amount'] != "") { echo $row['cash_amount'] ; } else { echo "0";} ?></td>
                                    <td style="text-align:right"><?php if($row['so_amount'] != "" && $row['cash_amount'] != "") { echo number_format($row['so_amount'] - $row['cash_amount'],2) ; } else { echo "0";} ?></td>
                                    <td style="text-align:right"><?php if($row['coupon_amount'] != "") { echo $row['coupon_amount'] ; } else { echo "0";} ?></td>
                                </tr>
						  <?php 
						  	  $packets = $packets + $row['no_of_packets'] ;
							  $so_amount = $so_amount + $row['so_amount'] ;
							  $cash_amount = $cash_amount + $row['cash_amount'] ;
							  $credit_amount = $credit_amount + round($row['credit_amount'],0) ;
							  $coupon_amount = $coupon_amount + round($row['coupon_amount'],0) ;
							  
							  $i++ ; 
							  } 
							 
							  if(!empty($data)) { 
						  ?>
                          		<?php /*?><tr>
                                	<td colspan="3" style="text-align:center"><strong>TOTAL</strong></td>
                                    <td style="text-align:right"><strong><?php echo $packets ; ?></strong></td>
                                    <td style="text-align:right"><strong><?php echo $so_amount ; ?></strong></td>
                                    <td style="text-align:right"><strong><?php echo $cash_amount ; ?></strong></td>
                                    <td style="text-align:right"><strong><?php echo $credit_amount ; ?></strong></td>
                                    <td style="text-align:right"><strong><?php echo $coupon_amount ; ?></strong></td>
                                </tr>	<?php */?>
						  <?php }else { ?>
                          		<?php /*?><tr>
                                	<td style="text-align:center;" colspan="8">Data not found.</td>
                                </tr><?php */?>
						  <?php }?>
                            </tbody>
                        </table>
                        <table class="table table-gradient">
                        <tr>
                            <td width="20%" align="right"><b>Total Packets :</b></td>
                            <td><b><?php echo $packets ; ?></b></td>
                        </tr>
                        <tr>
                            <td align="right"><b>Total SO Amount :</b></td>
                            <td><b><?php echo round($so_amount,0) ; ?></b></td>
                        </tr>
                        <tr>
                            <td align="right"><b>Total Cash Amount :</b></td>
                            <td><b><?php echo round($cash_amount,0) ; ?></b></td>
                        </tr>
                        <tr>
                            <td align="right"><b>Total Credit Amount :</b></td>
                            <td><b><?php echo $credit_amount ; ?></b></td>
                        </tr>
                        <tr>
                            <td align="right"><b>Total Coupon Amount :</b></td>
                            <td><b><?php echo $coupon_amount ; ?></b></td>
                        </tr>
                    </table>
                    </div>
                </div>
      <?php } ?>
      
      <?php if(isset($ext['type']) && $ext['type'] == 3) { ?>
      	<div class="widget">
                	<div class="navbar"><div class="navbar-inner"><h6>Invoice sales report of this date: <b><?php echo $ext['fromDate']; ?></b>   <i>&nbsp;to&nbsp;</i>  <b><?php echo $ext['toDate']; ?></b></h6></div></div>
                    <div class="table-overflow">
                        <table class="table table-bordered table-gradient" id="data-table">
                           
                                <tr>
                                    <th style="text-align:center">No</th>
                                    <th style="text-align:center">SO Id</th>
                                    <th style="text-align:center">Customer Id</th>
                                    <th style="text-align:center">Customer Name</th>
                                    <th style="text-align:center">SO Amount</th>
                                    <th style="text-align:center">Discount Amount</th>
                                </tr>
                         
                            
                           <?php 
							   $so_amount = 0 ;
							   $discount_amount = 0 ;	
							   $i=1; 
							   foreach($data as $row) { 
						   ?>
                                <tr>
                                    <td style="text-align:center"><?php echo $i ; ?></td>
                                    <td style="text-align:right"><?php echo $row['so_id'] ; ?></td>	
                                    <td style="text-align:right"><?php echo $row['representativeId'] ; ?></td>
                                    <td><?php echo $row['customer_name'] ; ?></td>
                                    <td style="text-align:right"><?php if($row['so_amount'] != "") { echo round($row['so_amount'],0) ; } else { echo "0";} ?></td>
                                    <td style="text-align:right"><?php if($row['discount_amount'] != "") { echo round($row['discount_amount'],0) ; } else { echo "0";} ?></td>
                                </tr>
						  <?php 
							  $so_amount = $so_amount + $row['so_amount'] ;
							  $discount_amount = $discount_amount + $row['discount_amount'];
							  
							  $i++ ; 
							  } 
						  ?>
                          
                            
                             <tr>
                              	  <td>&nbsp;&nbsp;&nbsp;</td>
                                   <td>&nbsp;&nbsp;&nbsp;</td>
                                   <td>&nbsp;&nbsp;&nbsp;</td>
                                   <td>&nbsp;&nbsp;&nbsp;</td>	
                                   <td style="text-align:right">
                                        <b>Total Discount Amount :</b>
                                   </td>
                                   <td style="text-align:right">
                                         <?php echo round($discount_amount); ?>
                                   </td>
                          	  </tr>	
                           
                        </table>

                        <table class="table table-gradient">
                        <tr>
                            <td align="right" width="20%"><b>Total SO Amount :</b></td>
                            <td align="left"><b><?php echo round($so_amount) ; ?></b></td>
                        </tr>
                        <tr>
                            <td align="right" width="20%"><b>Total Discount Amount :</b></td>
                            <td align="left"><b><?php echo round($discount_amount); ?></b></td>
                        </tr>
                    </table>
                    </div>
                </div>
      <?php } ?>
    </div>
  </div>

<!-- /default form --> 
