<div class="white-card">
    <h2>Redirect List</h2>
    <div class="component-action-bar">
        <?php if (count($this->model->settings->fields) > 0) { ?><a href="index.php?component=settings&controller=settings&extension=redirects" class="button"><i class="fas fa-cog"></i> Settings</a><?php } ?><a href="index.php?component=redirects&controller=redirect" class="button green-button"><i class="fa fa-plus"></i> New Redirect</a><a class="delete-by-ids button red-button"><i class="fas fa-trash"></i> Delete</a>
    </div>
    <?php $this->model->pagination->display($this->model->max); ?>
    <form action="index.php?component=redirects&controller=redirects&task=delete" method="post" class="admin-form">
        <div class="d-flex admin-header">
            <div class="col-md-1">&nbsp;</div>
            <div class="col-md-1 hidden-mobile"><strong>ID</strong></div>
            <div class="col-md-4"><strong>From URL</strong></div>
            <div class="col-md-4 hidden-mobile"><strong>To URL</strong></div>
            <div class="col-md-2 hidden-mobile"><strong>Published</strong></div>
        </div>
        <?php foreach ($this->model->redirects as $redirect) { ?>
            <div class="d-flex admin-list align-items-center">
                <div class="col-md-1" style="text-align: center;">
                    <input type="checkbox" name="ids[]" value="<?php echo $redirect->id; ?>" />
                </div>
                <div class="col-md-1 hidden-mobile">
                    <?php echo $redirect->id; ?>
                </div>
                <div class="col-md-4">
                    <a href="index.php?component=redirects&controller=redirect&id=<?php echo $redirect->id; ?>"><?php echo $redirect->from_url; ?></a>
                </div>
                <div class="col-md-4 hidden-mobile">
                    <?php echo $redirect->to_url; ?>
                </div>
                <div class="col-md-2 hidden-mobile">
                    <a href="index.php?component=redirects&controller=redirect&task=<?php echo ($redirect->published == 1 ? "unpublish" : "publish"); ?>&id=<?php echo $redirect->id; ?>" class="btn btn-<?php echo ($redirect->published == 1 ? "success" : "danger"); ?>">
                        <i class="fa fa-<?php echo ($redirect->published == 1 ? "check" : "times"); ?>"></i>
                    </a>
                </div>
            </div>
        <?php } ?>
    </form>
    <?php $this->model->pagination->display($this->model->max); ?>
</div>