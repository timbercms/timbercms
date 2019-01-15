<?php

    class RedirectModel extends Model
    {
        public $component_name = "redirects";
        public $table = "redirects";
        public $template = "redirect.php";
        public $database;
        public $form;
        
        public function __construct($id = 0, $database)
        {
            $this->database = $database;
            if ($id > 0)
            {
                $this->load($id);
            }
            $this->form = new Form(__DIR__ ."/../forms/redirect.xml", $this, $this->database);
        }
        
        public function delete($id)
        {
            $this->database->query("DELETE FROM #__redirects WHERE id = ?", array($id));
        }
        
    }

?>