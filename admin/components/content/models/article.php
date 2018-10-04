<?php

    require_once(__DIR__ ."/category.php");
    require_once(__DIR__ ."/../../../classes/form.php");

    class ArticleModel extends Model
    {
        public $component = "content";
        public $table = "articles";
        public $template = "article.php";
        public $database;
        public $form;
        
        public function __construct($id = 0, $database)
        {
            $this->database = $database;
            if ($id > 0)
            {
                $this->load($id);
            }
            $this->form = new Form(__DIR__ ."/../forms/article.xml", $this, $this->database);
        }
        
        public function processData()
        {
            $this->category = new CategoryModel($temp->category_id, $this->database, false);
            $this->author = new UserModel($temp->author_id, $this->database);
        }
        
        public function delete($id)
        {
            $this->database->query("DELETE FROM #__articles WHERE id = ?", array($id));
        }
        
    }

?>