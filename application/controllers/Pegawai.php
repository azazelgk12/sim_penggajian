<?php
	class Pegawai extends CI_Controller
		{
			private $sidebar = 'template/sidebar_kepegawaian';

			public function __construct()
				{
					parent::__construct();

					$this->load->model('M_pegawai');
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

					$data = array(
						'content'			=> 'kepegawaian/home',
						'sidebar'			=> $CI->sidebar,
						'jumlah_karyawan'	=> $CI->M_pegawai->jumlah_karyawan(),
						'karyawan_kantor'	=> $CI->M_pegawai->jumlah_karyawan(array('divisi.nama_divisi' => 'KANTOR')),
						'karyawan_produksi'	=> $CI->M_pegawai->jumlah_karyawan(array('divisi.nama_divisi' => 'PRODUKSI')),
						'total_laki_laki'	=> $CI->M_pegawai->jumlah_karyawan(array('karyawan.jk' => 'LAKI-LAKI')),
						'total_perempuan'	=> $CI->M_pegawai->jumlah_karyawan(array('karyawan.jk' => 'PEREMPUAN')),
					);

					$CI->load->view('template/layout',$data);
				}

			# view tambah data pegawai
			public static function tambah_pegawai()
				{
					$CI =& get_instance();

					$data = array(
						'content'		=> 'kepegawaian/tambah_pegawai',
						'title_page'	=> 'Tambah Pegawai',
						'sidebar'		=> $CI->sidebar,
						'jabatan'		=> $CI->M_jabatan->tampil_jabatan(),
					);

					$CI->load->view('template/layout',$data);
				}

			
			public static function tambah_data_pegawai()
				{
					$CI =& get_instance();

					# Config validasi inputan
					$config_validasi = array(
						array(
							'field'		=> 'no_identitas',
							'label'		=> 'No Identitas',
							'rules'		=> 'required|min_length[8]|is_unique[karyawan.nama]|callback_no_identitas_cek',
							'errors'	=> array(
												'required'		=> 'No Identitas tidak boleh kosong',
												'min_length'	=> 'No Identitas minimal 8 karakter',
												'is_unique'		=> 'No Identitas sudah digunakan',
											),

						),

						array(
							'field'		=> 'nama',
							'label'		=> 'Nama',
							'rules'		=> 'required|min_length[3]',
							'errors'	=> array(
												'required'		=> 'Nama tidak boleh kosong',
												'min_length'	=> 'Nama minimal menggunakan 3 karakter',
											),
						),

						array(
							'field'		=> 'jenis_kelamin',
							'label'		=> 'Jenis Kelamin',
							'rules'		=> 'required',
							'errors'	=> array(
												'required'		=> 'Jenis Kelamin tidak boleh kosong',
											),
						),

						array(
							'field'		=> 'tempat_lahir',
							'label'		=> 'Tempat Lahir',
							'rules'		=> 'required|min_length[3]',
							'errors'	=> array(
												'required'		=> 'Tempat lahir tidak boleh kosong',
												'min_length'	=> 'Tempat lahir minimal menggunakan 3 karakter',
											),
						),

						array(
							'field'		=> 'tanggal_lahir',
							'label'		=> 'Tanggal lahir',
							'rules'		=> 'required',
							'errors'	=> array(
												'required'		=> 'Tanggal lahir tidak boleh kosong',
											),
						),

						array(
							'field'		=> 'agama',
							'label'		=> 'Agama',
							'rules'		=> 'required',
							'errors'	=> array(
												'required'		=> 'Agama tidak boleh kosong',
											),
						),

						array(
							'field'		=> 'alamat',
							'label'		=> 'Alamat',
							'rules'		=> 'required|min_length[5]|max_length[100]',
							'errors'	=> array(
												'required'		=> 'Alamat tidak boleh kosong',
												'min_length'	=> 'Alamat minimal harus 5 karakter',
												'max_length'	=> 'Alamat maksimal memiliki 100 karakter',
											),
						),

						array(
							'field'		=> 'kota',
							'label'		=> 'Kota',
							'rules'		=> 'required|min_length[3]|max_length[100]',
							'errors'	=> array(
												'required'		=> 'Kota tidak boleh kosong',
												'min_length'	=> 'Kota minimal memiliki 3 karakter',
												'maX_length'	=> 'Kota maksimal memiliki 100 karakter',
											),
						),

						array(
							'field'		=> 'kewarganegaraan',
							'label'		=> 'Kewarganegaraan',
							'rules'		=> 'required',
							'errors'	=> array(
												'required'		=> 'Kewarganegaraan tidak boleh kosong',
											),
						),

						array(
							'field'		=> 'jabatan',
							'label'		=> 'Jabatan',
							'rules'		=> 'required',
							'errors'	=> array(
												'required'		=> 'Jabatan tidak boleh kosong',
											),
						),

						array(
							'field'		=> 'no_tlp',
							'label'		=> 'No Tlp ',
							'rules'		=> 'callback_no_tlp_cek',
						),

						array(
							'field'		=> 'rt',
							'label'		=> 'RT ',
							'rules'		=> 'callback_rt_cek',
						),

						array(
							'field'		=> 'rw',
							'label'		=> 'RW ',
							'rules'		=> 'callback_rw_cek',
						),
					);

					# set validation
                    $CI->form_validation->set_rules($config_validasi);

                    # cek form validation
                    if($CI->form_validation->run() == false)
                    	{
                    		# Set flashdata
                    		$CI->session->set_flashdata('old_no_identitas',$CI->input->post('no_identitas'));
                    		$CI->session->set_flashdata('old_nama',$CI->input->post('nama'));
                    		$CI->session->set_flashdata('old_jenis_kelamin',$CI->input->post('jenis_kelamin'));
                    		$CI->session->set_flashdata('old_tempat_lahir',$CI->input->post('tempat_lahir'));
                    		$CI->session->set_flashdata('old_tanggal_lahir',$CI->input->post('tanggal_lahir'));
                    		$CI->session->set_flashdata('old_agama',$CI->input->post('agama'));
                    		$CI->session->set_flashdata('old_alamat',$CI->input->post('alamat'));
                    		$CI->session->set_flashdata('old_rt',$CI->input->post('rt'));
                    		$CI->session->set_flashdata('old_rw',$CI->input->post('rw'));
                    		$CI->session->set_flashdata('old_kecamatan',$CI->input->post('kecamatan'));
                    		$CI->session->set_flashdata('old_kelurahan',$CI->input->post('kelurahan'));
                    		$CI->session->set_flashdata('old_kota',$CI->input->post('kota'));
                    		$CI->session->set_flashdata('old_kewarganegaraan',$CI->input->post('kewarganegaraan'));
                    		$CI->session->set_flashdata('old_jabatan',$CI->input->post('jabatan'));
                    		$CI->session->set_flashdata('old_no_tlp',$CI->input->post('no_tlp'));

                    		$CI->session->set_flashdata('status_tambah_pegawai','gagal');

                    		# set data ke view
                    		$data = array(
								'content'		=> 'kepegawaian/tambah_pegawai',
								'title_page'	=> 'Tambah Pegawai',
								'jabatan'		=> $CI->M_jabatan->tampil_jabatan(),
								'sidebar'		=> $CI->sidebar,
							);

                    		# tampilkan view
							$CI->load->view('template/layout',$data);

                    	}
                    else
                    	{
                    		# ubah format tanggal lahir pegawai
                    		$tgl_lahir 		= $CI->input->post('tanggal_lahir');
                    		$pecah_tgl 		= explode('-',$tgl_lahir);
                    		$tanggal_lahir 	= $pecah_tgl[2].'-'.$pecah_tgl[1].'-'.$pecah_tgl[0]; 

                    		# set data pegawai
                    		$data_pegawai 	= array(
                    			'nik'				=> date('ymdhis'),
                    			'id_jabatan'		=> $CI->input->post('jabatan'),
                    			'no_identitas'		=> $CI->input->post('no_identitas'),
                    			'nama'				=> strtoupper($CI->input->post('nama')),
                    			'jk'				=> $CI->input->post('jenis_kelamin'),
                    			'tempat_lahir'		=> strtoupper($CI->input->post('tempat_lahir')),
                    			'tanggal_lahir'		=> $tanggal_lahir,
                    			'alamat'			=> strtoupper($CI->input->post('alamat')),
                    			'rt'				=> $CI->input->post('rt'),
                    			'rw'				=> $CI->input->post('rw'),
                    			'kecamatan'			=> strtoupper($CI->input->post('kecamatan')),
                    			'kelurahan'			=> strtoupper($CI->input->post('kelurahan')),
                    			'kota'				=> strtoupper($CI->input->post('kota')),
                    			'no_tlp'			=> $CI->input->post('no_tlp'),
                    			'agama'				=> $CI->input->post('agama'),
                    			'kewarganegaraan'	=> $CI->input->post('kewarganegaraan'),
                    			'created_at'		=> date('Y-m-d H:i:s'),
                    		);

                    		$tambah = $CI->M_pegawai->tambah_pegawai($data_pegawai);

                    		if($tambah)
                    			{
                    				$CI->session->set_flashdata('status_tambah_pegawai','berhasil');
                    				redirect(site_url('pegawai/tambah_pegawai'));
                    			}
                    		else
                    			{
                    				# Set flashdata
		                    		$CI->session->set_flashdata('old_no_identitas',$CI->input->post('no_identitas'));
		                    		$CI->session->set_flashdata('old_nama',$CI->input->post('nama'));
		                    		$CI->session->set_flashdata('old_jenis_kelamin',$CI->input->post('jenis_kelamin'));
		                    		$CI->session->set_flashdata('old_tempat_lahir',$CI->input->post('tempat_lahir'));
		                    		$CI->session->set_flashdata('old_tanggal_lahir',$CI->input->post('tanggal_lahir'));
		                    		$CI->session->set_flashdata('old_agama',$CI->input->post('agama'));
		                    		$CI->session->set_flashdata('old_alamat',$CI->input->post('alamat'));
		                    		$CI->session->set_flashdata('old_rt',$CI->input->post('rt'));
		                    		$CI->session->set_flashdata('old_rw',$CI->input->post('rw'));
		                    		$CI->session->set_flashdata('old_kecamatan',$CI->input->post('kecamatan'));
		                    		$CI->session->set_flashdata('old_kelurahan',$CI->input->post('kelurahan'));
		                    		$CI->session->set_flashdata('old_kota',$CI->input->post('kota'));
		                    		$CI->session->set_flashdata('old_kewarganegaraan',$CI->input->post('kewarganegaraan'));
		                    		$CI->session->set_flashdata('old_jabatan',$CI->input->post('jabatan'));
		                    		$CI->session->set_flashdata('old_no_tlp',$CI->input->post('no_tlp'));

		                    		$CI->session->set_flashdata('status_tambah_pegawai','gagal');

		                    		# set data ke view
		                    		$data = array(
										'content'		=> 'pagawai/tambah_pegawai',
										'title_page'	=> 'Tambah Pegawai',
										'jabatan'		=> $CI->M_jabatan->tampil_jabatan(),
										'sidebar'		=> $CI->sidebar,
									);

		                    		# tampilkan view
									$CI->load->view('template/layout',$data);
                    			}
                    	}

				}

			# validasi nomer telepon
            public static function no_tlp_cek($value)
                {
                    $CI =& get_instance();
                    $value = trim($value);

                    if ($value == '') {
                            return TRUE;
                    }
                    else
                    {
                            if (preg_match("/^[0-9]+$/i", $value))
                                {
                                    return preg_replace('/^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/', '($1) $2-$3', $value);
                                }
                            else
                                {
                                    $CI->form_validation->set_message('no_tlp_cek','Nomor telepon hanya boleh diisi oleh angka saja');
                                    return FALSE;
                                }
                    }
                }

            # validasi rt
            public static function rt_cek($value)
                {
                    $CI =& get_instance();
                    $value = trim($value);

                    if ($value == '') {
                            return TRUE;
                    }
                    else
                    {
                            if (preg_match("/^[0-9]+$/i", $value))
                                {
                                    return preg_replace('/^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/', '($1) $2-$3', $value);
                                }
                            else
                                {
                                    $CI->form_validation->set_message('rt_cek','RT hanya boleh diisi oleh angka saja');
                                    return FALSE;
                                }
                    }
                }

            # validasi rt
            public static function rw_cek($value)
                {
                    $CI =& get_instance();
                    $value = trim($value);

                    if ($value == '') {
                            return TRUE;
                    }
                    else
                    {
                            if (preg_match("/^[0-9]+$/i", $value))
                                {
                                    return preg_replace('/^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/', '($1) $2-$3', $value);
                                }
                            else
                                {
                                    $CI->form_validation->set_message('rw_cek','RW hanya boleh diisi oleh angka saja');
                                    return FALSE;
                                }
                    }
                }

            # validasi no identitas
            public static function no_identitas_cek($value)
                {
                    $CI =& get_instance();
                    $value = trim($value);

                    
                    if (preg_match("/^[0-9]+$/i", $value))
                        {
                            return preg_replace('/^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/', '($1) $2-$3', $value);
                        }
                    else
                        {
                            $CI->form_validation->set_message('no_identitas_cek','No Identitas hanya boleh diisi oleh angka saja');
                            return FALSE;
                        }
            
                }

            # datatables lihat data jabatan
			public static function get_data_pegawai()
				{
					$CI =& get_instance();

					$list_divisi = $CI->M_pegawai->get_datatables();
					$data = array();
					$no = $_POST['start'];

					foreach($list_divisi as $field)
						{
							$no++;
							$row = array();

							$row[] = $no;
							$row[] = $field->nik;
							$row[] = $field->nama;
							$row[] = $field->jk;
							$row[] = $field->nama_jabatan;
							$row[] = $field->nama_divisi;

							$row[] = "<a href='".site_url('pegawai/edit/'.$field->id_karyawan)."' class='btn btn-xs btn-success col-md-5 text-center' title='Edit'><span class='fa fa-pencil' ></span></a> <button class='btn btn-xs btn-danger col-md-5 text-center' title='Hapus' onclick='hapus(\"".$field->id_karyawan."\")'><span class='fa fa-trash' ></span></button>";

                            $data[] = $row;
						}

					$output = array(
						'draw'				=> $_POST['draw'],
						'recordsTotal'      => $CI->M_pegawai->count_all(),
	                    'recordsFiltered'   => $CI->M_pegawai->count_filtered(),
	                    'data'              => $data,
					);

					echo json_encode($output);

				}

			# view lihat pegawai
			public static function lihat_pegawai()
				{
					$CI =& get_instance();
					# set data ke view
            		$data = array(
						'content'		=> 'kepegawaian/lihat_pegawai',
						'title_page'	=> 'Daftar Karyawan',
						'sidebar'		=> $CI->sidebar,
					);

            		# tampilkan view
					$CI->load->view('template/layout',$data);
				}

			# edit pegawai
			public static function edit($id_karyawan)
				{
					$CI =& get_instance();

					$data = array(
						'content'		=> 'kepegawaian/edit_pegawai',
						'sidebar'		=> $CI->sidebar,
						'title_page'	=> 'Edit Data Karyawan',
						'jabatan'		=> $CI->M_jabatan->tampil_jabatan(),
						'pegawai'		=> $CI->M_pegawai->tampil_pegawai(array('karyawan.id_karyawan' => $id_karyawan)),
					);

					foreach($data['pegawai'] as $dpgw)
						{
							$CI->session->set_userdata('edit_no_identitas',$dpgw->no_identitas);
						}

					$CI->load->view('template/layout',$data);
				}

			# edit data pegawai
			public static function edit_data_pegawai()
				{
					$CI =& get_instance();

					$id_pegawai = $CI->input->post('id_karyawan');

					# Config validasi inputan
					$config_validasi = array(
						array(
							'field'		=> 'no_identitas',
							'label'		=> 'No Identitas',
							'rules'		=> 'required|min_length[8]|callback_edit_no_identitas_cek',
							'errors'	=> array(
												'required'		=> 'No Identitas tidak boleh kosong',
												'min_length'	=> 'No Identitas minimal 8 karakter',
											),

						),

						array(
							'field'		=> 'nama',
							'label'		=> 'Nama',
							'rules'		=> 'required|min_length[3]',
							'errors'	=> array(
												'required'		=> 'Nama tidak boleh kosong',
												'min_length'	=> 'Nama minimal menggunakan 3 karakter',
											),
						),

						array(
							'field'		=> 'jenis_kelamin',
							'label'		=> 'Jenis Kelamin',
							'rules'		=> 'required',
							'errors'	=> array(
												'required'		=> 'Jenis Kelamin tidak boleh kosong',
											),
						),

						array(
							'field'		=> 'tempat_lahir',
							'label'		=> 'Tempat Lahir',
							'rules'		=> 'required|min_length[3]',
							'errors'	=> array(
												'required'		=> 'Tempat lahir tidak boleh kosong',
												'min_length'	=> 'Tempat lahir minimal menggunakan 3 karakter',
											),
						),

						array(
							'field'		=> 'tanggal_lahir',
							'label'		=> 'Tanggal lahir',
							'rules'		=> 'required',
							'errors'	=> array(
												'required'		=> 'Tanggal lahir tidak boleh kosong',
											),
						),

						array(
							'field'		=> 'agama',
							'label'		=> 'Agama',
							'rules'		=> 'required',
							'errors'	=> array(
												'required'		=> 'Agama tidak boleh kosong',
											),
						),

						array(
							'field'		=> 'alamat',
							'label'		=> 'Alamat',
							'rules'		=> 'required|min_length[5]|max_length[100]',
							'errors'	=> array(
												'required'		=> 'Alamat tidak boleh kosong',
												'min_length'	=> 'Alamat minimal harus 5 karakter',
												'max_length'	=> 'Alamat maksimal memiliki 100 karakter',
											),
						),

						array(
							'field'		=> 'kota',
							'label'		=> 'Kota',
							'rules'		=> 'required|min_length[3]|max_length[100]',
							'errors'	=> array(
												'required'		=> 'Kota tidak boleh kosong',
												'min_length'	=> 'Kota minimal memiliki 3 karakter',
												'maX_length'	=> 'Kota maksimal memiliki 100 karakter',
											),
						),

						array(
							'field'		=> 'kewarganegaraan',
							'label'		=> 'Kewarganegaraan',
							'rules'		=> 'required',
							'errors'	=> array(
												'required'		=> 'Kewarganegaraan tidak boleh kosong',
											),
						),

						array(
							'field'		=> 'jabatan',
							'label'		=> 'Jabatan',
							'rules'		=> 'required',
							'errors'	=> array(
												'required'		=> 'Jabatan tidak boleh kosong',
											),
						),

						array(
							'field'		=> 'no_tlp',
							'label'		=> 'No Tlp ',
							'rules'		=> 'callback_no_tlp_cek',
						),

						array(
							'field'		=> 'rt',
							'label'		=> 'RT ',
							'rules'		=> 'callback_rt_cek',
						),

						array(
							'field'		=> 'rw',
							'label'		=> 'RW ',
							'rules'		=> 'callback_rw_cek',
						),
					);

					# set validation
                    $CI->form_validation->set_rules($config_validasi);

                    if($CI->form_validation->run() == false)
                    	{
                    		$CI->session->set_flashdata('status_edit_pegawai','gagal');
                    		$CI->edit($id_pegawai);
                    	}
                    else
                    	{
                    		# ubah format tanggal lahir pegawai
                    		$tgl_lahir 		= $CI->input->post('tanggal_lahir');
                    		$pecah_tgl 		= explode('-',$tgl_lahir);
                    		$tanggal_lahir 	= $pecah_tgl[2].'-'.$pecah_tgl[1].'-'.$pecah_tgl[0]; 

                    		# set data pegawai
                    		$data_pegawai 	= array(
                    			'nik'				=> date('ymdhis'),
                    			'id_jabatan'		=> $CI->input->post('jabatan'),
                    			'no_identitas'		=> $CI->input->post('no_identitas'),
                    			'nama'				=> strtoupper($CI->input->post('nama')),
                    			'jk'				=> $CI->input->post('jenis_kelamin'),
                    			'tempat_lahir'		=> strtoupper($CI->input->post('tempat_lahir')),
                    			'tanggal_lahir'		=> $tanggal_lahir,
                    			'alamat'			=> strtoupper($CI->input->post('alamat')),
                    			'rt'				=> $CI->input->post('rt'),
                    			'rw'				=> $CI->input->post('rw'),
                    			'kecamatan'			=> strtoupper($CI->input->post('kecamatan')),
                    			'kelurahan'			=> strtoupper($CI->input->post('kelurahan')),
                    			'kota'				=> strtoupper($CI->input->post('kota')),
                    			'no_tlp'			=> $CI->input->post('no_tlp'),
                    			'agama'				=> $CI->input->post('agama'),
                    			'kewarganegaraan'	=> $CI->input->post('kewarganegaraan'),
                    			'updated_at'		=> date('Y-m-d H:i:s'),
                    		);

                    		$ubah = $CI->M_pegawai->update_pegawai($data_pegawai,array('id_karyawan' => $id_pegawai));

                    		if($ubah)
                    			{
                    				$CI->session->set_flashdata('status_edit_pegawai','berhasil');
                    				redirect(site_url('pegawai/edit/'.$id_pegawai));
                    			}
                    		else
                    			{
                    				$CI->session->set_flashdata('status_edit_pegawai','gagal');
		                    		$CI->edit($id_pegawai);
		                    	}
                    		
                    	}
				}

			# cek edit no identitas
			public static function edit_no_identitas_cek($no_identitas)
				{
					$CI =& get_instance();
					$no_identitas = trim($no_identitas);
					$no_identitas_pegawai = $CI->session->userdata('edit_no_identitas');


					if($no_identitas == $no_identitas_pegawai)
						{
							return true;
						}
					else
						{

							if (preg_match("/^[0-9]+$/i", $no_identitas))
		                        {
		                            
		                            $cek = $CI->M_pegawai->cek_no_identitas($no_identitas);
									if($cek == false)
										{
											$CI->form_validation->set_message('edit_no_identitas_cek','NO identitas sudah digunakan');
											return false;
										}
									else
										{
											return preg_replace('/^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/', '($1) $2-$3', $no_identitas);
										}
		                        }
		                    else
		                        {
		                            $CI->form_validation->set_message('no_identitas_cek','No Identitas hanya boleh diisi oleh angka saja');
		                            return FALSE;
		                        }


							
						}
				}

			# hapus data pegawai
			public static function hapus($id_karyawan)
				{
					$CI =& get_instance();

					$hapus = $CI->M_pegawai->hapus_pegawai(array('id_karyawan' => $id_karyawan));

					if($hapus)
						{
							$this->session->set_flashdata('status_hapus_pegawai', 'berhasil');
						}
					else
						{
							$this->session->set_flashdata('status_hapus_pegawai', 'gagal');
						}

					redirect(site_url('pegawai/lihat_pegawai'));
				}

			# tampiljson data pegawai
			public static function tampil_json_pegawai()
				{
					$CI =& get_instance();

					$id_karyawan = $_POST['id_karyawan'];
					$tampil = $CI->M_pegawai->tampil_pegawai(array('karyawan.id_karyawan' => $id_karyawan));
					foreach($tampil as $dp)
						{
							$data = array(
								'nama'			=> $dp->nama,
								'nik'			=> $dp->nik,
								'nama_jabatan'	=> $dp->nama_jabatan,
								'nama_divisi'	=> $dp->nama_divisi,
							);
						}

					echo json_encode($data);
				}
		}