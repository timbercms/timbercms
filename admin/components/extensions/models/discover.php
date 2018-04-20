<?php

    class DiscoverModel extends Model
    {
        
        public $template = "discover.php";
        public $database;
        
        public $new_components = array();
        public $new_hooks = array();
        public $new_modules = array();
        
        public function __construct($id = 0, $database)
        {
            $this->database = $database;
            $this->loadNewComponents();
            $this->loadNewHooks();
            $this->loadNewModules();
        }
        
        public function loadNewComponents()
        {
            $dirs = scandir(__DIR__ ."/../../");
            unset($dirs["0"], $dirs["1"]);
            foreach ($dirs as $dir)
            {
                $test = $this->database->loadObject("SELECT id FROM #__components WHERE internal_name = ?", array($dir));
                if ($test->id <= 0)
                {
                    $this->new_components[] = $dir;
                }
            }
        }
        
        public function loadNewHooks()
        {
            $files = scandir(__DIR__ ."/../../../../hooks");
            unset($files["0"], $files["1"]);
            foreach ($files as $file)
            {
                $hook_name = explode(".", $file)["0"];
                if (strtolower(explode(".", $file)["1"]) == "php")
                {
                    $test = $this->database->loadObject("SELECT id FROM #__components_hooks WHERE component_name = ?", array($hook_name));
                    if ($test->id <= 0)
                    {
                        $this->new_hooks[] = $hook_name;
                    }
                }
            }
        }
        
        public function loadNewModules()
        {
            $dirs = scandir(__DIR__ ."/../../../../modules");
            unset($dirs["0"], $dirs["1"]);
            foreach ($dirs as $dir)
            {
                $test = $this->database->loadObject("SELECT id FROM #__components_modules WHERE internal_name = ?", array($dir));
                if ($test->id <= 0)
                {
                    $this->new_modules[] = $dir;
                }
            }
        }
        
    }

?>