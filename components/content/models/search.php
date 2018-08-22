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
            if (strlen($_GET["query"]) > 0)
            {
                $temp_articles = $this->database->loadObjectList("SELECT id FROM #__articles WHERE (title LIKE ? OR content LIKE ?) AND published = ? ORDER BY publish_time DESC", array("%". $_GET["query"] ."%", "%". $_GET["query"] ."%", 1));
            }
            else
            {
                $temp_articles = $this->database->loadObjectList("SELECT id FROM #__articles WHERE published = 1 ORDER BY publish_time DESC", array(1));
            }
            foreach ($temp_articles as $temp_article)
            {
                $this->articles[] = new ArticleModel($temp_article->id, $this->database);
            }
            Core::hooks()->executeHook("onLoadSearchModel", $this);
        }
        
    }

?>