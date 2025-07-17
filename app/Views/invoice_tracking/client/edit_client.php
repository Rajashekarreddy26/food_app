<?
$name_val = (isset($client['name']) && !empty($client['name'])) ? $client['name'] : "";
$client_id_val = (isset($client['id']) && !empty($client['id'])) ? $client['id'] : $_POST['client_id'];
?>
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Client</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form name="client_edit_form" id="client_edit_form" method="post" onsubmit="clientUpdate(event)">
            <input type="hidden" name="client_id" id="client_id" value="<? print $client_id_val; ?>">
            <div class="modal-body">
                <div class="row">
                    <label for="name" class="col-sm-3 col-form-label text-end">Name<span class="text-danger">*</span>&nbsp;:</label>
                    <div class="col-sm-7">
                        <input type="text" class="form-control form-control-sm" name="name" id="name" value="<? print $name_val; ?>">
                        <span class="text-danger"><small><?= validation_show_error('name') ?></small></span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success btn-sm"><i class="bi bi-check-square"></i>&nbsp;Update</button>
                <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal"><i class="bi bi-x-square"></i>&nbsp;Close</button>
            </div>
        </form>
    </div>
</div>
