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
            $this->model->ordering = $_POST["ordering"];
            $this->model->params = $_POST["params"];
            if ($this->model->store())
            {
                $this->model->setMessage("success", "Category saved");
            }
            else
            {
                $this->model->setMessage("danger", "Something went wrong during saving");
            }
            header("Location: index.php?component=content&controller=categories");
        }
        
        public function publish()
        {
            $this->model->database->query("UPDATE #__articles_categories SET published = '1' WHERE id = ?", array($_GET["id"]));
            $this->model->setMessage("success", "Category published.");
            header("Location: index.php?component=content&controller=categories");
        }
        
        public function unpublish()
        {
            $this->model->database->query("UPDATE #__articles_categories SET published = '0' WHERE id = ?", array($_GET["id"]));
            $this->model->setMessage("success", "category unpublished");
            header("Location: index.php?component=content&controller=categories");
        }
        
    }

?>