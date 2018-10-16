<div class="white-card">
    <h2>Module Manager</h2>
    <form action="index.php?component=modules&controller=module&task=save" method="post" class="admin-form">
        <div class="component-action-bar">
            <a href="index.php?component=modules&controller=modules" class="button" style="float: left;"><i class="fa fa-chevron-left"></i> Back to List</a>
            <button type="submit" class="button green-button"><i class="fas fa-save"></i> Save</button>
            <button type="submit" class="button green-button save-and-new" data-action="index.php?component=modules&controller=module&task=saveandnew"><i class="fas fa-save"></i> Save & New</button>
        </div>
        <?php $this->model->form->display(false); ?>
        <?php $this->model->params_form->display(false, true); ?>
        <input type="hidden" name="type" value="<?php echo (strlen($this->model->type) > 0 ? $this->model->type : $_GET["type"]); ?>" />
    </form>
</div>