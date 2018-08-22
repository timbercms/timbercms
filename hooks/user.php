<?php

	class UserHook
	{
        
        public $database;
        
		public function __construct($database)
		{
            $this->database = $database;
		}
        
        public function onXMLSitemap()
        {
            $time = date("Y-m-d", time());
            $items = $this->database->loadObjectList("SELECT id FROM #__users WHERE activated = 1");
            foreach ($items as $item)
            {
                echo '    <url>';
                    echo '        <loc><![CDATA['. Core::route("index.php?component=user&controller=profile&id=". $item->id) .']]></loc>';
                    echo '        <lastmod>'. $time .'</lastmod>';
                    echo '        <changefreq>weekly</changefreq>';
                    echo '        <priority>0.5</priority>';
                echo '    </url>';
            }
        }
        
        public function onHTMLSitemap()
        {
            $items = $this->database->loadObjectList("SELECT id, username FROM #__users WHERE activated = 1");
            foreach ($items as $item)
            {
                echo '<p><a href="'. Core::route("index.php?component=user&controller=profile&id=". $item->id) .'">'. $item->username .'\'s Profile</a></p>';
            }
        }
        
        public function onLoadCategoryModel($model)
        {
            $model->testing = "Test!";
        }
	}

?>