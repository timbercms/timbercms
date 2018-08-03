<?php

    class DatabaseModel extends Model
    {
        
        public $template = "database.php";
        public $database;
        public $form;
        public $schema = array();
        public $optimal_schema = array();
        public $broken_tables = array();
        public $extra_tables = array();
        public $current_tables = array();
        public $optimal_tables = array();
        public $missing = array();
        public $extra = array();
        
        public function __construct($id = 0, $database)
        {
            $this->database = $database;
            $this->schema = $this->database->loadObjectList("SELECT table_name, column_name FROM INFORMATION_SCHEMA.COLUMNS WHERE table_schema = ? ORDER BY table_name, ordinal_position", array(DATABASE_NAME));
            $this->loadSchema();
            $this->prepare();
        }
        
        public function loadSchema()
        {
            $tables = array();
            $tables[DATABASE_PREFIX."articles"] = array();
            $tables[DATABASE_PREFIX."articles"][] = array("name" => "id", "params" => "int(11) NOT NULL AUTO_INCREMENT");
            $tables[DATABASE_PREFIX."articles"][] = array("name" => "title", "params" => "varchar(500) DEFAULT NULL");
            $tables[DATABASE_PREFIX."articles"][] = array("name" => "alias", "params" => "varchar(500) NOT NULL");
            $tables[DATABASE_PREFIX."articles"][] = array("name" => "category_id", "params" => "int(11) NOT NULL DEFAULT '0'");
            $tables[DATABASE_PREFIX."articles"][] = array("name" => "content", "params" => "text");
            $tables[DATABASE_PREFIX."articles"][] = array("name" => "published", "params" => "int(11) NOT NULL DEFAULT '1'");
            $tables[DATABASE_PREFIX."articles"][] = array("name" => "publish_time", "params" => "int(11) DEFAULT NULL");
            $tables[DATABASE_PREFIX."articles"][] = array("name" => "author_id", "params" => "int(11) DEFAULT NULL");
            $tables[DATABASE_PREFIX."articles"][] = array("name" => "hits", "params" => "int(11) DEFAULT NULL");
            $tables[DATABASE_PREFIX."articles"][] = array("name" => "meta_description", "params" => "varchar(500) DEFAULT NULL");
            $tables[DATABASE_PREFIX."articles"][] = array("name" => "image", "params" => "varchar(1000) DEFAULT NULL");
            
            $tables[DATABASE_PREFIX."articles_categories"][] = array("name" => "id", "params" => "int(11) NOT NULL AUTO_INCREMENT");
            $tables[DATABASE_PREFIX."articles_categories"][] = array("name" => "title", "params" => "varchar(500) DEFAULT NULL");
            $tables[DATABASE_PREFIX."articles_categories"][] = array("name" => "alias", "params" => "varchar(500) DEFAULT NULL");
            $tables[DATABASE_PREFIX."articles_categories"][] = array("name" => "description", "params" => "text");
            $tables[DATABASE_PREFIX."articles_categories"][] = array("name" => "published", "params" => "int(11) DEFAULT '1'");
            $tables[DATABASE_PREFIX."articles_categories"][] = array("name" => "params", "params" => "text");
            
            $tables[DATABASE_PREFIX."articles_comments"] = array();
            $tables[DATABASE_PREFIX."articles_comments"][] = array("name" => "id", "params" => "int(11) NOT NULL AUTO_INCREMENT");
            $tables[DATABASE_PREFIX."articles_comments"][] = array("name" => "article_id", "params" => "INT(11) NOT NULL");
            $tables[DATABASE_PREFIX."articles_comments"][] = array("name" => "content", "params" => "text NOT NULL");
            $tables[DATABASE_PREFIX."articles_comments"][] = array("name" => "published", "params" => "INT(11) NOT NULL");
            $tables[DATABASE_PREFIX."articles_comments"][] = array("name" => "publish_time", "params" => "INT(11) NOT NULL");
            $tables[DATABASE_PREFIX."articles_comments"][] = array("name" => "author_id", "params" => "INT(11) NOT NULL");
            
            $tables[DATABASE_PREFIX."components"][] = array("name" => "id", "params" => "int(11) NOT NULL AUTO_INCREMENT");
            $tables[DATABASE_PREFIX."components"][] = array("name" => "title", "params" => "varchar(255) DEFAULT NULL");
            $tables[DATABASE_PREFIX."components"][] = array("name" => "description", "params" => "varchar(5000) DEFAULT NULL");
            $tables[DATABASE_PREFIX."components"][] = array("name" => "internal_name", "params" => "varchar(255) DEFAULT NULL");
            $tables[DATABASE_PREFIX."components"][] = array("name" => "is_frontend", "params" => "int(11) NOT NULL DEFAULT '0'");
            $tables[DATABASE_PREFIX."components"][] = array("name" => "is_backend", "params" => "int(11) NOT NULL DEFAULT '0'");
            $tables[DATABASE_PREFIX."components"][] = array("name" => "is_locked", "params" => "int(11) NOT NULL DEFAULT '0'");
            $tables[DATABASE_PREFIX."components"][] = array("name" => "is_core", "params" => "int(11) NOT NULL DEFAULT '0'");
            $tables[DATABASE_PREFIX."components"][] = array("name" => "author_name", "params" => "varchar(500) DEFAULT NULL");
            $tables[DATABASE_PREFIX."components"][] = array("name" => "author_url", "params" => "varchar(2000) DEFAULT NULL");
            $tables[DATABASE_PREFIX."components"][] = array("name" => "version", "params" => "varchar(255) DEFAULT '1.0.0'");
            $tables[DATABASE_PREFIX."components"][] = array("name" => "params", "params" => "text");
            $tables[DATABASE_PREFIX."components"][] = array("name" => "enabled", "params" => "int(11) DEFAULT '1'");
            $tables[DATABASE_PREFIX."components"][] = array("name" => "ordering", "params" => "int(11) DEFAULT '0'");
            
            $tables[DATABASE_PREFIX."components_hooks"][] = array("name" => "id", "params" => "int(11) NOT NULL AUTO_INCREMENT");
            $tables[DATABASE_PREFIX."components_hooks"][] = array("name" => "title", "params" => "varchar(255) DEFAULT NULL");
            $tables[DATABASE_PREFIX."components_hooks"][] = array("name" => "description", "params" => "varchar(5000) DEFAULT NULL");
            $tables[DATABASE_PREFIX."components_hooks"][] = array("name" => "component_name", "params" => "varchar(255) DEFAULT NULL");
            $tables[DATABASE_PREFIX."components_hooks"][] = array("name" => "author_name", "params" => "varchar(500) DEFAULT NULL");
            $tables[DATABASE_PREFIX."components_hooks"][] = array("name" => "author_url", "params" => "varchar(2000) DEFAULT NULL");
            $tables[DATABASE_PREFIX."components_hooks"][] = array("name" => "version", "params" => "varchar(255) DEFAULT '1.0.0'");
            $tables[DATABASE_PREFIX."components_hooks"][] = array("name" => "enabled", "params" => "int(11) DEFAULT '1'");
            
            $tables[DATABASE_PREFIX."components_modules"][] = array("name" => "id", "params" => "int(11) NOT NULL AUTO_INCREMENT");
            $tables[DATABASE_PREFIX."components_modules"][] = array("name" => "title", "params" => "varchar(255) DEFAULT NULL");
            $tables[DATABASE_PREFIX."components_modules"][] = array("name" => "description", "params" => "varchar(5000) DEFAULT NULL");
            $tables[DATABASE_PREFIX."components_modules"][] = array("name" => "internal_name", "params" => "varchar(255) DEFAULT NULL");
            $tables[DATABASE_PREFIX."components_modules"][] = array("name" => "author_name", "params" => "varchar(500) DEFAULT NULL");
            $tables[DATABASE_PREFIX."components_modules"][] = array("name" => "author_url", "params" => "varchar(2000) DEFAULT NULL");
            $tables[DATABASE_PREFIX."components_modules"][] = array("name" => "version", "params" => "varchar(255) DEFAULT '1.0.0'");
            
            $tables[DATABASE_PREFIX."enquiries"][] = array("name" => "id", "params" => "int(11) NOT NULL AUTO_INCREMENT");
            $tables[DATABASE_PREFIX."enquiries"][] = array("name" => "name", "params" => "varchar(255) DEFAULT NULL");
            $tables[DATABASE_PREFIX."enquiries"][] = array("name" => "email", "params" => "varchar(255) DEFAULT NULL");
            $tables[DATABASE_PREFIX."enquiries"][] = array("name" => "content", "params" => "text");
            $tables[DATABASE_PREFIX."enquiries"][] = array("name" => "sent_time", "params" => "int(11) DEFAULT NULL");
            
            $tables[DATABASE_PREFIX."menus"][] = array("name" => "id", "params" => "int(11) NOT NULL AUTO_INCREMENT");
            $tables[DATABASE_PREFIX."menus"][] = array("name" => "title", "params" => "varchar(500)");
            
            $tables[DATABASE_PREFIX."menus_items"][] = array("name" => "id", "params" => "int(11) NOT NULL AUTO_INCREMENT");
            $tables[DATABASE_PREFIX."menus_items"][] = array("name" => "menu_id", "params" => "int(11) NOT NULL");
            $tables[DATABASE_PREFIX."menus_items"][] = array("name" => "parent_id", "params" => "int(11) NOT NULL DEFAULT '0'");
            $tables[DATABASE_PREFIX."menus_items"][] = array("name" => "title", "params" => "varchar(500) DEFAULT NULL");
            $tables[DATABASE_PREFIX."menus_items"][] = array("name" => "alias", "params" => "varchar(500) DEFAULT NULL");
            $tables[DATABASE_PREFIX."menus_items"][] = array("name" => "published", "params" => "int(11) DEFAULT NULL");
            $tables[DATABASE_PREFIX."menus_items"][] = array("name" => "access_group", "params" => "int(11) DEFAULT NULL");
            $tables[DATABASE_PREFIX."menus_items"][] = array("name" => "component", "params" => "varchar(255) DEFAULT NULL");
            $tables[DATABASE_PREFIX."menus_items"][] = array("name" => "controller", "params" => "varchar(255) DEFAULT NULL");
            $tables[DATABASE_PREFIX."menus_items"][] = array("name" => "content_id", "params" => "varchar(255) DEFAULT NULL");
            $tables[DATABASE_PREFIX."menus_items"][] = array("name" => "params", "params" => "text");
            $tables[DATABASE_PREFIX."menus_items"][] = array("name" => "is_home", "params" => "int(11) DEFAULT '0'");
            $tables[DATABASE_PREFIX."menus_items"][] = array("name" => "ordering", "params" => "varchar(255) DEFAULT '0'");
            
            $tables[DATABASE_PREFIX."modules"][] = array("name" => "id", "params" => "int(11) NOT NULL AUTO_INCREMENT");
            $tables[DATABASE_PREFIX."modules"][] = array("name" => "title", "params" => "varchar(255) DEFAULT NULL");
            $tables[DATABASE_PREFIX."modules"][] = array("name" => "type", "params" => "varchar(255) DEFAULT NULL");
            $tables[DATABASE_PREFIX."modules"][] = array("name" => "show_title", "params" => "int(11) DEFAULT NULL");
            $tables[DATABASE_PREFIX."modules"][] = array("name" => "published", "params" => "int(11) DEFAULT NULL");
            $tables[DATABASE_PREFIX."modules"][] = array("name" => "position", "params" => "varchar(255) DEFAULT NULL");
            $tables[DATABASE_PREFIX."modules"][] = array("name" => "params", "params" => "varchar(10000) DEFAULT NULL");
            $tables[DATABASE_PREFIX."modules"][] = array("name" => "pages", "params" => "varchar(255) DEFAULT '0'");
            $tables[DATABASE_PREFIX."modules"][] = array("name" => "ordering", "params" => "varchar(255) DEFAULT '0'");
            
            $tables[DATABASE_PREFIX."sessions"][] = array("name" => "id", "params" => "int(11) NOT NULL AUTO_INCREMENT");
            $tables[DATABASE_PREFIX."sessions"][] = array("name" => "php_session_id", "params" => "varchar(255) DEFAULT NULL");
            $tables[DATABASE_PREFIX."sessions"][] = array("name" => "user_id", "params" => "int(11) DEFAULT NULL");
            $tables[DATABASE_PREFIX."sessions"][] = array("name" => "last_action_time", "params" => "int(11) DEFAULT NULL");
            
            $tables[DATABASE_PREFIX."usergroups"][] = array("name" => "id", "params" => "int(11) NOT NULL AUTO_INCREMENT");
            $tables[DATABASE_PREFIX."usergroups"][] = array("name" => "title", "params" => "varchar(255) DEFAULT NULL");
            $tables[DATABASE_PREFIX."usergroups"][] = array("name" => "is_admin", "params" => "int(11) DEFAULT '0'");
            
            $tables[DATABASE_PREFIX."users"][] = array("name" => "id", "params" => "int(11) NOT NULL AUTO_INCREMENT");
            $tables[DATABASE_PREFIX."users"][] = array("name" => "username", "params" => "varchar(255) DEFAULT NULL");
            $tables[DATABASE_PREFIX."users"][] = array("name" => "email", "params" => "varchar(255) DEFAULT NULL");
            $tables[DATABASE_PREFIX."users"][] = array("name" => "usergroup_id", "params" => "int(11) DEFAULT NULL");
            $tables[DATABASE_PREFIX."users"][] = array("name" => "password", "params" => "varchar(255) DEFAULT NULL");
            $tables[DATABASE_PREFIX."users"][] = array("name" => "activated", "params" => "int(11) DEFAULT '0'");
            $tables[DATABASE_PREFIX."users"][] = array("name" => "blocked", "params" => "int(11) DEFAULT '0'");
            $tables[DATABASE_PREFIX."users"][] = array("name" => "blocked_reason", "params" => "varchar(500) DEFAULT NULL");
            $tables[DATABASE_PREFIX."users"][] = array("name" => "register_time", "params" => "int(11) DEFAULT NULL");
            $tables[DATABASE_PREFIX."users"][] = array("name" => "last_action_time", "params" => "int(11) DEFAULT NULL");
            $tables[DATABASE_PREFIX."users"][] = array("name" => "verify_token", "params" => "varchar(5000) DEFAULT NULL");
            $tables[DATABASE_PREFIX."users"][] = array("name" => "avatar", "params" => "varchar(255) DEFAULT NULL");
            $tables[DATABASE_PREFIX."users"][] = array("name" => "params", "params" => "text");
            
            $tables[DATABASE_PREFIX."users_recovery"][] = array("name" => "id", "params" => "int(11) NOT NULL AUTO_INCREMENT");
            $tables[DATABASE_PREFIX."users_recovery"][] = array("name" => "user_id", "params" => "int(11) DEFAULT NULL");
            $tables[DATABASE_PREFIX."users_recovery"][] = array("name" => "reset_requested", "params" => "int(11) DEFAULT NULL");
            $tables[DATABASE_PREFIX."users_recovery"][] = array("name" => "token", "params" => "varchar(5000) DEFAULT NULL");
            
            $this->optimal_schema = $tables;
        }
        
        public function prepare()
        {
            foreach ($this->schema as $record)
            {
                if (strpos($record->table_name, DATABASE_PREFIX) !== false)
                {
                    $this->current_tables[$record->table_name][] = $record->column_name;
                }
            }
            foreach ($this->optimal_schema as $key => $table)
            {
                foreach ($table as $record)
                {
                    $this->optimal_tables[$key][] = $record["name"];
                }
            }
            foreach ($this->current_tables as $key => $table)
            {
                foreach ($table as $column)
                {
                    if (!in_array($column, $this->optimal_tables[$key]))
                    {
                        $extra = new stdClass();
                        $extra->name = $column;
                        $extra->table = $key;
                        $this->extra[$key][] = $extra;
                        if (!in_array($key, $this->extra_tables))
                        {
                            $this->extra_tables[] = $key;
                        }
                    }
                }
            }
            foreach ($this->optimal_schema as $key => $table)
            {
                foreach ($table as $column)
                {
                    if (!in_array($column["name"], $this->current_tables[$key]))
                    {
                        $column["table"] = $key;
                        $this->missing[$key][] = (object) $column;
                        if (!in_array($key, $this->broken_tables))
                        {
                            $this->broken_tables[] = $key;
                        }
                    }
                }
            }
        }
        
        public function fix()
        {
            foreach ($this->missing as $table)
            {
                foreach ($table as $missing)
                {
                    $this->database->query("ALTER TABLE `". $missing->table ."` ADD `". $missing->name ."` ". $missing->params);
                }
            }
        }
        
        public function remove($table, $column)
        {
            $this->database->query("ALTER TABLE `". $table ."` DROP `". $column ."`");
        }
        
    }

?>