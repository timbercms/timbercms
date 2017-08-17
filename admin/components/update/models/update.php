<?php

    class UpdateModel extends Model
    {
        
        public $template = "update.php";
        public $database;
        
        public function __construct($id = 0, $database)
        {
            $this->database = $database;
            if ($id > 0)
            {
                $this->load($id);
            }
        }
        
    }

?>