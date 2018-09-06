<?php

    require_once(__DIR__ ."/usergroup.php");

    class UsergroupsModel extends Model
    {
        
        public $template = "usergroups.php";
        public $database;
        public $pagination;
        
        public $groups = array();
        public $settings;
        
        public function __construct($id = 0, $database)
        {
            $this->database = $database;
            $this->load();
            $this->settings = simplexml_load_file(__DIR__ ."/../extension.xml");
            $this->pagination = new Pagination();
        }
        
        public function load()
        {
            $query = "SELECT id FROM #__usergroups";
            $this->max = count($this->database->loadObjectList($query));
            $query .= " LIMIT ". ($_GET["p"] > 0 ? (($_GET["p"] - 1) * 20) : 0) .", 20";
            $temp_groups = $this->database->loadObjectList($query);
            foreach ($temp_groups as $temp_group)
            {
                $group = new UsergroupModel($temp_group->id, $this->database);
                $this->groups[] = $group;
            }
        }
        
    }

?>