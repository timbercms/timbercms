<?php

    require_once(__DIR__ ."/../../content/models/article.php");

    class DashboardModel extends Model
    {
        
        public $template = "dashboard.php";
        public $database;
        
        public $article_count = 0;
        public $user_count = 0;
        public $launch_days = 0;
        public $users = array();
        public $articles = array();
        
        public function __construct($id = 0, $database)
        {
            $this->database = $database;
            $this->load();
        }
        
        public function load()
        {
            $t_articles = $this->database->loadObjectList("SELECT id FROM #__articles ORDER BY publish_time DESC LIMIT 5");
            foreach ($t_articles as $t_article)
            {
                $article = new ArticleModel($t_article->id, $this->database);
                $this->articles[] = $article;
            }
            $t_users = $this->database->loadObjectList("SELECT id FROM #__users ORDER BY register_time DESC LIMIT 5");
            foreach ($t_users as $t_user)
            {
                $user = new UserModel($t_user->id, $this->database);
                $this->users[] = $user;
            }
            $this->article_count = count($this->articles);
            $this->user_count = count($this->users);
            $this->launch_days = number_format(((time() - LAUNCH_TIME) / 86400), 1);
        }
        
    }

?>