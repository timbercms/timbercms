<?php

	class Model
	{
		public function __construct()
		{
		}
        
        public function is_serial($string) {
            return (@unserialize($string) !== false || $string == 'b:0;');
        }
        
        public function load($id)
        {
            $rows = $this->database->loadObject("SELECT * FROM #__". $this->table ." WHERE id = ?", array($id));
            foreach ($rows as $key => $value)
            {
                if ($this->is_serial($value))
                {
                    $this->$key = unserialize($value);
                }
                else
                {
                    $this->$key = $value;
                }
            }
            if (method_exists($this, 'processData'))
            {
                $this->processData();
            }
        }
        
        public function store()
        {
            if (method_exists($this, 'preStoreData'))
            {
                $this->preStoreData();
            }
            $xml = simplexml_load_file(__DIR__ ."/../../admin/components/". $this->component_name ."/database.xml");
            $names = array();
            $values = array();
            $value_names = array();
            $title = "";
            foreach ($xml->tables->table as $table)
            {
                if ($table->name == $this->table)
                {
                    foreach ($table->columns->column as $column)
                    {
                        $name = $column->attributes()->name;
                        if ($name == "title")
                        {
                            $title = $this->$name;
                        }
                        else if ($name == "alias")
                        {
                            if (strlen($title) > 0 && strlen($this->$name) == 0)
                            {
                                $this->$name = Core::generateAlias($title, $table->name);   
                            }
                        }
                        if (is_array($this->$name))
                        {
                            $this->$name = serialize($this->$name);
                        }
                        if ($this->id > 0)
                        {
                            // Update Query
                            $names[] = "`". $name ."`=?";
                            $values[] = $this->$name;
                        }
                        else
                        {
                            // Insert Query
                            if ($name != "id")
                            {
                                $names[] = "`". $name ."`";
                                $value_names[] = ":".$name;
                                $values[":". $name] = $this->$name;
                            }
                        }
                    }
                }
            }
            if ($this->id > 0)
            {
                $query = "UPDATE `#__". $this->table ."` SET ". implode(", ", $names) ." WHERE id = '". $this->id ."'";
            }
            else
            {
                $query = "INSERT INTO `#__". $this->table ."` (". implode(", ", $names) .") VALUES (". implode(", ", $value_names) .")";
            }
            try
            {
                $this->database->query($query, $values);
                if ($this->id > 0)
                {
                    return $this->id;
                }
                {
                    return Core::db()->connection->lastInsertId();
                }
            }
            catch (PDOException $e)
            {
                echo "<pre>"; print_r($e->getMessage()); echo "</pre>"; die();
            }
        }
        
        //=============================================================
        // * Cheers to Zachstronaut for this one
        // * (https://gist.github.com/zachstronaut/1184831)
        //=============================================================
        function relativeTime($ptime)
        {
            $etime = time() - $ptime;

            if ($etime < 1) {
                return '0 seconds';
            }

            $a = array( 12 * 30 * 24 * 60 * 60  =>  'year',
                        30 * 24 * 60 * 60       =>  'month',
                        24 * 60 * 60            =>  'day',
                        60 * 60                 =>  'hour',
                        60                      =>  'min',
                        1                       =>  'sec'
                        );

            foreach ($a as $secs => $str) {
                $d = $etime / $secs;
                if ($d >= 1) {
                    $r = round($d);
                    return $r . ' ' . $str . ($r > 1 ? 's' : '');
                }
            }
        }
        
        public function setMessage($type = "primary", $message = "")
		{
			 $_SESSION["MESSAGES"][] = '<div class="system-message '. $type .'">'. $message .'</div>';
		}
        
        public function checkCaptcha()
        {
            if (isset($_POST['g-recaptcha-response']))
            {
                $captcha = $_POST['g-recaptcha-response'];
            }
            if (!$captcha)
            {
                return false;
            }
            else
            {
                $response = json_decode(file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=". Core::config()->recaptcha_secret ."&response=".$captcha."&remoteip=".$_SERVER['REMOTE_ADDR']), true);
                if ($response['success'] == false)
                {
                    // Spammer
                    return false;
                }
                else
                {
                    // Legitimate Enquiry
                    return true;
                }
            }
        }
	}

?>