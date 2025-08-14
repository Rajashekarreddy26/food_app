<?php
/**
 * Locations Body Page
 */ 
$keywords = isset($params['keywords']) ? $params['keywords'] : '';
$page_no = isset($params['pageno']) ? $params['pageno'] : 1;
$sort_by = isset($params['sort_by']) ? $params['sort_by'] : 'id';
$sort_order = isset($params['sort_order']) ? $params['sort_order'] : 'desc';
$rows = isset($params['rows']) ? $params['rows'] : 10;
$total_pages = ceil($tRecords/$rows);
?>
<div class="clearfix">
	<div class="float-start d-flex align-items-center">
		<div class="me-1">
			<input type="text" class="form-control form-control-sm" name="keywords" id="keywords" placeholder="Search here..." value="<? print $keywords; ?>">
		</div>
		<div class="me-1">
			<div>
				<button type="button" class="btn btn-sm btn-success" name="search" id="search" onclick="usersBody('<? print $rows; ?>', '<? print $page_no; ?>', '<? print $sort_by ?>', '<? print $sort_order; ?>')"><i class="bi bi-search"></i></button>
			</div>
		</div>
		<div class="me-1">
			<div>
				<button type="button" class="btn btn-sm btn-warning" name="search" id="search" onclick="resetUsersBody()"><i class="bi bi-arrow-clockwise"></i></button>
			</div>
		</div>
		<div class="me-1">
			<div>
				<strong>(&nbsp;<? print $tRecords; ?> Records&nbsp;)</strong>
			</div>
		</div>
	</div>
	<div class="float-end d-flex align-items-center">
		<div class="me-1">
			<div>
				<a href="javascript:void(0)" class="btn btn-success btn-sm" onclick="addUser()"><i class="bi bi-plus-square"></i>&nbsp;Add User</a>
			</div>
		</div>
		<div class="me-0">
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
						<a class="page-link" href="javascript:void(0);" onclick="usersBody('<? echo $rows; ?>','1','<? echo $sort_by; ?>','<? echo $sort_order; ?>')"><i class="bi bi-chevron-double-left"></i></a>
	                </li>
	                <li class="page-item">
	                    <a class="page-link" href="javascript:void(0);" onclick="usersBody('<? echo $rows; ?>','<? print $page_no - 1; ?>','<? echo $sort_by; ?>','<? echo $sort_order; ?>')"><i class="bi bi-chevron-left"></i></a>
	                </li><? } ?>
					<li class="page-item active" aria-current="page">
                    	<span class="page-link p-0 text-white inv-tracking-select">
							<select class="form-select form-select-sm" name="rows" onchange="usersBody('<? echo $rows; ?>',this.value,'<? echo $sort_by; ?>','<? echo $sort_order; ?>')">
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
	               	    <a class="page-link" href="javascript:void(0);" onclick="usersBody('<? echo $rows; ?>','<? print $page_no + 1; ?>','<? echo $sort_by; ?>','<? echo $sort_order; ?>')"><i class="bi bi-chevron-right"></i></a>
	               	</li>
	               	<li class="page-item">
	               		<a class="page-link" href="javascript:void(0);" onclick="usersBody('<? echo $rows; ?>','<? print $total_pages; ?>','<? echo $sort_by; ?>','<? echo $sort_order; ?>')"><i class="bi bi-chevron-double-right"></i></a>
	               	</li>
	           	<? } ?>
	        </ul>
		</div>
	</div>
</div>

<div class="table table-responsive mt-2 printable">
	<table class="table table-bordered table-hover table-striped table-condensed">
		<thead>
			<tr>
				<th width="1%" class="text-center">S.No.</th>
				<th nowrap>User Type</th>
				<th nowrap>Username</th>
				<th nowrap>Name</th>
				<th nowrap>Email</th>
				<th nowrap>Phone</th>
				<th nowrap>Role</th>
				<th nowrap class="text-center">Actions</th>
			</tr>
		</thead>
		<tbody>
			<?php 	
			if($users){
				$i=(($page_no - 1)*$rows)+1;
				foreach ($users as $key => $value) {
				 ?>
				<tr>
					<td class="text-center"><?= $i++; ?></td>
					<td><?= $value['emp_id']; ?></td>
					<td><?= $value['username']; ?></td>
					<td><?= $value['fname']." ".$value['lname']; ?></td>
					<td><?= $value['email']; ?></td>
					<td><?= $value['mobile']; ?></td>
					<td><?= $roles[$value['role']]['name']; ?></td>
					<td class="text-center">
						<? if(!in_array($value['id'], [1,2])): ?>
				  	  		<a class="btn btn-sm btn-primary" href="javascript:void(0)" onclick="editUser(<?= $value['id']; ?>)"><i class="bi bi-pencil-square"></i></a>
				  	  		<a class="btn btn-sm btn-danger" href="javascript:void(0)" onclick="deleteUser(<?= $value['id']; ?>)"><i class="bi bi-trash"></i></a>
				  	  		<a class="btn btn-sm btn-warning" href="javascript:void(0)" onclick="resetPassword(<?= $value['id']; ?>)"><i class="bi bi-person-lock"></i></a>
				  	  	<? endif; ?>
					</td>
				</tr>
			<?  }
		}
		else { ?>
			<tr>
				<td colspan="7" class="bg bg-warning">No Records Found</td>
			</tr>
		<? } ?>
		</tbody>
	</table>
</div>
<div class="text-end">
	<button type="button" class="btn btn-sm btn-secondary" onclick="printPage()"><i class="bi bi-printer"></i>&nbsp;Print</button>
</div>
<script type="text/javascript">
	function printPage() {
		// Method 1 with current window
		var printCnt = $('.printable').html();
		var bodyCnt = $('body').html();
		$('body').html(printCnt);
		window.print();
		$('body').html(bodyCnt);

		// Method 2 with new window
		// var printCnt = $('.printable').html();
		// var myWindow=window.open('','','width=200,height=100');
		// myWindow.document.write(printCnt);    
		// myWindow.document.close();
		// myWindow.focus();
		// myWindow.print();
		// myWindow.close();  
  	}
</script>