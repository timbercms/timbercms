<?php

    class ModuleController
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
            $this->model->type = $_POST["type"];
            $this->model->show_title = $_POST["show_title"];
            $this->model->published = $_POST["published"];
            $this->model->position = $_POST["position"];
            $this->model->params = $_POST["params"];
            $this->model->ordering = $_POST["ordering"];
            $this->model->pages = $_POST["pages"];
            $this->model->store();
            header("Location: index.php?component=modules&controller=modules");
        }
        
        public function publish()
        {
            $this->model->database->query("UPDATE #__modules SET published = '1' WHERE id = ?", array($_GET["id"]));
            header("Location: index.php?component=modules&controller=modules");
        }
        
        public function unpublish()
        {
            $this->model->database->query("UPDATE #__modules SET published = '0' WHERE id = ?", array($_GET["id"]));
            header("Location: index.php?component=modules&controller=modules");
        }
        
    }

?>