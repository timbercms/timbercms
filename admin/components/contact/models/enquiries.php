<?php

    require_once(__DIR__ ."/enquiry.php");

    class EnquiriesModel extends Model
    {
        
        public $template = "enquiries.php";
        public $database;
        public $pagination;
        
        public $enquiries = array();
        
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
            $temp = $this->database->loadObjectList("SELECT id FROM #__enquiries");
            $this->max = count($this->database->loadObjectList($query));
            $query .= " LIMIT ". ($_GET["p"] > 0 ? (($_GET["p"] - 1) * 20) : 0) .", 20";
            foreach ($temp as $temp_enquiry)
            {
                $enquiry = new EnquiryModel($temp_enquiry->id, $this->database);
                $this->enquiries[] = $enquiry;
            }
        }
        
    }

?>