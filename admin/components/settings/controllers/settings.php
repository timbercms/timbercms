<?php

    class SettingsController
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
            $this->model->extension->params = $_POST["params"];
            $this->model->extension->store();
            header("Location: index.php?component=settings&controller=settings&extension=". $_POST["extension"]);
        }
        
    }

?>