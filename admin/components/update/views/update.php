<?php

    $version = simplexml_load_file(__DIR__ ."/../../../version.xml");
    $opts = [
        'http' => [
                'method' => 'GET',
                'header' => [
                        'User-Agent: PHP'
                ]
        ]
    ];
    $context = stream_context_create($opts);
    $web_version = json_decode(file_get_contents("https://api.github.com/repos/Smith0r/bulletin/releases", false, $context));
    $web_version = $web_version["0"];

?>
<div class="card">
    <h2>Update your Bulletin installation</h2>
    <div class="action-bar">
        <a href="index.php?component=settings&controller=settings&extension=update"><i class="fa fa-cog"></i> Settings</a>
    </div>
    <?php if (version_compare($version->numerical, $web_version->tag_name)) { ?>
        <p>&nbsp;</p>
        <h3>Release Information for <?php echo $web_version->name; ?></h3>
        <div class="new-version-notes">
            <?php echo $web_version->body; ?>
        </div>
        <p style="text-align: center;"><a href="index.php?component=update&controller=update&task=update" class="btn btn-success btn-lg">UPDATE TO VERSION <?php echo $web_version->name; ?></a></p>
    <?php } else { ?>
        <p>&nbsp;</p>
        <p>Looks like your Bulletin installation (v<?php echo $version->numerical; ?>) is up to date. You don't need to do anything!</p>
    <?php } ?>
</div>