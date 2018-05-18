<div class="contact-form">
    <h1 class="component-title">Contact Form</h1>
    <form action="<?php echo Core::route("index.php?component=contact&controller=enquiry&task=send"); ?>" method="post">
        <div class="form-group">
            <label>Your name: *</label>
            <input type="text" placeholder="Enter your name" class="form-control" name="name" required>
        </div>
        <div class="form-group">
            <label>Your email: *</label>
            <input type="email" placeholder="Enter your email address" class="form-control" name="email" required>
        </div>
        <div class="form-group">
            <label>Your message: *</label>
            <textarea type="text" class="form-control" name="content" rows="15" required></textarea>
        </div>
        <?php if (Core::config()->enable_recaptcha == 1) { ?>
            <div class="g-recaptcha" data-sitekey="<?php echo Core::config()->recaptcha_site; ?>" style="margin-bottom: 20px;"></div>
        <?php } ?>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>