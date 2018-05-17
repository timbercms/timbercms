<?php

    require_once(__DIR__ ."/article.php");

    class SearchModel extends Model
    {
        
        public $template = "search.php";
        public $database;
        
        public $articles = array();
        
        public function __construct($id = 0, $database)
        {
            $this->database = $database;
            $this->load();
        }
        
        public function load()
        {
            $temp_articles = $this->database->loadObjectList("SELECT id FROM #__articles WHERE title LIKE ? OR content LIKE ?", array("%". $_GET["query"] ."%", "%". $_GET["query"] ."%"));
            foreach ($temp_articles as $temp_article)
            {
                $this->articles[] = new ArticleModel($temp_article->id, $this->database);
            }
        }
        
    }

?>