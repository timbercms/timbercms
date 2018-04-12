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
        
        public function save()
        {
            $this->model->id = $_POST["id"];
            $this->model->username = $_POST["username"];
            $this->model->email = $_POST["email"];
            $this->model->activated = $_POST["activated"];
            $this->model->blocked = $_POST["blocked"];
            $this->model->blocked_reason = $_POST["blocked_reason"];
            $this->model->register_time = ($_POST["register_time"] > 0 ? $_POST["register_time"] : time());
            $this->model->usergroup_id = $_POST["usergroup_id"];
            if ($this->model->store())
            {
                $this->model->setMessage("success", "User saved");
            }
            else
            {
                $this->model->setMessage("danger", "Something went wrong during saving");
            }
            header("Location: index.php?component=user&controller=users");
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
        
    }

?>