<?php
/**
 * Profile Details
 */ 
?>
<?= $this->extend('template/template_admin') ?>
<?= $this->section('content') ?>
<?php
/**
 * Profile view foro logged in user
 */

?>
<div class="user-profile">
    <div class="row align-items-center">
        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-5">
            <div class="d-flex border-right px-5 pr-xl-5 pl-xl-0 align-items-center user-header-media">
                <div class="me-4">
                    <div class="profile-img d-flex rounded-circle">
                        <img src="<?php print WEBROOT; ?>img/logo.png" class="img-fluid">
                    </div>
                </div>
                <div class="profile-admin">
                    <h2><?php print $user_details['name'] ?>&nbsp;(<?= $user_details['user_code'] ?>)</h2>
                    <? if($user_details['status'] == '1'){ ?>
                        <div class="badge text-bg-success rounded-pill p-2">Active</div><?
                    }
                    else {
                        ?><div class="badge text-bg-danger rounded-pill p-2">Inactive</div><?
                    }
                    ?>
                </div>                    
            </div>
        </div>
        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
            <div class="user-details px-5 px-sm-5 px-md-5 px-lg-0 px-xl-0 mt-5 mt-sm-5 mt-md-0 mt-lg-0 mt-xl-0">
                <div class="row">
                    <div class="col-md-6 col-sm-12 col-xs-12">
                        <div class="mb-0">
                            <div class="form-view-name">Username</div>
                            <div class="form-view-value"><?php print $user_details['username'];?></div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12 col-xs-12">
                        <div class="mb-0">
                            <div class="form-view-name">E-Mail</div>
                            <div class="form-view-value"><?php print $user_details['email']?></div>
                        </div>
                    </div>
                </div>
                <div class="hr1"></div>
                <div class="row">
                    <div class="col-md-6 col-sm-12 col-xs-12">
                        <div class="mb-0">
                            <div class="form-view-name">Phone Number</div>
                            <div class="form-view-value"><?php print $user_details['phone']?></div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12 col-xs-12">
                        <div class="mb-0">
                            <div class="form-view-name">Added Date</div>
                            <div class="form-view-value"><?php echo displayDate($user_details['created_at']); ?></div>
                        </div>
                    </div>
                </div>
                <div class="hr1"></div>
                <div class="row">
                    <div class="col-md-6 col-sm-12 col-xs-12">
                        <div class="mb-0">
                            <div class="form-view-name">Role</div>
                            <div class="form-view-value"><?php print $roles[$user_details['role']]['name'] ?></div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12 col-xs-12">
                        <div class="mb-0">
                            <div class="form-view-name">Last Login Time</div>
                            <div class="form-view-value"><?php echo isset($user_details['last_login_at']) ? displayDate($user_details['last_login_at'], 'H:i') : '--'; ?></div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style type="text/css">
    .profile-img {
        background-color: var(--bd-callout-bg, var(--bs-gray-100));
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
        font-weight: 600;
        padding: 1.25rem;
        box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;
        border: 1px solid var(--bs-border-color);
        width: 12rem;
        height: 12rem;
    }
    .profile-admin h2 {
        font-size: 1.25rem;
    }
</style>
<?= $this->endSection() ?>