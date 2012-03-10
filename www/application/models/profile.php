<?php
class Profile_Model extends Model
{
        public $user_table = 'acl_users';
	public $author_table = 'author';
        public $city_table = 'cities';
	

	public function __construct($id = NULL)
	{
		// load database library into $this->db (can be omitted if not required)
		parent::__construct($id);
	}

        public function get_author_date($username)
        {
            if ($this->db->table_exists($this->author_table) && $this->db->table_exists($this->user_table) && $this->db->table_exists($this->author_table))
		{

			$sql = "CALL getAuthor('".$username."');";
			$query = $this->db->query($sql);
                        $row = $query->result_array();
                        return $row[0];
		}
        }

        public function get_user_id($username)
        {
            if ($this->db->table_exists($this->user_table))
		{

			$sql = "CALL getUserId('".$username."');";
			$query = $this->db->query($sql);
                        $row = $query->result_array();
                        return $row[0];
		}
        }

        public function get_author($username)
        {
                if ($this->db->table_exists($this->author_table) && $this->db->table_exists($this->user_table) && $this->db->table_exists($this->author_table))
                {
                        $sql = "SELECT a.*,c.name city,u.id user_id FROM `".$this->author_table."` a, `".$this->user_table."` u,`".$this->city_table."` c
                                WHERE a.id = u.author_id and u.username = '".$username."' and a.city_id = c.id";
                        $query = $this->db->query($sql);
                        $row = $query->result(FALSE, MYSQL_BOTH);
                       
                        return $row[0];
                }

                
        }
        
        public function edit_profile($username='',$field='',$prev='',$new='')
        {
                 if ($this->db->table_exists($this->author_table))
                 {
                         $sql = "UPDATE `".$this->author_table."` a, `".$this->user_table."` u SET a.`".$field."` = '".$new."'
                                 WHERE a.`id` = u.`author_id`
                                 AND u.`username` = '".$username."'";
                         return $query = $this->db->query($sql);
                 }
        }

        public function edit_profile_city($username,$id='',$prev = '')
        {
                 if ($this->db->table_exists($this->author_table))
                 {
                         $sql = "UPDATE `".$this->author_table."` a, `".$this->city_table."` c,`".$this->user_table."` u  SET a.`city_id` = '".$id."'
                                 WHERE a.`id` = u.`author_id`
                                 AND u.`username` = '".$username."'";
                         return $query = $this->db->query($sql);
                 }
        }




}

?>
