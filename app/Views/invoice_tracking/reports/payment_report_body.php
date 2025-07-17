<?php
/**
 * Payment Report Body Page
 */ 
$keywords = isset($params['keywords']) ? $params['keywords'] : '';
$pageno = isset($params['page_no']) ? $params['page_no'] : 1;
$sortby = isset($params['sort_by']) ? $params['sort_by'] : '';
$sort_order = isset($params['sort_order']) ? $params['sort_order'] : 'desc';
$rows = isset($params['rows']) ? $params['rows'] : 20;
$total_records = isset($tRecords) ? $tRecords : 0;
$total_pages = ceil($total_records/$rows);
$project_val = isset($params['project_ext']) ? $params['project_ext'] : '';
$client_val = isset($params['client_ext']) ? $params['client_ext'] : '';
$inv_no_val = isset($params['invoice_number']) ? $params['invoice_number'] : '';
$payment_type_val = isset($params['pay_type_ext']) ? $params['pay_type_ext'] : '';
$file_upload_val = isset($params['file_payment']) ? $params['file_payment'] : "";
$sort_order_alt = ($params['sort_order'] == 'desc') ? 'asc' : 'desc';
$arrow = ($params['sort_order'] == 'desc') ? '<i class="bi bi-arrow-down"></i>' : '<i class="bi bi-arrow-up"></i>';
?>
<div class="clearfix">
	<div class="float-start d-flex align-items-center">
		<div class="me-1">
			<input type="text" class="form-control form-control-sm" name="keywords" id="keywords" value="<? print $keywords; ?>" placeholder="Search...">
		</div>
		<div class="me-1">
			<button type="button" class="btn btn-sm btn-success" name="search" id="search" onclick="paymentReportBody('<? print $rows; ?>', '<? print $pageno; ?>', '<? print $sortby ?>', '<? print $sort_order; ?>')"><i class="bi bi-search"></i></button>
		</div>
		<div class="me-1">
			<button type="button" class="btn btn-sm btn-warning" name="search" id="search" onclick="resetPaymentReportBody()"><i class="bi bi-arrow-clockwise"></i></button>
		</div>
		<div class="me-1">
			<strong>(&nbsp;<? echo $tRecords; ?>&nbsp;Records&nbsp;)</strong>
		</div>
	</div>
	<div class="float-end d-flex align-items-center">
		<div class="me-1">
			<select class="form-select form-select-sm" name="rows" id="rows" onchange="paymentReportBody(this.value,'<? echo $pageno; ?>','<? echo $sortby; ?>','<? echo $sort_order; ?>')">
				<option value="10" <? if($rows == 10) print 'selected="selected"'?>>10<? echo "Records"; ?></option>
				<option value="20" <? if($rows == 20) print 'selected="selected"'?>>20<? echo "Records"; ?></option>
				<option value="50" <? if($rows == 50) print 'selected="selected"'?>>50<? echo "Records"; ?></option>
				<option value="100" <? if($rows == 100) print 'selected="selected"'?>>100<? echo "Records"; ?></option>
			</select>
		</div>
		<div class="me-0">
			<nav aria-label="Page navigation example">
				<ul class="pagination pagination-sm mb-0 inv-tracking-pagination"> 
			 		<?	if($pageno == 1) { ?>
						<li class="page-item disabled">
							<a class="page-link" href="javascript:void(0);"><i class="bi bi-chevron-double-left"></i></a>
						</li>
						<li class="page-item disabled">
							<a class="page-link" href="javascript:void(0);"><i class="bi bi-chevron-left"></i></a>
						</li>
					<? }
					else { ?>
						<li class="page-item">
							<a class="page-link" href="javascript:void(0);" onclick="paymentReportBody('<? echo $rows; ?>','1','<? echo $sortby; ?>','<? echo $sort_order; ?>')"><i class="bi bi-chevron-double-left"></i></a>
		                </li>
		                <li class="page-item">
		                    <a class="page-link" href="javascript:void(0);" onclick="paymentReportBody('<? echo $rows; ?>','<? print $pageno - 1; ?>','<? echo $sortby; ?>','<? echo $sort_order; ?>')"><i class="bi bi-chevron-left"></i></a>
		                </li><? } ?>
						<li class="page-item active" aria-current="page">
	                    	<span class="page-link p-0 text-white inv-tracking-select">
								<select class="form-select form-select-sm" name="rows" onchange="paymentReportBody('<? echo $rows; ?>',this.value,'<? echo $sortby; ?>','<? echo $sort_order; ?>')">
							 	<? for($i = 1; $i <= $total_pages; $i++) { ?>
									<option value="<? echo $i; ?>" <? if($i == $pageno) echo 'selected="selected"'; ?>><? echo $i . '/' . $total_pages; ?></option><? } ?>
								</select>
							</span>
						</li>
		        	<? if ($pageno == $total_pages) { ?>
		               	<li class="page-item disabled">
		               		<a class="page-link" href="javascript:void(0);"><i class="bi bi-chevron-right"></i></a>
		               	</li>
		               	<li class="page-item disabled">
		               		<a class="page-link" href="javascript:void(0);"><i class="bi bi-chevron-double-right"></i></a>
		               	</li>
		           	<? }
		          	else { ?>
		               	<li class="page-item">
		               	    <a class="page-link" href="javascript:void(0);" onclick="paymentReportBody('<? echo $rows; ?>','<? print $pageno + 1; ?>','<? echo $sortby; ?>','<? echo $sort_order; ?>')"><i class="bi bi-chevron-right"></i></a>
		               	</li>
		               	<li class="page-item">
		               		<a class="page-link" href="javascript:void(0);" onclick="paymentReportBody('<? echo $rows; ?>','<? print $total_pages; ?>','<? echo $sortby; ?>','<? echo $sort_order; ?>')"><i class="bi bi-chevron-double-right"></i></a>
		               	</li>
		           	<? } ?>
		        </ul>
		    </nav>
		</div>
	</div>
</div>
<div class="table table-responsive freeze-table mt-2">
	<table class="table table-bordered table-hover table-striped table-condensed mb-0">
		<thead>
			<tr>
				<th width="1%" class="text-center">S.No.</th>
				<th nowrap><? if($sortby == 'i.inv_number') print $arrow; ?><a href="javascript:void(0)" onclick="paymentReportBody('<? echo $rows; ?>','<? print $pageno; ?>','i.inv_number','<? echo $sort_order_alt; ?>')">Invoice Number</a></th>
				<th nowrap><? if($sortby == 'invoice_payment.payment_date') print $arrow; ?><a href="javascript:void(0)" onclick="paymentReportBody('<? echo $rows; ?>','<? print $pageno; ?>','invoice_payment.payment_date','<? echo $sort_order_alt; ?>')">Payment Date</a></th>
				<th nowrap class="text-end"><? if($sortby == 'invoice_payment.amount') print $arrow; ?><a href="javascript:void(0)" onclick="paymentReportBody('<? echo $rows; ?>','<? print $pageno; ?>','invoice_payment.amount','<? echo $sort_order_alt; ?>')">Amount</a></th>
				<th nowrap><? if($sortby == 'p.code') print $arrow; ?><a href="javascript:void(0)" onclick="paymentReportBody('<? echo $rows; ?>','<? print $pageno; ?>','p.code','<? echo $sort_order_alt; ?>')">Project Code</a></th>
				<th nowrap><? if($sortby == 'c.name') print $arrow; ?><a href="javascript:void(0)" onclick="paymentReportBody('<? echo $rows; ?>','<? print $pageno; ?>','c.name','<? echo $sort_order_alt; ?>')">Client</a></th>
				<th nowrap><? if($sortby == 'invoice_payment.payment_type') print $arrow; ?><a href="javascript:void(0)" onclick="paymentReportBody('<? echo $rows; ?>','<? print $pageno; ?>','invoice_payment.payment_type','<? echo $sort_order_alt; ?>')">Payment Type</a></th>
				<th nowrap>Reference Number</th>
				<th nowrap class="text-center">File</th>
				<th nowrap class="text-center">Note</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td class="text-center">#</td>
				<td nowrap>
					<input class="form-control form-control-sm" type="text" name="invoice_number" id="invoice_number" value="<?= $inv_no_val ?>">
				</td>
				<td nowrap></td>
				<td nowrap></td>
				<td nowrap>
					<select class="form-select form-select-sm" name="project_ext" id="project_ext">
						<option value="">All</option>
						<?
						foreach($projects as $p_key => $project) { ?>
							<option value="<?= $project['id'] ?>"<? if($project_val == $project['id']){ echo 'selected'; }?>><?= $project['code'] ?></option>
						<? } ?>
					</select>
				</td>
				<td nowrap>
					<select class="form-select form-select-sm" name="client_ext" id="client_ext">
						<option value="">All</option>
						<?
						foreach($clients as $c_key => $client) { ?>
							<option value="<?= $client['id'] ?>"<? if($client_val == $client['id']){ echo 'selected'; }?>><?= $client['name'] ?></option>
						<? } ?>
					</select>
				</td>
				<td nowrap>
					<select class="form-select form-select-sm" name="pay_type_ext" id="pay_type_ext">
						<option value="">All</option>
						<?
						foreach($payment_types as $pt_key => $pay_type) { ?>
							<option value="<?= $pay_type['id'] ?>"<? if($payment_type_val == $pay_type['id']){ echo 'selected'; }?>><?= $pay_type['name'] ?></option>
						<? } ?>
					</select>
				</td>
				<td nowrap></td>
				<td nowrap>
					<select class="form-select form-select-sm" name="file_payment" id="file_payment">
						<option value="" <? if($file_upload_val == "") { echo "selected"; }?>>All</option>
						<option value="1"<? if($file_upload_val == "1") { echo "selected"; }?>>Uploaded</option>
						<option value="2"<? if($file_upload_val == "2") { echo "selected"; }?>>Not Uploaded</option>
					</select>
				</td>
				<td nowrap class="text-center">
					<button class="btn btn-sm btn-secondary" type="button" onclick="paymentReportBody('<? echo $rows; ?>', '1', '<? echo $sortby; ?>', '<? echo $sort_order; ?>')"><i class="bi bi-funnel"></i></button>
					<button class="btn btn-sm btn-warning" onclick="resetPaymentReportBody()"><i class="bi bi-arrow-clockwise"></i></button>
				</td>
			</tr>
			<? 	
			if($invoice_payments) {
				$i = (($pageno - 1) * $rows) + 1;
				foreach ($invoice_payments as $ip_key => $inv_payment) {
				 ?>
				<tr>
					<td class="text-center"><?= $i++; ?></td>
					<td nowrap><a href="javascript:void(0)" onclick="viewInvoice(<?= $inv_payment['invoice_id'] ?>, 3)"><?= $inv_payment['inv_number']; ?></a></td>
					<td nowrap><?= displayDate($inv_payment['payment_date']); ?></td>
					<td nowrap class="text-end"><?= displayNumber($inv_payment['amount'], 2); ?></td>
					<td nowrap><?= $inv_payment['project_code'] ?></td>
					<td nowrap><?= $inv_payment['client_name']; ?></td>
					<td nowrap><?= $inv_payment['pay_type']; ?></td>
					<td nowrap><?= $inv_payment['ref_number']; ?></td>
					<td nowrap class="text-center"><? if($inv_payment['payment_file'] == '') { ?>
						<i class="bi bi-circle-fill fs-600 text-danger" title="Payment Receipt"></i>
						<? }else { ?>
							<i class="bi bi-circle-fill fs-600 text-success" title="<?= $inv_payment['payment_file'] ?>"></i>
						<? } ?>
					</td>
					<td nowrap class="text-center">
						<span class="d-inline-block" tabindex="0" data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-content="<?= $inv_payment['note'] ?>" data-bs-placement="top">
						  	<button class="btn btn-primary-sm p-0 m-0" type="button"><i class="bi bi-info-circle"></i></button>
						</span>
					</td>
				</tr>
			<?  }
		}
		else {
			?>
			<tr>
				<td colspan="10">
				<div class="alert alert-warning">No Records Found</div>
				</td>
			</tr>
			<?
		}
		?>
		</tbody>
	</table>
</div>
<div class="row">
	<div class="col-md-6"></div>
	<div class="col-md-6">
		<div class="card-group">
			<div class="card text-bg-primary">
				<div class="card-body">
					<h5 class="card-title text-end fs-5"><? echo displayMoney($total_amt); ?></h5>
					<p class="card-text">Total Received Amount</p>
				</div>
			</div>
			<div class="card text-bg-success">
				<div class="card-body">
					<h5 class="card-title text-end fs-5"><? echo displayNumber(($total_amt / 10000000), 2); ?></h5>
					<p class="card-text">Total Received Amount (Cr.)</p>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$('[data-bs-toggle="popover"]').each(function(index){
		return new bootstrap.Popover($(this));
	});
	$(function() {
        $('.freeze-table').freezeTable({freezeColumn: true, columnNum: 2});
    });
</script>