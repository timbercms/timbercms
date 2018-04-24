<?php

    class DatabaseController
    {
        
        private $model;
        private $core;
        
        public function __construct($model, $core)
        {
            $this->model = $model;
            $this->core = $core;
        }
        
        public function fix()
        {
            $this->model->fix();
            $this->model->setMessage("success", count($this->model->missing) ." issues repaired successfully");
            header("Location: index.php?component=settings&controller=database");
        }
        
        public function remove()
        {
            $this->model->remove($_GET["table"], $_GET["column"]);
            $this->model->setMessage("success", $_GET["table"].".". $_GET["column"] ." removed successfully");
            header("Location: index.php?component=settings&controller=database");
        }
        
    }

?>