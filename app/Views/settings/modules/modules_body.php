<?php
/**
 * Modules Body Page
 */ 
$module_data = array();
foreach($modules as $mid => $module_s) {
	$module_data[$module_s['parent_id']][$module_s['id']] = $module_s;
}
?>
<div class="clearfix">
	<div class="float-start d-flex align-items-center">	
		<div class="me-0">
			<strong>(<?= sizeof($module_data) ?>) Records found</strong>
		</div>
	</div>
	<div class="float-end d-flex align-items-center">	
		<div class="me-0">
			<a href="javascript:void(0)" class="btn btn-success btn-sm" onclick="addModule(0)"><i class="bi bi-plus-square"></i>&nbsp;Add Module</a>
		</div>
	</div>
</div>
<div class="table table-responsive mt-2">
	<table class="table table-bordered table-hover table-striped table-condensed">
		<thead>
			<th width="1%">S.No</th>
			<th>Name</th>
			<th>URL</th>
			<th>URL2</th>
			<th>Status</th>
			<th>Actions</th>
		</thead>
		<tbody>
			<? displayModules($module_data, 0); ?>
		</tbody>
	</table>
</div>
<?
// Module display recurssive function
function displayModules($module_data, $parentId, $sr = 0)
{
	$sno = 1;
	foreach($module_data[$parentId] as $module_id => $module) {
		?>
		<tr>
			<td><?= ($sr > 0) ? $sr . '.' : ''; ?><?= $sno++ ?></td>
			<td><?= $module['name']?></td>
			<td><?= $module['url']?></td>
			<td><?= $module['url2']?></td>
			<td><? if($module['status'] == 1) { echo "<span class='badge rounded-pill text-bg-success p-2'><i class='bi bi-check-lg'></i>&nbsp;Active</span>"; }else { echo "<span class='badge rounded-pill text-bg-warning p-2'><i class='bi bi-x-lg'></i>&nbsp;Inactive</span"; }?></td>
			<td>
				<? if($module['status'] == 1) { ?>
					<a href="javascript:void(0)" class="btn btn-warning btn-sm" onclick="changeModuleStatus(<?= $module['id'] ?>,0)"><i class="bi bi-x"></i>&nbsp;In Active</a>
				<? }else { ?>
					<a href="javascript:void(0)" class="btn btn-success btn-sm" onclick="changeModuleStatus(<?= $module['id'] ?>,1)"><i class="bi bi-check2"></i>&nbsp;Active</a>
				<? } ?>
				<a href="javascript:void(0)" class="btn btn-sm btn-primary" onclick="editModule(<?= $module['id'] ?>)"><i class="bi bi-pencil-square"></i></a>
				<a href="javascript:void(0)" class="btn btn-danger btn-sm" onclick="deleteModule(<?= $module['id'] ?>)" title="Delete"><i class="bi bi-trash"></i></a>
				<a href="javascript:void(0)" class="btn btn-info btn-sm" onclick="changeModulePosition(<?= $module['id'] ?>, <?= $module['parent_id'] ?>, <?= $module['position'] ?>)"><i class="bi bi-arrow-up"></i></a>
				<a href="javascript:void(0)" class="btn btn-info btn-sm" onclick="changeModulePosition(<?= $module['id'] ?>, <?= $module['id']+1 ?>)"><i class="bi bi-arrow-down"></i></a>
				<? if($module['parent_id'] == 0):?>
					<a href="javascript:void(0)" class="btn btn-success btn-sm" onclick="addModule(<?= $module['id'] ?>)"><i class="bi bi-plus-square"></i>&nbsp;Add Sub Module</a>
				<? endif; ?>
			</td>
		</tr>
		<?
		// Termination condition
		if(isset($module_data[$module_id])) {
			displayModules($module_data, $module_id, $sno - 1);
		}
	}
}
?>