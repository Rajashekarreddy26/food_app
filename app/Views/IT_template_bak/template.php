<?php
/**
 * Template
 * 
 * Template usage
 *  $data['page'] = array(
 *      'title' => 'Main Title',                                - 
 *      'page_title' => 'Page Tilte',                           -
 *      'breadcrumb' => [['name' => 'name', 'url' => 'url']],   -
 *      'layout' => 1,                                          - Optional [0 or 1] for fullscreen pages like dahsboards etc,.
 *      'js' => [file1, file2,],                                - load path public/js/<file-name>
 *      'css' => [file1, file,],                                - load path public/css/<file-name>
 *  );
 * @author Ramakrishna<rama@highgoweb.com>
 * @version 1.0
 */
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?= esc(PROJECT_TITLE) ?> : <?= esc($page['title']) ?></title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- CSS files -->
        <link rel="stylesheet" type="text/css" href="<? echo WEBROOT;?>bootstrap-5.3.2/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="<? echo WEBROOT;?>css/template.css">        
        <?
        // Project CSS files
        if(isset($page['css'])) {
            foreach($page['css'] as $css_file) {
                ?><link rel="stylesheet" type="text/css" href="<?= WEBROOT ?>css/<?= $css_file ?>"><?
            }
        }
        ?>
        <!-- JS files -->
        <script type="text/javascript" src="<? echo WEBROOT;?>js/jquery-3.7.1.min.js"></script>
        <script type="text/javascript" src="<? echo WEBROOT;?>bootstrap-5.3.2/js/bootstrap.min.js"></script>
        <script type="text/javascript">var WEBROOT = '<?= WEBROOT ?>';</script>
        <?
        // Project JS files
        if(isset($page['js'])) {
            foreach($page['js'] as $js_file) {
                ?><script type="text/javascript" src="<?= WEBROOT ?>js/<?= $js_file ?>"></script><?
            }
        }
        ?>
    </head>
    <body>
        <?
        $page_layout = isset($page['layout']) ? $page['layout'] : 0;
        ?>
        <header>
            <div>
                <? // Load main navigation ?>
                <?= view_cell('Navigation::mainNavigation') ?>
            </div>
        </header>
        <div class="page-body">
            <? if($page_layout == 0):?>
                <div class="page-title">
                    <h3><?= esc($page['page_title']); ?></h3>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?= esc(WEBROOT) ?>">Home</a></li>
                            <?
                            if(isset($page['breadcrumb'])) {
                                foreach($page['breadcrumb'] as $breadcrumb_item) {
                                    ?><li class="breadcrumb-item"><a href="<?= esc(WEBROOT) . esc($breadcrumb_item['url']) ?>"><?= esc($breadcrumb_item['name']) ?></a></li><?
                                }
                            }
                            ?>
                            <li class="breadcrumb-item active" aria-current="page"><?= esc($page['page_title']); ?></li>
                        </ol>
                    </nav>
                </div>
            <? endif;?>
            <div class="page-content"><?= $this->renderSection('content'); ?></div>
        </div>
        <footer>
            <div class="text-center">
                <? // Load footer navigation ?>
                <?= view_cell('Navigation::footerNavigation') ?>
                &copy;<?= date('Y');?> HighGo&reg;
            </div>
        </footer>        
    </body>
</html>