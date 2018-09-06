<?php if ($this->model->id > 0 && $this->model->published) { ?>
    <?php if ($this->model->params->show_title) { ?>
        <div class="category-container">
            <h1 class="category-title"><?php echo $this->model->title; ?></h1>
            <div class="category-description">
                <?php echo $this->model->description; ?>
            </div>
        </div>
    <?php } ?>
    <?php if ($this->model->params->show_children && count($this->model->children) > 0) { ?>
        <div class="child-categories">
            <?php foreach ($this->model->children as $child) { ?>
                <div class="child-category">
                    <h4 class="child-category-title">
                        <a href="<?php echo Core::route("index.php?component=content&controller=category&id=". $child->id); ?>"><?php echo $child->title; ?></a>
                    </h4>
                    <div class="child-category-description">
                        <?php echo $child->description; ?>
                    </div>
                    <p><a href="<?php echo Core::route("index.php?component=content&controller=category&id=". $child->id); ?>" class="button">View items</a></p>
                </div>
            <?php } ?>
        </div>
    <?php } ?>
    <div class="article-list">
        <?php foreach ($this->model->articles as $article) { ?>
            <div class="category-article">
                <div class="row">
                    <div class="col-3">
                        <img src="<?php echo $article->image; ?>" class="category-article-image" />
                    </div>
                    <div class="col-9">
                        <div class="category-article-title">
                            <a href="<?php echo Core::route("index.php?component=content&controller=article&id=". $article->id); ?>">
                                <?php echo $article->title; ?>
                            </a>
                        </div>
                        <div class="category-article-author-info">
                            <time pubdate><?php echo $this->model->relativeTime($article->publish_time); ?> ago</time> by <a href="<?php echo Core::route("index.php?component=user&controller=profile&id=". $article->author->id); ?>"><?php echo $article->author->username; ?></a>
                        </div>
                        <div class="category-article-content">
                            <?php echo preg_replace("/<img[^>]+\>/i", "", $article->short_content); ?>
                        </div>
                        <div class="category-article-readmore">
                            <a href="<?php echo Core::route("index.php?component=content&controller=article&id=". $article->id); ?>" class="button">Read more</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
<?php } else { ?>
    <div class="system-message danger">Category not found</div>
<?php } ?>