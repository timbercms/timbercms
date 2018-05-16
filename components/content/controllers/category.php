<?php

    class CategoryController
    {
        
        private $model;
        
        public function __construct($model)
        {
            $this->model = $model;
            Core::addScript("components/content/assets/js/masonry.pkgd.min.js");
        }
        
    }

?>