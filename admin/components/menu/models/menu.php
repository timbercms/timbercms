<?php

    require_once(__DIR__ ."/menuitem.php");
    require_once(__DIR__ ."/../../../classes/form.php");

    class MenuModel extends Model
    {
        public $template = "menu.php";
        public $database;
        
        public $id;
        public $title;
        public $form;
        public $items = array();
        
        public function __construct($id = 0, $database)
        {
            $this->database = $database;
            if ($id > 0)
            {
                $this->load($id);
            }
            $this->form = new Form(__DIR__ ."/../forms/menu.xml", $this, $this->database);
        }
        
        public function load($id)
        {
            $temp = $this->database->loadObject("SELECT * FROM #__menus WHERE id = ?", array($id));
            $this->id = $temp->id;
            $this->title = $temp->title;
            $ti = $this->database->loadObjectList("SELECT id FROM #__menus_items WHERE menu_id = ?", array($id));
            if (is_array($ti))
            {
                foreach ($ti as $i)
                {
                    $item = new MenuitemModel($i->id, $this->database);
                    $this->items[] = $item;
                }
            }
        }
        
        public function store($table = "", $data = array())
		{
			$data = array();
			$data[] = array("name" => "id", "value" => $this->id);
			$data[] = array("name" => "title", "value" => $this->title);
			return parent::store("#__menus", $data);
		}
        
        public function delete($id)
        {
            $this->database->query("DELETE FROM #__menus WHERE id = ?", array($id));
            $this->database->query("DELETE FROM #__menus_items WHERE menu_id = ?", array($id));
        }
        
    }

?>