<?php
define('MAHASISWA','mahasiswa');
define('MAHASISWA_DOSEN_TABLE','mahasiswa_dosen');
define('MAHASISWA_PERIODE_TABLE','mahasiswa_periode');
class mahasiswa_model extends CI_Model{


	public function __construct()
	{
	// Call the CI_Model constructor
		parent::__construct();
		$this->load->model('penelitian_model');
		$this->load->model('dosen_model');
	}

	/*function untuk mendapatkan data 1 mahasiswa*/

	public function get_user($id){

		$this->db->where('id', $id);

		$query = $this->db->get(MAHASISWA);

		return $query->first_row('array');

		
	}


	
	/*function untuk mendapatkan data banyak mahasiswa*/

	public function get_users(){

		$query = $this->db->get(MAHASISWA);
		$mahasiswas_result = $query->result_array();

		
		foreach ($mahasiswas_result as $key => $mahasiswa_result) {
				# code...
			$periode = $this->check_periode($mahasiswa_result['id']);
			$dosens_data = $this->get_pembimbing($mahasiswa_result['id']);

			foreach ($dosens_data as $key1 => $dosen_data) {
				$dosen_detail = $this->dosen_model->get_user($dosen_data['id_dosen']);
				$dosen_data['nama'] = $dosen_detail['nama'];
				$dosens_data[$key1] = $dosen_data;
	# code...
			}

			$mahasiswa_result['pembimbing'] = $dosens_data;
			$mahasiswa_result['minat'] = $this->penelitian_model->get_penelitian($mahasiswa_result['id_minat']);
			$mahasiswa_result['periode'] = $periode['periode'];
			$mahasiswas_result[$key] = $mahasiswa_result;
			

		}
		return $mahasiswas_result;
	}

	

	/*function untuk mendapatkan dosen pembimbing*/

	public function get_pembimbing($id,$id_dosen = false){

		if($id_dosen){
			$this->db->select('id_dosen');
		}

		$this->db->where('id_mahasiswa', $id);

		$query = $this->db->get(MAHASISWA_DOSEN_TABLE);

		return $query->result_array();


	}

	/*memasukan data data mahasiswa*/
	public function update_data($id,$data){

		$this->db->where('id', $id);

		$this->db->update(MAHASISWA, $data);

	}
	public function check_periode($id){

		$this->db->select('periode');
		$this->db->where('id_mahasiswa',$id);
		$this->db->from(MAHASISWA_PERIODE_TABLE);
		$this->db->order_by('periode', 'desc');
		$this->db->limit(1);

		return $this->db->get()->first_row('array');
	}


	public function insert_periode($data){
		$this->db->insert(MAHASISWA_PERIODE_TABLE,$data);
	}

	/*memasukan atau mengupdate data dosen pembimbing dan mahasiswa*/
	public function insert_dosen_mahasiswa($data,$id='0'){

		$pembimbings_data = $this->get_pembimbing($id,true);

		if(!empty($pembimbings_data)){

			foreach ($pembimbings_data as $pembimbing_data) {
				# code...
				if(!in_array(array('id_mahasiswa'=>$this->session->userdata('id'),'id_dosen' =>$pembimbing_data['id_dosen'] ),$data)){

					$this->db->where('id_mahasiswa', $this->session->userdata('id'));
					$this->db->where('id_dosen', $pembimbing_data['id_dosen']);
					$this->db->delete(MAHASISWA_DOSEN_TABLE);



				}
			}
			foreach ($data as $datum) {
				# code...
				if(!in_array(array('id_dosen'=>$datum['id_dosen']), $pembimbings_data)){

					$this->db->insert(MAHASISWA_DOSEN_TABLE, $datum);
				}
			}

		}else{
			$this->db->insert_batch(MAHASISWA_DOSEN_TABLE, $data);
		}

	}

}