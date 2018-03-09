<?php

    class HtmlWorker
    {
        
        public $module;
        public $database;
     
        public function __construct($module, $database)
        {
            $this->module = $module;
            $this->database = $database;
        }
        
    }

?>