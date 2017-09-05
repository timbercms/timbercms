<div class="card">
    <h2>User Manager</h2>
    <div class="action-bar">
        <a href="index.php?component=settings&controller=settings&extension=users"><i class="fa fa-cog"></i> Settings</a><a href="index.php?component=users&controller=user"><i class="fa fa-plus"></i> New User</a><a class="delete-by-ids"><i class="fa fa-trash"></i> Delete</a>
    </div>
    <form action="index.php?component=users&controller=users&task=delete" method="post" class="admin-form">
        <table>
            <tr>
                <th class="frame-1">&nbsp;</th>
                <th class="frame-1"><strong>ID</strong></th>
                <th class="frame-4"><strong>Username</strong></th>
                <th class="frame-4"><strong>Email</strong></th>
                <th class="frame-1"><strong>Activated</strong></th>
                <th class="frame-1"><strong>Blocked</strong></th>
            </tr>
            <?php foreach ($this->model->users as $user) { ?>
                <tr>
                    <td class="frame-1" style="text-align: center;"><input type="checkbox" name="ids[]" value="<?php echo $user->id; ?>" /></td>
                    <td class="frame-1"><?php echo $user->id; ?></td>
                    <td class="frame-4"><a href="index.php?component=users&controller=user&id=<?php echo $user->id; ?>"><?php echo $user->username; ?></a></td>
                    <td class="frame-4"><?php echo $user->email; ?></td>
                    <td class="frame-1"><i class="fa fa-<?php echo ($user->activated == 1 ? "check" : "times"); ?>"></i></td>
                    <td class="frame-1"><i class="fa fa-<?php echo ($user->blocked == 1 ? "check" : "times"); ?>"></i></td>
                </tr>
            <?php } ?>
        </table>
    </form>
</div>