<?php
define("WAKTU_LUANG_TABLE", "waktu_luang");
define("DOSEN_WAKTULUANG_TABLE", "dosen_waktuluang");
class waktu_luang_model extends CI_Model{

	
	public function __construct()
	{
	// Call the CI_Model constructor
		parent::__construct();
	}

	/*function untuk mendapatkan jam berdasarkan hari*/
	public function get_day_time(){

		$query = $this->db->get(WAKTU_LUANG_TABLE);

		$times_array = $query->result_array();

		$time_result = array();

		foreach ($times_array as $time_array) {
			# code...
			$time_result[date('l',strtotime($time_array['waktu_luang']))][] = array(
				'id'=>$time_array['id'],
				'jam'=>intval(date('H',strtotime($time_array['waktu_luang']))),
				'full_date'=>$time_array['waktu_luang']
				);
		}
		return $time_result;

	}

	/*function untuk mendapatkan waktu luang untuk 1 dosen*/
	public function get_user_day_time($id){

		$this->db->select('id_waktu');

		$this->db->where('id_dosen',$id);

		$query = $this->db->get(DOSEN_WAKTULUANG_TABLE);

		return $query->result_array();

	}
	/*function untuk memasukan waktu luang untuk 1 dosen*/
	public function insert_user_day_time($id,$waktu_luangs){

		$current_waktu_luang = $this->get_user_day_time($id);

		foreach($waktu_luangs as $waktu_luang)
		{

			$waktu_luang['id_dosen'] = $id;

			if(!in_array(array('id_waktu'=>$waktu_luang['id_waktu']), $current_waktu_luang)){
				
				$this->db->insert(DOSEN_WAKTULUANG_TABLE, $waktu_luang);
			}
			/**if(!in_array( $current_waktu_luang,$waktu_luangs)){

				
				
			}**/	
		}
		foreach ($current_waktu_luang as $current) {
				# code...
				if(!in_array(array('id_waktu'=>$current['id_waktu']), $waktu_luangs)){

					$this->db->where('id_waktu', $current['id_waktu']);
					$this->db->where('id_dosen', $id);
					$this->db->delete(DOSEN_WAKTULUANG_TABLE);
				}
			}

	}	



}