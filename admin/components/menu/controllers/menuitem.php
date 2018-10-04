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
        
        public function saveandnew()
        {
            $this->save(false);
            header("Location: index.php?component=menu&controller=newitem&menu_id=". $_GET["menu_id"]);
        }
        
        public function save($redirect = true)
        {
            foreach ($_POST as $key => $value)
            {
                $this->model->$key = $value;
            }
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
            if ($redirect)
            {
                header("Location: index.php?component=menu&controller=menuitem&id=". $id ."&menu_id=". $_POST["menu_id"]);
            }
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