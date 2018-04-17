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
                            <label><strong>Avatar:</strong></label>
                            <?php if (strlen($this->model->user->avatar) > 0) { ?>
                                <div class="settings-avatar">
                                    <p><img src="<?php echo $this->model->user->avatar; ?>" style="max-width: 40%;" /></p>
                                </div>
                            <?php } ?>
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