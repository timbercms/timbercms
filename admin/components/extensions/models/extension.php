<?php

    class ExtensionModel extends Model
    {
        public $component = "extensions";
        public $table = "components";
        public $template = "extension.php";
        public $database;
        
        public function __construct($id = 0, $database)
        {
            $this->database = $database;
            if ($id > 0)
            {
                $this->load($id);
            }
        }
        
        public function loadByName($name)
        {
            $temp = $this->database->loadObject("SELECT id FROM #__components WHERE internal_name = ?", array($name));
            if ($temp->id > 0)
            {
                $this->load($temp->id);
            }
        }
        
    }

?>