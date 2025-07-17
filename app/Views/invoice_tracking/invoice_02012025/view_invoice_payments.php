<?php
/**
 * Invoice tracking
 * View invoice payments
 */

if($invoice_payments) {
    ?>
    <div class="hr1"></div>
    <div class="mb-1">        
        <strong>(<?= sizeof($invoice_payments) ?>)&nbsp;Records found</strong>
    </div>
    <table class="table table-bordered table-hover table-striped table-sm">
        <thead>
            <tr>
                <th>S.No</th>
                <th>Payment Date</th>
                <th>Amount</th>
                <th>Payment Type</th>
                <th>Reference No.</th>
                <th>Added Date</th>
                <th>Note</th>
                <th>File</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?
            $sno = 1;
            $total_p = 0;
            foreach($invoice_payments as $payment) {
                $total_p += $payment['amount'];
                ?>
                <tr>
                    <td width="1%"><?= $sno++ ?></td>
                    <td><?= displayDate($payment['payment_date']) ?></td>
                    <td class="text-end"><?= displayNumber($payment['amount'], 2) ?></td>
                    <td><?= $payment['payment_name'] ?></td>
                    <td><?= $payment['ref_number'] ?></td>
                    <td><?= displayDate($payment['created_at'], 1) ?></td>
                    <td><?= $payment['note'] ?></td>
                    <td width="180">
                        <?
                        if($payment['payment_file']) {
                            ?>
                            <a href="<?= WEBROOT ?>files/payment/<?= $payment['payment_file'] ?>" class="btn btn-sm btn-primary" target="_blank"><i class="bi bi-file-earmark-arrow-down"></i></a>
                            <button class="btn btn-sm btn-danger" onclick="invModDeleteFile(this, <?= $payment['id'] ?>, 'pay')"><i class="bi bi-trash"></i></button>
                            <?
                        }
                        else {
                            ?><button class="btn btn-sm btn-secondary" onclick="invModAddFile(this, <?= $payment['id'] ?>, 'pay')"><i class="bi bi-file-earmark-plus"></i>&nbsp;Add file</button><?
                        }
                        ?>
                    </td>
                    <td>
                        <button type="button" class="btn btn-sm btn-primary" onclick="editInvoicePayment(<?= $payment['id'] ?>)"><i class="bi bi-pencil-square"></i></button>
                        <button type="button" class="btn btn-sm btn-danger" onclick="deleteInvoicePayment(<?= $payment['id'] ?>, <?= $payment['inv_id'] ?>)"><i class="bi bi-trash"></i></button>
                    </td>
                </tr>
                <?
            }
            ?>
            <tr>
                <td></td>
                <th class="text-end"><?= displayNumber($total_p, 2) ?></th>
                <th colspan="7">Total Payments</th>
            </tr>
        </tbody>
    </table>
    <?
}
else {
    ?>
    <div class="alert alert-info mt-3">
        No payment records found!
    </div>
    <?
}
?>