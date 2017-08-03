<div class="card">
    <h2>Menu Manager</h2>
    <div class="action-bar">
        <a href="index.php?component=menu&controller=menu"><i class="fa fa-plus"></i> New Menu</a><a class="delete-by-ids"><i class="fa fa-trash"></i> Delete</a>
    </div>
    <form action="index.php?component=menu&controller=menus&task=delete" method="post" class="admin-form">
        <table>
            <tr>
                <th class="frame-1">&nbsp;</th>
                <th class="frame-1"><strong>ID</strong></th>
                <th class="frame-8"><strong>Title</strong></th>
                <th class="frame-2"><strong>Menu Items</strong></th>
            </tr>
            <?php foreach ($this->model->menus as $menu) { ?>
                <tr>
                    <td class="frame-1" style="text-align: center;"><input type="checkbox" name="ids[]" value="<?php echo $menu->id; ?>" /></td>
                    <td class="frame-1"><?php echo $menu->id; ?></td>
                    <td class="frame-8"><a href="index.php?component=menu&controller=menu&id=<?php echo $menu->id; ?>"><?php echo $menu->title; ?></a></td>
                    <td class="frame-2"><a href="index.php?component=menu&controller=menuitems&id=<?php echo $menu->id; ?>" class="button"><i class="fa fa-pencil"></i> Edit Menu Items</a></td>
                </tr>
            <?php } ?>
        </table>
    </form>
</div>