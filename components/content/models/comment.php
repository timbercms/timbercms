<?php

    class CommentModel extends Model
    {
        public $component = "content";
        public $table = "articles_comments";
        public $database;
        
        public function __construct($id = 0, $database)
        {
            $this->database = $database;
            if ($id > 0)
            {
                $this->load($id);
            }
        }
        
        public function processData()
        {
            $this->author = new UserModel($temp->author_id, $this->database);
            $this->article_title = $this->database->loadObject("SELECT title FROM #__articles WHERE id = ?", array($this->article_id))->title;
            Core::hooks()->executeHook("onLoadCategoryModel", $this);
        }
        
    }

?>