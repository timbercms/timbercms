<?php

    #=======================================================================================
    # * Bulletin. CMS
    # --------------------------------------------------------------------------------------
    # * GNU General Public License (GPL) (https://opensource.org/licenses/GPL-3.0)
    # * https://www.github.com/Smith0r
    #=======================================================================================

?>
<?php

    class Template
    {
        public $template = "default";
        public $database;
        public $page_title = "Bulletin. CMS";
        public $meta_description = "Bulletin. CMS - A free, Open Source CMS";
        public $view;
        
        public function __construct($database, $view)
        {
            $this->database = $database;
            $this->view = $view;
        }
        
        public function display()
        {
            require_once(__DIR__ ."/../templates/". $this->template ."/index.php");
        }
    }

?>