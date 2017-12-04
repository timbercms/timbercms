<?php

    class ProfileController
    {
        
        private $model;
        
        public function __construct($model)
        {
            $this->model = $model;
            Core::changeTitle($this->model->user->username."'s Profile");
        }
        
    }

?>