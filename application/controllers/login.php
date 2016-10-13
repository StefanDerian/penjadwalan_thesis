<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class login extends CI_Controller {

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
	public function index()
	{
		

		$this->load->library('form_validation');
		$this->load->view('container',
			array('page'=>'login',
				'title'=>'halaman login')
			);

		
	}



	public function login_ops(){

		$this->load->database();

		$this->load->model('login_model');

		$this->load->library('form_validation');

		$id = $this->input->post('nim');

		$password = $this->input->post('pwd');

		$this->form_validation->set_rules('nim', 'Nim', 'required');

		$this->form_validation->set_rules('pwd', 'Password', 'required',
			array('required' => 'please enter your password %s.')
			);

		if ($this->form_validation->run() == FALSE){

			$this->load->view('container',
				array('page'=>'login',
					'title'=>'halaman login')
				);

		}else{
			if($this->login_model->check_user($id,$password,'mahasiswa')){

				$user_data = $this->login_model->get_user($id,'mahasiswa');
				
				$this->session->set_userdata('id', $id);
				$this->session->set_userdata('nama', $user_data['nama']);
				$this->session->set_userdata('status', 'mahasiswa');
				redirect('mahasiswa','location');
			}else if($this->login_model->check_user($id,$password,'dosen')){

				$user_data = $this->login_model->get_user($id,'dosen');
				$this->session->set_userdata('id', $id);
				$this->session->set_userdata('nama', $user_data['nama']);
				$this->session->set_userdata('status', 'dosen');
				redirect('dosen','location');
			}else if($this->login_model->check_user($id,$password,'admin')){

				$user_data = $this->login_model->get_user($id,'admin');
				$this->session->set_userdata('id', $id);
				$this->session->set_userdata('nama', $user_data['nama']);
				$this->session->set_userdata('status', 'admin');
				redirect('admin','location');
			}
			else{
				$this->load->view('container',
					array('page'=>'login',
						'title'=>'halaman login',
						'validation'=>'password and NIM/NIP do not match')
					);
			}
		}








	}






}
