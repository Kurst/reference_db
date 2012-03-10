<?php
class Aut_Org_Model extends Model
{
	public $table = 'author_organization';
	public $table2 = 'organization';
	public function __construct($id = NULL)
	{
		// load database library into $this->db (can be omitted if not required)
		parent::__construct($id);
	}
	
	
	
	public function get_author_org_by_id($id)
	{
		
		if ($this->db->table_exists($this->table))
		{
			
			$sql = "SELECT id, name FROM `".$this->table2."` WHERE id = (SELECT id_organization FROM `".$this->table."` WHERE id_author = ".$id.") ";
			$query = $this->db->query($sql);
			
			if($query->count() > 0)
			{
				return $query->result(FALSE, MYSQL_BOTH);
			}
			
		}
	}
}
?>