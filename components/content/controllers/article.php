<?php

    class ArticleController
    {
        
        private $model;
        
        public function __construct($model)
        {
            $model->addHit();
            $this->model = $model;
            Core::changeTitle($this->model->title);
            Core::changeMetaDescription($this->model->meta_description);
        }
        
        public function postcomment()
        {
            if (strlen($_POST["content"]) > 0)
            {
                Core::db()->query("INSERT INTO #__articles_comments (article_id, author_id, post_time, content, published) VALUES (?, ?, ?, ?, ?)", array($_POST["article_id"], Core::user()->id, time(), $_POST["content"], 1));
                header("Location: index.php?component=content&controller=article&id=". $_POST["article_id"]);
            }
            else
            {
                header("Location: index.php?component=content&controller=article&id=". $_POST["article_id"]);
            }
        }
        
    }

?>