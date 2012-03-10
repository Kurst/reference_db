<?php
class Publisher_Model extends Model
{
	public $table = 'publisher';
	
	
	public function __construct($id = NULL)
	{
		// load database library into $this->db (can be omitted if not required)
		parent::__construct($id);
	}

        ////////////PROCEDURE BASED METHODS/////////////////

        //INSERT//
        public function insert_publisher($publisher)
        {
               if ($this->db->table_exists($this->table))
		{

			$sql = "CALL insertPublisher(
                                '" . $publisher['user_id'] . "',
                                '" . $publisher['name'] . "',
                                '" . $publisher['city_id'] . "',
                                '" . $publisher['site'] . "',
                                '" . $publisher['phone'] . "',
                                '" . $publisher['desc'] . "'
                                )";
			
                        try
                        {
                                 return $this->db->query($sql);
                        }catch(Exeption $e)
                        {
                                if(substr($e,18,9) == 'Duplicate')
                                {
                                        return 'duplicate';
                                }else
                                {
                                        return 'failed';
                                }
                        }


		}
        }

        //UPDATE//
        public function update_publisher_by_id($publisher)
        {
            if ($this->db->table_exists($this->table))
		{
			$sql = "CALL updatePublisherById(
                                '".$publisher['id']."',
                                '".$publisher['name']."',
                                '".$publisher['city_id']."',
                                '".$publisher['site']."',
                                '".$publisher['telephone']."',
                                '".$publisher['desc']."'
                                )";
                        try
                        {
                                 return $this->db->query($sql);
                        }catch(Exeption $e)
                        {
                                if(substr($e,18,9) == 'Duplicate')
                                {
                                        return 'duplicate';
                                }else
                                {
                                        return 'failed';
                                }
                        }
		}
        }

        //DELETE//
        public function delete_publisher_by_id($id)
        {
            if ($this->db->table_exists($this->table))
            {

                    $sql = "CALL deletePublisherById('".$id."')";
                    try
                        {
                                 return $this->db->query($sql);
                        }catch(Exeption $e)
                        {
                                if(substr($e,18,9) == 'Duplicate')
                                {
                                        return 'duplicate';
                                }else
                                {
                                        return 'failed';
                                }
                        }
            }
        }

        //GET//
        public function get_publishers()
	{
		if ($this->db->table_exists($this->table))
		{
			$sql = "CALL getAllPublishers();";
			$query = $this->db->query($sql);
                        return $query->result_array();
		}
	}

        public function get_publisher_by_id($id)
        {
            if ($this->db->table_exists($this->table))
		{

			$sql = "CALL getPublisherById(".$id.");";
			$query = $this->db->query($sql);
                        $row = $query->result_array();
                        return $row[0];
		}
        }

        public function get_publishers_created_by($username)
        {
                if ($this->db->table_exists($this->table))
		{
			$sql = "CALL getPublishersCreatedByUser('".$username."');";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
        }


        ////////////GENERAL SQL METHODS//////////////



	public function add($publisher)
	{
		if ($this->db->table_exists($this->table))
		{
			$sql = "INSERT INTO `" . $this->table . "` (`id`, `creator_id`, `name`, `city_id`, `site`, `telephone`, `description`) VALUES (
					NULL,
                                        '" . $publisher['user_id'] . "',
					'" . $publisher['name'] . "',
                                        '" . $publisher['city_id'] . "',
					'" . $publisher['site'] . "',
					'" . $publisher['phone'] . "',
					'" . $publisher['desc'] . "');";
					
			return $query = $this->db->query($sql);
        }
	}

        
	
	public function delete_publisher($id)
	{
		if ($this->db->table_exists($this->table))
		{
			$sql = "DELETE FROM `".$this->table."` WHERE id=".$id;
			return $query = $this->db->query($sql);
		}
	}
	
	public function get_all_publishers()
	{
		if ($this->db->table_exists($this->table))
		{
			$sql = "SELECT * FROM `".$this->table."` ORDER BY name ASC";
			$query = $this->db->query($sql);
			return $query->result(FALSE, MYSQL_BOTH);
		}
	}
	
	public function get_one_publisher($id)
	{
		$sql = "SELECT * FROM `".$this->table."` WHERE id=".$id;
		$query = $this->db->query($sql);
		$row = $query->result(FALSE, MYSQL_BOTH);
		return $row[0];
	}
		
	public function edit($publisher)
	{
		
		if ($this->db->table_exists($this->table))
		{
			$sql = "UPDATE `" . $this->table . "` SET `name`='" . $publisher['name'] . "',
			`telephone`='" . $publisher['telephone'] . "', `site`='" . $publisher['site'] . "',
			`description`='" . $publisher['desc'] . "' WHERE `id`='". $publisher['id'] ."';";
			
			return $query = $this->db->query($sql);
	 
		}
	}

        

       

        

	

}
?>