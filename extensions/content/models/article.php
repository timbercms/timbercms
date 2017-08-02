<?php

    #=======================================================================================
    # * Bulletin. CMS
    # --------------------------------------------------------------------------------------
    # * GNU General Public License (GPL) (https://opensource.org/licenses/GPL-3.0)
    # * https://www.github.com/Smith0r
    #=======================================================================================

?>
<?php

    class ArticleModel extends Model
    {
        public $table = "#__articles";
        public $database;
        
        public function __construct($database, $id = 0)
        {
            $this->database = $database;
            if ($id == 0)
            {
                $this->load($this->table, 1);
            }
        }
        
        public function load($table, $id)
        {
            $object = $this->database->loadObject("SELECT * FROM ". $table ." WHERE id = ?", array($id));
            foreach ($object as $key => $value)
            {
                $this->$key = $value;
            }
        }
    }

?>