<?php

    #=======================================================================================
    # * Bulletin. CMS
    # --------------------------------------------------------------------------------------
    # * GNU General Public License (GPL) (https://opensource.org/licenses/GPL-3.0)
    # * https://www.github.com/Smith0r
    #=======================================================================================

?>
<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $this->page_title; ?></title>
        <meta name="description" content="<?php echo $this->meta_description; ?>" />
    </head>
    <body>
        <div class="extension-container">
            <?php $this->view->display(); ?>
        </div>
    </body>
</html>