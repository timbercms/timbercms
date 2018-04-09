<?php

    class AboutModel
    {
        
        public $template = "about.php";
        public $database;
        
        public function __construct($id = 0, $database)
        {
            $this->database = $database;
        }
        
    }

?>