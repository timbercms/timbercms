<div class="white-card">
    <h2>Enquiry Viewer</h2>
    <div class="component-action-bar">
        <a href="index.php?component=contact&controller=enquiries" class="button"><i class="fa fa-chevron-left"></i> Back to List</a>
    </div>
    <form action="index.php?component=content&controller=article&task=save" method="post" enctype="multipart/form-data">
        <div class="form-group row">
            <div class="col-md-2">
                <strong>ID:</strong>
            </div>
            <div class="col-md-10">
                <?php echo $this->model->id; ?>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-2">
                <strong>Name:</strong>
            </div>
            <div class="col-md-10">
                <?php echo $this->model->name; ?>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-2">
                <strong>Email:</strong>
            </div>
            <div class="col-md-10">
                <?php echo $this->model->email; ?>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-2">
                <strong>Content:</strong>
            </div>
            <div class="col-md-10">
                <?php echo $this->model->content; ?>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-2">
                <strong>Sent at:</strong>
            </div>
            <div class="col-md-10">
                <?php echo date("jS M Y", $this->model->sent_time); ?>
            </div>
        </div>
    </form>
</div>