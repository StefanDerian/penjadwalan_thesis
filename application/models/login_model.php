<?php

class login_model extends CI_Model{


	public function __construct()
	{
	// Call the CI_Model constructor
		parent::__construct();
	}

	/*function untuk mengecek apakah user itu ada atau tidak*/

	public function check_user($id ,$password, $status){

		$this->db->where('id', $id);

		$this->db->where('password', md5($password));

		$query = $this->db->get($status);

		$number = $query->num_rows();

		if($number > 0 ){

			return true;

		}

		return false;
	}

	/*function untuk mendapatkan data user*/

	public function get_user($id,$status){

		$this->db->where('id', $id);

		$query = $this->db->get($status);

		return $query->first_row('array');

		
	}



}