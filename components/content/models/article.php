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
        public $published;
        public $publish_time;
        public $start_publishing;
        public $stop_publishing;
        public $author;
        public $hits;
        public $meta_description;
        public $tags;
        public $comments = array();
        public $comment_count;
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
            $this->published = $temp->published;
            $this->publish_time = $temp->publish_time;
            $this->start_publishing = $temp->start_publishing;
            $this->stop_publishing = $temp->stop_publishing;
            $this->hits = $temp->hits;
            $this->meta_description = $temp->meta_description;
            $this->tags = $temp->tags;
            $this->category = new CategoryModel($temp->category_id, $this->database, false);
            $this->author = new UserModel($temp->author_id, $this->database);
            $comments = $this->database->loadObject("SELECT COUNT(id) AS count FROM #__articles_comments WHERE article_id = ?", array($this->id));
            $this->comment_count = $comments->count;
            preg_match('/<img.+src=[\'"](?P<src>.+?)[\'"].*>/i', $this->content, $image);
            $this->image = $image["src"];
            $this->content = preg_replace('/<img(.*)>/i', '', $this->content, 1);
        }
        
        public function loadComments()
        {
            $temp = $this->database->loadObjectList("SELECT id FROM #__articles_comments WHERE article_id = ? ORDER BY post_time DESC", array($this->id));
            foreach ($temp as $t)
            {
                $comment = new CommentModel($t->id, $this->database);
                $this->comments[] = $comment;
            }
        }
        
        public function addHit()
        {
            $this->database->query("UPDATE #__articles SET hits = ? WHERE id = ?", array(($this->hits + 1), $this->id));
            $this->hits = ($this->hits + 1);
        }
        
    }

?>