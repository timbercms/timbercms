<div class="white-card">
    <h2>User Manager</h2>
    <form action="index.php?component=user&controller=user&task=save" method="post" class="admin-form" enctype="multipart/form-data">
        <div class="component-action-bar">
            <a href="index.php?component=user&controller=users" class="button" style="float: left;"><i class="fa fa-chevron-left"></i> Back to List</a>
            <button type="submit" class="button green-button"><i class="fas fa-save"></i> Save</button>
            <button type="submit" class="button green-button save-and-new" data-action="index.php?component=user&controller=user&task=saveandnew"><i class="fas fa-save"></i> Save & New</button>
        </div>
        <?php $this->model->form->display(false); ?>
        <div class="form-group">
            <label><strong>Avatar:</strong></label>
            <?php if (strlen($this->model->avatar) > 0) { ?>
                <div class="settings-avatar">
                    <p><img src="../<?php echo $this->model->avatar; ?>" style="max-width: 100px;" /></p>
                </div>
            <?php } ?>
            <p>Max image filesize: <strong>1MB</strong></p>
            <input type="file" class="form-control" name="avatar" />
        </div>
        <?php $groups = $this->model->database->loadObjectList("SELECT id as value, title as name FROM #__usergroups ORDER BY id ASC"); ?>
        <?php $this->model->form->displaySelect($groups, "usergroup_id", $this->model->usergroup_id, false, "", "Usergroup", Core::config()->default_usergroup); ?>
    </form>
</div>