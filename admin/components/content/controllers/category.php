<?php

    class CategoryController
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
            $this->model->alias = $_POST["alias"];
            $this->model->description = $_POST["description"];
            $this->model->published = $_POST["published"];
            $this->model->params = $_POST["params"];
            $this->model->store();
            header("Location: index.php?component=content&controller=categories");
        }
        
    }

?>