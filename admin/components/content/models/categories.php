<?php

    require_once(__DIR__ ."/category.php");

    class CategoriesModel extends Model
    {
        
        public $template = "categories.php";
        public $database;
        public $pagination;
        
        public $categories = array();
        public $settings;
        
        public function __construct($id = 0, $database)
        {
            $this->database = $database;
            $this->load();
            $this->settings = simplexml_load_file(__DIR__ ."/../extension.xml");
            $this->pagination = new Pagination();
        }
        
        public function load($id = false)
        {
            $query = "SELECT id FROM #__articles_categories WHERE parent_id = '0'";
            if (strlen($_GET["title"]) > 0)
            {
                $query .= " AND title LIKE '%". $_GET["title"] ."%'";
            }
            $query .= " ORDER BY id DESC";
            $this->max = count($this->database->loadObjectList($query));
            $query .= " LIMIT ". ($_GET["p"] > 0 ? (($_GET["p"] - 1) * 20) : 0) .", 20";
            $temp = $this->database->loadObjectList($query);
            foreach ($temp as $temp_cat)
            {
                $category = new CategoryModel($temp_cat->id, $this->database);
                $this->categories[] = $category;
            }
        }
        
    }

?>