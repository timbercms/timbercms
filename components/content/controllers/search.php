<?php

    class SearchController
    {
        
        private $model;
        
        public function __construct($model)
        {
            $this->model = $model;
            Core::changeTitle("Search Results");
        }
        
    }

?>