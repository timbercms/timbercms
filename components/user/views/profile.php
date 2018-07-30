<?php if ($this->model->user->activated) { ?>
    <div class="profile-header <?php echo (strlen($this->model->user->params->header_pattern) > 0 ? $this->model->user->params->header_pattern : "topography"); ?>">
        <img src="https://www.gravatar.com/avatar/<?php echo md5(strtolower(trim($this->model->user->email))); ?>?s=200" class="user-profile-avatar" />
        <div class="profile-username">
            <?php echo $this->model->user->username; ?><div class="online-status <?php if ((time() - $this->model->user->last_action_time) <= 900) { ?>online<?php } else { ?>offline<?php } ?>" data-toggle="tooltip" data-placement="top" title="<?php echo $this->model->user->username; ?> is <?php if ((time() - $this->model->user->last_action_time) <= 900) { ?>Online now<?php } else { ?>Offline<?php } ?>"></div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="user-information">
                <h3>About <?php echo $this->model->user->username; ?></h3>
                <ul>
                    <li><strong>Member since:</strong> <?php echo date("jS F Y", $this->model->user->register_time); ?></li>
                    <li><strong>Member for:</strong> <?php echo $this->model->days; ?> days</li>
                    <li><strong>Last Online:</strong> <?php echo ((time() - $this->model->user->last_action_time) <= 900 ? "Online Now" : $this->model->relativeTime($this->model->user->last_action_time) ." ago"); ?></li>
                    <li><strong>Articles written:</strong> <?php echo $this->model->article_count; ?></li>
                    <li><strong>Comments written:</strong> <?php echo $this->model->comment_count; ?></li>
                </ul>
            </div>
        </div>
        <div class="col-md-6">
            <div class="user-information">
                <h3 style="margin-top: 40px;">Recent Articles by <?php echo $this->model->user->username; ?></h3>
                <div class="profile-news-list">
                    <?php foreach ($this->model->articles as $article) { ?>
                        <div class="profile-news-item">
                            <div class="row">
                                <div class="col-md-3">
                                    <a href="<?php echo Core::route("index.php?component=content&controller=article&id=". $article->id); ?>"><img src="<?php echo $article->image; ?>" class="profile-article-image" /></a>
                                </div>
                                <div class="col-md-9">
                                    <p><a href="<?php echo Core::route("index.php?component=content&controller=article&id=". $article->id); ?>"><?php echo $article->title; ?></a></p>
                                    <?php echo $article->short_content; ?>
                                    <p><time pubdate><?php echo $this->model->relativeTime($article->publish_time); ?> ago</time></p>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <div class="user-information">
                <h3 style="margin-top: 40px;">Recent Comments by <?php echo $this->model->user->username; ?></h3>
                <?php foreach ($this->model->comments as $comment) { ?>
                    <div class="card">
                        <div class="card-header">
                            In: <a href="<?php echo Core::route("index.php?component=content&controller=article&id=". $comment->article_id); ?>"><?php echo $comment->article_title; ?></a>
                        </div>
                        <div class="card-body">
                            <?php echo $comment->content; ?>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
<?php } else { ?>
    <div class="system-message danger">User not found</div>
<?php } ?>