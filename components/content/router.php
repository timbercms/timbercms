<?php

    require_once(__DIR__ ."/models/article.php");

    class ContentRouter
    {
        
        public $database;
        public $component = "content";
        
        public function __construct($database)
        {
            $this->database = $database;
        }
        
        public function route($link)
        {
            $parts = explode("&", $link);
            foreach ($parts as $part)
            {
                $string = explode("=", $part);
                switch ($string["0"])
                {
                    case "component":
                        $comp = $string["1"];
                        break;
                    case "controller":
                        $controller = $string["1"];
                        break;
                    case "id":
                        $id = $string["1"];
                        break;
                }
            }
            if ($id > 0 && $comp == $this->component)
            {
                if ($controller == "article")
                {
                    $article = new ArticleModel($id, $this->database);
                    return BASE_URL .$this->component ."/article/". $article->category->alias ."/". $article->alias;
                }
                else if ($controller == "category")
                {
                    $category = new CategoryModel($id, $this->database, false);
                    return BASE_URL .$this->component ."/category/". $category->alias;
                }
            }
            else
            {
                return;
            }
        }
        
        public function unroute($parts)
        {
            $new_parts = array();
            if ($parts["1"] == "article")
            {
                $article = $this->database->loadObject("SELECT id FROM #__articles WHERE alias = ? AND published = 1", array($parts["3"]));
                if ($article->id > 0)
                {
                    // We have a match!
                    $new_parts[] = "content";
                    $new_parts[] = "article";
                    $new_parts[] = $article->id;
                }
                return $new_parts;
            }
            else if ($parts["1"] == "category")
            {
                $category = $this->database->loadObject("SELECT * FROM #__articles_categories WHERE alias = ? AND published = 1", array($parts["2"]));
                if ($category->id > 0)
                {
                    $new_parts[] = "content";
                    $new_parts[] = "category";
                    $new_parts[] = $category->id;
                }
                return $new_parts;
            }
            return false;
        }
        
    }

?>