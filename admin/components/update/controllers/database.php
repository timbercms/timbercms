<?php

    class DatabaseController
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
            if (file_exists(__DIR__ ."/../../../../databaseUpdate.txt"))
            {
                $contents = file_get_contents(__DIR__ ."/../../../../databaseUpdate.txt");
                $contents = str_replace("#__", DATABASE_PREFIX, $contents);
                $contents = explode(";", $contents);
                unset($contents[count($contents) - 1]);
                $completed = 0;
                foreach ($contents as $command)
                {
                    $this->model->database->query($command);
                }
                unlink(__DIR__ ."/../../../../databaseUpdate.txt");
                $this->model->setMessage("success", "Database has been successfully updated");
                header('Location: index.php?component=update&controller=update');
            }
            else
            {
                // Nothing to do, quit out.
                $this->model->setMessage("warning", "Database did not need updating");
                header('Location: index.php?component=update&controller=update');
            }
        }
        
    }

?>