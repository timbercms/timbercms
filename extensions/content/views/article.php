<?php

    #=======================================================================================
    # * Bulletin. CMS
    # --------------------------------------------------------------------------------------
    # * GNU General Public License (GPL) (https://opensource.org/licenses/GPL-3.0)
    # * https://www.github.com/Smith0r
    #=======================================================================================

?>
<?php

    class ArticleView
    {
        private $model;
        private $controller;
        public $template = "article.php";
        
        public function __construct($controller, $model)
        {
            $this->controller = $controller;
            $this->model = $model;
        }
        
        public function display()
        {
            require_once(__DIR__ ."/templates/". $this->template);
        }
    }

?>