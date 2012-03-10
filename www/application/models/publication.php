<?php
class Publication_Model extends Model
{
	public $table = 'publication';
        public $pub_auth_table = 'author_publication';
        public $user_table = 'acl_users';
        public $author_table = 'author';
        public $lib_table = 'library_link_list';
        public $auth_pub_rights_table = 'author_publication_rights';
	

	
	public function __construct($id = NULL)
	{
		// load database library into $this->db (can be omitted if not required)
		parent::__construct($id);
	}

        ////////////PROCEDURE BASED METHODS/////////////////

        //INSERT//
        public function insert_publication($publication)
        {
                if(empty($publication['last_page']))
                {
                        $publication['last_page'] = 0;
                }

                if(empty($publication['magazine_number']))
                {
                        $publication['magazine_number'] = 0;
                }

               if ($this->db->table_exists($this->table))
		{

			$sql = "CALL insertPublication(
                                '" . $publication['user_id'] . "',
                                '" . $publication['type'] . "',
                                '" . $publication['title'] . "',
                                '" . $publication['issue'] . "',
                                '" . $publication['publisher'] . "',
                                '" . $publication['magazine_number'] . "',
                                '" . $publication['date'] . "',
                                '" . $publication['circulation'] . "',
                                '" . $publication['pages'] . "',
                                '" . $publication['last_page'] . "',
                                '" . $publication['path_to_file'] . "',
                                '" . $publication['desc'] . "',
                                '" . $publication['authors'] . "',
                                '" . $publication['rank'] . "',
                                '" . $publication['protection'] . "',
                                '" . $publication['statement'] . "',
                                '" . $publication['city_id'] . "',
                                '" . $publication['report_type'] . "',
                                '" . $publication['short_name'] . "',
                                '" . $publication['standart_number'] . "',
                                '" . $publication['org'] . "',
                                '" . $publication['org_flag'] . "'
                                )";
			try
                        {
                                $query = $this->db->query($sql);
                                $row = $query->result(FALSE, MYSQL_BOTH);
                                return $row[0];
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

        public function delegate_rights_to_author($id,$auth_id)
        {


               if ($this->db->table_exists($this->auth_pub_rights_table))
		{

			$sql = "CALL delegateRightsToAuthor(
                                '" .$id. "',
                                '" .$auth_id. "'
                                )";
			try
                        {
                                $query = $this->db->query($sql);
                                $row = $query->result(FALSE, MYSQL_BOTH);
                                return $row[0];
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

        public function remove_rights_from_author($id,$auth_id)
        {


               if ($this->db->table_exists($this->auth_pub_rights_table))
		{

			$sql = "CALL removeRightsFromAuthor(
                                '" .$id. "',
                                '" .$auth_id. "'
                                )";
			$query = $this->db->query($sql);
			return true;
                       

		}
        }


       

        //UPDATE//
        public function update_publication_by_id($pub)
        {
                if ($this->db->table_exists($this->table))
		{
			$sql = "CALL updatePublicationById('".$pub['id']."',
                                '".$pub['title']."',
                                '".$pub['type']."',
                                '".$pub['issue']."',
                                '".$pub['publisher']."',
                                '".$pub['date']."',
                                '".$pub['circulation']."',
                                '".$pub['pages']."',
                                '".$pub['last_page']."',
                                '".$pub['desc']."',
                                '".$pub['magazine_number']."',
                                '".$pub['files']."',
                                '".$pub['authors_string']."',
                                '" . $pub['rank'] . "',
                                '" . $pub['protection'] . "',
                                '" . $pub['statement'] . "',
                                '" . $pub['city_id'] . "',
                                '" . $pub['report_type'] . "',
                                '" . $pub['short_name'] . "',
                                '" . $pub['standart_number'] . "',
                                '" . $pub['org'] . "'
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


        public function update_publication_status($username,$id,$status)
        {
                if ($this->db->table_exists($this->table))
		{
			$sql = "CALL updatePublicationStatus('".$username."',
                                '".$id."',
                                '".$status."'
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
        public function delete_publication_by_id($id)
	{
		if ($this->db->table_exists($this->table))
		{

			$sql = "CALL deletePublicationById('".$id."')";
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

        public function delete_author_from_publication($id,$pub_id)
        {
                if ($this->db->table_exists($this->table))
		{
			$sql = "CALL deleteAuthorFromPublicationById('".$id."','".$pub_id."')";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
        }


        //GET//

         public function get_pub_amount_of_author_by_type($type,$username)
	{
		if ($this->db->table_exists($this->table))
		{

			$sql = "CALL getPubsAmountOfAuthorByType('".$type."','".$username."')";
			$query = $this->db->query($sql);
			$row =  $query->result_array();
                        return $row[0]->amount;
		}
	}
         public function get_pub_amount_by_author_by_type($type,$username)
	{
		if ($this->db->table_exists($this->table))
		{

			$sql = "CALL getPubsAmountByAuthorByType('".$type."','".$username."')";
			$query = $this->db->query($sql);
			$row =  $query->result_array();
                        return $row[0]->amount;
		}
	}

        public function get_my_publications($username)
	{
		if ($this->db->table_exists($this->table))
		{

			$sql = "CALL getAllPublicationsOfAuthor('".$username."')";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
	}

        public function get_publications_as_coauthor($username)
	{
		if ($this->db->table_exists($this->table))
		{

			$sql = "CALL getAllPublicationsAsCoauthor('".$username."')";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
	}

        public function get_publications_from_list($list)
	{
		if ($this->db->table_exists($this->table))
		{

			$sql = "CALL getPublicationFromList('".$list."')";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
	}
        
        
        public function get_publication_by_id($id)
        {
            if ($this->db->table_exists($this->table))
		{

			$sql = "CALL getPublicationById(".$id.");";
			$query = $this->db->query($sql);
                        return $query->result_array();
		}
        }

        public function get_publications_created_by($username)
	{
		if ($this->db->table_exists($this->table))
		{

			$sql = "CALL getPublicationsCreatedByAuthor('".$username."')";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
	}

        public function get_publications_deligated_to($username)
	{
		if ($this->db->table_exists($this->table))
		{

			$sql = "CALL getPublicationsDeligatedToAuthor('".$username."')";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
	}

        public function get_publications_of_author_by_id($id)
	{
		if ($this->db->table_exists($this->table))
		{

			$sql = "CALL getAllPublicationsOfAuthorById('".$id."')";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
	}

        public function get_publications_of_publisher_by_id($id)
	{
		if ($this->db->table_exists($this->table))
		{

			$sql = "CALL getAllPublicationsOfPublisher('".$id."')";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
	}

        public function get_new_publications_amount($username)
	{
		if ($this->db->table_exists($this->table))
		{

			$sql = "CALL getNewPublicationsAmount('".$username."')";
			$query = $this->db->query($sql);
			$row =  $query->result_array();
                        return $row[0]->amount;
		}
	}

        ////////////GENERAL SQL METHODS//////////////
	
	public function add($publication)
	{
                
                if(empty($publication['last_page']))
                {
                        $publication['last_page'] = 0;
                }

                if(empty($publication['magazine_number']))
                {
                        $publication['magazine_number'] = 0;
                }
		if ($this->db->table_exists($this->table))
		{
                    
			$sql = "INSERT INTO `" . $this->table . "` (`id`, `creator_id`, `type`, `title`, `id_issue`,`id_publisher`, `magazine_number`, `date`, `circulation`, `pages`, `last_page`,`path_to_file`, `description`) VALUES (
					NULL,
                                        '" . $publication['user_id'] . "',
					'" . $publication['type'] . "',
					'" . $publication['title'] . "',
					'" . $publication['issue'] . "',
                                        '" . $publication['publisher'] . "',
                                        '" . $publication['magazine_number'] . "',
					'" . $publication['date'] . "',
					'" . $publication['circulation'] . "',
					'" . $publication['pages'] . "',
                                        '" . $publication['last_page'] . "',
                                        '" . $publication['path_to_file'] . "',
					'" . $publication['desc'] . "');";
					
			if($query = $this->db->query($sql))
                        {
                                $pub_id = $query->insert_id();
                                $table = "author_publication";
                                foreach($publication['author'] as $auth_id)
                                {
                                        $sql = "INSERT INTO `".$table."` (`id_publication` ,`id_author`) VALUES (
                                              '".$pub_id."',
                                              '".$auth_id."');";
                                    $query = $this->db->query($sql);
                                }


                                return $pub_id;

                        }else
                        {
                                return false;
                        }
		}
	}

        

	
	public function get_all_publications()
	{
		if ($this->db->table_exists($this->table))
		{
			$sql = "SELECT * FROM `".$this->table."` ORDER BY id ASC";
			$query = $this->db->query($sql);
			return $query->result(FALSE, MYSQL_BOTH);
		}
	}

        public  function get_authors_of_publication($id)
        {
                if ($this->db->table_exists($this->pub_auth_table))
                {
                        $sql = "SELECT id_author FROM `".$this->pub_auth_table."`  WHERE id_publication = '".$id."' ORDER BY id_author ASC";
                        $query = $this->db->query($sql);
			return $query->result(FALSE, MYSQL_BOTH);
                }

        }

        public function get_publications_of_author($id)
        {
                if ($this->db->table_exists($this->pub_auth_table))
		{
			$sql = "SELECT * FROM `".$this->table."` WHERE id IN (SELECT id_publication FROM `".$this->pub_auth_table."` WHERE id_author = ".$id.")";
			$query = $this->db->query($sql);
			return $query->result(FALSE, MYSQL_BOTH);
		}
        }

        


         public function get_one_publication($id)
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