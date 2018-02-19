<div class="latest-news-list">
    <ul>
        <?php foreach ($worker->items as $article) { ?>
            <li>
                <a href="<?php echo Core::route("index.php?component=content&controller=article&id=". $article->id); ?>"><?php echo $article->title; ?></a><br />
                By <?php echo $article->author->real_name; ?>
            </li>
        <?php } ?>
    </ul>
</div>