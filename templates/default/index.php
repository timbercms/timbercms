<!DOCTYPE html>
<html>
    <head>
        <title><!-- PAGE_TITLE --></title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- META_DESCRIPTION -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
        <link rel="stylesheet" href="<?php echo BASE_URL; ?>templates/<?php echo $this->template->name; ?>/css/font-awesome.min.css">
        <link rel="stylesheet" href="<?php echo BASE_URL; ?>templates/<?php echo $this->template->name; ?>/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo BASE_URL; ?>templates/<?php echo $this->template->name; ?>/css/template.css?v=<?php echo time(); ?>">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="<?php echo BASE_URL; ?>templates/<?php echo $this->template->name; ?>/js/bootstrap.min.js"></script>
        <script src="<?php echo BASE_URL; ?>tinymce/tinymce.min.js"></script>
        <script>tinymce.init({ selector:'textarea',height:350,theme: 'modern',
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
    </head>
    <body>
        <div class="body-container">
            <div class="header-container">
                <div class="header-content">
                    <div class="row">
                        <div class="col-md-9">
                            &nbsp;
                        </div>
                        <div class="col-md-3">
                            <div class="header-login">
                                <?php if ($this->user()->id > 0) { ?>
                                    <?php echo $this->user()->username; ?> [<a href="<?php echo $this->route("index.php?component=user&controller=user&task=logout"); ?>">Logout</a>]<?php if ($this->user()->usergroup->is_admin == 1) { ?>&nbsp;[<a href="<?php echo BASE_URL; ?>admin">Admin Panel</a>]<?php } ?>
                                <?php } else { ?>
                                    <a href="<?php echo $this->route("index.php?component=user&controller=login"); ?>">Login</a>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="body-content">
                <div class="system-messages">
                    <?php $this->displaySystemMessages(); ?>
                </div>
                <div class="component">
                    <div class="row">
                        <div class="col-md-8">
                            <?php $this->view->output(); ?>
                        </div>
                        <div class="col-md-4">
                            <?php $this->template->displayModules("sidebar"); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-container">
            <div class="footer-content">
                Footer Content
            </div>
        </div>
    </body>
</html>