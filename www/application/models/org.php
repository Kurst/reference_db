<?php
class Org_Model extends Model
{
	public $table = 'organization';
	public function __construct($id = NULL)
	{
		// load database library into $this->db (can be omitted if not required)
		parent::__construct($id);
	}

        ////////////PROCEDURE BASED METHODS/////////////////

        //INSERT//
        public function insert_org($org)
        {
               if ($this->db->table_exists($this->table))
		{

			$sql = "CALL insertOrg(
                                '".$org['parent']."',
                                '".$org['user_id']."',
				'".$org['name']."',
				'".$org['type']."',
				'".$org['site']."',
				'".$org['email']."',
				'".$org['phone']."',
				'".$org['desc']."'
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

         public function insert_quick_org($username,$n)
        {
                        

			$sql = "CALL insertQuickOrg(
                                '" .$username. "',
                                '" . $n['name'] . "',
                                '" . $n['type'] . "',
                                '" . $n['parent'] . "'
                                )";
			try
                        {
                                return $this->db->query($sql);

                        }catch (Exception $e)
                        {

                                return 'failed';

                        }


        }

        //UPDATE//
        public function update_org_by_id($org)
        {
            if ($this->db->table_exists($this->table))
		{
			$sql = "CALL updateOrgById(
                                '".$org['id']."',
                                '".$org['id_parent']."',
                                '".$org['name']."',
                                '".$org['type']."',
                                '".$org['site']."',
                                '".$org['email']."',
                                '".$org['phone']."',
                                '".$org['desc']."'
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
        public function delete_org_by_id($id)
        {
            if ($this->db->table_exists($this->table))
            {

                    $sql = "CALL deleteOrgById('".$id."')";
  
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
        public function get_orgs_by_parent_id($id)
	{
		if ($this->db->table_exists($this->table))
		{
			$sql = "CALL getOrgsByParentId('".$id."')";
			$query = $this->db->query($sql);
			return $query->result_array();

		}
	}

         public function get_orgs_breadcrumbs($id)
	{
		if ($this->db->table_exists($this->table))
		{
			$sql = "CALL getOrgsBreadcrumbs('".$id."')";
			$query = $this->db->query($sql);
			$row = $query->result_array();
                        return $row[0];

		}
	}

        public function get_my_orgs()
	{
		if ($this->db->table_exists($this->table))
		{
			$sql = "CALL getAllOrgs()";
			$query = $this->db->query($sql);
			return $query->result_array();


		}
	}

        public function get_orgs_created_by($username)
	{
		if ($this->db->table_exists($this->table))
		{

			$sql = "CALL getOrgsCreatedByUser('".$username."')";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
	}

        public function get_org_by_id($id)
	{
		if ($this->db->table_exists($this->table))
		{

			$sql = "CALL getOrgById('".$id."')";
			$query = $this->db->query($sql);
			$row = $query->result_array();
                        return $row[0];
		}
	}


        public function check_duplicate_org($org)
        {
            if ($this->db->table_exists($this->table))
		{

			$sql = "CALL checkForDuplicateOrg('".$org['name']."');";
			$query = $this->db->query($sql);
                        $row = $query->result_array();
                        return $row[0];
		}
        }







        ////////////GENERAL SQL METHODS//////////////
	public function add($org)
	{
		if ($this->db->table_exists($this->table))
		{
			$sql = "INSERT INTO `" . $this->table . "` (`id`, `id_parent`,`creator_id`, `name`, `type`, `site`, `email`, `telephone`, `description`) VALUES (
				NULL,
				'".$org['parent']."',
                                '".$org['user_id']."',
				'".$org['name']."',
				'".$org['type']."',
				'".$org['site']."',
				'".$org['email']."',
				'".$org['phone']."',
				'".$org['desc']."');";
				
			return $query = $this->db->query($sql);
		}
	}

      
	
	public function get_orgs()
	{
		if ($this->db->table_exists($this->table))
		{
			$sql = "SELECT id,name FROM `".$this->table."` ORDER BY name ASC";
			$query = $this->db->query($sql);
			return $query->result(FALSE, MYSQL_BOTH);
		}
	}
	
	/*public function get_orgs_by_parent_id($id)                    TO DELETE
	{
		if ($this->db->table_exists($this->table))
		{
			$sql = "SELECT id,name FROM `".$this->table."` WHERE id_parent = ".$id."  ORDER BY name ASC";
			$query = $this->db->query($sql);
			if($query->count() > 0)
			{
				return $query->result(FALSE, MYSQL_BOTH);
			}
			
		}
	}*/

        
	public function get_parent_for_edit($id)
	{
		if ($this->db->table_exists($this->table))
		{
			$sql = "SELECT id,name FROM `".$this->table."` WHERE id = (SELECT id_parent FROM `".$this->table."` 
			WHERE id= ".$id.")  ORDER BY name ASC";
			$query = $this->db->query($sql);
			if($query->count() > 0)
			{
				return $query->result(FALSE, MYSQL_BOTH);
			}
			
		}
	}
	
	
	public function delete_organisation($id)
	{
		$a = array();
		array_push($a, $id);
		if ($this->db->table_exists($this->table))
		{
			$sql = "DELETE FROM `".$this->table."` WHERE id=".$id;
			
		}
	}
	
	
	public function get_all_orgs()
	{
		if ($this->db->table_exists($this->table))
		{
			$sql = "SELECT * FROM `".$this->table."` ORDER BY name ASC";
			$query = $this->db->query($sql);
			return $query->result(FALSE, MYSQL_BOTH);
		}
	}
	
	public function get_one_organization($id)
	{
		$sql = "SELECT * FROM `".$this->table."` WHERE id=".$id;
		$query = $this->db->query($sql);
		$row = $query->result(FALSE, MYSQL_BOTH);
		return $row[0];
	}
	
	public function edit($organization)
	{
		if ($this->db->table_exists($this->table))
		{
			$sql = "UPDATE `" . $this->table . "` SET `type`='" . $organization['type'] . "', `name`='" . $organization['name'] . "',
			`id_parent`='" . $organization['id_parent'] . "', `email`='" . $organization['email'] . "',
			`telephone`='" . $organization['phone'] . "', `site`='" . $organization['site'] . "',
			`description`='" . $organization['desc'] . "' WHERE `id`='". $organization['id'] ."';";
			
			return $query = $this->db->query($sql);
	 
		}
	}

        public function org_exist($org)
        {
            if ($this->db->table_exists($this->table))
            {
                $sql = "SELECT * FROM `".$this->table."`
                        WHERE `name` = '".$org['name']."'
                        AND `type` = '".$org['type']."'
                        AND  `id_parent` = '0'";
                
                $query = $this->db->query($sql);
               
                if($query->count() > 0)
                {
                        return true;
                }else
                {
                        return false;
                }
            }

        }

       

        
        
	
		
}
?>