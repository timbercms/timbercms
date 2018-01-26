<?php

    session_start();
    ini_set("display_errors", "1");
    error_reporting(E_ALL & ~E_NOTICE);
    define("ADMIN", true);
    define("BASE_DIR", __DIR__);
    ob_start();
    
    require_once(__DIR__ ."/../core/classes/core.php");
    $core = new Core();

    $page = ob_get_contents();
    ob_clean();
    $page = $core->finalise($page);
    ob_end_flush();

?>