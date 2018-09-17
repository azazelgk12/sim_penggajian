<?php
	class Divisi extends CI_Controller
		{
			private $sidebar = 'template/sidebar_kepegawaian';

			public function __construct()
				{
					parent::__construct();
					$this->load->model('M_divisi');
					if(empty($this->session->userdata('username')) || $this->session->userdata('jabatan') != 'STAFF ADMINISTRASI')
						{
							redirect(site_url());
						}
				}

			

			# tambah divisi
			public static function tambah_divisi()
				{
					$CI =& get_instance();

					$data = array(
						'content'		=> 'divisi/tambah_divisi',
						'title_page'	=> 'Tambah Divisi',
						'sidebar'		=> $CI->sidebar,

					);

					$CI->load->view('template/layout',$data);
				}

			# tambah data divisi
			public static function tambah_data_divisi()
				{
					$CI =& get_instance();

					# config validasi 
					$config_validasi = array(

						array(
							'field'		=> 'nama_divisi',
							'label'		=> 'Nama Divisi',
							'rules'		=> 'required|min_length[3]|max_length[100]|is_unique[divisi.nama_divisi]',
							'errors'	=> array(
												'required'		=> 'Nama Divisi tidak boleh kosong',
												'min_length'	=> 'Nama Divisi minimal harus berisi 3 karakter',
												'max_length'	=> 'Nama Divisi maksimal terdiri dari 100 karakter',
												'is_unique'		=> "Nama DIvisi sudah digunakan",
											),
						),
					);

					$CI->form_validation->set_rules($config_validasi);

					# cek validasi
					if($CI->form_validation->run() == false)
						{
							$CI->session->set_flashdata('old_nama_divisi',$CI->input->post('nama_divisi'));

							$CI->session->set_flashdata('status_tambah_divisi','gagal');

							# set data view
							$data = array(
								'content'		=> 'divisi/tambah_divisi',
								'title_page'	=> 'Tambah Divisi',
								'sidebar'		=> $CI->sidebar,

							);

							# kembalikan ke halaman tambah divisi
							$CI->load->view('template/layout',$data);

						}
					else
						{
							$data_divisi = array(
								'kode_divisi'		=> 'DV'.date('YmdHis'),
								'nama_divisi'		=> strtoupper($CI->input->post('nama_divisi')),
								'created_at'		=> date('Y-m-d H:i:s'),
							);

							$tambah_data = $CI->M_divisi->tambah_divisi($data_divisi);

							if($tambah_data)
								{
									$status = 'berhasil';
									$CI->session->set_flashdata('status_tambah_divisi',$status);
									redirect(site_url('divisi/tambah_divisi'));
								}
							else
								{
									$status = 'gagal';
									$CI->session->set_flashdata('status_tambah_divisi',$status);
									# set data view
									$data = array(
										'content'		=> 'divisi/tambah_divisi',
										'title_page'	=> 'Tambah Divisi',
										'sidebar'		=> $CI->sidebar,

									);

									# kembalikan ke halaman tambah divisi
									$CI->load->view('template/layout',$data);
								}

						}

					
				}

			# halaman lihat divisi
			public static function lihat_divisi()
				{
					$CI =& get_instance();

					$data = array(
						'content'		=> 'divisi/lihat_divisi',
						'title_page'	=> 'Daftar Divisi',
						'sidebar'		=> $CI->sidebar,
					);

					$CI->load->view('template/layout',$data);
				}

			# datatables lihat data divisi
			public static function get_data_divisi()
				{
					$CI =& get_instance();

					$list_divisi = $CI->M_divisi->get_datatables();
					$data = array();
					$no = $_POST['start'];

					foreach($list_divisi as $field)
						{
							$no++;
							$row = array();

							$row[] = $no;
							$row[] = $field->kode_divisi;
							$row[] = $field->nama_divisi;

							$row[] = "<a href='".site_url('divisi/edit/'.$field->id_divisi)."' class='btn btn-sm btn-success col-md-5' title='Edit'><span class='fa fa-pencil' ></span></a> <button class='btn btn-sm btn-danger col-md-5' title='Hapus' onclick='hapus(\"".$field->id_divisi."\")'><span class='fa fa-trash' ></span></button>";

                            $data[] = $row;
						}

					$output = array(
						'draw'				=> $_POST['draw'],
						'recordsTotal'      => $CI->M_divisi->count_all(),
	                    'recordsFiltered'   => $CI->M_divisi->count_filtered(),
	                    'data'              => $data,
					);

					echo json_encode($output);

				}

			# halaman edit divisi
			public static function edit($id)
				{
					$CI =& get_instance();

					# data edit divisi
					$data = array(
						'content'		=> 'divisi/edit_divisi',
						'sidebar'		=> $CI->sidebar,
						'title_page'	=> 'Edit Divisi',
						'divisi'		=> $CI->M_divisi->tampil_divisi(array('id_divisi'=>$id)),
					);

					foreach($data['divisi'] as $d_divisi)
						{
							$CI->session->set_userdata('edit_nama_divisi',$d_divisi->nama_divisi);
						}

					$CI->load->view('template/layout',$data);
					
				}

			# edit data divisi
			public static function edit_data_divisi()
				{
					$CI =& get_instance();

					$id_divisi = $CI->input->post('id_divisi');
					$nama = $CI->input->post('nama_divisi');

					# config validasi 
					$config_validasi = array(

						array(
							'field'		=> 'nama_divisi',
							'label'		=> 'Nama Divisi',
							'rules'		=> 'required|min_length[3]|max_length[100]|callback_cekNamaDivisi',
							'errors'	=> array(
												'required'		=> 'Nama Divisi tidak boleh kosong',
												'min_length'	=> 'Nama Divisi minimal harus berisi 3 karakter',
												'max_length'	=> 'Nama Divisi maksimal terdiri dari 100 karakter',
											),
						),
					);

					$CI->form_validation->set_rules($config_validasi);

					if($CI->form_validation->run() == false)
						{
							$CI->session->set_flashdata('status_edit_divisi','gagal');
	                        $CI->edit($id_divisi);
	                       	// echo validation_errors();
						}
					else
						{
							$data_divisi = array(
								'nama_divisi'	=> strtoupper($CI->input->post('nama_divisi')),
								// 'updated_at'	=> date('Y-m-d H:i:s'),
							);
							#update data kdd
	                        $update_divisi = $CI->M_divisi->update_divisi($data_divisi,array('id_divisi'=>$id_divisi));
	                        # cek apakah update kdd berhasil atau tidak
	                        if($update_divisi)
	                          {
	                            $CI->session->set_flashdata('status_edit_divisi','berhasil');
	                            $CI->edit($id_divisi);
	                          }
	                        else
	                          {
	                            $CI->session->set_flashdata('status_edit_divisi','gagal');
	                            $CI->edit($id_kdd);
	                          }
	                        
	                        // echo $CI->db->last_query();
						}

				}

			# cek nama divisi
			public static function cekNamaDivisi($str)
				{
					$CI =& get_instance();

					$nama_divisi = $CI->session->userdata('edit_nama_divisi');

					if($str == $nama_divisi)
						{
							return true;
						}
					else
						{
							$cek = $CI->M_divisi->cek_nama_divisi($str);

							if($cek == false)
								{
									$CI->form_validation->set_message('cekNamaDivisi','Nama divisi sudah digunakan');
									return false;
								}
							else
								{
									return true;
								}
						}
				}

			# hapus data divisi
			public static function hapus($id)
				{
					$CI =& get_instance();

					$hapus = $CI->M_divisi->hapus_divisi(array('id_divisi'=>$id));

					if($hapus)
						{
							$CI->session->set_flashdata('status_hapus_divisi','berhasil');
						}
					else
						{
							$CI->session->set_flashdata('status_hapus_divisi','gagal');
						}

					redirect(site_url('divisi/lihat_divisi'));
				}
		}