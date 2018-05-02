<?php
    
    define("ADMIN", false);
    require_once(__DIR__ ."/model.php");
    require_once(__DIR__ ."/pagination.php");
    if (ADMIN)
    {
        require_once(__DIR__ ."/../../admin/components/user/models/user.php");
    }
    else
    {
        require_once(__DIR__ ."/../../components/user/models/user.php");
    }
    require_once(__DIR__ ."/../../admin/components/menu/models/menu.php");
    require_once(__DIR__ ."/../../admin/components/menu/models/menuitem.php");
    require_once(__DIR__ ."/../../admin/components/modules/models/module.php");
    require_once(__DIR__ ."/../../admin/components/modules/models/module.php");
    require_once(__DIR__ ."/../libraries/Mobile_Detect.php");
    require_once(__DIR__ ."/hooks.php");

    class Core
    {
        
        public $template;
        public $view;
        public $database;
        public static $router;
        public static $user;
        public static $stylesheets = array();
        public static $scripts = array();
        public static $db;
        public static $title = "";
        public static $description = '<meta name="description" content="Burgundy CMS">';
        private $component;
        private $controller;
        private $model;
        private $task;
        public $content_id;
        public static $content_item_id;
        public static $menu_item_id;
        public static $config = array();
        public static $componentconfig = array();
        public static $meta_properties = array();
        public static $meta_itemprops = array();
        public static $meta_names = array();
        public static $meta_author = "";
        public static $hooks;
        public static $cookie_name;
        
        public function __construct()
        {
            if (ADMIN)
            {
                $this->component = (strlen($_GET["component"]) > 0 ? $_GET["component"] : "dashboard");
                $this->controller = (strlen($_GET["controller"]) > 0 ? $_GET["controller"] : "dashboard");
                $this->content_id = (strlen($_GET["id"]) > 0 ? $_GET["id"] : "0");
                $this->setDatabase();
                $config = $this->database->loadObject("SELECT params FROM #__components WHERE internal_name = 'settings' LIMIT 1");
                $params = (object) unserialize($config->params);
                self::$config = $params;
                require_once(__DIR__ ."/template.php");
                $template = new Template($this->database, $params->admin_template);
                $this->template = $template;
                self::$user = new UserModel(0, $this->database);
                if (self::$user->usergroup->is_admin != 1)
                {
                    header("Location: ../index.php?component=user&controller=login");
                }
                $modelname = $this->controller ."Model";
                $controllername = $this->controller ."Controller";
                require_once(__DIR__ ."/../../admin/components/". $this->component ."/models/". $this->controller .".php");
                require_once(__DIR__ ."/../../admin/components/". $this->component ."/controllers/". $this->controller .".php");
                require_once(__DIR__ ."/../../admin/components/". $this->component ."/view.php");
                if (strtolower($modelname) == "usermodel")
                {
                    $model = new $modelname($this->content_id, $this->database, false);
                }
                else
                {
                    $model = new $modelname($this->content_id, $this->database);
                }
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
                    require_once(__DIR__ ."/../../admin/templates/". $this->template->name ."/index.php");
                    $this->template->addComponentStylesheet($this->component);
                    $this->template->addComponentScript($this->component);
                    $this->database->close();
                }
            }
            else
            {
                $this->setDatabase();
                $this->cleanSessions();
                self::$hooks = new Hooks($this->database);
                $config = $this->database->loadObject("SELECT params FROM #__components WHERE internal_name = 'settings' LIMIT 1");
                $params = (object) unserialize($config->params);
                self::$config = $params;
                require_once(__DIR__ ."/template.php");
                $template = new Template($this->database, $params->default_template);
                $this->template = $template;
                self::$user = new UserModel(0, $this->database);
                if (strlen($_GET["task"]) > 0)
                {
                    // Quickly load info from URL
                    if (strpos($link, "index.php?") !== false)
                    {
                        $link = str_replace("index.php?", "", $_SERVER["REQUEST_URI"]);
                        $link = str_replace(SUBFOLDER, "", $link); // Remove after putting live
                        $parts = explode("&", $link);
                        foreach ($parts as $part)
                        {
                            $part = explode("=", $part);
                            switch ($part["0"])
                            {
                                case "component":
                                    $this->component = $part["1"];
                                    break;
                                case "controller":
                                    $this->controller = $part["1"];
                                    break;
                                case "id":
                                    $this->content_id = $part["1"];
                                    break;
                                case "task":
                                    $this->task = $part["1"];
                                    break;
                            }
                        }
                    }
                    else
                    {
                        $this->unroute();
                    }
                }
                else
                {
                    $this->unroute();
                }
                self::$content_item_id = $this->content_id;
                // Check if component is disabled
                $test_comp = $this->database->loadObject("SELECT id, enabled, is_frontend FROM #__components WHERE internal_name = ?", array($this->component));
                if (!$test_comp->enabled || !$test_comp->is_frontend)
                {
                    // Abort! Component is disabled!
                    header("HTTP/1.0 404 Not Found");
                    require_once(__DIR__ ."/../../templates/". $this->template->name ."/error.php"); die();
                }
                $modelname = $this->controller ."Model";
                $controllername = $this->controller ."Controller";
                require_once(__DIR__ ."/../../components/". $this->component ."/models/". $this->controller .".php");
                require_once(__DIR__ ."/../../components/". $this->component ."/controllers/". $this->controller .".php");
                require_once(__DIR__ ."/../../components/". $this->component ."/view.php");
                $model = new $modelname($this->content_id, $this->database);
                $controller = new $controllername($model);
                $componentconfig = $this->database->loadObject("SELECT params FROM #__components WHERE internal_name = ? LIMIT 1", array($this->component));
                self::$componentconfig = (object) unserialize($componentconfig->params);
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
                    $this->template->addComponentScript($this->component);
                    $this->database->close();
                }
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
        
        public static function addScript($link)
        {
            self::$scripts[] = '<script src="'. BASE_URL.$link .'?v='. time() .'"></script>';
        }
        
        public static function changeTitle($title)
        {
            self::$title = $title." - ".self::$config->site_title;
        }
        
        public static function changeMetaDescription($string)
        {
            self::$description = '<meta name="description" content="' .$string .'">';
        }
        
        public static function addMetaProperty($name, $content)
        {
            self::$meta_properties[] = '<meta property="'. $name .'" content="'. $content .'" />';
        }
        
        public static function addMetaItemProp($name, $content)
        {
            self::$meta_itemprops[] = '<meta itemprop="'. $name .'" content="'. $content .'" />';
        }
        
        public static function addMetaName($name, $content)
        {
            self::$meta_names[] = '<meta name="'. $name .'" content="'. $content .'" />';
        }
        
        public static function setMetaAuthor($string)
        {
            self::$meta_author = '<meta name="author" content="'. $string .'">';
        }
        
        public function finalise($page)
        {
            $page = str_replace("<!-- HEADER_STYLES -->", implode("", self::$stylesheets), $page);
            $page = str_replace("<!-- HEADER_SCRIPTS -->", implode("", self::$scripts), $page);
            $page = str_replace("<!-- PAGE_TITLE -->", self::$title, $page);
            $page = str_replace("<!-- META_DESCRIPTION -->", self::$description, $page);
            $page = str_replace("<!-- META_AUTHOR -->", self::$meta_author, $page);
            $page = str_replace("<!-- META_PROPERTIES -->", implode("", self::$meta_properties), $page);
            $page = str_replace("<!-- META_ITEMPROPS -->", implode("", self::$meta_itemprops), $page);
            $page = str_replace("<!-- META_NAMES -->", implode("", self::$meta_names), $page);
            echo $page;
        }
        
        public static function route($link)
        {
            if ($link == "index.php")
            {
                $item = self::db()->loadObject("SELECT * FROM #__menus_items WHERE is_home = ?", array(1));
                return BASE_URL.$item->alias;
            }
            else if (!preg_match('/=/', $link))
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
                $component = "";
                $controller = "";
                $content_id = "";
                foreach ($parts as $part)
                {
                    $part = explode("=", $part);
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
                }
                $item = self::db()->loadObject("SELECT id, alias FROM #__menus_items WHERE component = ? AND controller = ? AND content_id = ?", array($component, $controller, $content_id));
                if ($item->id > 0)
                {
                    return BASE_URL.$item->alias;
                }
                else
                {
                    $routername = $component ."Router";
                    require_once(__DIR__ ."/../../components/". $component ."/router.php");
                    self::$router = new $routername(self::$db);
                    $custom = self::router()->route($link);
                    if (strlen($custom) > 0)
                    {
                        return $custom;
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
            $string = str_replace(SUBFOLDER, "", $string);
            if ($string == "index.php" || $string == "")
            {
                // If no rule from router found, find homepage
                $item = self::db()->loadObject("SELECT * FROM #__menus_items WHERE is_home = ?", array(1));
                self::changeTitle($item->title);
                $this->component = $item->component;
                $this->controller = $item->controller;
                $this->content_id = $item->content_id;
                self::$menu_item_id = $item->id;
                return;
            }
            if (strpos($string, "index.php?") !== false)
            {
                $string = str_replace("index.php?", "", $string);
                $ps = explode("=", $string);
                $parts = array();
                foreach ($ps as $part)
                {
                    $string = explode("=", $part);
                    $parts[] = $string["1"];
                }
                $item = new stdClass();
            }
            else
            {
                $task_split = explode("?", $string);
                $parts = explode("/", $task_split["0"]);
                if (strlen($parts[0]) == 0) array_shift($parts);
                $first = self::db()->loadObject("SELECT * FROM #__menus_items WHERE alias = ? AND published = 1", array($parts["0"]));
                if ($first->id > 0)
                {
                    $alias = end($parts);
                    $item = self::db()->loadObject("SELECT * FROM #__menus_items WHERE alias = ? AND published = 1", array($alias));
                    if ($item->id <= 0)
                    {
                        // Use Custom Router
                        $routername = $first->component ."Router";
                        require_once(__DIR__ ."/../../components/". $first->component ."/router.php");
                        self::$router = new $routername($this->database);
                        if (strlen(self::router()->component) > 0)
                        {
                            // We have a router!
                            $new_parts = self::router()->unroute($parts);
                            $this->component = $new_parts["0"];
                            $this->controller = $new_parts["1"];
                            $this->content_id = $new_parts["2"];
                            $router_set = true;
                        }
                        else
                        {
                            // Nothing. Default to 404.
                            header("HTTP/1.0 404 Not Found");
                            require_once(__DIR__ ."/../../templates/". $this->template->name ."/error.php"); die();
                        }
                    }
                }
                else
                {
                    $alias = end($parts);
                    $item = self::db()->loadObject("SELECT * FROM #__menus_items WHERE alias = ? AND published = 1", array($alias));
                }
            }
            if (!$router_set)
            {
                if ($item->id > 0)
                {
                    self::changeTitle($item->title);
                    $this->component = $item->component;
                    $this->controller = $item->controller;
                    $this->content_id = $item->content_id;
                    self::$menu_item_id = $item->id;
                }
                else
                {
                    // Use Custom Router
                    if (strlen($parts["0"]) > 0)
                    {
                        $routername = $parts["0"] ."Router";
                        require_once(__DIR__ ."/../../components/". $parts["0"] ."/router.php");
                        self::$router = new $routername($this->database);
                        if (strlen(self::router()->component) > 0)
                        {
                            // We have a router!
                            $new_parts = self::router()->unroute($parts);
                            $this->component = $new_parts["0"];
                            $this->controller = $new_parts["1"];
                            $this->content_id = $new_parts["2"];
                        }
                        else
                        {
                            // Nothing. Default to 404.
                            header("HTTP/1.0 404 Not Found");
                            require_once(__DIR__ ."/../../templates/". $this->template->name ."/error.php"); die();
                        }
                    }
                    else
                    {
                        // If no rule from router found, find homepage
                        $item = self::db()->loadObject("SELECT * FROM #__menus_items WHERE component = ? AND controller = ? AND content_id = ?", array($_GET["component"], $_GET["controller"], $_GET["id"]));
                        self::$menu_item_id = $item->id;
                        if ($item->id <= 0 && strlen($_GET["component"]) == 0)
                        {
                            $item = self::db()->loadObject("SELECT * FROM #__menus_items WHERE is_home = ?", array(1));
                            self::$menu_item_id = $item->id;
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
                }
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
        
        public static function router()
        {
            return self::$router;
        }
        
        public static function config()
        {
            return self::$config;
        }
        
        public static function hooks()
        {
            return self::$hooks;
        }
        
        public static function componentconfig()
        {
            return self::$componentconfig;
        }
        
        public static function content_item_id()
        {
            return self::$content_item_id;
        }
        
        public static function menu_item_id()
        {
            return self::$menu_item_id;
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