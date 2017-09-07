<?php

    session_start();
    ini_set("display_errors", "1");
    error_reporting(E_ALL & ~E_NOTICE);
    require_once(__DIR__ ."/../configuration.php");
    require_once("core/classes/database.php");
    $db = new Database();

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Bulletin. Installer</title>
        <link rel="stylesheet" type="text/css" href="installer.css" />
    </head>
    <body>
        The content of the document......
    </body>
</html>