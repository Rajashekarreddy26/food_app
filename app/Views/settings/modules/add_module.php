<?php
/**
 * Add Module
 */ 
$parent_id_val = isset($parent_id) ? $parent_id : 0;
?>
<div class="modal-dialog">
	<div class="modal-content">
		<form method="post" name="add_module" id="add_module" onsubmit="return false">
            <input type="hidden" name="parent_id" id="parent_id" value="<?= $parent_id_val ?>">
			<?= csrf_field(); ?>
			<div class="modal-header">
				<h5 class="modal-title fs-5">Add Module</h5>
            	<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div class="row">
                    <label for="name" class="col-sm-3 col-form-label text-end">Name&nbsp;<span class="text-danger">*</span>&nbsp;:</label>
                    <div class="col-sm-7">
                        <input type="text" class="form-control form-control-sm" name="name" id="name" value="<? print set_value('name'); ?>">
                        <span class="text-danger"><small><?= validation_show_error('name') ?></small></span>
                    </div>
                </div>
                <div class="row">
                    <label for="url" class="col-sm-3 col-form-label text-end">URL&nbsp;<span class="text-danger">*</span>&nbsp;:</label>
                    <div class="col-sm-7">
                        <input type="text" class="form-control form-control-sm" name="url" id="url" value="<? print set_value('url'); ?>">
                        <span class="text-danger"><small><?= validation_show_error('url') ?></small></span>
                    </div>
                </div>
                <div class="row">
                    <label for="url2" class="col-sm-3 col-form-label text-end">URL 2&nbsp;<span class="text-danger"></span>&nbsp;:</label>
                    <div class="col-sm-7">
                        <input type="text" class="form-control form-control-sm" name="url2" id="url2" value="<? print set_value('url2'); ?>">
                        <span class="text-danger"><small><?= validation_show_error('url2') ?></small></span>
                    </div>
                </div>
			</div>
			<div class="modal-footer">
                <button type="submit" onclick="insertModule()" class="btn btn-success btn-sm"><i class="bi bi-plus-square"></i>&nbsp;Add</button>
                <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal"><i class="bi bi-x-square"></i>&nbsp;Close</button>
            </div>
		</form>
	</div>
</div>