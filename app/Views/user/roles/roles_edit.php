<?php
/**
 * Manage Rights
 */ 
$name_val = isset($roles_details['name']) ? $roles_details['name'] : set_value('name');
$id_val = isset($roles_details['id']) ? $roles_details['id'] : (isset($_POST['id']) ? $_POST['id'] : '');
$rights_val = isset($roles_details['rights']) ? $roles_details['rights'] : (isset($_POST['rights']) ? implode(",",set_value('rights')) : array());
?>
<div class="modal-dialog modal-lg">
	<div class="modal-content">
		<form method="post" name="edit_role" id="edit_role" onsubmit="return false">
			<?= csrf_field(); ?>
			<input type="hidden" name="id" id="id" value="<?= $id_val ?>">
			<div class="modal-header">
				<h5 class="modal-title fs-5">Edit Role</h5>
            	<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
                <div class="row mb-2">
                    <label class="col-form-label col-sm-4 text-end" for="id">Role&nbsp;<span class="text-danger">*</span>&nbsp;:</label>
                    <div class="col-sm-6">
                        <input type="text" id="name" name="name" class="form-control form-control-sm" placeholder="Role" value="<?php print $name_val; ?>"/>
                        <span class="text-danger"><?= validation_show_error('name') ?></span>
                    </div>
                </div>
                <div class="hr1"></div>
				<div class="sub-title mb-2">Module List</div>
                <div class="row">  
                    <?
                    $rights = '';
                    if(isset($modules) && !empty($modules)){
                        foreach ($modules as $mid => $modul) { 
                            $check_class = "";
                            if(!empty($rights_val)){
                                $rights = explode(",", $rights_val);
                                if(in_array($modul['id'],$rights)) {
                                    $check_class = "checked";
                                }
                            }?>
                            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="rights[]" id="<?php print $modul['id'];?>" value="<?php print $modul['id'];?>" <?php print $check_class; ?>>
                                    <label class="form-check-label" for="<?php print $modul['id'];?>">
                                        <?php print $modul['name'];?>
                                    </label>
                                </div>
                            </div>
                        <?}
                    }
                    ?>
                </div>
			</div>
			<div class="modal-footer">
                <button type="submit" onclick="updateRoleRights()" class="btn btn-success btn-sm"><i class="bi bi-plus-square"></i>&nbsp;Update</button>
                <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal"><i class="bi bi-x-square"></i>&nbsp;Close</button>
            </div>
		</form>
	</div>
</div>