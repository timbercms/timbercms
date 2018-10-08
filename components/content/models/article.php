<?php

    require_once(__DIR__ ."/category.php");
    require_once(__DIR__ ."/comment.php");

    class ArticleModel extends Model
    {
        public $component_name = "content";
        public $table = "articles";
        public $template = "article.php";
        public $database;
        public $comments = array();
        
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
            $this->short_content = strip_tags(explode("<!-- pagebreak -->", $this->content)["0"], "<p></p>");
            $this->category = new CategoryModel($this->category_id, $this->database, false);
            $this->author = new UserModel($this->author_id, $this->database);
            if (strlen($this->image) > 0)
            {
                $this->image = (strlen(SUBFOLDER) > 0 ? SUBFOLDER : "/").$this->image;
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
            Core::hooks()->executeHook("onLoadArticleModel", $this);
        }
        
        public function addHit()
        {
            $this->database->query("UPDATE #__articles SET hits = ? WHERE id = ?", array(($this->hits + 1), $this->id));
            $this->hits = ($this->hits + 1);
        }
        
    }

?>