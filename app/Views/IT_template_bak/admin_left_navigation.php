<?php
/**
 * Admin Navigation
 * It's a view cell
 */
?>
<!-- ========== Topbar Start ========== -->
<div class="navbar-custom">
    <div class="topbar container-fluid">
        <div class="d-flex align-items-center gap-lg-2 gap-1">
            <!-- Sidebar Menu Toggle Button -->
            <button class="button-toggle-menu">
                <i class="bi bi-list"></i>
            </button>
            <span style="width: 90px;">
                <a href="<?= WEBROOT ?>" title="Home"><img src="<?= WEBROOT ?>img/logo.png" alt="logo" class="img-fluid"></a>
            </span>
            <!-- Horizontal Menu Toggle Button -->
            <button class="navbar-toggle" data-bs-toggle="collapse" data-bs-target="#topnav-menu-content">
                <div class="lines">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </button>
        </div>
        <ul class="topbar-menu d-flex align-items-center gap-3">
            <!-- Topbar Search Form -->
            <!-- <div class="app-search dropdown d-none d-lg-block">
                <form action="<?= WEBROOT ?>profile">
                    <div class="input-group">
                        <input type="search" name="key" class="form-control dropdown-toggle" placeholder="Search..." id="top-search">
                        <span class="bi bi-search search-icon"></span>
                        <button class="input-group-text btn btn-primary" type="submit">Search</button>
                    </div>
                </form>
            </div> -->
            <li class="d-none d-sm-inline-block">
                <!-- <a class="nav-link" onclick="myFunction()">
                    <i class="bi bi-brightness-high font-22"></i>
                </a> -->
                <div class="nav-link" id="light-dark-mode" data-bs-toggle="tooltip" data-bs-placement="left" aria-label="Theme Mode" data-bs-original-title="Theme Mode">
                <i class="bi bi-brightness-high font-22"></i>
            </div>
            </li>
            <li class="dropdown">
                <a class="nav-link dropdown-toggle arrow-none nav-user px-2" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                    <span class="d-lg-flex align-items-center gap-1 d-none">
                        <div><h5 class="my-0"><?= session()->get('user')['fname']; ?></h5></div>
                        <div><h6 class="my-0 fw-normal">(<?= session()->get('user')['username']; ?>)</h6></div>
                    </span>
                    <span class="account-user-avatar">
                        <img src="<?= WEBROOT ?>img/profile/profile_img.png" alt="profile-image" class="rounded-circle" width="18">
                    </span>
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated profile-dropdown">
                    <div class=" dropdown-header noti-title">
                        <h6 class="text-overflow m-0">Welcome <?= session()->get('user')['username'] ?>!</h6>
                    </div>
                    <a href="<?= WEBROOT ?>profile" class="dropdown-item">
                        <i class="bi bi-person-circle me-1"></i>
                        <span>My Account</span>
                    </a>
                    <a href="<?= WEBROOT ?>profile/changePassword" class="dropdown-item">
                        <i class="bi bi-person-lock me-1"></i>
                        <span>Change Password</span>
                    </a>
                    <a href="<?= WEBROOT ?>login/logout" class="dropdown-item">
                        <i class="bi bi-box-arrow-right me-1"></i>
                        <span>Logout</span>
                    </a>
                </div>
            </li>
        </ul>
    </div>
</div>
<!-- ========== Topbar End ========== -->

<!-- ========== Left Sidebar Start ========== -->
<div class="leftside-menu menuitem-active">
    <!-- Sidebar -left -->
    <div class="h-100 show" id="leftside-menu-container" data-simplebar="init"><div class="simplebar-wrapper" style="margin: 0px;"><div class="simplebar-height-auto-observer-wrapper"><div class="simplebar-height-auto-observer"></div></div><div class="simplebar-mask"><div class="simplebar-offset" style="right: 0px; bottom: 0px;"><div class="simplebar-content-wrapper" tabindex="0" role="region" aria-label="scrollable content" style="height: 100%; overflow: hidden scroll;"><div class="simplebar-content" style="padding: 0px;">

        <!-- Leftbar User -->
        <div class="leftbar-user"></div>
        <!-- Sidemenu -->
        <ul class="side-nav">
            <li class="side-nav-item menuitem-active">
                <a href="<?= WEBROOT ?>" class="side-nav-link">
                    <i class="bi bi-columns-gap"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="side-nav-item">
                <a href="<?= WEBROOT ?>invoice" class="side-nav-link">
                    <i class="bi bi-file-earmark-ruled"></i>
                    <span>Invoices</span>
                </a>
            </li>
            <li class="side-nav-item">
                <a href="<?= WEBROOT ?>project" class="side-nav-link">
                    <i class="bi bi-archive"></i>
                    <span>Projects</span>
                </a>
            </li>
            <li class="side-nav-item">
                <a href="<?= WEBROOT ?>client" class="side-nav-link">
                    <i class="bi bi-people"></i>
                    <span>Clients</span>
                </a>
            </li>
            <!-- <li class="side-nav-item">
                <a href="<?= WEBROOT ?>payment" class="side-nav-link">
                    <i class="bi bi-file-earmark-check"></i>
                    <span>Payments</span>
                </a>
            </li> -->
            <li class="side-nav-item">
                <a href="<?= WEBROOT ?>bankGuarantee" class="side-nav-link">
                    <i class="bi bi-bank"></i>
                    <span>Bank Guarantee</span>
                </a>
            </li>
            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#reports" aria-expanded="false" aria-controls="reports" class="side-nav-link collapsed">
                    <i class="bi bi-files"></i>
                    <span>Reports</span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="reports">
                    <ul class="side-nav-second-level">
                        <li><a href="<?= WEBROOT ?>reports/invoicePayments">Payments Report</a></li>
                        <li><a href="<?= WEBROOT ?>reports/invoiceDeductions">Deductions Report</a></li>
                    </ul>
                </div>
            </li>
            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#modules" aria-expanded="false" aria-controls="modules" class="side-nav-link collapsed">
                    <i class="bi bi-database"></i>
                    <span>Data Modules</span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="modules">
                    <ul class="side-nav-second-level">
                        <li><a href="<?= WEBROOT ?>location">Locations</a></li>
                        <li><a href="<?= WEBROOT ?>deduction">Deductions</a></li>
                        <li><a href="<?= WEBROOT ?>paymentType">Payment Types</a></li>
                        <li><a href="<?= WEBROOT ?>fileType">File Types</a></li>
                        <li><a href="<?= WEBROOT ?>bankGuaranteeType">Bank Guarantee Types</a></li>
                    </ul>
                </div>
            </li>
            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#user_admin" aria-expanded="false" aria-controls="user_admin" class="side-nav-link collapsed">
                    <i class="bi bi-person-gear"></i>
                    <span>User Administration</span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="user_admin">
                    <ul class="side-nav-second-level">
                        <li><a href="<?= WEBROOT ?>user">Users</a></li>
                        <li><a href="<?= WEBROOT ?>role">Roles</a></li>
                    </ul>
                </div>
            </li>
            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#settings" aria-expanded="false" aria-controls="settings" class="side-nav-link collapsed">
                    <i class="bi bi-gear"></i>
                    <span>Settings</span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="settings">
                    <ul class="side-nav-second-level">
                        <li><a href="<?= WEBROOT ?>configuration">Configuration</a></li>
                        <li><a href="<?= WEBROOT ?>module">Modules</a></li>
                    </ul>
                </div>
            </li>
        </ul>
        <!--- End Sidemenu -->
        <div class="clearfix"></div>

    </div></div></div></div><div class="simplebar-placeholder" style="width: auto; height: auto;"></div></div><div class="simplebar-track simplebar-horizontal" style="visibility: hidden;"><div class="simplebar-scrollbar" style="width: 0px; display: none; transform: translate3d(0px, 0px, 0px);"></div></div><div class="simplebar-track simplebar-vertical" style="visibility: visible;"><div class="simplebar-scrollbar" style="height: 407px; transform: translate3d(0px, 0px, 0px); display: block;"></div></div></div>
</div>
<!-- ========== Left Sidebar End ========== -->