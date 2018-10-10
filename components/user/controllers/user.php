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
            if (Core::config()->enable_recaptcha == 1)
            {
                if ($this->model->checkCaptcha())
                {
                    $this->processRegister();
                }
                else
                {
                    $this->model->setMessage("danger", "ReCaptcha verification failed.");
                    header("Location: ". Core::route("index.php?component=user&controller=register"));
                }
            }
            else
            {
                $this->processRegister();
            }
        }
        
        public function processRegister()
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
                if ($this->model->register($username, $password, $email, $_POST["name"]))
                {
                    $user = $this->model->database->loadObject("SELECT * FROM #__users WHERE username = ?", array($username));
                    $component = $this->model->database->loadObject("SELECT * FROM #__components WHERE internal_name = ?", array("contact"));
                    $params = (object) unserialize($component->params);
                    $email = $user->email;
                    $subject = 'Account Activation Required - '. Core::config()->site_title;
                    $headers = "From: ". $params->admin_email ."\r\n";
                    $headers .= "Reply-To: ". $params->admin_email ."\r\n";
                    $headers .= "MIME-Version: 1.0\r\n";
                    $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
                    $message = '<html><body>';
                        $message .= '<h4>Account Activation Required - '. Core::config()->site_title .'</h4>';
                        $message .= '<p>Hi '. $user->username .',</p>';
                        $message .= '<p>In order to access your account we require that you verify yourself. Please click the following link to activate your account: <a href="'. Core::route("index.php?component=user&controller=user&task=verify&token=". $user->verify_token) .'">Click here to activate</a></p>';
                        $message .= '<p>Thanks,<br />'. Core::config()->site_title .' Management</p>';
                    $message .= '</body></html>';
                    mail($email, $subject, $message, $headers);
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
            $user = $this->model->database->loadObject("SELECT * FROM #__users WHERE verify_token = ?", array($_GET["token"]));
            if ($user->id > 0)
            {
                $this->model->database->query("UPDATE #__users SET activated = ?, verify_token = ? WHERE id = ?", array(1, '', $user->id));
                Core::hooks()->executeHook("onUserVerify");
                $this->model->setMessage("success", "Thank you for activating your account, you may now log in.");
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
            $this->model->database->query("UPDATE #__users SET name = ? WHERE id = ?", array($_POST["name"], Core::user()->id));
            $this->model->database->query("UPDATE #__users SET email = ? WHERE id = ?", array($_POST["email"], Core::user()->id));
            $this->model->database->query("UPDATE #__users SET params = ? WHERE id = ?", array(serialize($_POST["params"]), Core::user()->id));
            if (strlen($_FILES["avatar"]["name"]) > 0)
            {
                foreach ($_FILES as $key => $file)
                {
                    if ($file["size"] <= 1048576)
                    {
                        $name = explode(".", $file["name"])["0"]."-".time().".jpg";
                        $tmp = $file["tmp_name"];
                        move_uploaded_file($tmp, __DIR__ ."/../../../images/avatars/". $name);
                        $this->model->database->query("UPDATE #__users SET avatar = ? WHERE id = ?", array("images/avatars/". $name, Core::user()->id));
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
                    $this->model->database->query("UPDATE #__users SET password = ? WHERE id = ?", array(password_hash($_POST["password"], PASSWORD_DEFAULT), Core::user()->id));
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