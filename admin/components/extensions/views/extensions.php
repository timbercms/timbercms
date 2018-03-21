<div class="white-card">
    <h2>Extension Manager</h2>
    <div class="component-action-bar">
        <a href="index.php?component=settings&controller=settings&extension=extensions" class="button"><i class="fa fa-cog"></i> Settings</a>
    </div>
    <div class="d-flex admin-header">
        <div class="col-md-1"><strong>ID</strong></div>
        <div class="col-md-3"><strong>Title</strong></div>
        <div class="col-md-1" style="text-align: center;"><strong>Frontend?</strong></div>
        <div class="col-md-1" style="text-align: center;"><strong>Backend?</strong></div>
        <div class="col-md-1" style="text-align: center;"><strong>Enabled?</strong></div>
        <div class="col-md-3"><strong>Author</strong></div>
        <div class="col-md-2"><strong>Version</strong></div>
    </div>
    <?php foreach ($this->model->extensions as $extension) { ?>
        <div class="d-flex admin-list align-items-center">
            <div class="col-md-1">
                <?php echo $extension->id; ?>
            </div>
            <div class="col-md-3">
                <a href="index.php?component=extensions&controller=extension&id=<?php echo $extension->id; ?>"><?php echo $extension->title; ?></a>
            </div>
            <div class="col-md-1" style="text-align: center;">
                <i class="fa fa-<?php echo ($extension->is_frontend == 1 ? "check" : "times"); ?>"></i>
            </div>
            <div class="col-md-1" style="text-align: center;">
                <i class="fa fa-<?php echo ($extension->is_backend == 1 ? "check" : "times"); ?>"></i>
            </div>
            <?php if ($extension->is_locked == 1) { ?>
                <div class="col-md-1" style="text-align: center;">
                    <button class="btn btn-success btn-disabled"><i class="fa fa-lock"></i></button>
                </div>
            <?php } else { ?>
                <div class="col-md-1" style="text-align: center;">
                    <a href="index.php?component=extensions&controller=extension&task=<?php echo ($extension->enabled == 1 ? "unpublish" : "publish"); ?>&id=<?php echo $extension->id; ?>" class="btn btn-<?php echo ($extension->enabled == 1 ? "success" : "danger"); ?>">
                        <i class="fa fa-<?php echo ($extension->enabled == 1 ? "check" : "times"); ?>"></i>
                    </a>
                </div>
            <?php } ?>
            <div class="col-md-3">
                <a href="<?php echo $extension->author_url; ?>" target="_blank"><?php echo $extension->author_name; ?></a>
            </div>
            <div class="col-md-2">
                <?php echo $extension->version; ?>
            </div>
        </div>
    <?php } ?>
</div>