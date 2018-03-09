<div class="latest-news-list">
    <?php foreach ($worker->items as $article) { ?>
        <div class="latest-news-item">
            <div class="row">
                <div class="col-md-3">
                    <img class="latestnews-article-image" src="<?php echo $article->image; ?>">
                </div>
                <div class="col-md-9">
                    <a href="<?php echo Core::route("index.php?component=content&controller=article&id=". $article->id); ?>"><?php echo $article->title; ?></a><br />
                    By <?php echo $article->author->real_name; ?>
                </div>
            </div>
        </div>
    <?php } ?>
</div>