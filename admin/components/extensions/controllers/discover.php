<?php

    class DiscoverController
    {
        
        private $model;
        private $core;
        
        public function __construct($model, $core)
        {
            $this->model = $model;
            $this->core = $core;
        }
        
        public function install()
        {
            $extension = $_GET["extension"];
            $xml = simplexml_load_file(__DIR__ ."/../../". $extension ."/extension.xml");
            if (strlen($xml) > 0)
            {
                $this->model->database->query("INSERT INTO #__components (title, description, internal_name, is_frontend, is_backend, is_locked, author_name, author_url, version, enabled) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", array($xml->title, $xml->description, $extension, $xml->is_frontend, $xml->is_backend, $xml->is_locked, $xml->author, $xml->author_url, $xml->version, 1));
                $this->model->setMessage("success", "Extension installed");
                header("Location: index.php?component=extensions&controller=extensions");
            }
            else
            {
                $this->model->setMessage("danger", "No extension.xml file was found. Please check files and retry.");
                header("Location: index.php?component=extensions&controller=discover");
            }
        }
        
    }

?>