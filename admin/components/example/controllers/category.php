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
        
        public function saveandnew()
        {
            $this->save(false);
            header("Location: index.php?component=example&controller=category");
        }
        
        public function save($redirect = true)
        {
            foreach ($_POST as $key => $value)
            {
                $this->model->$key = $value;
            }
            if ($this->model->store())
            {
                $this->model->setMessage("success", "Category saved");
            }
            else
            {
                $this->model->setMessage("danger", "Something went wrong during saving");
            }
            if ($redirect)
            {
                header("Location: index.php?component=example&controller=categories");
            }
        }
        
        public function publish()
        {
            $this->model->database->query("UPDATE #__example_categories SET published = '1' WHERE id = ?", array($_GET["id"]));
            $this->model->setMessage("success", "Category published.");
            header("Location: index.php?component=example&controller=categories");
        }
        
        public function unpublish()
        {
            $this->model->database->query("UPDATE #__example_categories SET published = '0' WHERE id = ?", array($_GET["id"]));
            $this->model->setMessage("success", "Category unpublished");
            header("Location: index.php?component=example&controller=categories");
        }
        
    }

?>