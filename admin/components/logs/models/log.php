<?php

    class LogModel extends Model
    {
        public $component_name = "logs";
        public $table = "logs";
        public $template = "log.php";
        public $database;
        
        public function __construct($id = 0, $database)
        {
            $this->database = $database;
            if ($id > 0)
            {
                $this->load($id);
            }
        }
        
        public function processData()
        {
            $this->author = new UserModel($this->event_author, $this->database);
        }
        
    }

?>