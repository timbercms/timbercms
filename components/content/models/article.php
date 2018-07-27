<?php

    require_once(__DIR__ ."/category.php");
    require_once(__DIR__ ."/comment.php");

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
        public $image;
        public $comments = array();
        
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
            $this->short_content = strip_tags(explode("<!-- pagebreak -->", $this->content)["0"], "<p></p>");
            $this->published = $temp->published;
            $this->publish_time = $temp->publish_time;
            $this->hits = $temp->hits;
            $this->meta_description = $temp->meta_description;
            $this->category = new CategoryModel($temp->category_id, $this->database, false);
            $this->author = new UserModel($temp->author_id, $this->database);
            if (strlen($temp->image) > 0)
            {
                $this->image = (strlen(SUBFOLDER) > 0 ? SUBFOLDER : "/").$temp->image;
            }
            else
            {
                $this->image = (strlen(SUBFOLDER) > 0 ? SUBFOLDER : "/")."images/articles/placeholder.jpg";
            }
            if (Core::user()->usergroup->is_admin == 1)
            {
                $temp_comments = $this->database->loadObjectList("SELECT id FROM #__articles_comments WHERE article_id = ? ORDER BY publish_time DESC", array($this->id));
            }
            else
            {
                $temp_comments = $this->database->loadObjectList("SELECT id FROM #__articles_comments WHERE article_id = ? AND published = ? ORDER BY publish_time DESC", array($this->id, 1));
            }
            foreach ($temp_comments as $temp_comment)
            {
                $this->comments[] = new CommentModel($temp_comment->id, $this->database);
            }
        }
        
        public function addHit()
        {
            $this->database->query("UPDATE #__articles SET hits = ? WHERE id = ?", array(($this->hits + 1), $this->id));
            $this->hits = ($this->hits + 1);
        }
        
    }

?>