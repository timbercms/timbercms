<div class="white-card">
    <h2>Menuitem Manager</h2>
    <form action="index.php?component=menu&controller=menuitem&task=save" method="post" class="admin-form">
        <div class="component-action-bar">
            <a href="index.php?component=menu&controller=menuitems&id=<?php echo $_GET["menu_id"]; ?>" class="button" style="float: left;"><i class="fa fa-chevron-left"></i> Back to List</a>
            <button type="submit" class="button green-button"><i class="fas fa-save"></i> Save</button>
            <button type="submit" class="button green-button save-and-new" data-action="index.php?component=menu&controller=menuitem&task=saveandnew&menu_id=<?php echo $_GET["menu_id"]; ?>"><i class="fas fa-save"></i> Save & New</button>
        </div>
        <h3 style="margin-bottom: 20px;">Change Menu Type</h3>
        <p><strong>Component:</strong> <span style="text-transform: capitalize;"><?php echo $this->model->component; ?></span></p>
        <p><strong>View:</strong> <?php echo ($this->model->controller_query ?  $this->model->controller_query->attributes()->label : ucwords($this->model->controller)); ?></p>
        <?php if ($this->model->controller_query) { ?>
            <p><strong>Overview:</strong> <?php echo $this->model->controller_query->attributes()->description; ?></p>
        <?php } ?>
        <p><a href="index.php?component=menu&controller=newitem&menu_id=<?php echo $_GET["menu_id"]; ?>&id=<?php echo $this->model->id; ?>" class="button">Change</a></p>
        <h3 style="margin-top: 20px; margin-bottom: 20px;">Basic Information</h3>
        <?php $this->model->form->display(false); ?>
        <div class="form-group">
            <label class="col-form-label">Parent Item</label>
            <select name="parent_id" class="form-control">
                <option value="0">-- PLEASE SELECT --</option>
                <?php foreach ($this->model->getSiblings() as $item) { ?>
                    <option value="<?php echo $item->id; ?>"<?php echo ($item->id == $this->model->parent_id ? ' selected="selected"' : ''); ?>><?php echo $item->title; ?></option>
                    <?php foreach ($item->children as $child) { ?>
                        <option value="<?php echo $child->id; ?>"<?php echo ($child->id == $this->model->parent_id ? ' selected="selected"' : ''); ?>>-- <?php echo $child->title; ?></option>
                        <?php foreach ($child->children as $grandchild) { ?>
                            <option value="<?php echo $grandchild->id; ?>"<?php echo ($grandchild->id == $this->model->parent_id ? ' selected="selected"' : ''); ?>>---- <?php echo $grandchild->title; ?></option>
                        <?php } ?>
                    <?php } ?>
                <?php } ?>
            </select>
        </div>
        <?php if ($this->model->component == "system" && ($this->model->controller == "alias" || $this->model->controller == "external")) { ?>
            <?php if ($this->model->controller == "alias") { ?>
                <div class="form-group">
                    <label class="col-form-label">Menu Item Alias</label>
                    <select name="params[alias]" class="form-control">
                        <?php $menus = $this->model->database->loadObjectList("SELECT id, title FROM #__menus ORDER BY title"); ?>
                        <?php foreach ($menus as $menu) { ?>
                            <optgroup label="<?php echo $menu->title; ?>">
                                <?php $items = $this->model->database->loadObjectList("SELECT id, title FROM #__menus_items WHERE menu_id = ? AND parent_id = 0 ORDER BY title", array($menu->id)); ?>
                                <?php foreach ($items as $item) { ?>
                                    <option value="<?php echo $item->id; ?>"<?php if ($this->model->params["alias"] == $item->id) { ?> selected="selected"<?php } ?>>-- <?php echo $item->title; ?></option>
                                    <?php $children = $this->model->database->loadObjectList("SELECT id, title FROM #__menus_items WHERE menu_id = ? AND parent_id = ? ORDER BY title", array($menu->id, $item->id)); ?>
                                    <?php foreach ($children as $child) { ?>
                                        <option value="<?php echo $child->id; ?>"<?php if ($this->model->params["alias"] == $child->id) { ?> selected="selected"<?php } ?>>---- <?php echo $child->title; ?></option>
                                        <?php $grandchildren = $this->model->database->loadObjectList("SELECT id, title FROM #__menus_items WHERE menu_id = ? AND parent_id = ? ORDER BY title", array($menu->id, $child->id)); ?>
                                        <?php foreach ($grandchildren as $grandchild) { ?>
                                            <option value="<?php echo $grandchild->id; ?>"<?php if ($this->model->params["alias"] == $grandchild->id) { ?> selected="selected"<?php } ?>>------ <?php echo $grandchild->title; ?></option>
                                        <?php } ?>
                                    <?php } ?>
                                <?php } ?>
                            </optgroup>
                        <?php } ?>
                    </select>
                </div>
            <?php } else if ($this->model->controller == "external") { ?>
                <div class="form-group">
                    <label class="col-form-label">External Link</label>
                    <input type="text" name="params[external_link]" class="form-control" value="<?php echo $this->model->params["external_link"]; ?>">
                </div>
            <?php } ?>
        <?php } ?>
        <div class="form-group">
            <label class="col-form-label">Access Control</label>
            <select name="params[access][]" multiple class="form-control">
                <option value="0"<?php echo (!is_array($this->model->params["access"]) || (is_array($this->model->params["access"]) && in_array(0, $this->model->params["access"])) ? 'selected="selected"' : ''); ?>>Public</option>
                <?php foreach ($this->model->getUsergroups() as $usergroup) { ?>
                    <option value="<?php echo $usergroup->id; ?>"<?php echo (is_array($this->model->params["access"]) && in_array($usergroup->id, $this->model->params["access"]) ? ' selected="selected"' : ''); ?>><?php echo $usergroup->title; ?></option>
                <?php } ?>
            </select>
        </div>
        <?php if ($this->model->controller_query) { ?>
            <?php if (strlen($this->model->controller_query->attributes()->query) > 0) { ?>
                <h3 style="margin-top: 20px; margin-bottom: 20px;">Item Options</h3>
                <?php $this->model->form->displaySql($this->model->controller_query, "content_id", $this->model->content_id, $this->model->database, "Content"); ?>
            <?php } ?>
        <?php } ?>
        <input type="hidden" name="component" value="<?php echo (strlen($this->model->component) > 0 && $_GET["overwrite"] != 1 ? $this->model->component : $_GET["comp"]); ?>" />
        <input type="hidden" name="controller" value="<?php echo (strlen($this->model->controller) > 0 && $_GET["overwrite"] != 1 ? $this->model->controller : $_GET["cont"]); ?>" />
        <input type="hidden" name="menu_id" value="<?php echo ($this->model->menu_id > 0 ? $this->model->menu_id : $_GET["menu_id"]); ?>" />
        <button type="submit" class="btn btn-success float-right no-margin" style="margin-top: 20px;"><i class="fa fa-save"></i> Save</button>
        <div class="clearfix"></div>
    </form>
</div>