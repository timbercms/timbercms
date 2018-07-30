<?php

    class ContributorsModel
    {
        
        public $template = "contributors.php";
        public $database;
        
        public function __construct($id = 0, $database)
        {
            $this->database = $database;
        }
        
    }

?>