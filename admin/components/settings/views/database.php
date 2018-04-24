<div class="white-card">
    <h2>Database Validity Checker</h2>
    <div class="component-action-bar">
        <?php if (count($this->model->broken_tables) > 0) { ?><a href="index.php?component=settings&controller=database&task=fix" class="btn btn-primary"><i class="fas fa-wrench"></i> Repair Issues</a><?php } ?>
    </div>
    <div>
        <h4 style="margin-bottom: 10px;"><?php echo count($this->model->broken_tables); ?> Core Table<?php if (count($this->model->broken_tables) != 1) { ?>s have<?php } else { ?> has<?php } ?> missing fields</h4>
        <h4 style="margin-bottom: 40px;"><?php echo count($this->model->extra_tables); ?> Core Table<?php if (count($this->model->extra_tables) != 1) { ?>s have<?php } else { ?> has<?php } ?> extra fields</h4>
        <?php foreach ($this->model->current_tables as $key => $table) { ?>
            <div class="system-message <?php if (in_array($key, $this->model->broken_tables)) { ?>danger<?php } else if (in_array($key, $this->model->extra_tables)) { ?>warning<?php } else { ?>success<?php } ?>">
                <?php if (in_array($key, $this->model->broken_tables)) { ?>
                    <i class="fas fa-times" style="float: right;"></i>
                    <p><strong><?php echo $key; ?></strong></p>
                    <p>Missing Fields:</p>
                    <ul>
                        <?php foreach ($this->model->missing[$key] as $field) { ?>
                            <li><?php echo $field->name; ?></li>
                        <?php } ?>
                    </ul>
                <?php } ?>
                <?php if (in_array($key, $this->model->extra_tables)) { ?> 
                    <?php if (!in_array($key, $this->model->broken_tables)) { ?>
                        <i class="fas fa-times" style="float: right;"></i>
                        <p><strong><?php echo $key; ?></strong></p>
                    <?php } ?>
                    <p>Extra Fields:</p>
                    <ul>
                        <?php foreach ($this->model->extra[$key] as $field) { ?>
                            <li><?php echo $field->name; ?> - <a href="index.php?component=settings&controller=database&task=remove&table=<?php echo $key; ?>&column=<?php echo $field->name; ?>" class="btn btn-primary btn-sm">Remove this field</a></li>
                        <?php } ?>
                    </ul>
                <?php } ?>
                <?php if (!in_array($key, $this->model->broken_tables) && !in_array($key, $this->model->extra_tables)) { ?>
                    <i class="fas fa-check" style="float: right;"></i>
                    <?php echo $key; ?>
                <?php } ?>
            </div>
        <?php } ?>
    </div>
</div>