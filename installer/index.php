<?php

    session_start();
    ini_set("display_errors", "1");
    error_reporting(E_ALL & ~E_NOTICE);
    require_once(__DIR__ ."/../configuration.php");
    require_once(__DIR__ ."/../core/classes/database.php");
    $db = new Database();

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Bulletin. Installer</title>
        <link rel="stylesheet" type="text/css" href="../templates/default/css/bootstrap.min.css" />
        <link rel="stylesheet" type="text/css" href="installer.css" />
    </head>
    <body>
        <div class="header-container">
            <span class="title">Bulletin. Installer</span><span class="subtitle">v1.0.0-alpha</span>
        </div>
        <div class="body-container">
            <?php if ($_GET["stage"] == 0 || strlen($_GET["stage"]) == 0) { ?>
                <h1>Database Connection</h1>
                <?php if ($_GET["error"] == 1) { ?>
                    <div class="alert alert-danger" style="margin-bottom: 40px;">
                        Failed to establish a connection to the database. Please check your settings and try again.
                    </div>
                <?php } ?>
                <form action="index.php?stage=1" method="post">
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">Database Host</label>
                        <div class="col-md-9">
                            <input type="text" name="db_host" value="localhost" class="form-control" />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">Database Name</label>
                        <div class="col-md-9">
                            <input type="text" name="db_name" value="" class="form-control" />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">Database Username</label>
                        <div class="col-md-9">
                            <input type="text" name="db_username" value="" class="form-control" />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">Database Password</label>
                        <div class="col-md-9">
                            <input type="password" name="db_password" value="" class="form-control" />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">Database Prefix</label>
                        <div class="col-md-9">
                            <input type="text" name="db_prefix" value="" class="form-control" />
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary float-right">Next Stage ></button>
                    <div class="clearfix"></div>
                </form>
            <?php } else if ($_GET["stage"] == 1) { ?>
                <?php
                    if ($db->connect($_POST["db_host"], $_POST["db_name"], $_POST["db_username"], $_POST["db_password"]))
                    {
                        $config_string = '<?php
    define("DATABASE_HOST", "'. $_POST["db_host"] .'");
    define("DATABASE_USER", "'. $_POST["db_username"] .'");
    define("DATABASE_PASSWORD", "'. $_POST["db_password"] .'");
    define("DATABASE_NAME", "'. $_POST["db_name"] .'");
    define("DATABASE_PREFIX", "'. $_POST["db_prefix"] .'_");
    define("BASE_URL", "https://localhost/bulletin/");

?>';

                        $file = fopen("configuration.php", "w");
                        fwrite($file, $config_string);
                        fclose($file);
                    }
                    else
                    {
                        header("Location: index.php?stage=0&error=1");
                    }
                ?>
            <?php } ?>
        </div>
    </body>
</html>