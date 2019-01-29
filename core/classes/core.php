<?php
    
    /*
     #=====================================================================================
     # * Timber CMS
     # * https://github.com/timbercms/timbercms
     #-------------------------------------------------------------------------------------
     # * Class Core
     # * Provides all core functionality of Timber CMS
     #=====================================================================================
    */

    define("ADMIN", false);
    require_once(__DIR__ ."/model.php");
    require_once(__DIR__ ."/pagination.php");
    require_once(__DIR__ ."/view.php");
    if (ADMIN)
    {
        require_once(__DIR__ ."/../../admin/components/user/models/user.php");
        require_once(__DIR__ ."/../../admin/components/logs/models/log.php");
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
        public static $menu_item;
        public static $stylesheets = array();
        public static $stylesheet_links = array();
        public static $scripts = array();
        public static $script_links = array();
        public static $db;
        public static $title = "";
        public static $description = '<meta name="description" content="Bulletin. CMS">';
        public $component;
        public $controller;
        public $model;
        public $task;
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
        public static $template_name;
        public static $component_name;
        public static $controller_name;
        public static $template_class;
        
        /*
         #=====================================================================================
         # * __construct
         # * Sets all the defaults, includes component files, and sets up MVC
         #=====================================================================================
        */
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
                if (self::$user->usergroup->is_admin != 1 && $_GET["task"] != "login")
                {
                    require_once(__DIR__ ."/../../admin/login.php"); die();
                }
                $modelname = $this->controller ."Model";
                $controllername = $this->controller ."Controller";
                require_once(__DIR__ ."/../../admin/components/". $this->component ."/models/". $this->controller .".php");
                require_once(__DIR__ ."/../../admin/components/". $this->component ."/controllers/". $this->controller .".php");
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
                    $this->template->addCriticalCSS();
                    $this->template->addComponentStylesheet($this->component);
                    $this->template->addComponentScript($this->component);
                    $this->database->close();
                }
            }
            else
            {
                $this->setDatabase();
                $this->checkRedirects();
                $this->cleanSessions();
                self::$hooks = new Hooks($this->database);
                $config = $this->database->loadObject("SELECT params FROM #__components WHERE internal_name = 'settings' LIMIT 1");
                $params = (object) unserialize($config->params);
                ini_set("display_errors", $params->error_reporting);
                switch ($params->error_reporting_level)
                {
                    case "normal":
                        error_reporting(E_ERROR | E_WARNING | E_PARSE);
                        break;
                    case "development":
                        error_reporting(E_ALL);
                        break;
                }
                self::$config = $params;
                require_once(__DIR__ ."/template.php");
                $template = new Template($this->database, $params->default_template);
                $this->template = $template;
                self::$template_class = $template;
                self::$template_name = $template->name;
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
                if ($this->component != "system" && $this->controller != "blank")
                {
                    $test_comp = $this->database->loadObject("SELECT id, enabled, is_frontend FROM #__components WHERE internal_name = ?", array($this->component));
                    if (!$test_comp->enabled || !$test_comp->is_frontend)
                    {
                        // Abort! Component is disabled!
                        $this->displayErrorPage();
                    }
                    $modelname = $this->controller ."Model";
                    $controllername = $this->controller ."Controller";
                    require_once(__DIR__ ."/../../components/". $this->component ."/models/". $this->controller .".php");
                    require_once(__DIR__ ."/../../components/". $this->component ."/controllers/". $this->controller .".php");
                    $model = new $modelname($this->content_id, $this->database);
                    $controller = new $controllername($model);
                    $componentconfig = $this->database->loadObject("SELECT params FROM #__components WHERE internal_name = ? LIMIT 1", array($this->component));
                    self::$componentconfig = (object) unserialize($componentconfig->params);
                }
                //echo "<pre>"; print_r($this); echo "</pre>"; die();
                if (strlen($_GET["task"]) > 0 && ($this->component != "system" && $this->controller != "blank"))
                {
                    $task = $_GET["task"];
                    $controller->$task();
                }
                else
                {
                    if ($this->component != "system" && $this->controller != "blank")
                    {
                        $view = new View($controller, $model, $this);
                        $this->view = $view;
                    }
                    else
                    {
                        self::$component_name = $this->component;
                        self::$controller_name = $this->controller;
                    }
                    require_once(__DIR__ ."/../../templates/". $this->template->name ."/index.php");
                    $this->template->addCriticalCSS();
                    $this->template->addComponentStylesheet($this->component);
                    $this->template->addComponentScript($this->component);
                    $this->database->close();
                }
            }
        }

        /*
         #=====================================================================================
         # * outputView
         # * $view = class View
         # * Output component view if user has access to view the page
         #=====================================================================================
        */
        public static function outputView($view)
        {
            if (self::$component_name != "system" && self::$controller_name != "blank")
            {
                if (is_array(self::$menu_item->params["access"]))
                {
                    if (in_array(self::$user->usergroup->id, self::$menu_item->params["access"]) || in_array(0, self::$menu_item->params["access"]))
                    {
                        $view->output();
                    }
                    else
                    {
                        echo '<div class="alert alert-danger">You do not have access to this page</div>';
                    }
                }
                else
                {
                    $view->output();
                }
            }
        }
        
        /*
         #=====================================================================================
         # * loadOverride
         # * $template = class Template
         # * Loads template overrides for component if one exists
         #=====================================================================================
        */
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
        
        /*
         #=====================================================================================
         # * setDatabase
         # * Set database information
         #=====================================================================================
        */
        public function setDatabase()
        {
            require_once(__DIR__ ."/../../configuration.php");
            require_once(__DIR__ ."/database.php");
            $db = new Database();
            $this->database = $db;
            self::$db = $db;
        }
        
        public function checkRedirects()
        {
            $redirect = $this->database->loadObject("SELECT * FROM #__redirects WHERE from_url = ? AND published = '1'", array(str_replace(SUBFOLDER, "", $_SERVER["REQUEST_URI"])));
            if (is_object($redirect) && $redirect->id > 0)
            {
                header("HTTP/1.1 301 Moved Permanently");
                header("Location: ". BASE_URL.$redirect->to_url);
                exit();
            }
        }
        
        /*
         #=====================================================================================
         # * addStylesheet
         # * $link = (string) Link to location of CSS file. Can be relative or external
         # * Adds stylesheet string into array for later processing
         #=====================================================================================
        */
        public static function addStylesheet($link)
        {
            if (!in_array($link, self::$stylesheet_links))
            {
                if (substr($link, 0, 4) != "http")
                {
                    if (file_exists(__DIR__ ."/../../". $link))
                    {
                        self::$stylesheet_links[] = $link;
                        self::$stylesheets[] = '<link rel="stylesheet" href="'. BASE_URL.$link .'?v='. time() .'">';
                    }
                }
                else
                {
                    self::$stylesheet_links[] = $link;
                    self::$stylesheets[] = '<link rel="stylesheet" href="'. $link .'?v='. time() .'">';
                }
            }
        }
        
        /*
         #=====================================================================================
         # * addScript
         # * $link = (string) Link to location of JS file. Can be relative or external
         # * Adds script string into array for later processing
         #=====================================================================================
        */
        public static function addScript($link)
        {
            if (!in_array($link, self::$script_links))
            {
                if (substr($link, 0, 4) != "http")
                {
                    if (file_exists(__DIR__ ."/../../". $link))
                    {
                        self::$script_links[] = $link;
                        self::$scripts[] = '<script src="'. BASE_URL.$link .'?v='. time() .'"></script>';
                    }
                }
                else
                {
                    self::$script_links[] = $link;
                    self::$scripts[] = '<script src="'. $link .'?v='. time() .'"></script>';
                }
            }
        }
        
        /*
         #=====================================================================================
         # * changeTitle
         # * $title = (string) New title string
         # * Changes the <title> tag to desired value
         #=====================================================================================
        */
        public static function changeTitle($title)
        {
            self::$title = $title;
        }
        
        /*
         #=====================================================================================
         # * changeMetaDescription
         # * $title = (string) New meta description string
         # * Changes the meta description tag to desired value
         #=====================================================================================
        */
        public static function changeMetaDescription($string)
        {
            if (strlen($string) > 0)
            {
                self::$description = '<meta name="description" content="' .$string .'">';
            }
        }
        
        public static function addMetaProperty($name, $content)
        {
            if (strlen($content) > 0)
            {
                self::$meta_properties[] = '<meta property="'. $name .'" content="'. $content .'" />';
            }
        }
        
        public static function addMetaItemProp($name, $content)
        {
            if (strlen($content) > 0)
            {
                self::$meta_itemprops[] = '<meta itemprop="'. $name .'" content="'. $content .'" />';
            }
        }
        
        public static function addMetaName($name, $content)
        {
            if (strlen($content) > 0)
            {
                self::$meta_names[] = '<meta name="'. $name .'" content="'. $content .'" />';
            }
        }
        
        public static function setMetaAuthor($string)
        {
            if (strlen($string) > 0)
            {
                self::$meta_author = '<meta name="author" content="'. $string .'">';
            }
        }
        
        public function finalise($page)
        {
            $page = str_replace("<!-- HEADER_STYLES -->", implode("", self::$stylesheets), $page);
            $page = str_replace("<!-- HEADER_SCRIPTS -->", implode("", self::$scripts), $page);
            $page = str_replace("<!-- PAGE_TITLE -->", self::$title." - ".self::$config->site_title, $page);
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
                        case "task":
                            $task = $part["1"];
                            break;
                    }
                }
                $item = self::db()->loadObject("SELECT id, alias, parent_id FROM #__menus_items WHERE component = ? AND controller = ? AND content_id = ?", array($component, $controller, $content_id));
                if (strlen($task) == 0 && $item->id > 0)
                {
                    $alias = array();
                    $alias[] = $item->alias;
                    if ($item->parent_id > 0)
                    {
                        $parent = self::db()->loadObject("SELECT id, alias, parent_id FROM #__menus_items WHERE id = ?", array($item->parent_id));
                        $alias[] = $parent->alias;
                        if ($parent->parent_id > 0)
                        {
                            $grandparent = self::db()->loadObject("SELECT id, alias, parent_id FROM #__menus_items WHERE id = ?", array($parent->parent_id));
                            $alias[] = $grandparent->alias;
                        }
                    }
                    $alias = array_reverse($alias);
                    $alias = implode("/", $alias);
                    return BASE_URL.$alias;
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
                self::$menu_item = new MenuItemModel($item->id, self::db());
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
                    self::$menu_item_id = $first->id;
                    if ($first->component == "system" && $first->controller == "blank")
                    {
                        $this->component = "system";
                        self::$component_name = "system";
                        $this->controller = "blank";
                        self::$controller_name = "blank";
                        $this->content_id = 0;
                        $router_set = true;
                    }
                    $menu_item = new MenuItemModel($first->id, self::db());
                    self::$menu_item = $menu_item;
                    self::changeTitle($menu_item->title);
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
                            $this->displayErrorPage();
                        }
                    }
                }
                else
                {
                    $alias = end($parts);
                    $item = self::db()->loadObject("SELECT * FROM #__menus_items WHERE alias = ? AND published = 1", array($alias));
                    self::$menu_item = new MenuItemModel($item->id, self::db());
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
                    self::$menu_item = new MenuItemModel($item->id, self::db());
                }
                else
                {
                    // Check that we have a valid component
                    $component = $this->database->loadObject("SELECT id FROM #__components WHERE internal_name = ? AND enabled = '1'", array($parts[0]));
                    if ($component->id > 0)
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
                                $this->displayErrorPage();
                            }
                        }
                        else
                        {
                            // If no rule from router found, find homepage
                            $item = self::db()->loadObject("SELECT * FROM #__menus_items WHERE component = ? AND controller = ? AND content_id = ?", array($_GET["component"], $_GET["controller"], $_GET["id"]));
                            self::$menu_item_id = $item->id;
                            self::$menu_item = new MenuItemModel($item->id, self::db());
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
                    else
                    {
                        // Component not found, default to 404 page
                        $this->displayErrorPage();
                    }
                }
            }
        }
        
        public function displayErrorPage()
        {
            header("HTTP/1.0 404 Not Found");
            if (file_exists(__DIR__ ."/../../templates/". $this->template->name ."/error.php"))
            {
                require_once(__DIR__ ."/../../templates/". $this->template->name ."/error.php"); die();
            }
            else
            {
                require_once(__DIR__ ."/../templates/error.php"); die();
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
        
        public static function template_name()
        {
            return self::$template_name;
        }
        
        public static function template_class()
        {
            return self::$template_class;
        }
        
        public function cleanSessions()
        {
            Core::db()->query("DELETE FROM #__sessions WHERE access < (UNIX_TIMESTAMP() - 2592000) LIMIT 100", array());
            Core::db()->query("DELETE FROM #__sessions WHERE access < (UNIX_TIMESTAMP() - 86400) AND user_id = 0 LIMIT 100", array());
        }
        
        public function displaySystemMessages()
        {
            if (!isset($_SESSION["MESSAGES"])) return;

            if (count($_SESSION["MESSAGES"]) > 0 && strlen($_GET["task"]) == 0)
            {
                foreach ($_SESSION["MESSAGES"] as $message)
                {
                    echo $message;
                }
                unset($_SESSION["MESSAGES"]);
            }
        }
        
        public static function generateAlias($string, $table)
        {
            $banned = array("admin");
            // TODO - unique aliases
            $string = trim($string);
            $string = str_replace("-", "", $string);
            $string = preg_replace('/[^A-Za-z0-9-]+/', '-', $string);
            $string = rtrim($string, "-");
            $string = strtolower($string);
            if (in_array($string, $banned))
            {
                // This alias is a banned alias! Notify the user that their alias has been modified.
                $_SESSION["MESSAGES"][] = '<div class="system-message danger">This alias has been modified because it contains one of the following aliases, which could disrupt website functionality: ('. implode(", ", $banned) .')</div>';
                return $string."-banned";
            }
            else
            {
                // Check for duplicates in menu items, if none, check in the table.
                // If a duplicate is found, set a message to notify the user that their alias has been modified.
                $duplicates = Core::db()->loadObjectList("SELECT id FROM #__menus_items WHERE alias = ?", array($string));
                if (count($duplicates) > 0)
                {
                    // Duplicate found! Change the alias to have a suffix of "-duplicatecount"
                    // Also notify the user.
                    $_SESSION["MESSAGES"][] = '<div class="system-message danger">A menu item with this alias already exists. To keep everything working, a number has been added to the end of your alias. It is recommended that you change your alias to be unique.</div>';
                    return $string."-".count($duplicates);
                }
                else
                {
                    // No menu item duplicates found, check in the table.
                    $duplicates = Core::db()->loadObjectList("SELECT id FROM #__". $table ." WHERE alias = ?", array($string));
                    if (count($duplicates) > 0)
                    {
                        $_SESSION["MESSAGES"][] = '<div class="system-message danger">An entity with this alias already exists. To keep everything working, a number has been added to the end of your alias. It is recommended that you change your alias to be unique.</div>';
                        return $string."-".count($duplicates);
                    }
                    else
                    {
                        return $string;
                    }
                }
            }
        }
        
        public static function log($label)
        {
            $log = new LogModel(0, self::db());
            $log->label = $label;
            $log->event_author = self::user()->id;
            $log->event_time = time();
            $log->store();
        }
        
    }

?>