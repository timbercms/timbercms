<?php

    require_once(__DIR__ ."/category.php");

    class CategoriesModel
    {
        
        public $template = "categories.php";
        public $database;
        
        public $categories = array();
        
        public function __construct($id = 0, $database)
        {
            $this->database = $database;
            $this->load();
        }
        
        public function load()
        {
            $temp = $this->database->loadObjectList("SELECT id FROM #__articles_categories");
            foreach ($temp as $temp_cat)
            {
                $category = new CategoryModel($temp_cat->id, $this->database);
                $this->categories[] = $category;
            }
        }
        
    }

?>