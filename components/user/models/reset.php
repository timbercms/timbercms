<?php

    class ResetModel extends Model
    {
        
        public $template = "reset.php";
        public $database;
        
        public $id;
        public $user_id;
        public $reset_requested;
        public $token;
        
        public function __construct($id = 0, $database)
        {
            $this->database = $database;
            if (strlen($_GET["token"]) > 0)
            {
                $this->load($_GET["token"]);
            }
        }
        
        public function load($token)
        {
            $temp = $this->database->loadObject("SELECT * FROM #__users_recovery WHERE token = ?", array($token));
            $this->id = $temp->id;
            $this->user_id = $temp->user_id;
            $this->reset_requested = $temp->reset_requested;
            $this->token = $temp->token;
        }
        
    }

?>