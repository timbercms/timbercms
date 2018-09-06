<?php

    require_once(__DIR__ ."/article.php");

    class ArticlesModel extends Model
    {
        
        public $template = "articles.php";
        public $database;
        public $pagination;
        
        public $articles = array();
        public $settings;
        public $max;
        
        public function __construct($id = 0, $database)
        {
            $this->database = $database;
            $this->load();
            $this->settings = simplexml_load_file(__DIR__ ."/../extension.xml");
            $this->pagination = new Pagination();
        }
        
        public function load()
        {
            $query = "SELECT id FROM #__articles";
            if (strlen($_GET["title"]) > 0)
            {
                $query .= " WHERE title LIKE '%". $_GET["title"] ."%'";
            }
            $this->max = count($this->database->loadObjectList($query));
            $query .= " LIMIT ". ($_GET["p"] > 0 ? (($_GET["p"] - 1) * 20) : 0) .", 20";
            $temp = $this->database->loadObjectList($query);
            foreach ($temp as $temp_article)
            {
                $article = new ArticleModel($temp_article->id, $this->database);
                $this->articles[] = $article;
            }
        }
        
    }

?>