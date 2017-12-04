<div class="action-bar">
</div>
<div class="white-card">
    <h2>Settings</h2>
    <?php if (is_array($this->model->form->raw_data)) { ?>
        <form action="index.php?component=settings&controller=settings&task=save&extension=<?php echo $this->model->extension->internal_name; ?>" method="post" class="admin-form">
            <input type="hidden" name="extension" value="<?php echo $this->model->extension->internal_name; ?>" />
            <?php $this->model->form->display(true, true); ?>
        </form>
    <?php } else { ?>
        <div class="alert alert-info" style="margin-top: 40px;">
            This Extension has no settings available for editing.
        </div>
    <?php } ?>
</div>