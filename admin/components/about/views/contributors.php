<?php

    $opts = [
        'http' => [
                'method' => 'GET',
                'header' => [
                        'User-Agent: PHP'
                ]
        ]
    ];
    $context = stream_context_create($opts);
    $contributors = json_decode(file_get_contents("https://api.github.com/repos/Smith0r/bulletin/contributors", false, $context));

?>
<div class="white-card">
    <h2>Contributors</h2>
    <p>Bulletin CMS is an Open Source community project. Anyone can propose a change to the codebase. Below are the users who have contributed to the project so far.</p>
    <h3 style="margin-top: 40px; margin-bottom: 20px;">Contributing Users</h3>
    <div class="row">
        <?php foreach ($contributors as $contrib) { ?>
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-2">
                        <a href="<?php echo $contrib->html_url; ?>" target="_blank"><img src="<?php echo $contrib->avatar_url; ?>" style="width: 100%; height: auto;" /></a>
                    </div>
                    <div class="col-md-10">
                        <p><a href="<?php echo $contrib->html_url; ?>" target="_blank"><?php echo $contrib->login; ?></a></p>
                        Contributions: <?php echo $contrib->contributions; ?>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>