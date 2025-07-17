<?php
/**
 * Invoices body view
 */

// Parameters
$total_pages = ceil($total_records / $params['rows']);
$page = isset($params['page']) ? $params['page'] : 1;
$sort_column = isset($params['sort_column']) ? $params['sort_column'] : '';
$sort_order = isset($params['sort_order']) ? $params['sort_order'] : 'desc';
$rows = isset($params['rows']) ? $params['rows'] : 20;
$sort_order_alt = ($params['sort_order'] == 'desc') ? 'asc' : 'desc';
$arrow = ($params['sort_order'] == 'desc') ? '<i class="bi bi-arrow-down"></i>' : '<i class="bi bi-arrow-up"></i>';
$payment_status_val = isset($params['payment_status']) ? $params['payment_status'] : 0;
?>
<div class="clearfix">
    <form id="inv-ser" onsubmit="invoiceBody(); return false">
        <div class="float-start d-flex align-items-center">
            <div class="me-1">
                <small><label class="form-label mb-0">Search&nbsp;:&nbsp;</label></small>
                <input class="form-control form-control-sm" type="text" name="key" id="key" placeholder="Search here..." value="<?= $params['key']; ?>">
            </div>
            <div class="me-1">
                <small><label class="form-label mb-0">Projects&nbsp;:&nbsp;</label></small>
                <select name="inv_proj" id="inv-proj" class="form-select form-select-sm">
                    <option value="">All</option>
                    <?
                    foreach($invoice_projects as $project) {
                        ?><option value="<?= $project['id'] ?>" <? if($params['inv_proj'] == $project['id']) echo 'selected'; ?>><?= $project['code'] ?></option><?
                    }
                    ?>
                </select>
            </div>
            <div class="me-1">
                <small><label class="form-label mb-0">Clients&nbsp;:&nbsp;</label></small>
                <select name="inv_client" id="inv-client" class="form-select form-select-sm">
                    <option value="">All</option>
                    <?
                    foreach($invoice_clients as $client) {
                        ?><option value="<?= $client['id'] ?>" <? if($params['inv_client'] == $client['id']) echo 'selected'; ?>><?= $client['name'] ?></option><?
                    }
                    ?>
                </select>
            </div>  
            <div class="me-1">
                <small><label class="form-label mb-0">Invoice Types&nbsp;:&nbsp;</label></small>
                <select name="inv_type" id="inv-type" class="form-select form-select-sm">
                    <option value="">All</option>
                    <?
                    foreach($invoice_categories as $id => $name) {
                        ?><option value="<?= $id ?>" <? if($params['inv_type'] == $id) echo 'selected'; ?>><?= $name ?></option><?
                    }
                    ?>
                </select>
            </div>
            <div class="me-1">
                <small><label class="form-label mb-0">Payment Status&nbsp;:&nbsp;</label></small>
                <select name="payment_status" id="payment_status" class="form-select form-select-sm">
                    <option value="0"<? if($payment_status_val == "0"){ echo "selected"; }?>>All</option>
                    <option value="1"<? if($payment_status_val == "1"){ echo "selected"; }?>>Paid</option>
                    <option value="2"<? if($payment_status_val == "2"){ echo "selected"; }?>>Partially Paid</option>
                    <option value="3"<? if($payment_status_val == "3"){ echo "selected"; }?>>No Payment</option>
                </select>
            </div>  
            <div class="me-1">
                <small><label class="form-label mb-0">&nbsp;</label></small>
                <div>
                    <button class="btn btn-sm btn-success" type="button" onclick="invoiceBody()"><i class="bi bi-search"></i></button>
                    <button class="btn btn-sm btn-warning" type="button" onclick="invoiceBodyReset()"><i class="bi bi-arrow-clockwise"></i></button>
                </div>
            </div>
            <div class="me-1">
                <small><label class="form-label mb-0">&nbsp;</label></small>
                <div>
                    <strong>Invoices&nbsp;(&nbsp;<?= esc($total_records) ?>&nbsp;)</strong>
                </div>
            </div>
        </div>
        <div class="float-end d-flex align-items-center">
            <div class="me-1">
                <small><label class="form-label mb-0">&nbsp;</label></small>
                <div><button type="button" class="btn btn-sm btn-success" onclick="addInvoice()"><i class="bi bi-plus-square"></i>&nbsp;Add Invoice</button></div>
            </div>
            <div class="me-0">
                <small><label class="form-label mb-0">&nbsp;</label></small>
                <div>
                    <ul class="pagination pagination-sm m-0">
                        <li class="page-item <? if($params['page'] <= 1) echo 'disabled'; ?>"><a class="page-link" href="javascript:invoiceBody(1)" aria-label="Previous"><i class="bi bi-chevron-double-left"></i></a></li>
                        <li class="page-item <? if($params['page'] <= 1) echo 'disabled'; ?>"><a class="page-link" href="javascript:invoiceBody(<?= ($params['page'] - 1) ?>)" aria-label="Previous"><i class="bi bi-chevron-left"></i></a></li>
                        <li class="page-item active"><a class="page-link" href="#"><?= $params['page'] ?> of <?= $total_pages ?></a></li>
                        <li class="page-item <? if($params['page'] >= $total_pages) echo 'disabled'; ?>"><a class="page-link" href="javascript:invoiceBody(<?= ($params['page'] + 1) ?>)" aria-label="Previous"><i class="bi bi-chevron-right"></i></a></li>
                        <li class="page-item <? if($params['page'] >= $total_pages) echo 'disabled'; ?>"><a class="page-link" href="javascript:invoiceBody(<?= $total_pages ?>)" aria-label="Previous"><i class="bi bi-chevron-double-right"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
        <input type="hidden" name="page" id="page" value="<?= $params['page'] ?>">
        <input type="hidden" name="rows" id="rows" value="<?= $params['rows'] ?>">
        <input type="hidden" name="sort_column" id="sort_column" value="<?= $params['sort_column'] ?>">
        <input type="hidden" name="sort_order" id="sort_order" value="<?= $params['sort_order'] ?>">
    </form>
</div>

<div class="table table-responsive mt-2 freeze-table" style="min-height: 400px; font-size: 12px;">
    <table class="table table-bordered table-hover table-striped table-sm mb-0">
        <thead>
            <tr class="align-middle">
                <th nowrap rowspan="2" width="1%" class="text-center">S.No.</th>
                <th nowrap rowspan="2"><? if($sort_column == 'invoice.inv_number') print $arrow; ?><a href="javascript:void(0)" onclick="invoiceSort('<? echo $rows; ?>','<? print $page; ?>','invoice.inv_number','<? echo $sort_order_alt; ?>')">Invoice No.</a></th>
                <th nowrap rowspan="2">Documents</th>
                <th nowrap rowspan="2"><? if($sort_column == 'invoice.inv_date') print $arrow; ?><a href="javascript:void(0)" onclick="invoiceSort('<? echo $rows; ?>','<? print $page; ?>','invoice.inv_date','<? echo $sort_order_alt; ?>')">Date</a></th>
                <th nowrap rowspan="2"><? if($sort_column == 'p.code') print $arrow; ?><a href="javascript:void(0)" onclick="invoiceSort('<? echo $rows; ?>','<? print $page; ?>','p.code','<? echo $sort_order_alt; ?>')">Project</a></th>
                <th nowrap rowspan="2"><? if($sort_column == 'c.name') print $arrow; ?><a href="javascript:void(0)" onclick="invoiceSort('<? echo $rows; ?>','<? print $page; ?>','c.name','<? echo $sort_order_alt; ?>')">Client</a></th>
                <th nowrap rowspan="2"><? if($sort_column == 'invoice.inv_category') print $arrow; ?><a href="javascript:void(0)" onclick="invoiceSort('<? echo $rows; ?>','<? print $page; ?>','invoice.inv_category','<? echo $sort_order_alt; ?>')">Type</a></th>
                <th nowrap colspan="4" class="text-center">Invoice Value</th>
                <th nowrap colspan="6" class="text-center">Deductions</th>
                <th nowrap rowspan="2" class="text-end">Total</th>
                <th nowrap rowspan="2" class="text-end">Received</th>
                <th nowrap rowspan="2" class="text-end">Balance</th>
                <th nowrap rowspan="2" class="text-end">Status</th>
                <th nowrap rowspan="2" class="text-center">Actions</th>
            </tr>
            <tr class="align-middle">
                <th nowrap class="text-end"><? if($sort_column == 'invoice.basic') print $arrow; ?><a href="javascript:void(0)" onclick="invoiceSort('<? echo $rows; ?>','<? print $page; ?>','invoice.basic','<? echo $sort_order_alt; ?>')">Basic</a></th>
                <th nowrap class="text-end"><? if($sort_column == 'invoice.sgst') print $arrow; ?><a href="javascript:void(0)" onclick="invoiceSort('<? echo $rows; ?>','<? print $page; ?>','invoice.sgst','<? echo $sort_order_alt; ?>')">SGST</a></th>
                <th nowrap class="text-end"><? if($sort_column == 'invoice.cgst') print $arrow; ?><a href="javascript:void(0)" onclick="invoiceSort('<? echo $rows; ?>','<? print $page; ?>','invoice.cgst','<? echo $sort_order_alt; ?>')">CGST</a></th>
                <th nowrap class="text-end"><? if($sort_column == 'invoice.total') print $arrow; ?><a href="javascript:void(0)" onclick="invoiceSort('<? echo $rows; ?>','<? print $page; ?>','invoice.total','<? echo $sort_order_alt; ?>')">Total</a></th>
                <th nowrap class="text-end"><? if($sort_column == 'invoice.tds') print $arrow; ?><a href="javascript:void(0)" onclick="invoiceSort('<? echo $rows; ?>','<? print $page; ?>','invoice.tds','<? echo $sort_order_alt; ?>')">TDS</a></th>
                <th nowrap class="text-end" nowrap><? if($sort_column == 'invoice.tds_sgst') print $arrow; ?><a href="javascript:void(0)" onclick="invoiceSort('<? echo $rows; ?>','<? print $page; ?>','invoice.tds_sgst','<? echo $sort_order_alt; ?>')">TDS-SGST</a></th>
                <th nowrap class="text-end" nowrap><? if($sort_column == 'invoice.tds_cgst') print $arrow; ?><a href="javascript:void(0)" onclick="invoiceSort('<? echo $rows; ?>','<? print $page; ?>','invoice.tds_cgst','<? echo $sort_order_alt; ?>')">TDS-CGST</a></th>
                <th nowrap class="text-end" nowrap><? if($sort_column == 'invoice.labour_cess') print $arrow; ?><a href="javascript:void(0)" onclick="invoiceSort('<? echo $rows; ?>','<? print $page; ?>','invoice.labour_cess','<? echo $sort_order_alt; ?>')">Labour Cess</a></th>
                <th nowrap class="text-end"><? if($sort_column == 'invoice.other_deductions') print $arrow; ?><a href="javascript:void(0)" onclick="invoiceSort('<? echo $rows; ?>','<? print $page; ?>','invoice.other_deductions','<? echo $sort_order_alt; ?>')">Others</a></th>
                <th nowrap class="text-end">Total D</th>
            </tr>
        </thead>
        <tbody>
            <?/*<tr>
                <td colspan="4"></td>
                <td>
                    <select name="inv_proj" id="inv-proj" class="form-select form-select-sm">
                        <option value="">All</option>
                        <?
                        foreach($invoice_projects as $project) {
                            ?><option value="<?= $project['id'] ?>" <? if($params['inv_proj'] == $project['id']) echo 'selected'; ?>><?= $project['code'] ?></option><?
                        }
                        ?>
                    </select>
                </td>
                <td>
                    <select name="inv_client" id="inv-client" class="form-select form-select-sm">
                        <option value="">All</option>
                        <?
                        foreach($invoice_clients as $client) {
                            ?><option value="<?= $client['id'] ?>" <? if($params['inv_client'] == $client['id']) echo 'selected'; ?>><?= $client['name'] ?></option><?
                        }
                        ?>
                    </select>
                </td>
                <td>
                    <select name="inv_type" id="inv-type" class="form-select form-select-sm">
                        <option value="">All</option>
                        <?
                        foreach($invoice_categories as $id => $name) {
                            ?><option value="<?= $id ?>" <? if($params['inv_type'] == $id) echo 'selected'; ?>><?= $name ?></option><?
                        }
                        ?>
                    </select>
                </td>
                <td colspan="15">
                    <button type="button" class="btn btn-sm btn-secondary" onclick="invoiceBody()"><i class="bi bi-funnel"></i></button>
                    <button class="btn btn-sm btn-warning" type="button" onclick="invoiceBodyReset()"><i class="bi bi-arrow-clockwise"></i></button>
                </td>
            </tr>*/
            if($invoices) {
                $sno = 1;
                foreach ($invoices as $invoice) {
                    $inv_credit = (isset($invoice['credit']) and !empty($invoice['credit'])) ? $invoice['credit'] : 0;
                    $total_d = $invoice['tds'] + $invoice['tds_sgst'] + $invoice['tds_cgst'] + $invoice['labour_cess'] + $invoice['other_deductions'];
                    $balance = $invoice['total'] - $total_d - $invoice['total_received'] + $inv_credit;
                    ?>
                    <tr>
                        <td class="text-center"><?= $sno++ ?></td>
                        <td nowrap><a href="javascript:viewInvoice(<?= $invoice['id'] ?>)"><?= $invoice['inv_number'] ?></a></td>
                        <td nowrap class="text-center">
                            <?
                            if(!empty($invoice['inv_file']) OR ($invoice['file_count'] > 0)) {
                                ?><i class="bi bi-circle-fill fs-600 text-success" title="Files uploaded"></i><?
                            }
                            else {
                                ?><i class="bi bi-circle-fill fs-600 text-danger" title="Files not uploaded"></i><?
                            }
                            ?>
                        </td>
                        <td nowrap><?= displayDate($invoice['inv_date']) ?></td>
                        <td nowrap><a href="javascript:viewProjectInvoices(<?= $invoice['project_id'] ?>)"><?= $invoice['project_name'] ?></a></td>
                        <td nowrap><?= $invoice['client_name'] ?></td>
                        <td nowrap><?= $invoice_categories[$invoice['inv_category']] ?></td>
                        <td nowrap class="text-end"><?= displayNumber($invoice['basic'], 0) ?></td>
                        <td nowrap class="text-end"><?= displayNumber($invoice['sgst'], 0) ?></td>
                        <td nowrap class="text-end"><?= displayNumber($invoice['cgst'], 0) ?></td>
                        <td nowrap class="text-end"><?= displayNumber($invoice['total'], 0) ?></td>
                        <td nowrap class="text-end"><?= displayNumber($invoice['tds'], 0) ?></td>
                        <td nowrap class="text-end"><?= displayNumber($invoice['tds_sgst'], 0) ?></td>
                        <td nowrap class="text-end"><?= displayNumber($invoice['tds_cgst'], 0) ?></td>
                        <td nowrap class="text-end"><?= displayNumber($invoice['labour_cess'], 0) ?></td>
                        <td nowrap class="text-end"><?= displayNumber($invoice['other_deductions'], 0) ?></td>
                        <td nowrap class="text-end"><?= displayNumber($total_d, 0) ?></td>
                        <td nowrap class="text-end"><?= displayNumber(($invoice['total'] - $total_d), 0) ?></td>
                        <td nowrap class="text-end"><?= ($invoice['total_received']) ? displayNumber($invoice['total_received'], 0) : 0 ?></td>
                        <td nowrap class="text-end"><?= ($balance > 0) ? displayNumber($balance, 0) : 0 ?></td>
                        <td nowrap class="text-center">
                            <?
                            if($invoice['total_received'] == 0) {
                                ?><span class="badge rounded-pill text-bg-danger">No Payment</span><?
                            }
                            else if(round($balance) <= MIN_INV_BALANCE) {
                                ?><span class="badge rounded-pill text-bg-success">Paid</span><?
                            }
                            else {
                                ?><span class="badge rounded-pill text-bg-warning">Partial</span><?
                            }
                            ?>
                        </td>
                        <td nowrap class="text-center">
                            <div class="dropdown">
                                <a class="btn btn-sm btn-primary dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="bi bi-list"></i></a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#" onclick="viewInvoice(<?= $invoice['id'] ?>)"><i class="bi bi-info-square"></i>&nbsp;View</a></li>
                                    <li><a class="dropdown-item" href="#" onclick="editInvoice(<?= $invoice['id'] ?>)"><i class="bi bi-pencil-square"></i>&nbsp;Edit</a></li>
                                    <li><a class="dropdown-item" href="#" onclick="viewInvoice(<?= $invoice['id'] ?>, 2)"><i class="bi bi-dash-square"></i>&nbsp;Add Deductions</a></li>
                                    <li><a class="dropdown-item" href="#" onclick="viewInvoice(<?= $invoice['id'] ?>, 4)"><i class="bi bi-slash-square"></i>&nbsp;Add Credit Notes</a></li>
                                    <li><a class="dropdown-item" href="#" onclick="viewInvoice(<?= $invoice['id'] ?>, 3)"><i class="bi bi-plus-square"></i>&nbsp;Add Payment</a></li>
                                    <li><a class="dropdown-item" href="#" onclick="deleteInvoice(<?= $invoice['id'] ?>)"><i class="bi bi-x-square"></i>&nbsp;Delete</a></li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                    <?
                }
            }
            else {
                ?><tr><td colspan="22"><div class="alert alert-danger mt-3">No records found!</div></td></tr><?
            }
            ?>
        </tbody>
    </table>
</div>
<!-- Totals -->
<?
$total_invoice_value = $totals['basic_sum'] + $totals['sgst_sum'] + $totals['cgst_sum'];
$total_deductions = $totals['tds_sum'] + $totals['tds_sgst_sum'] + $totals['tds_cgst_sum'] + $totals['labour_cess_sum'] + $totals['other_deductions_sum'];
$total_receivable = $total_invoice_value - $total_deductions;
?>
<div class="card-group">
    <div class="card text-bg-info">
        <div class="card-body">
            <h5 class="card-title text-end fs-5">Cr. <?= displayNumber(($totals['basic_sum'] / 10000000), 2) ?></h5>
            <p class="card-text">Basic</p>
        </div>
    </div>
    <div class="card text-bg-warning">
        <div class="card-body">
            <h5 class="card-title text-end fs-5">Cr. <?= displayNumber(($total_invoice_value / 10000000), 2) ?></h5>
            <p class="card-text">
                Basic + TAX&nbsp;
                <a class="text-black" data-bs-container="body" data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-placement="top" data-html="true" data-bs-content="SGST: <?= displayNumber(($totals['sgst_sum'] / 10000000), 2) ?>, CGST: <?= displayNumber(($totals['cgst_sum'] / 10000000), 2) ?>"><i class="bi bi-info-circle"></i></a>
            </p>
        </div>
    </div>
    <div class="card text-bg-secondary">
        <div class="card-body">
            <h5 class="card-title text-end fs-5">Cr. <?= displayNumber(($totals['other_deductions_sum'] / 10000000), 2) ?></h5>
            <p class="card-text">Other Deductions&nbsp;
                <a class="text-white" data-bs-container="body" data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-placement="top" data-html="true" data-bs-content="TDS: <?= displayNumber(($totals['tds_sum'] / 10000000), 2) ?>, SGST-TDS: <?= displayNumber(($totals['tds_sgst_sum'] / 10000000), 2) ?>, CGS-TDS: <?= displayNumber(($totals['tds_cgst_sum'] / 10000000), 2) ?>, Labour Cess: <?= displayNumber(($totals['labour_cess_sum'] / 10000000), 2) ?>, Other Deductions: <?= displayNumber(($totals['other_deductions_sum'] / 10000000), 2) ?>"><i class="bi bi-info-circle"></i></a>
            </p>
        </div>
    </div>
    <div class="card text-bg-primary">
        <div class="card-body">
            <h5 class="card-title text-end fs-5">Cr. <?= displayNumber(($total_receivable / 10000000), 2) ?></h5>
            <p class="card-text">Receivables</p>
        </div>
    </div>
    <div class="card text-bg-success">
        <div class="card-body">
            <h5 class="card-title text-end fs-5">Cr. <?= displayNumber(($totals['received_sum'] / 10000000), 2) ?></h5>
            <p class="card-text">Received</p>
        </div>
    </div>
    <div class="card text-bg-danger">
        <div class="card-body">
            <h5 class="card-title text-end fs-5">Cr. <?= displayNumber((($total_receivable - $totals['received_sum']) / 10000000), 2) ?></h5>
            <p class="card-text">Balance</p>
        </div>
    </div>
</div>
<script type="text/javascript">
    function invoiceSort(rows, page, sort_column, sort_order) {
        $('#rows').val(rows);
        $('#page').val(page);
        $('#sort_column').val(sort_column);
        $('#sort_order').val(sort_order);
        invoiceBody(page);
    }
    $(function() {
        // Totals at bottom
        $('[data-bs-toggle="popover"]').each(function( index ) {
            return new bootstrap.Popover($(this));
        });
        // Table freeze
        $('.freeze-table').freezeTable({'freezeColumn': true, 'columnNum': 2, 'freezeColumnHead': true, 'fixedNavbar': '.navbar-custom'});
        $('.freeze-table').scroll(function() {
            $('.freeze-table').freezeTable('resize');
        })
    });
</script>