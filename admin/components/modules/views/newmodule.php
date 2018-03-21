<div class="white-card">
    <h2>New Module</h2>
    <div class="component-action-bar">
        <a href="index.php?component=modules&controller=modules" class="button"><i class="fa fa-chevron-left"></i> Back to List</a>
    </div>
    <div class="module-type" style="border: none;">
        <div class="row">
            <div class="col-md-3">
                <strong>Module Type</strong>
            </div>
            <div class="col-md-5">
                <strong>Description</strong>
            </div>
            <div class="col-md-2">
                <strong>Author</strong>
            </div>
            <div class="col-md-2">
            </div>
        </div>
    </div>
    <div class="module-type-list">
        <?php foreach ($this->model->module_types as $type) { ?>
            <div class="module-type">
                <div class="row d-flex align-items-center">
                    <div class="col-md-3">
                        <a href="index.php?component=modules&controller=module&type=<?php echo $type->internal_name; ?>"><?php echo $type->title; ?></a>
                    </div>
                    <div class="col-md-5">
                        <?php echo $type->description; ?>
                    </div>
                    <div class="col-md-2">
                        <?php echo $type->author_name; ?>
                    </div>
                    <div class="col-md-2" style="text-align: right;">
                        <a href="index.php?component=modules&controller=module&type=<?php echo $type->internal_name; ?>" class="button">Select <i class="fa fa-chevron-right"></i></a>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>