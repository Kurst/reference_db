<?php
class Issue_type_Model extends Model
{
	
	public $table = 'issue_type';

	public function __construct($id = NULL)
	{
		// load database library into $this->db (can be omitted if not required)
		parent::__construct($id);
	}
	////////////PROCEDURE BASED METHODS/////////////////

        //GET//
	public function get_all_types()
        {
            $sql = "CALL getAllIssueTypes();";
            $query = $this->db->query($sql);

            return $query->result_array();

        }

        ////////////GENERAL SQL METHODS//////////////
	public function get_types()
	{
		if ($this->db->table_exists($this->table))
		{
			$sql = "SELECT id,name FROM `".$this->table."` ORDER BY name ASC";
			$query = $this->db->query($sql);
			return $query->result(FALSE, MYSQL_BOTH);
		}
	}

        
}
?>