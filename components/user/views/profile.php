<div class="row">
    <div class="col-md-4">
        <img src="https://www.gravatar.com/avatar/<?php echo md5(strtolower(trim($this->model->user->email))); ?>?s=200" class="user-profile-avatar" />
    </div>
    <div class="col-md-8">
        <div class="user-information">
            <h3>About <?php echo explode(" ", $this->model->user->username)["0"]; ?></h3>
            <ul>
                <li><strong>Member since:</strong> <?php echo date("jS F Y", $this->model->user->register_time); ?></li>
                <li><strong>Last Online:</strong> <?php echo ((time() - $this->model->user->last_action_time) <= 900 ? "Online Now" : $this->model->relativeTime($this->model->user->last_action_time) ." ago"); ?></li>
            </ul>
        </div>
    </div>
</div>
<div class="user-information">
    <div class="row">
        <div class="col-md-6">
            <h3 style="margin-top: 40px;">Recent Articles by <?php echo $this->model->user->username; ?></h3>
            <ul>
                <?php foreach ($this->model->articles as $article) { ?>
                    <li>
                        <p><a href="<?php echo Core::route("index.php?component=content&controller=article&id=". $article->id); ?>"><?php echo $article->title; ?></a><br /><?php echo $this->model->relativeTime($article->publish_time); ?> ago</p>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>
</div>