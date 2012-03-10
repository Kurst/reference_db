<?php
class Publication_type_Model extends Model
{
	
	public $table = 'publication_type';

	public function __construct($id = NULL)
	{
		// load database library into $this->db (can be omitted if not required)
		parent::__construct($id);
	}

        ////////////PROCEDURE BASED METHODS/////////////////

        //GET//
        public function get_all_types()
        {
            $sql = "CALL getAllPublicationTypes();";
            $query = $this->db->query($sql);

            return $query->result_array();

        }

        ////////////GENERAL SQL METHODS//////////////
	public function get_types()
	{
		if ($this->db->table_exists($this->table))
		{
			$sql = "SELECT id,name FROM `".$this->table."` ORDER BY id ASC";
			$query = $this->db->query($sql);
			return $query->result(FALSE, MYSQL_BOTH);
		}
	}

        public function get_type_by_id($id)
	{
		if ($this->db->table_exists($this->table))
		{
			$sql = "SELECT * FROM `".$this->table."` WHERE id = '".$id."'";
			$query = $this->db->query($sql);
                        $row = $query->result(FALSE, MYSQL_BOTH);
                        return $row[0];
		}
	}

        
}
?>