<!DOCTYPE html>
<html>
    <head>
        <title>404 - Page Not Found</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
        <link rel="stylesheet" href="<?php echo BASE_URL; ?>templates/<?php echo $this->template->name; ?>/css/error.css">
    </head>
    <body>
        <div class="error-container">
            <h1 class="error-header">404 - Page Not Found</h1>
            <p style="text-align: center;"><img src="<?php echo BASE_URL; ?>templates/<?php echo $this->template->name; ?>/images/error.gif" /></p>
            <p>Unfortunately, this page could not be found. It may have been moved, or may never have existed in the first place.</p>
            <p>You could try one of the following actions:</p>
            <ul>
                <li>Go back to the <a href="<?php echo BASE_URL; ?>">home page</a>.</li>
            </ul>
        </div>
    </body>
</html>