<?php if ($this->model->id > 0 && $this->model->published) { ?>
    <?php if ($this->model->params->show_title) { ?>
        <div class="category-container">
            <h1 class="category-title"><?php echo $this->model->title; ?></h1>
            <div class="category-description">
                <?php echo $this->model->description; ?>
            </div>
        </div>
    <?php } ?>
    <div class="card-columns">
        <?php foreach ($this->model->articles as $article) { ?>
            <div class="card category-card">
                <a href="<?php echo Core::route("index.php?component=content&controller=article&id=". $article->id); ?>"><img class="card-img-top" src="<?php echo $article->image; ?>" /></a>
                <div class="card-body">
                    <h5 class="card-title"><a href="<?php echo Core::route("index.php?component=content&controller=article&id=". $article->id); ?>"><?php echo $article->title; ?></a></h5>
                    <?php echo preg_replace("/<img[^>]+\>/i", "", $article->short_content); ?>
                    <div class="category-author-info">
                        <div class="row align-items-center">
                            <div class="col-md-3">
                                <img src="<?php echo $article->author->avatar; ?>" />
                            </div>
                            <div class="col-md-9">
                                <a href="<?php echo Core::route("index.php?component=user&controller=profile&id=". $article->author->id); ?>"><?php echo $article->author->username; ?></a><br />
                                <time pubdate><?php echo $this->model->relativeTime($article->publish_time); ?> ago</time>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
<?php } else { ?>
    <div class="system-message danger">Category not found</div>
<?php } ?>