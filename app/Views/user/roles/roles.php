<?php
/**
 * Roles Page
 */ 
?>
<?= $this->extend('template/template_admin') ?>
<?= $this->section('content') ?>
<div class="clearfix">
	<div class="float-start d-flex align-items-center">
		<div class="me-1">
			<strong>(&nbsp;<? print $tRecords; ?> Records&nbsp;)</strong>
		</div>
	</div>
	<div class="float-end d-flex align-items-center">	
		<div class="me-0">
			<a href="javascript:void(0)" class="btn btn-success btn-sm" onclick="addRole()"><i class="bi bi-plus-square"></i>&nbsp;Add Role</a>
		</div>
	</div>
</div>
<div class="table-responsive mt-2">
	<table class="table table-bordered table-hover table-striped table-condensed mb-0">
		<thead>
			<th width="1%">S.No</th>
			<th>Name</th>
			<th>Actions</th>
		</thead>
		<tbody>
			<?
			if($roles){
				$i=1;
				foreach ($roles as $key => $role) { ?>
				<tr>
					<td class="text-center"><?= $i++; ?></td>
					<td><?= $role['name']; ?></td>
					<td>
						<? if($role['id'] > 2) { ?>
							<button class="btn btn-success btn-sm" type="button" onclick="editRoleRights(<?= $role['id'] ?>)"><i class="bi bi-gear"></i>&nbsp;Manage Rights</button>
							<button class="btn btn-danger btn-sm" type="button" onclick="deleteRole(<?= $role['id'] ?>)"><i class="bi bi-trash"></i></button>
						<? }else { ?>
							<button class="btn btn-secondary btn-sm"><i class="bi bi-person-check"></i>&nbsp;All Rights</button>
						<? } ?>
					</td>
				</tr>
			<? }
			}
			else { ?>
				<tr>
					<td colspan="3" class="bg bg-warning">No Records Found</td>
				</tr>

			<? } ?>
		</tbody>
	</table>
</div>
<?= $this->endSection() ?>