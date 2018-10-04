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
        
        public function saveandnew()
        {
            $this->save(false);
            header("Location: index.php?component=modules&controller=newmodule");
        }
        
        public function save($redirect = true)
        {
            foreach ($_POST as $key => $value)
            {
                $this->model->$key = $value;
            }
            $this->model->pages = implode(",", $_POST["pages"]);
            if ($this->model->store())
            {
                $this->model->setMessage("success", "Module saved");
            }
            else
            {
                $this->model->setMessage("danger", "Something went wrong during saving");
            }
            if ($redirect)
            {
                header("Location: index.php?component=modules&controller=modules");
            }
        }
        
        public function publish()
        {
            $this->model->database->query("UPDATE #__modules SET published = '1' WHERE id = ?", array($_GET["id"]));
            $this->model->setMessage("success", "Module published");
            header("Location: index.php?component=modules&controller=modules");
        }
        
        public function unpublish()
        {
            $this->model->database->query("UPDATE #__modules SET published = '0' WHERE id = ?", array($_GET["id"]));
            $this->model->setMessage("success", "Module unpublished");
            header("Location: index.php?component=modules&controller=modules");
        }
        
    }

?>