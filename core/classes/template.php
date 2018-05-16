<?php

    class Template extends Core
    {
        
        public $name;
        public $database;
        
        public function __construct($database, $name)
        {
            $this->database = $database;
            if (strlen($name) <= 0)
            {
                $name = "default";
            }
            $this->name = $name;
        }
        
        public function addComponentStylesheet($component = "")
        {
            $admin = "";
            if (ADMIN)
            {
                $admin = "admin/";
            }
            if (strlen($component) == 0)
            {
                $component = $_GET["component"];
            }
            if (file_exists(__DIR__ ."/../../". $admin ."components/". $component ."/assets/css/". $component .".css"))
            {
                Core::addStylesheet($admin. "components/". $component ."/assets/css/". $component .".css");
            }
        }
        
        public function addComponentScript($component = "")
        {
            $admin = "";
            if (ADMIN)
            {
                $admin = "admin/";
            }
            if (strlen($component) == 0)
            {
                $component = $_GET["component"];
            }
            if (file_exists(__DIR__ ."/../../". $admin ."components/". $component ."/assets/js/". $component .".js"))
            {
                Core::addScript($admin. "components/". $component ."/assets/js/". $component .".js");
            }
        }
        
        public function displayModules($position)
        {
            if (strlen($position) > 0)
            {
                $modules = $this->database->loadObjectList("SELECT id FROM #__modules WHERE published = '1' AND position = ? AND (pages = '0' OR find_in_set(?, pages)) ORDER BY ordering ASC", array($position, Core::menu_item_id()));
                foreach ($modules as $mod)
                {
                    Core::addStyleSheet("modules/". $module->type ."/". $module->type .".css");
                    $module = new ModuleModel($mod->id, $this->database);
                    require_once(__DIR__ ."/../../modules/". $module->type ."/worker.php");
                    $worker_string = $module->type."Worker";
                    $worker = new $worker_string($module, $this->database);
                    echo '<div class="module module-'. $module->id .'">';
                        if ($module->show_title)
                        {
                            echo '<h3 class="module-title">'. $module->title .'</h3>';
                        }
                        echo '<div class="module-inner">';
                            require(__DIR__ ."/../../modules/". $module->type ."/template.php");
                        echo '</div>';
                    echo '</div>';
                }
            }
        }
        
        public function hasModules($position)
        {
            $results = $this->database->loadObjectList("SELECT id FROM #__modules WHERE (pages = '0' OR FIND_IN_SET(?, pages)) AND position = ?", array(Core::menu_item_id(), $position));
            return (count($results) > 0 ? true : false);
        }
        
    }

?>