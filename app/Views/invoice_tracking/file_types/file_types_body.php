<?php
/**
 * File Types Body Page
 */ 
$keywords = isset($params['keywords']) ? $params['keywords'] : '';
$pageno = isset($params['pageno']) ? $params['pageno'] : '';
$sortby = isset($params['sort_by']) ? $params['sort_by'] : '';
$sort_order = isset($params['sort_order']) ? $params['sort_order'] : '';
$rows = isset($params['rows']) ? $params['rows'] : '';
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
				<button type="button" class="btn btn-sm btn-success" name="search" id="search" onclick="fileTypeBody('<? print $rows; ?>', '<? print $pageno; ?>', '<? print $sortby ?>', '<? print $sort_order; ?>')"><i class="bi bi-search"></i></button>
			</div>
		</div>
		<div class="me-1">
			<label>&nbsp;</label>
			<div>
				<button type="button" class="btn btn-sm btn-warning" name="search" id="search" onclick="resetFileTypeBody()"><i class="bi bi-arrow-clockwise"></i></button>
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
				<a href="javascript:void(0)" class="btn btn-success btn-sm" onclick="addFileType()"><i class="bi bi-plus-square"></i>&nbsp;Add File Type</a>
			</div>
		</div>
	</div>
</div>

<div class="table table-responsive mt-2">
	<table class="table table-bordered table-hover table-striped table-condensed">
		<thead>
			<tr>
				<th width="1%" class="text-center">S.No.</th>
				<th nowrap>Name</th>
				<th nowrap>Actions</th>
			</tr>
		</thead>
		<tbody>
			<?php 	
			if($file_types){
				$i=1;
				foreach ($file_types as $ft_key => $f_type) {
				 ?>
				<tr>
					<td class="text-center"><?= $i++; ?></td>
					<td><?= $f_type['name']; ?></td>
					<td>
				  	  	<a class="btn btn-sm btn-primary" href="javascript:void(0)" onclick="editFileType(<?= $f_type['id']; ?>)"><i class="bi bi-pencil-square"></i></a>
				  	  	<a class="btn btn-sm btn-danger" href="javascript:void(0)" onclick="deleteFileType(<?= $f_type['id']; ?>)"><i class="bi bi-trash"></i></a>
					</td>
				</tr>
			<?  }
		}
		else { ?>
			<tr>
				<td colspan="3" class="bg bg-warning">No Records Found</td>
			</tr>
		<? } ?>
		</tbody>
	</table>
</div>