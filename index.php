<?php

    session_start();
    if (file_exists(__DIR__ ."/installer/index.php") && !file_exists(__DIR__ ."/core/installer.lock"))
    {
        header('Location: installer/');
    }
    else
    {
        ob_start();
        require_once("core/classes/core.php");
        $core = new Core();
        $page = ob_get_contents();
        ob_clean();
        $page = $core->finalise($page);
        ob_end_flush();
    }

?>