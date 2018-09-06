<?php

    require_once(__DIR__ ."/menuitem.php");

    class MenuitemsModel extends Model
    {
        
        public $template = "menuitems.php";
        public $database;
        public $pagination;
        
        public $items = array();
        public $settings;
        
        public function __construct($id = 0, $database)
        {
            $this->database = $database;
            $this->load($id);
            $this->settings = simplexml_load_file(__DIR__ ."/../extension.xml");
            $this->pagination = new Pagination();
        }
        
        public function load($id)
        {
            $query = "SELECT id FROM #__menus_items WHERE menu_id = ? AND parent_id = 0";
            if (strlen($_GET["title"]) > 0)
            {
                $query .= " AND title LIKE '%". $_GET["title"] ."%'";
            }
            $query .= " ORDER BY ordering ASC";
            $this->max = count($this->database->loadObjectList($query));
            $query .= " LIMIT ". ($_GET["p"] > 0 ? (($_GET["p"] - 1) * 20) : 0) .", 20";
            $temp_items = $this->database->loadObjectList($query, array($id));
            foreach ($temp_items as $temp_item)
            {
                $item = new MenuitemModel($temp_item->id, $this->database);
                $this->items[] = $item;
            }
        }
        
    }

?>