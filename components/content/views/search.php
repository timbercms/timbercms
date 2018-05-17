<?php if (strlen($_GET["query"]) > 0) { ?>
    <div class="search-page">
        <h1>Search Results for "<?php echo $_GET["query"]; ?>"</h1>
        <div class="card-columns">
            <?php foreach ($this->model->articles as $article) { ?>
                <div class="card category-card">
                    <a href="<?php echo Core::route("index.php?component=content&controller=article&id=". $article->id); ?>"><img class="card-img-top" src="<?php echo $article->image; ?>" /></a>
                    <div class="card-body">
                        <h5 class="card-title"><a href="<?php echo Core::route("index.php?component=content&controller=article&id=". $article->id); ?>"><?php echo $article->title; ?></a></h5>
                        <?php echo preg_replace("/<img[^>]+\>/i", "", $article->short_content); ?>
                        <div class="category-author-info">
                            <div class="row align-items-center">
                                <div class="col-md-3 col-4">
                                    <img src="<?php echo $article->author->avatar; ?>" />
                                </div>
                                <div class="col-md-6 col-8">
                                    By <a href="<?php echo Core::route("index.php?component=user&controller=profile&id=". $article->author->id); ?>"><?php echo $article->author->username; ?></a><br />
                                    <time pubdate><?php echo $this->model->relativeTime($article->publish_time); ?> ago</time>
                                </div>
                                <div class="col-md-3 col-12" style="text-align: right;">
                                    <a href="<?php echo Core::route("index.php?component=content&controller=article&id=". $article->id); ?>" class="button">More</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <p><i class="fa fa-eye"></i> <?php echo $article->hits; ?></p>
                        <p><i class="fa fa-comments"></i> <?php echo count($article->comments); ?></p>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
<?php } else { ?>
    <h1>Search Results</h1>
    <p>You did not enter a search query.</p>
<?php } ?>