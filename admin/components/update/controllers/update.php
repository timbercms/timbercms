<?php

    class UpdateController
    {
        
        private $model;
        private $core;
        
        public function __construct($model, $core)
        {
            $this->model = $model;
            $this->core = $core;
        }
        
        public function update()
        {
            $opts = [
                'http' => [
                        'method' => 'GET',
                        'header' => [
                                'User-Agent: PHP'
                        ]
                ]
            ];
            $context = stream_context_create($opts);
            $web_version = json_decode(file_get_contents("https://api.github.com/repos/Smith0r/bulletin/releases", false, $context));
            $web_version = $web_version["0"];
            $file = file_put_contents(__DIR__ ."/../../../../update.zip", file_get_contents($web_version->assets["0"]->browser_download_url));
            $zip = new ZipArchive;
            $res = $zip->open(__DIR__ ."/../../../../update.zip");
            if ($res == TRUE)
            {
                $zip->extractTo(__DIR__ ."/../../../../");
                $zip->close();
                echo "Zip File Extracted! CMS Updated!";
            }
            else
            {
                echo "Does the zip file exist? Can't find it.";
            }
        }
        
    }

?>