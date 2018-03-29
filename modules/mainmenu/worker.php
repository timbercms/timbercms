<?php

    require_once(__DIR__ ."/../../admin/components/menu/models/menuitem.php");

    class MainMenuWorker
    {
        
        public $module;
        public $items = array();
        public $database;
     
        public function __construct($module, $database)
        {
            $this->module = $module;
            $this->database = $database;
            $this->fetchItems();
        }
        
        public function fetchItems()
        {
            $temp = $this->database->loadObjectList("SELECT id FROM #__menus_items WHERE menu_id = ? AND published = '1' AND parent_id = 0 ORDER BY ordering ASC", array($this->module->params->menu_id));
            foreach ($temp as $m)
            {
                $this->items[] = new MenuitemModel($m->id, $this->database);
            }
        }
        
    }

?>