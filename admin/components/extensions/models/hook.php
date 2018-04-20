<?php

    class HookModel extends Model
    {
        
        public $template = "hook.php";
        public $database;
        
        public $id;
        public $title;
        public $description;
        public $component_name;
        public $author_name;
        public $author_url;
        public $version;
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
            $temp = $this->database->loadObject("SELECT * FROM #__components_hooks WHERE id = ?", array($id));
            $this->id = $temp->id;
            $this->title = $temp->title;
            $this->description = $temp->description;
            $this->internal_name = $temp->component_name;
            $this->author_name = $temp->author_name;
            $this->author_url = $temp->author_url;
            $this->version = $temp->version;
            $this->enabled = $temp->enabled;
        }
        
        public function store($table = "", $data = array())
		{
			$data = array();
			$data[] = array("name" => "id", "value" => $this->id);
			$data[] = array("name" => "title", "value" => $this->title);
            $data[] = array("name" => "description", "value" => $this->description);
            $data[] = array("name" => "component_name", "value" => $this->component_name);
            $data[] = array("name" => "author_name", "value" => $this->author_name);
            $data[] = array("name" => "author_url", "value" => $this->author_url);
            $data[] = array("name" => "version", "value" => $this->version);
            $data[] = array("name" => "enabled", "value" => $this->enabled);
			return parent::store("#__components_hooks", $data);
		}
        
        public function loadByName($name)
        {
            $temp = $this->database->loadObject("SELECT id FROM #__components_hooks WHERE component_name = ?", array($name));
            if ($temp->id > 0)
            {
                $this->load($temp->id);
            }
        }
        
    }

?>