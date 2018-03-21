<?php

    require_once(__DIR__ ."/../../../classes/form.php");

    class ModuleModel extends Model
    {
        
        public $template = "module.php";
        public $database;
        public $form;
        public $params_form;
        
        public $id;
        public $title;
        public $type;
        public $show_title;
        public $published;
        public $position;
        public $ordering;
        public $params = array();
        public $pages;
        
        public function __construct($id = 0, $database)
        {
            $this->database = $database;
            if ($id > 0)
            {
                $this->load($id);
            }
            $this->form = new Form(__DIR__ ."/../forms/module.xml", $this, $this->database);
            $this->getParams();
        }
        
        public function load($id)
        {
            $temp = $this->database->loadObject("SELECT * FROM #__modules WHERE id = ?", array($id));
            $this->id = $temp->id;
            $this->title = $temp->title;
            $this->type = $temp->type;
            $this->show_title = $temp->show_title;
            $this->published = $temp->published;
            $this->position = $temp->position;
            $this->ordering = $temp->ordering;
            $this->params = (object) unserialize($temp->params);
            $this->pages = explode(",", $temp->pages);
        }
        
        public function store($table = "", $data = array())
		{
			$data = array();
			$data[] = array("name" => "id", "value" => $this->id);
			$data[] = array("name" => "title", "value" => $this->title);
            $data[] = array("name" => "type", "value" => $this->type);
            $data[] = array("name" => "show_title", "value" => $this->show_title);
            $data[] = array("name" => "published", "value" => $this->published);
            $data[] = array("name" => "position", "value" => $this->position);
            if ($this->id <= 0)
            {
                $module = $this->database->loadObject("SELECT id, ordering FROM #__modules WHERE position = ? ORDER BY ordering DESC LIMIT 1", array($this->position));
                if ($module->id > 0)
                {
                    $this->ordering = $module->ordering + 1;
                }
            }
            $data[] = array("name" => "ordering", "value" => $this->ordering);
            $data[] = array("name" => "params", "value" => serialize($this->params));
            $data[] = array("name" => "pages", "value" => implode(",", $this->pages));
			return parent::store("#__modules", $data);
		}
        
        public function getParams()
        {
            $this->params_form = new Form(__DIR__ ."/../../../../modules/". (strlen($this->type) > 0 ? $this->type : $_GET["type"]) ."/module.xml", $this->params, $this->database);
        }
        
        public function delete($id)
        {
            $this->database->query("DELETE FROM #__modules WHERE id = ?", array($id));
        }
        
    }

?>