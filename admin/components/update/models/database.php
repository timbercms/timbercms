<?php

    class DatabaseModel extends Model
    {
        
        public $template = "database.php";
        public $database;
        
        public function __construct($id = 0, $database)
        {
            $this->database = $database;
        }
        
    }

?>