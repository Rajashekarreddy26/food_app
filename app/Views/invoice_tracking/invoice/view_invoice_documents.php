<?php
/**
 * Invoice documents
 */
$file_type_val = (isset($params['file_type']) and !empty($params['file_type'])) ? $params['file_type'] : "";
?>
<div class="row">
    <div class="col-md-6 col-sm-12 col-xs-12">
        <div class="mb-2" style="background-color: #f8f9fa;border: 1px dashed #dee2e6;padding: 1rem;">
            <form class="row gy-2 gx-3 align-items-top" name="add_file" id="add_file" method="post">
                <input type="hidden" name="invoice_id" value="<?= $id ?>">
                <div class="col-auto">
                    <select class="form-select form-select-sm" name="file_type" id="file_type">
                        <option value="">Select File Type</option>
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
                <div class="col-auto">
                    <input class="form-control form-control-sm" type="file" id="invoice_file" name="invoice_file">
                    <span class="text-danger"><?= validation_show_error('invoice_file') ?></span>
                </div>
                <div class="col-auto">
                    <button type="button" onclick="uploadInvoiceFile(<?= $id ?>)" class="btn btn-sm btn-success"><i class="bi bi-plus"></i>&nbsp;Upload File</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php
if (isset($response) and !empty($response)) {
    ?>
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
    <div class="mb-1">
        <strong>(<?= sizeof($invoice_documents) ?>)&nbsp;Records found</strong>        
    </div>
    <table class="table table-bordered table-hover table-striped table-condensed">
        <thead>
            <tr>
                <th class="text-center" width="1%">S.No</th>
                <th>File Type</th>
                <th>Added Date</th>
                <th>Added By</th>
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
                    <td><?= (isset($document['created_at']) and !empty($document['created_at'])) ? displayDate($document['created_at']) : "--"; ?></td>
                    <td><?= $document['user_name']; ?></td>
                    <td>
                        <a href="<?= WEBROOT ?>files/invoice/<?= $document['file'] ?>" class="btn btn-sm btn-primary" target="_blank"><i class="bi bi-file-earmark-arrow-down"></i></a>
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