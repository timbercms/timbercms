<?php if ($this->model->id > 0 && $this->model->published && $this->model->category->published) { ?>
    <article class="article-container">
        <header>
            <?php if ($this->model->image) { ?>
                <img class="article-image" src="<?php echo (strlen(SUBFOLDER) > 0 ? SUBFOLDER : "/"); ?><?php echo $this->model->image; ?>" alt="<?php echo $this->model->title; ?>" />
            <?php } ?>
            <h1 class="article-title"><?php echo $this->model->title; ?></h1>
            <div class="article-author-info">
                <div class="row align-items-center">
                    <div class="col-md-1 col-4">
                        <a href="<?php echo Core::route("index.php?component=user&controller=profile&id=". $this->model->id); ?>"><img src="<?php echo $this->model->author->avatar; ?>" /></a>
                    </div>
                    <div class="col-md-11 col-8">
                        By <a href="<?php echo Core::route("index.php?component=user&controller=profile&id=". $this->model->id); ?>"><?php echo $this->model->author->username; ?></a><br />
                        <time pubdate><?php echo $this->model->relativeTime($this->model->publish_time); ?> ago</time>
                    </div>
                </div>
            </div>
        </header>
        <div class="article-content">
            <?php echo $this->model->content; ?>
        </div>
        <?php if (Core::componentconfig()->enable_comments == 1 && Core::componentconfig()->comments_type == "disqus") { ?>
            <div id="disqus_thread"></div>
            <script>

            /**
            *  RECOMMENDED CONFIGURATION VARIABLES: EDIT AND UNCOMMENT THE SECTION BELOW TO INSERT DYNAMIC VALUES FROM YOUR PLATFORM OR CMS.
            *  LEARN WHY DEFINING THESE VARIABLES IS IMPORTANT: https://disqus.com/admin/universalcode/#configuration-variables*/
            var disqus_config = function () {
            this.page.url = "<?php echo $_SERVER["REQUEST_SCHEME"]; ?>://<?php echo $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; ?>";  // Replace PAGE_URL with your page's canonical URL variable
            this.page.identifier = '<?php echo $this->model->id; ?>'; // Replace PAGE_IDENTIFIER with your page's unique identifier variable
            };
            (function() { // DON'T EDIT BELOW THIS LINE
            var d = document, s = d.createElement('script');
            s.src = 'https://<?php echo Core::componentconfig()->disqus_shortname; ?>.disqus.com/embed.js';
            s.setAttribute('data-timestamp', +new Date());
            (d.head || d.body).appendChild(s);
            })();
            </script>
            <noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
        <?php } ?>
        <div class="share-buttons">
            <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $_SERVER["REQUEST_SCHEME"]; ?>://<?php echo $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; ?>" class="facebook-button" target="_blank"><i class="fab fa-facebook-f"></i></a>
            <a href="https://twitter.com/home?status=<?php echo urlencode($_SERVER["REQUEST_SCHEME"]."://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']); ?>" class="twitter-button" target="_blank"><i class="fab fa-twitter"></i></a>
            <a href="https://plus.google.com/share?url=<?php echo $_SERVER["REQUEST_SCHEME"]; ?>://<?php echo $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; ?>" class="google-button" target="_blank"><i class="fab fa-google-plus-g"></i></a>
            <a href="whatsapp://send?text=<?php echo $_SERVER["REQUEST_SCHEME"]; ?>://<?php echo $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; ?>" data-action="share/whatsapp/share" data-href="<?php echo $_SERVER["REQUEST_SCHEME"]; ?>://<?php echo $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; ?>" class="whatsapp-button"><i class="fab fa-whatsapp"></i></a>
        </div>
        <footer class="article-information">
            <p><strong>Category:</strong> <?php echo $this->model->category->title; ?></p>
            <p><strong>Views:</strong> <?php echo $this->model->hits; ?> times</p>
        </footer>
        <?php if (Core::componentconfig()->enable_comments == 1 && Core::componentconfig()->comments_type == "internal") { ?>
            <div class="comments-container">
                <h3><?php echo count($this->model->comments); ?> Comments</h3>
                <?php if (count($this->model->comments) == 0) { ?>
                    <p style="font-style: italic;">Be the first to comment!</p>
                <?php } ?>
                <?php foreach ($this->model->comments as $comment) { ?>
                    <div class="comment-container">
                        <div class="row">
                            <div class="col-md-2 comment-author">
                                <p><a href="<?php echo Core::route("index.php?component=user&controller=profile&id=". $comment->author->id); ?>"><img src="<?php echo $comment->author->avatar; ?>" /></a></p>
                                <p><a href="<?php echo Core::route("index.php?component=user&controller=profile&id=". $comment->author->id); ?>"><?php echo $comment->author->username; ?></a></p>
                                <p><time pubdate><?php echo $this->model->relativeTime($comment->publish_time); ?> ago</time></p>
                            </div>
                            <div class="col-md-10">
                                <?php echo $comment->content; ?>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <?php if (Core::user()->id > 0) { ?>
                    <h3>Add your comment</h3>
                    <div class="comments-form">
                        <form action="<?php echo Core::route("index.php?component=content&controller=article&task=postComment"); ?>" method="post">
                            <textarea name="content" class="form-control"></textarea>
                            <input type="hidden" name="article_id" value="<?php echo $this->model->id; ?>" />
                            <p style="text-align: right; margin-top: 20px;"><button type="submit" class="button">Add your Comment&nbsp;&nbsp;&nbsp;<i class="fa fa-comments"></i></button></p>
                        </form>
                    </div>
                <?php } ?>
            </div>
        <?php } ?>
    </article>
<?php } else { ?>
    <div class="system-message danger">Article not found</div>
<?php } ?>