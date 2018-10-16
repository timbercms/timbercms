<?php

    require_once(__DIR__ ."/../../../classes/form.php");
    require_once(__DIR__ ."/usergroup.php");

    class UserModel extends Model
    {
        public $component_name = "user";
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
            if (strlen($this->avatar) == 0)
            {
                $this->avatar = "https://www.gravatar.com/avatar/" .md5(strtolower(trim($this->email))) ."?s=200";
            }
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
        
    }

?>