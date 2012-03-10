<?php
class News_Model extends Model
{
        public $news_table = 'news';
	
	

	public function __construct($id = NULL)
	{
		// load database library into $this->db (can be omitted if not required)
		parent::__construct($id);
	}

        public function get_news($username)
        {
            if ($this->db->table_exists($this->news_table))
		{

			$sql = "CALL getNews('".$username."');";
			$query = $this->db->query($sql);
                        return $query->result_array();
                        
		}
        }

        public function get_news_by_id($id)
        {
            if ($this->db->table_exists($this->news_table))
		{

			$sql = "CALL getNewsById('".$id."');";
			$query = $this->db->query($sql);
                        $row = $query->result_array();
                        return $row[0];

		}
        }

      
        


}

?>
