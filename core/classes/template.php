<?php

    class Template extends Core
    {
        
        public $name;
        public $database;
        
        public function __construct($database)
        {
            $this->name = "default";
            $this->database = $database;
        }
        
        public function addComponentStylesheet($component = "")
        {
            if (strlen($component) == 0)
            {
                $component = $_GET["component"];
            }
            Core::addStylesheet("components/". $component ."/assets/". $component .".css");
        }
        
        public function displayModules($position)
        {
            if (strlen($position) > 0)
            {
                $modules = $this->database->loadObjectList("SELECT id FROM #__modules WHERE published = '1' AND position = ? AND (pages = '0' OR find_in_set(?, pages)) ORDER BY ordering ASC", array($position, Core::menu_item_id()));
                foreach ($modules as $mod)
                {
                    $module = new ModuleModel($mod->id, $this->database);
                    require_once(__DIR__ ."/../../modules/". $module->type ."/worker.php");
                    $worker_string = $module->type."Worker";
                    $worker = new $worker_string($module, $this->database);
                    echo '<div class="module module-'. $module->id .'">';
                        echo '<h3 class="module-title">'. $module->title .'</h3>';
                        echo '<div class="module-inner">';
                            require_once(__DIR__ ."/../../modules/". $module->type ."/template.php");
                        echo '</div>';
                    echo '</div>';
                }
            }
        }
        
    }

?>