<?php
/**
 * Admin Template view
 * This template was developed for CodeIgniter4, and this template will be called in views with section.
 * The code between the section(content) in the view will be diaplayed here with the renderSection()
 * 
 * Template usage
 *  $data['page'] = array(
 *      'title' => 'Main Title',                                -
 *      'page_title' => 'Page Tilte',                           -
 *      'breadcrumb' => [['name' => 'name', 'url' => 'url']],   -
 *      'layout' => 1,                                          - Optional [0 or 1] for fullscreen pages like dahsboards etc,.
 *      'js' => [file1, file2,],                                - load path public/js/admin/<file-name>
 *      'css' => [file1, file,],                                - load path public/css/admin/<file-name>
 *  );
 * @author
 * @version 1.0
 */
?>
<!DOCTYPE html>
<html lang="en" class="menuitem-active">
    <head>
        <title><?= esc(PROJECT_TITLE) ?> : <?= esc($page['title']) ?></title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="<?= WEBROOT ?>img/favicon.jpeg" type="image/x-icon">
       <?/* <!-- CSS files -->
        <link rel="stylesheet" type="text/css" href="<?= WEBROOT ?>bootstrap-5.3.2/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="<?= WEBROOT ?>css/admin/template_admin.css">
        <!-- bootstrap icons -->
        <link rel="stylesheet" href="<?php echo WEBROOT;?>bootstrap-5.3.2/icons/bootstrap-icons.css">
        <!-- menu css -->
        <link rel="stylesheet" type="text/css" href="<? echo WEBROOT;?>menu/css/theme.css" id="app-style">*/?>


        <!-- plugins:css -->
        <link rel="stylesheet" href="<? echo WEBROOT;?>vendors/mdi/css/materialdesignicons.min.css">
        <link rel="stylesheet" href="<? echo WEBROOT;?>vendors/ti-icons/css/themify-icons.css">
        <link rel="stylesheet" href="<? echo WEBROOT;?>vendors/css/vendor.bundle.base.css">
        <link rel="stylesheet" href="<? echo WEBROOT;?>vendors/font-awesome/css/font-awesome.min.css">
        <!-- endinject -->
        <!-- Plugin css for this page -->
        <link rel="stylesheet" href="<? echo WEBROOT;?>vendors/font-awesome/css/font-awesome.min.css" />
        <link rel="stylesheet" href="<? echo WEBROOT;?>vendors/bootstrap-datepicker/bootstrap-datepicker.min.css">
        <!-- End plugin css for this page -->
        <!-- inject:css -->
        <!-- endinject -->
        <!-- Layout styles -->
        <!-- <link rel="stylesheet" type="text/css" href="./assets/bootstrap/css/bootstrap.min.css"> -->
        <link rel="stylesheet" href="<? echo WEBROOT;?>vendors/css/theme.css">
        <link rel="stylesheet" type="text/css" href="<? echo WEBROOT;?>css/style.css">
        <?php
        // Project CSS files
        if(isset($page['css'])) {
            foreach($page['css'] as $css_file) {
                ?><link rel="stylesheet" type="text/css" href="<?= WEBROOT ?>css/<?php print $css_file ?>.css?<?= CCV ?>"><?php
            }
        }
        ?>
        <?/*<!-- DatePicker css -->
        <link rel="stylesheet" type="text/css" href="<?= WEBROOT ?>date-picker/datepicker.min.css" />
        <!-- JS files -->
        <script type="text/javascript">var WEBROOT = '<?= WEBROOT ?>';</script>
        <script type="text/javascript" src="<?= WEBROOT ?>js/jquery-3.7.1.min.js"></script>
        <script type="text/javascript" src="<?= WEBROOT ?>bootstrap-5.3.2/js/bootstrap.bundle.min.js"></script>
        <script type="text/javascript" src="<?= WEBROOT ?>date-picker/datepicker.min.js"></script>
        <script type="text/javascript" src="<?= WEBROOT ?>js/main.js"></script>*/?>

        
        <!-- End custom js for this page -->
        <?php
        // Project JS files
        if(isset($page['js'])) {
            foreach($page['js'] as $js_file) {
                ?><script type="text/javascript" src="<?= WEBROOT ?>js/<?= $js_file ?>.js?<?= CCV ?>"></script><?php
            }
        }
        ?>
    </head>
    <body>
        <div class="container-scroller">
            <? $page_layout = isset($page['layout']) ? $page['layout'] : 0; ?>
            <? // Load main navigation ?>
            <?= view_cell('AdminNavigation::leftNavigation') ?>
            <div class="main-panel">
                <div class="content-wrapper">
                    <? if($page_layout == 0):?>
                        <div class="page-header">
                            <h3 class="page-title">
                                <span class="page-title-icon bg-gradient-primary text-white me-2">
                                  <i class="mdi mdi-home"></i>
                                </span> <?= esc($page['page_title']); ?>
                            </h3>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb fd-breadcrumb">
                                    <li class="breadcrumb-item"><a href="<?= esc(WEBROOT) ?>">Home</a></li>
                                    <?php
                                    if(isset($page['breadcrumb'])) {
                                        foreach($page['breadcrumb'] as $breadcrumb_item) {
                                            ?><li class="breadcrumb-item"><a href="<?php print esc(WEBROOT) . esc($breadcrumb_item['url']) ?>"><?= esc($breadcrumb_item['name']) ?></a></li><?php
                                        }
                                    }
                                    ?>
                                    <li class="breadcrumb-item active" aria-current="page"><?= esc($page['page_title']); ?></li>
                                </ol>
                            </nav>
                        </div>
                        <?= $this->renderSection('content'); ?>
                    <? else: ?>
                        <?= $this->renderSection('content'); ?>
                    <? endif; ?>
                </div>
                <footer class="footer">
                    <div class="d-sm-flex justify-content-center justify-content-sm-between">
                        <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © 2025 <a href="https://www.bootstrapdash.com/" target="_blank">FoodApp</a>. All rights reserved.</span>
                      <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Made with <i class="mdi mdi-heart text-danger"></i></span>
                    </div>
                </footer>
            </div>
        </div>
        <!-- plugins:js -->
        <script src="<?= WEBROOT ?>vendors/js/vendor.bundle.base.js"></script>
        <!-- endinject -->
        <!-- Plugin js for this page -->
        <script src="<?= WEBROOT ?>vendors/chart.js/chart.umd.js"></script>
        <script src="<?= WEBROOT ?>vendors/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
        <!-- End plugin js for this page -->
        <!-- inject:js -->
        <script src="<?= WEBROOT ?>vendors/js-theme/off-canvas.js"></script>
        <script src="<?= WEBROOT ?>vendors/js-theme/hoverable-collapse.js"></script>
        <script src="<?= WEBROOT ?>vendors/js-theme/misc.js"></script>
        <!-- endinject -->
        <!-- Custom js for this page -->
        <script src="<?= WEBROOT ?>vendors/js-theme/dashboard.js"></script>
    </body>
</html>