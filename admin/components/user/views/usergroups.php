<div class="white-card">
    <h2>Usergroups Manager</h2>
    <div class="component-action-bar">
        <a href="index.php?component=settings&controller=settings&extension=user" class="button"><i class="fa fa-cog"></i> Settings</a><a href="index.php?component=user&controller=usergroup" class="button green-button"><i class="fa fa-plus"></i> New Usergroup</a><a class="delete-by-ids button red-button"><i class="fa fa-trash"></i> Delete</a>
    </div>
    <form action="index.php?component=user&controller=usergroups&task=delete" method="post" class="admin-form">
        <div class="d-flex admin-header">
            <div class="col-md-1">&nbsp;</div>
            <div class="col-md-1"><strong>ID</strong></div>
            <div class="col-md-4"><strong>Title</strong></div>
            <div class="col-md-4"><strong>Colour</strong></div>
            <div class="col-md-2"><strong>Is Admin?</strong></div>
        </div>
        <?php foreach ($this->model->groups as $group) { ?>
            <div class="d-flex admin-list align-items-center">
                <div class="col-md-1" style="text-align: center;">
                    <input type="checkbox" name="ids[]" value="<?php echo $group->id; ?>" />
                </div>
                <div class="col-md-1">
                    <?php echo $group->id; ?>
                </div>
                <div class="col-md-4">
                    <a href="index.php?component=user&controller=usergroup&id=<?php echo $group->id; ?>"><?php echo $group->title; ?></a>
                </div>
                <div class="col-md-4">
                    <?php echo $group->colour; ?>
                </div>
                <div class="col-md-2">
                    <i class="fa fa-<?php echo ($group->is_admin == 1 ? "check" : "times"); ?>"></i>
                </div>
            </div>
        <?php } ?>
    </form>
</div>