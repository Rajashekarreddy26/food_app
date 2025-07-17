<?php
/**
 * Edit Bank guarantee form
 */

$bg_id = (isset($bank_guarantee['id']) and !empty($bank_guarantee['id'])) ? $bank_guarantee['id'] :((isset($params['bg_id']) and !empty($params['bg_id'])) ? $params['bg_id'] : "");
$name = (isset($bank_guarantee['name']) and !empty($bank_guarantee['name'])) ? $bank_guarantee['name'] : set_value('name');
$bg_number = (isset($bank_guarantee['bg_number']) and !empty($bank_guarantee['bg_number'])) ? $bank_guarantee['bg_number'] : set_value('bg_number');
$bg_bank = (isset($bank_guarantee['bg_bank']) and !empty($bank_guarantee['bg_bank'])) ? $bank_guarantee['bg_bank'] : set_value('bg_bank');
$bg_amount = (isset($bank_guarantee['bg_amount']) and !empty($bank_guarantee['bg_amount'])) ? $bank_guarantee['bg_amount'] : set_value('bg_amount');
$project_val = (isset($bank_guarantee['project_id']) and !empty($bank_guarantee['project_id'])) ? $bank_guarantee['project_id'] : set_value('project');
$bg_type_val = (isset($bank_guarantee['type']) and !empty($bank_guarantee['type'])) ? $bank_guarantee['type'] : set_value('bg_type');
$issue_date = (isset($bank_guarantee['issue_date']) and !empty($bank_guarantee['issue_date'])) ? displayDate($bank_guarantee['issue_date']) : set_value('issue_date');
$valid_date = (isset($bank_guarantee['valid_date']) and !empty($bank_guarantee['valid_date'])) ? displayDate($bank_guarantee['valid_date']) : set_value('valid_date');
$claim_date = (isset($bank_guarantee['claim_date']) and !empty($bank_guarantee['claim_date'])) ? displayDate($bank_guarantee['claim_date']) : set_value('claim_date');
$old_bg_file = (isset($bank_guarantee['bg_file']) and !empty($bank_guarantee['bg_file'])) ?$bank_guarantee['bg_file'] : ((isset($params['old_bg_file']) and !empty($params['old_bg_file'])) ? $params['old_bg_file'] : "");
$note = (isset($bank_guarantee['note']) and !empty($bank_guarantee['note'])) ? $bank_guarantee['note'] : set_value('note');
?>
<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Edit Bank Guarantee</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form name="bg_edit_form" id="bg_edit_form" onsubmit="updateBg(event)">
            <div class="modal-body">
                <input type="hidden" name="bg_id" id="bg_id" value="<?= $bg_id ?>">
                <div class="row">
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <div class="mb-0">
                            <label class="form-label mb-0">Project&nbsp;<span class="text-danger">*</span>&nbsp;:&nbsp;</label>
                            <select class="form-select form-select-sm" name="project" id="project">
                                <option value="">Select</option>
                                <?
                                if (isset($projects) and !empty($projects)) {
                                    foreach ($projects as $key => $project) { ?>
                                        <option value="<?= $project['id'] ?>" <? if ($project['id'] == $project_val) { print "selected='selected'"; } ?>><?= $project['name']." ( ".$project['code']." ) " ?></option>
                                        <?
                                    }
                                 } 
                                ?>
                            </select>
                            <span class="text-danger"><?= validation_show_error('project') ?></span>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <div class="mb-0">
                            <label class="form-label mb-0">BG Type&nbsp;<span class="text-danger">*</span>&nbsp;:&nbsp;</label>
                            <select class="form-select form-select-sm" name="bg_type" id="bg_type">
                                <option value="">Select</option>
                                <?
                                if (isset($bg_types) and !empty($bg_types)) {
                                    foreach ($bg_types as $key => $bg_type) { ?>
                                        <option value="<?= $bg_type['id'] ?>" <? if ($bg_type['id'] == $bg_type_val) { print "selected='selected'"; } ?>><?= $bg_type['name'] ?></option>
                                        <?
                                    }
                                 } 
                                ?>
                            </select>
                            <span class="text-danger"><?= validation_show_error('bg_type') ?></span>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <div class="mb-0">
                            <label for="name" class="form-label mb-0">Name of the Party&nbsp;<span class="text-danger">*</span>&nbsp;:&nbsp;</label>
                            <input type="text" class="form-control form-control-sm" name="name" id="name" value="<?= $name ?>" placeholder="Please Enter Name of the Party">
                            <span class="text-danger"><?= validation_show_error('name') ?></span>
                        </div>
                    </div>
                </div>
                <div class="hr1"></div>
                <div class="row">
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <div class="mb-0">
                            <label for="bg_number" class="form-label mb-0">BG Number&nbsp;<span class="text-danger">*</span>&nbsp;:&nbsp;</label>
                            <input type="text" class="form-control form-control-sm" name="bg_number" id="bg_number" value="<?= $bg_number ?>" placeholder="Please Enter BG Number">
                            <span class="text-danger"><?= validation_show_error('bg_number') ?></span>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <div class="mb-0">
                            <label for="bg_amount" class="form-label mb-0">BG Amount&nbsp;<span class="text-danger">*</span>&nbsp;:&nbsp;</label>
                            <input type="text" class="form-control form-control-sm text-end" name="bg_amount" id="bg_amount" value="<?= $bg_amount ?>" placeholder="Please Enter BG Amount">
                            <span class="text-danger"><?= validation_show_error('bg_amount') ?></span>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <div class="mb-0">
                            <label for="bg_bank" class="form-label mb-0">Bank Name&nbsp;<span class="text-danger">*</span>&nbsp;:&nbsp;</label>
                            <input type="text" class="form-control form-control-sm" name="bg_bank" id="bg_bank" value="<?= $bg_bank ?>" placeholder="Please Enter Bank Name">
                            <span class="text-danger"><?= validation_show_error('bg_bank') ?></span>
                        </div>
                    </div>
                </div>
                <div class="hr1"></div>
                <div class="row">
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <div class="mb-0">
                            <label for="issue_date" class="form-label mb-0">BG Issue date&nbsp;<span class="text-danger">*</span>&nbsp;:&nbsp;</label>
                            <div class="input-group input-group-sm date">
                                <input type="text" name="issue_date" id="issue_date" class="form-control" value="<?= $issue_date ?>" placeholder="DD-MM-YYYY">
                                <span class="input-group-text"><i class="bi bi-calendar4-week"></i></span>
                            </div>
                            <span class="text-danger"><?= validation_show_error('issue_date') ?></span>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <div class="mb-0">
                            <label for="valid_date" class="form-label mb-0">BG Valid Date&nbsp;<span class="text-danger">*</span>&nbsp;:&nbsp;</label>
                            <div class="input-group input-group-sm date">
                                <input type="text" class="form-control" id="valid_date" name="valid_date" value="<?= $valid_date ?>" placeholder="DD-MM-YYYY">
                                <span class="input-group-text"><i class="bi bi-calendar4-week"></i></span>
                            </div>
                            <span class="text-danger"><?= validation_show_error('valid_date') ?></span>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <div class="mb-0">
                            <label for="claim_date" class="form-label mb-0">BG Claim Date&nbsp;<span class="text-danger">*</span>&nbsp;:&nbsp;</label>
                            <div class="input-group input-group-sm date">
                                <input type="text" class="form-control" id="claim_date" name="claim_date" value="<?= $claim_date ?>" placeholder="DD-MM-YYYY">
                                <span class="input-group-text"><i class="bi bi-calendar4-week"></i></span>
                            </div>
                            <span class="text-danger"><?= validation_show_error('claim_date') ?></span>
                        </div>
                    </div>
                </div>
                <div class="hr1"></div>
                <div class="row">
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="mb-0">
                            <label class="form-label mb-0">Old BG File&nbsp;:&nbsp;</label>
                            <input type="hidden" name="old_bg_file" id="old_bg_file" value="<?= $old_bg_file ?>">
                            <? if (isset($old_bg_file) and $old_bg_file != '') { ?>
                                <a href="<?= WEBROOT ?>files/bank_guarantee/<?= $old_bg_file ?>" target="_blank"><i class="bi bi-file-earmark-pdf"></i>&nbsp;<?= $old_bg_file ?></a>
                            <? }
                            else {
                                echo "NA";
                            } ?>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12 col-xs-12">
                        <div class="mb-0">
                            <label for="bg_file" class="form-label mb-0">BG File&nbsp;<span class="text-danger">*</span>&nbsp;:&nbsp;</label>
                            <div class="input-group input-group-sm">
                                <input type="file" class="form-control form-control-sm" id="bg_file" name="bg_file">
                            </div>
                            <span class="text-danger"><?= validation_show_error('bg_file') ?></span>
                            <small>Allowed file types (pdf, docx, doc, png, jpg).</small>
                            <small>Maximum file size 20MB.</small>
                        </div>                   
                    </div>
                </div>
                <div class="hr1"></div>
                <div class="row">
                    <div class="mb-3">
                        <label for="form-label mb-0">Note&nbsp;:&nbsp;</label>
                        <textarea class="form-control" name="note" id="note" placeholder="Description"><?= $note ?></textarea>
                    </div>
                    <span class="text-danger"><?= validation_show_error('note') ?></span>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success btn-sm"><i class="bi bi-check-square"></i>&nbsp;Update</button>
                <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal"><i class="bi bi-x-square"></i>&nbsp;Close</button>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript">
    $('#issue_date').datepicker({format:'dd-mm-YYYY',autoHide:true});
    $('#valid_date').datepicker({format:'dd-mm-YYYY',autoHide:true});
    $('#claim_date').datepicker({format:'dd-mm-YYYY',autoHide:true});


</script>