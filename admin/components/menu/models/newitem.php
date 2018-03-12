<?php

    class NewItemModel extends Model
    {
        
        public $template = "newitem.php";
        public $database;
        
        public $module_types;
        
        public function __construct($id = 0, $database)
        {
            $this->database = $database;
            $this->loadComponents();
        }
        
        public function loadComponents()
        {
            $this->components = array();
            $temp = $this->database->loadObjectList("SELECT * FROM #__components WHERE is_frontend = '1'");
            foreach ($temp as $comp)
            {
                $controllers = array();
                $xml = simplexml_load_file(__DIR__ ."/../../". $comp->internal_name ."/extension.xml");
                foreach ($xml->controller as $control)
                {
                    $tcomp = new stdClass();
                    $tcomp->component = $comp->internal_name;
                    $tcomp->name = (string) $control->attributes()->label;
                    $tcomp->value = (string) $control->attributes()->internal_name;
                    $tcomp->description = (string) $control->attributes()->description;
                    $controllers[] = $tcomp;
                }
                $this->components[$comp->title] = $controllers;
            }
        }
        
    }

?>