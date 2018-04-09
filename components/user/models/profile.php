<?php

    require_once(__DIR__ ."/../../content/models/article.php");

    class ProfileModel extends Model
    {
        
        public $template = "profile.php";
        public $database;
        
        public $user;
        public $articles = array();
        
        public function __construct($id = 0, $database)
        {
            $this->database = $database;
            $this->user = new UserModel($id, $this->database);
            $recents = $this->database->loadObjectList("SELECT id FROM #__articles WHERE author_id = ? AND published = '1' ORDER BY publish_time DESC LIMIT 5", array($this->user->id));
            foreach ($recents as $recent)
            {
                $this->articles[] = new ArticleModel($recent->id, $this->database);
            }
        }
        
    }

?>