<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class mahasiswa extends CI_Controller {

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

	private $mahasiswa_data = null;

	private $dosens_data = null;

	private $pembimbing_data = null;

	private $status = null;

	public function __construct()
	{
	// Call the CI_Model constructor
		parent::__construct();
		$this->load->database();

		$this->load->library('form_validation');

		$this->load->model('penelitian_model');
		$this->load->model('mahasiswa_model');
		$this->load->model('dosen_model');

		$this->penelitians_data = $this->penelitian_model->get_penelitians();
		$this->mahasiswa_data = $this->mahasiswa_model->get_user($this->session->userdata('id'));
		$this->pembimbing_data = $this->mahasiswa_model->get_pembimbing($this->session->userdata('id'));
		$this->dosens_data = $this->dosen_model->get_users();
		$this->status = 'edit';


	}

	public function index()
	{

		//mencocokan tanggal pendafataran dan tanggal sekarang
		$current_time = $this->mahasiswa_model->check_periode($this->session->userdata('id'));
		$current_time_data = date_parse($current_time['periode']);
		$current_date_data = date_parse(date("Y-m-d h:i:s"));
		$mahasiswa_data = $this->mahasiswa_data;
		if(empty($mahasiswa_data['ipk']) || ($current_time_data['month'] !== $current_date_data['month'] && $current_time_data['year'] !== $current_date_data['year']) ){
			$this->status = 'signup';
		}

		echo $this->status;
		//echo $this->status;
		$this->mahasiswa_form();
	}

	public function mahasiswa_form($validation = ''){

		$this->load->view('container',array(
			'title'=>'Signup Mahasiswa',
			'page'=> 'mahasiswa/signup',
			'dosens_data'=> $this->dosens_data,
			'mahasiswa_data'=>$this->mahasiswa_data,
			'minats_data' => $this->penelitians_data,
			'pembimbing_data' => $this->pembimbing_data,
			'status'=>$this->status,
			'validation'=>$validation

			)
		);
	}

	public function submit_mahasiswa(){

		
// memasukan data data mahasiswayang sudah dimasukan melalui form baik itu untuk signup maupun untuk edit data
		$ipk = $this->input->post('ipk');

		$thesis = $this->input->post('thesis');

		$dosen1 = $this->input->post('dosen1');

		$dosen2 = $this->input->post('dosen2');

		$minat = $this->input->post('minat');

		$this->form_validation->set_rules('ipk', 'IPK', 'required');

		$this->form_validation->set_rules('thesis', 'Thesis', 'required');

		if ($this->form_validation->run() == FALSE){

			$this->mahasiswa_form();

		}else{

			$data_mahasiswa = array(
				'ipk' => $ipk, 
				'judul_thesis'=>$thesis,
				'id_minat'=>$minat
				);

			if(!empty($dosen1) || !empty($dosen2)){
				$data_dosen_mahasiswa = array();

				if(!empty($dosen1)){
					array_push($data_dosen_mahasiswa, array(
						'id_mahasiswa' => $this->session->userdata('id'),
						'id_dosen' => $dosen1,

						));
				}
				if(!empty($dosen2)){
					array_push($data_dosen_mahasiswa, array(
						'id_mahasiswa' => $this->session->userdata('id'),
						'id_dosen' => $dosen2,

						));
				}


			}
			$this->mahasiswa_model->update_data($this->session->userdata('id'), $data_mahasiswa);
			$this->mahasiswa_model->insert_dosen_mahasiswa($data_dosen_mahasiswa,$this->session->userdata('id'));

			if($this->status === 'signup'){
				$this->mahasiswa_model->insert_periode(
					array('id_mahasiswa'=>$this->session->userdata('id')
						)
					);
			}
			
			echo "your registration is success";
		}
	}

}
