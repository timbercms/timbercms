<?php

    class View extends Core
    {
        
        private $model;
        private $controller;
        private $core;
        
        public function __construct($controller, $model, $core)
        {
            $this->controller = $controller;
            $this->model = $model;
            $this->core = $core;
        }
        
        public function output()
        {
            require_once($this->core->loadOverride($this->model->template));
        }
        
    }

?>