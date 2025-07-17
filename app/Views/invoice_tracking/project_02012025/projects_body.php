<?php
/**
 * Projects Body Page
 */ 
$rows = isset($params['rows']) ? $params['rows'] : 10;
$page_no = isset($params['pageno']) ? $params['pageno'] : 1;
$sort_by = isset($params['sortby']) ? $params['sortby'] : 'name';
$sort_order = ($params['sort_order'] == 'desc') ? 'desc' : 'asc';
$sort_order_alt = ($params['sort_order'] == 'desc') ? 'asc' : 'desc';
$arrow = ($params['sort_order'] == 'desc') ? '<i class="bi bi-arrow-down"></i>' : '<i class="bi bi-arrow-up"></i>';
$keywords = isset($params['keywords']) ? $params['keywords'] : '';
$tRecords = isset($total_records) ? $total_records : 0;
$total_pages = ceil($tRecords/$rows);
$loc_val = isset($params['loc_ext']) ? $params['loc_ext'] : '';
$client_val = isset($params['client_ext']) ? $params['client_ext'] : '';
$completion_date_val = isset($params['complete_date']) ? $params['complete_date'] : '';
$extention_date_val = isset($params['extens_date']) ? $params['extens_date'] : '';
$code_val = isset($params['code_ext']) ? $params['code_ext'] : '';
$name_val = isset($params['name_ext']) ? $params['name_ext'] : '';
?>
<div class="clearfix">	
	<div class="float-start d-flex align-items-center">
		<div class="me-1">
			<input class="form-control form-control-sm" type="text" name="keywords" id="keywords" placeholder="Search here..." value="<? echo $keywords; ?>">
		</div>	
		<div class="me-1">
			<button class="btn btn-sm btn-success" type="button" onclick="projectsBody('<? echo $rows; ?>', '1', '<? echo $sort_by; ?>', '<? echo $sort_order; ?>')"><i class="bi bi-search"></i></button>
			<button class="btn btn-sm btn-warning" onclick="resetProjectsBody()"><i class="bi bi-arrow-clockwise"></i></button>
		</div>
		<div class="me-1"><strong>(&nbsp;<? echo $tRecords; ?>&nbsp;Records&nbsp;)</strong></div>
	</div>
	<div class="float-end d-flex align-items-center">
		<div class="me-1"><button type="button" class="btn btn-success btn-sm" onclick="addProject()"><i class="bi bi-plus-square"></i>&nbsp;Add Project</button></div>
		<div class="me-1">
			<select class="form-select form-select-sm" name="rows" id="rows" onchange="projectsBody(this.value,'<? echo $page_no; ?>','<? echo $sort_by; ?>','<? echo $sort_order; ?>')">
				<option value="10" <? if($rows == 10) print 'selected="selected"'?>>10<? echo "Records"; ?></option>
				<option value="20" <? if($rows == 20) print 'selected="selected"'?>>20<? echo "Records"; ?></option>
				<option value="50" <? if($rows == 50) print 'selected="selected"'?>>50<? echo "Records"; ?></option>
				<option value="100" <? if($rows == 100) print 'selected="selected"'?>>100<? echo "Records"; ?></option>
			</select>
		</div>
		<div class="me-0">
			<nav aria-label="Page navigation example">
				<ul class="pagination pagination-sm mb-0 inv-tracking-pagination"> 
			 		<?	if($page_no == 1) { ?>
						<li class="page-item disabled">
							<a class="page-link" href="javascript:void(0);"><i class="bi bi-chevron-double-left"></i></a>
						</li>
						<li class="page-item disabled">
							<a class="page-link" href="javascript:void(0);"><i class="bi bi-chevron-left"></i></a>
						</li>
					<? }
					else { ?>
						<li class="page-item">
							<a class="page-link" href="javascript:void(0);" onclick="projectsBody('<? echo $rows; ?>','1','<? echo $sort_by; ?>','<? echo $sort_order; ?>')"><i class="bi bi-chevron-double-left"></i></a>
		                </li>
		                <li class="page-item">
		                    <a class="page-link" href="javascript:void(0);" onclick="projectsBody('<? echo $rows; ?>','<? print $page_no - 1; ?>','<? echo $sort_by; ?>','<? echo $sort_order; ?>')"><i class="bi bi-chevron-left"></i></a>
		                </li><? } ?>
						<li class="page-item active" aria-current="page">
	                    	<span class="page-link p-0 text-white inv-tracking-select">
								<select class="form-select form-select-sm" name="rows" onchange="projectsBody('<? echo $rows; ?>',this.value,'<? echo $sort_by; ?>','<? echo $sort_order; ?>')">
							 	<? for($i = 1; $i <= $total_pages; $i++) { ?>
									<option value="<? echo $i; ?>" <? if($i == $page_no) echo 'selected="selected"'; ?>><? echo $i . '/' . $total_pages; ?></option><? } ?>
								</select>
							</span>
						</li>
		        	<? if ($page_no == $total_pages) { ?>
		               	<li class="page-item disabled">
		               		<a class="page-link" href="javascript:void(0);"><i class="bi bi-chevron-right"></i></a>
		               	</li>
		               	<li class="page-item disabled">
		               		<a class="page-link" href="javascript:void(0);"><i class="bi bi-chevron-double-right"></i></a>
		               	</li>
		           	<? }
		          	else { ?>
		               	<li class="page-item">
		               	    <a class="page-link" href="javascript:void(0);" onclick="projectsBody('<? echo $rows; ?>','<? print $page_no + 1; ?>','<? echo $sort_by; ?>','<? echo $sort_order; ?>')"><i class="bi bi-chevron-right"></i></a>
		               	</li>
		               	<li class="page-item">
		               		<a class="page-link" href="javascript:void(0);" onclick="projectsBody('<? echo $rows; ?>','<? print $total_pages; ?>','<? echo $sort_by; ?>','<? echo $sort_order; ?>')"><i class="bi bi-chevron-double-right"></i></a>
		               	</li>
		           	<? } ?>
		        </ul>
		    </nav>
		</div>
	</div>
</div>
<div class="table-responsive freeze-table mt-2">
	<table class="table table-bordered table-hover table-striped table-sm">
		<thead>
			<tr class="align-middle">
				<th rowspan="2" width="1%" class="text-center">S.No.</th>
				<th rowspan="2" nowrap><? if($sort_by == 'code') print $arrow; ?><a href="javascript:void(0)" onclick="projectsBody('<? echo $rows; ?>','<? print $page_no; ?>','code','<? echo $sort_order_alt; ?>')">Code</a></th>
				<th rowspan="2" nowrap><? if($sort_by == 'p.name') print $arrow; ?><a href="javascript:void(0)" onclick="projectsBody('<? echo $rows; ?>','<? print $page_no; ?>','p.name','<? echo $sort_order_alt; ?>')">Name</a></th>
				<th rowspan="2" nowrap>Location</th>
				<th rowspan="2" nowrap>Client</th>
				<th rowspan="2" nowrap title="Project Management Consultant">PMC</th>
				<th rowspan="2" nowrap title="Design Engineer Consultant">DEC</th>
				<th rowspan="2" nowrap title="Notification of Award"><? if($sort_by == 'noa') print $arrow; ?><a href="javascript:void(0)" onclick="projectsBody('<? echo $rows; ?>','<? print $page_no; ?>','noa','<? echo $sort_order_alt; ?>')">NOA</a></th>
				<th rowspan="2" nowrap><? if($sort_by == 'completion_date') print $arrow; ?><a href="javascript:void(0)" onclick="projectsBody('<? echo $rows; ?>','<? print $page_no; ?>','completion_date','<? echo $sort_order_alt; ?>')">Completion Date</a></th>
				<th rowspan="2" nowrap><? if($sort_by == 'extension_date') print $arrow; ?><a href="javascript:void(0)" onclick="projectsBody('<? echo $rows; ?>','<? print $page_no; ?>','extension_date','<? echo $sort_order_alt; ?>')">Extension Date</a></th>
				<th colspan="4" nowrap class="text-center">Contract Value</th>
				<th rowspan="2" nowrap class="text-end">Total in INR</th>
				<th rowspan="2" nowrap class="text-end">Total INR(in Crs)</th>
				<th rowspan="2" nowrap class="text-center">Actions</th>
			</tr>
			<tr class="align-middle">
				<th class="text-end" nowrap>INR</th>
				<th class="text-end" nowrap>Other Currencies</th>
				<th class="text-end" nowrap>Conversion Rate</th>
				<th class="text-end" nowrap>Convertion in INR</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td class="text-center">#</td>
				<td nowrap>
					<input class="form-control form-control-sm" type="text" name="code_ext" id="code_ext" value="<?= $code_val; ?>" placeholder="Code">
				</td>
				<td nowrap>
					<input class="form-control form-control-sm" type="text" name="name_ext" id="name_ext" value="<?= $name_val; ?>" placeholder="Name">
				</td>
				<td nowrap>
					<select class="form-select form-select-sm" name="loc_ext" id="loc_ext" onchange="projectsBody('<? echo $rows; ?>','<? echo $page_no; ?>','<? echo $sort_by; ?>','<? echo $sort_order; ?>')">
						<option value="">All</option>
						<? foreach ($locations as $key => $value) { ?>
							<option value="<?= $value['id']; ?>"<? if($loc_val == $value['id']){ echo "selected";}?>><?= $value['name']; ?></option>
						<? } ?>
					</select>
				</td>
				<td nowrap>
					<select class="form-select form-select-sm" name="client_ext" id="client_ext" onchange="projectsBody('<? echo $rows; ?>','<? echo $page_no; ?>','<? echo $sort_by; ?>','<? echo $sort_order; ?>')">
						<option value="">All</option>
						<? foreach ($clients as $key1 => $value1) { ?>
							<option value="<?= $value1['id']; ?>"<? if($client_val == $value1['id']){ echo "selected";}?>><?= $value1['name']; ?></option>
						<? } ?>
					</select>
				</td>
				<td nowrap></td>
				<td nowrap></td>
				<td nowrap>
					
				</td>
				<td nowrap>
					<div class="input-group input-group-sm date">
                        <input type="text" name="complete_date" id="complete_date" class="form-control" value="<?= $completion_date_val; ?>" placeholder="DD-MM-YYYY">
                        <span class="input-group-text"><i class="bi bi-calendar4-week"></i></span>
                    </div>
				</td>
				<td nowrap>
					<div class="input-group input-group-sm date">
                        <input type="text" name="extens_date" id="extens_date" class="form-control" value="<?= $extention_date_val; ?>" placeholder="DD-MM-YYYY">
                        <span class="input-group-text"><i class="bi bi-calendar4-week"></i></span>
                    </div>
				</td>
				<td nowrap></td>
				<td nowrap></td>
				<td nowrap></td>
				<td nowrap></td>
				<td nowrap></td>
				<td nowrap></td>
				<td nowrap class="text-center">
					<button class="btn btn-sm btn-secondary" type="button" onclick="projectsBody('<? echo $rows; ?>', '1', '<? echo $sort_by; ?>', '<? echo $sort_order; ?>')"><i class="bi bi-funnel"></i></button>
					<button class="btn btn-sm btn-warning" onclick="resetProjectsBody()"><i class="bi bi-arrow-clockwise"></i></button>
				</td>
			</tr>
			<?php 	
			if($projects){
				$i=($page_no-1)*$rows+1;
				$con_inr = $tot_inr = $tot_cr = 0;
				foreach ($projects as $key => $value) {
					$con_inr = round(($value['ex_rate']*$value['contract_value']),2);
					$tot_inr = round(($con_inr+$value['contract_value_inr']),2);
					$tot_cr = round(($tot_inr/10000000),2);
				 ?>
				<tr>
					<td class="text-center"><?= $i++; ?></td>
					<td nowrap><a href="javascript:void(0)" onclick="viewProject(<?= $value['id'] ?>)"><?= $value['code']; ?></a></td>
					<td nowrap><?= $value['name']; ?></td>
					<td nowrap><?= $value['location']; ?></td>
					<td nowrap><?= $value['client']; ?></td>
					<td nowrap><?= $value['pm_c']; ?></td>
					<td nowrap><?= $value['de_c']; ?></td>
					<td nowrap><?= displayDate($value['noa']); ?></td>
					<td nowrap><?= displayDate($value['completion_date']); ?></td>
					<td nowrap><?= displayDate($value['extension_date']); ?></td>
					<td nowrap class="text-end"><?= displayNumber($value['contract_value_inr'],2); ?></td>
					<td nowrap class="text-end" nowrap="nowrap"><?= ($value['contract_value'] > 0) ? $currencies[$value['currency']]['symbol'].' '.displayNumber($value['contract_value'],2) : ''; ?></td>
					<td nowrap class="text-end"><?= ($value['ex_rate'] > 0) ? displayNumber($value['ex_rate'],2) : ''; ?></td>
					<td nowrap class="text-end"><?= ($con_inr > 0) ? displayNumber($con_inr,2) : ''; ?></td>
					<td nowrap class="text-end"><?= displayNumber($tot_inr,2); ?></td>
					<td nowrap class="text-end"><?= displayNumber($tot_cr,2); ?></td>
					<td nowrap class="text-center">
						<div class="dropdown">
						  	<button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="actionMenu" data-bs-toggle="dropdown" aria-expanded="false"><i class="bi bi-list"></i></button>
						  	<ul class="dropdown-menu" aria-labelledby="actionMenu">
						  	  	<li><a class="dropdown-item" href="javascript:void(0)" onclick="viewProject(<?= $value['id']; ?>)"><i class="bi bi-info-square"></i>&nbsp;View</a></li>
						  	  	<li><a class="dropdown-item" href="javascript:void(0)" onclick="editProject(<?= $value['id']; ?>)"><i class="bi bi-pencil-square"></i>&nbsp;Edit</a></li>
						  	  	<li><a class="dropdown-item" href="javascript:void(0)" onclick="deleteProject(<?= $value['id']; ?>)"><i class="bi bi-x-square"></i>&nbsp;Delete</a></li>
						  	</ul>
						</div>
					</td>
				</tr>
		<? }
		}
		else { ?>
			<tr>
				<td colspan="17" class="bg bg-warning">No Records Found</td>
			</tr>
		<? } ?>
		</tbody>
	</table>
</div>
<script type="text/javascript">
	$(document).ready
    $(function(){
    	$('#complete_date').datepicker({format:'dd-mm-YYYY',autoHide:true});
    	$('#extens_date').datepicker({format:'dd-mm-YYYY',autoHide:true});
    	// Tbale freeze
    	$('.freeze-table').freezeTable({'freezeColumn': true, 'columnNum': 2, 'freezeColumnHead': true, 'fixedNavbar': '.navbar-custom','namespace': 'first-table'});
    	$('.freeze-table').scroll(function() {
            $('.freeze-table').freezeTable('resize');
        })
    })
</script>