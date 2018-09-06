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
                    case "query":
                        $query = $string["1"];
                        break;
                }
            }
            if ($comp == $this->component)
            {
                if ($controller == "article" && $id > 0)
                {
                    $article = new ArticleModel($id, $this->database);
                    $item = Core::db()->loadObject("SELECT id, alias FROM #__menus_items WHERE component = ? AND controller = ? AND content_id = ? AND is_home != '1'", array($this->component, "category", $article->category->id));
                    if ($item->id > 0)
                    {
                        return BASE_URL .$item->alias."/". $article->alias;
                    }
                    else
                    {
                        $url_parts = array($article->category->alias);
                        if ($article->category->parent_id > 0)
                        {
                            $url_parts[] = $article->category->parent->alias;
                            if ($article->category->parent->parent_id > 0)
                            {
                                $cat = $this->database->loadObject("SELECT alias FROM #__articles_categories WHERE id = ?", array($article->category->parent->parent_id));
                                $url_parts[] = $cat->alias;
                            }
                        }
                        $url_parts = implode("/", array_reverse($url_parts));
                        return BASE_URL .$this->component ."/article/". $url_parts ."/". $article->alias;
                    }
                }
                else if ($controller == "category" && $id > 0)
                {
                    $category = new CategoryModel($id, $this->database, false);
                    $url_parts = array($category->alias);
                    if ($category->parent_id > 0)
                    {
                        $url_parts[] = $category->parent->alias;
                        if ($category->parent->parent_id > 0)
                        {
                            $cat = $this->database->loadObject("SELECT alias FROM #__articles_categories WHERE id = ?", array($category->parent->parent_id));
                            $url_parts[] = $cat->alias;
                        }
                    }
                    $url_parts = implode("/", array_reverse($url_parts));
                    return BASE_URL .$this->component ."/category/". $url_parts;
                }
                else if ($controller == "search")
                {
                    return BASE_URL .$this->component ."/search/results?query=". $query;
                }
                else
                {
                    return;
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
                $article = $this->database->loadObject("SELECT id FROM #__articles WHERE alias = ? AND published = 1", array(end($parts)));
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
                $category = $this->database->loadObject("SELECT * FROM #__articles_categories WHERE alias = ? AND published = 1", array(end($parts)));
                if ($category->id > 0)
                {
                    $new_parts[] = "content";
                    $new_parts[] = "category";
                    $new_parts[] = $category->id;
                }
                return $new_parts;
            }
            else if ($parts["1"] == "search")
            {
                $new_parts[] = "content";
                $new_parts[] = "search";
                $new_parts[] = 0;
                return $new_parts;
            }
            else
            {
                // Menu Item Detection
                $alias = end($parts);
                $article = $this->database->loadObject("SELECT id FROM #__articles WHERE alias = ? AND published = 1", array($alias));
                if ($article->id > 0)
                {
                    // We have a match!
                    $new_parts[] = "content";
                    $new_parts[] = "article";
                    $new_parts[] = $article->id;
                }
                return $new_parts;
            }
            return false;
        }
        
    }

?>