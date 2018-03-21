<div class="white-card">
    <h2>Category Manager</h2>
    <div class="component-action-bar">
        <a href="index.php?component=settings&controller=settings&extension=content"><i class="fa fa-cog"></i> Settings</a><a href="index.php?component=content&controller=category"><i class="fa fa-plus"></i> New Category</a><a class="delete-by-ids"><i class="fa fa-trash"></i> Delete</a>
    </div>
    <form action="index.php?component=content&controller=categories&task=delete" method="post" class="admin-form">
        <div class="d-flex admin-header">
            <div class="col-md-1">&nbsp;</div>
            <div class="col-md-1"><strong>ID</strong></div>
            <div class="col-md-9"><strong>Title</strong></div>
            <div class="col-md-1" style="text-align: center;"><strong>Published</strong></div>
        </div>
        <?php foreach ($this->model->categories as $category) { ?>
            <div class="d-flex align-items-center admin-list">
                <div class="col-md-1" style="text-align: center;">
                    <input type="checkbox" name="ids[]" value="<?php echo $category->id; ?>" />
                </div>
                <div class="col-md-1">
                    <?php echo $category->id; ?>
                </div>
                <div class="col-md-9">
                    <a href="index.php?component=content&controller=category&id=<?php echo $category->id; ?>"><?php echo $category->title; ?></a>
                </div>
                <div class="col-md-1" style="text-align: center;">
                    <a href="index.php?component=content&controller=category&task=<?php echo ($category->published == 1 ? "unpublish" : "publish"); ?>&id=<?php echo $category->id; ?>" class="btn btn-<?php echo ($category->published == 1 ? "success" : "danger"); ?>">
                        <i class="fa fa-<?php echo ($category->published == 1 ? "check" : "times"); ?>"></i>
                    </a>
                </div>
            </div>
        <?php } ?>
    </form>
</div>