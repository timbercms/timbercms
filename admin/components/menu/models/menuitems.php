<?php

    require_once(__DIR__ ."/menuitem.php");

    class MenuitemsModel extends Model
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
            $temp_items = $this->database->loadObjectList("SELECT id FROM #__menus_items WHERE menu_id = ? AND parent_id = 0 ORDER BY ordering ASC", array($id));
            foreach ($temp_items as $temp_item)
            {
                $item = new MenuitemModel($temp_item->id, $this->database);
                $this->items[] = $item;
            }
        }
        
    }

?>