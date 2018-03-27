<?php if ($this->model->id > 0) { ?>
    <?php if ($this->model->params->show_title) { ?>
        <div class="category-container">
            <h1 class="category-title"><?php echo $this->model->title; ?></h1>
            <div class="category-description">
                <?php echo $this->model->description; ?>
            </div>
        </div>
    <?php } ?>
    <?php foreach ($this->model->articles as $article) { ?>
        <div class="category-article">
            <div class="row">
                <div class="col-md-3">
                    <img class="category-article-image" src="<?php echo $article->image; ?>">
                </div>
                <div class="col-md-9">
                    <div class="category-article-info">
                        <h4 class="card-title"><a href="<?php echo Core::route("index.php?component=content&controller=article&id=". $article->id); ?>"><?php echo $article->title; ?></a></h4>
                        <p class="card-text category-publish-time"><i class="far fa-clock"></i>&nbsp;<time pubdate><?php echo $this->model->relativeTime($article->publish_time); ?> ago</time></p>
                        <p class="card-text"><?php echo substr(strip_tags($article->content), 0, 300); ?><?php echo (strlen($article->content) > 300 ? "..." : ""); ?></p>
                        <a href="<?php echo Core::route("index.php?component=content&controller=article&id=". $article->id); ?>" class="button">Read More</a>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
<?php } else { ?>
    Category not found
<?php } ?>