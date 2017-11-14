<ul class="menu-list">
    <?php foreach ($worker->items as $menuitem) { ?>
        <li<?php if (Core::menu_item_id() == $menuitem->id) { echo ' class="active"'; } ?>><a href="<?php echo BASE_URL.$menuitem->alias; ?>"><?php echo $menuitem->title; ?></a></li>
    <?php } ?>
</ul>