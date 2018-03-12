<div class="white-card">
    <h2>Menuitem Manager</h2>
    <div class="component-action-bar">
        <a href="index.php?component=menu&controller=newitem&menu_id=<?php echo $_GET["id"]; ?>"><i class="fa fa-plus"></i> New Menu Item</a><a class="delete-by-ids"><i class="fa fa-trash"></i> Delete</a>
    </div>
    <form action="index.php?component=menu&controller=menuitems&task=delete&id=<?php echo $_GET["id"]; ?>" method="post" class="admin-form">
        <table>
            <tr>
                <th class="frame-1">&nbsp;</th>
                <th class="frame-1"><strong>ID</strong></th>
                <th class="frame-4"><strong>Title</strong></th>
                <th class="frame-3"><strong>Type</strong></th>
                <th class="frame-1" style="text-align: center;"><strong>Published</strong></th>
                <th class="frame-2"><strong>&nbsp;</strong></th>
            </tr>
            <?php foreach ($this->model->items as $item) { ?>
                <tr>
                    <td class="frame-1" style="text-align: center;"><input type="checkbox" name="ids[]" value="<?php echo $item->id; ?>" /></td>
                    <td class="frame-1"><?php echo $item->id; ?></td>
                    <td class="frame-4"><a href="index.php?component=menu&controller=menuitem&id=<?php echo $item->id; ?>&menu_id=<?php echo $item->menu_id; ?>"><?php echo $item->title; ?></a></td>
                    <td class="frame-3"><?php echo $item->component; ?> - <?php echo $item->controller; ?></td>
                    <td class="frame-1" style="text-align: center;">
                        <a href="index.php?component=menu&controller=menuitem&task=<?php echo ($item->published == 1 ? "unpublish" : "publish"); ?>&id=<?php echo $item->id; ?>&menu_id=<?php echo $item->menu_id; ?>" class="btn btn-<?php echo ($item->published == 1 ? "success" : "danger"); ?>">
                            <i class="fa fa-<?php echo ($item->published == 1 ? "check" : "times"); ?>"></i>
                        </a>
                    </td>
                    <td class="frame-2" style="text-align: right;"><a href="index.php?component=menu&controller=menuitem&id=<?php echo $item->id; ?>&menu_id=<?php echo $item->menu_id; ?>" class="button"><i class="fa fa-pencil"></i> Edit Item</a></td>
                </tr>
            <?php } ?>
        </table>
    </form>
</div>