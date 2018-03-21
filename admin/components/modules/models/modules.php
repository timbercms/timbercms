<?php

    require_once(__DIR__ ."/module.php");

    class ModulesModel
    {
        
        public $template = "modules.php";
        public $database;
        public $positions = array();
        
        public $modules = array();
        
        public function __construct($id = 0, $database)
        {
            $this->database = $database;
            $this->load();
        }
        
        public function load()
        {
            $args = array();
            $query = "SELECT id FROM #__modules";
            if (strlen($_GET["position"]) > 0)
            {
                $query .= " WHERE position = ? ORDER BY ordering";
                $args[] = $_GET["position"];
            }
            $temp = $this->database->loadObjectList($query, $args);
            foreach ($temp as $temp_module)
            {
                $module = new ModuleModel($temp_module->id, $this->database);
                $this->modules[] = $module;
            }
            $xml = simplexml_load_file(BASE_DIR ."/../templates/". Core::config()->default_template ."/template.xml");
            foreach ($xml->position as $position)
            {
                $this->positions[] = $position;
            }
        }
        
    }

?>