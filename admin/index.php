<?php

    session_start();
    ini_set("display_errors", "1");
    error_reporting(E_ALL & ~E_NOTICE);
    ob_start();
    
    require_once(__DIR__ ."/classes/core.php");
    $core = new Core();

    ob_end_flush();

?>