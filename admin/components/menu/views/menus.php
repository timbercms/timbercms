<div class="white-card">
    <h2>Menu Manager</h2>
    <div class="component-action-bar">
        <a href="index.php?component=settings&controller=settings&extension=menu" class="button"><i class="fa fa-cog"></i> Settings</a><a href="index.php?component=menu&controller=menu" class="button green-button"><i class="fa fa-plus"></i> New Menu</a><a class="delete-by-ids button red-button"><i class="fa fa-trash"></i> Delete</a>
    </div>
    <form action="index.php?component=menu&controller=menus&task=delete" method="post" class="admin-form">
        <div class="d-flex admin-header">
            <div class="col-md-1">&nbsp;</div>
            <div class="col-md-1"><strong>ID</strong></div>
            <div class="col-md-8"><strong>Title</strong></div>
            <div class="col-md-2"><strong></strong></div>
        </div>
        <?php foreach ($this->model->menus as $menu) { ?>
            <div class="d-flex admin-list align-items-center">
                <div class="col-md-1" style="text-align: center;">
                    <input type="checkbox" name="ids[]" value="<?php echo $menu->id; ?>" />
                </div>
                <div class="col-md-1">
                    <?php echo $menu->id; ?>
                </div>
                <div class="col-md-8">
                    <a href="index.php?component=menu&controller=menu&id=<?php echo $menu->id; ?>"><?php echo $menu->title; ?></a>
                </div>
                <div class="col-md-2">
                    <a href="index.php?component=menu&controller=menuitems&id=<?php echo $menu->id; ?>" class="button"><i class="fa fa-edit"></i> Menu Items (<?php echo count($menu->items); ?>)</a>
                </div>
            </div>
        <?php } ?>
    </form>
</div>