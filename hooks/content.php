<?php

	class ContentHook
	{
        
        public $database;
        
		public function __construct($database)
		{
            $this->database = $database;
		}
        
        public function onXMLSitemap()
        {
            $time = date("Y-m-d", time());
            $cats = $this->database->loadObjectList("SELECT id FROM #__articles_categories WHERE published = 1");
            $items = $this->database->loadObjectList("SELECT id FROM #__articles WHERE published = 1");
            foreach ($cats as $cat)
            {
                echo '    <url>';
                    echo '        <loc><![CDATA['. Core::route("index.php?component=content&controller=category&id=". $cat->id) .']]></loc>';
                    echo '        <lastmod>'. $time .'</lastmod>';
                    echo '        <changefreq>weekly</changefreq>';
                    echo '        <priority>0.5</priority>';
                echo '    </url>';
            }
            foreach ($items as $item)
            {
                echo '    <url>';
                    echo '        <loc><![CDATA['. Core::route("index.php?component=content&controller=article&id=". $item->id) .']]></loc>';
                    echo '        <lastmod>'. $time .'</lastmod>';
                    echo '        <changefreq>weekly</changefreq>';
                    echo '        <priority>0.5</priority>';
                echo '    </url>';
            }
        }
        
        public function onHTMLSitemap()
        {
            $cats = $this->database->loadObjectList("SELECT id, title FROM #__articles_categories WHERE published = 1");
            $items = $this->database->loadObjectList("SELECT id, title FROM #__articles WHERE published = 1");
            foreach ($cats as $cat)
            {
                echo '<p><a href="'. Core::route("index.php?component=content&controller=category&id=". $cat->id) .'">'. $cat->title .'</a></p>';
            }
            foreach ($items as $item)
            {
                echo '<p><a href="'. Core::route("index.php?component=content&controller=article&id=". $item->id) .'">'. $item->title .'</a></p>';
            }
        }
	}

?>