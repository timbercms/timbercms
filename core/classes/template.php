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
            if (strlen($component) == 0)
            {
                $component = $_GET["component"];
            }
            if (ADMIN)
            {
                Core::addStyleSheet("admin/components/". $component ."/assets/css/". $component .".css");
            }
            else
            {
                Core::addStyleSheet("components/". $component ."/assets/css/". $component .".css");
                if (file_exists("templates/". Core::template_name() ."/overrides/components/". $component ."/". $component .".css"))
                {
                    Core::addStyleSheet("templates/". Core::template_name() ."/overrides/components/". $component ."/". $component .".css");
                }
            }
        }
        
        public function addCriticalCSS()
        {
            Core::addStyleSheet("core/assets/critical.css");
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
                    $module = new ModuleModel($mod->id, $this->database);
                    if (file_exists(__DIR__ ."/../../templates/". Core::template_name() ."/overrides/modules/". $module->type ."/". $module->type .".css"))
                    {
                        Core::addStyleSheet("templates/". Core::template_name() ."/overrides/modules/". $module->type ."/". $module->type .".css");
                    }
                    else
                    {
                        Core::addStyleSheet("modules/". $module->type ."/". $module->type .".css");
                    }
                    if (file_exists(__DIR__ ."/../../templates/". Core::template_name() ."/overrides/modules/". $module->type ."/". $module->type .".js"))
                    {
                        Core::addScript("templates/". Core::template_name() ."/overrides/modules/". $module->type ."/". $module->type .".js");
                    }
                    else
                    {
                        Core::addScript("modules/". $module->type ."/". $module->type .".js");
                    }
                    require_once(__DIR__ ."/../../modules/". $module->type ."/worker.php");
                    $worker_string = $module->type."Worker";
                    $worker = new $worker_string($module, $this->database);
                    echo '<div class="module module-'. $module->id .'">';
                        if ($module->show_title)
                        {
                            echo '<h3 class="module-title">'. $module->title .'</h3>';
                        }
                        echo '<div class="module-inner">';
                            if (file_exists(__DIR__ ."/../../templates/". Core::template_name() ."/overrides/modules/". $module->type ."/template.php"))
                            {
                                require(__DIR__ ."/../../templates/". Core::template_name() ."/overrides/modules/". $module->type ."/template.php");
                            }
                            else
                            {
                                require(__DIR__ ."/../../modules/". $module->type ."/template.php");
                            }
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