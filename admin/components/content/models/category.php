<?php

    require_once(__DIR__ ."/../../../classes/form.php");

    class CategoryModel extends Model
    {
        public $component_name = "content";
        public $table = "articles_categories";
        public $template = "category.php";
        public $database;
        public $form;
        
        public function __construct($id = 0, $database)
        {
            $this->database = $database;
            if ($id > 0)
            {
                $this->load($id);
            }
            $this->form = new Form(__DIR__ ."/../forms/category.xml", $this, $this->database);
        }
        
        public function processData()
        {
            $this->children = array();
            $child_cats = $this->database->loadObjectList("SELECT id FROM #__articles_categories WHERE parent_id = ?", array($this->id));
            foreach ($child_cats as $child)
            {
                $this->children[] = new CategoryModel($child->id, $this->database);
            }
        }
        
        public function delete($id)
        {
            $this->database->query("DELETE FROM #__articles_categories WHERE id = ?", array($id));
        }
        
    }

?>