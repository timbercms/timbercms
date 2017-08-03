<?php
    
    require_once(__DIR__ ."/model.php");
    require_once(__DIR__ ."/../../components/user/models/user.php");
    require_once(__DIR__ ."/../../admin/components/menu/models/menu.php");
    require_once(__DIR__ ."/../../admin/components/menu/models/menuitem.php");
    require_once(__DIR__ ."/../../admin/components/modules/models/module.php");
    define("BASE_URL", "http://localhost/burgundy-cms/");

    class Core
    {
        
        public $template;
        public $view;
        public $database;
        public static $user;
        public static $stylesheets = array();
        public static $db;
        public static $title = "Burgundy CMS";
        public static $description = '<meta name="description" content="Burgundy CMS">';
        private $component;
        private $controller;
        private $model;
        public $content_id;
        public static $content_item_id;
        
        public function __construct()
        {
            $this->setDatabase();
            $this->cleanSessions();
            require_once(__DIR__ ."/template.php");
            $template = new Template($this->database);
            $this->template = $template;
            self::$user = new UserModel(0, $this->database);
            if ($alias = $this->unroute())
            {
                // Check if menu item exists
                $item = $this->database->loadObject("SELECT * FROM #__menus_items WHERE alias = ? AND published = 1", array($alias));
                if ($item->id > 0)
                {
                    $this->component = $item->component;
                    $this->controller = $item->controller;
                    $this->content_id = $item->content_id;
                }
                else
                {
                    // See if any articles exist that have this alias
                    $article = $this->database->loadObject("SELECT * fROM #__articles WHERE alias = ? AND published = 1", array($alias));
                    if ($article->id > 0)
                    {
                        // We have a match!
                        $this->component = "content";
                        $this->controller = "article";
                        $this->content_id = $article->id;
                    }
                    else
                    {
                        // Maybe a category matches?
                        $category = $this->database->loadObject("SELECT * FROM #__articles_categories WHERE alias = ? AND published = 1", array($alias));
                        if ($category->id > 0)
                        {
                            $this->component = "content";
                            $this->controller = "category";
                            $this->content_id = $category->id;
                        }
                        else
                        {
                            // Nothing. Default to 404.
                        }
                    }
                }
            }
            else
            {
                $item = $this->database->loadObject("SELECT * FROM #__menus_items WHERE component = ? AND controller = ? AND content_id = ?", array($_GET["component"], $_GET["controller"], $_GET["id"]));
                if ($item->id <= 0 && strlen($_GET["component"]) == 0)
                {
                    $item = $this->database->loadObject("SELECT * FROM #__menus_items WHERE is_home = ?", array(1));
                }
                elseif (strlen($_GET["component"]) > 0)
                {
                    $item = new stdClass();
                    $item->component = $_GET["component"];
                    $item->controller = $_GET["controller"];
                    $item->content_id = $_GET["id"];
                }
                $this->component = $item->component;
                $this->controller = $item->controller;
                $this->content_id = $item->content_id;
            }
            self::$content_item_id = $this->content_id;
            $modelname = $this->controller ."Model";
            $controllername = $this->controller ."Controller";
            require_once(__DIR__ ."/../../components/". $this->component ."/models/". $this->controller .".php");
            require_once(__DIR__ ."/../../components/". $this->component ."/controllers/". $this->controller .".php");
            require_once(__DIR__ ."/../../components/". $this->component ."/view.php");
            $model = new $modelname($this->content_id, $this->database);
            $controller = new $controllername($model);
            if (strlen($_GET["task"]) > 0)
            {
                $task = $_GET["task"];
                $controller->$task();
            }
            else
            {
                $view = new View($controller, $model, $this);
                $this->view = $view;
                require_once(__DIR__ ."/../../templates/". $this->template->name ."/index.php");
                $this->template->addComponentStylesheet($this->component);
                $this->database->close();
            }
        }
        
        public function loadOverride($template)
        {
            if (file_exists(__DIR__ ."/../../templates/". $this->template->name ."/overrides/components/". $this->component ."/". $template))
            {
                return __DIR__ ."/../../templates/". $this->template->name ."/overrides/components/". $this->component ."/". $template;
            }
            else
            {
                return __DIR__ ."/../../components/". $this->component ."/views/". $template;
            }
        }
        
        public function setDatabase()
        {
            require_once(__DIR__ ."/../../configuration.php");
            require_once(__DIR__ ."/database.php");
            $db = new Database();
            $this->database = $db;
            self::$db = $db;
        }
        
        public static function addStylesheet($link)
        {
            self::$stylesheets[] = '<link rel="stylesheet" href="'. BASE_URL.$link .'?v='. time() .'">';
        }
        
        public static function changeTitle($title)
        {
            self::$title = $title;
        }
        
        public static function changeMetaDescription($string)
        {
            self::$description = '<meta name="description" content="' .$string .'">';
        }
        
        public function finalise($page)
        {
            $page = str_replace("<!-- HEADER_STYLES -->", implode("", self::$stylesheets), $page);
            $page = str_replace("<!-- PAGE_TITLE -->", self::$title, $page);
            $page = str_replace("<!-- META_DESCRIPTION -->", self::$description, $page);
            echo $page;
        }
        
        public static function route($link)
        {
            if (!preg_match('/=/', $link))
            {
                $request = $_SERVER["REQUEST_URI"];
                $parts = explode("/", $link);
                $structure = array();
                foreach ($parts as $part)
                {
                    if (!preg_match('/'. $part .'/', $request))
                    {
                        $structure[] = $part;
                    }
                }
                return implode("/", $structure);
            }
            else
            {
                $link = str_replace("index.php?", "", $link);
                $parts = explode("&", $link);
                foreach ($parts as $part)
                {
                    $part = explode("=", $part);
                    $component = "";
                    $controller = "";
                    $content_id = "";
                    switch ($part["0"])
                    {
                        case "component":
                            $component = $part["1"];
                            break;
                        case "controller":
                            $controller = $part["1"];
                            break;
                        case "id":
                            $content_id = $part["1"];
                            break;
                    }
                    $item = Core::db()->loadObject("SELECT id FROM #__menus_items WHERE component = ? AND controller = ? AND content_id = ?", array($component, $controller, $content_id));
                    if ($item->id > 0)
                    {
                        return BASE_URL."index.php?component=". $component ."&controller=". $controller ."&id=". $content_id ."&iid=". $item->id;
                    }
                    else
                    {
                        return BASE_URL."index.php?". $link;
                    }
                }
            }
        }
        
        public function unroute()
        {
            $string = $_SERVER["REQUEST_URI"];
            if (!preg_match('/=/', $string))
            {
                $string = str_replace("/burgundy-cms", "", $string); // Remove after putting live
                $parts = explode("/", $string);
                $alias = end($parts);
                if (strlen($alias) > 0)
                {
                    return $alias;
                }
                else
                {
                    return false;
                }
            }
            else
            {
                return false;
            }
        }
        
        public static function db()
        {
            return self::$db;
        }
        
        public static function user()
        {
            return self::$user;
        }
        
        public static function content_item_id()
        {
            return self::$content_item_id;
        }
        
        public function cleanSessions()
        {
            Core::db()->query("DELETE FROM #__sessions WHERE access < (UNIX_TIMESTAMP() - 2592000) LIMIT 100", array());
            Core::db()->query("DELETE FROM #__sessions WHERE access < (UNIX_TIMESTAMP() - 86400) AND user_id = 0 LIMIT 100", array());
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
        
    }

?>