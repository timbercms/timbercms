<?php

    require_once(__DIR__ ."/../../../classes/form.php");
    require_once(__DIR__ ."/usergroup.php");

    class UserModel extends Model
    {
        
        public $template = "user.php";
        public $database;
        public $form;
        
        public $id;
        public $username;
        public $real_name;
        public $email;
        public $password;
        public $activated;
        public $blocked;
        public $blocked_reason;
        public $register_time;
        public $last_action_time;
        public $usergroup_id;
        public $usergroup;
        public $avatar;
        
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
        
        public function load($id)
        {
            $temp = $this->database->loadObject("SELECT * FROM #__users WHERE id = ?", array($id));
            $this->id = $temp->id;
            $this->username = $temp->username;
            $this->real_name = $temp->real_name;
            $this->email = $temp->email;
            $this->password = $temp->password;
            $this->activated = $temp->activated;
            $this->blocked = $temp->blocked;
            $this->blocked_reason = $temp->blocked_reason;
            $this->register_time = $temp->register_time;
            $this->last_action_time = $temp->last_action_time;
            $this->usergroup = new UsergroupModel($temp->usergroup_id, $this->database);
            $this->avatar = "https://www.gravatar.com/avatar/" .md5(strtolower(trim($this->email))) ."?s=38";
        }
        
        public function store($table = "", $data = array())
		{
			$data = array();
			$data[] = array("name" => "id", "value" => $this->id);
			$data[] = array("name" => "username", "value" => $this->username);
            $data[] = array("name" => "real_name", "value" => $this->real_name);
            $data[] = array("name" => "email", "value" => $this->email);
            $data[] = array("name" => "activated", "value" => $this->activated);
            $data[] = array("name" => "blocked", "value" => $this->blocked);
            $data[] = array("name" => "blocked_reason", "value" => $this->blocked_reason);
            $data[] = array("name" => "register_time", "value" => $this->register_time);
            $data[] = array("name" => "usergroup_id", "value" => $this->usergroup_id);
			return parent::store("#__users", $data);
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