<?php if ($this->model->id > 0) { ?>
    <?php if ($this->model->params->show_title) { ?>
        <div class="category-container">
            <h1 class="category-title"><?php echo $this->model->title; ?></h1>
            <div class="category-description">
                <?php echo $this->model->description; ?>
            </div>
        </div>
    <?php } ?>
    <div class="category-articles">
        <?php foreach ($this->model->articles as $article) { ?>
            <div class="category-article">
                <div class="row">
                    <div class="col-md-4">
                        <?php if ($article->image) { ?>
                            <div class="category-article-image" style="background-image: url('<?php echo $article->image; ?>');"></div>
                        <?php } ?>
                    </div>
                    <div class="col-md-8">
                        <h3 class="category-article-title"><a href="<?php echo Core::route("index.php?component=content&controller=article&id=". $article->id); ?>"><?php echo $article->title; ?></a></h3>
                        <div class="category-time">
                            <i class="fa fa-clock-o"></i> <?php echo $this->model->relativeTime($article->publish_time); ?>
                        </div>
                        <div class="category-article-description">
                            <?php echo substr(strip_tags($article->content), 0, 200); ?><?php echo (strlen($article->content) > 200 ? "..." : ""); ?>
                        </div>
                        <div class="category-read-more">
                            <a href="<?php echo Core::route("index.php?component=content&controller=article&id=". $article->id); ?>" class="button">Read More <i class="fa fa-chevron-right"></i></a>
                        </div>
                        <div class="category-article-information">
                            <i class="fa fa-comments"></i> <?php echo $article->comment_count; ?> <?php echo ($article->comment_count > 1 || $article->comment_count == 0 ? "Comments" : "Comment"); ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
<?php } else { ?>
    Category not found
<?php } ?>