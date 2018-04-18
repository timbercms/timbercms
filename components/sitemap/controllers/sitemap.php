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
            $items = $this->model->database->loadObjectList("SELECT * FROM #__menus_items WHERE published = 1");
            $string = '<?xml version="1.0" encoding="UTF-8"?>';
            $string .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
            foreach ($items as $item)
            {
                $string .= '    <url>';
                    $string .= '        <loc><![CDATA['. Core::route("index.php?component=". $item->component ."&controller=". $item->controller .($item->content_id > 0 ? "&id=". $item->content_id : "")) .']]></loc>';
                    $string .= '        <lastmod>'. $time .'</lastmod>';
                    $string .= '        <changefreq>weekly</changefreq>';
                    $string .= '        <priority>0.5</priority>';
                $string .= '    </url>';
            }
            $string .= '</urlset>';
            echo $string;
        }
        
    }

?>