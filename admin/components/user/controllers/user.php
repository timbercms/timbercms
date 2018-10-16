<?php

    class UserController
    {
        
        private $model;
        private $core;
        
        public function __construct($model, $core)
        {
            $this->model = $model;
            $this->core = $core;
        }
        
        public function saveandnew()
        {
            $this->save(false);
            header("Location: index.php?component=user&controller=user");
        }
        
        public function save($redirect = true)
        {
            $admin_groups = $this->model->database->loadObjectList("SELECT id FROM #__usergroups WHERE is_admin = ?", array("1"));
            $admins = array();
            foreach ($admin_groups as $group)
            {
                $admins[] = $group->id;
            }
            if ($_POST["id"] > 0)
            {
                $this->model->load($_POST["id"]);
                if (in_array($this->model->usergroup_id, $admins) && $_POST["id"] != Core::user()->id)
                {
                    Core::log(Core::user()->username ." modified ". $_POST["username"] ."'s administrator account");
                }
            }
            else if ($_POST["id"] <= 0 && in_array($_POST["usergroup_id"], $admins))
            {
                Core::log(Core::user()->username ." created a new administrator with the username ". $_POST["username"] ."");
            }
            foreach ($_POST as $key => $value)
            {
                if ($_POST["id"] > 0)
                {
                    if ($key == "password")
                    {
                        if (password_hash($value, PASSWORD_DEFAULT) != $this->model->password)
                        {
                            $value = password_hash($_POST["password"], PASSWORD_DEFAULT);
                        }
                    }
                }
                $this->model->$key = $value;
            }
            if (strlen($_FILES["avatar"]["name"]) > 0)
            {
                foreach ($_FILES as $key => $file)
                {
                    if ($file["size"] <= 1048576)
                    {
                        $name = explode(".", $file["name"])["0"]."-".time().".jpg";
                        $tmp = $file["tmp_name"];
                        move_uploaded_file($tmp, __DIR__ ."/../../../../images/avatars/". $name);
                        $this->model->avatar = "images/avatars/". $name;
                        break;
                    }
                    else
                    {
                        $this->model->setMessage("danger", "Your avatar must be below 1MB in filesize.");
                    }
                }
            }
            $this->model->register_time = ($_POST["register_time"] > 0 ? $_POST["register_time"] : time());
            if ($this->model->store())
            {
                $this->model->setMessage("success", "User saved");
            }
            else
            {
                $this->model->setMessage("danger", "Something went wrong during saving");
            }
            if ($redirect)
            {
                header("Location: index.php?component=user&controller=users");
            }
        }
        
        public function activate()
        {
            $this->model->database->query("UPDATE #__users SET activated = '1' WHERE id = ?", array($_GET["id"]));
            $this->model->setMessage("success", "User activated");
            header("Location: index.php?component=user&controller=users");
        }
        
        public function deactivate()
        {
            $this->model->database->query("UPDATE #__users SET activated = '0' WHERE id = ?", array($_GET["id"]));
            $this->model->setMessage("success", "User deactivated");
            header("Location: index.php?component=user&controller=users");
        }
        
        public function block()
        {
            $this->model->database->query("UPDATE #__users SET blocked = '1' WHERE id = ?", array($_GET["id"]));
            $this->model->setMessage("success", "User blocked");
            header("Location: index.php?component=user&controller=users");
        }
        
        public function unblock()
        {
            $this->model->database->query("UPDATE #__users SET blocked = '0' WHERE id = ?", array($_GET["id"]));
            $this->model->setMessage("success", "User unblocked");
            header("Location: index.php?component=user&controller=users");
        }
        
        public function login()
        {
            $username = $_POST["username"];
            $password = $_POST["password"];
            $temp = $this->model->database->loadObject("SELECT * FROM #__users WHERE username = ?", array($username));
            if ($temp->id > 0)
            {
                if ($temp->blocked == 0)
                {
                    if ($temp->activated == 1)
                    {
                        if (password_verify($password, $temp->password))
                        {
                            $this->model->setMessage("success", "Welcome back, ". $username);
                            // Login as details are correct
                            $this->model->login($temp->id, $_POST["remember"]);
                            header("Location: index.php");
                        }
                        else
                        {
                            $this->model->setMessage("danger", "Sorry, but those details do not match an account in our system.");
                            // Password is incorrect
                            header("Location: index.php");
                        }
                    }
                    else
                    {
                        $this->model->setMessage("danger", "Sorry, but it looks like you haven't activated your account. We previously sent an email to your account which contains an activation link.");
                        header("Location: index.php");
                    }
                }
                else
                {
                    $this->model->setMessage("danger", "Sorry, but it appears you have been blocked from logging into this website. The reason given is: <strong>". $temp->blocked_reason ."</strong>");
                    header("Location: index.php");
                }
            }
            else
            {
                $this->model->setMessage("danger", "Sorry, but those details do not match an account in our system.");
                // No User with that username found
                header("Location: index.php");
            }
        }
        
        public function logout()
        {
            $this->model->logout();
            $this->model->setMessage("success", "Come back soon!");
            header("Location: index.php");
        }
        
    }

?>