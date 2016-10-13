<?php
define("DOSEN_TABLE", "dosen");
define("DOSEN_PENELITIAN_TABLE", "dosen_penelitian");
class dosen_model extends CI_Model{

	
	public function __construct()
	{
	// Call the CI_Model constructor
		parent::__construct();
	}

	

	/*function untuk mendapatkan data 1 dosen*/

	public function get_user($id){

		$this->db->where('id', $id);

		$query = $this->db->get(DOSEN_TABLE);

		return $query->first_row('array');

		
	}

	/*function untuk mendapatkan banyak dosen*/
	public function get_users(){

		$query = $this->db->get(DOSEN_TABLE);

		return  $query->result_array();

		
	}

	public function get_penelitian_dosen($id){

		
		$this->db->where('id_dosen', $id);

		$query = $this->db->get(DOSEN_PENELITIAN_TABLE);

		return  $query->result_array();

		
	}

	public function get_count_penelitian_dosen($id){

		
		$this->db->where('id_dosen', $id);

		$this->db->from(DOSEN_PENELITIAN_TABLE);

		return  $this->db->count_all_results();

		
	}

	/* function untuk memasukan atau mengganti data-data penelitian-penelitian ang dilakukan dosen beserta ratingnya */

	public function insert_penelitians($id, $penelitians,$status = 'signup'){


		if($status == 'signup'){

			foreach($penelitians as $penelitian)
			{

				$penelitian['id_dosen'] = $id ;
				$this->db->insert(DOSEN_PENELITIAN_TABLE, $penelitian);
			}


		}else{
			$current_penelitians_dosen = $this->get_penelitian_dosen($id);

			$id_penelitians_dosen = array_column($current_penelitians_dosen, 'id_penelitian');

			$rating_penelitians_dosen = array_column($current_penelitians_dosen, 'rating');

			$sliced_penelitians =  array_column($penelitians, 'id_penelitian');

			$sliced_rating_penelitians =  array_column($penelitians, 'rating');

			foreach ($penelitians as $key => $penelitian) 
			{
				//unset($sliced_penelitians[$key]['rating']);
				if(!in_array($penelitian['id_penelitian'], $id_penelitians_dosen)){
					$penelitian['id_dosen'] = $id ;
					//array_push($sliced_penelitians, $penelitian['id_penelitian']);
					$this->db->insert(DOSEN_PENELITIAN_TABLE, $penelitian);
				}
				
			}

			foreach($id_penelitians_dosen as $key => $id_penelitian_dosen)
			{

				if(!in_array($id_penelitian_dosen, $sliced_penelitians)){

					$this->db->where('id_penelitian', $id_penelitian_dosen);
					$this->db->where('id_dosen', $id);
					$this->db->delete(DOSEN_PENELITIAN_TABLE);

				}else{
					if($found_index = array_search($id_penelitian_dosen, $sliced_penelitians)){

						if($rating_penelitians_dosen[$key] !== $sliced_rating_penelitians[$found_index]){
							$this->db->set('rating', $sliced_rating_penelitians[$found_index]);
							$this->db->where('id_penelitian', $id_penelitian_dosen);
							$this->db->where('id_dosen', $id);
							$this->db->update(DOSEN_PENELITIAN_TABLE);
						}
						
					}
				}

			}
			
		}

	}


}