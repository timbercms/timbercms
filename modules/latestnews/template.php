<div class="latest-news-list">
    <?php foreach ($worker->items as $article) { ?>
        <div class="latest-news-item">
            <div class="row">
                <div class="col-3">
                    <a href="<?php echo Core::route("index.php?component=content&controller=article&id=". $article->id); ?>"><img class="latestnews-article-image" src="<?php echo $article->image; ?>"></a>
                </div>
                <div class="col-9">
                    <a href="<?php echo Core::route("index.php?component=content&controller=article&id=". $article->id); ?>"><?php echo $article->title; ?></a><br />
                    By <?php echo $article->author->username; ?>
                </div>
            </div>
        </div>
    <?php } ?>
</div>