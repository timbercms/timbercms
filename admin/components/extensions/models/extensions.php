<?php

    require_once(__DIR__ ."/extension.php");

    class ExtensionsModel
    {
        
        public $template = "extensions.php";
        public $database;
        
        public $extensions = array();
        
        public function __construct($id = 0, $database)
        {
            $this->database = $database;
            $this->load();
        }
        
        public function load()
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