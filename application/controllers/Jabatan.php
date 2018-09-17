<?php
	class Jabatan extends CI_controller
		{
			private $sidebar = 'template/sidebar_kepegawaian';

			public function __construct()
				{
					parent::__construct();
					$this->load->model('M_jabatan');
					$this->load->model('M_divisi');

					if(empty($this->session->userdata('username')) || $this->session->userdata('jabatan') != 'STAFF ADMINISTRASI')
						{
							redirect(site_url());
						}
				}

			public static function index()
				{
					$CI =& get_instance();
				}

			# view tambah jabatan
			public static function tambah_jabatan()
				{
					$CI =& get_instance();

					$data = array(
						'content'		=> 'jabatan/tambah_jabatan',
						'sidebar'		=> $CI->sidebar,
						'title_page'	=> 'Tambah Jabatan',
						'divisi'		=> $CI->M_divisi->tampil_divisi(),
					);

					$CI->load->view('template/layout',$data);
				}

			#tambah data jabatan
			public static function tambah_data_jabatan()
				{
					$CI =& get_instance();

					# config validasi
					$config_validasi = array(
						array(
							'field'		=> 'nama_jabatan',
							'label'		=> 'Nama Jabatan',
							'rules'		=> 'required|min_length[3]|max_length[100]|is_unique[jabatan.nama_jabatan]',
							'errors'	=> array(
												'required'		=> 'Nama jabatan tidak boleh kosong',
												'min_length'	=> 'Nama Jabatan minimal 3 karakter',
												'max_length'	=> 'Nama Jabatan maksimal 100 karakter',
												'is_unique'		=> 'Nama Jabatan sudah digunakan'
											),
						),

						array(
							'field'		=> 'divisi',
							'label'		=> 'Divisi',
							'rules'		=> 'required',
							'errors'	=> array(
												'required'		=> 'Divisi tidak boleh kosong',
											),
						),
					);

					# set rules validation
					$CI->form_validation->set_rules($config_validasi);

					# cek validasi
					if($CI->form_validation->run() == false)
						{
							$CI->session->set_flashdata('old_nama_jabatan',$CI->input->post('nama_jabatan'));
							$CI->session->set_flashdata('status_tambah_jabatan','gagal');

							# kembalkan ke view tambah jabatan
							$data = array(
								'content'		=> 'jabatan/tambah_jabatan',
								'sidebar'		=> $CI->sidebar,
								'title_page'	=> 'Tambah Jabatan',
								'divisi'		=> $CI->M_divisi->tampil_divisi(),
							);

							$CI->load->view('template/layout',$data);

						}
					else
						{
							$data_jabatan = array(
								'id_divisi'		=> $CI->input->post('divisi'),
								'kode_jabatan'	=> 'JBT'.date('YmdHis'),
								'nama_jabatan'	=> strtoupper($CI->input->post('nama_jabatan')),
								'created_at'	=> date('Y-m-d H:i:s'),
							);

							$tambah = $CI->M_jabatan->tambah_jabatan($data_jabatan);

							if($tambah)
								{
									$CI->session->set_flashdata('status_tambah_jabatan','berhasil');
									redirect(site_url('jabatan/tambah_jabatan'));
								}
							else
								{
									$CI->session->set_flashdata('status_tambah_jabatan','gagal');
									# kembalkan ke view tambah jabatan
									$data = array(
										'content'		=> 'jabatan/tambah_jabatan',
										'sidebar'		=> $CI->sidebar,
										'title_page'	=> 'Tambah Jabatan',
										'divisi'		=> $CI->M_divisi->tampil_divisi(),
									);

									$CI->load->view('template/layout',$data);

								}
						}
				}

			# datatables lihat data jabatan
			public static function get_data_jabatan()
				{
					$CI =& get_instance();

					$list_divisi = $CI->M_jabatan->get_datatables();
					$data = array();
					$no = $_POST['start'];

					foreach($list_divisi as $field)
						{
							$no++;
							$row = array();

							$row[] = $no;
							$row[] = $field->kode_jabatan;
							$row[] = $field->nama_jabatan;
							$row[] = $field->nama_divisi;

							$row[] = "<a href='".site_url('jabatan/edit/'.$field->id_jabatan)."' class='btn btn-sm btn-success col-md-5' title='Edit'><span class='fa fa-pencil' ></span></a> <button class='btn btn-sm btn-danger col-md-5' title='Hapus' onclick='hapus(\"".$field->id_jabatan."\")'><span class='fa fa-trash' ></span></button>";

                            $data[] = $row;
						}

					$output = array(
						'draw'				=> $_POST['draw'],
						'recordsTotal'      => $CI->M_jabatan->count_all(),
	                    'recordsFiltered'   => $CI->M_jabatan->count_filtered(),
	                    'data'              => $data,
					);

					echo json_encode($output);

				}

			# view lihat jabatan
			public static function lihat_jabatan()
				{	
					$CI =& get_instance();

					$data = array(
						'content'		=> 'jabatan/lihat_jabatan',
						'sidebar'		=> $CI->sidebar,
						'title_page'	=> 'Daftar Jabatan',
					);

					$CI->load->view('template/layout',$data);
				}

			# view edit jabatan
			public static function edit($id)
				{
					$CI =& get_instance();

					$data = array(
						'content'		=> 'jabatan/edit_jabatan',
						'title_page'	=> 'Edit Jabatan',
						'sidebar'		=> $CI->sidebar,
						'jabatan'		=> $CI->M_jabatan->tampil_jabatan(array('jabatan.id_jabatan' => $id)),
						'divisi'		=> $CI->M_divisi->tampil_divisi(),
					);

					foreach($data['jabatan'] as $d_jabatan)
						{
							$CI->session->set_userdata('edit_nama_jabatan',$d_jabatan->nama_jabatan);
						}

					$CI->load->view('template/layout',$data);
				}

			# edit data jabatan
			public static function edit_data_jabatan()
				{
					$CI =& get_instance();

					$id_jabatan = $CI->input->post('id_jabatan');

					$data_jabatan = array(
						'nama_jabatan'	=> strtoupper($CI->input->post('nama_jabatan')),
						'id_divisi'		=> $CI->input->post('divisi'),
						'updated_at'	=> date('Y-m-d H:i:s'),
					);

					$config_validasi = array(
						array(
							'field'		=> 'nama_jabatan',
							'label'		=> 'Nama Jabatan',
							'rules'		=> 'required|min_length[3]|max_length[100]|callback_cek_edit_nama_jabatan',
							'errors'	=> array(
												'required'		=> 'Nama jabatan tidak boleh kosong',
												'min_length'	=> 'Nama Jabatan minimal 3 karakter',
												'max_length'	=> 'Nama Jabatan maksimal 100 karakter',
											),
						),

						array(
							'field'		=> 'divisi',
							'label'		=> 'Divisi',
							'rules'		=> 'required',
							'errors'	=> array(
												'required'		=> 'Divisi tidak boleh kosong',
											),
						),
					);

					# set rules validation
					$CI->form_validation->set_rules($config_validasi);

					if($CI->form_validation->run() == false)
						{
							$CI->session->set_flashdata('status_edit_jabatan','gagal');
							$CI->edit($id_jabatan);
						}
					else
						{
							$ubah = $CI->M_jabatan->update_jabatan($data_jabatan,array('id_jabatan' => $id_jabatan));

							if($ubah)
								{
									$CI->session->set_flashdata('status_edit_jabatan','berhasil');
									$CI->edit($id_jabatan);
								}
							else
								{
									$CI->session->set_flashdata('status_edit_jabatan','gagal');
									$CI->edit($id_jabatan);
								}
						}
				}

			# cek edit nama jabatan
			public static function cek_edit_nama_jabatan($str)
				{
					$CI =& get_instance();

					$nama_jabatan = $CI->session->userdata('edit_nama_jabatan');

					if($str == $nama_jabatan)
						{
							return true;
						}
					else
						{
							$cek = $CI->M_jabatan->cek_nama_jabatan($str);

							if($cek == false)
								{
									$CI->form_validation->set_message('cek_edit_nama_jabatan','Nama jabatan sudah digunakan');
									return false;
								}
							else
								{
									return true;
								}
						}
				}

			# hapus data jabatan
			public static function hapus($id_jabatan)
				{
					$CI =& get_instance();

					$hapus  = $CI->M_jabatan->hapus_jabatan(array('id_jabatan' => $id_jabatan));

					if($hapus)
						{
							$CI->session->set_flashdata('status_hapus_jabatan','berhasil');
						}
					else
						{
							$CI->session->set_flashdata('status_hapus_jabatan','gagal');
						}

					redirect(site_url('jabatan/lihat_jabatan'));
				}
		}