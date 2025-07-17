<?php
/**
 * Deductions Body Page
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
$ded_type_val = isset($params['ded_type_ext']) ? $params['ded_type_ext'] : '';
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
			<button type="button" class="btn btn-sm btn-success" name="search" id="search" onclick="deductionReportBody('<? print $rows; ?>', '<? print $pageno; ?>', '<? print $sortby ?>', '<? print $sort_order; ?>')"><i class="bi bi-search"></i></button>
		</div>
		<div class="me-1">
			<button type="button" class="btn btn-sm btn-warning" name="search" id="search" onclick="resetDeductionBody()"><i class="bi bi-arrow-clockwise"></i></button>
		</div>
		<div class="me-1">
			<strong>(&nbsp;<? echo $tRecords; ?>&nbsp;Records&nbsp;)</strong>
		</div>
	</div>
	<div class="float-end d-flex align-items-center">
		<div class="me-1">
			<select class="form-select form-select-sm" name="rows" id="rows" onchange="deductionReportBody(this.value,'<? echo $pageno; ?>','<? echo $sortby; ?>','<? echo $sort_order; ?>')">
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
							<a class="page-link" href="javascript:void(0);" onclick="deductionReportBody('<? echo $rows; ?>','1','<? echo $sortby; ?>','<? echo $sort_order; ?>')"><i class="bi bi-chevron-double-left"></i></a>
		                </li>
		                <li class="page-item">
		                    <a class="page-link" href="javascript:void(0);" onclick="deductionReportBody('<? echo $rows; ?>','<? print $pageno - 1; ?>','<? echo $sortby; ?>','<? echo $sort_order; ?>')"><i class="bi bi-chevron-left"></i></a>
		                </li><? } ?>
						<li class="page-item active" aria-current="page">
	                    	<span class="page-link p-0 text-white inv-tracking-select">
								<select class="form-select form-select-sm" name="rows" onchange="deductionReportBody('<? echo $rows; ?>',this.value,'<? echo $sortby; ?>','<? echo $sort_order; ?>')">
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
		               	    <a class="page-link" href="javascript:void(0);" onclick="deductionReportBody('<? echo $rows; ?>','<? print $pageno + 1; ?>','<? echo $sortby; ?>','<? echo $sort_order; ?>')"><i class="bi bi-chevron-right"></i></a>
		               	</li>
		               	<li class="page-item">
		               		<a class="page-link" href="javascript:void(0);" onclick="deductionReportBody('<? echo $rows; ?>','<? print $total_pages; ?>','<? echo $sortby; ?>','<? echo $sort_order; ?>')"><i class="bi bi-chevron-double-right"></i></a>
		               	</li>
		           	<? } ?>
		        </ul>
		    </nav>
		</div>
	</div>
</div>
<div class="table table-responsive freeze-table mt-2">
	<table class="table table-bordered table-hover table-striped table-condensed mb-0">
		<thead class="align-middle">
			<tr>
				<th width="1%" class="text-center">S.No.</th>
				<th nowrap><? if($sortby == 'p.name') print $arrow; ?><a href="javascript:void(0)" onclick="deductionReportBody('<? echo $rows; ?>','<? print $pageno; ?>','p.name','<? echo $sort_order_alt; ?>')">Project</a></th>
				<th nowrap><? if($sortby == 'i.inv_number') print $arrow; ?><a href="javascript:void(0)" onclick="deductionReportBody('<? echo $rows; ?>','<? print $pageno; ?>','i.inv_number','<? echo $sort_order_alt; ?>')">Invoice Number</a></th>
				<th nowrap class="text-end"><? if($sortby == 'invoice_deduction.amount') print $arrow; ?><a href="javascript:void(0)" onclick="deductionReportBody('<? echo $rows; ?>','<? print $pageno; ?>','invoice_deduction.amount','<? echo $sort_order_alt; ?>')">Amount</a></th>
				<th nowrap><? if($sortby == 'd.name') print $arrow; ?><a href="javascript:void(0)" onclick="deductionReportBody('<? echo $rows; ?>','<? print $pageno; ?>','d.name','<? echo $sort_order_alt; ?>')">Deduction Type</a></th>
				<th nowrap><? if($sortby == 'invoice_deduction.created_at') print $arrow; ?><a href="javascript:void(0)" onclick="deductionReportBody('<? echo $rows; ?>','<? print $pageno; ?>','invoice_deduction.created_at','<? echo $sort_order_alt; ?>')">Added Date</a></th>
				<th nowrap><? if($sortby == 'c.name') print $arrow; ?><a href="javascript:void(0)" onclick="deductionReportBody('<? echo $rows; ?>','<? print $pageno; ?>','c.name','<? echo $sort_order_alt; ?>')">Client</a></th>
				<th nowrap class="text-center">File</th>
				<th nowrap class="text-center">Note</th>
			</tr>
		</thead>
		<tbody class="align-middle">
			<tr>
				<td nowrap></td>
				<td nowrap>
					<select class="form-select form-select-sm" name="project_ext" id="project_ext">
						<option value="">All</option>
						<?
						if (isset($projects) and !empty($projects)) {
							foreach($projects as $p_key => $project) { ?>
								<option value="<?= $project['id'] ?>"<? if($project_val == $project['id']){ echo 'selected'; }?>><?= $project['name']." ( ".$project['code']." ) " ?></option>
							<? }
						}
						?>
					</select>
				</td>
				<td nowrap>
					<input class="form-control form-control-sm" type="text" name="invoice_number" id="invoice_number" value="<?= $inv_no_val ?>">
				</td>
				<td nowrap></td>
				<td nowrap>
					<select class="form-select form-select-sm" name="ded_type_ext" id="ded_type_ext">
						<option value="">All</option>
						<?
						foreach($deduction_types as $dt_key => $ded_type) { ?>
							<option value="<?= $ded_type['id'] ?>"<? if($ded_type_val == $ded_type['id']){ echo 'selected'; }?>><?= $ded_type['name'] ?></option>
						<? } ?>
					</select>
				</td>
				<td nowrap></td>
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
					<select class="form-select form-select-sm" name="file_payment" id="file_payment">
						<option value="" <? if($file_upload_val == "") { echo "selected"; }?>>All</option>
						<option value="1"<? if($file_upload_val == "1") { echo "selected"; }?>>Uploaded</option>
						<option value="2"<? if($file_upload_val == "2") { echo "selected"; }?>>Not Uploaded</option>
					</select>
				</td>
				<td nowrap class="text-center">
					<button class="btn btn-sm btn-secondary" type="button" onclick="deductionReportBody('<? echo $rows; ?>', '1', '<? echo $sortby; ?>', '<? echo $sort_order; ?>')"><i class="bi bi-funnel"></i></button>
					<button class="btn btn-sm btn-warning" onclick="resetDeductionBody()"><i class="bi bi-arrow-clockwise"></i></button>
				</td>
			</tr>
			<? 	
			if($invoice_deduction){
				$i=(($pageno-1)*$rows)+1;
				foreach ($invoice_deduction as $d_key => $inv_deduction) {
				 ?>
				<tr>
					<td nowrap><?= $i++; ?></td>
					<td nowrap><?= $inv_deduction['project_name']." ( ".$inv_deduction['project_code']." ) " ?></td>
					<td nowrap><a href="javascript:void(0)" onclick="viewInvoice(<?= $inv_deduction['invoice_id'] ?>, 2)"><?= $inv_deduction['inv_number']; ?></a></td>
					<td nowrap class="text-end"><?= displayNumber($inv_deduction['amount'], 2) ?></td>
					<td nowrap><?= $inv_deduction['deduct_name'] ?></td>
					<td nowrap><?= displayDate($inv_deduction['created_at']) ?></td>
					<td nowrap><?= $inv_deduction['client_name'] ?></td>
					<td nowrap class="text-center"><? if($inv_deduction['deduction_file'] == '') { ?>
						<i class="bi bi-circle-fill fs-600 text-danger" title="Invoice Copy"></i>
					<? }else { ?>
						<i class="bi bi-circle-fill fs-600 text-success" title="<?= $inv_deduction['deduction_file'] ?>"></i>
					<? } ?>
					</td>
					<td nowrap class="text-center">
						<span class="d-inline-block" tabindex="0" data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-content="<?= ($inv_deduction['note']) ? $inv_deduction['note'] : ' '; ?>" data-bs-placement="top">
						  	<button class="btn btn-primary-sm p-0 m-0" type="button"><i class="bi bi-info-circle"></i></button>
						</span>
					</td>
				</tr>
			<?  }
		}
		else { ?>
			<tr>
				<td colspan="9" class="bg bg-warning">No Records Found</td>
			</tr>
		<? } ?>
		</tbody>
	</table>
</div>
<div class="row">
	<div class="col-md-6"></div>
	<div class="col-md-6">
		<div class="card-group">
			<div class="card text-bg-primary">
				<div class="card-body">
					<h5 class="card-title text-end fs-5"><? echo displayMoney($total_amt); ?></h5><p class="card-text">Total Deduction Amount</p>
				</div>
			</div>
			<div class="card text-bg-success">
				<div class="card-body success">
					<h5 class="card-title text-end fs-5"><? echo displayNumber(($total_amt / 10000000), 2); ?></h5><p class="card-text">Total Deduction Amount (Cr.)</p>
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