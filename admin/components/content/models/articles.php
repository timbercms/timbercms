<?php

    require_once(__DIR__ ."/article.php");

    class ArticlesModel extends Model
    {
        
        public $template = "articles.php";
        public $database;
        
        public $articles = array();
        public $settings;
        
        public function __construct($id = 0, $database)
        {
            $this->database = $database;
            $this->load();
            $this->settings = simplexml_load_file(__DIR__ ."/../extension.xml");
        }
        
        public function load()
        {
            $query = "SELECT id FROM #__articles";
            if (strlen($_GET["title"]) > 0)
            {
                $query .= " WHERE title LIKE '%". $_GET["title"] ."%'";
            }
            $temp = $this->database->loadObjectList($query);
            foreach ($temp as $temp_article)
            {
                $article = new ArticleModel($temp_article->id, $this->database);
                $this->articles[] = $article;
            }
        }
        
    }

?>