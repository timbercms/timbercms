<?php

    class EnquiryModel extends Model
    {
        public $component = "contact";
        public $table = "enquiries";
        public $template = "enquiry.php";
        public $database;
        
        public function __construct($id = 0, $database)
        {
            $this->database = $database;
        }
        
    }

?>