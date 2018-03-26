<?php

    class EnquiryModel extends Model
    {
        
        public $template = "enquiry.php";
        public $database;
        
        public function __construct($id = 0, $database)
        {
            $this->database = $database;
        }
        
        public function store($table = "", $data = array())
		{
			$data = array();
			$data[] = array("name" => "id", "value" => $this->id);
			$data[] = array("name" => "email", "value" => $this->email);
            $data[] = array("name" => "name", "value" => $this->name);
            $data[] = array("name" => "content", "value" => $this->content);
            $data[] = array("name" => "sent_time", "value" => $this->sent_time);
			return parent::store("#__enquiries", $data);
		}
        
    }

?>