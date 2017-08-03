<div class="register-container">
    <form action="index.php?component=user&controller=user&task=register" method="post">
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
                <strong>Real Name:</strong>
            </div>
            <div class="frame-9">
                <input type="text" name="real_name" />
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
        <div class="frame">
            <div class="frame-3">
                <strong>Password (again):</strong>
            </div>
            <div class="frame-9">
                <input type="password" name="password_again" />
            </div>
        </div>
        <div class="frame">
            <div class="frame-3">
                <strong>Email Address:</strong>
            </div>
            <div class="frame-9">
                <input type="email" name="email" />
            </div>
        </div>
        <button type="submit" class="burgundy-button"><i class="fa fa-users"></i> Register</button>
    </form>
</div>