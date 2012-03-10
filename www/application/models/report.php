<?php
class Report_Model extends Model
{
        public $table = 'settings';
	
	

	public function __construct($id = NULL)
	{
		// load database library into $this->db (can be omitted if not required)
		parent::__construct($id);
	}

        ////////////PROCEDURE BASED METHODS/////////////////

        //INSERT//
        public function insert_to_basement($username,$new_pos,$new_fio)
        {
               if ($this->db->table_exists($this->table))
		{

			$sql = "CALL insertToReportBasement(
                                '".$username."',
                                '".$new_pos."',
                                '".$new_fio."'
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

        //UPDATE
        public function update_report_basement($id,$new_pos,$new_fio)
        {

             if ($this->db->table_exists($this->table))
		{

			$sql = "CALL updateReportBasement(
                                '".$id."',
                                '".$new_pos."',
                                '".$new_fio."'
                                )";
			try
                        {
                                 return $this->db->query($sql);
                        }catch(Exeption $e)
                        {
                                
                                 return 'failed';
                                
                        }
		}

        }

        public function update_report_name($username,$new)
        {

             if ($this->db->table_exists($this->table))
		{

			$sql = "CALL updateReportName(
                                '".$username."',
                                '".$new."'
                                )";
			try
                        {
                                 return $this->db->query($sql);
                        }catch(Exeption $e)
                        {
                                
                                 return 'failed';
                               
                        }
		}

        }

        public function update_report_type($username,$type)
        {

             if ($this->db->table_exists($this->table))
		{

			$sql = "CALL updateReportType(
                                '".$username."',
                                '".$type."'
                                )";
			try
                        {
                                 return $this->db->query($sql);
                        }catch(Exeption $e)
                        {

                                 return 'failed';

                        }
		}

        }

        //DELETE//
        public function delete_basement_by_id($id)
        {

             if ($this->db->table_exists($this->table))
		{

                    $sql = "CALL deleteReportBasementById('".$id."')";
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

        public function get_name($username)
        {
            if ($this->db->table_exists($this->table))
		{

			$sql = "CALL getNameForReport('".$username."');";
			$query = $this->db->query($sql);
                        $row = $query->result_array();
                        return $row[0];
		}
        }

        public function get_basement($username)
        {
            if ($this->db->table_exists($this->table))
		{

			$sql = "CALL getBasementForReport('".$username."');";
			$query = $this->db->query($sql);
                        $row = $query->result_array();
                        return $row;
		}
        }

        

        

        

        




}

?>
