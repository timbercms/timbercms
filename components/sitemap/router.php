<?php

    class SitemapRouter
    {
        
        public $database;
        public $component = "sitemap";
        
        public function __construct($database)
        {
            $this->database = $database;
        }
        
        public function route($link)
        {
            $parts = explode("&", $link);
            foreach ($parts as $part)
            {
                $string = explode("=", $part);
                switch ($string["0"])
                {
                    case "component":
                        $comp = $string["1"];
                        break;
                    case "controller":
                        $controller = $string["1"];
                        break;
                    case "id":
                        $id = $string["1"];
                        break;
                    case "task":
                        $task = $string["1"];
                        break;
                }
            }
            if ($comp == $this->component)
            {
                if ($controller == "sitemap")
                {
                    return BASE_URL .$this->component ."/display";
                }
            }
            else
            {
                return;
            }
        }
        
        public function unroute($parts)
        {
            $new_parts = array();
            if ($parts["1"] == "display")
            {
                $new_parts = ["sitemap", "sitemap", 0];
                return $new_parts;
            }
            return false;
        }
        
    }

?>