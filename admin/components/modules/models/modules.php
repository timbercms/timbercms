<?php

    require_once(__DIR__ ."/module.php");

    class ModulesModel
    {
        
        public $template = "modules.php";
        public $database;
        
        public $modules = array();
        
        public function __construct($id = 0, $database)
        {
            $this->database = $database;
            $this->load();
        }
        
        public function load()
        {
            $temp = $this->database->loadObjectList("SELECT id FROM #__modules");
            foreach ($temp as $temp_module)
            {
                $module = new ModuleModel($temp_module->id, $this->database);
                $this->modules[] = $module;
            }
        }
        
    }

?>