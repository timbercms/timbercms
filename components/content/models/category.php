<?php

    require_once(__DIR__ ."/article.php");

    class CategoryModel extends Model
    {
        
        public $template = "category.php";
        public $database;
        public $pagination;
        public $max;
        public $articles = array();
        public $children = array();
        
        public function __construct($id = 0, $database, $load_articles = true)
        {
            $this->database = $database;
            if ($id > 0)
            {
                $this->loadList($id, $load_articles);
            }
            $this->pagination = new Pagination();
        }
        
        public function loadList($id, $load_articles)
        {
            $temp = $this->database->loadObject("SELECT * FROM #__articles_categories WHERE id = ?", array($id));
            $this->id = $temp->id;
            $this->parent_id = $temp->parent_id;
            $this->title = $temp->title;
            $this->alias = $temp->alias;
            $this->description = $temp->description;
            $this->published = $temp->published;
            $this->ordering = $temp->ordering;
            $this->params = (object) unserialize($temp->params);
            $this->parent = $this->database->loadObject("SELECT id, alias, parent_id FROM #__articles_categories WHERE id = ?", array($this->parent_id));
            if (strlen($temp->image) > 0)
            {
                $this->image = (strlen(SUBFOLDER) > 0 ? SUBFOLDER : "/").$temp->image;
            }
            else
            {
                $this->image = (strlen(SUBFOLDER) > 0 ? SUBFOLDER : "/")."/images/categories/placeholder.jpg";
            }
            $children = $this->database->loadObjectList("SELECT id FROM #__articles_categories WHERE parent_id = ? ORDER BY title ASC", array($id));
            $child_array = array();
            foreach ($children as $child)
            {
                $child_array[] = $child->id;
                $this->children[] = new CategoryModel($child->id, $this->database, false);
            }
            $child_string = implode(",", $child_array);
            if ($load_articles)
            {
                if (strlen($child_string) > 0)
                {
                    $query = "SELECT id FROM #__articles WHERE (category_id = ? OR FIND_IN_SET(category_id, '". $child_string ."')) AND published = '1' ORDER BY ". $this->ordering;
                }
                else
                {
                    $query = "SELECT id FROM #__articles WHERE category_id = ? AND published = '1' ORDER BY ". $this->ordering;
                }
                $this->max = count($this->database->loadObjectList($query, array($id)));
                $query .= " LIMIT ". ($_GET["p"] > 0 ? (($_GET["p"] - 1) * 9) : 0) .", 9";
                $ta = $this->database->loadObjectList($query, array($id));
                foreach ($ta as $a)
                {
                    $this->articles[] = new ArticleModel($a->id, $this->database);
                }
            }
            Core::hooks()->executeHook("onLoadCategoryModel", $this);
        }
        
    }

?>