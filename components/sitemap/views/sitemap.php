<h1>Sitemap</h1>
<?php foreach ($this->model->items as $item) { ?>
    <?php if ($item->component != "system") { ?>
        <p><a href="<?php echo Core::route("index.php?component=". $item->component ."&controller=". $item->controller .($item->content_id > 0 ? "&id=". $item->content_id : "")); ?>"><?php echo $item->title; ?></a></p>
    <?php } ?>
<?php } ?>
<?php Core::hooks()->executeHook("onHTMLSitemap"); ?>