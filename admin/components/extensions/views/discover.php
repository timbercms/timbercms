<div class="white-card">
    <h2>Discover Extensions</h2>
    <div class="component-action-bar">
    </div>
    <?php if (count($this->model->new_components) > 0) { ?>
        <h3>Components</h3>
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
                    <a href="index.php?component=extensions&controller=discover&task=installComponent&extension=<?php echo $component; ?>" class="btn btn-success">Install</a>
                </div>
            </div>
        <?php } ?>
    <?php } ?>
    <?php if (count($this->model->new_modules) > 0) { ?>
        <h3>Modules</h3>
        <div class="d-flex admin-header">
            <div class="col-md-3"><strong>Title</strong></div>
            <div class="col-md-3"><strong>Description</strong></div>
            <div class="col-md-3"><strong>Author</strong></div>
            <div class="col-md-2"><strong>Version</strong></div>
            <div class="col-md-1"></div>
        </div>
        <?php foreach ($this->model->new_modules as $module) { ?>
            <?php $xml = simplexml_load_file(__DIR__ ."/../../../../modules/". $module ."/module.xml"); ?>
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
                    <a href="index.php?component=extensions&controller=discover&task=installModule&module=<?php echo $module; ?>" class="btn btn-success">Install</a>
                </div>
            </div>
        <?php } ?>
    <?php } ?>
    <?php if (count($this->model->new_hooks) > 0) { ?>
        <h3>Hooks</h3>
        <div class="d-flex admin-header">
            <div class="col-md-3"><strong>Title</strong></div>
            <div class="col-md-3"><strong>Description</strong></div>
            <div class="col-md-3"><strong>Author</strong></div>
            <div class="col-md-2"><strong>Version</strong></div>
            <div class="col-md-1"></div>
        </div>
        <?php foreach ($this->model->new_hooks as $hook) { ?>
            <?php $xml = simplexml_load_file(__DIR__ ."/../../../../hooks/". $hook .".xml"); ?>
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
                    <a href="index.php?component=extensions&controller=discover&task=installHook&hook=<?php echo $hook; ?>" class="btn btn-success">Install</a>
                </div>
            </div>
        <?php } ?>
    <?php } ?>
</div>