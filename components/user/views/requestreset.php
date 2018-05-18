<div class="reset-container">
    <h1 class="component-title">Request password reset</h1>
    <form action="index.php?component=user&controller=requestreset&task=reset" method="post">
        <div class="frame">
            <div class="frame-3">
                <strong>Email Address:</strong>
            </div>
            <div class="frame-9">
                <input type="text" name="email" required />
            </div>
        </div>
        <?php if (Core::config()->enable_recaptcha == 1) { ?>
            <div class="g-recaptcha" data-sitekey="<?php echo Core::config()->recaptcha_site; ?>" style="margin-bottom: 20px;"></div>
        <?php } ?>
        <button type="submit" class="button"><i class="fa fa-users"></i> Request Reset</button>
    </form>
</div>