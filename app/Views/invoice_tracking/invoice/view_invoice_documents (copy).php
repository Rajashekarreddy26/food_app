<?
$file_type_val = (isset($params['file_type']) and !empty($params['file_type'])) ? $params['file_type'] : "";
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
                                  <option value="<?= $type['id']; ?>" <? if($type['id'] == $file_type_val) { print 'selected="selected"';} ?> ><?= $type['name']; ?></option>  
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
<?php
if (isset($response) and !empty($response)) { ?>
    <div class="hr1"></div>
    <div class="alert alert-<?= (isset($response['color'])) ? $response['color'] : "info"; ?> alert-dismissible fade show" role="alert">
        <?= (isset($response['msg'])) ? $response['msg'] : ""; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div> 
    <script type="text/javascript">
        setTimeout(function() {
            $(".alert").alert('close');
        }, 3000);
    </script>
<?
}
/**
 * Invoice tracking
 * View invoice deductions
 */

if(isset($invoice_documents) and !empty($invoice_documents)) {
    ?>
    <div class="hr1"></div>
    <div class="mb-1">
        <strong>(<?= sizeof($invoice_documents) ?>)&nbsp;Records found</strong>        
    </div>
    <table class="table table-bordered table-hover table-striped table-condensed">
        <thead>
            <tr>
                <th class="text-center" width="1%">S.No</th>
                <th>File Type</th>
                <th>Document</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?
            $sno = 1;
            foreach($invoice_documents as $document) {
                ?>
                <tr>
                    <td class="text-center"><?= $sno++ ?></td>
                    <td><?= $document['file_name']; ?></td>
                    <td width="180">
                        <a href="<?= WEBROOT ?>files/invoice/<?= $document['file'] ?>" class="btn btn-sm btn-primary" target="_blank"><i class="bi bi-file-earmark-arrow-down"></i></a>
                    </td>
                    <td>
                        <button class="btn btn-sm btn-danger" onclick="deleteInvFile(<?= $document['id'] ?>, <?= $document['invoice_id'] ?>)"><i class="bi bi-trash"></i></button>
                    </td>
                </tr>
                <?
            }
            ?>
        </tbody>
    </table>
    <?
}
else {
    ?>
    <div class="alert alert-info mt-3">
        No document records found!
    </div>
    <?
}
?>