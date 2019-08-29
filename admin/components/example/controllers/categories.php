<?php

    class CategoriesController
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
            $mod = new CategoryModel(0, $this->model->database);
            foreach ($deletes as $delete)
            {
                $mod->delete($delete);
            }
            $this->model->setMessage("success", (count($deletes) > 1 ? "Categories" : "Category") ." deleted successfully!");
            header('Location: index.php?component=example&controller=categories');
        }
        
    }

?>