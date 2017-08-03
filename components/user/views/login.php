<div class="login-container">
    <form action="index.php?component=user&controller=user&task=login" method="post">
        <div class="frame">
            <div class="frame-3">
                <strong>Username:</strong>
            </div>
            <div class="frame-9">
                <input type="text" name="username" />
            </div>
        </div>
        <div class="frame">
            <div class="frame-3">
                <strong>Password:</strong>
            </div>
            <div class="frame-9">
                <input type="password" name="password" />
            </div>
        </div>
        <button type="submit" class="burgundy-button"><i class="fa fa-key"></i> Login</button>
        <div class="other-actions">
            <a href="<?php echo $this->route("index.php?component=user&controller=register"); ?>"><i class="fa fa-users"></i> Register</a><br />
            <a href="<?php echo $this->route("index.php?component=user&controller=requestreset"); ?>"><i class="fa fa-key"></i> Reset Password</a>
        </div>
    </form>
</div>