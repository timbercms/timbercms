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
<div class="white-card">
    <h2>Update your Bulletin installation</h2>
    <div class="component-action-bar">
        <a href="index.php?component=settings&controller=settings&extension=update"><i class="fa fa-cog"></i> Settings</a>
    </div>
    <?php if (version_compare($version->numerical, $web_version->tag_name)) { ?>
        <p>&nbsp;</p>
        <h3>Release Information for <?php echo $web_version->name; ?></h3>
        <div class="new-version-notes">
            <?php echo $web_version->body; ?>
        </div>
        <h4>Update steps</h4>
        <ol>
            <li>Download the v<?php echo $web_version->tag_name; ?> update package <a href="<?php echo $web_version->assets["0"]->browser_download_url; ?>">here</a>.</li>
            <li>Extract the files using a program like Winrar</li>
            <li>Upload the contents of the UPLOAD folder to the root directory of your website</li>
            <li>Run the database updater tool <a href="index.php?component=update&controller=database">here</a>.</li>
        </ol>
    <?php } else { ?>
        <p>&nbsp;</p>
        <p>Looks like your Bulletin installation (v<?php echo $version->numerical; ?>) is up to date. You don't need to do anything!</p>
    <?php } ?>
</div>