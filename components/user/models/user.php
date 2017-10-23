<?php

    require_once(__DIR__ ."/usergroup.php");

    class UserModel extends Model
    {
        
        public $template = "profile.php";
        public $database;
        
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
        public $usergroup;
        public $verify_token;
        
        public function __construct($id = 0, $database)
        {
            $this->database = $database;
            if ($id > 0)
            {
                $this->load($id);
            }
            else
            {
                $this->loadSession();
            }
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
            $this->verify_token = $temp->verify_token;
        }
        
        public function loadSession()
        {
            $session_id = (strlen($_COOKIE["bgdy_session_id"]) > 0 ? $_COOKIE["bgdy_session_id"] : session_id());
            $session = $this->database->loadObject("SELECT * FROM #__sessions WHERE php_session_id = ?", array($session_id));
            if ($session->id > 0)
            {
                $this->load($session->user_id);
                $this->database->query("UPDATE #__sessions SET last_action_time = ? WHERE user_id = ?", array(time(), $this->id));
                $this->database->query("UPDATE #__users SET last_action_time = ? WHERE id = ?", array(time(), $session->user_id));
            }
        }
        
        public function login($id)
        {
            $session_id = (strlen($_COOKIE["bgdy_session_id"]) > 0 ? $_COOKIE["bgdy_session_id"] : session_id());
            $session = $this->database->loadObject("SELECT * FROM #__sessions WHERE user_id = ?", array($id));
            if ($session->id > 0)
            {
                $this->database->query("UPDATE #__sessions SET last_action_time = ?, php_session_id = ? WHERE user_id = ?", array(time(), $session_id, $id));
            }
            else
            {
                $this->database->query("INSERT INTO #__sessions (php_session_id, user_id, last_action_time) VALUES (?, ?, ?)", array($session_id, $id, time()));
            }
            setcookie("bgdy_session_id", $session_id, time() + (86400 * 30), "/");
        }
        
        public function logout()
        {
            $session_id = (strlen($_COOKIE["bgdy_session_id"]) > 0 ? $_COOKIE["bgdy_session_id"] : session_id());
            $session = $this->database->loadObject("SELECT * FROM #__sessions WHERE php_session_id = ?", array($session_id));
            if ($session->id > 0)
            {
                $this->database->query("DELETE FROM #__sessions WHERE id = ?", array($session->id));
                setcookie("bgdy_session_id", "", time() - (86400 * 30), "/");
                unset($_COOKIE["bgdy_session_id"]);
                session_destroy();
            }
        }
        
        public function loadByUsername($username)
        {
            $temp = $this->database->loadObject("SELECT id FROM #__users WHERE username = ?", array($username));
            $this->load($id);
        }
        
        public function register($username, $real_name, $password, $email)
        {
			$data = array();
			$data[] = array("name" => "id", "value" => 0);
			$data[] = array("name" => "username", "value" => $username);
            $data[] = array("name" => "real_name", "value" => $real_name);
            $data[] = array("name" => "password", "value" => password_hash($password, PASSWORD_DEFAULT));
            $data[] = array("name" => "email", "value" => $email);
            $data[] = array("name" => "activated", "value" => 0);
            $data[] = array("name" => "blocked", "value" => 0);
            $data[] = array("name" => "blocked_reason", "value" => "");
            $data[] = array("name" => "register_time", "value" => time());
            $data[] = array("name" => "usergroup_id", "value" => 1);
            $data[] = array("name" => "verify_token", "value" => md5($email).time().(time() + rand(67234)));
			return parent::store("#__users", $data);
        }
        
    }

?>