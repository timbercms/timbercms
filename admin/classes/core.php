<?php
    
    require_once(__DIR__ ."/../../core/classes/model.php");
    require_once(__DIR__ ."/../components/users/models/user.php");

    class Core
    {
        public $database;
        public static $user;
        public static $db;
        private $component;
        private $controller;
        private $content_id;
        
        public function __construct()
        {
            $this->component = (strlen($_GET["component"]) > 0 ? $_GET["component"] : "dashboard");
            $this->controller = (strlen($_GET["controller"]) > 0 ? $_GET["controller"] : "dashboard");
            $this->content_id = (strlen($_GET["id"]) > 0 ? $_GET["id"] : "0");
            $this->setDatabase();
            require_once(__DIR__ ."/../../core/classes/template.php");
            $template = new Template($this->database);
            $this->template = $template;
            self::$user = new UserModel(0, $this->database);
            if (self::$user->usergroup->is_admin != 1)
            {
                header("Location: ../index.php?component=user&controller=login");
            }
            $modelname = $this->controller ."Model";
            $controllername = $this->controller ."Controller";
            require_once(__DIR__ ."/../components/". $this->component ."/models/". $this->controller .".php");
            require_once(__DIR__ ."/../components/". $this->component ."/controllers/". $this->controller .".php");
            require_once(__DIR__ ."/../components/". $this->component ."/view.php");
            $model = new $modelname($this->content_id, $this->database);
            $controller = new $controllername($model, $this);
            if (strlen($_GET["task"]) > 0)
            {
                $task = $_GET["task"];
                $controller->$task();
            }
            else
            {
                $view = new View($controller, $model, $this);
                $this->view = $view;
                require_once(__DIR__ ."/../templates/". $this->template->name ."/index.php");
                $this->template->addComponentStylesheet($this->component);
                $this->database->close();
            }
        }
        
        public function setDatabase()
        {
            require_once(__DIR__ ."/../../configuration.php");
            require_once(__DIR__ ."/../../core/classes/database.php");
            $db = new Database();
            $this->database = $db;
            self::$db = $db;
        }
        
        public static function db()
        {
            return self::$db;
        }
        
        public static function user()
        {
            return self::$user;
        }
        
        // Added for compatibility
        public static function addStylesheet()
        {
        }
        
        // Added for compatibility
        public static function addScript()
        {
        }
        
        public function finalise($page)
        {
            $page = str_replace("<!-- HEADER_STYLES -->", implode("", self::$stylesheets), $page);
            $page = str_replace("<!-- HEADER_SCRIPTS -->", implode("", self::$scripts), $page);
            $page = str_replace("<!-- PAGE_TITLE -->", self::$title, $page);
            $page = str_replace("<!-- META_DESCRIPTION -->", self::$description, $page);
            echo $page;
        }
        
        public function displaySystemMessages()
        {
            if (count($_SESSION["MESSAGES"]) > 0 && strlen($_GET["task"]) == 0)
            {
                foreach ($_SESSION["MESSAGES"] as $message)
                {
                    echo $message;
                }
                unset($_SESSION["MESSAGES"]);
            }
        }
        
        public function setMessage($type = "primary", $message = "")
		{
			 $_SESSION["MESSAGES"][] = '<div class="system-message '. $type .'">'. $message .'</div>';
		}
        
    }

?>