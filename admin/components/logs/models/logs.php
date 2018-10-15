<?php

    require_once(__DIR__ ."/log.php");

    class LogsModel extends Model
    {
        
        public $template = "logs.php";
        public $database;
        public $pagination;
        
        public $logs = array();
        
        public $settings;
        
        public function __construct($id = 0, $database)
        {
            $this->database = $database;
            $this->load();
            $this->settings = simplexml_load_file(__DIR__ ."/../extension.xml");
            $this->pagination = new Pagination();
        }
        
        public function load($id = false)
        {
            $temp = $this->database->loadObjectList("SELECT id FROM #__logs ORDER BY event_time DESC");
            $this->max = count($this->database->loadObjectList($query));
            $query .= " LIMIT ". ($_GET["p"] > 0 ? (($_GET["p"] - 1) * 20) : 0) .", 20";
            foreach ($temp as $temp_log)
            {
                $this->logs[] = new LogModel($temp_log->id, $this->database);
            }
        }
        
    }

?>