<div class="row dashboard-row">
    <div class="col-md-6">
        <div class="white-card">
            <h2>Latest Articles</h2>
            <?php foreach ($this->model->articles as $article) { ?>
                <p><a href="index.php?component=content&controller=article&id=<?php echo $article->id; ?>"><?php echo $article->title; ?></a><br />By <?php echo $article->author->username; ?></p>
            <?php } ?>
        </div>
    </div>
    <div class="col-md-6">
        <div class="white-card">
            <h2>Latest Users</h2>
            <?php foreach ($this->model->users as $user) { ?>
                <p><a href="index.php?component=user&controller=user&id=<?php echo $user->id; ?>"><?php echo $user->username; ?></a><br /><?php echo date("jS F Y", $user->register_time); ?></p>
            <?php } ?>
        </div>
    </div>
</div>
<div class="row dashboard-row">
    <div class="col-md-12">
        <div class="white-card">
            <h2>Website Statistics</h2>
            <p><strong><?php echo $this->model->article_count; ?></strong> Articles</p>
            <p><strong><?php echo $this->model->user_count; ?></strong> Users</p>
            <p><strong><?php echo $this->model->launch_days; ?></strong> Days since launch</p>
        </div>
    </div>
</div>