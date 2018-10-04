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
            if ($id > 0)
            {
                $this->load($id);
            }
        }
        
        public function delete($id)
        {
            $this->database->query("DELETE FROM #__enquiries WHERE id = ?", array($id));
        }
        
    }

?>