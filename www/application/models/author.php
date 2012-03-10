<?php
class Author_Model extends Model
{
	public $table = 'author';
	public $table2 = "author_organization";
        public $user_table = "acl_users";
	
	public function __construct($id = NULL)
	{
		// load database library into $this->db (can be omitted if not required)
		parent::__construct($id);
	}
	////////////PROCEDURE BASED METHODS/////////////////

        //INSERT//
        public function insert_author($author)
        {
               if ($this->db->table_exists($this->table))
		{

			$sql = "CALL insertAuthor(
                                '" . $author['user_id'] . "',
                                '" . $author['family'] . "',
                                '" . $author['name'] . "',
                                '" . $author['patronymic'] . "',
                                '" . $author['date'] . "',
                                '" . $author['sex'] . "',
                                '" . $author['city_id']. "',
                                '" . $author['email'] . "',
                                '" . $author['phone'] . "',
                                '" . $author['site'] . "',
                                '" . $author['desc'] . "',
                                '" . $author['org_id'] . "'
                                )";
			try
                        {
                                return $this->db->query($sql);
                        }catch (Exception $e)
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

        public function insert_quick_author($username,$n)
        {


			$sql = "CALL insertQuickAuthor(
                                '" .$username. "',
                                '" . $n['family'] . "',
                                '" . $n['name'] . "',
                                '" . $n['patronymic'] . "',
                                '" . $n['date'] . "',
                                '" . $n['email'] . "',
                                '" . $n['sex'] . "'
                                )";
			try
                        {
                                $query = $this->db->query($sql);
                                $row = $query->result_array();;
                                return $row[0];
                        }catch (Exception $e)
                        {
                                
                                return 'failed';
                                
                        }


        }

       

        //UPDATE//
        public function update_author_by_id($author)
        {
            if ($this->db->table_exists($this->table))
		{
			$sql = "CALL updateAuthorById(
                                '".$author['id']."',
                                '".$author['family']."',
                                '".$author['name']."',
                                '".$author['patronymic']."',
                                '".$author['date']."',
                                '".$author['sex']."',
                                '".$author['city_id']."',
                                '".$author['email']."',
                                '".$author['site']."',
                                '".$author['desc']."',
                                '".$author['phone']."',
                                '".$author['org_id']."'
                                )";
			try
                        {
                                return $this->db->query($sql);
                        }catch (Exception $e)
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
        public function delete_author_by_id($id)
        {
            if ($this->db->table_exists($this->table))
            {

                    $sql = "CALL deleteAuthorById('".$id."')";
                    try
                        {
                                return $this->db->query($sql);
                        }catch (Exception $e)
                        {

                                return 'failed';

                        }
            }
        }

        //GET//
        public function get_author_name($username)
        {
            if ($this->db->table_exists($this->table))
		{

			$sql = "CALL getAuthorName('".$username."');";
			$query = $this->db->query($sql);
                        $row = $query->result_array();
                        return $row[0];
		}
        }

        public function get_all_authors()
        {
                if ($this->db->table_exists($this->table))
		{
			$sql = "CALL getAllAuthors();";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
        }

        public function get_authors_created_by($username)
        {
                if ($this->db->table_exists($this->table))
		{
			$sql = "CALL getAuthorsCreatedByUser('".$username."');";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
        }



        public function get_author_by_id($id)
        {
            if ($this->db->table_exists($this->table))
		{

			$sql = "CALL getAuthorById(".$id.");";
			$query = $this->db->query($sql);
                        $row = $query->result_array();
                        return $row[0];
		}
        }

        public function get_author_by_user_id($id)
        {
            if ($this->db->table_exists($this->table))
		{

			$sql = "CALL getAuthorByUserId(".$id.");";
			$query = $this->db->query($sql);
                        $row = $query->result_array();
                        return $row[0];
		}
        }

        public function get_coauthors_by_pub_id($id,$flag)
        {
            if ($this->db->table_exists($this->table))
		{

			$sql = "CALL getCoAuthorsByPubId(".$id.",".$flag.");";
			$query = $this->db->query($sql);
                        return $query->result_array();
                       
		}
        }
       

        public function get_all_authors_by_org($id)
        {
                if ($this->db->table_exists($this->table))
		{
			$sql = "CALL getAllAuthorsByOrg(".$id.");";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
        }

        public function check_duplicate_author($author)
        {
            if ($this->db->table_exists($this->table))
		{

			$sql = "CALL checkForDuplicateAuthor('".$author['name']."',
                        '".$author['family']."',
                        '".$author['patronymic']."',
                        '".$author['email']."'   
                        );";
			$query = $this->db->query($sql);
                        $row = $query->result_array();
                        return $row[0];
		}
        }


        ////////////GENERAL SQL METHODS//////////////
	public function add($author)
	{
		if ($this->db->table_exists($this->table))
		{
                   
			$sql = "INSERT INTO `" . $this->table . "` (`id`, `creator_id`, `family`, `name`, `patronymic`, `date_of_birth`, `sex`, `city_id`, `email`, `telephone`, `site`, `description`) VALUES (
					NULL,
                                        '" . $author['user_id'] . "',
					'" . $author['family'] . "',
					'" . $author['name'] . "',
					'" . $author['patronymic'] . "',
					'" . $author['date'] . "',
					'" . $author['sex'] . "',
					'" . $author['city_id']. "',
					'" . $author['email'] . "',
					'" . $author['phone'] . "',
					'" . $author['site'] . "',
					'" . $author['desc'] . "');";
	 
			if($query = $this->db->query($sql))
			{
				$auth_id = $query->insert_id();
				
				$sql = "INSERT INTO `".$this->table2."` (`id_author` ,`id_organization`) VALUES (
						'".$auth_id."',
						'".$author['org_id']."');";
						
				return $query = $this->db->query($sql);
				
			}else
			{
				return false;
			}
		}
	}

        
	
	public function edit($author)
	{
		if ($this->db->table_exists($this->table))
		{
			$sql = "UPDATE `" . $this->table . "` SET `family`='" . $author['family'] . "', `name`='" . $author['name'] . "', `patronymic`='" . $author['patronymic'] . "', `date_of_birth`='" . $author['date'] . "', `sex`='" . $author['sex'] . "', `town`='" . $author['town'] . "', `email`='" . $author['email'] . "', `telephone`='" . $author['phone'] . "', `site`='" . $author['site'] . "', `description`='" . $author['desc'] . "' WHERE `id`='". $author['id'] ."';";
			
			return $query = $this->db->query($sql);
	 
		}
	}
	
	
	public function delete_author($id)
	{
		if ($this->db->table_exists($this->table))
		{
			$sql = "DELETE FROM `".$this->table."` WHERE id=".$id;
			
			if($query = $this->db->query($sql))
			{
				$sql = "DELETE FROM `".$this->table2."` WHERE id_author=".$id;
						
				return $query = $this->db->query($sql);
				
			}else
			{
				return false;
			}
	 
		}
	}
	
	
	public function get_authors()
	{
		$sql = "SELECT * FROM `".$this->table."` ORDER BY id ASC";
		$query = $this->db->query($sql);
		return $query->result(FALSE, MYSQL_BOTH);
	}
	
	public function get_one_author($id)
	{
		$sql = "SELECT * FROM `".$this->table."` WHERE id=".$id;
		$query = $this->db->query($sql);
		$row = $query->result(FALSE, MYSQL_BOTH);
		return $row[0];
	}

        public function get_one_author_name($username)
	{
		$sql = "SELECT a.name, a.family, a.patronymic FROM `".$this->table."` a, `".$this->user_table."` u
                        WHERE a.id=u.author_id AND u.username = '".$username."'";
		$query = $this->db->query($sql);
		$row = $query->result(FALSE, MYSQL_BOTH);
		return $row[0];
	}

        
        
        public function author_exist($author)
        {
            if ($this->db->table_exists($this->table))
            {
                $sql = "SELECT * FROM `".$this->table."`
                        WHERE (`family` = '".$author['family']."'
                        AND `name` = '".$author['name']."'
                        AND `patronymic` = '".$author['patronymic']."'
                        AND `date_of_birth` = '".$author['date']."')
                        OR `email` = '".$author['email']."'";
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

        public function get_authors_like($q)
        {
            if ($this->db->table_exists($this->table))
            {
                $sql = "SELECT id,name,family,patronymic FROM `" .$this->table. "` WHERE family LIKE '".$q."%' LIMIT 10";
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