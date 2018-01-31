<?php

    class ArticleController
    {
        
        private $model;
        
        public function __construct($model)
        {
            $model->addHit();
            $this->model = $model;
            Core::changeTitle($this->model->title);
            Core::changeMetaDescription($this->model->meta_description);
            Core::setMetaAuthor($this->model->author->username);
            Core::addMetaItemProp("name", $this->model->title ." - ". Core::config()->site_title);
            Core::addMetaItemProp("description", $this->model->meta_description);
            Core::addMetaItemProp("image", BASE_URL.$this->model->image);
            Core::addMetaProperty("og:url", BASE_URL.$_SERVER["REQUEST_URI"]);
            Core::addMetaProperty("og:type", "website");
            Core::addMetaProperty("og:title", $this->model->title ." - ". Core::config()->site_title);
            Core::addMetaProperty("og:description", $this->model->meta_description);
            Core::addMetaProperty("og:image", BASE_URL.$this->model->image);
            Core::addMetaName("twitter:card", "summary_large_image");
            Core::addMetaName("twitter:title", $this->model->title ." - ". Core::config()->site_title);
            Core::addMetaName("twitter:description", $this->model->meta_description);
            Core::addMetaName("twitter:image", BASE_URL.$this->model->image);
        }
        
    }

?>