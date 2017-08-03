<?php

    class MenuitemController
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
            $this->model->menu_id = $_POST["menu_id"];
            $this->model->title = $_POST["title"];
            $this->model->alias = $_POST["alias"];
            $this->model->published = $_POST["published"];
            $this->model->access_group = $_POST["access_group"];
            $this->model->component = $_POST["component"];
            $this->model->controller = $_POST["controller"];
            $this->model->content_id = $_POST["content_id"];
            $this->model->params = $_POST["params"];
            $this->model->is_home = $_POST["is_home"];
            $this->model->store();
            $this->model->setMessage("success", "Menu Item saved Successfully");
            header("Location: index.php?component=menu&controller=menuitems&id=". $_POST["menu_id"]);
        }
        
    }

?>