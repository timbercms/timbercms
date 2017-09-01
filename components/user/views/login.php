<div class="login-container">
    <form action="index.php?component=user&controller=user&task=login" method="post">
        <div class="row">
            <div class="col-md-3">
                <strong>Username:</strong>
            </div>
            <div class="col-md-9">
                <input type="text" name="username" />
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <strong>Password:</strong>
            </div>
            <div class="col-md-9">
                <input type="password" name="password" />
            </div>
        </div>
        <button type="submit" class="button"><i class="fa fa-key"></i> Login</button> <a href="<?php echo $this->route("index.php?component=user&controller=register"); ?>" class="button"><i class="fa fa-users"></i> Register</a> <a href="<?php echo $this->route("index.php?component=user&controller=requestreset"); ?>" class="button"><i class="fa fa-key"></i> Reset Password</a>
        </div>
    </form>
</div>