<?php

    class LoginWorker
    {
        
        public $module;
     
        public function __construct($module, $database)
        {
            $this->module = $module;
            Core::addStylesheet("components/content/assets/css/user.css");
        }
        
    }

?>