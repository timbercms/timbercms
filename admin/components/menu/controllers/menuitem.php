<?php

    class MenuitemController
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
            $this->model->menu_id = $_POST["menu_id"];
            $this->model->parent_id = $_POST["parent_id"];
            $this->model->title = $_POST["title"];
            $this->model->alias = $_POST["alias"];
            $this->model->published = $_POST["published"];
            $this->model->access_group = $_POST["access_group"];
            $this->model->component = $_POST["component"];
            $this->model->controller = $_POST["controller"];
            $this->model->content_id = $_POST["content_id"];
            $this->model->params = $_POST["params"];
            $this->model->is_home = $_POST["is_home"];
            $this->model->ordering = $_POST["ordering"];
            if ($this->model->store())
            {
                $this->model->setMessage("success", "Menu item saved");
            }
            else
            {
                $this->model->setMessage("danger", "Something went wrong during saving");
            }
            if ($_POST["id"] > 0)
            {
                $id = $_POST["id"];
            }
            else
            {
                $id = $this->model->database->lastInsertId();
            }
            header("Location: index.php?component=menu&controller=menuitem&id=". $id ."&menu_id=". $_POST["menu_id"]);
        }
        
        public function publish()
        {
            $this->model->database->query("UPDATE #__menus_items SET published = '1' WHERE id = ?", array($_GET["id"]));
            $this->model->setMessage("success", "Menu item published");
            header("Location: index.php?component=menu&controller=menuitems&id=". $_GET["menu_id"]);
        }
        
        public function unpublish()
        {
            $this->model->database->query("UPDATE #__menus_items SET published = '0' WHERE id = ?", array($_GET["id"]));
            $this->model->setMessage("success", "Menu item unpublished");
            header("Location: index.php?component=menu&controller=menuitems&id=". $_GET["menu_id"]);
        }
        
    }

?>