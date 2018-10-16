<?php

    require_once(__DIR__ ."/module.php");

    class ModulesModel extends Model
    {
        
        public $template = "modules.php";
        public $database;
        public $positions = array();
        public $pagination;
        
        public $modules = array();
        public $settings;
        
        public function __construct($id = 0, $database)
        {
            $this->database = $database;
            $this->load();
            $this->settings = simplexml_load_file(__DIR__ ."/../extension.xml");
            $this->pagination = new Pagination();
        }
        
        public function load($id = false)
        {
            $args = array();
            $query = "SELECT id FROM #__modules";
            if (strlen($_GET["position"]) > 0)
            {
                $query .= " WHERE position = ? ORDER BY ordering";
                $args[] = $_GET["position"];
            }
            $this->max = count($this->database->loadObjectList($query));
            $query .= " LIMIT ". ($_GET["p"] > 0 ? (($_GET["p"] - 1) * 20) : 0) .", 20";
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