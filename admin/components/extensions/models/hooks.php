<?php

    require_once(__DIR__ ."/hook.php");

    class HooksModel
    {
        
        public $template = "hooks.php";
        public $database;
        
        public $hooks = array();
        public $settings;
        
        public function __construct($id = 0, $database)
        {
            $this->database = $database;
            $this->load();
            $this->settings = simplexml_load_file(__DIR__ ."/../extension.xml");
        }
        
        public function load()
        {
            $temp_hooks = $this->database->loadObjectList("SELECT id FROM #__components_hooks");
            foreach ($temp_hooks as $temp_hook)
            {
                $hook = new HookModel($temp_hook->id, $this->database);
                $this->hooks[] = $hook;
            }
        }
        
    }

?>