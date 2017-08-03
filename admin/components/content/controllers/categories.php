<?php

    class CategoriesController
    {
        
        private $model;
        private $core;
        
        public function __construct($model, $core)
        {
            $this->model = $model;
            $this->core = $core;
        }
        
    }

?>