<?php

    class SitemapModel extends Model
    {
        
        public $template = "sitemap.php";
        public $database;
        
        public $items = array();
        
        public function __construct($id = 0, $database)
        {
            $this->database = $database;
            $this->items = $this->database->loadObjectList("SELECT * FROM #__menus_items WHERE published = 1");
        }
        
    }

?>