<?php
	class Akuntansi extends CI_Controller
		{
			private $sidebar = 'template/sidebar_keuangan';

			public function __construct()
				{
					parent::__construct();
					$this->load->model('M_akun');
				}

			public static function index()
				{
					$CI =& get_instance();
					$data = array(
						'sidebar'		=> $CI->sidebar,
						'title_page'	=> 'Akun',
						'content'		=> 'akuntansi/akun',
					);

					$CI->load->view('template/layout',$data);
				}

			public static function lihat_akun()
				{
					$CI =& get_instance();

					$data = array(
						'sidebar'		=> $CI->sidebar,
						'title_page'	=> 'Akun',
						'content'		=> 'akuntansi/akun',
					);

					$CI->load->view('template/layout',$data);
				}

			# view tambah akun
			public static function tambah_akun()
				{
					$CI =& get_instance();
					$data = array(
						'sidebar'		=> $CI->sidebar,
						'title_page'	=> 'Akun',
						'content'		=> 'akuntansi/tambah_akun',
					);

					$CI->load->view('template/layout',$data);
				}

			# tambah data akun
			public static function tambah_data_akun()
				{
					$CI =& get_instance();

					$config_validasi = array(
						array(
							'field'		=> 'nama_akun',
							'label'		=> 'Nama Akun',
							'rules'		=> 'required|is_unique[akun.nama_akun]',
							'errors'	=> array(
												'required'		=> 'Nama akun tidak boleh kosong',
												'is_unique'		=> 'Nama akun sudah digunakan, gunakan nama akun yang lain'
											),
						),
					);

					$CI->form_validation->set_rules($config_validasi);

					if($CI->form_validation->run() == false)
						{
							$CI->session->set_flashdata('status_tambah_akun','gagal');
							$CI->session->set_flashdata('old_nama_akun',$CI->input->post('nama_akun'));
							$CI->session->set_flashdata('old_keterangan',$CI->input->post('keterangan'));
							$data = array(
								'sidebar'		=> $CI->sidebar,
								'title_page'	=> 'Akun',
								'content'		=> 'akuntansi/tambah_akun',
							);

							$CI->load->view('template/layout',$data);
						}
					else
						{
							$data_akun = array(
								'nama_akun'		=> $CI->input->post('nama_akun'),
								'keterangan'	=> $CI->input->post('keterangan'),
								'created_at'	=> date('Y-m-d H:i:s'),
							);

							$tambah_data = $CI->M_akun->tambah_akun($data_akun);

							if($tambah_data)
								{
									$CI->session->set_flashdata('status_tambah_akun','berhasil');
									redirect(site_url('akuntansi/tambah_akun'));
								}
							else
								{
									$CI->session->set_flashdata('status_tambah_akun','gagal');
									$CI->session->set_flashdata('old_nama_akun',$CI->input->post('nama_akun'));
									$CI->session->set_flashdata('old_keterangan',$CI->input->post('keterangan'));
									$data = array(
										'sidebar'		=> $CI->sidebar,
										'title_page'	=> 'Akun',
										'content'		=> 'akuntansi/tambah_akun',
									);

									$CI->load->view('template/layout',$data);

								}
						}
				}

			# view edit akun 
			public static function edit($id)
				{
					$CI =& get_instance();

					$data_akun = $CI->M_akun->tampil_akun(array('id_akun' => $id));

					foreach($data_akun as $da)
						{
							$CI->session->set_userdata('cek_nama_akun',$da->nama_akun);
						}

					$data = array(
						'content'		=> 'akuntansi/edit_akun',
						'title_page'	=> 'Edit Akun',
						'sidebar'		=> $CI->sidebar,
						'data_akun'		=> $data_akun,
					);

					$CI->load->view('template/layout',$data);
				}

			# cek nama akun
			public static function cek_akun($str)
				{
					$CI =& get_instance();

					$nama_akun = $CI->session->userdata('cek_nama_akun');

					

					if($str == $nama_akun)
						{
							return true;
						}
					else
						{
							$cek = $CI->M_akun->data_akun(array('nama_akun' => $str))->count_all_results();

							if($cek == 0)
								{
									
									return true;
								}
							else
								{
									$CI->form_validation->set_message('cek_akun','Nama Akun sudah digunakan');
									return false;
									
								}
						}

					
				}

			# cek nama akun

			# edit data akun
			public static function edit_data_akun()
				{
					$CI =& get_instance();

					$id_akun = $CI->input->post('id_akun');

					$config_validasi = array(
						array(
							'field'		=> 'nama_akun',
							'label'		=> 'Nama Akun',
							'rules'		=> 'required|callback_cek_akun',
							'errors'	=> array(
												'required'		=> 'Nama Akun tidak boleh kosong',
											),
						),
					);

					$CI->form_validation->set_rules($config_validasi);

					if($CI->form_validation->run() == false)
						{
							$CI->session->set_flashdata('status_edit_akun','gagal');
							$data_akun = $CI->M_akun->tampil_akun(array('id_akun' => $id_akun));

							foreach($data_akun as $da)
								{
									$CI->session->set_userdata('cek_nama_akun',$da->nama_akun);
								}

							$data = array(
								'content'		=> 'akuntansi/edit_akun',
								'title_page'	=> 'Edit Akun',
								'sidebar'		=> $CI->sidebar,
								'data_akun'		=> $data_akun,
							);

							$CI->load->view('template/layout',$data);
						}
					else
						{
							$CI->session->set_flashdata('status_edit_akun','berhasil');
							redirect(site_url('akuntansi/edit/').$id_akun);

						}

				}

			# get datatables akun
			public static function get_data_akun()
				{
					$CI =& get_instance();

					$list_akun = $CI->M_akun->get_datatables();
					$data = array();
					$no = $_POST['start'];

					foreach($list_akun as $field)
						{
							$no++;
							$row = array();

							$row[] = $no;
							$row[] = $field->nama_akun;
							$row[] = $field->keterangan;
							$row[] = "<a class='btn btn-sm btn-success' href='".site_url('akuntansi/edit/').$field->id_akun."' title='Edit'><i class='fa fa-pencil'></i></a>
								<button class='btn btn-danger btn-sm' title='Hapus' onclick='hapus($field->id_akun)'><i class='fa fa-trash'></i></button>
								";
							

                            $data[] = $row;
						}

					$output = array(
						'draw'				=> $_POST['draw'],
						'recordsTotal'      => $CI->M_akun->count_all(),
	                    'recordsFiltered'   => $CI->M_akun->count_filtered(),
	                    'data'              => $data,
					);

					echo json_encode($output);
				}


			# hapus data akun
			public static function hapus_akun($id)
				{
					$CI =& get_instance();

					$hapus = $CI->M_akun->hapus_akun(array('id_akun'=> $id));

					if($hapus)
						{
							$CI->session->set_flashdata('status_hapus_akun','berhasil');
							redirect(site_url('akuntansi/lihat_akun'));
						}
					else
						{
							$CI->session->set_flashdata('status_hapus_akun','gagal');
							redirect(site_url('akuntansi/lihat_akun'));
						}
				}
			
		}