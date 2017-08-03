<?php

	class Model
	{
		public function __construct()
		{
			
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
	}

?>