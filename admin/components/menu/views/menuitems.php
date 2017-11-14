<div class="card">
    <h2>Menuitem Manager</h2>
    <div class="action-bar">
        <a href="index.php?component=menu&controller=menuitem&menu_id=<?php echo $_GET["id"]; ?>"><i class="fa fa-plus"></i> New Menuitem</a><a class="delete-by-ids"><i class="fa fa-trash"></i> Delete</a>
    </div>
    <form action="index.php?component=menu&controller=menuitems&task=delete" method="post" class="admin-form">
        <table>
            <tr>
                <th class="frame-1">&nbsp;</th>
                <th class="frame-1"><strong>ID</strong></th>
                <th class="frame-4"><strong>Title</strong></th>
                <th class="frame-3"><strong>Type</strong></th>
                <th class="frame-1"><strong>Published</strong></th>
                <th class="frame-2"><strong>&nbsp;</strong></th>
            </tr>
            <?php foreach ($this->model->items as $item) { ?>
                <tr>
                    <td class="frame-1" style="text-align: center;"><input type="checkbox" name="ids[]" value="<?php echo $item->id; ?>" /></td>
                    <td class="frame-1"><?php echo $item->id; ?></td>
                    <td class="frame-4"><a href="index.php?component=menu&controller=menuitem&id=<?php echo $item->id; ?>&menu_id=<?php echo $item->menu_id; ?>"><?php echo $item->title; ?></a></td>
                    <td class="frame-3"><?php echo $item->component; ?> - <?php echo $item->controller; ?></td>
                    <td class="frame-1"><i class="fa fa-<?php echo ($item->published == 1 ? "check" : "close"); ?>"></i></td>
                    <td class="frame-2"><a href="index.php?component=menu&controller=menuitem&id=<?php echo $item->id; ?>&menu_id=<?php echo $item->menu_id; ?>" class="button"><i class="fa fa-pencil"></i> Edit Item</a></td>
                </tr>
            <?php } ?>
        </table>
    </form>
</div>