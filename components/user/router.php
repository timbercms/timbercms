<?php

    require_once(__DIR__ ."/models/user.php");

    class UserRouter
    {
        
        public $database;
        public $component = "user";
        
        public function __construct($database)
        {
            $this->database = $database;
        }
        
        public function route($link)
        {
            $parts = explode("&", $link);
            foreach ($parts as $part)
            {
                $string = explode("=", $part);
                switch ($string["0"])
                {
                    case "component":
                        $comp = $string["1"];
                        break;
                    case "controller":
                        $controller = $string["1"];
                        break;
                    case "id":
                        $id = $string["1"];
                        break;
                    case "task":
                        $task = $string["1"];
                        break;
                    case "token":
                        $token = $string["1"];
                        break;
                }
            }
            if ($comp == $this->component)
            {
                if ($controller == "login")
                {
                    return BASE_URL .$this->component ."/login";
                }
                else if ($controller == "profile")
                {
                    $user = new UserModel($id, $this->database);
                    return BASE_URL .$this->component ."/profile/". strtolower($user->username);
                }
                else if ($controller == "register")
                {
                    return BASE_URL .$this->component ."/register";
                }
                else if ($controller == "requestreset")
                {
                    return BASE_URL .$this->component ."/requestreset";
                }
                else if ($controller == "reset")
                {
                    return BASE_URL .$this->component ."/reset";
                }
                else if ($controller == "user")
                {
                    return BASE_URL .$this->component ."/user/?task=". $task.(strlen($token) > 0 ? "&token=". $token : "");
                }
                else if ($controller == "settings")
                {
                    return BASE_URL .$this->component ."/settings";
                }
            }
            else
            {
                return;
            }
        }
        
        public function unroute($parts)
        {
            $new_parts = array();
            if ($parts["1"] == "login")
            {
                $new_parts = ["user", "login", 0];
                return $new_parts;
            }
            else if ($parts["1"] == "profile")
            {
                $user = $this->database->loadObject("SELECT * FROM #__users WHERE LOWER(username) = ?", array($parts["2"]));
                if ($user->id > 0)
                {
                    $new_parts = ["user", "profile", $user->id];
                }
                return $new_parts;
            }
            else if ($parts["1"] == "register")
            {
                $new_parts = ["user", "register", 0];
                return $new_parts;
            }
            else if ($parts["1"] == "user")
            {
                $new_parts = ["user", "user", 0];
                return $new_parts;
            }
            else if ($parts["1"] == "settings")
            {
                $new_parts = ["user", "settings", 0];
                return $new_parts;
            }
            return false;
        }
        
    }

?>