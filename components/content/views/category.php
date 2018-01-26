<?php if ($this->model->id > 0) { ?>
    <?php if ($this->model->params->show_title) { ?>
        <div class="category-container">
            <h1 class="category-title"><?php echo $this->model->title; ?></h1>
            <div class="category-description">
                <?php echo $this->model->description; ?>
            </div>
        </div>
    <?php } ?>
    <div class="row">
        <?php foreach ($this->model->articles as $article) { ?>
            <div class="col-md-4">
                <div class="card">
                    <img class="card-img-top" src="<?php echo $article->image; ?>">
                    <div class="card-body">
                        <h4 class="card-title"><a href="<?php echo Core::route("index.php?component=content&controller=article&id=". $article->id); ?>"><?php echo $article->title; ?></a></h4>
                        <p class="card-text category-publish-time"><i class="fa fa-clock-o"></i><time pubdate><?php echo $this->model->relativeTime($article->publish_time); ?> ago</time></p>
                        <p class="card-text"><?php echo substr(strip_tags($article->content), 0, 300); ?><?php echo (strlen($article->content) > 300 ? "..." : ""); ?></p>
                        <a href="<?php echo Core::route("index.php?component=content&controller=article&id=". $article->id); ?>" class="button">Read More</a>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
<?php } else { ?>
    Category not found
<?php } ?>