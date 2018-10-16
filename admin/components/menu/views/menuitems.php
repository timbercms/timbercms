<div class="white-card">
    <h2>Menuitem Manager</h2>
    <div class="component-action-bar">
        <?php if (count($this->model->settings->fields) > 0) { ?><a href="index.php?component=settings&controller=settings&extension=menu" class="button"><i class="fa fa-cog"></i> Settings</a><?php } ?>
        <a href="index.php?component=menu&controller=newitem&menu_id=<?php echo $_GET["id"]; ?>" class="button green-button"><i class="fa fa-plus"></i> New Menu Item</a><a class="delete-by-ids button red-button"><i class="fa fa-trash"></i> Delete</a>
    </div>
    <div class="component-filters">
        <form action="index.php?component=menu&controller=menuitems" method="get">
            <input type="hidden" name="component" value="menu" />
            <input type="hidden" name="controller" value="menuitems" />
            <input type="hidden" name="id" value="<?php echo $_GET["id"]; ?>" />
            <div class="row">
                <div class="col-md-3">
                    <input type="text" name="title" placeholder="Filter by title" class="form-control" value="<?php echo $_GET["title"]; ?>" />
                </div>
                <div class="col-md-1">
                    <button type="submit" class="button">Filter</button>
                </div>
            </div>
        </form>
    </div>
    <?php $this->model->pagination->display($this->model->max); ?>
    <form action="index.php?component=menu&controller=menuitems&task=delete&id=<?php echo $_GET["id"]; ?>" method="post" class="admin-form">
        <div class="d-flex admin-header">
            <div class="col-md-1">&nbsp;</div>
            <div class="col-md-1 hidden-mobile"><strong>ID</strong></div>
            <div class="col-md-3"><strong>Title</strong></div>
            <div class="col-md-2 hidden-mobile"><strong>Type</strong></div>
            <div class="col-md-1" style="text-align: center;"><strong>Published</strong></div>
            <div class="col-md-2 hidden-mobile"><strong>Ordering</strong></div>
            <div class="col-md-2 hidden-mobile"><strong>&nbsp;</strong></div>
        </div>
        <?php foreach ($this->model->items as $item) { ?>
            <div class="d-flex admin-list align-items-center">
                <div class="col-md-1" style="text-align: center;">
                    <input type="checkbox" name="ids[]" value="<?php echo $item->id; ?>" />
                </div>
                <div class="col-md-1 hidden-mobile">
                    <?php echo $item->id; ?>
                </div>
                <div class="col-md-3">
                    <a href="index.php?component=menu&controller=menuitem&id=<?php echo $item->id; ?>&menu_id=<?php echo $item->menu_id; ?>"><?php echo $item->title; ?></a>
                </div>
                <div class="col-md-2 hidden-mobile">
                    <?php echo $item->component; ?> - <?php echo $item->controller; ?>
                </div>
                <div class="col-md-1" style="text-align: center;">
                    <a href="index.php?component=menu&controller=menuitem&task=<?php echo ($item->published == 1 ? "unpublish" : "publish"); ?>&id=<?php echo $item->id; ?>&menu_id=<?php echo $item->menu_id; ?>" class="btn btn-<?php echo ($item->published == 1 ? "success" : "danger"); ?>">
                        <i class="fa fa-<?php echo ($item->published == 1 ? "check" : "times"); ?>"></i>
                    </a>
                </div>
                <div class="col-md-2 hidden-mobile">
                    <?php if (strlen($_GET["title"]) == 0) { ?>
                        <div class="btn-group">
                            <a id="order-up order-up-<?php echo $item->id; ?>" class="btn btn-primary<?php if ($item->ordering == 0) { echo ' disabled'; } ?>" href="index.php?component=menu&controller=menuitems&task=order&swap=<?php echo $item->ordering; ?>&with=<?php echo ($item->ordering - 1); ?>&menu_id=<?php echo $item->menu_id; ?>&parent_id=0"><i class="fa fa-arrow-up"></i></a>
                            <a id="order-down order-down-<?php echo $item->id; ?>" class="btn btn-primary<?php if ($item->ordering == (count($this->model->items) - 1)) { echo ' disabled'; } ?>" href="index.php?component=menu&controller=menuitems&task=order&swap=<?php echo $item->ordering; ?>&with=<?php echo ($item->ordering + 1); ?>&menu_id=<?php echo $item->menu_id; ?>&parent_id=0"><i class="fa fa-arrow-down"></i></a>
                        </div>
                    <?php } else { ?>
                        Remove filters to order
                    <?php } ?>
                </div>
                <div class="col-md-2 hidden-mobile" style="text-align: right;">
                    <a href="index.php?component=menu&controller=menuitem&id=<?php echo $item->id; ?>&menu_id=<?php echo $item->menu_id; ?>" class="button"><i class="fa fa-edit"></i> Edit Item</a>
                </div>
            </div>
            <?php foreach ($item->children as $child) { ?>
                <div class="d-flex admin-list align-items-center">
                    <div class="col-md-1" style="text-align: center;">
                        <input type="checkbox" name="ids[]" value="<?php echo $child->id; ?>" />
                    </div>
                    <div class="col-md-1 hidden-mobile">
                        <?php echo $child->id; ?>
                    </div>
                    <div class="col-md-3">
                        <a href="index.php?component=menu&controller=menuitem&id=<?php echo $child->id; ?>&menu_id=<?php echo $child->menu_id; ?>">---- <?php echo $child->title; ?></a>
                    </div>
                    <div class="col-md-2 hidden-mobile">
                        <?php echo $child->component; ?> - <?php echo $child->controller; ?>
                    </div>
                    <div class="col-md-1" style="text-align: center;">
                        <a href="index.php?component=menu&controller=menuitem&task=<?php echo ($child->published == 1 ? "unpublish" : "publish"); ?>&id=<?php echo $child->id; ?>&menu_id=<?php echo $child->menu_id; ?>" class="btn btn-<?php echo ($child->published == 1 ? "success" : "danger"); ?>">
                            <i class="fa fa-<?php echo ($child->published == 1 ? "check" : "times"); ?>"></i>
                        </a>
                    </div>
                    <div class="col-md-2 hidden-mobile" style="text-align: center;">
                        <div class="btn-group">
                            <a id="order-up order-up-<?php echo $child->id; ?>" class="btn btn-warning<?php if ($child->ordering == 0) { echo ' disabled'; } ?>" href="index.php?component=menu&controller=menuitems&task=order&swap=<?php echo $child->ordering; ?>&with=<?php echo ($child->ordering - 1); ?>&menu_id=<?php echo $child->menu_id; ?>&parent_id=<?php echo $item->id; ?>"><i class="fa fa-arrow-up"></i></a>
                            <a id="order-down order-down-<?php echo $child->id; ?>" class="btn btn-warning<?php if ($child->ordering == (count($item->children) - 1)) { echo ' disabled'; } ?>" href="index.php?component=menu&controller=menuitems&task=order&swap=<?php echo $child->ordering; ?>&with=<?php echo ($child->ordering + 1); ?>&menu_id=<?php echo $child->menu_id; ?>&parent_id=<?php echo $item->id; ?>"><i class="fa fa-arrow-down"></i></a>
                        </div>
                    </div>
                    <div class="col-md-2 hidden-mobile" style="text-align: right;">
                        <a href="index.php?component=menu&controller=menuitem&id=<?php echo $child->id; ?>&menu_id=<?php echo $child->menu_id; ?>" class="button"><i class="fa fa-edit"></i> Edit Item</a>
                    </div>
                </div>
                <?php foreach ($child->children as $grandchild) { ?>
                    <div class="d-flex admin-list align-items-center">
                        <div class="col-md-1" style="text-align: center;">
                            <input type="checkbox" name="ids[]" value="<?php echo $grandchild->id; ?>" />
                        </div>
                        <div class="col-md-1 hidden-mobile">
                            <?php echo $grandchild->id; ?>
                        </div>
                        <div class="col-md-3">
                            <a href="index.php?component=menu&controller=menuitem&id=<?php echo $grandchild->id; ?>&menu_id=<?php echo $grandchild->menu_id; ?>">-------- <?php echo $grandchild->title; ?></a>
                        </div>
                        <div class="col-md-2 hidden-mobile">
                            <?php echo $grandchild->component; ?> - <?php echo $grandchild->controller; ?>
                        </div>
                        <div class="col-md-1" style="text-align: center;">
                            <a href="index.php?component=menu&controller=menuitem&task=<?php echo ($grandchild->published == 1 ? "unpublish" : "publish"); ?>&id=<?php echo $grandchild->id; ?>&menu_id=<?php echo $grandchild->menu_id; ?>" class="btn btn-<?php echo ($grandchild->published == 1 ? "success" : "danger"); ?>">
                                <i class="fa fa-<?php echo ($grandchild->published == 1 ? "check" : "times"); ?>"></i>
                            </a>
                        </div>
                        <div class="col-md-2 hidden-mobile" style="text-align: right;">
                            <div class="btn-group">
                                <a id="order-up order-up-<?php echo $grandchild->id; ?>" class="btn btn-secondary<?php if ($grandchild->ordering == 0) { echo ' disabled'; } ?>" href="index.php?component=menu&controller=menuitems&task=order&swap=<?php echo $grandchild->ordering; ?>&with=<?php echo ($grandchild->ordering - 1); ?>&menu_id=<?php echo $grandchild->menu_id; ?>&parent_id=<?php echo $child->id; ?>"><i class="fa fa-arrow-up"></i></a>
                                <a id="order-down order-down-<?php echo $grandchild->id; ?>" class="btn btn-secondary<?php if ($grandchild->ordering == (count($child->children) - 1)) { echo ' disabled'; } ?>" href="index.php?component=menu&controller=menuitems&task=order&swap=<?php echo $grandchild->ordering; ?>&with=<?php echo ($grandchild->ordering + 1); ?>&menu_id=<?php echo $grandchild->menu_id; ?>&parent_id=<?php echo $child->id; ?>"><i class="fa fa-arrow-down"></i></a>
                            </div>
                        </div>
                        <div class="col-md-2 hidden-mobile" style="text-align: right;">
                            <a href="index.php?component=menu&controller=menuitem&id=<?php echo $grandchild->id; ?>&menu_id=<?php echo $grandchild->menu_id; ?>" class="button"><i class="fa fa-edit"></i> Edit Item</a>
                        </div>
                    </div>
                <?php } ?>
            <?php } ?>
        <?php } ?>
    </form>
    <?php $this->model->pagination->display($this->model->max); ?>
</div>