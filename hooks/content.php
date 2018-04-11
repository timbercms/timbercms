<?php

	class ContentHook
	{
        
        public $database;
        
		public function __construct($database)
		{
            $this->database = $database;
		}
        
        public function onLoadContent()
        {
            // Process Content Load Hook example
        }
	}

?>