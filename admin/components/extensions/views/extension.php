<div class="white-card">
    <h2><?php echo $this->model->title; ?> Extension</h2>
    <div class="component-action-bar">
        <?php if (!$this->model->is_locked) { ?>
            <a href="index.php?component=extensions&controller=extension&task=<?php echo ($this->model->enabled == 1 ? "unpublish" : "publish"); ?>&id=<?php echo $this->model->id; ?>" class="btn btn-<?php echo ($this->model->enabled == 0 ? "success" : "danger"); ?>">
                <i class="fa fa-<?php echo ($this->model->enabled == 0 ? "eye" : "eye-slash"); ?>"></i> <?php echo ($this->model->enabled == 0 ? "Enable" : "Disable"); ?>
            </a>
        <?php } ?>
        <a href="index.php?component=extensions&controller=extensions" class="button"><i class="fa fa-chevron-left"></i> Back to List</a>
    </div>
    <?php if ($this->model->is_locked) { ?>
        <div class="alert alert-warning">
            <i class="fa fa-lock"></i> This is a <span style="font-weight: bold;">system extension</span> and cannot be disabled.
        </div>
    <?php } ?>
    <p><?php echo $this->model->description; ?></p>
    <p>&nbsp;</p>
    <p style="font-style: italic;">Maintained by <?php echo $this->model->author_name; ?> (<a href="<?php echo $this->model->author_url; ?>" target="_blank"><?php echo $this->model->author_url; ?></a>)</p>
</div>