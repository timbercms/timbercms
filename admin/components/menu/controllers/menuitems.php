<?php

    class MenuitemsController
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
            $mod = new MenuitemModel(0, $this->model->database);
            foreach ($deletes as $delete)
            {
                $mod->delete($delete);
            }
            $mod->setMessage("success", (count($deletes) > 1 ? "Menuitems" : "Menuitem") ." deleted successfully!");
            header('Location: index.php?component=menu&controller=menuitems&id='. $_GET["id"]);
        }
        
    }

?>