<?php

    require_once(__DIR__ ."/../../components/content/models/article.php");

    class LatestnewsWorker
    {
        
        public $module;
        public $items = array();
        public $database;
     
        public function __construct($module, $database)
        {
            $this->module = $module;
            $this->database = $database;
            $this->fetchItems();
        }
        
        public function fetchItems()
        {
            $category_id = $this->module->params->category_id;
            $limit = intval($this->module->params->limit);
            $query = sprintf("SELECT id FROM #__articles WHERE category_id = ? ORDER BY publish_time DESC LIMIT %d", $limit);

            $temp = $this->database->loadObjectList($query, array($category_id));

            foreach ($temp as $a)
            {
                $this->items[] = new ArticleModel($a->id, $this->database);
            }
        }
        
    }

?>