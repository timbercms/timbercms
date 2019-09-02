<?php

    class RedirectController
    {
        
        private $model;
        private $core;
        
        public function __construct($model, $core)
        {
            $this->model = $model;
            $this->core = $core;
        }
        
        public function save($redirect = true)
        {
            foreach ($_POST as $key => $value)
            {
                $this->model->$key = $value;
            }
            if ($this->model->store())
            {
                $this->model->setMessage("success", "Redirect saved");
            }
            else
            {
                $this->model->setMessage("danger", "Something went wrong during saving");
            }
            if ($redirect)
            {
                header("Location: index.php?component=redirects&controller=redirects");
            }
        }
        
        public function publish()
        {
            $this->model->database->query("UPDATE #__redirects SET published = '1' WHERE id = ?", array($_GET["id"]));
            $this->model->setMessage("success", "Redirect published");
            header("Location: index.php?component=redirects&controller=redirects");
        }
        
        public function unpublish()
        {
            $this->model->database->query("UPDATE #__redirects SET published = '0' WHERE id = ?", array($_GET["id"]));
            $this->model->setMessage("success", "Redirect unpublished");
            header("Location: index.php?component=redirects&controller=redirects");
        }
        
    }

?>