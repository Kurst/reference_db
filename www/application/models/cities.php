<?php
class Cities_Model extends Model
{
	public $cities_table = 'cities';
	

	public function __construct($id = NULL)
	{
		// load database library into $this->db (can be omitted if not required)
		parent::__construct($id);
	}

        public function get_cities_like($q)
        {
            if ($this->db->table_exists($this->cities_table))
            {
                $sql = "SELECT id,name FROM `" .$this->cities_table. "` WHERE name LIKE '".$q."%' LIMIT 10";
                $query = $this->db->query($sql);
                if($query->count()>0)
                {
                    return $query;
                }else
                {
                    return false;
                }
		
            }
        }
}

?>
