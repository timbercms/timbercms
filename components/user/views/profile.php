<h1><?php echo $this->model->user->real_name; ?> (<?php echo $this->model->user->username; ?>)</h1>
<iframe
    src="http://player.twitch.tv/?channel=<?php echo $this->model->user->twitch_channel; ?>"
    height="480"
    width="640"
    frameborder="0"
    scrolling="no"
    allowfullscreen="true">
</iframe>