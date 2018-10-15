<div class="white-card">
    <h2>Log List</h2>
    <div class="component-action-bar">
        <?php if (count($this->model->settings->fields) > 0) { ?><a href="index.php?component=settings&controller=settings&extension=contact" class="button"><i class="fas fa-cog"></i> Settings</a><?php } ?>
    </div>
    <?php $this->model->pagination->display($this->model->max); ?>
    <div class="d-flex admin-header">
        <div class="col-md-1 hidden-mobile"><strong>ID</strong></div>
        <div class="col-md-5"><strong>Details</strong></div>
        <div class="col-md-4 hidden-mobile"><strong>Event Author</strong></div>
        <div class="col-md-2 hidden-mobile"><strong>Event Time</strong></div>
    </div>
    <?php foreach ($this->model->logs as $log) { ?>
        <div class="d-flex admin-list align-items-center">
            <div class="col-md-1 hidden-mobile">
                <?php echo $log->id; ?>
            </div>
            <div class="col-md-5">
                <?php echo $log->label; ?>
            </div>
            <div class="col-md-4 hidden-mobile">
                <?php echo $log->author->username; ?>
            </div>
            <div class="col-md-2 hidden-mobile">
                <?php echo date("jS M Y - H:i:s", $log->event_time); ?>
            </div>
        </div>
    <?php } ?>
    <?php $this->model->pagination->display($this->model->max); ?>
</div>