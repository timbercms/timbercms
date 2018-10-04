<?php

    require_once(__DIR__ ."/../../../classes/form.php");

    class UsergroupModel extends Model
    {
        public $component = "user";
        public $table = "usergroups";
        public $template = "usergroup.php";
        public $database;
        public $form;
        
        public $id;
        public $title;
        public $is_admin;
        
        public function __construct($id = 0, $database)
        {
            $this->database = $database;
            if ($id > 0)
            {
                $this->load($id);
            }
            $this->form = new Form(__DIR__ ."/../forms/usergroup.xml", $this, $this->database);
        }
        
        public function delete($id)
        {
            $this->database->query("DELETE FROM #__usergroups WHERE id = ?", array($id));
        }
        
    }

?>