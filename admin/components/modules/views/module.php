<div class="white-card">
    <h2>Module Manager</h2>
    <div class="component-action-bar">
        <a href="index.php?component=modules&controller=modules" class="button"><i class="fa fa-chevron-left"></i> Back to List</a>
    </div>
    <form action="index.php?component=modules&controller=module&task=save" method="post">
        <?php $this->model->form->display(false); ?>
        <?php $this->model->params_form->display(false, true); ?>
        <input type="hidden" name="type" value="<?php echo (strlen($this->model->type) > 0 ? $this->model->type : $_GET["type"]); ?>" />
        <button type="submit" class="button float-right no-margin"><i class="fa fa-save"></i> Save</button>
        <div class="clearfix"></div>
    </form>
</div>