<?php

    class ExtensionModel extends Model
    {
        
        public $template = "extension.php";
        public $database;
        
        public $id;
        public $title;
        public $description;
        public $internal_name;
        public $is_frontend;
        public $is_backend;
        public $is_locked;
        public $author_name;
        public $author_url;
        public $version;
        public $params;
        public $enabled;
        
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
            $temp = $this->database->loadObject("SELECT * FROM #__components WHERE id = ?", array($id));
            $this->id = $temp->id;
            $this->title = $temp->title;
            $this->description = $temp->description;
            $this->internal_name = $temp->internal_name;
            $this->is_frontend = $temp->is_frontend;
            $this->is_backend = $temp->is_backend;
            $this->is_locked = $temp->is_locked;
            $this->author_name = $temp->author_name;
            $this->author_url = $temp->author_url;
            $this->version = $temp->version;
            $this->params = unserialize($temp->params);
            $this->enabled = $temp->enabled;
        }
        
        public function store($table = "", $data = array())
		{
			$data = array();
			$data[] = array("name" => "id", "value" => $this->id);
			$data[] = array("name" => "title", "value" => $this->title);
            $data[] = array("name" => "description", "value" => $this->description);
            $data[] = array("name" => "internal_name", "value" => $this->internal_name);
            $data[] = array("name" => "is_frontend", "value" => $this->is_frontend);
            $data[] = array("name" => "is_backend", "value" => $this->is_backend);
            $data[] = array("name" => "is_locked", "value" => $this->is_locked);
            $data[] = array("name" => "author_name", "value" => $this->author_name);
            $data[] = array("name" => "author_url", "value" => $this->author_url);
            $data[] = array("name" => "version", "value" => $this->version);
            $data[] = array("name" => "params", "value" => serialize($this->params));
            $data[] = array("name" => "enabled", "value" => $this->enabled);
			return parent::store("#__components", $data);
		}
        
        public function loadByName($name)
        {
            $temp = $this->database->loadObject("SELECT id FROM #__components WHERE internal_name = ?", array($name));
            if ($temp->id > 0)
            {
                $this->load($temp->id);
            }
        }
        
    }

?>