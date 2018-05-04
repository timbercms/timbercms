<div class="login-container">
    <h1>Settings</h1>
    <?php if ($this->model->user->id > 0) { ?>
        <div class="settings-container">
            <h3>My Information</h3>
            <form action="<?php echo Core::route("index.php?component=user&controller=user&task=updateSettings"); ?>" method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                            <label><strong>Email Address:</strong></label>
                            <input type="email" class="form-control" name="email" value="<?php echo $this->model->user->email; ?>" />
                        </div>
                        <div class="form-group">
                            <label><strong>Password:</strong></label>
                            <input type="password" class="form-control" name="password" placeholder="(Only edit this if you wish to change your password)" />
                        </div>
                        <div class="form-group">
                            <label><strong>Verify Password:</strong></label>
                            <input type="password" class="form-control" name="password_verify" placeholder="(Only edit this if you wish to change your password)" />
                        </div>
                        <div class="form-group">
                            <label><strong>Profile Background:</strong></label>
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="header-preview topography<?php if ($this->model->user->params->header_pattern == "topography") { ?> active<?php } ?>" data-label><input type="radio" name="params[header_pattern]" value="topography"<?php if ($this->model->user->params->header_pattern == "topography") { ?>checked="checked"<?php } ?>></label>
                                </div>
                                <div class="col-md-3">
                                    <label class="header-preview jupiter<?php if ($this->model->user->params->header_pattern == "jupiter") { ?> active<?php } ?>" data-label><input type="radio" name="params[header_pattern]" value="jupiter"<?php if ($this->model->user->params->header_pattern == "jupiter") { ?>checked="checked"<?php } ?>></label>
                                </div>
                                <div class="col-md-3">
                                    <label class="header-preview jigsaw<?php if ($this->model->user->params->header_pattern == "jigsaw") { ?> active<?php } ?>" data-label><input type="radio" name="params[header_pattern]" value="jigsaw"<?php if ($this->model->user->params->header_pattern == "jigsaw") { ?>checked="checked"<?php } ?>></label>
                                </div>
                                <div class="col-md-3">
                                    <label class="header-preview piano<?php if ($this->model->user->params->header_pattern == "piano") { ?> active<?php } ?>" data-label><input type="radio" name="params[header_pattern]" value="piano"<?php if ($this->model->user->params->header_pattern == "piano") { ?>checked="checked"<?php } ?>></label>
                                </div>
                                <div class="col-md-3">
                                    <label class="header-preview hexagons<?php if ($this->model->user->params->header_pattern == "hexagons") { ?> active<?php } ?>" data-label><input type="radio" name="params[header_pattern]" value="hexagons"<?php if ($this->model->user->params->header_pattern == "hexagons") { ?>checked="checked"<?php } ?>></label>
                                </div>
                                <div class="col-md-3">
                                    <label class="header-preview food<?php if ($this->model->user->params->header_pattern == "food") { ?> active<?php } ?>" data-label><input type="radio" name="params[header_pattern]" value="food"<?php if ($this->model->user->params->header_pattern == "food") { ?>checked="checked"<?php } ?>></label>
                                </div>
                                <div class="col-md-3">
                                    <label class="header-preview anchors<?php if ($this->model->user->params->header_pattern == "anchors") { ?> active<?php } ?>" data-label><input type="radio" name="params[header_pattern]" value="anchors"<?php if ($this->model->user->params->header_pattern == "anchors") { ?>checked="checked"<?php } ?>></label>
                                </div>
                                <div class="col-md-3">
                                    <label class="header-preview bubbles<?php if ($this->model->user->params->header_pattern == "bubbles") { ?> active<?php } ?>" data-label><input type="radio" name="params[header_pattern]" value="bubbles"<?php if ($this->model->user->params->header_pattern == "bubbles") { ?>checked="checked"<?php } ?>></label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label><strong>Avatar:</strong></label>
                            <?php if (strlen($this->model->user->avatar) > 0) { ?>
                                <div class="settings-avatar">
                                    <p><img src="<?php echo $this->model->user->avatar; ?>" style="max-width: 40%;" /></p>
                                </div>
                            <?php } ?>
                            <p>Max image filesize: <strong>1MB</strong></p>
                            <input type="file" class="form-control" name="avatar" />
                        </div>
                        <button class="button" type="submit">Save</button>
                    </div>
                </div>
            </form>
        </div>
    <?php } else { ?>
        <div class="alert alert-danger">
            You must be logged in to access this feature
        </div>
    <?php } ?>
</div>