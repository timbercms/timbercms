<div class="white-card">
    <h2>Menuitem Manager</h2>
    <div class="component-action-bar">
        <a href="index.php?component=menu&controller=menuitems&id=<?php echo $_GET["menu_id"]; ?>" class="button"><i class="fa fa-chevron-left"></i> Back to List</a>
    </div>
    <form action="index.php?component=menu&controller=menuitem&task=save" method="post" class="admin-form">
        <h3 style="margin-bottom: 20px;">Change Menu Type</h3>
        <div class="row form-group">
            <label class="col-md-2 col-form-label">Current Type</label>
            <div class="col-md-10">
                <p>
                    <strong>Component:</strong> <?php echo $this->model->component; ?><br />
                    <strong>View:</strong> <?php echo $this->model->controller; ?>
                </p>
                <a href="index.php?component=menu&controller=newitem&menu_id=<?php echo $_GET["menu_id"]; ?>&id=<?php echo $this->model->id; ?>" class="button">Change</a>
            </div>
        </div>
        <h3 style="margin-top: 20px; margin-bottom: 20px;">Basic Information</h3>
        <?php $this->model->form->display(false); ?>
        <?php $this->model->form->displaySelect($this->model->getSiblings(), "parent_id", $this->model->parent_id, false, "", "Parent Item"); ?>
        <?php if (strlen($this->model->controller_query->attributes()->query) > 0) { ?>
            <h3 style="margin-top: 20px; margin-bottom: 20px;">Item Options</h3>
            <?php $this->model->form->displaySql($this->model->controller_query, "content_id", $this->model->content_id, $this->model->database, "Content"); ?>
        <?php } ?>
        <input type="hidden" name="component" value="<?php echo (strlen($this->model->component) > 0 && $_GET["overwrite"] != 1 ? $this->model->component : $_GET["comp"]); ?>" />
        <input type="hidden" name="controller" value="<?php echo (strlen($this->model->controller) > 0 && $_GET["overwrite"] != 1 ? $this->model->controller : $_GET["cont"]); ?>" />
        <input type="hidden" name="menu_id" value="<?php echo ($this->model->menu_id > 0 ? $this->model->menu_id : $_GET["menu_id"]); ?>" />
        <button type="submit" class="button float-right no-margin" style="margin-top: 20px;"><i class="fa fa-save"></i> Save</button>
        <div class="clearfix"></div>
    </form>
</div>