<?php if ($this->model->id > 0) { ?>
    <article class="article-container">
        <header>
            <?php if ($this->model->image) { ?>
                <div class="article-image" style="background-image: url('<?php echo (strlen(SUBFOLDER) > 0 ? SUBFOLDER : "/"); ?><?php echo $this->model->image; ?>');">
                </div>
            <?php } ?>
            <h1 class="article-title"><?php echo $this->model->title; ?></h1>
            <p class="article-publish-date">
                Written by <?php echo $this->model->author->real_name; ?> on the <time pubdate><?php echo date("jS F Y", $this->model->publish_time); ?></time>
            </p>
        </header>
        <div class="article-content">
            <?php echo $this->model->content; ?>
        </div>
        <div class="share-buttons">
            <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $_SERVER["REQUEST_SCHEME"]; ?>://<?php echo $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; ?>" class="facebook-button" target="_blank"><i class="fa fa-facebook-official"></i></a>
            <a href="https://twitter.com/home?status=<?php echo urlencode($_SERVER["REQUEST_SCHEME"]."://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']); ?>" class="twitter-button" target="_blank"><i class="fa fa-twitter"></i></a>
            <a href="https://plus.google.com/share?url=<?php echo $_SERVER["REQUEST_SCHEME"]; ?>://<?php echo $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; ?>" class="google-button" target="_blank"><i class="fa fa-google-plus"></i></a>
            <a href="whatsapp://send?text=<?php echo $_SERVER["REQUEST_SCHEME"]; ?>://<?php echo $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; ?>" data-action="share/whatsapp/share" data-href="<?php echo $_SERVER["REQUEST_SCHEME"]; ?>://<?php echo $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; ?>" class="whatsapp-button"><i class="fa fa-whatsapp"></i></a>
        </div>
        <footer class="article-information">
            <p><strong>Category:</strong> <?php echo $this->model->category->title; ?></p>
            <p><strong>Views:</strong> <?php echo $this->model->hits; ?> times</p>
        </footer>
    </article>
<?php } else { ?>
    Article not found
<?php } ?>