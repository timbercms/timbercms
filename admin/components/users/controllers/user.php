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
            $this->model->store();
            header("Location: index.php?component=users&controller=users");
        }
        
    }

?>