<?php

    require_once(__DIR__ ."/category.php");

    class ArticleModel extends Model
    {
        
        public $template = "article.php";
        public $database;
        
        public $id;
        public $title;
        public $alias;
        public $category;
        public $content;
        public $short_content;
        public $published;
        public $publish_time;
        public $author;
        public $hits;
        public $meta_description;
        public $tags;
        public $image;
        
        public function __construct($id = 0, $database)
        {
            $this->database = $database;
            if ($id > 0)
            {
                $this->load($id);
            }
        }
        
        public function load($id)
        {
            $temp = $this->database->loadObject("SELECT * FROM #__articles WHERE id = ?", array($id));
            $this->id = $temp->id;
            $this->title = $temp->title;
            $this->alias = $temp->alias;
            $this->content = $temp->content;
            $this->short_content = strip_tags(explode("</p>", $this->content)["0"], "<p></p>");
            $this->published = $temp->published;
            $this->publish_time = $temp->publish_time;
            $this->hits = $temp->hits;
            $this->meta_description = $temp->meta_description;
            $this->tags = $temp->tags;
            $this->category = new CategoryModel($temp->category_id, $this->database, false);
            $this->author = new UserModel($temp->author_id, $this->database);
            $this->image = $temp->image;
        }
        
        public function addHit()
        {
            $this->database->query("UPDATE #__articles SET hits = ? WHERE id = ?", array(($this->hits + 1), $this->id));
            $this->hits = ($this->hits + 1);
        }
        
    }

?>