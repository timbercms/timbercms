<div class="white-card">
    <h2>Discover Extensions</h2>
    <div class="component-action-bar">
    </div>
    <div class="d-flex admin-header">
        <div class="col-md-3"><strong>Title</strong></div>
        <div class="col-md-3"><strong>Description</strong></div>
        <div class="col-md-3"><strong>Author</strong></div>
        <div class="col-md-2"><strong>Version</strong></div>
        <div class="col-md-1"></div>
    </div>
    <?php foreach ($this->model->new_components as $component) { ?>
        <?php $xml = simplexml_load_file(__DIR__ ."/../../". $component ."/extension.xml"); ?>
        <div class="d-flex admin-list align-items-center">
            <div class="col-md-3">
                <?php echo $xml->title; ?>
            </div>
            <div class="col-md-3">
                <?php echo $xml->description; ?>
            </div>
            <div class="col-md-3">
                <?php echo $xml->author; ?><br />
                <a href="<?php echo $xml->author_url; ?>" target="_blank"><?php echo $xml->author_url; ?></a>
            </div>
            <div class="col-md-2">
                <?php echo $xml->version; ?>
            </div>
            <div class="col-md-1">
                <a href="index.php?component=extensions&controller=discover&task=install&extension=<?php echo $component; ?>" class="btn btn-success">Install</a>
            </div>
        </div>
    <?php } ?>
</div>