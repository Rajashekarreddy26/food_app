<?
$sort_order = ($params['sort_order'] == "desc") ? 'desc' : 'asc';
$sort_order_alt = ($params['sort_order'] == 'desc') ? 'asc' : 'desc';
$sortby = ($params['sortby']);
$rows = $params['rows'];
$pageno = $params['pageno'];
$tRecords = (isset($clients) && !empty($clients)) ? sizeof($clients) : 0;
$total_pages = ceil($tRecords/$rows);
$i = (($rows * ($pageno-1))+1);
$keywords = (isset($params['keywords'])) ? $params['keywords'] : "";
?>
<div class="clearfix">
	<div class="float-start d-flex align-items-center">
		<div class="me-1">
			<label>Search&nbsp;:&nbsp;</label>
			<input type="text" class="form-control form-control-sm" name="keywords" id="keywords" value="<? print $keywords; ?>">
		</div>
		<div class="me-1">
			<label>&nbsp;</label>
			<div>
				<button type="button" class="btn btn-sm btn-success" name="search" id="search" onclick="clientBody('<? print $rows; ?>', '<? print $pageno; ?>', '<? print $sortby ?>', '<? print $sort_order; ?>')"><i class="bi bi-search"></i></button>
			</div>
		</div>
		<div class="me-1">
			<label>&nbsp;</label>
			<div>
				<button type="button" class="btn btn-sm btn-warning" name="search" id="search" onclick="resetClientBody()"><i class="bi bi-arrow-clockwise"></i></button>
			</div>
		</div>
		<div class="me-1">
			<label>&nbsp;</label>
			<div>
				<strong>(&nbsp;<? print $tRecords; ?> Records&nbsp;)</strong>
			</div>
		</div>
	</div>
	<div class="float-end d-flex align-items-center">	
		<div class="me-0">
			<label>&nbsp;</label>
			<div>
				<a href="javascript:void(0)" class="btn btn-success btn-sm" onclick="addClient()"><i class="bi bi-plus-square"></i>&nbsp;Add Client</a>
			</div>
		</div>
	</div>			
</div>
<div class="table table-responsive mt-2">
	<table class="table table-bordered table-hover table-striped table-condensed">
		<thead>
			<tr>
				<th width="1%" class="text-center">S.No.</th>
				<th><a href="javascript:void(0)" onclick="clientBody('<? print $rows; ?>', '<? print $pageno; ?>', 'name', '<? print $sort_order_alt; ?>')">Name</a></th>
				<th><a href="javascript:void(0)" onclick="clientBody('<? print $rows; ?>', '<? print $pageno; ?>', 'created_at', '<? print $sort_order_alt; ?>')">Added Date</a></th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
			<?php
			// $i = 1;
			if (isset($clients) && !empty($clients)) {
				foreach ($clients as $key => $client) { ?>
					<tr>
						<td class="text-center"><?= $i++; ?> </td>
						<td><?= $client['name']; ?></td>
						<td><?= date('d-m-Y',strtotime($client['created_at'])); ?></td>
						<td>
							<a class="btn btn-sm btn-primary" href="javascript:void(0)" onclick="editClient(<?= $client['id']; ?>)"><i class="bi bi-pencil-square"></i></a>
					  	  	<a class="btn btn-sm btn-danger" href="javascript:void(0)" onclick="deleteClient(<?= $client['id']; ?>)"><i class="bi bi-trash"></i></a>
					  	  	<a class="btn btn-sm btn-info" href="<? print WEBROOT; ?>client/viewDetails/<? print $client['id']; ?>"><i class="bi bi-archive"></i></a>
							<?/*<div class="dropdown">
							  	<button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="actionMenu" data-bs-toggle="dropdown" aria-expanded="false">
							    Actions
							  	</button>
							  	<ul class="dropdown-menu" aria-labelledby="actionMenu" style="position: absolute; inset: 0px 0px auto auto; margin: 0px; transform: translate(0px, 40px);" data-popper-placement="bottom-end">
							  	  	<li><a class="dropdown-item" href="javascript:void(0)" onclick="editClient(<?= $client['id']; ?>)">Edit</a></li>
							  	  	<li><a class="dropdown-item" href="javascript:void(0)" onclick="deleteClient(<?= $client['id']; ?>)">Delete</a></li>
							  	  	<li><a class="dropdown-item" href="<? print WEBROOT; ?>client/viewDetails/<? print $client['id']; ?>" target="_blank">View</a></li>
							  	</ul>
							</div>
							<div>
								<a class="btn btn-info btn-sm" href="<? print WEBROOT; ?>client/viewDetails/<? print $client['id']; ?>" target="_blank">More Details</a>
							</div>*/?>
						</td>
					</tr>
				<?php
				}
			}
			?>
		</tbody>
	</table>
</div>