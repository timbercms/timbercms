<?php $detect = new Mobile_Detect; ?>
<?php if (!$detect->isMobile()) { ?>
    <ul class="menu-list">
        <?php foreach ($worker->items as $item) { ?>
            <?php if (!is_array($item->params["access"]) || (is_array($item->params["access"]) && in_array(Core::user()->usergroup->id, $item->params["access"])) || (is_array($item->params["access"]) && in_array(0, $item->params["access"]))) { ?>
                <li class="top-level<?php if (Core::menu_item_id() == $item->id) { echo ' active'; } ?><?php echo (count($item->children) > 0 ? ' parent' : ''); ?>">
                    <a<?php if ($item->controller != "separator") { ?> href="<?php if ($item->component == "system" && $item->controller == "external") { echo $item->params["external_link"]; } else { echo BASE_URL.$item->alias; } ?>"<?php } ?><?php if ($item->component == "system" && $item->controller == "external") { echo ' target="_blank"'; } ?>><?php echo $item->title; ?><?php echo (count($item->children) > 0 ? '&nbsp;&nbsp;&nbsp;<i class="fas fa-chevron-down"></i>' : ''); ?></a>
                    <?php if (count($item->children) > 0) { ?>
                        <ul>
                            <?php foreach ($item->children as $child) { ?>
                                <?php if (!is_array($child->params["access"]) || (is_array($child->params["access"]) && in_array(Core::user()->usergroup->id, $child->params["access"])) || (is_array($child->params["access"]) && in_array(0, $child->params["access"]))) { ?>
                                    <li class="first-child<?php if (Core::menu_item_id() == $child->id) { echo ' active'; } ?><?php echo (count($child->children) > 0 ? ' parent' : ''); ?>">
                                        <a<?php if ($child->controller != "separator") { ?> href="<?php if ($child->component == "system" && $child->controller == "external") { echo $child->params["external_link"]; } else { echo BASE_URL.$item->alias."/".$child->alias; } ?>"<?php } ?><?php if ($child->component == "system" && $child->controller == "external") { echo ' target="_blank"'; } ?>><?php echo $child->title; ?><?php echo (count($child->children) > 0 ? '&nbsp;&nbsp;&nbsp;<i class="fas fa-chevron-down"></i>' : ''); ?></a>
                                        <?php if (count($child->children) > 0) { ?>
                                            <ul>
                                                <?php foreach ($child->children as $grandchild) { ?>
                                                    <?php if (!is_array($grandchild->params["access"]) || (is_array($grandchild->params["access"]) && in_array(Core::user()->usergroup->id, $grandchild->params["access"])) || (is_array($grandchild->params["access"]) && in_array(0, $grandchild->params["access"]))) { ?>
                                                        <li class="second-child<?php if (Core::menu_item_id() == $grandchild->id) { echo ' active'; } ?>">
                                                            <a<?php if ($grandchild->controller != "separator") { ?> href="<?php if ($grandchild->component == "system" && $grandchild->controller == "external") { echo $grandchild->params["external_link"]; } else { echo BASE_URL.$item->alias."/".$child->alias."/".$grandchild->alias; } ?>"<?php } ?><?php if ($grandchild->component == "system" && $grandchild->controller == "external") { echo ' target="_blank"'; } ?>><?php echo $grandchild->title; ?></a>
                                                        </li>
                                                    <?php } ?>
                                                <?php } ?>
                                            </ul>
                                        <?php } ?>
                                    </li>
                                <?php } ?>
                            <?php } ?>
                        </ul>
                    <?php } ?>
                </li>
            <?php } ?>
        <?php } ?>
    </ul>
    <div class="clearfix"></div>
<?php } else { ?>
    <div class="mobile-menu">
        <div class="mobile-menu-toggler">
            <div class="mobile-menu-button">
                <i class="fas fa-bars"></i>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-10">
                <div class="mobile-menu-container">
                    <ul class="mobile-menu-list">
                        <?php foreach ($worker->items as $item) { ?>
                            <?php if (!is_array($item->params["access"]) || (is_array($item->params["access"]) && in_array(Core::user()->usergroup->id, $item->params["access"])) || (is_array($item->params["access"]) && in_array(0, $item->params["access"]))) { ?>
                                <li class="top-level<?php if (Core::menu_item_id() == $item->id) { echo ' active'; } ?><?php echo (count($item->children) > 0 ? ' parent' : ''); ?>">
                                    <a<?php if ($item->controller != "separator") { ?> href="<?php if ($item->component == "system" && $item->controller == "external") { echo $item->params["external_link"]; } else { echo BASE_URL.$item->alias; } ?>"<?php } ?><?php if ($item->component == "system" && $item->controller == "external") { echo ' target="_blank"'; } ?>><?php echo $item->title; ?><?php echo (count($item->children) > 0 ? '&nbsp;&nbsp;&nbsp;<i class="fas fa-chevron-down"></i>' : ''); ?></a>
                                    <div class="parent-toggler"><?php echo (count($item->children) > 0 ? '<i class="fas fa-chevron-down"></i>' : ''); ?></div>
                                    <?php if (count($item->children) > 0) { ?>
                                        <ul>
                                            <?php foreach ($item->children as $child) { ?>
                                                <?php if (!is_array($child->params["access"]) || (is_array($child->params["access"]) && in_array(Core::user()->usergroup->id, $child->params["access"])) || (is_array($child->params["access"]) && in_array(0, $child->params["access"]))) { ?>
                                                    <li class="first-child<?php if (Core::menu_item_id() == $child->id) { echo ' active'; } ?><?php echo (count($child->children) > 0 ? ' parent' : ''); ?>">
                                                        <a<?php if ($child->controller != "separator") { ?> href="<?php if ($child->component == "system" && $child->controller == "external") { echo $child->params["external_link"]; } else { echo BASE_URL.$item->alias."/".$child->alias; } ?>"<?php } ?><?php if ($child->component == "system" && $child->controller == "external") { echo ' target="_blank"'; } ?>><?php echo $child->title; ?><?php echo (count($child->children) > 0 ? '&nbsp;&nbsp;&nbsp;<i class="fas fa-chevron-down"></i>' : ''); ?></a>
                                                        <div class="parent-toggler"><?php echo (count($child->children) > 0 ? '<i class="fas fa-chevron-down"></i>' : ''); ?></div>
                                                        <?php if (count($child->children) > 0) { ?>
                                                            <ul>
                                                                <?php foreach ($child->children as $grandchild) { ?>
                                                                    <?php if (!is_array($grandchild->params["access"]) || (is_array($grandchild->params["access"]) && in_array(Core::user()->usergroup->id, $grandchild->params["access"])) || (is_array($grandchild->params["access"]) && in_array(0, $grandchild->params["access"]))) { ?>
                                                                        <li class="second-child<?php if (Core::menu_item_id() == $grandchild->id) { echo ' active'; } ?>">
                                                                            <a<?php if ($grandchild->controller != "separator") { ?> href="<?php if ($grandchild->component == "system" && $grandchild->controller == "external") { echo $grandchild->params["external_link"]; } else { echo BASE_URL.$item->alias."/".$child->alias."/".$grandchild->alias; } ?>"<?php } ?><?php if ($grandchild->component == "system" && $grandchild->controller == "external") { echo ' target="_blank"'; } ?>><?php echo $grandchild->title; ?></a>
                                                                        </li>
                                                                    <?php } ?>
                                                                <?php } ?>
                                                            </ul>
                                                        <?php } ?>
                                                    </li>
                                                <?php } ?>
                                            <?php } ?>
                                        </ul>
                                    <?php } ?>
                                </li>
                            <?php } ?>
                        <?php } ?>
                    </ul>
                </div>
            </div>
            <div class="col-sm-2">
            </div>
        </div>
    </div>
<?php } ?>