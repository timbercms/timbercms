<?php

    class CompleteModel extends Model
    {
        
        public $template = "complete.php";
        public $database;
        
        public function __construct($id = 0, $database)
        {
            $this->database = $database;
        }
        
    }

?>