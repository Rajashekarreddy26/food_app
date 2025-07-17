<?
$id = (isset($id) and !empty($id)) ? $id : ((isset($invoice_id) and !empty($invoice_id)) ? $invoice_id : "");
?>
<form name="add_file" id="add_file" method="post">
    <div class="card">
        <div class="card-header"><h5 class="mb-0">Upload File</h5></div>
        <div class="card-body">
            <input type="hidden" name="invoice_id" value="<?= $id ?>">
            <div class="row">
                 <div class="col-md-3 col-sm-6">
                    <div class="mb-3">
                        <label class="form-label mb-0">File Type&nbsp;<span class="text-danger">*</span>&nbsp;:</label>
                        <select class="form-select form-select-sm" name="file_type" id="file_type">
                            <option value="">Select</option>
                            <?
                            if (isset($file_types) and !empty($file_types)) {
                                foreach ($file_types as $key => $type) { ?>
                                  <option value="<?= $type['id']; ?>" ><?= $type['name']; ?></option>  
                                <?
                                }
                            }
                            ?>
                        </select>
                        <span class="text-danger"><?= validation_show_error('file_type') ?></span>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="mb-3">
                        <label class="form-label mb-0">File Upload</label>
                        <input class="form-control form-control-sm" type="file" id="invoice_file" name="invoice_file">
                        <span class="text-danger"><?= validation_show_error('invoice_file') ?></span>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="mb-3">
                        <label class="form-label mb-0">&nbsp;</label>
                        <button type="button" onclick="uploadInvoiceFile(<?= $id ?>)" class="btn btn-sm btn-success"><i class="bi bi-plus"></i>&nbsp;Upload File</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>