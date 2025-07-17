<?php
/**
 * Add Module
 */ 
$trecords = isset($tRecords) ? $tRecords+1 : 1;
$parent_id_val = isset($parent_id) ? $parent_id : 0;
$id_val = isset($module_details['id']) ? $module_details['id'] : (isset($_POST['id']) ? $_POST['id'] : '');
$name_val = isset($module_details['name']) ? $module_details['name'] : set_value('name');
$url_val = isset($module_details['url']) ? $module_details['url'] : set_value('url');
$url2_val = isset($module_details['url2']) ? $module_details['url2'] : set_value('url2');
?>
<div class="modal-dialog">
	<div class="modal-content">
		<form method="post" name="edit_module" id="edit_module" onsubmit="return false">
            <input type="hidden" name="id" id="id" value="<?= $id_val ?>">
			<?= csrf_field(); ?>
			<div class="modal-header">
				<h5 class="modal-title fs-5">Edit Module</h5>
            	<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div class="row">
                    <label for="name" class="col-sm-3 col-form-label text-end">Name&nbsp;<span class="text-danger">*</span>&nbsp;:</label>
                    <div class="col-sm-7">
                        <input type="text" class="form-control form-control-sm" name="name" id="name" value="<?= $name_val ?>">
                        <span class="text-danger"><small><?= validation_show_error('name') ?></small></span>
                    </div>
                </div>
                <div class="row">
                    <label for="url" class="col-sm-3 col-form-label text-end">URL&nbsp;<span class="text-danger">*</span>&nbsp;:</label>
                    <div class="col-sm-7">
                        <input type="text" class="form-control form-control-sm" name="url" id="url" value="<?= $url_val ?>">
                        <span class="text-danger"><small><?= validation_show_error('url') ?></small></span>
                    </div>
                </div>
                <div class="row">
                    <label for="url2" class="col-sm-3 col-form-label text-end">URL 2&nbsp;<span class="text-danger">*</span>&nbsp;:</label>
                    <div class="col-sm-7">
                        <input type="text" class="form-control form-control-sm" name="url2" id="url2" value="<?= $url2_val ?>">
                    </div>
                </div>
			</div>
			<div class="modal-footer">
                <button type="submit" onclick="updateModule()" class="btn btn-success btn-sm"><i class="bi bi-plus-square"></i>&nbsp;Update</button>
                <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal"><i class="bi bi-x-square"></i>&nbsp;Close</button>
            </div>
		</form>
	</div>
</div>