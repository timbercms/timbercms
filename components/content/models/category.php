<?php

    require_once(__DIR__ ."/article.php");

    class CategoryModel extends Model
    {
        
        public $template = "category.php";
        public $database;
        
        public $id;
        public $title;
        public $alias;
        public $description;
        public $published;
        public $params;
        public $articles = array();
        
        public function __construct($id = 0, $database, $load_articles = true)
        {
            $this->database = $database;
            if ($id > 0)
            {
                $this->load($id, $load_articles);
            }
        }
        
        public function load($id, $load_articles)
        {
            $temp = $this->database->loadObject("SELECT * FROM #__articles_categories WHERE id = ?", array($id));
            $this->id = $temp->id;
            $this->title = $temp->title;
            $this->alias = $temp->alias;
            $this->description = $temp->description;
            $this->published = $temp->published;
            $this->params = (object) unserialize($temp->params);
            if ($load_articles)
            {
                if (Core::user()->usergroup->is_admin == 1)
                {
                    $ta = $this->database->loadObjectList("SELECT a.id FROM #__articles a WHERE a.category_id = ?", array($id));
                }
                else
                {
                    $ta = $this->database->loadObjectList("SELECT a.id FROM #__articles a WHERE a.category_id = ? AND ((a.published = '1') AND ((a.start_publishing > UNIX_TIMESTAMP() AND a.stop_publishing < UNIX_TIMESTAMP()) OR (a.start_publishing > UNIX_TIMESTAMP() AND a.stop_publishing = 0) OR (a.stop_publishing < UNIX_TIMESTAMP() AND a.stop_publishing > 0)))", array($id));
                }
                foreach ($ta as $a)
                {
                    $this->articles[] = new ArticleModel($a->id, $this->database);
                }
            }
        }
        
    }

?>