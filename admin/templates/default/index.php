<?php

    $dirs = scandir(__DIR__ ."/../../components");
    unset($dirs["0"], $dirs["1"]);

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Burgundy CMS Admin</title>
        <!-- META_DESCRIPTION -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
        <link rel="stylesheet" href="templates/<?php echo $this->template->name; ?>/css/font-awesome.min.css">
        <link rel="stylesheet" href="templates/<?php echo $this->template->name; ?>/css/smith-framework.min.css">
        <link rel="stylesheet" href="templates/<?php echo $this->template->name; ?>/css/template.css?v=<?php echo time(); ?>">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
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
              external_filemanager_path:"http://localhost/burgundy-cms/filemanager/",
              filemanager_title:"Responsive Filemanager" ,
              external_plugins: { "filemanager" : "../filemanager/plugin.min.js"},
              extended_valid_elements:"i[class]" });</script>
        <!-- HEADER_STYLES -->
    </head>
    <body>
        <div class="frame">
            <div class="frame-2">
                <div class="sidebar">
                    <div class="menu-header">
                        <a href="index.php"><i class="fa fa-home"></i> ImTrav CMS</a>
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
            <div class="frame-10">
                <div class="main-content">
                    <div class="system-messages">
                        <?php $this->displaySystemMessages(); ?>
                    </div>
                    <?php $this->view->output(); ?>
                    <div class="card centre-text">
                        Burgundy CMS <strong>v0.1</strong> - Copyright <?php echo date("Y", time()); ?> Chris Smith (<a href="mailto:smith0r54@gmail.com" target="_blank">smith0r54@gmail.com</a>)
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>