<?php

    $version = simplexml_load_file(__DIR__ ."/../../../version.xml");
    $web_version = simplexml_load_file("https://raw.githubusercontent.com/timbercms/timbercms/master/admin/version.xml");

?>
<div class="white-card">
    <h2>Update your Timber CMS installation</h2>
    <div class="component-action-bar">
        <?php if (count($this->model->settings->fields) > 0) { ?><a href="index.php?component=settings&controller=settings&extension=update" class="button"><i class="fa fa-cog"></i> Settings</a><?php } ?>
    </div>
    <div class="alert alert-info">
        Current Supported Timber CMS Version: v<?php echo $web_version->numerical; ?>
    </div>
    <div class="alert alert-<?php if (version_compare($version->numerical, $web_version->numerical) < 0) { ?>danger<?php } else { ?>success<?php } ?>">You are running Timber CMS v<?php echo $version->numerical; ?> <?php if (version_compare($version->numerical, $web_version->numerical) < 0) { ?> - [OUT OF DATE]<?php } ?></div>
    <?php if (version_compare($version->numerical, $web_version->numerical) < 0) { ?>
        <p>&nbsp;</p>
        <h3>Release Information for v<?php echo $web_version->numerical; ?></h3>
        <div class="new-version-notes">
            <?php echo $web_version->new; ?>
        </div>
        <h4>Update steps</h4>
        <ol>
            <li><a href="<?php echo $web_version->packageURL; ?>" class="btn btn-primary">Download the v<?php echo $web_version->numerical; ?> update package</a></li>
            <li>Extract the files using a program like Winrar</li>
            <li>Upload the contents of the UPLOAD folder to the root directory of your website</li>
            <li><a href="index.php?component=update&controller=database" class="btn btn-primary">Run the database updater tool</a></li>
        </ol>
    <?php } else { ?>
        <p>&nbsp;</p>
        <p>Looks like your Bulletin installation (v<?php echo $version->numerical; ?>) is up to date. You don't need to do anything!</p>
    <?php } ?>
</div>