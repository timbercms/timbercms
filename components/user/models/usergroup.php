<?php

    class UsergroupModel
    {
        
        public $template = "groups.php";
        public $database;
        
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
        }
        
        public function load($id)
        {
            $temp = $this->database->loadObject("SELECT * FROM #__usergroups WHERE id = ?", array($id));
            $this->id = $temp->id;
            $this->title = $temp->title;
            $this->is_admin = $temp->is_admin;
        }
        
    }

?>