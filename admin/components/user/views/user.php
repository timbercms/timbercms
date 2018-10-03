<div class="white-card">
    <h2>User Manager</h2>
    <form action="index.php?component=user&controller=user&task=save" method="post" class="admin-form">
        <div class="component-action-bar">
            <a href="index.php?component=user&controller=users" class="button" style="float: left;"><i class="fa fa-chevron-left"></i> Back to List</a>
            <button type="submit" class="button green-button"><i class="fas fa-save"></i> Save</button>
            <button type="submit" class="button green-button save-and-new" data-action="index.php?component=user&controller=user&task=saveandnew"><i class="fas fa-save"></i> Save & New</button>
        </div>
        <?php $this->model->form->display(false); ?>
        <?php $groups = $this->model->database->loadObjectList("SELECT id as value, title as name FROM #__usergroups ORDER BY id ASC"); ?>
        <?php $this->model->form->displaySelect($groups, "usergroup_id", $this->model->usergroup_id, false, "", "Usergroup", Core::config()->default_usergroup); ?>
    </form>
</div>