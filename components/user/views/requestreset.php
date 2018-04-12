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
        <button type="submit" class="button"><i class="fa fa-users"></i> Request Reset</button>
    </form>
</div>