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
            if ($this->model->extension->store())
            {
                $this->model->setMessage("success", "Settings saved");
            }
            else
            {
                $this->model->setMessage("danger", "Something went wrong during saving");
            }
            header("Location: index.php?component=settings&controller=settings&extension=". $_POST["extension"]);
        }
        
    }

?>