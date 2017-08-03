<?php

    class RequestResetModel extends Model
    {
        
        public $template = "requestreset.php";
        public $database;
        
        public function __construct($id = 0, $database)
        {
            $this->database = $database;
        }
        
    }

?>