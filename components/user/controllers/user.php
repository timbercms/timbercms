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
                if ($temp->activated == 1)
                {
                    if (password_verify($password, $temp->password))
                    {
                        $this->model->setMessage("success", "Welcome back, ". $username);
                        // Login as details are correct
                        $this->model->login($temp->id);
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
                    $this->model->setMessage("danger", "Sorry, but it looks like you haven't activated your account. We sent an email to ". $temp->email ." which contains an activation link.");
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
            $this->model->setMessage("success", "Come back soon!");
            header("Location: ". Core::route("index.php"));
        }
        
        public function register()
        {
            $username = $_POST["username"];
            $real_name = $_POST["real_name"];
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
                if ($this->model->register($username, $real_name, $password, $email))
                {
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
                    if (strlen($file["name"]) > 0)
                    {
                        $name = explode(".", $file["name"])["0"]."-".time().".jpg";
                        $tmp = $file["tmp_name"];
                        move_uploaded_file($tmp, __DIR__ ."/../../../images/avatars/". $name);
                        $this->model->database->query("UPDATE #__users SET avatar = ?", array("images/avatars/". $name));
                        break;
                    }
                    else
                    {
                        return false;
                    }
                }
            }
            if (strlen($_POST["password"]) > 0)
            {
                if ($_POST["password"] == $_POST["password_verify"])
                {
                    $this->model->database->query("UPDATE #__users SET password = ?", array(password_hash($_POST["password"], PASSWORD_DEFAULT)));
                    $this->model->setMessage("success", "Changes Saved");
                    header("Location: ". Core::route("index.php?component=user&controller=settings"));
                }
                else
                {
                    $this->model->setMessage("danger", "The passwords you entered do not match");
                    header("Location: ". Core::route("index.php?component=user&controller=settings"));
                }
            }
            else
            {
                $this->model->setMessage("success", "Changes Saved");
                header("Location: ". Core::route("index.php?component=user&controller=settings"));
            }
        }
        
    }

?>