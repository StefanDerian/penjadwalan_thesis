<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class dosen extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	
	private $penelitians_data = null;
	private $dosen_penelitians_data = null;

	public function __construct()
	{
	// Call the CI_Model constructor
		parent::__construct();
		$this->load->database();
		$this->load->model('dosen_model');
		$this->load->model('waktu_luang_model');
		$this->load->library('form_validation');
		$this->load->model('penelitian_model');
		$this->penelitians_data = $this->penelitian_model->get_penelitians();
		$this->dosen_penelitians_data = $this->dosen_model->get_penelitian_dosen($this->session->userdata['id']);
		
		
	}


	public function index()
	{

		/*akan dibuatkan function tersendiri*/
		if(empty($this->dosen_penelitians_data)){
			$this->dosen_form('signup');
		}else{
			$this->dosen_form('edit');
		}
	}

	public function dosen_form($status,$validation = ''){
		

		$this->load->view('container',array(
			'title'=>'Signup Dosen',
			'page'=> 'dosen/signup',
			'penelitians_data'=> $this->penelitians_data,
			'status'=>$status,
			'dosen_penelitians_data'=> $this->dosen_penelitians_data,
			'dosen_jumlah_penelitian'=> $this->dosen_model->get_count_penelitian_dosen($this->session->userdata['id']),
			'jumlah_penelitians'=> $this->penelitian_model->get_count_penelitians(),
			'validation'=>$validation
			)
		);
	}

	public function jadwal_dosen(){

		

		$waktu_luang_data = $this->waktu_luang_model->get_day_time();

		$current_waktu_luang = $this->waktu_luang_model->get_user_day_time($this->session->userdata['id']);
		

		$this->load->view('container',array(
			'title'=>'Jadwal Dosen',
			'page'=> 'dosen/jadwal',
			'waktu_luang_data'=> $waktu_luang_data,
			'current_waktu_luang'=>$current_waktu_luang
			)
		);

	}

	public function submit_jadwal_dosen(){
		$jadwals_data = $this->input->post('jadwal');

		$this->waktu_luang_model->insert_user_day_time($this->session->userdata('id'),$jadwals_data);


	}

	public function submit_dosen(){

		
		$penelitians_input_data = $this->input->post('penelitian');


		$status_data = $this->input->post('status');



		if(!empty($penelitians_input_data))
		{
        // Loop through penelitian and add the validation
			foreach($penelitians_input_data as $id => $data)
			{
				
				$this->form_validation->set_rules('penelitian[' . $id . '][rating]', 'Rating', 'required');
			}

		}
		

		if ($this->form_validation->run() == FALSE){
			
			$this->dosen_form($status_data);


		}else{


//validasi memastikan tidak ada topik dan rating yang sama 
			
			if(!$this->check_uniqueness(array_count_values(array_column($penelitians_input_data,'rating')))){


				$this->dosen_form($status_data,'rating tidak boleh ada yang sama');


			}else if(!$this->check_uniqueness(array_count_values(array_column($penelitians_input_data,'id')))){

				$this->dosen_form($status_data,'minat tidak boleh ada yang sama');


			}else{

				$this->dosen_model->insert_penelitians($this->session->userdata('id'),$penelitians_input_data,$status_data);

				if($status_data == 'signup'){
					redirect('dosen/jadwal_dosen','location');
				}else{

					$this->penelitians_data = $this->penelitian_model->get_penelitians();
					$this->dosen_penelitians_data = $this->dosen_model->get_penelitian_dosen($this->session->userdata['id']);

					$this->dosen_form('edit','data berhasil di ubah');
				}

				
			}
		}
	}

	public function check_uniqueness($array = array()){

		foreach ($array as $key => $value) {
	# code...
			if($value > 1){
				return false;
			}
		}


		return true;
	}


}
