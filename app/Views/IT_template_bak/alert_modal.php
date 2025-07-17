<?php
/**
 * Alert modal
 */
?>
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Response / Result</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <?= ($msg) ? $msg : '<div class="alert alert-warning mb-0" role="alert">Response / Result message not found!</div>'; ?>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal"><i class="bi bi-x-lg"></i>&nbsp;Close</button>
        </div>
    </div>
</div>
