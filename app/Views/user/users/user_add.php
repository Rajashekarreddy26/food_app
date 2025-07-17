<?php
/**
 * Add Location
 */ 
?>
<div class="modal-dialog modal-lg">
	<div class="modal-content">
		<form method="post" id="add_user" onsubmit="return false">
			<?= csrf_field(); ?>
			<div class="modal-header">
				<h5 class="modal-title fs-5">Add User</h5>
            	<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
                <div class="row mb-3">
                    <label for="name" class="col-sm-4 col-form-label text-end">Name&nbsp;<span class="text-danger">*</span>&nbsp;:</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control form-control-sm" name="name" id="name" value="<? print set_value('name'); ?>" placeholder="Please Enter Name">
                        <span class="text-danger"><small><?= validation_show_error('name') ?></small></span>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="email" class="col-sm-4 col-form-label text-end">Email&nbsp;<span class="text-danger">*</span>&nbsp;:</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control form-control-sm" name="email" id="email" value="<? print set_value('email'); ?>" placeholder="Please Enter Email">
                        <span class="text-danger"><small><?= validation_show_error('email') ?></small></span>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="phone" class="col-sm-4 col-form-label text-end">Phone&nbsp;<span class="text-danger">*</span>&nbsp;:</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control form-control-sm" name="phone" id="phone" maxlength="10" value="<? print set_value('phone'); ?>" placeholder="Please Enter Phone Number">
                        <span class="text-danger"><small><?= validation_show_error('phone') ?></small></span>
                    </div>
                </div>
				<div class="row mb-3">
                    <label for="username" class="col-sm-4 col-form-label text-end">Username&nbsp;<span class="text-danger">*</span>&nbsp;:</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control form-control-sm" name="username" id="username" value="<? print set_value('username'); ?>" placeholder="Please Enter Username">
                        <span class="text-danger"><small><?= validation_show_error('username') ?></small></span>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="password" class="col-sm-4 col-form-label text-end">Password&nbsp;<span class="text-danger">*</span>&nbsp;:</label>
                    <div class="col-sm-6">
                        <input type="password" class="form-control form-control-sm" name="password" id="password" value="<? print set_value('password'); ?>" placeholder="Please Enter Password">
                        <span class="text-danger"><small><?= validation_show_error('password') ?></small></span>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="password" class="col-sm-4 col-form-label text-end">Confirm Password&nbsp;<span class="text-danger">*</span>&nbsp;:</label>
                    <div class="col-sm-6">
                        <input type="password" class="form-control form-control-sm" name="c_password" id="c_password" value="<? print set_value('c_password'); ?>" placeholder="Please Enter Confirm Password">
                        <span class="text-danger"><small><?= validation_show_error('c_password') ?></small></span>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-4 col-form-label text-end">Role&nbsp;<span class="text-danger">*</span>&nbsp;:</label>
                    <div class="col-sm-6">
                        <select class="form-select form-select-sm" name="role" id="role">
                            <option value="">Select</option>
                            <? foreach ($roles as $key => $value) { ?>
                                <option value="<?= $value['id']; ?>"<? if($value['id'] == set_value('role')){ echo "selected";}?>><?= $value['name']; ?></option>
                            <? } ?>
                        </select>
                        <span class="text-danger"><small><?= validation_show_error('role'); ?></small></span>
                    </div>
                </div>
			</div>
			<div class="modal-footer">
                <button type="submit" onclick="insertUser()" class="btn btn-success btn-sm"><i class="bi bi-plus-square"></i>&nbsp;Add</button>
                <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal"><i class="bi bi-x-square"></i>&nbsp;Close</button>
            </div>
		</form>
	</div>
</div>