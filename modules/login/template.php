<div class="login-module">
    <?php if (Core::user()->id > 0) { ?>
        <div class="logged-in-user">
            <div class="login-avatar">
                <img src="<?php echo Core::user()->avatar; ?>" />
            </div>
            <div class="login-username">
                <?php echo Core::user()->username; ?>
            </div>
            <ul class="login-options">
                <li><a href="<?php echo Core::route("index.php?component=user&controller=profile&id=". Core::user()->id); ?>">My Profile</a></li>
                <li><a href="<?php echo Core::route("index.php?component=user&controller=settings"); ?>">Settings</a></li>
                <?php if (Core::user()->usergroup->is_admin == 1) { ?>
                    <li><a href="<?php echo BASE_URL; ?>admin">Admin Panel</a></li>
                <?php } ?>
                <li><a href="<?php echo Core::route("index.php?component=user&controller=user&task=logout"); ?>">Logout</a></li>
            </ul>
        </div>
    <?php } else { ?>
        <form action="<?php echo $this->route("index.php?component=user&controller=user&task=login"); ?>" method="post">
            <div class="row form-group">
                <label class="col-md-3 col-form-label">Username:</label>
                <div class="col-md-9">
                    <input type="text" name="username" class="form-control" />
                </div>
            </div>
            <div class="row form-group">
                <label class="col-md-3 col-form-label">Password:</label>
                <div class="col-md-9">
                    <input type="password" name="password" class="form-control" />
                    <p style="text-align: right;">
                        <a href="<?php echo Core::route("index.php?component=user&controller=requestreset"); ?>">Forgotten password?</a>
                    </p>
                </div>
            </div>
            <button type="submit" class="button pull-right"><i class="fa fa-key"></i> Login</button> <a href="<?php echo $this->route("index.php?component=user&controller=register"); ?>" class="button hollow pull-right">Don't have an account?</a>
            <div class="clearfix"></div>
        </form>
    <?php } ?>
</div>