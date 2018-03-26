<?php

    class CompleteController
    {
        
        private $model;
        
        public function __construct($model)
        {
            Core::changeTitle("Complete");
            $this->model = $model;
        }
        
    }

?>