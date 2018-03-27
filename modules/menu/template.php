<ul class="menu-list">
    <?php foreach ($worker->items as $item) { ?>
        <li class="top-level<?php if (Core::menu_item_id() == $item->id) { echo ' active'; } ?><?php echo (count($item->children) > 0 ? ' parent' : ''); ?>">
            <a href="<?php echo BASE_URL.$item->alias; ?>"><?php echo $item->title; ?><?php echo (count($item->children) > 0 ? '&nbsp;&nbsp;&nbsp;<i class="fas fa-chevron-down"></i>' : ''); ?></a>
            <?php if (count($item->children) > 0) { ?>
                <ul>
                    <?php foreach ($item->children as $child) { ?>
                        <li class="first-child<?php if (Core::menu_item_id() == $child->id) { echo ' active'; } ?><?php echo (count($child->children) > 0 ? ' parent' : ''); ?>">
                            <a href="<?php echo BASE_URL.$child->alias; ?>"><?php echo $child->title; ?></a>
                            <?php if (count($child->children) > 0) { ?>
                                <ul>
                                    <?php foreach ($child->children as $grandchild) { ?>
                                        <li class="second-child<?php if (Core::menu_item_id() == $grandchild->id) { echo ' active'; } ?>"><a href="<?php echo BASE_URL.$grandchild->alias; ?>"><?php echo $grandchild->title; ?></a></li>
                                    <?php } ?>
                                </ul>
                            <?php } ?>
                        </li>
                    <?php } ?>
                </ul>
            <?php } ?>
        </li>
    <?php } ?>
</ul>
<div class="clearfix"></div>