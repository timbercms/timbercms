<?php

    require_once(__DIR__ ."/enquiry.php");

    class EnquiriesModel
    {
        
        public $template = "enquiries.php";
        public $database;
        
        public $enquiries = array();
        
        public function __construct($id = 0, $database)
        {
            $this->database = $database;
            $this->load();
        }
        
        public function load()
        {
            $temp = $this->database->loadObjectList("SELECT id FROM #__enquiries");
            foreach ($temp as $temp_enquiry)
            {
                $enquiry = new EnquiryModel($temp_enquiry->id, $this->database);
                $this->enquiries[] = $enquiry;
            }
        }
        
    }

?>