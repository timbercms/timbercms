<?php

    require_once(__DIR__ ."/../../../classes/form.php");
    require_once(__DIR__ ."/usergroup.php");

    class UserModel extends Model
    {
        public $component = "user";
        public $table = "users";
        public $template = "user.php";
        public $database;
        public $form;
        
        public function __construct($id = 0, $database, $load_session = true)
        {
            $this->database = $database;
            if ($id > 0)
            {
                $this->load($id);
            }
            else
            {
                if ($load_session)
                {
                    $this->loadSession();
                }
            }
            $this->form = new Form(__DIR__ ."/../forms/user.xml", $this, $this->database);
        }
        
        public function processData()
        {
            $this->usergroup = new UsergroupModel($this->usergroup_id, $this->database);
            $this->avatar = "https://www.gravatar.com/avatar/" .md5(strtolower(trim($this->email))) ."?s=38";
        }
        
        public function loadSession()
        {
            $session_id = (strlen($_COOKIE["bgdy_session_id"]) > 0 ? $_COOKIE["bgdy_session_id"] : session_id());
            $session = $this->database->loadObject("SELECT * FROM #__sessions WHERE php_session_id = ?", array($session_id));
            if ($session->id > 0)
            {
                $this->load($session->user_id);
                $this->database->query("UPDATE #__sessions SET last_action_time = ? WHERE user_id = ?", array(time(), $this->id));
            }
        }
        
        public function delete($id)
        {
            $this->database->query("DELETE FROM #__users WHERE id = ?", array($id));
        }
        
    }

?>