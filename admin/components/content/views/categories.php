<div class="white-card">
    <h2>Category Manager</h2>
    <div class="component-action-bar">
        <a href="index.php?component=settings&controller=settings&extension=content"><i class="fa fa-cog"></i> Settings</a><a href="index.php?component=content&controller=category"><i class="fa fa-plus"></i> New Category</a><a class="delete-by-ids"><i class="fa fa-trash"></i> Delete</a>
    </div>
    <form action="index.php?component=content&controller=categories&task=delete" method="post" class="admin-form">
        <table>
            <tr>
                <th class="frame-1">&nbsp;</th>
                <th class="frame-1"><strong>ID</strong></th>
                <th class="frame-9"><strong>Title</strong></th>
                <th class="frame-1"><strong>Published</strong></th>
            </tr>
            <?php foreach ($this->model->categories as $category) { ?>
                <tr>
                    <td class="frame-1" style="text-align: center;"><input type="checkbox" name="ids[]" value="<?php echo $category->id; ?>" /></td>
                    <td class="frame-1"><?php echo $category->id; ?></td>
                    <td class="frame-9"><a href="index.php?component=content&controller=category&id=<?php echo $category->id; ?>"><?php echo $category->title; ?></a></td>
                    <td class="frame-1">
                        <i class="fa fa-<?php echo ($category->published == 1 ? "check" : "times"); ?>"></i>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </form>
</div>