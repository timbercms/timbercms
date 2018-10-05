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
                switch ($string[0])
                {
                    case "component":
                        $comp = $string[1];
                        break;
                    case "controller":
                        $controller = $string[1];
                        break;
                    case "id":
                        $id = $string[1];
                        break;
                    case "query":
                        $query = $string[1];
                        break;
                    case "task":
                        $task = $string[1];
                        break;
                    case "article_id":
                        $article_id = $string[1];
                        break;
                }
            }
            if ($comp == $this->component)
            {
                if (strlen($task) > 0)
                {
                    if ($controller == "article")
                    {
                        if ($task == "postComment")
                        {
                            return BASE_URL.$this->component."/article/?task=postComment";
                        }
                        else if ($task == "hideComment")
                        {
                            return BASE_URL.$this->component."/article/?task=hideComment&id=".$id."&article_id=".$article_id;
                        }
                        else if ($task == "unhideComment")
                        {
                            return BASE_URL.$this->component."/article/?task=unhideComment&id=".$id."&article_id=".$article_id;
                        }
                    }
                }
                else if ($controller == "article" && $id > 0)
                {
                    $article = new ArticleModel($id, $this->database);
                    $category = $this->database->loadObject("SELECT id, parent_id, alias FROM #__articles_categories WHERE id = ?", array($article->category->id));
                    if ($category->id > 0)
                    {
                        $url_parts[] = $article->alias;
                        $url_parts[] = $category->alias;
                        if ($category->parent_id > 0)
                        {
                            $parent = $this->database->loadObject("SELECT id, parent_id, alias FROM #__articles_categories WHERE id = ?", array($category->parent_id));
                            if ($parent->id > 0)
                            {
                                // Check to see if a menu item exists for the parent
                                $parent_item = $this->database->loadObject("SELECT id, alias, parent_id FROM #__menus_items WHERE component = ? AND controller = ? AND content_id = ? AND is_home != '1'", array($this->component, "category", $parent->id));
                                if ($parent_item->id > 0)
                                {
                                    // Menu item exists! Add alias and check for grandparent.
                                    $url_parts[] = $parent->alias;
                                    if ($parent_item->parent_id > 0)
                                    {
                                        $grandparent_item = $this->database->loadObject("SELECT id, alias, parent_id FROM #__menus_items WHERE id = ? AND is_home != '1'", array($parent_item->parent_id));
                                        if ($grandparent_item->id > 0)
                                        {
                                            // Item found! Add the alias.
                                            $url_parts[] = $grandparent_item->alias;
                                        }
                                    }
                                }
                            }
                            $url_parts = implode("/", array_reverse($url_parts));
                            return BASE_URL.$url_parts;
                        }
                        else
                        {
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
                    }
                }
                else if ($controller == "category" && $id > 0)
                {
                    // Check if this category, or it's parent, or it's grandparent has a menu item
                    // If so, build the url in the direction of children. If a category has a menu item,
                    // and has a parent, ignore the parent and use the current menu item.
                    // From there, check if the category has any child categories.
                    
                    $url_parts = array();
                    
                    $item = $this->database->loadObject("SELECT id, alias, parent_id FROM #__menu_items WHERE component = ? AND controller = ? AND content_id = ? AND is_home != '1'", array($this->component, "category", $id));
                    if ($item->id > 0)
                    {
                        // Menu item exists for this category! Use this alias.
                        $url_parts[] = $item->alias;
                        // Now check to see if this menu item has a parent.
                        if ($item->parent_id > 0)
                        {
                            $parent = $this->database->loadObject("SELECT id, alias, parent_id FROM #__menu_items WHERE component = ? AND controller = ? AND content_id = ? AND is_home != '1'", array($this->component, "category", $item->parent_id));
                            if ($parent->id > 0)
                            {
                                $url_parts[] = $parent->alias;
                                // Check to see if the grandparent exists.
                                $grandparent = $this->database->loadObject("SELECT id, alias, parent_id FROM #__menu_items WHERE component = ? AND controller = ? AND content_id = ? AND is_home != '1'", array($this->component, "category", $parent->parent_id));
                                if ($grandparent->id > 0)
                                {
                                    $url_parts[] = $grandparent->alias;
                                }
                            }
                        }
                    }
                    else
                    {
                        // Check to see if this category has a parent, if so, check for a menu item
                        $category = $this->database->loadObject("SELECT id, parent_id, alias FROM #__articles_categories WHERE id = ?", array($id));
                        if ($category->id > 0)
                        {
                            $url_parts[] = $category->alias;
                            if ($category->parent_id > 0)
                            {
                                $parent = $this->database->loadObject("SELECT id, parent_id, alias FROM #__articles_categories WHERE id = ?", array($category->parent_id));
                                if ($parent->id > 0)
                                {
                                    // Check to see if a menu item exists for the parent
                                    $parent_item = $this->database->loadObject("SELECT id, alias, parent_id FROM #__menus_items WHERE component = ? AND controller = ? AND content_id = ? AND is_home != '1'", array($this->component, "category", $parent->id));
                                    if ($parent_item->id > 0)
                                    {
                                        // Menu item exists! Add alias and check for grandparent.
                                        $url_parts[] = $parent->alias;
                                        if ($parent_item->parent_id > 0)
                                        {
                                            $grandparent_item = $this->database->loadObject("SELECT id, alias, parent_id FROM #__menus_items WHERE id = ? AND is_home != '1'", array($parent_item->parent_id));
                                            if ($grandparent_item->id > 0)
                                            {
                                                // Item found! Add the alias.
                                                $url_parts[] = $grandparent_item->alias;
                                            }
                                        }
                                    }
                                }
                                $url_parts = implode("/", array_reverse($url_parts));
                                return BASE_URL.$url_parts;
                            }
                            else
                            {
                                // No parent, just use this alias.
                                $url_parts[] = $category->alias;
                                $url_parts = implode("/", $url_parts);
                                return BASE_URL .$this->component ."/category/". $url_parts;
                            }
                        }
                    }
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
                // First, see if an article exists with the same alias, if not, check if a category exists.
                $alias = end($parts);
                $article = $this->database->loadObject("SELECT id FROM #__articles WHERE alias = ? AND published = 1", array($alias));
                if ($article->id > 0)
                {
                    // We have a match!
                    $new_parts[] = "content";
                    $new_parts[] = "article";
                    $new_parts[] = $article->id;
                    return $new_parts;
                }
                $category = $this->database->loadObject("SELECT id FROM #__articles_categories WHERE alias = ? AND published = 1", array($alias));
                if ($category->id > 0)
                {
                    // Matched!
                    $new_parts[] = "content";
                    $new_parts[] = "category";
                    $new_parts[] = $category->id;
                    return $new_parts;
                }
                return false;
            }
            return false;
        }
        
    }

?>