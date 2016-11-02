  <div class="widget">
    <div class="navbar">
      <div class="navbar-inner">
        <h6><a href="<?php echo Yii::app()->params->base_path;?>admin/showExportData">Export Data</a>&nbsp;&nbsp;<img src="<?php echo Yii::app()->params->base_url;?>images/path-arrow.png" alt="" border="0" />&nbsp;&nbsp;Coupon Transaction Report</h6>
      </div>
    </div>
    <div class="well">
<form id="validate" action="<?php echo Yii::app()->params->base_path;?>admin/exportExcelCouponTransactionReport" method="post" enctype="multipart/form-data">
      <table width="80%" id="ordertbl" align="center" border="0" cellspacing="5" cellpadding="5" >
        <tr>
            <td width="40%">
                <div class="control-group">
                    <label class="control-label">Date range:</label>
                    <div class="controls">
                        <ul class="dates-range">
                            <li><input type="text" id="fromDate" name="from" placeholder="From" /></li>
                            <li class="sep">-</li>
                            <li><input type="text" id="toDate" name="to" placeholder="To" /></li>
                        </ul>
                    </div>
                </div>
            </td>
            
            <td width="33%">
            	<label class="control-label"> &nbsp; </label>
                 <input class="btn btn-large btn-info" type="submit" name="submit" value="Export Excel Report" />
            </td>
        </tr>
      </table>
</form>     
    </div>
  </div>

<!-- /default form --> 
