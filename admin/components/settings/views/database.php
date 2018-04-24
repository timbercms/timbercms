<div class="white-card">
    <h2>Database Validity Checker</h2>
    <div class="component-action-bar">
        <?php if (count($this->model->broken_tables) > 0) { ?><a href="index.php?component=settings&controller=database&task=fix" class="btn btn-primary"><i class="fas fa-wrench"></i> Repair Issues</a><?php } ?>
    </div>
    <div>
        <h3 style="margin-bottom: 40px;"><?php echo count($this->model->broken_tables); ?> Table<?php if (count($this->model->broken_tables) != 1) { ?>s have<?php } else { ?> has<?php } ?> an issue</h3>
        <?php foreach ($this->model->current_tables as $key => $table) { ?>
            <div class="system-message <?php if (in_array($key, $this->model->broken_tables)) { ?>danger<?php } else { ?>success<?php } ?>">
                <?php if (in_array($key, $this->model->broken_tables)) { ?>
                    <i class="fas fa-times" style="float: right;"></i>
                    <p><strong><?php echo $key; ?></strong></p>
                    <p>Missing Fields:</p>
                    <ul>
                        <?php foreach ($this->model->missing[$key] as $field) { ?>
                            <li><?php echo $field->name; ?></li>
                        <?php } ?>
                    </ul>
                <?php } else { ?>
                    <i class="fas fa-check" style="float: right;"></i>
                    <?php echo $key; ?>
                <?php } ?>
            </div>
        <?php } ?>
    </div>
</div>