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
    $web_version = json_decode(file_get_contents("https://api.github.com/repos/Smith0r/bulletin/releases", false, $context))["0"];

?>
<div class="white-card">
    <h2>Update your Bulletin installation</h2>
    <div class="component-action-bar">
        <a href="index.php?component=settings&controller=settings&extension=update" class="button"><i class="fa fa-cog"></i> Settings</a>
    </div>
    <div class="alert alert-<?php if (version_compare($version->numerical, $web_version->tag_name) < 0) { ?>danger<?php } else { ?>success<?php } ?>">You are running Bulletin CMS v<?php echo $version->numerical; ?> <?php if (version_compare($version->numerical, $web_version->tag_name) < 0) { ?> - [OUT OF DATE]<?php } ?></div>
    <?php if (version_compare($version->numerical, $web_version->tag_name) < 0) { ?>
        <p>&nbsp;</p>
        <h3>Release Information for <?php echo $web_version->name; ?></h3>
        <div class="new-version-notes">
            <?php echo $web_version->body; ?>
        </div>
        <h4>Update steps</h4>
        <ol>
            <li><a href="<?php echo $web_version->assets["0"]->browser_download_url; ?>" class="btn btn-primary">Download the v<?php echo $web_version->tag_name; ?> update package</a></li>
            <li>Extract the files using a program like Winrar</li>
            <li>Upload the contents of the UPLOAD folder to the root directory of your website</li>
            <li><a href="index.php?component=update&controller=database" class="btn btn-primary">Run the database updater tool</a></li>
        </ol>
    <?php } else { ?>
        <p>&nbsp;</p>
        <p>Looks like your Bulletin installation (v<?php echo $version->numerical; ?>) is up to date. You don't need to do anything!</p>
    <?php } ?>
</div>