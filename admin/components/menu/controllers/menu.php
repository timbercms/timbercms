<?php

    class MenuController
    {
        
        private $model;
        private $core;
        
        public function __construct($model, $core)
        {
            $this->model = $model;
            $this->core = $core;
        }
        
        public function save()
        {
            $this->model->id = $_POST["id"];
            $this->model->title = $_POST["title"];
            $this->model->store();
            header("Location: index.php?component=menu&controller=menus");
        }
        
    }

?>