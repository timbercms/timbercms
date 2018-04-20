<div class="login-container">
    <h1>Login to your account</h1>
    <div class="row">
        <div class="col-md-6">
            <form action="<?php echo $this->route("index.php?component=user&controller=user&task=login"); ?>" method="post">
                <div class="form-group">
                    <label class="col-form-label"><strong>Username:</strong></label>
                    <input type="text" name="username" class="form-control" required />
                </div>
                <div class="form-group">
                    <label class="col-form-label"><strong>Password:</strong></label>
                    <input type="password" name="password" class="form-control" required />
                </div>
                <div class="form-group form-check" style="margin-bottom: 40px;">
                    <input type="checkbox" class="form-check-input" name="remember" style="margin-top: .2rem;">
                    <label class="form-check-label">Remember me</label>
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