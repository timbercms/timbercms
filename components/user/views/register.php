<div class="register-container">
    <h1 class="component-title">Register an account</h1>
    <form action="<?php echo $this->route("index.php?component=user&controller=user&task=register"); ?>" method="post">
        <div class="form-group">
            <label><strong>Username:</strong></label>
            <input type="text" name="username" class="form-control" required />
        </div>
        <div class="form-group">
            <label><strong>Password:</strong></label>
            <input type="password" name="password" class="form-control" required />
        </div>
        <div class="form-group">
            <label><strong>Password (again):</strong></label>
            <input type="password" name="password_again" class="form-control" required />
        </div>
        <div class="form-group">
            <label><strong>Email Address:</strong></label>
            <input type="email" name="email" class="form-control" required />
        </div>
        <?php if (Core::config()->enable_recaptcha == 1) { ?>
            <div class="g-recaptcha" data-sitekey="<?php echo Core::config()->recaptcha_site; ?>" style="margin-bottom: 20px;"></div>
        <?php } ?>
        <button type="submit" class="button"><i class="fa fa-users"></i> Register</button>
    </form>
</div>