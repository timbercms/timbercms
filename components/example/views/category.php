<?php if ($this->model->id > 0 && $this->model->published) { ?>
    <div class="category-container">
        <h1 class="category-title"><?php echo $this->model->title; ?></h1>
        <div class="category-description">
            <?php echo $this->model->description; ?>
        </div>
    </div>
    <?php if (count($this->model->children) > 0) { ?>
        <div class="child-categories">
            <?php foreach ($this->model->children as $child) { ?>
                <div class="child-category">
                    <div class="row">
                        <div class="col-md-3">
                            <img src="<?php echo $child->image; ?>" class="child-category-image" />
                        </div>
                        <div class="col-md-9">
                            <h4 class="child-category-title">
                                <a href="<?php echo Core::route("index.php?component=example&controller=category&id=". $child->id); ?>"><?php echo $child->title; ?></a>
                            </h4>
                            <div class="child-category-description">
                                <?php echo $child->description; ?>
                            </div>
                            <p><a href="<?php echo Core::route("index.php?component=example&controller=category&id=". $child->id); ?>" class="button">View items</a></p>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    <?php } ?>
<?php } else { ?>
    <div class="system-message danger">Category not found</div>
<?php } ?>