<?php

    require_once(__DIR__ ."/../../../classes/form.php");

    class ModuleModel extends Model
    {
        public $component_name = "modules";
        public $table = "modules";
        public $template = "module.php";
        public $database;
        public $form;
        public $params_form;
        
        public function __construct($id = 0, $database)
        {
            $this->database = $database;
            if ($id > 0)
            {
                $this->load($id);
            }
            $this->form = new Form(__DIR__ ."/../forms/module.xml", $this, $this->database);
            $this->getParams();
        }
        
        public function processData()
        {
            $this->params = (object) $this->params;
            $this->pages = explode(",", $this->pages);
        }
        
        public function preStoreData()
        {
            if ($this->id <= 0)
            {
                $module = $this->database->loadObject("SELECT id, ordering FROM #__modules WHERE position = ? ORDER BY ordering DESC LIMIT 1", array($this->position));
                if ($module->id > 0)
                {
                    $this->ordering = $module->ordering + 1;
                }
                else
                {
                    $this->ordering = 0;
                }
            }
        }
        
        public function getParams()
        {
            $this->params_form = new Form(__DIR__ ."/../../../../modules/". (strlen($this->type) > 0 ? $this->type : $_GET["type"]) ."/module.xml", $this->params, $this->database);
        }
        
        public function delete($id)
        {
            $this->database->query("DELETE FROM #__modules WHERE id = ?", array($id));
        }
        
    }

?>