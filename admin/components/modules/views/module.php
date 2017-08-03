<div class="card">
    <h2>Module Manager</h2>
    <div class="action-bar">
        <a href="index.php?component=modules&controller=modules"><i class="fa fa-chevron-left"></i> Back to List</a>
    </div>
    <form action="index.php?component=modules&controller=module&task=save" method="post">
        <?php $this->model->form->display(false); ?>
        <?php if (strlen($this->model->type) > 0) {
            $this->model->params_form->display(false, true);
        } ?>
        <button type="submit" class="button float-right no-margin"><i class="fa fa-save"></i> Save</button>
        <div class="clearfix"></div>
    </form>
</div>