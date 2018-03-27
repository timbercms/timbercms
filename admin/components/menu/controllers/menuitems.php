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
            $this->model->setMessage("success", (count($deletes) > 1 ? "Menuitems" : "Menuitem") ." deleted successfully!");
            header('Location: index.php?component=menu&controller=menuitems&id='. $_GET["id"]);
        }
        
        public function order()
        {
            $swap = $_GET["swap"];
            $with = $_GET["with"];
            $menu_id = $_GET["menu_id"];
            $parent_id = $_GET["parent_id"];
            $this->model->database->query("UPDATE #__menus_items SET ordering = ? WHERE ordering = ? AND menu_id = ? AND parent_id = ?", array($swap ."-". $with, $swap, $menu_id, $parent_id));
            $this->model->database->query("UPDATE #__menus_items SET ordering = ? WHERE ordering = ? AND menu_id = ? AND parent_id = ?", array($swap, $with, $menu_id, $parent_id));
            $this->model->database->query("UPDATE #__menus_items SET ordering = ? WHERE ordering = ? AND menu_id = ? AND parent_id = ?", array($with, $swap ."-". $with, $menu_id, $parent_id));
            $this->model->setMessage("success", "Menu Items reordered");
            header('Location: index.php?component=menu&controller=menuitems&id='. $menu_id);
        }
        
    }

?>