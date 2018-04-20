<?php

	class SitemapHook
	{
        
        public $database;
        
		public function __construct($database)
		{
            $this->database = $database;
		}
        
        public function onXMLSitemap()
        {
            $time = date("Y-m-d", time());
            echo '    <url>';
                echo '        <loc><![CDATA['. Core::route("index.php?component=sitemap&controller=sitemap") .']]></loc>';
                echo '        <lastmod>'. $time .'</lastmod>';
                echo '        <changefreq>weekly</changefreq>';
                echo '        <priority>0.5</priority>';
            echo '    </url>';
        }
	}

?>