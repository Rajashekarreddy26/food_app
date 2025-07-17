<?php
/**
 * Invoice tracking
 * View invoice credits
 */

// Credit types
$credit_type = array(
    1 => 'Credit Note',
    2 => 'Debit Note',
);

if($invoice_credits) {
    ?>
    <div class="hr1"></div>
    <div class="mb-1">
        <strong>(<?= sizeof($invoice_credits) ?>)&nbsp;Records found</strong>        
    </div>
    <table class="table table-bordered table-hover table-striped table-sm">
        <thead>
            <tr>
                <th class="text-center" width="1%">S.No</th>
                <th class="text-end">Amount</th>
                <th>Type</th>
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
            foreach($invoice_credits as $credit) {
                $credit['amount'] = ($credit['type'] == 1) ? -$credit['amount'] : $credit['amount'];
                $total_d += $credit['amount'];
                ?>
                <tr>
                    <td class="text-center"><?= $sno++ ?></td>
                    <td class="text-end"><?= displayNumber($credit['amount'], 2) ?></td>
                    <td><?= $credit_type[$credit['type']] ?></td>
                    <td><?= displayDate($credit['created_at'], 1) ?></td>
                    <td><?= $credit['note'] ?></td>
                    <td width="180">
                        <?
                        if($credit['credit_file']) {
                            ?>
                            <a href="<?= WEBROOT ?>files/credit/<?= $credit['credit_file'] ?>" class="btn btn-sm btn-primary" target="_blank"><i class="bi bi-file-earmark-arrow-down"></i></a>
                            <button class="btn btn-sm btn-danger" onclick="invModDeleteFile(this, <?= $credit['id'] ?>, 'cre')"><i class="bi bi-trash"></i></button>
                            <?
                        }
                        else {
                            ?>
                            <button class="btn btn-sm btn-secondary" onclick="invModAddFile(this, <?= $credit['id'] ?>, 'cre')"><i class="bi bi-file-earmark-plus"></i>&nbsp;Add file</button>
                            <?
                        }
                        ?>
                    </td>
                    <td>
                        <button type="button" class="btn btn-sm btn-primary" onclick="editInvoiceCredit(<?= $credit['id'] ?>)"><i class="bi bi-pencil-square"></i></button>
                        <button type="button" class="btn btn-sm btn-danger" onclick="deleteInvoiceCredit(<?= $credit['id'] ?>, <?= $credit['inv_id'] ?>)"><i class="bi bi-trash"></i></button>
                    </td>
                </tr>
                <?
            }
            ?>
            <tr>
                <td>&nbsp;</td>
                <th class="text-end"><?= displayNumber($total_d, 2) ?></th>
                <th colspan="5">Total Credit</th>
            </tr>
        </tbody>
    </table>
    <?
}
else {
    ?>
    <div class="alert alert-info mt-3">
        No credit / debit records found!
    </div>
    <?
}
?>