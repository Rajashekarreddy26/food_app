<?php
/**
 * Invoice tracking
 * View invoice deductions
 */

if($invoice_deductions) {
    ?>
    <div class="hr1"></div>
    <div class="mb-1">
        <strong>(<?= sizeof($invoice_deductions) ?>)&nbsp;Records found</strong>        
    </div>
    <table class="table table-bordered table-hover table-striped table-sm">
        <thead>
            <tr>
                <th class="text-center" width="1%">S.No</th>
                <th class="text-end">Amount</th>
                <th>Deduction Type</th>
                <th>Added Date</th>
                <th>Note</th>
                <th>File</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?
            $sno = 1;
            $total_d = 0;
            foreach($invoice_deductions as $deduction) {
                $total_d += $deduction['amount'];
                ?>
                <tr>
                    <td class="text-center"><?= $sno++ ?></td>
                    <td class="text-end"><?= displayNumber($deduction['amount'], 2) ?></td>
                    <td><?= $deduction['deduction_name'] ?></td>
                    <td><?= displayDate($deduction['created_at'], 1) ?></td>
                    <td><?= $deduction['note'] ?></td>
                    <td width="180">
                        <?
                        if($deduction['deduction_file']) {
                            ?>
                            <a href="<?= WEBROOT ?>files/deduction/<?= $deduction['deduction_file'] ?>" class="btn btn-sm btn-primary" target="_blank"><i class="bi bi-file-earmark-arrow-down"></i></a>
                            <button class="btn btn-sm btn-danger" onclick="invModDeleteFile(this, <?= $deduction['id'] ?>, 'ded')"><i class="bi bi-trash"></i></button>
                            <?
                        }
                        else {
                            ?>
                            <button class="btn btn-sm btn-secondary" onclick="invModAddFile(this, <?= $deduction['id'] ?>, 'ded')"><i class="bi bi-file-earmark-plus"></i>&nbsp;Add file</button>
                            <?
                        }
                        ?>
                    </td>
                    <td>
                        <button type="button" class="btn btn-sm btn-primary" onclick="editInvoiceDeduction(<?= $deduction['id'] ?>)"><i class="bi bi-pencil-square"></i></button>
                        <button type="button" class="btn btn-sm btn-danger" onclick="deleteInvoiceDeduction(<?= $deduction['id'] ?>, <?= $deduction['inv_id'] ?>)"><i class="bi bi-trash"></i></button>
                    </td>
                </tr>
                <?
            }
            ?>
            <tr>
                <td>&nbsp;</td>
                <th class="text-end"><?= displayNumber($total_d, 2) ?></th>
                <th colspan="5">Total Deductions</th>
            </tr>
        </tbody>
    </table>
    <?
}
else {
    ?>
    <div class="alert alert-info mt-3">
        No deduction records found!
    </div>
    <?
}
?>