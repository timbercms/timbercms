<!DOCTYPE html>
<html>
    <head>
        <title><!-- PAGE_TITLE --></title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- META_DESCRIPTION -->
        <!-- META_AUTHOR -->
        <!-- META_PROPERTIES -->
        <!-- META_ITEMPROPS -->
        <!-- META_NAMES -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
        <link rel="stylesheet" href="<?php echo BASE_URL; ?>templates/<?php echo $this->template->name; ?>/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo BASE_URL; ?>templates/<?php echo $this->template->name; ?>/css/template.css?v=<?php echo time(); ?>">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="<?php echo BASE_URL; ?>templates/<?php echo $this->template->name; ?>/js/bootstrap.bundle.min.js"></script>
        <script src="<?php echo BASE_URL; ?>tinymce/tinymce.min.js"></script>
        <script src="<?php echo BASE_URL; ?>templates/<?php echo $this->template->name; ?>/js/fontawesome-all.min.js?v=<?php echo time(); ?>"></script>
        <script src="<?php echo BASE_URL; ?>templates/<?php echo $this->template->name; ?>/js/template.js?v=<?php echo time(); ?>"></script>
        <script>tinymce.init({ selector:'.editor',height:350,theme: 'modern',
                menubar:false,
                statusbar: false,
              plugins: [
                'advlist autolink lists link charmap print preview hr anchor pagebreak',
                'searchreplace wordcount visualblocks visualchars code fullscreen',
                'insertdatetime media nonbreaking save table contextmenu directionality',
                'emoticons template paste textcolor colorpicker textpattern'
              ],
              toolbar1: 'undo redo | bold italic | bullist numlist outdent indent | link | preview media<?php if ($this->user()->usergroup->is_admin == 1) { ?> | code<?php } ?>', });</script>
        <!-- HEADER_STYLES -->
        <?php $detect = new Mobile_Detect; ?>
        <?php if ($detect->isMobile()) { ?>
            <link rel="stylesheet" href="<?php echo BASE_URL; ?>templates/<?php echo $this->template->name; ?>/css/template-responsive.css?v=<?php echo time(); ?>">
        <?php } ?>
        <!-- HEADER_SCRIPTS -->
    </head>
    <body>
        <div class="body-container">
            <div class="branding-container">
                <div class="website-title">
                    <?php echo Core::config()->site_title; ?>
                </div>
            </div>
            <div class="menu-container">
                <?php $this->template->displayModules("main-menu"); ?>
            </div>
            <div class="body-content">
                <div class="system-messages">
                    <?php $this->displaySystemMessages(); ?>
                </div>
                <div class="row">
                    <div class="<?php echo ($this->template->hasModules("sidebar") ? "col-md-9" : "col-md-12"); ?>">
                        <div class="component-container">
                            <?php $this->view->output(); ?>
                        </div>
                    </div>
                    <?php if ($this->template->hasModules("sidebar")) { ?>
                        <div class="col-md-3">
                            <?php $this->template->displayModules("sidebar"); ?>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
        <div class="footer-container">
            <div class="footer-content">
                <div class="row">
                    <div class="col-md-3">
                        <?php $this->template->displayModules("footer-col-1"); ?>
                    </div>
                    <div class="col-md-3">
                        <?php $this->template->displayModules("footer-col-2"); ?>
                    </div>
                    <div class="col-md-3">
                        <?php $this->template->displayModules("footer-col-3"); ?>
                    </div>
                    <div class="col-md-3">
                        <?php $this->template->displayModules("footer-col-4"); ?>
                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            $(function () {
                $('[data-toggle="tooltip"]').tooltip()
            });
        </script>
    </body>
</html>