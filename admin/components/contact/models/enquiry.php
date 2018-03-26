<?php

    class EnquiryModel extends Model
    {
        
        public $template = "enquiry.php";
        public $database;
        
        public $id;
        public $email;
        public $name;
        public $content;
        public $sent_time;
        
        public function __construct($id = 0, $database)
        {
            $this->database = $database;
            if ($id > 0)
            {
                $this->load($id);
            }
        }
        
        public function load($id)
        {
            $temp = $this->database->loadObject("SELECT * FROM #__enquiries WHERE id = ?", array($id));
            $this->id = $temp->id;
            $this->email = $temp->email;
            $this->name = $temp->name;
            $this->content = $temp->content;
            $this->sent_time = $temp->sent_time;
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
        
        public function delete($id)
        {
            $this->database->query("DELETE FROM #__enquiries WHERE id = ?", array($id));
        }
        
    }

?>