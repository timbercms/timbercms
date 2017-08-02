<?php

    #=======================================================================================
    # * Bulletin. CMS
    # --------------------------------------------------------------------------------------
    # * GNU General Public License (GPL) (https://opensource.org/licenses/GPL-3.0)
    # * https://www.github.com/Smith0r
    #=======================================================================================

?>
<?php

    class Database
    {
        public $connection;
        public $configuration;
        
        public function __construct($configuration)
        {
            $this->configuration = $configuration;
            $options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ, PDO::ATTR_EMULATE_PREPARES => FALSE];
            $this->connection = new PDO("mysql:host=". $this->configuration->database_host .";dbname=". $this->configuration->database_name .";charset=utf8;", $this->configuration->database_user, $this->configuration->database_password, $options);
        }
        
        public function query($string, $data = array())
		{
			$string = str_replace("#__", $this->configuration->database_prefix, $string);
			$query = $this->connection->prepare($string);
			try 
			{
				if ($query->execute($data))
                {
                    $query = null;
                    return true;
                }
			}
            catch (PDOException $e)
            {
				echo "<pre>"; print_r($e->getMessage()); echo "</pre>"; die();
			}
		}
		
		public function loadObject($string, $arguments = array())
		{
			$string = str_replace("#__", $this->configuration->database_prefix, $string);
			$query = $this->connection->prepare($string);
			$query->execute($arguments);
            $result = (object) $query->fetch(PDO::FETCH_OBJ);
            $query = null;
			return $result;
		}
		
		public function loadObjectList($string, $arguments = array())
		{
			$string = str_replace("#__", $this->configuration->database_prefix, $string);
			$query = $this->connection->prepare($string);
			$query->execute($arguments);
            $result = $query->fetchAll(PDO::FETCH_OBJ);
            $query = null;
            return $result;
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