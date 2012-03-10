<?php
class Issue_Model extends Model
{
	public $table = 'issue';
	
	public function __construct($id = NULL)
	{
		// load database library into $this->db (can be omitted if not required)
		parent::__construct($id);
	}

        ////////////PROCEDURE BASED METHODS/////////////////

        //INSERT//
        public function insert_issue($issue)
        {
               if ($this->db->table_exists($this->table))
		{

			$sql = "CALL insertIssue(
                                '" . $issue['id_publisher'] . "',
                                '" . $issue['user_id'] . "',
                                '" . $issue['name'] . "',
                                '" . $issue['type'] . "',
                                '" . $issue['date'] . "',
                                '" . $issue['isbn'] . "',
                                '" . $issue['issn'] . "',
                                '" . $issue['desc'] . "'
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
        public function update_issue_by_id($issue)
        {
            if ($this->db->table_exists($this->table))
		{
			$sql = "CALL updateIssueById(
                                '".$issue['id']."',
                                '".$issue['id_publisher']."',
                                '".$issue['name']."',
                                '".$issue['type']."',
                                '".$issue['date']."',
                                '".$issue['isbn']."',
                                '".$issue['issn']."',
                                '".$issue['desc']."'
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
        public function delete_issue_by_id($id)
        {
            if ($this->db->table_exists($this->table))
            {

                    $sql = "CALL deleteIssueById('".$id."')";

                    try
                        {
                                 return $this->db->query($sql);
                        }catch(Exeption $e)
                        {

                                 return 'failed';

                        }
            }
        }


        //GET//
        public function get_issues()
	{
		if ($this->db->table_exists($this->table))
		{
			$sql = "CALL getAllIssues();";
			$query = $this->db->query($sql);
                        return $query->result_array();
		}
	}

        public function get_issue($id)
	{
		if ($this->db->table_exists($this->table))
		{
			$sql = "CALL getIssueById(".$id.");";
			$query = $this->db->query($sql);
                        $res = $query->result_array();
                        if(!empty($res))
                        {       
                                return $query->result_array();
                        }else
                        {
                                $r[0] = array('name' => '', 'publisher_name' => '','date' => '');
                                $r[0] = (object)$r[0]; 
                                return $r;
                        }
                        
		}
	}

        public function get_issues_created_by($username)
        {
                if ($this->db->table_exists($this->table))
		{
			$sql = "CALL getIssuesCreatedByUser('".$username."');";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
        }


        ////////////GENERAL SQL METHODS//////////////
	public function add($issue)
	{
		if ($this->db->table_exists($this->table))
		{
			$sql = "INSERT INTO `" . $this->table . "` (`id`, `id_publisher`, `creator_id`, `name`, `type`, `date`, `isbn`, `issn`,  `description`) VALUES (
					NULL,
                                        '" . $issue['id_publisher'] . "',
                                        '" . $issue['user_id'] . "',
					'" . $issue['name'] . "',
					'" . $issue['type'] . "',
					'" . $issue['date'] . "',
					'" . $issue['isbn'] . "',
					'" . $issue['issn'] . "',
					'" . $issue['desc'] . "');";
					
			return $query = $this->db->query($sql);
        }
	}

        


	public function delete_issue($id)
	{
		if ($this->db->table_exists($this->table))
		{
			$sql = "DELETE FROM `".$this->table."` WHERE id=".$id;
			return $query = $this->db->query($sql);
		}
	}
	
	
        public function get_all_issues()
	{
		$sql = "SELECT * FROM `".$this->table."` ORDER BY id ASC";
		$query = $this->db->query($sql);
		return $query->result(FALSE, MYSQL_BOTH);
	}
	
        public function get_one_issue($id)
        {
            $sql = "SELECT * FROM `".$this->table."` WHERE id=".$id;
            $query = $this->db->query($sql);
            $row = $query->result(FALSE, MYSQL_BOTH);
            
            return $row[0];
            
        }
    
 	public function edit($issue)
	{
		if ($this->db->table_exists($this->table))
		{
			$sql = "UPDATE `" . $this->table . "` SET `name`='" . $issue['name'] . "', `type`='" . $issue['type'] . "', `date`='" . $issue['date'] . "', `id_publisher`='" . $issue['id_publisher'] . "', `isbn`='" . $issue['isbn'] . "', `issn`='" . $issue['issn'] . "', `description`='" . $issue['desc'] . "' WHERE `id`='". $issue['id'] ."';";
			
			return $query = $this->db->query($sql);
	 
		}
	}
       

        

        



}
?>