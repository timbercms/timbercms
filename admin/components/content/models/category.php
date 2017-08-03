<?php

    require_once(__DIR__ ."/../../../classes/form.php");

    class CategoryModel extends Model
    {
        
        public $template = "category.php";
        public $database;
        public $form;
        
        public $id;
        public $title;
        public $alias;
        public $description;
        public $published;
        public $params;
        
        public function __construct($id = 0, $database)
        {
            $this->database = $database;
            if ($id > 0)
            {
                $this->load($id);
            }
            $this->form = new Form(__DIR__ ."/../forms/category.xml", $this, $this->database);
        }
        
        public function load($id)
        {
            $temp = $this->database->loadObject("SELECT * FROM #__articles_categories WHERE id = ?", array($id));
            $this->id = $temp->id;
            $this->title = $temp->title;
            $this->alias = $temp->alias;
            $this->description = $temp->description;
            $this->published = $temp->published;
            $this->params = unserialize($temp->params);
        }
        
        public function store($table = "", $data = array())
		{
			$data = array();
			$data[] = array("name" => "id", "value" => $this->id);
			$data[] = array("name" => "title", "value" => $this->title);
            $data[] = array("name" => "alias", "value" => $this->alias);
            $data[] = array("name" => "description", "value" => $this->description);
            $data[] = array("name" => "published", "value" => $this->published);
            $data[] = array("name" => "params", "value" => serialize($this->params));
			return parent::store("#__articles_categories", $data);
		}
        
    }

?>