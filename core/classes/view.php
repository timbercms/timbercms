<?php

    class View extends Core
    {
        
        public $model;
        public $controller;
        public $core;
        
        public function __construct($controller, $model, $core)
        {
            $this->controller = $controller;
            $this->model = $model;
            $this->core = $core;
        }
        
        public function output()
        {
            if (ADMIN)
            {
                require_once(__DIR__ ."/../../admin/components/". $this->core->component ."/views/".$this->model->template);
            }
            else
            {
                echo '<div class="component-container">';
                require_once($this->core->loadOverride($this->model->template));
                echo '</div>';
            }
        }
        
    }

?>