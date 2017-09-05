<?php

    $version = simplexml_load_file(__DIR__ ."/../../../version.xml");
    $web_version = simplexml_load_file("https://raw.githubusercontent.com/Smith0r/bulletin/master/admin/version.xml", null, LIBXML_NOCDATA);

?>
<div class="card">
    <h2>Update your Bulletin installation</h2>
    <div class="action-bar">
        <a href="index.php?component=settings&controller=settings&extension=update"><i class="fa fa-cog"></i> Settings</a>
    </div>
    <?php if (version_compare($version->numerical, $web_version->numerical)) { ?>
        <p>&nbsp;</p>
        <h3>What's new in this version?</h3>
        <div class="new-version-notes">
            <?php echo $web_version->new; ?>
        </div>
        <p style="text-align: center;"><a href="" class="btn btn-success btn-lg">UPDATE TO VERSION <?php echo $version->numerical; ?></a></p>
    <?php } else { ?>
        <p>&nbsp;</p>
        <p>Looks like your Bulletin installation (v<?php echo $version->numerical; ?>) is up to date. You don't need to do anything!</p>
    <?php } ?>
</div>