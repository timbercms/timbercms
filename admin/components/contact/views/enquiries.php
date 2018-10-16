<div class="white-card">
    <h2>Enquiry List</h2>
    <div class="component-action-bar">
        <?php if (count($this->model->settings->fields) > 0) { ?><a href="index.php?component=settings&controller=settings&extension=contact" class="button"><i class="fas fa-cog"></i> Settings</a><?php } ?><a class="delete-by-ids button red-button"><i class="fas fa-trash"></i> Delete</a>
    </div>
    <?php $this->model->pagination->display($this->model->max); ?>
    <form action="index.php?component=contact&controller=enquiries&task=delete" method="post" class="admin-form">
        <div class="d-flex admin-header">
            <div class="col-md-1">&nbsp;</div>
            <div class="col-md-1 hidden-mobile"><strong>ID</strong></div>
            <div class="col-md-4"><strong>Name</strong></div>
            <div class="col-md-4 hidden-mobile"><strong>Email</strong></div>
            <div class="col-md-2 hidden-mobile"><strong>Sent Time</strong></div>
        </div>
        <?php foreach ($this->model->enquiries as $enquiry) { ?>
            <div class="d-flex admin-list align-items-center">
                <div class="col-md-1" style="text-align: center;">
                    <input type="checkbox" name="ids[]" value="<?php echo $enquiry->id; ?>" />
                </div>
                <div class="col-md-1 hidden-mobile">
                    <?php echo $enquiry->id; ?>
                </div>
                <div class="col-md-4">
                    <a href="index.php?component=contact&controller=enquiry&id=<?php echo $enquiry->id; ?>"><?php echo $enquiry->name; ?></a>
                </div>
                <div class="col-md-4 hidden-mobile">
                    <?php echo $enquiry->email; ?>
                </div>
                <div class="col-md-2 hidden-mobile">
                    <?php echo date("jS M Y", $enquiry->sent_time); ?>
                </div>
            </div>
        <?php } ?>
    </form>
    <?php $this->model->pagination->display($this->model->max); ?>
</div>