<?php

    require_once(__DIR__ ."/menu.php");

    class MenusModel extends Model
    {
        
        public $template = "menus.php";
        public $database;
        public $pagination;
        
        public $menus = array();
        public $settings;
        
        public function __construct($id = 0, $database)
        {
            $this->database = $database;
            $this->load();
            $this->settings = simplexml_load_file(__DIR__ ."/../extension.xml");
            $this->pagination = new Pagination();
        }
        
        public function load()
        {
            $query = "SELECT id FROM #__menus";
            $this->max = count($this->database->loadObjectList($query));
            $query .= " LIMIT ". ($_GET["p"] > 0 ? (($_GET["p"] - 1) * 20) : 0) .", 20";
            $temp_menus = $this->database->loadObjectList($query);
            foreach ($temp_menus as $temp_menu)
            {
                $menu = new MenuModel($temp_menu->id, $this->database);
                $this->menus[] = $menu;
            }
        }
        
    }

?>