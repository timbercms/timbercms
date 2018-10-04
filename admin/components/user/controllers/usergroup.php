<?php

    class UsergroupController
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
            header("Location: index.php?component=user&controller=usergroup");
        }
        
        public function save($redirect = true)
        {
            foreach ($_POST as $key => $value)
            {
                $this->model->$key = $value;
            }
            if ($this->model->store())
            {
                $this->model->setMessage("success", "Usergroup saved");
            }
            else
            {
                $this->model->setMessage("danger", "Something went wrong during saving");
            }
            if ($redirect)
            {
                header("Location: index.php?component=user&controller=usergroups");
            }
        }
        
    }

?>