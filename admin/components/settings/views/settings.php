<div class="card">
    <h2>Settings</h2>
    <form action="index.php?component=settings&controller=settings&task=save&extension=<?php echo $this->model->extension->internal_name; ?>" method="post" class="admin-form">
        <input type="hidden" name="extension" value="<?php echo $this->model->extension->internal_name; ?>" />
        <?php $this->model->form->display(true, true); ?>
    </form>
</div>