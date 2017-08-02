<?php

    #=======================================================================================
    # * Bulletin. CMS
    # --------------------------------------------------------------------------------------
    # * GNU General Public License (GPL) (https://opensource.org/licenses/GPL-3.0)
    # * https://www.github.com/Smith0r
    #=======================================================================================

?>
<?php

    require_once(__DIR__ ."/configuration.php");
    require_once(__DIR__ ."/database.php");
    require_once(__DIR__ ."/model.php");
    require_once(__DIR__ ."/template.php");

    class Core
    {
        public $configuration;
        public $database;
        public $model;
        public $controller;
        public $view;
        public $template;
        
        public function __construct()
        {
            $this->configuration = new Configuration();
            $this->database = new Database($this->configuration);
            $this->loadExtension();
            $this->loadTemplate();
        }
        
        public function loadExtension()
        {
            require_once(__DIR__ ."/../extensions/". $_GET["extension"] ."/models/". $_GET["view"] .".php");
            require_once(__DIR__ ."/../extensions/". $_GET["extension"] ."/controllers/". $_GET["controller"] .".php");
            require_once(__DIR__ ."/../extensions/". $_GET["extension"] ."/views/". $_GET["view"] .".php");
            $modelName = ucwords($_GET["view"])."Model";
            $this->model = new $modelName($this->database, $this->model);
            $controllerName = ucwords($_GET["controller"])."Controller";
            $this->controller = new $controllerName($this->model);
            $viewName = ucwords($_GET["view"])."View";
            $this->view = new $viewName($this->controller, $this->model);
        }
        
        public function loadTemplate()
        {
            $template = new Template($this->database, $this->view);
            $template->display();
        }
    }

?>