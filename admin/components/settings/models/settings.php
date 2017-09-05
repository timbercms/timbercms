<?php

    require_once(__DIR__ ."/../../../classes/form.php");
    require_once(__DIR__ ."/../../extensions/models/extension.php");

    class SettingsModel
    {
        
        public $template = "settings.php";
        public $database;
        public $form;
        public $extension;
        
        public function __construct($id = 0, $database)
        {
            $this->database = $database;
            $this->extension = new ExtensionModel($id, $this->database);
            if (strlen($_GET["extension"]) > 0)
            {
                $ext = $_GET["extension"];
            }
            else if (strlen($_POST["extension"]) > 0)
            {
                $ext = $_POST["extension"];
            }
            else
            {
                $ext = "settings";
            }
            $this->extension->loadByName($ext);
            $this->form = new Form(__DIR__ ."/../../". $this->extension->internal_name ."/extension.xml", $this->extension->params, $this->database);
        }
        
    }

?>