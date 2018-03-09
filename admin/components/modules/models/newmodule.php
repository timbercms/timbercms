<?php

    class NewModuleModel extends Model
    {
        
        public $template = "newmodule.php";
        public $database;
        
        public $module_types;
        
        public function __construct($id = 0, $database)
        {
            $this->database = $database;
            $this->loadTypes();
        }
        
        public function loadTypes()
        {
            $this->module_types = $this->database->loadObjectList("SELECT * FROM #__components_modules");
        }
        
    }

?>