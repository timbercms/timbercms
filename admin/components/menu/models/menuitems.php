<?php

    require_once(__DIR__ ."/menuitem.php");

    class MenuitemsModel
    {
        
        public $template = "menuitems.php";
        public $database;
        
        public $items = array();
        
        public function __construct($id = 0, $database)
        {
            $this->database = $database;
            $this->load($id);
        }
        
        public function load($id)
        {
            $temp_items = $this->database->loadObjectList("SELECT id FROM #__menus_items WHERE menu_id = ?", array($id));
            foreach ($temp_items as $temp_item)
            {
                $item = new MenuitemModel($temp_item->id, $this->database);
                $this->items[] = $item;
            }
        }
        
    }

?>