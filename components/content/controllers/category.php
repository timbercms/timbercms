<?php

    class CategoryController
    {
        
        private $model;
        
        public function __construct($model)
        {
            $this->model = $model;
            Core::changeTitle($this->model->title);
        }
        
    }

?>