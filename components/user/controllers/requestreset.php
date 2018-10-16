<?php

    class RequestResetController
    {
        private $model;
        
        public function __construct($model)
        {
            Core::changeTitle("Request Password Reset");
            $this->model = $model;
            if (Core::config()->enable_recaptcha == 1)
            {
                Core::addScript("https://www.google.com/recaptcha/api.js");
            }
        }
        
        public function reset()
        {
            if (Core::config()->enable_recaptcha == 1)
            {
                if ($this->model->checkCaptcha())
                {
                    $this->processReset();
                }
                else
                {
                    $this->model->setMessage("danger", "ReCaptcha verification failed.");
                    header("Location: ". Core::route("index.php?component=user&controller=requestreset"));
                }
            }
            else
            {
                $this->processReset();
            }
        }
        
        public function processReset()
        {
            $user = $this->model->database->loadObject("SELECT id FROM #__users WHERE email = ?", array($_POST["email"]));
            if ($user->id > 0)
            {
                // Delete all previous reset attempts
                $this->model->database->query("DELETE FROM #__users_recovery WHERE user_id = ?", array($user->id));
                $this->model->database->query("INSERT INTO #__users_recovery (user_id, reset_requested, token) VALUES (?, ?, ?)", array($user->id, time(), $user->id.time().(time() + rand(64726))));
                Core::hooks()->executeHook("onRequestReset");
                $this->model->setMessage("success", "We've just sent an email to ". $_POST["email"] ." containing a link that you can use to reset your password");
                header("Location: ". Core::route("index.php?component=user&controller=requestreset"));
            }
            else
            {
                $this->model->setMessage("danger", "We couldn't find an account associated with this email address.");
                header("Location: ". Core::route("index.php?component=user&controller=requestreset"));
            }
        }
        
    }

?>