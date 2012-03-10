<?php
class Lib_Model extends Model
{
        public $lib_list_table = 'library_list';
	public $lib_table = 'library_link_list';
	public $pub_table = 'publication';

	public function __construct($id = NULL)
	{
		// load database library into $this->db (can be omitted if not required)
		parent::__construct($id);
	}

        public function get_lib_lists($username)
        {
            if ($this->db->table_exists($this->lib_list_table))
		{

			$sql = "CALL getLibraryLists('".$username."');";
			$query = $this->db->query($sql);
                        return $query->result_array();
                        
		}
        }

        public function get_publications_from_library($list_id)
	{
		if ($this->db->table_exists($this->pub_table) && $this->db->table_exists($this->lib_table))
		{

			$sql = "CALL getPublicationFromLibrary('".$list_id."')";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
	}



        public function delete_lib_list($username,$id)
        {
            if ($this->db->table_exists($this->lib_list_table))
		{

			$sql = "CALL deleteLibraryList('".$username."','".$id."');";
			try
                        {
                                return $this->db->query($sql);
                        }catch (Exception $e)
                        {

                                return 'failed';

                        }

		}
        }

        public function delete_pub_from_list($pub_id,$list_id)
        {
                if ($this->db->table_exists($this->lib_list_table))
		{

			$sql = "CALL deletePubFromList('".$pub_id."','".$list_id."');";
			try
                        {
                                return $this->db->query($sql);
                        }catch (Exception $e)
                        {

                                return 'failed';

                        }

		}
        }

        public function insert_lib_list($username,$name)
        {
            if ($this->db->table_exists($this->lib_list_table))
		{

			$sql = "CALL insertLibraryList('".$username."','".$name."');";
			try
                        {
                                return $this->db->query($sql);
                        }catch (Exception $e)
                        {

                                return 'failed';

                        }

		}
        }

        public function insert_link_to_lib($link_id,$list_id)
        {
            if ($this->db->table_exists($this->lib_list_table))
		{

			$sql = "CALL insertLinkToLibrary('".$link_id."','".$list_id."');";
			try
                        {
                                return $this->db->query($sql);
                        }catch (Exception $e)
                        {

                                return 'failed';

                        }

		}
        }


      
        


}

?>
