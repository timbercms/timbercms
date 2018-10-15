<?php

    class HookController
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
            $this->model->database->query("UPDATE #__components_hooks SET enabled = '1' WHERE id = ?", array($_GET["id"]));
            $hook = $this->model->database->loadObject("SELECT title FROM #__components_hooks WHERE id = ?", array($_GET["id"]));
            Core::log(Core::user()->username ." published the ". $hook->title ." hook");
            $this->model->setMessage("success", "Hook enabled");
            header("Location: index.php?component=extensions&controller=".(strlen($_GET["return"]) > 0 ? "hooks" : "hook&id=". $_GET["id"]));
        }
        
        public function unpublish()
        {
            $this->model->database->query("UPDATE #__components_hooks SET enabled = '0' WHERE id = ?", array($_GET["id"]));
            $hook = $this->model->database->loadObject("SELECT title FROM #__components_hooks WHERE id = ?", array($_GET["id"]));
            Core::log(Core::user()->username ." unpublished the ". $hook->title ." hook");
            $this->model->setMessage("success", "Hook disabled");
            header("Location: index.php?component=extensions&controller=".(strlen($_GET["return"]) > 0 ? "hooks" : "hook&id=". $_GET["id"]));
        }
        
    }

?>