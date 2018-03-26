<div class="white-card">
    <h2>Settings</h2>
    <div class="component-action-bar">
    </div>
    <?php if ($this->model->form->xml->fields) { ?>
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