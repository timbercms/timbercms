<?php

    #=======================================================================================
    # * Bulletin. CMS
    # --------------------------------------------------------------------------------------
    # * GNU General Public License (GPL) (https://opensource.org/licenses/GPL-3.0)
    # * https://www.github.com/Smith0r
    #=======================================================================================

?>
<?php

    class Configuration
    {
        public $database_host;
        public $database_name;
        public $database_user;
        public $database_password;
        public $database_prefix;
        
        public function __construct()
        {
            $this->database_host = "localhost";
            $this->database_name = "bulletin";
            $this->database_user = "root";
            $this->database_password = "";
            $this->database_prefix = "bul_";
        }
    }

?>