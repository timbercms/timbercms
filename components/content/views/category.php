<?php if ($this->model->id > 0) { ?>
    <div class="category-container">
        <h1 class="category-title"><?php echo $this->model->title; ?></h1>
        <div class="category-description">
            <?php echo $this->model->description; ?>
        </div>
    </div>
    <div class="category-articles">
        <div class="frame">
            <?php foreach ($this->model->articles as $article) { ?>
                <div class="frame-4">
                    <div class="category-article">
                        <div class="category-article-image" style="background-image: url('https://unsplash.it/416/150?random');"></div>
                        <div class="category-time">
                            <i class="fa fa-clock-o"></i> <?php echo $this->model->relativeTime($article->publish_time); ?>
                        </div>
                        <h3 class="category-article-title"><?php echo $article->title; ?></h3>
                        <div class="category-article-description">
                            <?php echo substr(strip_tags($article->content), 0, 200); ?><?php echo (strlen($article->content) > 200 ? "..." : ""); ?>
                        </div>
                        <div class="category-read-more">
                            <a href="<?php echo Core::route($article->category->alias."/".$article->alias); ?>" class="burgundy-button">Read More <i class="fa fa-chevron-right"></i></a>
                        </div>
                        <div class="category-article-information">
                            <i class="fa fa-comments"></i> <?php echo $article->comment_count; ?> <?php echo ($article->comment_count > 1 ? "Comments" : "Comment"); ?>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
<?php } else { ?>
    Category not found
<?php } ?>