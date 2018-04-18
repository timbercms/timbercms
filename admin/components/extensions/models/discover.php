<?php

    class DiscoverModel extends Model
    {
        
        public $template = "discover.php";
        public $database;
        
        public $new_components = array();
        
        public function __construct($id = 0, $database)
        {
            $this->database = $database;
            $this->loadNewComponents();
        }
        
        public function loadNewComponents()
        {
            $dirs = scandir(__DIR__ ."/../../");
            unset($dirs["0"], $dirs["1"]);
            foreach ($dirs as $dir)
            {
                $test = $this->database->loadObject("SELECT id FROM #__components WHERE internal_name = ?", array($dir));
                if ($test->id <= 0)
                {
                    $this->new_components[] = $dir;
                }
            }
        }
        
    }

?>