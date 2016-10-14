<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ob_start();

class admin extends CI_Controller {

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
	
	private $mahasiswas_data;

	public function __construct()
	{
	// Call the CI_Model constructor
		parent::__construct();
		$this->load->model('mahasiswa_model');
		$this->load->database();
		$this->mahasiswas_data = $this->mahasiswa_model->get_users();
	}


	public function index()
	{
		

		

		$this->load->view('container',
			array('page'=>'admin/daftar_mahasiswa',
				'title'=>'Data Mahasiswa',
				'mahasiswas_data' => $this->mahasiswas_data)
			);

		
	}

	public function generate_excel(){

		$mahasiswas_data = $this->mahasiswas_data;

		//load our new PHPExcel library
		$this->load->library('excel');
        //activate worksheet number 1
		$objPHPExcel = new PHPExcel();

            //set Sheet yang akan diolah 
		$objPHPExcel->setActiveSheetIndex(0)
                    //mengisikan value pada tiap-tiap cell, A1 itu alamat cellnya 
                    //Hello merupakan isinya
		->setCellValue('A1', 'No')
		->setCellValue('B1', 'Nim')
		->setCellValue('C1', 'Nama')
		->setCellValue('D1', 'Judul Thesis')
		->setCellValue('E1', 'Minat')
		->setCellValue('F1', 'Dosen Pembimbing 1')
		->setCellValue('G1', 'Dosen Pembimbing 2')
		->setCellValue('H1', 'Periode');
            //set title pada sheet (me rename nama sheet)
		$objPHPExcel->getActiveSheet()->setTitle('Data Mahasiswa');


		foreach ($mahasiswas_data as $key => $mahasiswa_data) {
			# code...
			$row = $key + 2;
			$no = $key + 1;

			$objPHPExcel->getActiveSheet()->setCellValue('A'.$row,$no);
			$objPHPExcel->getActiveSheet()->setCellValue('B'.$row,$mahasiswa_data['id']);
			$objPHPExcel->getActiveSheet()->setCellValue('C'.$row,$mahasiswa_data['nama']);
			$objPHPExcel->getActiveSheet()->setCellValue('D'.$row,$mahasiswa_data['judul_thesis']);
			$objPHPExcel->getActiveSheet()->setCellValue('E'.$row,$mahasiswa_data['minat']['topik']);
			$objPHPExcel->getActiveSheet()->setCellValue('F'.$row,$mahasiswa_data['pembimbing'][0]['nama']);
			$objPHPExcel->getActiveSheet()->setCellValue('G'.$row,$mahasiswa_data['pembimbing'][1]['nama']);
			$objPHPExcel->getActiveSheet()->setCellValue('H'.$row,date('M Y',strtotime($mahasiswa_data['periode'])));
			
		}

            //mulai menyimpan excel format xlsx, kalau ingin xls ganti Excel2007 menjadi Excel5          
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

            //sesuaikan headernya 
		ob_clean();
		//sesuaikan headernya 
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="Daftar_Mahasiswa.xlsx"');
            //ubah nama file saat diunduh
		
            //unduh file
		$objWriter->save("php://output");
		


	}
}
