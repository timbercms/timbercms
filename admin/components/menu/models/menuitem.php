<?php

    class MenuitemModel extends Model
    {
        public $component = "menu";
        public $table = "menus_items";
        public $database;
        public $template = "menuitem.php";
        public $form;
        public $children = array();
        
        public function __construct($id = 0, $database)
        {
            $this->database = $database;
            if ($id > 0)
            {
                $this->load($id);
            }
            $this->getControllers();
            $this->form = new Form(__DIR__ ."/../forms/menuitem.xml", $this, $this->database);
        }
        
        public function processData()
        {
            $temp_children = $this->database->loadObjectList("SELECT id FROM #__menus_items WHERE parent_id = ? ORDER BY ordering ASC", array($this->id));
            if (count($temp_children) > 0)
            {
                foreach ($temp_children as $child)
                {
                    $this->children[] = new MenuitemModel($child->id, $this->database);
                }
            }
        }
        
        public function preStoreData()
        {
            if ($this->is_home == 1)
            {
                $this->clearHome();
            }
            if ($this->id <= 0)
            {
                $item = $this->database->loadObject("SELECT id, ordering FROM #__menus_items WHERE menu_id = ? AND parent_id = ? ORDER BY ordering DESC LIMIT 1", array($this->menu_id, $this->parent_id));
                if ($item->id > 0)
                {
                    $this->ordering = $item->ordering + 1;
                }
            }
        }
        
        public function getControllers()
        {
            $this->component = (strlen($this->component) > 0 && $_GET["overwrite"] != 1 ? $this->component : $_GET["comp"]);
            $this->controller = (strlen($this->controller) > 0 && $_GET["overwrite"] != 1 ? $this->controller : $_GET["cont"]);
            if (strlen($this->component) > 0)
            {
                if (file_exists(__DIR__ ."/../../". $this->component ."/extension.xml"))
                {
                    $xml = simplexml_load_file(__DIR__ ."/../../". $this->component ."/extension.xml");
                    foreach ($xml->controller as $control)
                    {
                        $temp_controller = new stdClass();
                        $temp_controller->name = $control->attributes()->label;
                        $temp_controller->value = $control->attributes()->internal_name;
                        $this->controllers[] = $temp_controller;
                        if (strlen($this->controller) > 0)
                        {
                            $this->controller_xml = $control;
                            if ($this->controller == $control->attributes()->internal_name)
                            {
                                $this->controller_query = $control;
                            }
                        }
                    }
                }
            }
        }
        
        public function clearHome()
        {
            $this->database->query("UPDATE #__menus_items SET is_home = 0");
        }
        
        public function getSiblings()
        {
            $items = array();
            if ($this->id > 0)
            {
                $results = $this->database->loadObjectList("SELECT id, title FROM #__menus_items WHERE menu_id = ? AND id != ? AND parent_id = 0 ORDER BY ordering ASC", array($_GET["menu_id"], $this->id));
            }
            else
            {
                $results = $this->database->loadObjectList("SELECT id, title FROM #__menus_items WHERE menu_id = ? AND parent_id = 0 ORDER BY ordering ASC", array($_GET["menu_id"]));
            }
            foreach ($results as $result)
            {
                $item = new stdClass();
                $item->id = $result->id;
                $item->title = $result->title;
                $item->children = array();
                if ($this->id > 0)
                {
                    $children = $this->database->loadObjectList("SELECT id, title FROM #__menus_items WHERE menu_id = ? AND id != ? AND parent_id = ? ORDER BY ordering ASC", array($_GET["menu_id"], $this->id, $result->id));
                }
                else
                {
                    $children = $this->database->loadObjectList("SELECT id, title FROM #__menus_items WHERE menu_id = ? AND parent_id = ? ORDER BY ordering ASC", array($_GET["menu_id"], $result->id));
                }
                foreach ($children as $child)
                {
                    $child_item = new stdClass();
                    $child_item->id = $child->id;
                    $child_item->title = $child->title;
                    $child_item->children = array();
                    if ($this->id > 0)
                    {
                        $grandchildren = $this->database->loadObjectList("SELECT id, title FROM #__menus_items WHERE menu_id = ? AND id != ? AND parent_id = ? ORDER BY ordering ASC", array($_GET["menu_id"], $this->id, $child->id));
                    }
                    else
                    {
                        $grandchildren = $this->database->loadObjectList("SELECT id, title FROM #__menus_items WHERE menu_id = ? AND parent_id = ? ORDER BY ordering ASC", array($_GET["menu_id"], $child->id));
                    }
                    foreach ($grandchildren as $grandchild)
                    {
                        $grandchild_item = new stdClass();
                        $grandchild_item->id = $grandchild->id;
                        $grandchild_item->title = $grandchild->title;
                        $child_item->children[] = $grandchild;
                    }
                    $item->children[] = $child_item;
                }
                $items[] = $item;
            }
            return $items;
        }
        
        public function getUsergroups()
        {
            $temp = $this->database->loadObjectList("SELECT id FROM #__usergroups ORDER BY title ASC");
            $groups = array();
            foreach ($temp as $t)
            {
                $groups[] = new UserGroupModel($t->id, $this->database);
            }
            return $groups;
        }
        
        public function delete($id)
        {
            $this->database->query("DELETE FROM #__menus_items WHERE id = ?", array($id));
        }
        
    }

?>