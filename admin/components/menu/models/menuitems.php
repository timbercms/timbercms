<?php

    require_once(__DIR__ ."/menuitem.php");

    class MenuitemsModel extends Model
    {
        
        public $template = "menuitems.php";
        public $database;
        
        public $items = array();
        public $settings;
        
        public function __construct($id = 0, $database)
        {
            $this->database = $database;
            $this->load($id);
            $this->settings = simplexml_load_file(__DIR__ ."/../extension.xml");
        }
        
        public function load($id)
        {
            $query = "SELECT id FROM #__menus_items WHERE menu_id = ? AND parent_id = 0";
            if (strlen($_GET["title"]) > 0)
            {
                $query .= " AND title LIKE '%". $_GET["title"] ."%'";
            }
            $query .= " ORDER BY ordering ASC";
            $temp_items = $this->database->loadObjectList($query, array($id));
            foreach ($temp_items as $temp_item)
            {
                $item = new MenuitemModel($temp_item->id, $this->database);
                $this->items[] = $item;
            }
        }
        
    }

?>