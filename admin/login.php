<!DOCTYPE html>
<html>
    <head>
        <title>Timber CMS Login</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
        <link rel="stylesheet" href="<?php echo BASE_URL; ?>core/assets/critical.css">
        <link rel="stylesheet" href="<?php echo BASE_URL; ?>core/assets/admin-login.css">
    </head>
    <body>
        <div class="login-container">
            <h1>Admin Login</h1>
            <?php Core::displaySystemMessages(); ?>
            <form action="index.php?component=user&controller=user&task=login" method="post">
                <input type="text" name="username" placeholder="Username">
                <input type="password" name="password" placeholder="Password">
                <button type="submit">Login</button>
            </form>
        </div>
    </body>
</html>