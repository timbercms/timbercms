<ul class="menu-list">
    <?php foreach ($worker->items as $menuitem) { ?>
        <li><a href="<?php echo BASE_URL.$menuitem->alias; ?>"><?php echo $menuitem->title; ?></a></li>
    <?php } ?>
</ul>