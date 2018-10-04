<?php

    require_once(__DIR__ ."/extension.php");

    class ExtensionsModel extends Model
    {
        
        public $template = "extensions.php";
        public $database;
        
        public $extensions = array();
        public $settings;
        
        public function __construct($id = 0, $database)
        {
            $this->database = $database;
            $this->load();
            $this->settings = simplexml_load_file(__DIR__ ."/../extension.xml");
        }
        
        public function load($id = false)
        {
            $temp_exts = $this->database->loadObjectList("SELECT id FROM #__components");
            foreach ($temp_exts as $temp_ext)
            {
                $ext = new ExtensionModel($temp_ext->id, $this->database);
                $this->extensions[] = $ext;
            }
        }
        
    }

?>