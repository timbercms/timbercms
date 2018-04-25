<?php

    class UsersModel extends Model
    {
        
        public $template = "users.php";
        public $database;
        
        public $users = array();
        public $settings;
        
        public function __construct($id = 0, $database)
        {
            $this->database = $database;
            $this->load();
            $this->settings = simplexml_load_file(__DIR__ ."/../extension.xml");
        }
        
        public function load()
        {
            $temp_users = $this->database->loadObjectList("SELECT id FROM #__users");
            foreach ($temp_users as $temp_user)
            {
                $user = new UserModel($temp_user->id, $this->database);
                $this->users[] = $user;
            }
        }
        
    }

?>