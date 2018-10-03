<?php

    class ArticleController
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
            header("Location: index.php?component=content&controller=article");
        }
        
        public function save($redirect = true)
        {
            $this->model->id = $_POST["id"];
            $this->model->title = $_POST["title"];
            $this->model->alias = $_POST["alias"];
            $this->model->category_id = $_POST["category_id"];
            $this->model->content = $_POST["content"];
            $this->model->published = $_POST["published"];
            $this->model->publish_time = ($_POST["publish_time"] > 0 ? $_POST["publish_time"] : time());
            $this->model->author_id = ($_POST["author_id"] > 0 ? $_POST["author_id"] : $this->core->user()->id);
            $this->model->hits = $_POST["hits"];
            $this->model->meta_description = $_POST["meta_description"];
            $this->model->image = $_POST["image"];
            if (strlen($_FILES["image"]["name"]) > 0)
            {
                $this->model->image = $this->uploadFile();
            }
            if ($this->model->store())
            {
                $this->model->setMessage("success", "Article saved");
            }
            else
            {
                $this->model->setMessage("danger", "Something went wrong during saving");
            }
            if ($redirect)
            {
                header("Location: index.php?component=content&controller=articles");
            }
        }
        
        public function publish()
        {
            $this->model->database->query("UPDATE #__articles SET published = '1' WHERE id = ?", array($_GET["id"]));
            $this->model->setMessage("success", "Article published");
            header("Location: index.php?component=content&controller=articles");
        }
        
        public function unpublish()
        {
            $this->model->database->query("UPDATE #__articles SET published = '0' WHERE id = ?", array($_GET["id"]));
            $this->model->setMessage("success", "Article unpublished");
            header("Location: index.php?component=content&controller=articles");
        }
        
        public function uploadFile()
        {
            if (strlen($_FILES["image"]["name"]) > 0)
            {
                foreach ($_FILES as $key => $file)
                {
                    if (strlen($file["name"]) > 0)
                    {
                        $name = $file["name"];
                        $tmp = $file["tmp_name"];
                        move_uploaded_file($tmp, __DIR__ ."/../../../../images/articles/". $name);
                        return "images/articles/". $name;
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