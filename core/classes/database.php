<?php

	class Database
	{
		
		public $connection;
        public $prefix;
		
		public function __construct($host = DATABASE_HOST, $name = DATABASE_NAME, $user = DATABASE_USER, $password = DATABASE_PASSWORD, $prefix = DATABASE_PREFIX)
		{
            $this->prefix = $prefix;
            if (defined("DATABASE_HOST") || strlen($host) > 0 && $host != "DATABASE_HOST")
            {
                $this->connect($host, $name, $user, $password);
            }
		}
		
		public function connect($host, $name, $user, $password)
		{
			try {
				$this->connection = new PDO("mysql:host=". $host .";dbname=". $name, $user, $password, array(PDO::ATTR_PERSISTENT => false));
                return true;
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
        
        public function close()
        {
            $this->connection = null;
        }
	}

?>