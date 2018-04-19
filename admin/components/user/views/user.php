<div class="white-card">
    <h2>User Manager</h2>
    <div class="component-action-bar">
        <a href="index.php?component=user&controller=users" class="button"><i class="fa fa-chevron-left"></i> Back to List</a>
    </div>
    <form action="index.php?component=user&controller=user&task=save" method="post">
        <?php $this->model->form->display(false); ?>
        <?php $groups = $this->model->database->loadObjectList("SELECT id as value, title as name FROM #__usergroups ORDER BY id ASC"); ?>
        <?php $this->model->form->displaySelect($groups, "usergroup_id", $this->model->usergroup_id, false, "", "Usergroup", Core::config()->default_usergroup); ?>
        <button type="submit" class="button float-right no-margin"><i class="fa fa-save"></i> Save</button>
        <div class="clearfix"></div>
    </form>
</div>