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
            
            $dirs = scandir(__DIR__ ."/../../");
            foreach ($dirs as $dir)
            {
                if (file_exists(__DIR__ ."/../../". $dir ."/database.xml"))
                {
                    $xml = simplexml_load_file(__DIR__ ."/../../". $dir ."/database.xml");
                    foreach ($xml->tables->table as $table)
                    {
                        foreach ($table->columns->column as $column)
                        {
                            $tables[DATABASE_PREFIX.$table->name][] = array("name" => $column->attributes()->name, "params" => $column->attributes()->params);
                        }
                    }
                }
            }
            
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