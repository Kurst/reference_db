<?php defined('SYSPATH') OR die('No direct access allowed.');

class Search_Model extends Model
{
	
	public $author_table    = 'author';
        public $org_table       = 'organization';
	public $publisher_table       = 'publisher';

	public function __construct($id = NULL)
	{
		// load database library into $this->db (can be omitted if not required)
		parent::__construct($id);
                
	}
	
	public function get_result_by_author($query)
	{
		if ($this->db->table_exists($this->author_table))
		{
			$sql = "CALL searchByAuthor('".$query."');";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
	}

        public function get_result_by_org($query)
	{
		if ($this->db->table_exists($this->org_table))
		{
			$sql = "CALL searchByOrg('".$query."');";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
	}

        public function get_result_by_publisher($query)
	{
		if ($this->db->table_exists($this->publisher_table))
		{
			$sql = "CALL searchByPublisher('".$query."');";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
	}

        public function get_result_by_name($query)
	{
		if ($this->db->table_exists($this->publisher_table))
		{
			$sql = "CALL searchByName('".$query."');";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
	}

        


	
	
}