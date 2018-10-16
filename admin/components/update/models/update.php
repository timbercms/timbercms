<?php

    class UpdateModel extends Model
    {
        
        public $template = "update.php";
        public $database;
        public $settings;
        
        public function __construct($id = 0, $database)
        {
            $this->database = $database;
            $this->settings = simplexml_load_file(__DIR__ ."/../extension.xml");
        }
        
    }

?>