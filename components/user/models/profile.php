<?php

    class ProfileModel
    {
        
        public $template = "profile.php";
        public $database;
        
        public $user;
        
        public function __construct($id = 0, $database)
        {
            $this->database = $database;
            $this->user = new UserModel($id, $this->database);
        }
        
    }

?>