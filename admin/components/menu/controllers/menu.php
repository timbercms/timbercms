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
        
        public function saveandnew()
        {
            $this->save(false);
            header("Location: index.php?component=menu&controller=menu");
        }
        
        public function save($redirect = true)
        {
            $this->model->id = $_POST["id"];
            $this->model->title = $_POST["title"];
            if ($this->model->store())
            {
                $this->model->setMessage("success", "Menu saved");
            }
            else
            {
                $this->model->setMessage("danger", "Something went wrong during saving");
            }
            if ($redirect)
            {
                header("Location: index.php?component=menu&controller=menus");
            }
        }
        
    }

?>