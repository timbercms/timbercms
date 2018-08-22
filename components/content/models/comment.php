<?php

    class CommentModel extends Model
    {
        public $database;
        
        public $id;
        public $article_id;
        public $content;
        public $published;
        public $publish_time;
        public $author;
        public $article_title;
        
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
            $this->content = $temp->content;
            $this->published = $temp->published;
            $this->publish_time = $temp->publish_time;
            $this->author = new UserModel($temp->author_id, $this->database);
            $this->article_title = $this->database->loadObject("SELECT title FROM #__articles WHERE id = ?", array($this->article_id))->title;
            Core::hooks()->executeHook("onLoadCategoryModel", $this);
        }
        
        public function store($table = "", $data = array())
		{
			$data = array();
			$data[] = array("name" => "id", "value" => $this->id);
			$data[] = array("name" => "article_id", "value" => $this->article_id);
            $data[] = array("name" => "content", "value" => $this->content);
            $data[] = array("name" => "published", "value" => $this->published);
            $data[] = array("name" => "publish_time", "value" => $this->publish_time);
            $data[] = array("name" => "author_id", "value" => $this->author_id);
			return parent::store("#__articles_comments", $data);
		}
        
    }

?>