<?php

    class UserController
    {
        
        private $model;
        
        public function __construct($model)
        {
            $this->model = $model;
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
                            Core::hooks()->executeHook("onUserLogin");
                            header("Location: ". Core::route("index.php?component=user&controller=profile&id=". $temp->id));
                        }
                        else
                        {
                            $this->model->setMessage("danger", "Sorry, but those details do not match an account in our system.");
                            // Password is incorrect
                            header("Location: ". Core::route("index.php"));
                        }
                    }
                    else
                    {
                        $this->model->setMessage("danger", "Sorry, but it looks like you haven't activated your account. We previously sent an email to your account which contains an activation link.");
                        header("Location: ". Core::route("index.php"));
                    }
                }
                else
                {
                    $this->model->setMessage("danger", "Sorry, but it appears you have been blocked from logging into this website. The reason given is: <strong>". $temp->blocked_reason ."</strong>");
                    header("Location: ". Core::route("index.php"));
                }
            }
            else
            {
                $this->model->setMessage("danger", "Sorry, but those details do not match an account in our system.");
                // No User with that username found
                header("Location: ". Core::route("index.php"));
            }
        }
        
        public function logout()
        {
            $this->model->logout();
            Core::hooks()->executeHook("onUserLogout");
            $this->model->setMessage("success", "Come back soon!");
            header("Location: ". Core::route("index.php"));
        }
        
        public function register()
        {
            $username = $_POST["username"];
            $password = $_POST["password"];
            $password_again = $_POST["password_again"];
            $email = $_POST["email"];
            $user = $this->model->loadByUsername($username);
            if ($user->id > 0)
            {
                // User already has an account
                $this->model->setMessage("primary", "It looks like you already have an account. If you've forgotten your password, you can reset it <a href='". Core::route("index.php?component=user&controller=requestreset") ."'>here</a>");
            }
            else
            {
                // Register a new account
                if ($this->model->register($username, $password, $email))
                {
                    Core::hooks()->executeHook("onUserRegister");
                    $this->model->setMessage("success", "Thank you for registering an account. We've sent an email to ". $email ." to confirm it's really you. You won't be able to login until you've activated your account.");
                    header("Location: ". Core::route("index.php"));
                }
                else
                {
                    $this->model->setMessage("danger", "Sorry, something went wrong during registration.");
                    header("Location: ". Core::route("index.php"));
                }
            }
        }
        
        public function verify()
        {
            $user = $this->model->database->loadObject("SELECT id FROM #__users WHERE verify_token = ?", array($_GET["token"]));
            if ($user->id > 0)
            {
                $this->model->database->query("UPDATE #__users SET activated = ?, verify_token = ? WHERE id = ?", array(1, '', $user->id));
                Core::hooks()->executeHook("onUserVerify");
                $this->model->setMessage("danger", "Thank you for activating your account, you may now log in.");
                header("Location: ". Core::route("index.php?component=user&controller=login"));
            }
            else
            {
                $this->model->setMessage("danger", "Sorry, but you did not supply a valid verification token");
                header("Location: ". Core::route("index.php"));
            }
        }
        
        public function updateSettings()
        {
            $this->model->database->query("UPDATE #__users SET email = ?", array($_POST["email"]));
            if (strlen($_FILES["avatar"]["name"]) > 0)
            {
                foreach ($_FILES as $key => $file)
                {
                    if ($file["size"] <= 1048576)
                    {
                        $name = explode(".", $file["name"])["0"]."-".time().".jpg";
                        $tmp = $file["tmp_name"];
                        move_uploaded_file($tmp, __DIR__ ."/../../../images/avatars/". $name);
                        $this->model->database->query("UPDATE #__users SET avatar = ?", array("images/avatars/". $name));
                        $this->model->setMessage("success", "Avatar Uploaded");
                        break;
                    }
                    else
                    {
                        $this->model->setMessage("danger", "Your avatar must be below 1MB in filesize.");
                    }
                }
            }
            if (strlen($_POST["password"]) > 0)
            {
                if ($_POST["password"] == $_POST["password_verify"])
                {
                    $this->model->database->query("UPDATE #__users SET password = ?", array(password_hash($_POST["password"], PASSWORD_DEFAULT)));
                    $this->model->setMessage("success", "New password saved");
                }
                else
                {
                    $this->model->setMessage("danger", "The passwords you entered do not match");
                }
            }
            Core::hooks()->executeHook("onUserUpdateSettings");
            header("Location: ". Core::route("index.php?component=user&controller=settings"));
        }
        
    }

?>