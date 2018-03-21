<div class="white-card">
    <h2>Module Manager</h2>
    <div class="component-action-bar">
        <a href="index.php?component=settings&controller=settings&extension=modules" class="button"><i class="fa fa-cog"></i> Settings</a><a href="index.php?component=modules&controller=newmodule" class="button green-button"><i class="fa fa-plus"></i> New Module</a><a class="delete-by-ids button red-button"><i class="fa fa-trash"></i> Delete</a>
    </div>
    <div class="module-ordering">
        <form action="index.php" method="get">
            <input type="hidden" name="component" value="modules" />
            <input type="hidden" name="controller" value="modules" />
            <div class="row">
                <div class="col-md-4">
                    <select name="position" class="form-control">
                        <option value="">-- SELECT MODULE POSITION --</option>
                        <?php foreach ($this->model->positions as $position) { ?>
                            <option value="<?php echo $position; ?>"<?php echo ($_GET["position"] == $position ? ' selected="selected"' : ''); ?>><?php echo $position; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-md-8">
                    <button type="submit" class="btn btn-primary">Filter</button>
                </div>
            </div>
        </form>
    </div>
    <form action="index.php?component=modules&controller=modules&task=delete" method="post" class="admin-form">
        <div class="d-flex admin-header">
            <div class="col-md-1">&nbsp;</div>
            <div class="col-md-1"><strong>ID</strong></div>
            <div class="col-md-4"><strong>Title</strong></div>
            <div class="col-md-2"><strong>Type</strong></div>
            <div class="col-md-1"><strong>Position</strong></div>
            <div class="col-md-1" style="text-align: center;"><strong>Published</strong></div>
            <div class="col-md-2"><strong>Ordering</strong></div>
        </div>
        <?php $count = count($this->model->modules) - 1; ?>
        <?php foreach ($this->model->modules as $module) { ?>
            <div class="d-flex align-items-center admin-list">
                <div class="col-md-1" style="text-align: center;">
                    <input type="checkbox" name="ids[]" value="<?php echo $module->id; ?>" />
                </div>
                <div class="col-md-1">
                    <?php echo $module->id; ?>
                </div>
                <div class="col-md-4">
                    <a href="index.php?component=modules&controller=module&id=<?php echo $module->id; ?>"><?php echo $module->title; ?></a>
                </div>
                <div class="col-md-2">
                    <?php echo $module->type; ?>
                </div>
                <div class="col-md-1">
                    <?php echo $module->position; ?>
                </div>
                <div class="col-md-1" style="text-align: center;">
                    <a href="index.php?component=modules&controller=module&task=<?php echo ($module->published == 1 ? "unpublish" : "publish"); ?>&id=<?php echo $module->id; ?>" class="btn btn-<?php echo ($module->published == 1 ? "success" : "danger"); ?>">
                        <i class="fa fa-<?php echo ($module->published == 1 ? "check" : "times"); ?>"></i>
                    </a>
                </div>
                <div class="col-md-2">
                    <?php if (strlen($_GET["position"]) > 0) { ?>
                        <div class="btn-group">
                            <a id="order-up order-up-<?php echo $module->id; ?>" class="btn btn-secondary<?php if ($module->ordering == 0) { echo ' disabled'; } ?>" href="index.php?component=modules&controller=modules&task=order&swap=<?php echo $module->ordering; ?>&with=<?php echo ($module->ordering - 1); ?>&position=<?php echo $module->position; ?>"><i class="fa fa-arrow-up"></i></a>
                            <a id="order-down order-down-<?php echo $module->id; ?>" class="btn btn-secondary<?php if ($module->ordering == $count) { echo ' disabled'; } ?>" href="index.php?component=modules&controller=modules&task=order&swap=<?php echo $module->ordering; ?>&with=<?php echo ($module->ordering + 1); ?>&position=<?php echo $module->position; ?>"><i class="fa fa-arrow-down"></i></a>
                        </div>
                    <?php } else { ?>
                        Filter by position to order
                    <?php } ?>
                </div>
            </div>
        <?php } ?>
    </form>
</div>