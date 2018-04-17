<?php

    class SettingsModel extends Model
    {
        
        public $template = "settings.php";
        public $database;
        
        public $user;
        
        public function __construct($id = 0, $database)
        {
            $this->database = $database;
            $this->user = Core::user();
        }
        
    }

?>