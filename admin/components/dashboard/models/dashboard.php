<?php

    class DashboardModel
    {
        
        public $template = "dashboard.php";
        public $database;
        
        public function __construct($id = 0, $database)
        {
            $this->database = $database;
        }
        
    }

?>