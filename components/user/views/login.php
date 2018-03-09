<div class="login-container">
    <h1>Login to your account</h1>
    <div class="row">
        <div class="col-md-6">
            <form action="<?php echo $this->route("index.php?component=user&controller=user&task=login"); ?>" method="post">
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Username:</label>
                    <div class="col-sm-10">
                        <input type="text" name="username" class="form-control" />
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Password:</label>
                    <div class="col-sm-10">
                        <input type="password" name="password" class="form-control" />
                    </div>
                </div>
                <button type="submit" class="button pull-right"><i class="fa fa-key"></i> Login</button>
                <div class="clearfix"></div>
                <ul class="login-options">
                    <li><a href="<?php echo $this->route("index.php?component=user&controller=register"); ?>"><i class="fa fa-users"></i> Register</a></li>
                    <li><a href="<?php echo $this->route("index.php?component=user&controller=requestreset"); ?>"><i class="fa fa-key"></i> Reset Password</a></li>
                </ul>
            </form>
        </div>
    </div>
</div>