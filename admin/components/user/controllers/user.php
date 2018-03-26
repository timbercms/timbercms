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
            $this->model->real_name = $_POST["real_name"];
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
        
    }

?>