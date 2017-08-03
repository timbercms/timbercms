<?php

	class Database
	{
		
		public $connection;
        public $prefix;
		
		public function __construct($host = DATABASE_HOST, $name = DATABASE_NAME, $user = DATABASE_USER, $password = DATABASE_PASSWORD, $prefix = DATABASE_PREFIX)
		{
            $this->prefix = $prefix;
			$this->connect($host, $name, $user, $password);
		}
		
		public function connect($host, $name, $user, $password)
		{
			try {
				$this->connection = new PDO("mysql:host=". $host .";dbname=". $name, $user, $password, array(PDO::ATTR_PERSISTENT => false));
			} catch (PDOException $e) {
				echo "<pre>"; print_r($e->getMessage()); echo "</pre>"; die();
			}
		}
		
		public function query($string, $data = array())
		{
			$string = str_replace("#__", $this->prefix, $string);
			$query = $this->connection->prepare($string);
			try 
			{
				if ($query->execute($data))
                {
                    return true;
                }
			} catch (PDOException $e) {
				echo "<pre>"; print_r($e->getMessage()); echo "</pre>"; die();
			}
		}
		
		public function loadObject($string, $arguments = array())
		{
            set_time_limit(60);
			$string = str_replace("#__", $this->prefix, $string);
			$query = $this->connection->prepare($string);
			$query->execute($arguments);
            set_time_limit(30);
			return $query->fetch(PDO::FETCH_OBJ);
		}
		
		public function loadObjectList($string, $arguments = array())
		{
			$string = str_replace("#__", $this->prefix, $string);
			$query = $this->connection->prepare($string);
			$query->execute($arguments);
            return $query->fetchAll(PDO::FETCH_OBJ);
		}
        
        public function lastInsertId()
        {
            return $this->connection->lastInsertId();
        }
        
        public function store($table, $data)
		{
			if ($data["0"]["value"] > 0)
			{
				$string = "UPDATE `". $table ."` SET ";
				$strings = array();
				$values = array();
				foreach ($data as $val)
				{
					$strings[] = "`". $val["name"] ."`=?";
					$values[] = $val["value"];
				}
				$strings = implode(", ", $strings);
				$string .= $strings;
				$string .= " WHERE id='". $data["0"]["value"] ."'";
				try
				{
					Core::db()->query($string, $values);
					return $data["0"]["value"];
				}
				catch (PDOException $e) {
					echo "<pre>"; print_r($e->getMessage()); echo "</pre>"; die();
				}
			}
			else
			{
				$string = "INSERT INTO `". $table ."` ";
				$strings = array();
				$values = array();
				$val_names = array();
				foreach ($data as $val)
				{
                    if ($val["name"] != "id")
                    {
                        $strings[] = "`". $val["name"] ."`";
                        $val_names[] = ":". $val["name"];
                        $values[":". $val["name"]] = $val["value"];
                    }
				}
				$strings = implode(", ", $strings);
				$val_names = implode(", ", $val_names);
				$string .= "(". $strings .")";
				$string .= " VALUES ";
				$string .= "(". $val_names .")";
				try
				{
					Core::db()->query($string, $values);
					return Core::db()->connection->lastInsertId();
				}
				catch (PDOException $e) {
					echo "<pre>"; print_r($e->getMessage()); echo "</pre>"; die();
				}
			}
        }
        
        public function close()
        {
            $this->connection = null;
        }
	}

?>