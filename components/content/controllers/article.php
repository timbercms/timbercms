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
            Core::hooks()->executeHook("onLoadContent");
        }
        
        public function postComment()
        {
            if (Core::user()->id > 0)
            {
                $comment = new CommentModel(0, $this->database);
                $comment->article_id = $_POST["article_id"];
                $comment->content = $_POST["content"];
                $comment->published = 1;
                $comment->publish_time = time();
                $comment->author_id = Core::user()->id;
                $comment->store();
                Core::hooks()->executeHook("onPostComment");
                $this->model->setMessage("success", "Your comment has been posted successfully!");
                header("Location: ". Core::route("index.php?component=content&controller=article&id=". $comment->article_id));
            }
            else
            {
                $this->model->setMessage("danger", "Sorry, but you must be logged in to post a comment.");
                header("Location: ". Core::route("index.php?component=content&controller=article&id=". $comment->article_id));
            }
        }
        
        public function hideComment()
        {
            if (Core::user()->usergroup->is_admin == 1)
            {
                $this->model->database->query("UPDATE #__articles_comments SET published = ? WHERE id = ?", array(0, $_GET["id"]));
                $this->model->setMessage("success", "The comment has been hidden.");
                header("Location: ". Core::route("index.php?component=content&controller=article&id=". $_GET["article_id"]));
            }
            else
            {
                $this->model->setMessage("danger", "Sorry, but you do not have the required authorisation to perform this action.");
                header("Location: ". Core::route("index.php?component=content&controller=article&id=". $_GET["article_id"]));
            }
        }
        
        public function unhideComment()
        {
            if (Core::user()->usergroup->is_admin == 1)
            {
                $this->model->database->query("UPDATE #__articles_comments SET published = ? WHERE id = ?", array(1, $_GET["id"]));
                $this->model->setMessage("success", "The comment has been unhidden.");
                header("Location: ". Core::route("index.php?component=content&controller=article&id=". $_GET["article_id"]));
            }
            else
            {
                $this->model->setMessage("danger", "Sorry, but you do not have the required authorisation to perform this action.");
                header("Location: ". Core::route("index.php?component=content&controller=article&id=". $_GET["article_id"]));
            }
        }
        
    }

?>