<?php

    class CommentModel extends Model
    {
        
        public $database;
        
        public $id;
        public $article_id;
        public $author;
        public $post_time;
        public $content;
        public $published;
        public $reported;
        public $reported_time;
        
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
            $temp = $this->database->loadObject("SELECT * FROM #__articles_comments WHERE id = ?", array($id));
            $this->id = $temp->id;
            $this->article_id = $temp->article_id;
            $this->post_time = $temp->post_time;
            $this->content = $temp->content;
            $this->published = $temp->published;
            $this->reported = $temp->reported;
            $this->reported_time = $temp->reported_time;
            $this->author = new UserModel($temp->author_id, $this->database);
        }
        
    }

?>