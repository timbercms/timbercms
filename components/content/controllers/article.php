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
        
    }

?>