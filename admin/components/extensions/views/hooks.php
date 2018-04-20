<div class="white-card">
    <h2>Hook Manager</h2>
    <div class="component-action-bar">
        <?php if (count($this->model->settings->fields) > 0) { ?><a href="index.php?component=settings&controller=settings&extension=extensions" class="button"><i class="fa fa-cog"></i> Settings</a><?php } ?>
    </div>
    <div class="d-flex admin-header">
        <div class="col-md-1"><strong>ID</strong></div>
        <div class="col-md-5"><strong>Title</strong></div>
        <div class="col-md-1" style="text-align: center;"><strong>Enabled?</strong></div>
        <div class="col-md-3"><strong>Author</strong></div>
        <div class="col-md-2"><strong>Version</strong></div>
    </div>
    <?php foreach ($this->model->hooks as $hook) { ?>
        <div class="d-flex admin-list align-items-center">
            <div class="col-md-1">
                <?php echo $hook->id; ?>
            </div>
            <div class="col-md-5">
                <a href="index.php?component=extensions&controller=hook&id=<?php echo $hook->id; ?>"><?php echo $hook->title; ?></a>
            </div>
            <div class="col-md-1" style="text-align: center;">
                <a href="index.php?component=extensions&controller=hook&task=<?php echo ($hook->enabled == 1 ? "unpublish" : "publish"); ?>&id=<?php echo $hook->id; ?>&return=1" class="btn btn-<?php echo ($hook->enabled == 1 ? "success" : "danger"); ?>">
                    <i class="fa fa-<?php echo ($hook->enabled == 1 ? "check" : "times"); ?>"></i>
                </a>
            </div>
            <div class="col-md-3">
                <a href="<?php echo $hook->author_url; ?>" target="_blank"><?php echo $hook->author_name; ?></a>
            </div>
            <div class="col-md-2">
                <?php echo $hook->version; ?>
            </div>
        </div>
    <?php } ?>
</div>