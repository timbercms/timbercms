<?php

    class ResetController
    {
        private $model;
        
        public function __construct($model)
        {
            $this->model = $model;
        }
        
        public function reset()
        {
            $reset = $this->model->database->loadObject("SELECT id, user_id FROM #__users_recovery WHERE token = ?", array($_POST["token"]));
            if ($reset->id > 0)
            {
                if ($_POST["password"] == $_POST["password_again"])
                {
                    $this->model->database->query("UPDATE #__users SET password = ? WHERE id = ?", array(password_hash($_POST["password"], PASSWORD_DEFAULT), $reset->user_id));
                    $this->model->setMessage("success", "Your password has been reset. You may now login using your new password.");
                    header("Location: index.php?component=user&controller=login");
                }
                else
                {
                    $this->model->setMessage("danger", "Sorry, but the two password you entered did not appear to match.");
                    header("Location: index.php?component=user&controller=reset&token=". $_POST["token"]);
                }
            }
            else
            {
                $this->model->setMessage("danger", "Sorry, something went wrong when trying to access your recovery options. Please try again, or contact us.");
                header("Location: index.php?component=user&controller=reset");
            }
        }
        
    }

?>