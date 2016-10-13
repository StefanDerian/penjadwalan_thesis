<?php

define('MINAT_TABLE', 'minat');

class penelitian_model extends CI_Model{

	
	public function __construct()
	{
	// Call the CI_Model constructor
		parent::__construct();
	}

	

	/*function untuk mendapatkan data 1 penelitian*/

	public function get_penelitian($id){

		$this->db->where('id', $id);

		$query = $this->db->get(MINAT_TABLE);

		return $query->first_row('array');

		
	}

	/*function untuk mendapatkan banyak dosen*/
	public function get_penelitians(){

		$query = $this->db->get(MINAT_TABLE);

		return  $query->result_array();

		
	}

	public function get_count_penelitians(){

		return  $this->db->count_all_results(MINAT_TABLE);
		
	}


}