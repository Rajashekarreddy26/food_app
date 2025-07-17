<?php
/**
 * Invoice tracking
 * Add invoice module file
 */
?>
<form id="add-inv-mod-file" name="add_inv_file" method="POST" onsubmit="return false" enctype="multipart/form-data">
    <input type="file" name="inv_file" id="inv-file" class="form-control form-control-sm d-none">
    <input type="hidden" name="inv_mod" value="<?= $inv_mod ?>">
    <input type="hidden" name="id" value="<?= $id ?>">
    <button type="button" class="btn btn-sm btn-info" onclick="$('#inv-file').click()"><i class="bi bi-folder2-open"></i></button>
    <button type="button" class="btn btn-sm btn-success" onclick="invModSaveFile(this)"><i class="bi bi-file-earmark-arrow-up"></i>&nbsp;Upload</button>
</form>