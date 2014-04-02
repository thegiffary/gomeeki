<?php

class tweet_model extends CI_Model {

    var $id   = '';
    var $text = '';
    var $screen_name = '';
	var $lat = '';
	var $lng = '';
	var $created_at = '';
	
    function __construct(){
        // Call the Model constructor
        parent::__construct();
    }
	
	/*
	 * insert_entry($data)
	 * to insert data into tweet table.
	 * @param $data information about tweet.
	 */
	public function insert_entry($data){
		$this->id = $data['id'];
		$this->text = $data['text'];
		$this->screen_name = $data['screen_name'];
		$this->lat = $data['lat'];
		$this->lng = $data['lng'];
		$this->created_at = $data['created_at'];
		
		$this->db->insert('tweet', $this);
	}
	
	/*
	 * isExist($id)
	 * to check if tweet id is already exist in database. 
	 * @param $id unique id of tweet
	 * @return true if $id already existed, false if not.
	 */
	public function isExist($id){
		$this->db->where('id', $id);
		
		$query = $this->db->get('tweet');
		if($query->num_rows==1){
			return true;
		}
		else{
			return false;	
		}
	}
}