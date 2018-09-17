<?php
	class Keterlambatan extends CI_Controller
		{
			private $sidebar = 'template/sidebar_keuangan';

			public function __construct()
				{
					parent::__construct();
					$this->load->model('M_keterlambatan');

					if(empty($this->session->userdata('username')) || $this->session->userdata('jabatan') != 'STAFF AKUNTING')
						{
							redirect(site_url());
						}
				}

			# view tambah potongan keterlambatan
			public static function tambah_potongan()
				{
					$CI =& get_instance();

					$data = array(
						'content'		=> 'keterlambatan/tambah_potongan',
						'title_page'	=> 'Tambah Potongan',
						'sidebar'		=> $CI->sidebar,
					);

					$CI->load->view('template/layout',$data);
				}

			# tambah data potongan keterlambatan
			public static function tambah_data_potongan()
				{
					$CI =& get_instance();

					# config validasi
					$config_validasi = array(
						array(
							'field'		=> 'lama_keterlambatan',
							'label'		=> 'Lama Keterlambatan',
							'rules'		=> 'required|is_unique[potongan_keterlambatan.jumlah_menit]',
							'errors'	=> array(
												'required'		=> 'Lama keterlambatan tidak boleh kosong',
												'is_unique'		=> 'Lama keterlambatan sudah diinputkan sebelumnya',
											),
						),

						array(
							'field'		=> 'jumlah_potongan',
							'label'		=> 'Jumlah Potongan',
							'rules'		=> 'required',
							'errors'	=> array(
												'required'		=> 'Jumlah potongan tidak boleh kosong',
											),
						),
					);

					# set validasi
					$CI->form_validation->set_rules($config_validasi);

					# cek hasil validasi
					if($CI->form_validation->run() == false)
						{
							$CI->session->set_flashdata('status_tambah_potongan','gagal');
							$CI->session->set_flashdata('old_lama_keterlambatan',$CI->input->post('lama_keterlambatan'));
							$CI->session->set_flashdata('old_jumlah_potongan',$CI->input->post('jumlah_potongan'));

							$CI =& get_instance();

							$data = array(
								'content'		=> 'keterlambatan/tambah_potongan',
								'title_page'	=> 'Tambah Potongan',
								'sidebar'		=> $CI->sidebar,
							);

							$CI->load->view('template/layout',$data);
						}
					else
						{
							$data = array(
								
									'jumlah_menit'		=> $CI->input->post('lama_keterlambatan'),
									'jumlah_potongan'	=> $CI->input->post('jumlah_potongan'),
									'created_at'		=> date('Y-m-d H:i:s'),
								);

							$input_data = $CI->M_keterlambatan->tambah_potongan($data);

							if($input_data)
								{
									$CI->session->set_flashdata('status_tambah_potongan','berhasil');
									redirect(site_url('keterlambatan/tambah_potongan'));
								}
							else
								{
									$CI->session->set_flashdata('status_tambah_potongan','gagal');
									$CI->session->set_flashdata('old_lama_keterlambatan',$CI->input->post('lama_keterlambatan'));
									$CI->session->set_flashdata('old_jumlah_potongan',$CI->input->post('jumlah_potongan'));

									$CI =& get_instance();

									$data = array(
										'content'		=> 'keterlambatan/tambah_potongan',
										'title_page'	=> 'Tambah Potongan',
										'sidebar'		=> $CI->sidebar,
									);

									$CI->load->view('template/layout',$data);
								}
						}
				}

			# halaman lihat potongan ketetlambatan
			public static function lihat_potongan()
				{
					$CI =& get_instance();

					$data = array(
						'content'	=> 'keterlambatan/lihat_potongan',
						'title_page'	=> 'Potongan Keterlambatan',
						'sidebar'		=> $CI->sidebar,
					);

					$CI->load->view('template/layout',$data);
				}

			# datatables lihat data potongan_keterlambatan
			public static function get_data_potongan()
				{
					$CI =& get_instance();

					$list_divisi = $CI->M_keterlambatan->get_datatables();
					$data = array();
					$no = $_POST['start'];

					foreach($list_divisi as $field)
						{
							$no++;
							$row = array();

							$row[] = $no;
							$row[] = $field->jumlah_menit.' Menit';
							$row[] = "Rp. ".number_format($field->jumlah_potongan);

							$row[] = "<a href='".site_url('keterlambatan/edit_potongan/'.$field->id_potongan_keterlambatan)."' class='btn btn-sm btn-success col-md-5' title='Edit'><span class='fa fa-pencil' ></span></a> <button class='btn btn-sm btn-danger col-md-5' title='Hapus' onclick='hapus(\"".$field->id_potongan_keterlambatan."\")'><span class='fa fa-trash' ></span></button>";

                            $data[] = $row;
						}

					$output = array(
						'draw'				=> $_POST['draw'],
						'recordsTotal'      => $CI->M_keterlambatan->count_all(),
	                    'recordsFiltered'   => $CI->M_keterlambatan->count_filtered(),
	                    'data'              => $data,
					);

					echo json_encode($output);

				}

			# halaman edit potongan keterlambatan
			public static function edit_potongan($id)
				{
					$CI =& get_instance();

					$data = array(
						'content'		=> 'keterlambatan/edit_potongan',
						'sidebar'		=> $CI->sidebar,
						'title_page'	=> 'Edit Potongan Keterlambatan',
						'potongan'		=> $CI->M_keterlambatan->tampil_potongan(array(
												'id_potongan_keterlambatan'		=> $id
											)),
					);

					foreach($data['potongan'] as $d)
						{
							$CI->session->set_userdata('menit_edit_potongan_keterlambatan',$d->jumlah_menit);
						}

					$CI->load->view('template/layout',$data);
				}

			# edit data potongan keterlambatan
			public static function edit_data_potongan()
				{
					$CI =& get_instance();

					$id_potongan = $CI->input->post('id_potongan');

					// $CI->session->set_userdata('menit_edit_potongan_keterlambatan',$CI->input->post('lama_keterlambatan'));

					# cnnfig validasi
					$config_validasi = array(
						array(
							'field'		=> 'lama_keterlambatan',
							'label'		=> 'Lama Keterlambatan',
							'rules'		=> 'required|callback_cekMenitPotongan',
							'errors'	=> array(
												'required'		=> 'Menit tidak boleh kosong',
											),
							
						),

						array(
							'field'		=> 'jumlah_potongan',
							'label'		=> 'Jumlah Potongan',
							'rules'		=> 'required',
							'errors'	=> array(
												'required'		=> 'Jumlah potongan tidak boleh kosong',
											),
						),
					);

					# set rules
					$CI->form_validation->set_rules($config_validasi);



					# cek validasi
					if($CI->form_validation->run() == false)
						{
							$CI->session->set_flashdata('status_edit_potongan_keterlambatan','gagal');
							$CI->edit_potongan($id_potongan);
							
						}
					else
						{
							$data = array(
								'jumlah_menit'		=> $CI->input->post('lama_keterlambatan'),
								'jumlah_potongan'	=> $CI->input->post('jumlah_potongan'),
								'updated_at'		=> date('Y-m-d H:i:s'),
							);

							$ubah = $CI->M_keterlambatan->update_potongan_keterlambatan(array('id_potongan_keterlambatan'	=> $id_potongan),$data);

							if($ubah)
								{
									$CI->session->set_flashdata('status_edit_potongan_keterlambatan','berhasil');
									redirect(site_url('keterlambatan/edit_potongan/'.$id_potongan));
								}
							else
								{
									$CI->session->set_flashdata('status_edit_potongan_keterlambatan','gagal');
									$CI->edit_potongan($id_potongan);
								}


						}
				}

			# cek menit potongan keterlambatan
			public static function cekMenitPotongan($str = 1)
				{
					$CI =& get_instance();
					$menit = $CI->session->userdata('menit_edit_potongan_keterlambatan');
					

					if($str == $menit)
						{
							return true;
						}
					else
						{
							$cek = $CI->M_keterlambatan->cek_menit_potongan($str);

							if($cek == false)
								{
									$CI->form_validation->set_message('cekMenitPotongan','Menit sudah digunakan');
									return false;
								}
							else
								{
									
									return true;
								}
						}
				}

			# hapus data potongan
			public static function hapus_data_potongan($id)
				{
					$CI =& get_instance();

					$hapus =  $CI->M_keterlambatan->hapus_potongan_keterlambatan(array('id_potongan_keterlambatan' => $id));

					if($hapus)
						{
							$CI->session->set_flashdata('status_hapus_potongan_keterlambatan','berhasil');
							redirect(site_url('keterlambatan/lihat_potongan'));
						}
					else
						{
							$CI->session->set_flashdata('status_hapus_potongan_keterlambatan','gagal');
							redirect(site_url('keterlambatan/lihat_potongan'));
						}
				}

			##########################
			# Keterlambatan karyawan #
			# ########################
			
			# view keterlambatan karyawan
			public static function  keterlambatan_karyawan()
				{
					$CI =& get_instance();

					$data = array(
						'content'	=> 'keterlambatan/lihat_keterlambatan_karyawan',
						'sidebar'	=> $CI->sidebar,
						'title_page'	=> 'Keterlambatan Karyawan',
					);

					$CI->load->view('template/layout',$data);

				}

			# datatables lihat data potongan_keterlambatan
			public static function get_data_keterlambatan_karyawan()
				{
					$CI =& get_instance();

					if(!empty($CI->session->userdata('filter_potongan_keterlambatan_karyawan')))
						{
							$where = $CI->session->userdata('filter_potongan_keterlambatan_karyawan');
						}
					else
						{
							$where = null;
						}

					$list_keterlambatan = $CI->M_keterlambatan->get_datatables_keterlambatan_karyawan($where);
					$data = array();
					$no = $_POST['start'];

					foreach($list_keterlambatan as $field)
						{
							$no++;
							$row = array();

							$row[] = $no;
							$row[] = date_format(date_create($field->tgl),'d-m-Y');
							$row[] = $field->nama;

							$row[] = 'Rp. '.number_format($field->jumlah_potongan);

                            $data[] = $row;
						}

					$output = array(
						'draw'				=> $_POST['draw'],
						'recordsTotal'      => $CI->M_keterlambatan->count_all_keterlambatan_karyawan(),
	                    'recordsFiltered'   => $CI->M_keterlambatan->count_filtered_keterlambatan_karyawan($where),
	                    'data'              => $data,
					);
					$CI->session->unset_userdata('filter_potongan_keterlambatan_karyawan');
					echo json_encode($output);
					
					

				}

			# FILTER DATA KETERLAMBATAN
			public static function set_filter_keterlambatan()
				{
					$CI =& get_instance();
					$condition = array();

					$data_cari = array(
						'absensi.tgl' 									=> $_POST['data_tanggal'],
						'karyawan.nama='								=> "'".$_POST['karyawan']."'",
						'potongan_keterlambatan.jumlah_potongan='		=> "'".$_POST['potongan']."'",
					);

					foreach($data_cari as $dc => $val)
						{
							if(!empty($val) && $val != '\'\'')
								{
									array_push($condition, $dc.$val);
								}
						}

					if(!empty($condition) && $condition != null)
						{
							$where = implode(' AND ',$condition);
						}
					else
						{
							$where = null;
						}

					$CI->session->set_userdata('filter_potongan_keterlambatan_karyawan',$where);
					
				}

		}