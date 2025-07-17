<?php
/**
 * Change password
 */
?>
<?= $this->extend('template/template_admin') ?>
<?= $this->section('content') ?>
<? if(session()->getFlashdata('status')) { ?>
        <?= alert_success(session()->getFlashdata('status')) ?>
<? } elseif(session()->getFlashdata('error')){ ?>
        <?= alert_danger(session()->getFlashdata('error')) ?>
<? }  ?> 
<div class="row d-flex px-5 pr-xl-5 pl-xl-0 align-items-center">
    <div class="col-12 col-sm-12 col-md-5 col-lg-5 col-xl-5 border-right">
        <div class="d-flex mb-4">
            <div class="align-self-center me-3 profile-icon">
                <span class="bi bi-person-circle"></span>
            </div> 
            <div class="media-body">
                <p class="form-view-name mb-0">Username&nbsp;:</p> 
                <p class="form-view-value mb-0"><? print $user['username'];?></p>
            </div>
        </div>
        <div class="d-flex mb-4">
            <div class="align-self-center me-3 profile-icon">
                <span class="bi bi-envelope-at"></span>
            </div> 
            <div class="media-body">
                <p class="form-view-name mb-0">E-Mail&nbsp;:</p> 
                <p class="form-view-value mb-0"><? print $user['email']?></p>
            </div>
        </div>
        <div class="d-flex">
            <div class="align-self-center me-3 profile-icon">
                <span class="bi bi-telephone"></span>
            </div> 
            <div class="media-body">
                <p class="form-view-name mb-0">Phone Number&nbsp;:</p> 
                <p class="form-view-value mb-0"><? print $user['phone']?></p>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-12 col-md-7 col-lg-7 col-xl-7">
        <form action="<? echo WEBROOT;?>profile/updatePassword" method="post">
            <div class="row mb-3">
                <label for="oldpassword" class="col-sm-4 col-form-label text-end"><? print _("Old Password");?><span class="text-danger">*</span>&nbsp;:</label>
                <div class="col-sm-8">
                    <input type="password" class="form-control" id="oldpassword" name="oldpassword" placeholder="<? print _("Old Password");?>" value="<?= set_value('oldpassword');?>">
                    <span class="text-danger"><?= validation_show_error('oldpassword'); ?></span>
                    <span class="text-danger"><small id="oldpassword_alert"></small></span>
                    <span class="text-danger"><? echo isset($message) ? $message : '';?></span>
                </div>
            </div>
            <div class="row mb-3">
                <label for="password" class="col-sm-4 col-form-label text-end"><? print _("New Password");?><span class="text-danger">*</span>&nbsp;:</label>
                <div class="col-sm-8">
                    <input type="password" class="form-control" id="password" name="password" placeholder="<? print _("New Password");?>" value="<? print set_value('password');?>">
                    <span class="text-danger"><? print validation_show_error('password'); ?></span>
                    <span class="text-danger"><small id="password_alert"></small></span>
                    <span class="text-danger"><? echo isset($conf_message) ? $conf_message : '';?></span>
                </div> 
            </div>
            <div class="row mb-3">
                <label for="passconf" class="col-sm-4 col-form-label text-end"><? print _("Confirm Password");?><span class="text-danger">*</span>&nbsp;:</label>
                <div class="col-sm-8">
                    <input type="password" class="form-control" id="passconf" name="passconf" placeholder="<? print _("Confirm New Password");?>" value="<? print set_value('passconf');?>">
                    <span class="text-danger"><? print validation_show_error('passconf'); ?></span>
                    <span class="text-danger"><small id="cpassword_alert"></small></span>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 text-end">
                    <input type="hidden" class="form-control" id="id" name="id" value="<? print $user['id'];?>">
                    <button type="submit" class="btn btn-success btn-sm"><i class="bi bi-check-square"></i>&nbsp;<? print ("Submit");?></button>
                    <button type="reset" class="btn btn-warning btn-sm" ><i class="bi bi-arrow-clockwise"></i>&nbsp;<? print ("Reset");?></button>
                    <a type="button" class="btn btn-danger btn-sm" href="<? print WEBROOT;?>" class="btn-link">
                        <i class="bi bi-arrow-left"></i>&nbsp;<? print _("Return To Home");?>
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
<style type="text/css">
    .profile-icon .bi {
        font-size: 1.25rem;
        font-weight: normal !important;
        opacity: 0.75;
        color: #303293;
    }
</style>
<?= $this->endSection() ?>
