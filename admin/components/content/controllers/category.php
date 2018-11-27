<?php

    class CategoryController
    {
        
        private $model;
        private $core;
        
        public function __construct($model, $core)
        {
            $this->model = $model;
            $this->core = $core;
        }
        
        public function saveandnew()
        {
            $this->save(false);
            header("Location: index.php?component=content&controller=category");
        }
        
        public function save($redirect = true)
        {
            foreach ($_POST as $key => $value)
            {
                $this->model->$key = $value;
            }
            if (strlen($_FILES["image"]["name"]) > 0)
            {
                $this->model->image = $this->uploadFile();
            }
            if ($this->model->store())
            {
                $this->model->setMessage("success", "Category saved");
            }
            else
            {
                $this->model->setMessage("danger", "Something went wrong during saving");
            }
            if ($redirect)
            {
                header("Location: index.php?component=content&controller=categories");
            }
        }
        
        public function publish()
        {
            $this->model->database->query("UPDATE #__articles_categories SET published = '1' WHERE id = ?", array($_GET["id"]));
            $this->model->setMessage("success", "Category published.");
            header("Location: index.php?component=content&controller=categories");
        }
        
        public function unpublish()
        {
            $this->model->database->query("UPDATE #__articles_categories SET published = '0' WHERE id = ?", array($_GET["id"]));
            $this->model->setMessage("success", "category unpublished");
            header("Location: index.php?component=content&controller=categories");
        }
        
        public function uploadFile()
        {
            if (strlen($_FILES["image"]["name"]) > 0)
            {
                foreach ($_FILES as $key => $file)
                {
                    if (strlen($file["name"]) > 0)
                    {
                        $name = ($this->model->id > 0 ? $this->model->id : Core::user()->id)."-".time().".".explode(".", $_FILES["image"]["name"])[1];
                        $tmp = $file["tmp_name"];
                        move_uploaded_file($tmp, __DIR__ ."/../../../../images/categories/". $name);
                        return "images/categories/". $name;
                        break;
                    }
                    else
                    {
                        return false;
                    }
                }
            }
            else
            {
                return false;
            }
        }
        
    }

?>