<?php

    class UsersModel extends Model
    {
        
        public $template = "users.php";
        public $database;
        public $pagination;
        
        public $users = array();
        public $settings;
        
        public function __construct($id = 0, $database)
        {
            $this->database = $database;
            $this->load();
            $this->settings = simplexml_load_file(__DIR__ ."/../extension.xml");
            $this->pagination = new Pagination();
        }
        
        public function load($id = false)
        {
            $query = "SELECT id FROM #__users";
            if (strlen($_GET["q"]) > 0)
            {
                $query .= " WHERE (username LIKE '%". $_GET["q"] ."%' OR name LIKE '%". $_GET["q"] ."%' OR email LIKE '%". $_GET["q"] ."%')";
            }
            $query .= " ORDER BY register_time DESC";
            $this->max = count($this->database->loadObjectList($query));
            $query .= " LIMIT ". ($_GET["p"] > 0 ? (($_GET["p"] - 1) * 20) : 0) .", 20";
            $temp_users = $this->database->loadObjectList($query);
            foreach ($temp_users as $temp_user)
            {
                $user = new UserModel($temp_user->id, $this->database);
                $this->users[] = $user;
            }
        }
        
    }

?>