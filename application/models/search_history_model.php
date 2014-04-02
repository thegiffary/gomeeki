<?php

class search_history_model extends CI_Model {
	
	var $keyword = '';
	
    function __construct(){
        // Call the Model constructor.
        parent::__construct();
    }
	
	/*
	 * insert_entry($data)
	 * to insert data into search_history table.
	 * @param $keyword city name searched by user.
	 */
	public function insert_entry($keyword){
		$this->keyword = $keyword;
		$this->db->insert('search_history', $this);
	}
	
	/*
	 * getAll()
	 * get all of data in search_history table.
	 * @return list of city name in  search_history table.
	 */
	public function getAll(){
		$query = $this->db->query("SELECT * FROM search_history");
		return $query->result();
	}
	
	/*
	 * isExist($keyword)
	 * to check if city name is already exist in database. 
	 * @param $keyword city name searched by user.
	 * @return true if $id already existed, false if not.
	 */
	public function isExist($keyword){
		$this->db->where('keyword', $keyword);
		
		$query = $this->db->get('search_history');
		if($query->num_rows==1){
			return true;
		}
		else{
			return false;	
		}
	}
	
}