<?php

    class MenuitemModel extends Model
    {
        public $database;
        public $template = "menuitem.php";
        
        public $id = 0;
        public $menu_id;
        public $parent_id;
        public $title;
        public $alias;
        public $published;
        public $access_group = array();
        public $component;
        public $controller;
        public $controller_xml;
        public $content_id;
        public $params = array();
        public $is_home;
        public $ordering;
        public $controllers = array();
        public $controller_query;
        public $children = array();
        public $usergroups = array();
        
        public $form;
        
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
        
        public function load($id)
        {
            $temp = $this->database->loadObject("SELECT * FROM #__menus_items WHERE id = ?", array($id));
            $this->id = $temp->id;
            $this->menu_id = $temp->menu_id;
            $this->parent_id = $temp->parent_id;
            $this->title = $temp->title;
            $this->alias = $temp->alias;
            $this->published = $temp->published;
            $this->access_group = explode(",", $temp->access_group);
            $this->component = $temp->component;
            $this->controller = $temp->controller;
            $this->content_id = $temp->content_id;
            $this->params = unserialize($temp->params);
            $this->is_home = $temp->is_home;
            $this->ordering = $temp->ordering;
            $temp_children = $this->database->loadObjectList("SELECT id FROM #__menus_items WHERE parent_id = ? ORDER BY ordering ASC", array($id));
            if (count($temp_children) > 0)
            {
                foreach ($temp_children as $child)
                {
                    $this->children[] = new MenuitemModel($child->id, $this->database);
                }
            }
        }
        
        public function store($table = "", $data = array())
		{
            if ($this->is_home == 1)
            {
                $this->clearHome();
            }
			$data = array();
			$data[] = array("name" => "id", "value" => $this->id);
            $data[] = array("name" => "menu_id", "value" => $this->menu_id);
            $data[] = array("name" => "parent_id", "value" => $this->parent_id);
			$data[] = array("name" => "title", "value" => $this->title);
            if (strlen($this->alias) == 0)
            {
                $this->alias = Core::generateAlias($this->title);
            }
            $data[] = array("name" => "alias", "value" => $this->alias);
            $data[] = array("name" => "published", "value" => $this->published);
            $data[] = array("name" => "access_group", "value" => implode(",", $this->access_group));
            $data[] = array("name" => "component", "value" => $this->component);
            $data[] = array("name" => "controller", "value" => $this->controller);
            $data[] = array("name" => "content_id", "value" => $this->content_id);
            $data[] = array("name" => "params", "value" => serialize($this->params));
            $data[] = array("name" => "is_home", "value" => $this->is_home);
            if ($this->id <= 0)
            {
                $item = $this->database->loadObject("SELECT id, ordering FROM #__menus_items WHERE menu_id = ? AND parent_id = ? ORDER BY ordering DESC LIMIT 1", array($this->menu_id, $this->parent_id));
                if ($item->id > 0)
                {
                    $this->ordering = $item->ordering + 1;
                }
            }
            $data[] = array("name" => "ordering", "value" => $this->ordering);
			return parent::store("#__menus_items", $data);
		}
        
        public function getControllers()
        {
            $this->component = (strlen($this->component) > 0 && $_GET["overwrite"] != 1 ? $this->component : $_GET["comp"]);
            $this->controller = (strlen($this->controller) > 0 && $_GET["overwrite"] != 1 ? $this->controller : $_GET["cont"]);
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
        
        public function clearHome()
        {
            $this->database->query("UPDATE #__menus_items SET is_home = 0");
        }
        
        public function getSiblings()
        {
            $items = array();
            $results = $this->database->loadObjectList("SELECT id, title FROM #__menus_items WHERE menu_id = ? AND id != ? AND parent_id = 0 ORDER BY ordering ASC", array($_GET["menu_id"], $this->id));
            foreach ($results as $result)
            {
                $item = new stdClass();
                $item->id = $result->id;
                $item->title = $result->title;
                $item->children = array();
                $children = $this->database->loadObjectList("SELECT id, title FROM #__menus_items WHERE menu_id = ? AND id != ? AND parent_id = ? ORDER BY ordering ASC", array($_GET["menu_id"], $this->id, $result->id));
                foreach ($children as $child)
                {
                    $child_item = new stdClass();
                    $child_item->id = $child->id;
                    $child_item->title = $child->title;
                    $child_item->children = array();
                    $grandchildren = $this->database->loadObjectList("SELECT id, title FROM #__menus_items WHERE menu_id = ? AND id != ? AND parent_id = ? ORDER BY ordering ASC", array($_GET["menu_id"], $this->id, $child->id));
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