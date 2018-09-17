<?php
	class Tunjangan extends CI_Controller
		{
			private $sidebar = 'template/sidebar_keuangan';

			public function __construct()
				{
					parent::__construct();
					$this->load->model('M_tunjangan');
					$this->load->model('M_jabatan');
					$this->load->model('M_pegawai');
					$this->load->model('M_divisi');

					if(empty($this->session->userdata('username')) || $this->session->userdata('jabatan') != 'STAFF AKUNTING')
						{
							redirect(site_url());
						}

				}

			# view lihat tunjangan
			public static function index(){
				$CI =& get_instance();

				$data = array(
					'content'		=> 'tunjangan/lihat_tunjangan_karyawan',
					'sidebar'		=> $CI->sidebar,
					'title_page'	=> 'Tunjangan',
				);

				$CI->load->view('template/layout',$data);
			}

			# view tambah tunjangan jabatan
			public static function tambah_tunjangan()
				{
					$CI =& get_instance();

					$data = array(
						'content'		=> 'tunjangan/tambah_tunjangan',
						'sidebar'		=> $CI->sidebar,
						'pegawai'		=> $CI->M_pegawai->tampil_pegawai(),
						'tunjangan'		=> $CI->M_tunjangan->tampil_master_tunjangan(),	
						'title_page'	=> 'Tambah Tunjangan'
					);

					$CI->load->view('template/layout',$data);
				}

			# tambah data tunjangan_jabatan
			public static function tambah_data_tunjangan_karyawan()
				{
					$CI =& get_instance();

					# config validasi
					$config_validasi = array(
						array(
							'field'		=> 'nama_karyawan',
							'label'		=> 'Nama Karyawan',
							'rules'		=> 'required',
							'errors'	=> array(
												'required'		=> 'Nama Karyawan tidak boleh kosong',
											),
						),

						array(
							'field'		=> 'tunjangan',
							'label'		=> 'Tunjangan',
							'rules'		=> 'required',
							'errors'	=> array(
												'required'		=> 'Nama Tunjangan tidak boleh kosong',
											),
						),

						array(
							'field'		=> 'jumlah_tunjangan',
							'label'		=> 'Jumlah Tunjangan',
							'rules'		=> 'required',
							'errors'	=> array(
												'required'		=> 'Jumlah tunjangan tidak boleh kosong',
											),
						),
					);

					# SET VALIDASI FORM VALIDATION
					$CI->form_validation->set_rules($config_validasi);

					# CEK STATUS FORM VALIDATION
					if($CI->form_validation->run() == false)
						{
							$CI->session->set_flashdata('status_tambah_tunjangan_jabatan','gagal');
							$CI->session->set_flashdata('old_nama_tunjangan',$CI->input->post('nama_tunjangan'));
							$CI->session->set_flashdata('old_jumlah_tunjangan',$CI->input->post('jumlah_tunjangan'));

							$data = array(
								'content'		=> 'tunjangan/tambah_tunjangan',
								'sidebar'		=> $CI->sidebar,
								'pegawai'		=> $CI->M_pegawai->tampil_pegawai(),
								'tunjangan'		=> $CI->M_tunjangan->tampil_master_tunjangan(),	
								'title_page'	=> 'Tambah Tunjangan'
							);

							$CI->load->view('template/layout',$data);

						}
					else
						{

							# SET DATA TUNJANGAN JABATAN
							$data = array(
								'id_karyawan'			=> $CI->input->post('nama_karyawan'),
								'id_master_tunjangan'	=> $CI->input->post('tunjangan'),
								'jumlah_tunjangan'		=> $CI->input->post('jumlah_tunjangan'),
								'created_at'			=> date('Y-m-d H:i:s'),
							);

							# cek tunjangan jabatan sudah dimiliki karyawan / belum
							$cek_tunjangan = $CI->M_tunjangan->jumlah_tunjangan_karyawan(array(
												'id_karyawan'		=> $CI->input->post('nama_karyawan'),
												'id_master_tunjangan'	=> $CI->input->post('tunjangan'),
											));

							if($cek_tunjangan > 0)
								{
									$CI->session->set_flashdata('status_tambah_tunjangan_karyawan','gagal');
									$CI->session->set_flashdata('data_tunjangan','sudah ada');
									

									$data = array(
										'content'		=> 'tunjangan/tambah_tunjangan',
										'sidebar'		=> $CI->sidebar,
										'pegawai'		=> $CI->M_pegawai->tampil_pegawai(),
										'tunjangan'		=> $CI->M_tunjangan->tampil_master_tunjangan(),	
										'title_page'	=> 'Tambah Tunjangan'
									);

									$CI->load->view('template/layout',$data);

								}
							else
								{
									# INPUT DATA TUNJANGAN JABATAN
									$tambah_tunjangan = $CI->M_tunjangan->tambah_tunjangan_karyawan($data);

									# CEK TAMBAH TUNJANGAN JABATAN
									if($tambah_tunjangan)
										{
											$CI->session->set_flashdata('status_tambah_tunjangan_karyawan','berhasil');
											redirect(site_url('tunjangan/tambah_tunjangan'));
										}
									else
										{
											$CI->session->set_flashdata('status_tambah_tunjangan_karyawan','gagal');
											$CI->session->set_flashdata('old_nama_tunjangan',$CI->input->post('nama_tunjangan'));
											$CI->session->set_flashdata('old_jumlah_tunjangan',$CI->input->post('jumlah_tunjangan'));

											$data = array(
												'content'		=> 'tunjangan/tambah_tunjangan',
												'sidebar'		=> $CI->sidebar,
												'jabatan'		=> $CI->M_jabatan->tampil_jabatan(),
												'title_page'	=> 'Tambah Tunjangan'
											);

											$CI->load->view('template/layout',$data);
										}
								}
						}
				}

			# master tunjangan
			# LIHAT DATA MASTER TUNJANGAN
			public static function master_tunjangan()
				{
					$CI =& get_instance();

					$data = array(
						'content'		=> 'tunjangan/master_tunjangan',
						'title_page'	=> 'Master Tunjangan',
						'sidebar'		=> $CI->sidebar,
					);

					$CI->load->view('template/layout',$data);
				}

			# VIEW TAMBAH MASTER TUNJANGAN
			public static function tambah_master_tunjangan()
				{
					$CI =& get_instance();

					$data = array(
						'content'		=> 'tunjangan/tambah_master_tunjangan',
						'title_page'	=> 'Tamabah Master Tunjangan',
						'sidebar'		=> $CI->sidebar,
					);

					$CI->load->view('template/layout',$data);
				}

			# TAMBAH DATA MASTER TUNJANGAN
			public static function tambah_data_master_tunjangan()
				{
					$CI =& get_instance();

					# config validasi
					$config_validasi = array(
						array(
							'field'		=> 'nama_tunjangan',
							'label'		=> 'Nama Tunjangan',
							'rules'		=> 'required|min_length[3]|max_length[100]|is_unique[master_tunjangan.nama_tunjangan]',
							'errors'	=> array(
												'required'		=> 'Nama tunjangan tidak boleh kosong',
												'min_length'	=> 'Nama tunjangan minimal 3 karakter',
												'max_length'	=> 'Nama tunjangan maksimal 100 karakter',
												'is_unique'		=> 'Nama tunjangan sudah digunakan',
											),
						),
					);

					# set validasi
					$CI->form_validation->set_rules($config_validasi);

					# cek validasi
					if($CI->form_validation->run() == false)
						{
							$CI->session->set_flashdata('status_tambah_master_tunjangan','gagal');
							$CI->session->set_flashdata('old_nama_tunjangan',$CI->input->post('nama_tunjangan'));

							$data = array(
								'content'		=> 'tunjangan/tambah_master_tunjangan',
								'title_page'	=> 'Tamabah Master Tunjangan',
								'sidebar'		=> $CI->sidebar,
							);

							$CI->load->view('template/layout',$data);

						}
					else
						{
							$data_master = array(
								'nama_tunjangan'		=> strtoupper($CI->input->post('nama_tunjangan')),
								'created_at'			=> date('Y-m-d H:i:s'),
							);

							$tambah = $CI->M_tunjangan->tambah_master_tunjangan($data_master);

							if($tambah)
								{
									$CI->session->set_flashdata('status_tambah_master_tunjangan','berhasil');
									redirect(site_url('tunjangan/tambah_master_tunjangan'));
								}
							else
								{
									$CI->session->set_flashdata('status_tambah_master_tunjangan','gagal');
									$CI->session->set_flashdata('old_nama_tunjangan',$CI->input->post('nama_tunjangan'));

									$data = array(
										'content'		=> 'tunjangan/tambah_master_tunjangan',
										'title_page'	=> 'Tamabah Master Tunjangan',
										'sidebar'		=> $CI->sidebar,
									);

									$CI->load->view('template/layout',$data);
								}
						}
				}

			# datatables lihat data master tunjangan
			public static function get_data_master_tunjangan()
				{
					$CI =& get_instance();

					$list_tunjangan = $CI->M_tunjangan->get_datatables_master_tunjangan();
					$data = array();
					$no = $_POST['start'];

					foreach($list_tunjangan as $field)
						{
							$no++;
							$row = array();

							$row[] = $no;
							$row[] = $field->nama_tunjangan;

							$row[] = "<a href='".site_url('tunjangan/edit_master_tunjangan/'.$field->id_master_tunjangan)."' class='btn btn-sm btn-success col-md-5' title='Edit'><span class='fa fa-pencil' ></span></a> <button class='btn btn-sm btn-danger col-md-5' title='Hapus' onclick='hapus(\"".$field->id_master_tunjangan."\")'><span class='fa fa-trash' ></span></button>";

                            $data[] = $row;
						}

					$output = array(
						'draw'				=> $_POST['draw'],
						'recordsTotal'      => $CI->M_tunjangan->count_all_master_tunjangan(),
	                    'recordsFiltered'   => $CI->M_tunjangan->count_filtered_master_tunjangan(),
	                    'data'              => $data,
					);

					echo json_encode($output);

				}

			# view edit master tunjangan
			public static function edit_master_tunjangan($id)
				{
					$CI =& get_instance();

					$data = array(
						'content'		=> 'tunjangan/edit_master_tunjangan',
						'sidebar'		=> $CI->sidebar,
						'title_page'	=> 'Edit Master Tunjangan',
						'data_master'	=> $CI->M_tunjangan->tampil_master_tunjangan(array('id_master_tunjangan' => $id)),
					);

					foreach($data['data_master'] as $dm)
						{
							$CI->session->set_userdata('edit_nama_tunjangan',$dm->nama_tunjangan);
						}

					$CI->load->view('template/layout',$data);
				}

			# edit data master tunjangan
			public static function edit_data_master_tunjangan()
				{
					$CI =& get_instance();

					$id_master_tunjangan = $CI->input->post('id_master_tunjangan');

					$config_validasi = array(
						array(
							'field'		=> 'nama_tunjangan',
							'label'		=> 'Nama Tunjangan',
							'rules'		=> 'required|min_length[3]|max_length[100]|callback_cek_nama_master_tunjangan',
							'errors'	=> array(
												'required'		=> 'Nama tunjangan tidak boleh kosong',
												'min_length'	=> 'Nama tunjangan minimal 3 karakter',
												'max_length'	=> 'Nama tunjangan maksimal 100 karakter'
											),
						),
					);

					# set rules
					$CI->form_validation->set_rules($config_validasi);

					# cek validasi
					if($CI->form_validation->run() == false)
						{
							$CI->session->set_flashdata('status_edit_master_tunjangan','gagal');
							$data = array(
								'content'		=> 'tunjangan/edit_master_tunjangan',
								'sidebar'		=> $CI->sidebar,
								'title_page'	=> 'Edit Master Tunjangan',
								'data_master'	=> $CI->M_tunjangan->tampil_master_tunjangan(array('id_master_tunjangan' => $id_master_tunjangan)),
							);

							foreach($data['data_master'] as $dm)
								{
									$CI->session->set_userdata('edit_nama_tunjangan',$dm->nama_tunjangan);
								}

							$CI->load->view('template/layout',$data);
						}
					else
						{
							$data_master = array(
								'nama_tunjangan'	=> $CI->input->post('nama_tunjangan'),
								'updated_at'		=> date('Y-m-d H:i:s'),
							);

							$update = $CI->M_tunjangan->ubah_master_tunjangan(
											array(
												'id_master_tunjangan' => $id_master_tunjangan,
											),
											$data_master
										);

							if($update)
								{
									$CI->session->set_flashdata('status_edit_master_tunjangan','berhasil');
									redirect(site_url('tunjangan/edit_master_tunjangan/'.$id_master_tunjangan));
								}
							else
								{
									$CI->session->set_flashdata('status_edit_master_tunjangan','gagal');
									$data = array(
										'content'		=> 'tunjangan/edit_master_tunjangan',
										'sidebar'		=> $CI->sidebar,
										'title_page'	=> 'Edit Master Tunjangan',
										'data_master'	=> $CI->M_tunjangan->tampil_master_tunjangan(array('id_master_tunjangan' => $id_master_tunjangan)),
									);

									foreach($data['data_master'] as $dm)
										{
											$CI->session->set_userdata('edit_nama_tunjangan',$dm->nama_tunjangan);
										}

									$CI->load->view('template/layout',$data);
								}
						}
				}

			# cek validasi edit nama tunjangan
			public static function cek_nama_master_tunjangan($str)
				{
					$CI =& get_instance();

					$nama_tunjangan = $CI->session->userdata('edit_nama_tunjangan');

					if($str == $nama_tunjangan)
						{
							return true;
						}
					else
						{
							$cek = $CI->M_tunjangan->jumlah_master_tunjangan(array('nama_tunjangan' => $str));

							if($cek == 0)
								{
									return true;
								}
							else
								{
									$CI->form_validation->set_message('cek_nama_master_tunjangan','Nama tunjangan sudah digunakan');
									return false;
								}
						}
				}

			# hapus data master tunjangan
			public static function hapus_master_tunjangan($id)
				{
					$CI =& get_instance();

					$hapus = $CI->M_tunjangan->hapus_master_tunjangan(array('id_master_tunjangan' => $id));
					
					if($hapus)
						{
							$CI->session->set_flashdata('status_hapus_master_tunjangan','berhasil');
							redirect(site_url('tunjangan/master_tunjangan'));
						}
					else
						{
							$CI->session->set_flashdata('status_hapus_master_tunjangan','gagal');
							redirect(site_url('tunjangan/master_tunjangan'));
						}
				}

			# datatables lihat data tunjangan_karyawan
			public static function get_data_tunjangan_karyawan()
				{
					$CI =& get_instance();

					$list_tunjangan = $CI->M_tunjangan->get_datatables_tunjangan_karyawan();
					$data = array();
					$no = $_POST['start'];

					foreach($list_tunjangan as $field)
						{
							$no++;
							$row = array();

							$row[] = $no;
							$row[] = $field->nik;
							$row[] = $field->nama;
							$row[] = $field->jk;
							$row[] = $field->nama_jabatan;
							$row[] = $field->nama_divisi;

							$row[] = "<a href='".site_url('tunjangan/detail_tunjangan/'.$field->id_karyawan)."' class='btn btn-sm btn-success col-md-12' title='lihat tunjangan'><span class='fa fa-list' ></span></a>";

                            $data[] = $row;
						}

					$output = array(
						'draw'				=> $_POST['draw'],
						'recordsTotal'      => $CI->M_tunjangan->count_all_tunjangan_karyawan(),
	                    'recordsFiltered'   => $CI->M_tunjangan->count_filtered_tunjangan_karyawan(),
	                    'data'              => $data,
					);

					echo json_encode($output);

				}

			# detail tunjangan
			# menampilkan tunjangan yg dimiliki karyawan yg dipilih
			public static function detail_tunjangan($id_karyawan)
				{
					$CI =& get_instance();

					
					$data = array(
						'karyawan'		=> $CI->M_pegawai->tampil_pegawai(array('id_karyawan' => $id_karyawan)),
						'tunjangan'		=> $CI->M_tunjangan->tampil_tunjangan_karyawan(array('a.id_karyawan' => $id_karyawan)),
						'content'		=> 'tunjangan/detail_tunjangan',
						'sidebar'		=> $CI->sidebar,
						'title_page'	=> 'Tunjangan Karyawan',

					);

					$CI->load->view('template/layout',$data);

				}

			# view edit tunjangan
			public static function edit_tunjangan($id_tunjangan_karyawan)
				{
					$CI =& get_instance();

					$data = array(
						'content'			=> 'tunjangan/edit_tunjangan_karyawan',
						'sidebar'			=> $CI->sidebar,
						'title_page'		=> 'Edit Tunjangan Karyawan',
						'tunjangan'			=> $CI->M_tunjangan->tampil_master_tunjangan(),
						'data_tunjangan'	=> $CI->M_tunjangan->tampil_tunjangan_karyawan(array('id_tunjangan_karyawan' => $id_tunjangan_karyawan)),
					);

					foreach($data['data_tunjangan'] as $dt)
						{
							$CI->session->set_userdata('edit_id_master_tunjangan',$dt->id_master_tunjangan);
						}

					$CI->load->view('template/layout',$data);
				}

			# edit data tunjangan karyawan
			public static function edit_data_tunjangan_karyawan()
				{
					$CI =& get_instance();

					$id_tunjangan_karyawan	= $CI->input->post('id_tunjangan_karyawan');
					$id_karyawan 			= $CI->input->post('id_karyawan'); 

					$config_validasi = array(
						array(
							'field'		=> 'tunjangan',
							'label'		=> 'Tunjangan',
							'rules'		=> 'required',
							'errors'	=> array(
												'required'		=> 'Nama tunjangan tidak boleh kosong',
											),
						),

						array(
							'field'		=> 'jumlah_tunjangan',
							'label'		=> 'Jumlah Tunjangan',
							'rules'		=> 'required',
							'errors'	=> array(
												'required'		=> 'Jumlah tunjangan tidak boleh kosong',
											),
						),
					);

					# set rules form validation
					$CI->form_validation->set_rules($config_validasi);

					# cek validasi 
					if($CI->form_validation->run() == false)
						{
							$CI->session->set_flashdata('status_edit_tunjangan','gagal');

							$data = array(
								'content'			=> 'tunjangan/edit_tunjangan_karyawan',
								'sidebar'			=> $CI->sidebar,
								'title_page'		=> 'Edit Tunjangan Karyawan',
								'tunjangan'			=> $CI->M_tunjangan->tampil_master_tunjangan(),
								'data_tunjangan'	=> $CI->M_tunjangan->tampil_tunjangan_karyawan(array('id_tunjangan_karyawan' => $id_tunjangan_karyawan)),
							);

							$CI->load->view('template/layout',$data);

						}
					else
						{
							# SET DATA TUNJANGAN JABATAN
							$data_tunjangan = array(
								'id_master_tunjangan'	=> $CI->input->post('tunjangan'),
								'jumlah_tunjangan'		=> $CI->input->post('jumlah_tunjangan'),
								'updated_at'			=> date('Y-m-d H:i:s'),
							);

							if($CI->session->userdata('edit_id_master_tunjangan') == $CI->input->post('tunjangan'))
								{
									$cek_tunjangan = 0;
								}
							else
								{
									# cek tunjangan jabatan sudah dimiliki karyawan / belum
									$cek_tunjangan = $CI->M_tunjangan->jumlah_tunjangan_karyawan(array(
										'id_karyawan'			=> $id_karyawan,
										'id_master_tunjangan'	=> $CI->input->post('tunjangan'),
									));
								}
							

							if($cek_tunjangan > 0)
								{
									$CI->session->set_flashdata('data_tunjangan','sudah ada');
									$CI->session->set_flashdata('status_edit_tunjangan','gagal');
									$data = array(
										'content'			=> 'tunjangan/edit_tunjangan_karyawan',
										'sidebar'			=> $CI->sidebar,
										'title_page'		=> 'Edit Tunjangan Karyawan',
										'tunjangan'			=> $CI->M_tunjangan->tampil_master_tunjangan(),
										'data_tunjangan'	=> $CI->M_tunjangan->tampil_tunjangan_karyawan(array('id_tunjangan_karyawan' => $id_tunjangan_karyawan)),
									);

									$CI->load->view('template/layout',$data);
								}
							else
								{
									$update_tunjangan = $CI->M_tunjangan->update_tunjangan_karyawan(
										array(
											'id_tunjangan_karyawan'		=> $id_tunjangan_karyawan,
										),
										$data_tunjangan
									);

									if($update_tunjangan)
										{
											$CI->session->set_flashdata('status_edit_tunjangan','berhasil');
											redirect(site_url('tunjangan/edit_tunjangan/'.$id_tunjangan_karyawan));
										}
									else
										{
											$CI->session->set_flashdata('status_edit_tunjangan','gagal');

											$data = array(
												'content'			=> 'tunjangan/edit_tunjangan_karyawan',
												'sidebar'			=> $CI->sidebar,
												'title_page'		=> 'Edit Tunjangan Karyawan',
												'tunjangan'			=> $CI->M_tunjangan->tampil_master_tunjangan(),
												'data_tunjangan'	=> $CI->M_tunjangan->tampil_tunjangan_karyawan(array('id_tunjangan_karyawan' => $id_tunjangan_karyawan)),
											);

											$CI->load->view('template/layout',$data);
										}
								}


						}
				}

			# hapus tunjangan karyawan
			public static function hapus_tunjangan_karyawan($id_tunjangan,$id_karyawan)
				{
					$CI =& get_instance();

					$hapus = $CI->M_tunjangan->hapus_tunjangan_karyawan(array('id_tunjangan_karyawan' => $id_tunjangan));

					if($hapus)
						{
							$CI->session->set_flashdata('status_hapus_tunjangan','berhasil');
							redirect(site_url('tunjangan/detail_tunjangan/'.$id_karyawan));
						}
					else
						{
							$CI->session->set_flashdata('status_hapus_tunjangan','gagal');
							redirect(site_url('tunjangan/detail_tunjangan/'.$id_karyawan));
						}
				}

			#view transport makan
			public static function transportmakan()
				{
					$CI =& get_instance();

					$data = array(
						'content'		=> 'tunjangan/transport_makan',
						'title_page'	=> 'Trasnport dan Uang Makan',
						'sidebar'		=> $CI->sidebar,
						'transport'		=> $CI->M_tunjangan->tampil_transport_makan(),
					);

					$CI->load->view('template/layout',$data);
				}

			# view tambah transport dan uang makan
			public static function tambah_transportmakan()
				{
					$CI =& get_instance();

					$data = array(
						'content'		=> 'tunjangan/tambah_transport_makan',
						'sidebar'		=> $CI->sidebar,
						'title_page'	=> 'Tambah Transport dan Uang Makan',
						'divisi'		=> $CI->M_divisi->tampil_divisi(),
					);

					$CI->load->view('template/layout',$data);
				}

			# tambah data transport dan uang makan
			public static function tambah_data_transport_makan()
				{
					$CI =& get_instance();

					$config_validasi = array(
						array(
							'field'		=> 'transport',
							'label'		=> 'Transport',
							'rules'		=> 'required',
							'errors'	=> array(
											'required'		=> 'Transport tidak boleh kosong'
										),
						),

						array(
							'field'		=> 'uang_makan',
							'label'		=> 'Uang Makan',
							'rules'		=> 'required',
							'errors'	=> array(
											'required'		=> 'Uang makan tidak boleh kosong'
										),
						),

						array(
							'field'		=> 'divisi',
							'label'		=> 'Divisi',
							'rules'		=> 'required',
							'errors'	=> array(
											'required'		=> 'Divisi tidak boleh kosong'
										),
						),
					);

					$CI->form_validation->set_rules($config_validasi);

					if($CI->form_validation->run() == false)
						{
							$CI->session->set_flashdata('status_tambah_transport', 'gagal');
							$CI->session->set_flashdata('old_transport',$CI->input->post('transport'));
							$CI->session->set_flashdata('old_uang_makan',$CI->input->post('uang_makan'));

							$data = array(
								'content'		=> 'tunjangan/tambah_transport_makan',
								'sidebar'		=> $CI->sidebar,
								'title_page'	=> 'Tambah Transport dan Uang Makan',
								'divisi'		=> $CI->M_divisi->tampil_divisi(),
							);

							$CI->load->view('template/layout',$data);
						}
					else
						{
							$cek_data = $CI->M_tunjangan->jumlah_data_trasnport();

							if($cek_data == 0)
								{
									$data_transport = array(
										'transport'		=> $CI->input->post('transport'),
										'uang_makan'	=> $CI->input->post('uang_makan'),
										'divisi'		=> $CI->input->post('divisi'),
										'created_at'	=> date('Y-m-d H:i:s'),
									);

									$tambah = $CI->M_tunjangan->tambah_transport_makan($data_transport);

									if($tambah)
										{
											$CI->session->set_flashdata('status_tambah_transport','berhasil');
											redirect(site_url('tunjangan/tambah_transportmakan'));
										}
									else
										{
											$CI->session->set_flashdata('status_tambah_transport', 'gagal');
											$CI->session->set_flashdata('old_transport',$CI->input->post('transport'));
											$CI->session->set_flashdata('old_uang_makan',$CI->input->post('uang_makan'));

											$data = array(
												'content'		=> 'tunjangan/tambah_transport_makan',
												'sidebar'		=> $CI->sidebar,
												'title_page'	=> 'Tambah Transport dan Uang Makan',
												'divisi'		=> $CI->M_divisi->tampil_divisi(),
											);

											$CI->load->view('template/layout',$data);
										}
								}
							else
								{
									$CI->session->set_flashdata('status_tambah_transport','sudah ada');
									redirect(site_url('tunjangan/tambah_transportmakan'));
								}
						}
				}

			# view edit transport dan uang makan
			public static function edit_transport($id)
				{
					$CI =& get_instance();

					$data = array(
						'content'		=> 'tunjangan/edit_transport_makan',
						'sidebar'		=> $CI->sidebar,
						'title_page'	=> 'Edit Transport dan Uang Makan',
						'transport'		=> $CI->M_tunjangan->tampil_transport_makan(array(
											'id_transport_makan'	=> $id
										)),
						'divisi'		=> $CI->M_divisi->tampil_divisi(),
					);

					$CI->load->view('template/layout',$data);
				}

			# edit data transport makan
			public static function edit_data_transport_makan()
				{
					$CI =& get_instance();
					$id = $CI->input->post('id_transport');

					$config_validasi = array(
						array(
							'field'		=> 'transport',
							'label'		=> 'Transport',
							'rules'		=> 'required',
							'errors'	=> array(
											'required'		=> 'Transport tidak boleh kosong'
										),
						),

						array(
							'field'		=> 'uang_makan',
							'label'		=> 'Uang Makan',
							'rules'		=> 'required',
							'errors'	=> array(
											'required'		=> 'Uang makan tidak boleh kosong'
										),
						),

						array(
							'field'		=> 'divisi',
							'label'		=> 'Divisi',
							'rules'		=> 'required',
							'errors'	=> array(
											'required'		=> 'Divisi tidak boleh kosong'
										),
						),
					);

					$CI->form_validation->set_rules($config_validasi);

					if($CI->form_validation->run() == false)
						{
							$CI->session->set_flashdata('status_edit_transport', 'gagal');
							$CI->session->set_flashdata('old_transport',$CI->input->post('transport'));
							$CI->session->set_flashdata('old_uang_makan',$CI->input->post('uang_makan'));

							$data = array(
								'content'		=> 'tunjangan/edit_transport_makan',
								'sidebar'		=> $CI->sidebar,
								'title_page'	=> 'Edit Transport dan Uang Makan',
								'transport'		=> $CI->M_tunjangan->tampil_transport_makan(array(
													'id_transport_makan'	=> $id
												)),
								'divisi'		=> $CI->M_divisi->tampil_divisi(),
							);

							$CI->load->view('template/layout',$data);
						}
					else
						{
							
							$data_transport = array(
								'transport'		=> $CI->input->post('transport'),
								'uang_makan'	=> $CI->input->post('uang_makan'),
								'divisi'		=> $CI->input->post('divisi'),
								'updated_at'	=> date('Y-m-d H:i:s'),
							);

							$update = $CI->M_tunjangan->edit_transport_makan(array('id_transport_makan' => $id),$data_transport);

							if($update)
								{
									$CI->session->set_flashdata('status_edit_transport','berhasil');
									redirect(site_url('tunjangan/transportmakan'));
								}
							else
								{
									$CI->session->set_flashdata('status_edit_transport', 'gagal');
									$CI->session->set_flashdata('old_transport',$CI->input->post('transport'));
									$CI->session->set_flashdata('old_uang_makan',$CI->input->post('uang_makan'));

									$data = array(
										'content'		=> 'tunjangan/edit_transport_makan',
										'sidebar'		=> $CI->sidebar,
										'title_page'	=> 'Edit Transport dan Uang Makan',
										'transport'		=> $CI->M_tunjangan->tampil_transport_makan(array(
															'id_transport_makan'	=> $id
														)),
										'divisi'		=> $CI->M_divisi->tampil_divisi(),
									);

									$CI->load->view('template/layout',$data);
								}
								
						}
				}
		}