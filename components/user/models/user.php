<?php

    require_once(__DIR__ ."/usergroup.php");

    class UserModel extends Model
    {
        public $component = "user";
        public $table = "users";
        public $template = "profile.php";
        public $database;
        
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
        
        public function processData()
        {
            $this->usergroup = new UsergroupModel($this->usergroup_id, $this->database);
            $this->params = (object) $this->params;
            if (strlen($this->avatar) > 0)
            {
                if (substr($this->avatar, 0, 5) != "https")
                {
                    $this->avatar = BASE_URL.$this->avatar;
                }
            }
            else
            {
                $this->avatar = "https://www.gravatar.com/avatar/" .md5(strtolower(trim($this->email))) ."?s=200";
            }
            Core::hooks()->executeHook("onLoadUserModel", $this);
        }
        
        public function loadSession()
        {
            $session_id = (strlen($_COOKIE[Core::config()->cookie_name]) > 0 ? $_COOKIE[Core::config()->cookie_name] : session_id());
            $session = $this->database->loadObject("SELECT * FROM #__sessions WHERE php_session_id = ?", array($session_id));
            if ($session->id > 0)
            {
                $this->load($session->user_id);
                $this->database->query("UPDATE #__sessions SET last_action_time = ? WHERE user_id = ?", array(time(), $this->id));
                $this->database->query("UPDATE #__users SET last_action_time = ? WHERE id = ?", array(time(), $session->user_id));
            }
        }
        
        public function login($id, $remember = false)
        {
            $session_id = (strlen($_COOKIE[Core::config()->cookie_name]) > 0 ? $_COOKIE[Core::config()->cookie_name] : session_id());
            $session = $this->database->loadObject("SELECT * FROM #__sessions WHERE user_id = ?", array($id));
            if ($session->id > 0)
            {
                $this->database->query("UPDATE #__sessions SET last_action_time = ?, php_session_id = ? WHERE user_id = ?", array(time(), $session_id, $id));
            }
            else
            {
                $this->database->query("INSERT INTO #__sessions (php_session_id, user_id, last_action_time) VALUES (?, ?, ?)", array($session_id, $id, time()));
            }
            if ($remember)
            {
                setcookie(Core::config()->cookie_name, $session_id, time() + (86400 * (Core::config()->cookie_duration > 0 ? Core::config()->cookie_duration : 28)), COOKIE_DOMAIN);
            }
        }
        
        public function logout()
        {
            $session_id = (strlen($_COOKIE[Core::config()->cookie_name]) > 0 ? $_COOKIE[Core::config()->cookie_name] : session_id());
            $session = $this->database->loadObject("SELECT * FROM #__sessions WHERE php_session_id = ?", array($session_id));
            if ($session->id > 0)
            {
                $this->database->query("DELETE FROM #__sessions WHERE id = ?", array($session->id));
                setcookie(Core::config()->cookie_name, "", time() - (86400 * (Core::config()->cookie_duration > 0 ? Core::config()->cookie_duration : 28)), COOKIE_DOMAIN);
                unset($_COOKIE[Core::config()->cookie_name]);
                session_destroy();
                session_start();
            }
        }
        
        public function loadByUsername($username)
        {
            $temp = $this->database->loadObject("SELECT id FROM #__users WHERE username = ?", array($username));
            $this->load($id);
        }
        
        public function register($username, $password, $email)
        {
			$data = array();
			$data[] = array("name" => "id", "value" => 0);
			$data[] = array("name" => "username", "value" => $username);
            $data[] = array("name" => "password", "value" => password_hash($password, PASSWORD_DEFAULT));
            $data[] = array("name" => "email", "value" => $email);
            $data[] = array("name" => "activated", "value" => 0);
            $data[] = array("name" => "blocked", "value" => 0);
            $data[] = array("name" => "blocked_reason", "value" => "");
            $data[] = array("name" => "register_time", "value" => time());
            $data[] = array("name" => "usergroup_id", "value" => Core::config()->default_usergroup);
            $data[] = array("name" => "verify_token", "value" => md5($email).time().(time() + rand(67234)));
			return parent::store("#__users", $data);
        }
        
        public function updateSettings($table = "", $data = array(), $updatePassword = false)
		{
			$data = array();
			$data[] = array("name" => "id", "value" => $this->id);
			$data[] = array("name" => "username", "value" => $this->username);
            $data[] = array("name" => "email", "value" => $this->email);
            $data[] = array("name" => "activated", "value" => $this->activated);
            $data[] = array("name" => "blocked", "value" => $this->blocked);
            $data[] = array("name" => "blocked_reason", "value" => $this->blocked_reason);
            $data[] = array("name" => "register_time", "value" => $this->register_time);
            $data[] = array("name" => "usergroup_id", "value" => $this->usergroup_id);
            $data[] = array("name" => "params", "value" => serialize($this->params));
            if ($updatePassword)
            {
                $data[] = array("name" => "password", "value" => password_hash($this->password, PASSWORD_DEFAULT));
            }
			return parent::store("#__users", $data);
		}
        
    }

?>