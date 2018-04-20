<?php

    require_once(__DIR__ ."/usergroup.php");

    class UsergroupsModel
    {
        
        public $template = "usergroups.php";
        public $database;
        
        public $groups = array();
        public $settings;
        
        public function __construct($id = 0, $database)
        {
            $this->database = $database;
            $this->load();
            $this->settings = simplexml_load_file(__DIR__ ."/../extension.xml");
        }
        
        public function load()
        {
            $temp_groups = $this->database->loadObjectList("SELECT id FROM #__usergroups");
            foreach ($temp_groups as $temp_group)
            {
                $group = new UsergroupModel($temp_group->id, $this->database);
                $this->groups[] = $group;
            }
        }
        
    }

?>