<div class="white-card">
    <h2><?php echo (strlen($_GET["id"]) > 0 ? "Change" : "New"); ?> Menu Item</h2>
    <div class="component-action-bar">
        <a href="index.php?component=menu&controller=menuitems&id=<?php echo $_GET["menu_id"]; ?>" class="button"><i class="fa fa-chevron-left"></i> Back to List</a>
    </div>
    <div class="component-list">
        <?php foreach ($this->model->components as $key => $component) { ?>
            <div class="component-item">
                <div class="component-title">
                    <?php echo $key; ?>
                </div>
                <div class="component-controllers">
                    <?php foreach ($component as $controller) { ?>
                        <div class="component-controller">
                            <p><strong><?php echo $controller->name; ?></strong></p>
                            <p><?php echo $controller->description; ?></p>
                            <a href="index.php?component=menu&controller=menuitem<?php echo (strlen($_GET["id"]) > 0 ? "&overwrite=1&id=". $_GET["id"] : ""); ?>&menu_id=<?php echo $_GET["menu_id"]; ?>&comp=<?php echo $controller->component; ?>&cont=<?php echo $controller->value; ?>" class="button">Select</a>
                        </div>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>
    </div>
</div>