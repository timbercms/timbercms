<div class="white-card">
    <h2>Category Manager</h2>
    <div class="component-action-bar">
        <?php if (count($this->model->settings->fields) > 0) { ?><a href="index.php?component=settings&controller=settings&extension=content" class="button"><i class="fa fa-cog"></i> Settings</a><?php } ?><a href="index.php?component=content&controller=category" class="button green-button"><i class="fa fa-plus"></i> New Category</a><a class="delete-by-ids button red-button"><i class="fa fa-trash"></i> Delete</a>
    </div>
    <div class="component-filters">
        <form action="index.php?component=content&controller=categories" method="get">
            <input type="hidden" name="component" value="content" />
            <input type="hidden" name="controller" value="categories" />
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
    <form action="index.php?component=content&controller=categories&task=delete" method="post" class="admin-form">
        <div class="d-flex admin-header">
            <div class="col-md-1">&nbsp;</div>
            <div class="col-md-1"><strong>ID</strong></div>
            <div class="col-md-9"><strong>Title</strong></div>
            <div class="col-md-1" style="text-align: center;"><strong>Published</strong></div>
        </div>
        <?php foreach ($this->model->categories as $category) { ?>
            <div class="d-flex align-items-center admin-list">
                <div class="col-md-1" style="text-align: center;">
                    <input type="checkbox" name="ids[]" value="<?php echo $category->id; ?>" />
                </div>
                <div class="col-md-1">
                    <?php echo $category->id; ?>
                </div>
                <div class="col-md-9">
                    <a href="index.php?component=content&controller=category&id=<?php echo $category->id; ?>"><?php echo $category->title; ?></a>
                </div>
                <div class="col-md-1" style="text-align: center;">
                    <a href="index.php?component=content&controller=category&task=<?php echo ($category->published == 1 ? "unpublish" : "publish"); ?>&id=<?php echo $category->id; ?>" class="btn btn-<?php echo ($category->published == 1 ? "success" : "danger"); ?>">
                        <i class="fa fa-<?php echo ($category->published == 1 ? "check" : "times"); ?>"></i>
                    </a>
                </div>
            </div>
            <?php if (count($category->children) > 0) { ?>
                <?php foreach ($category->children as $child) { ?>
                    <div class="d-flex align-items-center admin-list">
                        <div class="col-md-1" style="text-align: center;">
                            <input type="checkbox" name="ids[]" value="<?php echo $child->id; ?>" />
                        </div>
                        <div class="col-md-1">
                            <?php echo $child->id; ?>
                        </div>
                        <div class="col-md-9">
                            <a href="index.php?component=content&controller=category&id=<?php echo $child->id; ?>" style="display: inline-block; padding-left: 20px;"><i class="fas fa-angle-right"></i> <?php echo $child->title; ?></a>
                        </div>
                        <div class="col-md-1" style="text-align: center;">
                            <a href="index.php?component=content&controller=category&task=<?php echo ($child->published == 1 ? "unpublish" : "publish"); ?>&id=<?php echo $child->id; ?>" class="btn btn-<?php echo ($child->published == 1 ? "success" : "danger"); ?>">
                                <i class="fa fa-<?php echo ($child->published == 1 ? "check" : "times"); ?>"></i>
                            </a>
                        </div>
                    </div>
                    <?php foreach ($child->children as $grandchild) { ?>
                        <div class="d-flex align-items-center admin-list">
                            <div class="col-md-1" style="text-align: center;">
                                <input type="checkbox" name="ids[]" value="<?php echo $grandchild->id; ?>" />
                            </div>
                            <div class="col-md-1">
                                <?php echo $grandchild->id; ?>
                            </div>
                            <div class="col-md-9">
                                <a href="index.php?component=content&controller=category&id=<?php echo $grandchild->id; ?>" style="display: inline-block; padding-left: 40px;"><i class="fas fa-angle-double-right"></i> <?php echo $grandchild->title; ?></a>
                            </div>
                            <div class="col-md-1" style="text-align: center;">
                                <a href="index.php?component=content&controller=category&task=<?php echo ($grandchild->published == 1 ? "unpublish" : "publish"); ?>&id=<?php echo $grandchild->id; ?>" class="btn btn-<?php echo ($grandchild->published == 1 ? "success" : "danger"); ?>">
                                    <i class="fa fa-<?php echo ($grandchild->published == 1 ? "check" : "times"); ?>"></i>
                                </a>
                            </div>
                        </div>
                    <?php } ?>
                <?php } ?>
            <?php } ?>
        <?php } ?>
    </form>
</div>