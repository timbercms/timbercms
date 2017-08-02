<?php

    #=======================================================================================
    # * Bulletin. CMS
    # --------------------------------------------------------------------------------------
    # * GNU General Public License (GPL) (https://opensource.org/licenses/GPL-3.0)
    # * https://www.github.com/Smith0r
    #=======================================================================================

?>
<?php

    ini_set("display_errors", "1");
    error_reporting(E_ERROR | E_WARNING | E_PARSE);
    require_once(__DIR__ ."/classes/core.php");

    $core = new Core();
    $core->database->close();

?>