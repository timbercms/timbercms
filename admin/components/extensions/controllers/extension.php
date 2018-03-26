<?php

    class ExtensionController
    {
        
        private $model;
        private $core;
        
        public function __construct($model, $core)
        {
            $this->model = $model;
            $this->core = $core;
        }
        
        public function publish()
        {
            $this->model->database->query("UPDATE #__components SET enabled = '1' WHERE id = ?", array($_GET["id"]));
            $this->model->setMessage("success", "Extension enabled");
            header("Location: index.php?component=extensions&controller=extensions");
        }
        
        public function unpublish()
        {
            $this->model->database->query("UPDATE #__components SET enabled = '0' WHERE id = ?", array($_GET["id"]));
            $this->model->setMessage("success", "Extension disabled");
            header("Location: index.php?component=extensions&controller=extensions");
        }
        
    }

?>