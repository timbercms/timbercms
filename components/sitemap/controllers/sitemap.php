<?php

    class SitemapController
    {
        
        private $model;
        
        public function __construct($model)
        {
            $this->model = $model;
        }
        
        public function xml()
        {
            header('Content-Type: text/xml');
            $time = date("Y-m-d", time());
            echo '<?xml version="1.0" encoding="UTF-8"?>';
            echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
            foreach ($this->model->items as $item)
            {
                echo '    <url>';
                    echo '        <loc><![CDATA['. Core::route("index.php?component=". $item->component ."&controller=". $item->controller .($item->content_id > 0 ? "&id=". $item->content_id : "")) .']]></loc>';
                    echo '        <lastmod>'. $time .'</lastmod>';
                    echo '        <changefreq>weekly</changefreq>';
                    echo '        <priority>0.5</priority>';
                echo '    </url>';
            }
            Core::hooks()->executeHook("onXMLSitemap");
            echo '</urlset>';
        }
        
    }

?>