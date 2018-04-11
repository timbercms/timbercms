<?php

	class Hooks
	{
        
        public $database;
        public $hooks = array();
        
		public function __construct($database)
		{
            $this->database = $database;
			$this->loadHooks();
		}
        
        public function loadHooks()
        {
            $files = scandir(__DIR__ ."/../../hooks");
            unset($files["0"], $files["1"]);
            foreach ($files as $file)
            {
                require_once(__DIR__ ."/../../hooks/". $file);
                $name = explode(".", $file)["0"]."Hook";
                $this->hooks[] = new $name($this->database);
            }
        }
        
        public function executeHook($name)
        {
            foreach ($this->hooks as $hook)
            {
                if (method_exists($hook, $name))
                {
                    $hook->$name();
                }
            }
        }
	}

?>