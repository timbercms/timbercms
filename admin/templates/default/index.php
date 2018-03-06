<?php

    $dirs = scandir(__DIR__ ."/../../components");
    unset($dirs["0"], $dirs["1"]);
    $version = simplexml_load_file(__DIR__ ."/../../version.xml");
    $web_version = simplexml_load_file("https://raw.githubusercontent.com/Smith0r/bulletin/master/admin/version.xml", null, LIBXML_NOCDATA);

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Bulletin. Admin</title>
        <!-- META_DESCRIPTION -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
        <link rel="stylesheet" href="templates/<?php echo $this->template->name; ?>/css/font-awesome.min.css">
        <link rel="stylesheet" href="templates/<?php echo $this->template->name; ?>/css/bootstrap.min.css">
        <link rel="stylesheet" href="templates/<?php echo $this->template->name; ?>/css/template.css?v=<?php echo time(); ?>">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
        <script src="templates/<?php echo $this->template->name; ?>/js/bootstrap.min.js"></script>
        <script src="templates/<?php echo $this->template->name; ?>/js/sweetalert.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/core-js/2.4.1/core.js"></script>
        <script src="templates/<?php echo $this->template->name; ?>/js/template.js?v=<?php echo time(); ?>"></script>
        <script src="../tinymce/tinymce.min.js"></script>
        <script>tinymce.init({ selector:'textarea',height:500,theme: 'modern',
              plugins: [
                'advlist autolink lists link image charmap print preview hr anchor pagebreak',
                'searchreplace wordcount visualblocks visualchars code fullscreen',
                'insertdatetime media nonbreaking save table contextmenu directionality',
                'emoticons template paste textcolor colorpicker textpattern imagetools responsivefilemanager'
              ],
              toolbar1: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media | code responsivefilemanager',
              image_advtab: true,
              relative_urls: false,
              external_filemanager_path:"https://localhost/bulletin/filemanager/",
              filemanager_title:"Responsive Filemanager" ,
              external_plugins: { "filemanager" : "../filemanager/plugin.min.js"},
              extended_valid_elements:"i[class]" });</script>
        <!-- HEADER_STYLES -->
        <!-- HEADER_SCRIPTS -->
    </head>
    <body>
        <div class="action-bar">
            <div class="dropdown">
                <a class="dropdown-toggle" href="#" type="button" role="button" id="adminUserMenu" data-toggle="dropdown">
                    <img src="<?php echo $this->user()->avatar; ?>" /><span class="user-username"><?php echo $this->user()->username; ?><i class="fa fa-chevron-down"></i></span>
                </a>
                <div class="dropdown-menu" aria-labelledby="adminUserMenu">
                    <a class="dropdown-item" href="../user/user/?task=logout">Logout</a>
                </div>
            </div>
        </div>
        <div class="row" style="margin-right: 0px !important;">
            <div class="col-md-2" style="padding-right: 0px !important;">
                <div class="sidebar">
                    <div class="menu-header">
                        <a href="index.php"><i class="fa fa-circle-o"></i> Bulletin.</a>
                    </div>
                    <div class="menu-container">
                        <ul>
                            <?php 
                                foreach ($dirs as $dir) 
                                {
                                    if (file_exists(__DIR__ ."/../../components/". $dir ."/extension.xml")) {
                                        $xml = simplexml_load_file(__DIR__ ."/../../components/". $dir ."/extension.xml");
                                        foreach ($xml->items as $item)
                                        {
                                            ?>
                                            <li>
                                                <a href="index.php?component=<?php echo $dir; ?>&controller=<?php echo $item->attributes()->value; ?>"><i class="fa fa-<?php echo $item->attributes()->icon; ?>"></i> <?php echo $item->attributes()->label; ?></a>
                                            </li>
                                            <?php
                                        }
                                    }
                                } 
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-10" style="padding-left: 30px !important;">
                <div class="main-content">
                    <div class="system-messages">
                        <?php $this->displaySystemMessages(); ?>
                    </div>
                    <?php $this->view->output(); ?>
                    <div class="white-card centre-text">
                        Bulletin. <strong>v<?php echo $version->numerical; ?></strong>
                        <?php if (version_compare($version->numerical, $web_version->numerical)) { ?>
                             - <span class="badge badge-danger version-label">UPDATE (v<?php echo $web_version->numerical; ?> Available)</span>
                        <?php } else { ?>
                             - <span class="badge badge-success version-label">UP TO DATE</span>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            $(document).ready(function() {
                setTimeout(function() {
                    $(".sidebar").css("height", $("html").height() + "px");
                }, 750);
            });
        </script>
    </body>
</html>