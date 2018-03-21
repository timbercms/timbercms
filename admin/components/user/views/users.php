<div class="white-card">
    <h2>User Manager</h2>
    <div class="component-action-bar">
        <a href="index.php?component=settings&controller=settings&extension=user"><i class="fa fa-cog"></i> Settings</a><a href="index.php?component=user&controller=user"><i class="fa fa-plus"></i> New User</a><a class="delete-by-ids"><i class="fa fa-trash"></i> Delete</a>
    </div>
    <form action="index.php?component=user&controller=users&task=delete" method="post" class="admin-form">
        <div class="d-flex admin-header">
            <div class="col-md-1">&nbsp;</div>
            <div class="col-md-1"><strong>ID</strong></div>
            <div class="col-md-4"><strong>Username</strong></div>
            <div class="col-md-4"><strong>Email</strong></div>
            <div class="col-md-1"><strong>Activated</strong></div>
            <div class="col-md-1"><strong>Blocked</strong></div>
        </div>
        <?php foreach ($this->model->users as $user) { ?>
            <div class="d-flex admin-list align-items-center">
                <div class="col-md-1" style="text-align: center;">
                    <input type="checkbox" name="ids[]" value="<?php echo $user->id; ?>" />
                </div>
                <div class="col-md-1">
                    <?php echo $user->id; ?>
                </div>
                <div class="col-md-4">
                    <a href="index.php?component=user&controller=user&id=<?php echo $user->id; ?>"><?php echo $user->username; ?></a>
                </div>
                <div class="col-md-4">
                    <?php echo $user->email; ?>
                </div>
                <div class="col-md-1">
                    <i class="fa fa-<?php echo ($user->activated == 1 ? "check" : "times"); ?>"></i>
                </div>
                <div class="col-md-1">
                    <i class="fa fa-<?php echo ($user->blocked == 1 ? "check" : "times"); ?>"></i>
                </div>
            </div>
        <?php } ?>
    </form>
</div>