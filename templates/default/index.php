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
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
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
        <div class="menu-container">
            <div class="header-content">
                <div class="row">
                    <div class="col-md-9">
                        <?php $this->template->displayModules("main-menu"); ?>
                    </div>
                    <div class="col-md-3">
                        <div class="header-login">
                            <?php if ($this->user()->id > 0) { ?>
                                <div class="dropdown">
                                    <button class="user-menu" type="button" data-toggle="dropdown">
                                        <?php echo $this->user()->username; ?> <i class="fa fa-chevron-down"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="<?php echo $this->route("index.php?component=user&controller=profile&id=". $this->user()->id); ?>">My Profile</a>
                                        <?php if ($this->user()->usergroup->is_admin == 1) { ?>
                                            <a class="dropdown-item" href="<?php echo BASE_URL; ?>admin">Admin Panel</a>
                                        <?php } ?>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="<?php echo $this->route("index.php?component=user&controller=user&task=logout"); ?>">Logout</a>
                                    </div>
                                </div>
                            <?php } else { ?>
                                <a href="<?php echo $this->route("index.php?component=user&controller=login"); ?>" class="user-menu">Login</a>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="body-container">
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
                Footer Content
            </div>
        </div>
    </body>
</html>