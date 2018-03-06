<div class="white-card">
    <h2>Module Manager</h2>
    <div class="component-action-bar">
        <a href="index.php?component=settings&controller=settings&extension=modules"><i class="fa fa-cog"></i> Settings</a><a href="index.php?component=modules&controller=module"><i class="fa fa-plus"></i> New Module</a><a class="delete-by-ids"><i class="fa fa-trash"></i> Delete</a>
    </div>
    <form action="index.php?component=modules&controller=modules&task=delete" method="post" class="admin-form">
        <table>
            <tr>
                <th class="frame-1">&nbsp;</th>
                <th class="frame-1"><strong>ID</strong></th>
                <th class="frame-5"><strong>Title</strong></th>
                <th class="frame-4"><strong>Type</strong></th>
                <th class="frame-1"><strong>Published</strong></th>
            </tr>
            <?php foreach ($this->model->modules as $module) { ?>
                <tr>
                    <td class="frame-1" style="text-align: center;"><input type="checkbox" name="ids[]" value="<?php echo $module->id; ?>" /></td>
                    <td class="frame-1"><?php echo $module->id; ?></td>
                    <td class="frame-5"><a href="index.php?component=modules&controller=module&id=<?php echo $module->id; ?>"><?php echo $module->title; ?></a></td>
                    <td class="frame-4">
                        <?php echo $module->type; ?>
                    </td>
                    <td class="frame-1">
                        <i class="fa fa-<?php echo ($module->published == 1 ? "check" : "times"); ?>"></i>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </form>
</div>