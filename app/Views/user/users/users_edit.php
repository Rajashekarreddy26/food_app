<?php
/**
 * Edit Location
 */ 
$id_val = isset($user_details['id']) ? $user_details['id'] : (isset($_POST['id']) ? $_POST['id'] : '');
$name_val = isset($user_details['name']) ? $user_details['name'] : set_value('name');
$email_val = isset($user_details['email']) ? $user_details['email'] : set_value('email');
$phone_val = isset($user_details['phone']) ? $user_details['phone'] : set_value('phone');
$role_val = isset($user_details['role']) ? $user_details['role'] : set_value('role');
?>
<div class="modal-dialog modal-lg">
	<div class="modal-content">
		<form method="post" id="edit_user" onsubmit="return false">
			<?= csrf_field(); ?>
			<input type="hidden" name="id" value="<?= $id_val; ?>">
			<div class="modal-header">
				<h5 class="modal-title fs-5">Edit User</h5>
            	<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
                <div class="row mb-3">
                    <label for="name" class="col-sm-4 col-form-label text-end">Name&nbsp;<span class="text-danger">*</span>&nbsp;:</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control form-control-sm" name="name" id="name" value="<?= $name_val; ?>">
                        <span class="text-danger"><small><?= validation_show_error('name') ?></small></span>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="email" class="col-sm-4 col-form-label text-end">Email&nbsp;<span class="text-danger">*</span>&nbsp;:</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control form-control-sm" name="email" id="email" value="<?= $email_val; ?>">
                        <span class="text-danger"><small><?= validation_show_error('email') ?></small></span>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="phone" class="col-sm-4 col-form-label text-end">Phone&nbsp;<span class="text-danger">*</span>&nbsp;:</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control form-control-sm" name="phone" id="phone" value="<?= $phone_val; ?>">
                        <span class="text-danger"><small><?= validation_show_error('phone') ?></small></span>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-4 col-form-label text-end">Role&nbsp;<span class="text-danger">*</span>&nbsp;:</label>
                    <div class="col-sm-6">
                        <select class="form-select form-select-sm" name="role" id="role">
                            <option value="">Select</option>
                            <? foreach ($roles as $key => $value) { ?>
                                <option value="<?= $value['id']; ?>"<? if($value['id'] == $role_val){ echo "selected";}?>><?= $value['name']; ?></option>
                            <? } ?>
                        </select>
                        <span class="text-danger"><small><?= validation_show_error('role'); ?></small></span>
                    </div>
                </div>
			</div>
			<div class="modal-footer">
                <button type="submit" onclick="updateUser()" class="btn btn-success btn-sm"><i class="bi bi-check-square"></i>&nbsp;Update</button>
                <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal"><i class="bi bi-x-square"></i>&nbsp;Close</button>
            </div>
		</form>
	</div>
</div>