<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">View Bank Guarantee</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="mb-0">
                        <div class="form-view-name">Project&nbsp;:</div>
                        <div class="form-view-value"><?= (isset($bank_guarantee['project_name']) and !empty($bank_guarantee['project_name'])) ? $bank_guarantee['project_name']." ( ".$bank_guarantee['project_code']." ) " : "-" ?></div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="mb-0">
                        <div class="form-view-name">BG Type&nbsp;:</div>
                        <div class="form-view-value"><?= (isset($bank_guarantee['bg_type']) and !empty($bank_guarantee['bg_type'])) ? $bank_guarantee['bg_type'] : "-" ?></div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="mb-0">
                        <div class="form-view-name">Name of the Party&nbsp;:</div>
                        <div class="form-view-value"><?= (isset($bank_guarantee['name']) and !empty($bank_guarantee['name'])) ? $bank_guarantee['name'] : "-" ?></div>
                    </div>
                </div>
            </div>
            <div class="hr1"></div>
            <div class="row">
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="mb-0">
                        <div class="form-view-name">BG Number&nbsp;:</div>
                        <div class="form-view-value"><?= (isset($bank_guarantee['bg_number']) and !empty($bank_guarantee['bg_number'])) ? $bank_guarantee['bg_number'] : "-" ?></div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="mb-0">
                        <div class="form-view-name">BG Amount&nbsp;:</div>
                        <div class="form-view-value"><?= (isset($bank_guarantee['bg_amount']) and !empty($bank_guarantee['bg_amount'])) ? displayMoney($bank_guarantee['bg_amount'],2) : "-" ?></div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="mb-0">
                        <div class="form-view-name">Bank Name&nbsp;:</div>
                        <div class="form-view-value"><?= (isset($bank_guarantee['bg_bank']) and !empty($bank_guarantee['bg_bank'])) ? $bank_guarantee['bg_bank'] : "-" ?></div>
                    </div>
                </div>
            </div>
            <div class="hr1"></div>
            <div class="row">
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="mb-0">
                        <div class="form-view-name">BG Issue Date&nbsp;:</div>
                        <div class="form-view-value"><?= (isset($bank_guarantee['issue_date']) and !empty($bank_guarantee['issue_date'])) ? displayDate($bank_guarantee['issue_date']) : "-" ?></div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="mb-0">
                        <div class="form-view-name">BG Valid Upto&nbsp;:</div>
                        <div class="form-view-value"><?= (isset($bank_guarantee['valid_date']) and !empty($bank_guarantee['valid_date'])) ? displayDate($bank_guarantee['valid_date']) : "-" ?></div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="mb-0">
                        <div class="form-view-name">BG Claim Date&nbsp;:</div>
                        <div class="form-view-value"><?= (isset($bank_guarantee['claim_date']) and !empty($bank_guarantee['claim_date'])) ? displayDate($bank_guarantee['claim_date']) : "-" ?></div>
                    </div>
                </div>
            </div>
            <div class="hr1"></div>
            <div class="row">
                <div class="col-md-8 col-sm-6 col-xs-12">
                    <div class="mb-0">
                        <div class="form-view-name">BG File&nbsp;:</div>
                        <div class="form-view-value">
                            <? if (isset($bank_guarantee['bg_file']) and !empty($bank_guarantee['bg_file'])) { ?>
                                <a href="<?= WEBROOT ?>files/bank_guarantee/<?= $bank_guarantee['bg_file'] ?>" target="_blank"><i class="bi bi-file-earmark-arrow-down"></i>&nbsp;<?= $bank_guarantee['bg_file'] ?></a>
                            <? }
                            else {
                                echo "NA";
                            } ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="hr1"></div>
            <div class="row">
                <div class="col-md-12 col-sm-6 col-xs-12">
                    <div class="mb-0">
                        <div class="form-view-name">Note&nbsp;:</div>
                        <div class="form-view-value"><?= (isset($bank_guarantee['note']) and !empty($bank_guarantee['note'])) ? $bank_guarantee['note'] : "-" ?></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal"><i class="bi bi-x-square"></i>&nbsp;Close</button>
        </div>
    </div>
</div>