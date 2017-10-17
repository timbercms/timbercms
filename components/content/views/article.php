<?php if ($this->model->id > 0) { ?>
    <?php $this->model->loadComments(); ?>
    <article class="article-container">
        <header>
            <?php if ($this->model->image) { ?>
                <div class="article-image" style="background-image: url('<?php echo $this->model->image; ?>');">
                </div>
            <?php } ?>
            <div class="row article-header">
                <div class="col-md-2 article-avatar-container">
                    <img src="https://www.gravatar.com/avatar/<?php echo md5(strtolower(trim($this->model->author->email))); ?>?s=100" class="article-avatar" />
                </div>
                <div class="col-md-10">
                    <h1 class="article-title"><?php echo $this->model->title; ?></h1>
                    <p class="article-publish-date">
                        Written by <?php echo $this->model->author->username; ?> on the <time pubdate><?php echo date("jS F Y", $this->model->publish_time); ?></time>
                    </p>
                </div>
            </div>
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
            <strong>Category:</strong> <?php echo $this->model->category->title; ?><br />
            <strong>Views:</strong> <?php echo $this->model->hits; ?> times
        </footer>
        <h3 class="comments-header"><?php echo count($this->model->comments); ?> <?php echo (count($this->model->comments) != 1 ? "comments" : "comment"); ?></h3>
        <section class="comments-container">
            <?php foreach ($this->model->comments as $comment) { ?>
                <div class="comment row">
                    <div class="col-md-2">
                        <div class="article-comment-avatar-container">
                            <img src="https://www.gravatar.com/avatar/<?php echo md5(strtolower(trim($comment->author->email))); ?>" class="comment-avatar" />
                        </div>
                    </div>
                    <div class="col-md-10">
                        <div class="article-comment-info-container">
                            <header class="comment-information">
                                <h3><time pubdate><?php echo date("jS F Y", $comment->post_time); ?></time><?php echo $comment->author->username; ?> said:</h3>
                            </header>
                            <div class="comment-content">
                                <?php echo $comment->content; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </section>
        <h4 style="margin-top: 20px;">Add your comment</h4>
        <?php if ($this->user()->id > 0) { ?>
            <section class="add-comment">
                <form action="index.php?component=content&controller=article&task=postcomment" method="post">
                    <input type="hidden" name="article_id" value="<?php echo $this->model->id; ?>" />
                    <textarea name="content"></textarea>
                    <button type="submit" class="pull-right button" style="margin: 20px 0px;"><i class="fa fa-envelope"></i> Post Comment</button>
                    <div class="clearfix"></div>
                </form>
            </section>
        <?php } else { ?>
            <div class="system-message info">
                <i class="fa fa-exclamation-circle"></i> To ensure the cleanliness of our community, we ask that if you would like to post a comment that you could log in. This helps us to eliminate spam. Thank you. You rock.<br /><br />
                <a href="<?php echo $this->route("index.php?component=user&controller=login"); ?>">You can login to your account here.</a>
            </div>
        <?php } ?>
    </article>
<?php } else { ?>
    Article not found
<?php } ?>