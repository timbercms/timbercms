<?php

    require_once(__DIR__ ."/redirect.php");

    class RedirectsModel extends Model
    {
        
        public $template = "redirects.php";
        public $database;
        public $pagination;
        
        public $redirects = array();
        
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
            $temp = $this->database->loadObjectList("SELECT id FROM #__redirects");
            $this->max = count($this->database->loadObjectList($query));
            $query .= " LIMIT ". ($_GET["p"] > 0 ? (($_GET["p"] - 1) * 20) : 0) .", 20";
            foreach ($temp as $temp_redirect)
            {
                $redirect = new RedirectModel($temp_redirect->id, $this->database);
                $this->redirects[] = $redirect;
            }
        }
        
    }

?>