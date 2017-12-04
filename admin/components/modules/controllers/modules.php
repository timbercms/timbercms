<?php

    class ModulesController
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
            $mod = new ModuleModel(0, $this->model->database);
            foreach ($deletes as $delete)
            {
                $mod->delete($delete);
            }
            $mod->setMessage("success", (count($deletes) > 1 ? "Modules" : "Module") ." deleted successfully!");
            header('Location: index.php?component=modules&controller=modules');
        }
        
    }

?>