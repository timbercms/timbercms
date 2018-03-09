<div class="white-card">
    <h2>Usergroups Manager</h2>
    <div class="component-action-bar">
        <a href="index.php?component=settings&controller=settings&extension=user"><i class="fa fa-cog"></i> Settings</a><a href="index.php?component=user&controller=usergroup"><i class="fa fa-plus"></i> New Usergroup</a><a class="delete-by-ids"><i class="fa fa-trash"></i> Delete</a>
    </div>
    <form action="index.php?component=user&controller=usergroups&task=delete" method="post" class="admin-form">
        <table>
            <tr>
                <th class="frame-1">&nbsp;</th>
                <th class="frame-1"><strong>ID</strong></th>
                <th class="frame-4"><strong>Title</strong></th>
                <th class="frame-4"><strong>Colour</strong></th>
                <th class="frame-2"><strong>Is Admin?</strong></th>
            </tr>
            <?php foreach ($this->model->groups as $group) { ?>
                <tr>
                    <td class="frame-1" style="text-align: center;"><input type="checkbox" name="ids[]" value="<?php echo $group->id; ?>" /></td>
                    <td class="frame-1"><?php echo $group->id; ?></td>
                    <td class="frame-4"><a href="index.php?component=user&controller=usergroup&id=<?php echo $group->id; ?>"><?php echo $group->title; ?></a></td>
                    <td class="frame-4"><?php echo $group->colour; ?></td>
                    <td class="frame-2"><i class="fa fa-<?php echo ($group->is_admin == 1 ? "check" : "times"); ?>"></i></td>
                </tr>
            <?php } ?>
        </table>
    </form>
</div>