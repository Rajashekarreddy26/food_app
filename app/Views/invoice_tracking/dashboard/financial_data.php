<?php
/**
 * Invoice tracking
 * Dashboard - Financial data
 */
$fy = isset($fy) ? $fy : date('Y');
$fy_end = 2019;
?>
<div class="card">
    <div class="card-header">
        <div class="float-start"><h2 class="fs-5"><i class="bi bi-layers"></i>&nbsp;Financial Data - Turnover</h2></div>
        <div class="float-end d-flex align-items-center">
            <div class="me-1">FY: </div>
            <div class="me-1">
            <select name="fy" class="form-select form-select-sm pb-0 pt-0" onchange="dashboardFinancialData(this.value)">
                <option>All</option>
                <?php
                for($y = date('Y'); $y >= $fy_end; $y--) {
                    ?><option value="<?= $y ?>" <? if($fy == $y) echo'selected'; ?>><?= $y ?></option><?
                }
                ?>
            </select>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <div class="fw-semibold text-info-emphasis border border-info-subtle rounded-2 p-4">
                    <h5 class="card-title text-end fs-5">Cr. 100000</h5>
                    <p class="card-text fs-6">Invoice Value (Basic)</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="fw-semibold text-success-emphasis border border-success-subtle rounded-2 p-4">
                    <h5 class="card-title text-end fs-5">Cr. 15000000</h5>
                    <p class="card-text fs-6">Invoice Value (Basic + TAX)</p>
                </div>
            </div>
        </div>
    </div>
</div>