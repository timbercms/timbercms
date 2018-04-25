<?php

    require_once(__DIR__ ."/category.php");

    class CategoriesModel extends Model
    {
        
        public $template = "categories.php";
        public $database;
        
        public $categories = array();
        public $settings;
        
        public function __construct($id = 0, $database)
        {
            $this->database = $database;
            $this->load();
            $this->settings = simplexml_load_file(__DIR__ ."/../extension.xml");
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