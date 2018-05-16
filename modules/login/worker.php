<?php

    class LoginWorker
    {
        
        public $module;
     
        public function __construct($module, $database)
        {
            $this->module = $module;
            Core::addStylesheet("components/user/assets/css/user.css");
        }
        
    }

?>