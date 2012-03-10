<?php
class Admin_Model extends Model
{
        

	public function __construct($id = NULL)
	{
		// load database library into $this->db (can be omitted if not required)
		parent::__construct($id);
	}

        public function get_all_users()
        {
           
			$sql = "CALL getAllUsers();";
			$query = $this->db->query($sql);
                        return $query->result_array();
                
        }

        public function get_user_by_name($query)
        {
            
			$sql = "CALL getUserByName('".$query."');";
			$query = $this->db->query($sql);
			return $query->result_array();

		
        }

        public function get_user_by_id($id)
        {

			$sql = "CALL getUserById('".$id."');";
			$query = $this->db->query($sql);
                        $row = $query->result_array();
                        return $row[0];


        }

        public function get_all_user_groups()
        {

			$sql = "CALL getallUserGroups();";
                        $query = $this->db->query($sql);
			return $query->result_array();


        }

        public function delete_user_by_id($id)
        {

                    $sql = "CALL deleteUserById('".$id."')";
                    try
                        {
                                return $this->db->query($sql);
                        }catch (Exception $e)
                        {

                                return 'failed';

                        }

        }

        public function delete_group_by_id($id)
        {

                    $sql = "CALL deleteGroupById('".$id."')";
                    try
                        {
                                return $this->db->query($sql);
                        }catch (Exception $e)
                        {

                                return 'failed';

                        }

        }


        public function update_user_by_id($user)
        {
               
                $sql = "CALL updateUserById(
                                '".$user['id']."',
                                '".$user['family']."',
                                '".$user['name']."',
                                '".$user['patronymic']."',
                                '".$user['date']."',
                                '".$user['sex']."',
                                '".$user['city_id']."',
                                '".$user['site']."',
                                '".$user['phone']."',
                                '".$user['group']."',
                                '".$user['active']."'
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


         public function insert_group($group)
        {

         
                $sql = "CALL insertGroup(
                        '" . $group['name'] . "',
                        '" . $group['fullname'] . "',
                        '" . $group['desc'] . "',
                        '" . $group['master'] . "'
                        )";
                
                        return $this->db->query($sql);
                


        }

      
        


}

?>
