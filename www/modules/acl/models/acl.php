<?php defined('SYSPATH') OR die('No direct access allowed.');

class Acl_Model extends Model
{
	
	public $users_table    = 'acl_users';
        public $group_table    = 'acl_user_groups';
        public $role_table     = 'acl_roles';
        public $grp_role_table = 'acl_group_roles';
        public $author_table   = 'author';
        public $report_head_table   = 'set_report_head';
        public $settings_table   = 'settings';
	
	public function __construct($id = NULL)
	{
		// load database library into $this->db (can be omitted if not required)
		parent::__construct($id);
	}
	
	public function get_access_permission($username,$pub,$table)
        {
                if ($this->db->table_exists($this->users_table) && $this->db->table_exists($this->group_table))
		{

			$sql = "CALL securityCheck('".$username."','".$pub."','".$table."')";
			$query = $this->db->query($sql);
			$row =  $query->result_array();
                        return $row[0]->permission;
		}
        }
        
        public function get_user($username = '')
	{
		if ($this->db->table_exists($this->users_table))
		{
			$sql = "SELECT * FROM `".$this->users_table."` WHERE username='".$username."'";
			$query = $this->db->query($sql);
			if($query->count()==1)
			{
				return $query[0];
			}else
			{
				return false;
			}
			
		}
	}

        public function get_role($username)
        {
                if ($this->db->table_exists($this->users_table) && $this->db->table_exists($this->group_table))
                {
                        $sql = "SELECT  gr.name FROM `".$this->group_table."` gr, `".$this->users_table."` u
                                WHERE u.username='".$username."' and u.group_id = gr.id";
                        $query = $this->db->query($sql);
                        if($query->count()==1)
                        {
                                return $query[0];
                        }else
                        {
                                return false;
                        }

                }
            
        }

        public function get_user_by_id($id = '')
	{
		if ($this->db->table_exists($this->users_table))
		{
			$sql = "SELECT * FROM `".$this->users_table."` WHERE id='".$id."'";
			$query = $this->db->query($sql);
			if($query->count()==1)
			{
				return $query[0];
			}else
			{
				return false;
			}

		}
	}
	
	public function add_user($profile)
	{
		if ($this->db->table_exists($this->users_table))
		{
			$sql = "INSERT INTO `".$this->users_table."` (`id` ,`username` ,`password` ,`hash`,`group_id`,`active`)
					VALUES (
					NULL ,
					'".$profile['username']."',
					'".$profile['password']."',
					'".$profile['hash']."',
                                        '2',
                                        '0'
					);";
			$query = $this->db->query($sql);
                        
                        return $query->insert_id();
                           
                        
                       
				
		}
	}

        public function add_hash_to_user($id,$hash)
	{
		if ($this->db->table_exists($this->users_table))
		{
			$sql = "UPDATE `".$this->users_table."` SET `hash` =  '".$hash."' WHERE `id` =".$id.";";
			return $query = $this->db->query($sql);




		}
	}

        public function update_user_pswd($id,$new_pswd)
	{
		if ($this->db->table_exists($this->users_table))
		{
			$sql = "UPDATE `".$this->users_table."` SET `hash` =  '',`password` = '".$new_pswd."'  WHERE `id` =".$id.";";
			return $query = $this->db->query($sql);




		}
	}

        public function activate_user($id)
        {
                if ($this->db->table_exists($this->users_table))
		{
			$sql = "UPDATE `".$this->users_table."` SET `active` =  '1' WHERE `id` =".$id.";";
			return $query = $this->db->query($sql);




		}
        }

        public function user_exist($username)
        {
                if ($this->db->table_exists($this->users_table))
		{
			$sql = "SELECT * FROM `".$this->users_table."` WHERE username = '".$username."'";
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
	
	public function insert_hash($id,$hash)
	{
		if ($this->db->table_exists($this->users_table))
		{
			$sql = "UPDATE `".$this->users_table."` SET `hash` =  '".$hash."' WHERE `id` =".$id.";";
			return $query = $this->db->query($sql);
				
		}
	}

        public function insert_author_id($id,$author_id)
	{
		if ($this->db->table_exists($this->users_table))
		{
			$sql = "UPDATE `".$this->users_table."` SET `author_id` =  '".$author_id."' WHERE `id` =".$id.";";
			return $query = $this->db->query($sql);

		}
	}


        public function delete_hash($id)
        {
            if ($this->db->table_exists($this->users_table))
		{
			$sql = "UPDATE `".$this->users_table."` SET `hash` =  '' WHERE `id` =".$id.";";
			return $query = $this->db->query($sql);
		}
        }

        public function get_group_id($group)
        {
                if ($this->db->table_exists($this->group_table))
		{
                        $sql = "SELECT * FROM `".$this->group_table."` WHERE name='".$group."'";
                        $query = $this->db->query($sql);
                        $row = $query->result(FALSE, MYSQL_BOTH);
                        return $row[0]['id'];

                }
        }

        public function get_role_id($path)
        {
                if ($this->db->table_exists($this->role_table))
		{
                         $sql = "SELECT id FROM `".$this->role_table."` WHERE path='".$path."'";
                         $query = $this->db->query($sql);
                         if($query->count()==1)
                         {
                                 $row = $query->result(FALSE, MYSQL_BOTH);
                                 return $row[0]['id'];
                         }else
                         {
                                 return false;
                         }
                      
                }
        }
        
        public function get_allow_flag($username,$path)
        {
                if ($this->db->table_exists($this->grp_role_table))
		{
                        /*$sql = "SELECT allow_flag FROM `".$this->grp_role_table."`
                                WHERE group_id =".$group_id." AND role_id =".$role_id."";*/

                        $sql = "SELECT gr_rl.allow_flag FROM `".$this->grp_role_table."` gr_rl, `".$this->users_table."` user,`".$this->role_table."` role
                                WHERE gr_rl.group_id = user.group_id and gr_rl.role_id = role.id and user.username = '".$username."'
                                and role.path = '".$path."'";
                        
                        $query = $this->db->query($sql);
                        if($query->count()==1)
                        {
                              $row = $query->result(FALSE, MYSQL_BOTH);
                              return $row[0]['allow_flag'];

                        }else
                        {
                                return false;
                        }
                }
        }
        
        public function get_flag($username,$group)
        {
                if ($this->db->table_exists($this->group_table) && $this->db->table_exists($this->users_table))
		{
                        
                        $sql = "SELECT count(*) FROM `".$this->group_table."` gr, `".$this->users_table."` u  WHERE gr.id = u.group_id and gr.name='".$group."' and u.username='".$username."'";
                        
                        $query = $this->db->query($sql);
                        if($query->count()==1)
                        {
                              $row = $query->result(FALSE, MYSQL_BOTH);
                              return $row[0];

                        }else
                        {
                                return false;
                        }
                }
        }



        public function get_author_by_email($email)
	{
		$sql = "SELECT * FROM `".$this->author_table."` WHERE email LIKE '".$email."'";
		$query = $this->db->query($sql);
		if($query->count()==1)
                {
                        return $query[0];
                }else
                {
                        return false;
                }
	}

        public function get_author_by_id($id)
	{
		$sql = "SELECT * FROM `".$this->author_table."` WHERE id = ".$id;
		$query = $this->db->query($sql);
		if($query->count()==1)
                {
                        return $query[0];
                }else
                {
                        return false;
                }
	}

        public function add_author($author)
	{
		if ($this->db->table_exists($this->author_table))
		{
			$sql = "INSERT INTO `" . $this->author_table . "` (`id`, `family`, `name`, `patronymic`, `date_of_birth`, `sex`, `city_id`, `email`, `telephone`, `site`, `description`) VALUES (
					NULL,
					'" . $author['family'] . "',
					'" . $author['name'] . "',
					'" . $author['patronymic'] . "',
					'" . $author['date'] . "',
					'" . $author['sex'] . "',
					'111111',
					'" . $author['email'] . "',
					'',
					'',
					'');";

			$query = $this->db->query($sql);
                        return $query->insert_id();

			
		}
	}

        public function add_report_head($id,$author)
	{
		if ($this->db->table_exists($this->report_head_table))
		{
                        $name = $author['family'].' '.$author['name'].' '.$author['patronymic'];
			/*$sql = "INSERT INTO  `ref_db`.`set_report_head` (
                                `id` ,
                                `user_id` ,
                                `FIO`
                                )
                                VALUES (
                                NULL ,
                                '" . $id . "',
                                '" . $name .  "'
                                );";
                        */
                        $sql = "CALL insertFirstHead('".$id."','".$name."');";
			return $this->db->query($sql);

			//$query = $this->db->query($sql);
                       // return $query->insert_id();


		}
	}

        public function check_debug_mode($username)
        {
                if ($this->db->table_exists($this->settings_table))
		{
			$sql = "SELECT s.`VALUE`, u.`group_id` FROM ".$this->settings_table." s,".$this->users_table." u
                                WHERE s.`KEY` = 'config.debug_mode' AND u.`username` = '".$username."'";
                        $query = $this->db->query($sql);
			$row = $query->result(FALSE, MYSQL_BOTH);
                        
                        if($row[0]['VALUE'] == 'ON' AND $row[0]['group_id'] != 1)
                        {
                                return true;
                        }else
                        {
                                return false;
                        }




		}
        }
        
        public function debug_mode_status()
        {
                if ($this->db->table_exists($this->settings_table))
		{
			$sql = "SELECT s.`VALUE` FROM ".$this->settings_table." s
                                WHERE s.`KEY` = 'config.debug_mode'";
                        $query = $this->db->query($sql);
			$row = $query->result(FALSE, MYSQL_BOTH);
                        
                        return $row[0]['VALUE'];
                      




		}
        }

        public function debug_mode_start_stop($value)
        {
                if($value == 'start')
                {
                        if ($this->db->table_exists($this->settings_table))
                        {
                                $sql = "UPDATE  ".$this->settings_table." SET  `VALUE` =  'ON' WHERE  `KEY` = 'config.debug_mode';";
                                return $query = $this->db->query($sql);
                        }


                }elseif($value == 'stop')
                {
                        if ($this->db->table_exists($this->settings_table))
                        {
                                $sql = "UPDATE  ".$this->settings_table." SET  `VALUE` =  'OFF' WHERE  `KEY` = 'config.debug_mode';";
                                return $query = $this->db->query($sql);
                        }

                }
        }





	
	
}