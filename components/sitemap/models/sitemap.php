<?php

    class SitemapModel extends Model
    {
        
        public $template = "sitemap.php";
        public $database;
        
        public function __construct($id = 0, $database)
        {
            $this->database = $database;
        }
        
    }

?>