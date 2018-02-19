<?php

    class DashboardModel
    {
        
        public $template = "dashboard.php";
        public $database;
        
        public $article_count = 0;
        public $user_count = 0;
        public $launch_days = 0;
        
        public function __construct($id = 0, $database)
        {
            $this->database = $database;
            $this->load();
        }
        
        public function load()
        {
            $articles = $this->database->loadObject("SELECT COUNT(id) AS count FROM #__articles");
            $this->article_count = $articles->count;
            $users = $this->database->loadObject("SELECT COUNT(id) AS count FROM #__users");
            $this->user_count = $users->count;
            $this->launch_days = number_format(((time() - LAUNCH_TIME) / 86400), 1);
        }
        
    }

?>