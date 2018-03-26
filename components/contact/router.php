<?php

    class ContactRouter
    {
        
        public $database;
        public $component = "contact";
        
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
                if ($controller == "enquiry")
                {
                    return BASE_URL .$this->component ."/form". (strlen($task) > 0 ? "?task=". $task : "");
                }
                else if ($controller == "complete")
                {
                    return BASE_URL .$this->component ."/thank-you";
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
            if ($parts["1"] == "form")
            {
                $new_parts = ["contact", "enquiry", 0];
                return $new_parts;
            }
            else if ($parts["1"] == "thank-you")
            {
                $new_parts = ["contact", "complete", 0];
                return $new_parts;
            }
            return false;
        }
        
    }

?>