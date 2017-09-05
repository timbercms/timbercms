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
        
        public function save()
        {
            $this->model->id = $_POST["id"];
            $this->model->title = $_POST["title"];
            $this->model->alias = $_POST["alias"];
            $this->model->category_id = $_POST["category_id"];
            $this->model->content = $_POST["content"];
            $this->model->published = $_POST["published"];
            $this->model->publish_time = ($_POST["publish_time"] > 0 ? $_POST["publish_time"] : time());
            $this->model->start_publishing = $_POST["start_publishing"];
            $this->model->stop_publishing = $_POST["stop_publishing"];
            $this->model->author_id = ($_POST["author_id"] > 0 ? $_POST["author_id"] : $this->core->user()->id);
            $this->model->hits = $_POST["hits"];
            $this->model->meta_description = $_POST["meta_description"];
            $this->model->tags = $_POST["tags"];
            $this->model->store();
            header("Location: index.php?component=content&controller=articles");
        }
        
    }

?>