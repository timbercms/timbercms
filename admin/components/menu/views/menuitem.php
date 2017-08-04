<div class="card">
    <h2>Menuitem Manager</h2>
    <div class="action-bar">
        <a href="index.php?component=menu&controller=menuitems&id=<?php echo $this->model->menu_id; ?>"><i class="fa fa-chevron-left"></i> Back to List</a>
    </div>
    <form action="index.php?component=menu&controller=menuitem&task=save" method="post">
        <?php $this->model->form->display(false); ?>
        <?php if (strlen($this->model->component) > 0) { ?>
            <?php $this->model->form->displaySelect($this->model->controllers, "controller", $this->model->controller); ?>
        <?php } ?>
        <?php if (strlen($this->model->controller) > 0) { ?>
            <?php $this->model->form->displaySql($this->model->controller_query, "content_id", $this->model->content_id, $this->model->database); ?>
        <?php } ?>
        <input type="hidden" name="menu_id" value="<?php echo ($this->model->menu_id > 0 ? $this->model->menu_id : $_GET["menu_id"]); ?>" />
        <button type="submit" class="button float-right no-margin"><i class="fa fa-save"></i> Save</button>
        <div class="clearfix"></div>
    </form>
</div>