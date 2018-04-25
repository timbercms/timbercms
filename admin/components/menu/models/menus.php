<?php

    require_once(__DIR__ ."/menu.php");

    class MenusModel extends Model
    {
        
        public $template = "menus.php";
        public $database;
        
        public $menus = array();
        public $settings;
        
        public function __construct($id = 0, $database)
        {
            $this->database = $database;
            $this->load();
            $this->settings = simplexml_load_file(__DIR__ ."/../extension.xml");
        }
        
        public function load()
        {
            $temp_menus = $this->database->loadObjectList("SELECT id FROM #__menus");
            foreach ($temp_menus as $temp_menu)
            {
                $menu = new MenuModel($temp_menu->id, $this->database);
                $this->menus[] = $menu;
            }
        }
        
    }

?>