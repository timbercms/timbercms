<?php

    class UsersController
    {
        
        private $model;
        private $core;
        
        public function __construct($model, $core)
        {
            $this->model = $model;
            $this->core = $core;
        }
        
        public function delete()
        {
            $deletes = $_POST["ids"];
            $mod = new UserModel(0, $this->model->database, false);
            foreach ($deletes as $delete)
            {
                $mod->delete($delete);
            }
            $mod->setMessage("success", (count($deletes) > 1 ? "Users" : "User") ." deleted successfully!");
            header('Location: index.php?component=user&controller=users');
        }
        
    }

?>