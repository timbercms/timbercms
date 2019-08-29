<?php

    class CategoryModel extends Model
    {
        
        public $template = "category.php";
        public $database;
        public $pagination;
        public $max;
        public $children = array();
        
        public function __construct($id = 0, $database)
        {
            $this->database = $database;
            if ($id > 0)
            {
                $this->loadList($id);
            }
            $this->pagination = new Pagination();
        }
        
        public function loadList($id)
        {
            $temp = $this->database->loadObject("SELECT * FROM #__example_categories WHERE id = ?", array($id));
            $this->id = $temp->id;
            $this->parent_id = $temp->parent_id;
            $this->title = $temp->title;
            $this->alias = $temp->alias;
            $this->description = $temp->description;
            $this->published = $temp->published;
            $this->params = (object) unserialize($temp->params);
            $this->parent = $this->database->loadObject("SELECT id, alias, parent_id FROM #__example_categories WHERE id = ?", array($this->parent_id));
            $children = $this->database->loadObjectList("SELECT id FROM #__articles_categories WHERE parent_id = ? ORDER BY title ASC", array($id));
            $child_array = array();
            foreach ($children as $child)
            {
                $child_array[] = $child->id;
                $this->children[] = new CategoryModel($child->id, $this->database);
            }
            Core::hooks()->executeHook("onLoadExampleCategoryModel", $this);
        }
        
    }

?>