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
            foreach ($_POST as $key => $value)
            {
                $this->model->$key = $value;
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
        
    }

?>