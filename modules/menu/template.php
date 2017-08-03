<ul class="menu-list">
    <?php foreach ($worker->items as $menuitem) { ?>
        <li><a href="<?php echo Core::route("index.php?component=". $menuitem->component ."&controller=". $menuitem->controller.($menuitem->content_id > 0 ? "&id=". $menuitem->content_id : "")); ?>"><?php echo $menuitem->title; ?></a></li>
    <?php } ?>
</ul>