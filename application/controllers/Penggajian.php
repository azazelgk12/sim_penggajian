<?php
	class Penggajian extends CI_Controller
		{
			private $sidebar = 'template/sidebar_keuangan';

			public function __construct()
				{
					parent::__construct();
					$this->load->model('M_penggajian');
					$this->load->model('M_jabatan');
					$this->load->model('M_pegawai');
					$this->load->model('M_absensi');
					$this->load->model('M_tunjangan');
					$this->load->model('M_divisi');

					if(empty($this->session->userdata('username')) || $this->session->userdata('jabatan') != 'STAFF AKUNTING')
						{
							redirect(site_url());
						}

				}

			public static function index()
				{
					$CI =& get_instance();

					$data = array(
						'content'		=> 'keuangan/lihat_gapok',
						'title_page'	=> 'Gaji Pokok',
						'sidebar'		=> $CI->sidebar,
					);

					$CI->load->view('template/layout',$data);
				}

			# view tambah gapok
			public static function tambah_gapok()
				{
					$CI =& get_instance();

					$data = array(
						'content'		=> 'keuangan/tambah_gapok',
						'sidebar'		=> $CI->sidebar,
						'title_page'	=> 'Tambah Gaji Pokok',
						'karyawan'		=> $CI->M_pegawai->tampil_pegawai(),
					);

					$CI->load->view('template/layout',$data);
				}

			#input data gapok
			public static function tambah_data_gapok()
				{
					$CI =& get_instance();

					$config_validasi = array(

						array(
							'field'		=> 'karyawan',
							'label'		=> 'karyawan',
							'rules'		=> 'required|is_unique[gapok.id_karyawan]',
							'errors'	=> array(
												'required'		=> 'Karyawan tidak boleh kosong',
												'is_unique'		=> 'Karyawan sudah mempunyai gaji pokok',
											),
						),

						array(
							'field'		=> 'gapok',
							'label'		=> 'gapok',
							'rules'		=> 'required',
							'errors'	=> array(
												'required'		=> 'Gaji Pokok tidak boleh kosong',
											),
						),

						array(
							'field'		=> 'jenis_pembayaran',
							'label'		=> 'Jenis Pembayaran',
							'rules'		=> 'required',
							'errors'	=> array(
												'required'		=> 'Jenis Pembayaran tidak boleh kosong',
											),
						),

					);

					# set rules
					$CI->form_validation->set_rules($config_validasi);

					# cek validasi
					if($CI->form_validation->run() == false)
						{
							$CI->session->set_flashdata('status_tambah_gapok','gagal');
							$CI->session->set_flashdata('old_gapok',$CI->input->post('gapok'));

							$data = array(
								'content'		=> 'keuangan/tambah_gapok',
								'sidebar'		=> $CI->sidebar,
								'title_page'	=> 'Tambah Gaji Pokok',
								'karyawan'		=> $CI->M_pegawai->tampil_pegawai(),
							);

							$CI->load->view('template/layout',$data);

						}
					else
						{
							$data = array(
								'id_karyawan'		=> $CI->input->post('karyawan'),
								'gaji_pokok'		=> $CI->input->post('gapok'),
								'jenis_pembayaran'	=> $CI->input->post('jenis_pembayaran'),
								'created_at'		=> date('Y-m-d H:i:s'),
							);

							$tambah = $CI->M_penggajian->tambah_gapok($data);

							if($tambah)
								{
									$CI->session->set_flashdata('status_tambah_gapok','berhasil');
									redirect(site_url('penggajian/tambah_gapok'));
								}
							else
								{
									$CI->session->set_flashdata('old_gapok',$CI->input->post('gapok'));

									$data = array(
										'content'		=> 'keuangan/tambah_gapok',
										'sidebar'		=> $CI->sidebar,
										'title_page'	=> 'Tambah Gaji Pokok',
										'karyawan'		=> $CI->M_pegawai->tampil_pegawai(),
									);

									$CI->load->view('template/layout',$data);
									$CI->session->set_flashdata('status_tambah_gapok','gagal');
								}
						}
				}

			# datatables lihat data gapok
			public static function get_data_gapok()
				{
					$CI =& get_instance();

					$list_divisi = $CI->M_penggajian->get_datatables();
					$data = array();
					$no = $_POST['start'];

					foreach($list_divisi as $field)
						{
							$no++;
							$row = array();

							$row[] = $no;
							$row[] = $field->nama;
							$row[] = 'Rp. '.number_format($field->gaji_pokok);
							$row[] = $field->jenis_pembayaran;
							$row[] = "<a href='".site_url('penggajian/edit_gapok/'.$field->id_gapok)."' class='btn btn-sm btn-success col-md-5' title='Edit'><span class='fa fa-pencil' ></span></a> <button class='btn btn-sm btn-danger col-md-5' title='Hapus' onclick='hapus(\"".$field->id_gapok."\")'><span class='fa fa-trash' ></span></button>";

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

			# halaman edit gapok
			public static function edit_gapok($id)
				{
					$CI =& get_instance();

					$data = array(
						'content'		=> 'keuangan/edit_gapok',
						'sidebar'		=> $CI->sidebar,
						'title_page'	=> 'Edit Gaji Pokok',
						'karyawan'		=> $CI->M_pegawai->tampil_pegawai(),
						'data_gapok'	=> $CI->M_penggajian->tampil_gapok(array('id_gapok'=> $id)),
					);

					foreach($data['data_gapok'] as $dg)
						{
							$CI->session->set_userdata('edit_jabatan_gapok',$dg->id_karyawan);
						}

					$CI->load->view('template/layout',$data);
				}

			# edit data gapok
			public static function edit_data_gapok()
				{
					$CI =& get_instance();

					$id = $CI->input->post('id_gapok');

					$config_validasi = array(

						array(
							'field'		=> 'karyawan',
							'label'		=> 'Karyawan',
							'rules'		=> 'required|callback_cek_edit_karyawan_gapok',
							'errors'	=> array(
												'required'		=> 'Karyawan tidak boleh kosong',
											),
						),

						array(
							'field'		=> 'gapok',
							'label'		=> 'gapok',
							'rules'		=> 'required',
							'errors'	=> array(
												'required'		=> 'Gaji Pokok tidak boleh kosong',
											),
						),

						array(
							'field'		=> 'jenis_pembayaran',
							'label'		=> 'Jenis Pembayaran',
							'rules'		=> 'required',
							'errors'	=> array(
												'required'		=> 'Jenis Pembayaran tidak boleh kosong',
											),
						),

					);

					# set rules
					$CI->form_validation->set_rules($config_validasi);

					#cek validasi
					if($CI->form_validation->run() == false)
						{
							$CI->session->set_flashdata('status_edit_gapok','gagal');
							$data = array(
								'content'		=> 'keuangan/edit_gapok',
								'sidebar'		=> $CI->sidebar,
								'title_page'	=> 'Edit Gaji Pokok',
								'karyawan'		=> $CI->M_pegawai->tampil_pegawai(),
								'data_gapok'	=> $CI->M_penggajian->tampil_gapok(array('id_gapok'=> $id)),
							);

							foreach($data['data_gapok'] as $dg)
								{
									$CI->session->set_userdata('edit_karyawan_gapok',$dg->id_karyawan);
								}

							$CI->load->view('template/layout',$data);
						}	
					else
						{
							$data = array(
								'id_karyawan'		=> $CI->input->post('karyawan'),
								'gaji_pokok'		=> $CI->input->post('gapok'),
								'jenis_pembayaran'	=> $CI->input->post('jenis_pembayaran'),
								'updated_at'		=> date('Y-m-d H:i:s'),
							);

							$ubah = $CI->M_penggajian->ubah_data_gapok(array('id_gapok'=>$id),$data);

							if($ubah)
								{
									$CI->session->set_flashdata('status_edit_gapok','berhasil');
									redirect(site_url('penggajian/edit_gapok/'.$id));
								}
							else
								{
									$CI->session->set_flashdata('status_edit_gapok','gagal');
									redirect(site_url('penggajian/edit_gapok/'.$id));
								}
						}
				}

			# cek edit jabatan gapok
			public static function cek_edit_karyawan_gapok($id)
				{
					$CI =& get_instance();

					if($id == $CI->session->userdata('edit_jabatan_gapok'))
						{
							return true;
						}
					else
						{
							$cek = $CI->M_penggajian->jumlah_data_gapok(array('gapok.id_karyawan' => $id));

							if($cek == 0)
								{
									return true;
								}
							else
								{
									$CI->form_validation->set_message('cek_edit_jabatan_gapok','Jabatan sudah memiliki gaji pokok');
									return false;
								}
						}
				}

			# hapus gapok
			public static function hapus_gapok($id)
				{
					$CI =& get_instance();

					$hapus = $CI->M_penggajian->hapus_gapok(array('id_gapok' => $id));

					if($hapus)
						{
							$CI->session->set_flashdata('status_hapus_gapok','berhasil');
							redirect(site_url('penggajian'));
						}
					else
						{
							$CI->session->set_flashdata('status_hapus_gapok','gagal');
							redirect(site_url('penggajian'));
						}
				}

			# view lihat penggajian 
			public static function lihat_penggajian()
				{
					$CI =& get_instance();

					$data = array(
						'content'		=> 'penggajian/lihat_penggajian_v2',
						'sidebar'		=> $CI->sidebar,
						'title_page'	=> 'Penggajian Karyawan',
						'jabatan'		=> $CI->M_jabatan->tampil_jabatan(),
						'divisi'		=> $CI->M_divisi->tampil_divisi(),
					);

					$CI->load->view('template/layout',$data);
				}

			# view penggajian karyawan
			public static function penggajian_karyawan()
				{
					$CI =& get_instance();

					$data = array(
						'content'		=> 'penggajian/tambah_penggajian_karyawan',
						'title_page'	=> 'Penggajian karyawan',
						'sidebar'		=> $CI->sidebar,
					);

					$CI->load->view('template/layout',$data);
				}

			# view tambah penggajian
			public static function tambah_penggajian($id_karyawan)
				{
					$CI =& get_instance();

					$data = array(
						'content'		=> 'penggajian/tambah_penggajian',
						'sidebar'		=> $CI->sidebar,
						'title_page'	=> 'Penggajian Karyawan',
						'pegawai'		=> $CI->M_pegawai->tampil_pegawai(array('karyawan.id_karyawan' => $id_karyawan)),
					);

					$CI->load->view('template/layout',$data);

				}

			#proses tambah data penggajian karyawan
			public static function tambah_data_penggajian()
				{
					$CI =& get_instance();

					$id_karyawan 		= $CI->input->post('id_karyawan');
					$tgl_awal			= $CI->input->post('tgl_awal');
					$tgl_akhir			= $CI->input->post('tgl_akhir');
					$sertakan_tunjangan = $CI->input->post('tunjangan');

					$pecahtglawal 		= explode("-",$tgl_awal);
					$pecahtglakhir		= explode("-",$tgl_akhir);

					$tanggal_awal 		= $pecahtglawal[2]."-".$pecahtglawal[1]."-".$pecahtglawal[0];
					$tanggal_akhir		= $pecahtglakhir[2]."-".$pecahtglakhir[1]."-".$pecahtglakhir[0];

					$time1 				= strtotime($tgl_awal);
					$time2 				= strtotime($tgl_akhir);

					$data_karyawan = $CI->M_pegawai->tampil_pegawai(array('id_karyawan' => $id_karyawan));

					// test
					$penggajian = $CI->M_penggajian->tampil_penggajian(array('karyawan.id_karyawan' => $id_karyawan));

					$tgl_penggajian = array();
					
					$list_pencarian = $CI->list_tanggal($tanggal_awal,$tanggal_akhir);
					foreach($penggajian as $pg)
						{
							$list = $CI->list_tanggal($pg->tgl_awal,$pg->tgl_akhir);
							foreach($list as $key => $val)
								{
									array_push($tgl_penggajian, $val);
								}
						}
					foreach($tgl_penggajian as $key => $value)
						{
							if(in_array($value, $list_pencarian))
								{
									$CI->session->set_flashdata('status_tambah_penggajian','sudah ada');
									redirect(site_url('penggajian/tambah_penggajian/'.$id_karyawan));
								}
							
						}


					
					# /test

					foreach($data_karyawan as $dk)
						{
							$divisi_karyawan = $dk->nama_divisi;
						}

					$transport_makan = $CI->M_tunjangan->tampil_transport_makan();

					foreach($transport_makan as $tm)
						{
							$transport_karyawan 	= $tm->transport;
							$uang_makan_karyawan	= $tm->uang_makan;
							$divisi_kerja 			= $tm->divisi;
						}

					if($divisi_kerja == $divisi_karyawan || $divisi_kerja == "SEMUA DIVISI")
						{
							$transport 		= $transport_karyawan;
							$uang_makan 	= $uang_makan_karyawan;
						}
					else
						{
							$transport 		= 0;
							$uang_makan 	= 0;
						}

					// echo $divisi_karyawan."<br>";
					// echo $divisi_kerja."<br";

					// exit();

					

					$config_validasi = array(

						array(
							'field'		=> 'id_karyawan',
							'label'		=> 'ID Karyawan',
							'rules'		=> 'required',
							'errors'	=> array(
												'required'		=> 'ID karyawan tidak boleh kosong'
											),
						),

						array(
							'field'		=> 'tgl_awal',
							'label'		=> 'Tanggal Awal',
							'rules'		=> 'required',
							'errors'	=> array(
												'required'		=> 'tanggal tidak boleh kosong'
											),
						),

						array(
							'field'		=> 'tgl_akhir',
							'label'		=> 'Tanggal Akhir',
							'rules'		=> 'required',
							'errors'	=> array(
												'required'		=> 'tanggal tidak boleh kosong'
											),
						),

						array(
							'field'		=> 'tunjangan',
							'label'		=> 'Tunjangan',
							'rules'		=> 'required',
							'errors'	=> array(
												'required'		=> 'Field ini tidak boleh kosong'
											),
						),



					);

					$CI->form_validation->set_rules($config_validasi);

					if($CI->form_validation->run() == false)
						{
							$CI->session->set_flashdata('status_tambah_pengajian','gagal');

							$data = array(
								'content'		=> 'penggajian/tambah_penggajian',
								'sidebar'		=> $CI->sidebar,
								'title_page'	=> 'Penggajian Karyawan',
								'pegawai'		=> $CI->M_pegawai->tampil_pegawai(array('karyawan.id_karyawan' => $id_karyawan)),
							);

							$CI->load->view('template/layout',$data);
						}
					else
						{
							
							# tampilkan jenis pembayaran gaji karyawan
							$tampil_gapok = $CI->M_penggajian->tampil_gapok(array('gapok.id_karyawan' => $id_karyawan));

							foreach($tampil_gapok as $tg)
								{
									$jenis_pembayaran = $tg->jenis_pembayaran;
								}

							# cek inputan tanggal
							if($time1 > $time2)
								{
									$CI->session->set_flashdata('status_tambah_penggajian','tanggal_salah');
									redirect(site_url('penggajian/tambah_penggajian/'.$id_karyawan));
								}
							else
								{
									# cek jenis pembayaran penggajian
							
									if($jenis_pembayaran == "perbulan")
										{
											# cek apakah rentang tanggal berada d bulan yg sama atau tidak
											

											if($pecahtglawal[1] == $pecahtglakhir[1])
												{
													# cek apakah  tanggal yg di pilih sebulan atau tidak
													$jumlah_hari = cal_days_in_month(CAL_GREGORIAN,$pecahtglawal[1],$pecahtglawal[0]);

													$selisih = ((abs(strtotime($tanggal_akhir) - strtotime($tanggal_awal))) / (60*60*24));
													$range_tanggal = $selisih +1;
													
													if($range_tanggal < $jumlah_hari)
														{
															$CI->session->set_flashdata('status_tambah_penggajian','bulan_kurang');
															redirect(site_url('penggajian/tambah_penggajian/'.$id_karyawan));
														}
													else
														{
															$potongan_keterlambatan = $CI->M_penggajian->jumlah_potongan(array(
																'karyawan.id_karyawan'	=> $id_karyawan,
																'absensi.tgl>='			=> $tanggal_awal,
																'absensi.tgl<='			=> $tanggal_akhir
															));

															foreach($potongan_keterlambatan as $pk)
																{
																	if($pk->jumlah != null)
																		{
																			$potongan = $pk->jumlah;
																		}
																	else
																		{
																			$potongan = 0;
																		}
																}

															$upah_lemburan =  $CI->M_penggajian->jumlah_lemburan(array(
																'karyawan.id_karyawan'	=> $id_karyawan,
																'absensi.tgl>='			=> $tanggal_awal,
																'absensi.tgl<='			=> $tanggal_akhir
															));

															foreach($upah_lemburan as $ul)
																{
																	if($ul->jumlah != null)
																		{
																			$upah_lembur = $ul->jumlah;
																		}
																	else
																		{
																			$upah_lembur = 0;
																		}
																}

															$data_gapok = $CI->M_penggajian->tampil_gapok(array(
																'karyawan.id_karyawan'	=> $id_karyawan
															));

															# Jumlah absensi karyawan
															$jumlah_absensi = $CI->M_absensi->jumlah_absen_karyawan(array(
																'absensi.id_karyawan'	=> $id_karyawan,
																'absensi.tgl>='			=> $tanggal_awal,
																'absensi.tgl<='			=> $tanggal_akhir,
															));

															foreach($data_gapok as $dg)
																{
																	$gapok = $dg->gaji_pokok;
																	$transport 	= $transport * $jumlah_absensi;
																	$uang_makan = $uang_makan * $jumlah_absensi;
																}

															$data_tunjangan = $CI->M_penggajian->jumlah_tunjangan(array(
																	'id_karyawan'	=> $id_karyawan
															));

															foreach($data_tunjangan as $dt)
																{
																	if($dt->jumlah != null)
																		{
																			$tunjangan = $dt->jumlah;
																		}
																	else
																		{
																			$tunjangan = 0;
																		}
																}

															$data_penggajian = array(
																'kode_penggajian'		=> 'PGJ'.date('YmdHis'),
																'id_karyawan'			=> $id_karyawan,
																'tgl'					=> date('Y-m-d'),
																'tgl_awal'				=> $tanggal_awal,
																'tgl_akhir'				=> $tanggal_akhir,
																'total_gaji'			=> $gapok,
																'total_potongan'		=> $potongan,
																'total_tunjangan'		=> $tunjangan,
																'total_lemburan'		=> $upah_lembur,
																'transport'				=> $transport,
																'uang_makan'			=> $uang_makan,
																'created_at'			=> date('Y-m-d H:i:s'),
															);

															$tambah = $CI->M_penggajian->tambah_penggajian($data_penggajian);

															if($tambah)
																{
																	$CI->session->set_flashdata('status_tambah_penggajian','berhasil');
																	redirect(site_url('penggajian/tambah_penggajian/'.$id_karyawan));
																}
															else
																{
																	$CI->session->set_flashdata('status_tambah_penggajian','gagal');
																	redirect(site_url('penggajian/tambah_penggajian/'.$id_karyawan));
																}


														}
													
												}
											else
												{
													$CI->session->set_flashdata('status_tambah_penggajian','beda_bulan_perbulan');

													redirect(site_url('penggajian/tambah_penggajian/'.$id_karyawan));
													
												}
											
										}
									else if($jenis_pembayaran == "perhari")
										{
											# selisih waktu bedasarkan tanggak yg dipilih
											$selisih = ((abs(strtotime($tanggal_akhir) - strtotime($tanggal_awal))) / (60*60*24));
											$range_tanggal = $selisih +1;

											$potongan_keterlambatan = $CI->M_penggajian->jumlah_potongan(array(
												'karyawan.id_karyawan'	=> $id_karyawan,
												'absensi.tgl>='			=> $tanggal_awal,
												'absensi.tgl<='			=> $tanggal_akhir
											));

											foreach($potongan_keterlambatan as $pk)
												{
													if($pk->jumlah != null)
														{
															$potongan = $pk->jumlah;
														}
													else
														{
															$potongan = 0;
														}
												}

											$upah_lemburan =  $CI->M_penggajian->jumlah_lemburan(array(
												'karyawan.id_karyawan'	=> $id_karyawan,
												'absensi.tgl>='			=> $tanggal_awal,
												'absensi.tgl<='			=> $tanggal_akhir
											));

											foreach($upah_lemburan as $ul)
												{
													if($ul->jumlah != null)
														{
															$upah_lembur = $ul->jumlah;
														}
													else
														{
															$upah_lembur = 0;
														}
												}

											$data_gapok = $CI->M_penggajian->tampil_gapok(array(
												'karyawan.id_karyawan'	=> $id_karyawan
											));

											# Jumlah absensi karyawan
											$jumlah_absensi = $CI->M_absensi->jumlah_absen_karyawan(array(
												'absensi.id_karyawan'	=> $id_karyawan,
												'absensi.tgl>='			=> $tanggal_awal,
												'absensi.tgl<='			=> $tanggal_akhir,
											));


											# cek gaji sesuai absensi
											foreach($data_gapok as $dg)
												{
													$gapok 		= $dg->gaji_pokok * $jumlah_absensi;
													$transport 	= $transport * $jumlah_absensi;
													$uang_makan = $uang_makan * $jumlah_absensi;
												}

											$data_tunjangan = $CI->M_penggajian->jumlah_tunjangan(array(
													'id_karyawan'	=> $id_karyawan
											));

											if($sertakan_tunjangan == "ya")
												{
													foreach($data_tunjangan as $dt)
													{
														if($dt->jumlah != null)
															{
																$tunjangan = $dt->jumlah;
															}
														else
															{
																$tunjangan = 0;
															}
													}
												}
											else
												{
													$tunjangan = 0;
												}

											$data_penggajian = array(
												'kode_penggajian'		=> 'PGJ'.date('YmdHis'),
												'id_karyawan'			=> $id_karyawan,
												'tgl'					=> date('Y-m-d'),
												'tgl_awal'				=> $tanggal_awal,
												'tgl_akhir'				=> $tanggal_akhir,
												'total_gaji'			=> $gapok,
												'total_potongan'		=> $potongan,
												'total_tunjangan'		=> $tunjangan,
												'total_lemburan'		=> $upah_lembur,
												'transport'				=> $transport,
												'uang_makan'			=> $uang_makan,
												'created_at'			=> date('Y-m-d H:i:s'),
											);

											$tambah = $CI->M_penggajian->tambah_penggajian($data_penggajian);

											if($tambah)
												{
													$CI->session->set_flashdata('status_tambah_penggajian','berhasil');
													redirect(site_url('penggajian/tambah_penggajian/'.$id_karyawan));
												}
											else
												{
													$CI->session->set_flashdata('status_tambah_penggajian','gagal');
													redirect(site_url('penggajian/tambah_penggajian/'.$id_karyawan));
												}
										}

								}
							
							
						}
				}

			# get datatables karyawan untuk menentukan penggajian
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

							$row[] = "<a href='".site_url('penggajian/tambah_penggajian/'.$field->id_karyawan)."' class='btn btn-xs btn-success col-md-12 text-center' title='Proses Penggajian'><span class='fa fa-pencil' ></span></a>";

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

			#pencarian tanggal
			public function list_tanggal($tgl1,$tgl2)
				{

				 	$tgl1 = mktime(0,0,0,date('m',strtotime($tgl1)),date('d',strtotime($tgl1))-1,date('Y',strtotime($tgl1)));
		     		$tgl1 = date('Y-m-d',$tgl1);
		     		$list = array();
				
				 
					 while(strtotime($tgl1) < strtotime($tgl2))
					 	{
					 		$tgl1 = mktime(0,0,0,date('m',strtotime($tgl1)),date('d',strtotime($tgl1))+1,date('Y',strtotime($tgl1)));
					 		$tgl1 = date('Y-m-d',$tgl1);

					 		array_push($list, $tgl1);
					 	}

					 return $list;
				}

			# datatables penggajian
			# datatables lihat data potongan_keterlambatan
			public static function get_data_penggajian()
				{
					$CI =& get_instance();

					if(!empty($CI->session->userdata('filter_penggajian')))
						{
							$where = $CI->session->userdata('filter_penggajian');
						}
					else
						{
							$where = null;
						}

					$list_penggajian = $CI->M_penggajian->get_datatables_penggajian($where);
					$data = array();
					$no = $_POST['start'];

					foreach($list_penggajian as $field)
						{
							$no++;
							$row 	= array();

							$row[] 	= $no;
							// $row[] 	= date_format(date_create($field->tgl),'d-m-Y');
							// $row[] 	= $field->kode_penggajian;
							$row[] 	= date_format(date_create($field->tgl),'d-m-Y');
							$row[] 	= date_format(date_create($field->tgl_awal),'d-m-Y')." s/d ".date_format(date_create($field->tgl_akhir),'d-m-Y');
							$row[] 	= $field->nama;
							$row[] 	= $field->nama_jabatan;
							$row[] 	= $field->nama_divisi;
							$row[]	= "<a target='_blank' href='".site_url('slip_gaji/cetak/'.$field->id_penggajian)."' class='btn btn-primary btn-sm' title='Cetak Slip Gaji'><i class='fa fa-print'></i></a>
								<a href='".site_url('penggajian/hapus_penggajian/'.$field->id_penggajian)."' class='btn btn-danger btn-sm' title='Hapus Penggajian'><i class='fa fa-trash'></i></a> ";
                            $data[] = $row;
						}

					$output = array(
						'draw'				=> $_POST['draw'],
						'recordsTotal'      => $CI->M_penggajian->count_all_penggajian(),
	                    'recordsFiltered'   => $CI->M_penggajian->count_filtered_penggajian($where),
	                    'data'              => $data,
					);
					
					echo json_encode($output);
					
					

				}
			# datatable pengajain old
			public static function get_data_penggajian_v2()
				{
					$CI =& get_instance();

					if(!empty($CI->session->userdata('filter_penggajian')))
						{
							$where = $CI->session->userdata('filter_penggajian');
						}
					else
						{
							$where = null;
						}

					$list_penggajian = $CI->M_penggajian->get_datatables_penggajian($where);
					$data = array();
					$no = $_POST['start'];

					foreach($list_penggajian as $field)
						{
							$no++;
							$row 	= array();

							$row[] 	= $no;
							$row[] 	= date_format(date_create($field->tgl),'d-m-Y');
							$row[] 	= $field->kode_penggajian;
							// $row[] 	= $field->tgl;
							$row[] 	= $field->nama;
							$row[] 	= $field->nama_jabatan;
							$row[] 	= $field->nama_divisi;
							$row[]	= "<a target='_blank' href='".site_url('slip_gaji/cetak/'.$field->id_penggajian)."' class='btn btn-primary' title='Cetak Slip Gaji'><i class='fa fa-print'></i></a> <button class='btn btn-danger' onclick='hapus(\"".$field->id_penggajian."\")' title='Hapus'><i class='fa fa-trash'></i></button>";
                            $data[] = $row;
						}

					$output = array(
						'draw'				=> $_POST['draw'],
						'recordsTotal'      => $CI->M_penggajian->count_all_penggajian(),
	                    'recordsFiltered'   => $CI->M_penggajian->count_filtered_penggajian($where),
	                    'data'              => $data,
					);
					
					echo json_encode($output);
					
					

				}

			# set filter penggajian
			
			public static function set_filter_penggajian()
				{
					$CI =& get_instance();
					$condition = array();

					$tgl_awal 	= $_POST['tgl_awal'];
					$tgl_akhir 	= $_POST['tgl_akhir'];

					if(!empty($tgl_awal) && !empty($tgl_akhir))
						{
							$pecah_tgl_awal 	= explode('-',$tgl_awal);
							$pecah_tgl_akhir	= explode('-',$tgl_akhir);

							if($pecah_tgl_awal[1] == $pecah_tgl_akhir[1])
								{
									switch($pecah_tgl_awal[1])
										{
											case '01'	: $bln = 'Januari'; 	break;
											case '02'	: $bln = 'Februari'; 	break;
											case '03'	: $bln = 'Maret'; 		break;
											case '04'	: $bln = 'April'; 		break;
											case '05'	: $bln = 'Mei'; 		break;
											case '06'	: $bln = 'Juni'; 		break;
											case '07'	: $bln = 'Juli'; 		break;
											case '08'	: $bln = 'Agustus'; 	break;
											case '09'	: $bln = 'September'; 	break;
											case '10'	: $bln = 'Oktober'; 	break;
											case '11'	: $bln = 'November'; 	break;
											case '12'	: $bln = 'Desember'; 	break;
											default 	: $bln = '';			break;
										}
									$CI->session->set_userdata('title_laporan','Penggajian Bulan ; '.$bln);
								}
							else
								{
									$CI->session->set_userdata('title_laporan','Penggajian Periode ; '.$tgl_awal.' s/d '.$tgl_akhir);
								}
						}
					else
						{
							$CI->session->set_userdata('title_laporan','');
						}


					$data_cari_penggajian = array(
						'penggajian_karyawan.tgl' 		=> $_POST['data_tanggal'],
						'karyawan.nama='				=> "'".$_POST['karyawan']."'",
						'jabatan.id_jabatan='			=> "'".$_POST['jabatan']."'",
						'divisi.id_divisi='				=> "'".$_POST['divisi']."'",
					);
					$data_cari = array(
						
						'karyawan.nama='				=> "'".$_POST['karyawan']."'",
						'jabatan.id_jabatan='			=> "'".$_POST['jabatan']."'",
						'divisi.id_divisi='				=> "'".$_POST['divisi']."'",
					);

					foreach($data_cari_penggajian as $dc => $val)
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

					$CI->session->set_userdata('filter_penggajian',$where);

					print_r($condition);
					
				}
			# reset filter penggajian
			public static function reset_filter_penggajian()
				{
					$CI =& get_instance();

					$CI->session->unset_userdata('filter_penggajian');
				}

			# hapus penggajian
			public static function hapus_penggajian($id)
				{
					$CI =& get_instance();

					$hapus = $CI->M_penggajian->hapus_penggajian(array('id_penggajian' => $id));

					if($hapus)
						{
							$CI->session->set_flashdata('status_hapus_penggajian','berhasil');
							redirect(site_url('penggajian/lihat_penggajian'));
						}
					else
						{
							$CI->session->set_flashdata('status_hapus_penggajian','gagal');
							redirect(site_url('penggajian/lihat_penggajian'));
						}


				}

			# testing
			public static function tes()
				{
					// $bulan = date('m');
					// $tahun = date('Y');

					// $kalender = '';

					// $hari = cal_days_in_month(CAL_GREGORIAN,$bulan,$tahun);

					// echo $hari." hari";
				 $tgl1 = '2018-07-01';
				 $tgl1 = mktime(0,0,0,date('m',strtotime($tgl1)),date('d',strtotime($tgl1))-1,date('Y',strtotime($tgl1)));
				 		$tgl1 = date('Y-m-d',$tgl1);
				 $tgl2 = '2018-08-31';

				 // $tanggal1 = new DateTime($tgl1);
				 // $tanggal2 = new DateTime($tgl2);
				 $selisih = ((abs(strtotime($tgl2) - strtotime($tgl1))) / (60*60*24));

				 // echo $selisih + 1;
				 
				 while(strtotime($tgl1) < strtotime($tgl2))
				 	{
				 		$tgl1 = mktime(0,0,0,date('m',strtotime($tgl1)),date('d',strtotime($tgl1))+1,date('Y',strtotime($tgl1)));
				 		$tgl1 = date('Y-m-d',$tgl1);

				 		echo $tgl1."<br>";
				 	}
				}
			# testing pengajian
			public static function testing_data()
				{
					$CI =& get_instance();
					$penggajian = $CI->M_penggajian->tampil_penggajian_karyawan();

					var_dump($penggajian);
				}

			#testingpenentuan hari sabtu
			public static function tes_sabtu()
				{
					$CI =& get_instance();
					$tgl = date('Y-m-d');

					$tanggal = substr($tgl,8,2);
					$bulan 		= substr($tgl,5,2);
					$tahun		= substr($tgl,0,4);

					$info = date('w',mktime(0,0,0,$bulan,$tanggal,$tahun));

					switch($info)
						{
							case '0'	: echo "Minggu"; break;
							case '1'	: echo "Senin"; break;
							case '2'	: echo "Selasa"; break;
							case '3'	: echo "Rabu"; break;
							case '4'	: echo "Kamis"; break;
							case '5'	: echo "Jum'at"; break;
							case '6'	: echo "Sabtu"; break;
						}
				}

			# proses penggajian karyawan v2
			public static function tambah_penggajian_karyawan()
				{
					$CI =& get_instance();

					$response = array();

					# inputan tanggal penggajian
					$tgl_awal			= @$CI->input->post('tgl_awal');
					$tgl_akhir			= @$CI->input->post('tgl_akhir');

					
					if(!empty($tgl_awal) && $tgl_awal != null && !empty($tgl_akhir) && $tgl_akhir != null)
						{

							# merubah format inputan tanggal menjadi Y-m-d
							$tanggal_awal 		= date_format(date_create($tgl_awal),'Y-m-d');
							$tanggal_akhir		= date_format(date_create($tgl_akhir),'Y-m-d');

							$time1 				= strtotime($tgl_awal);
							$time2 				= strtotime($tgl_akhir);

							# cek apakah tanggal awal lebih kecil dari tanggal akhir
							if($time1 > $time2)
								{
									$CI->session->set_flashdata('status_tambah_penggajian','tanggal_salah');
											redirect(site_url('penggajian/penggajian_karyawan'));
								}
							else
								{
									# Data pegawai yang akan dilakukan penggajian
									$data_pegawai = array();
									# data tanggal
									$data_tanggal = array();
									# list tanggal sesuai range tanggal yang dipilih
									$list_tanggal = $CI->list_tanggal($tanggal_awal,$tanggal_akhir);
									

									# data penggajian
									$data_penggajian = array();

									# cari pegawai yang sudah dilakukan penggajian pada tanggal yang sudah dipilih
									
									# Tampilkan data absensi 
									# berdasarkan tanggal yang telah dipilih
									
									$tampil_absensi = $CI->M_penggajian->tampil_absen_gaji(array(
															'tgl_absen >=' 	=>$tanggal_awal,
															'tgl_absen <='	=> $tanggal_akhir,
														))->get()->result();
									// print_r($tampil_absensi);exit;

									# cari absensi karyawan berdasarkan tanggal yang diinput
									foreach($tampil_absensi as $ta)
										{
											if(!in_array($ta->id_karyawan,$data_pegawai))
												{

													array_push($data_pegawai,$ta->id_karyawan);
												}
										}

									# cek jumlah data pengajian 
									# apakah ada penggajian yang sudah dilakukan
									# diantara tanggal yang dipilih
									
									
									
									# --Metode pembayaran gaji--
									# lakukan pengecekan untuk pennggajian
									# jika range waktu adalah satu bulan 
									# maka lakukan inputan penggajian untuk 
									# karyawan yang metode penggajian nya bulanan  & tunjangan
									# dan tunjangan karyawan yang metode penggajian nya perhari
									
									# -- metode perhitungan gaji --
									# penggajian dihitung berdasarkan absensi yang telah dilakukan
									# untuk metode pembayaran gaji harian dihitung berdasarkan jumlah absensi
									# untuk metode pembayaran gaji bulanan 
									# jika jumlah absen kurang dari 24 hari
									# maka perhitungan dilakukan dari gaji bulanan dibagi jumlah absen
									# jika lebih dari 24 hari maka gaji full sebulan
									$data_gaji = array();
									$data_gaji_kar = array();
									foreach($tampil_absensi as $abs)
										{
											# data karyawan
											$data_karyawan = $CI->M_pegawai->tampil_pegawai(array('id_karyawan' => $abs->id_karyawan));


											
											foreach($data_karyawan as $dk)
												{
													$divisi_karyawan = $dk->nama_divisi;
												}


											# uang transport dan makan
											$transport_makan = $CI->M_tunjangan->tampil_transport_makan();
											


											foreach($transport_makan as $tm)
												{
													$transport_karyawan 	= $tm->transport;
													$uang_makan_karyawan	= $tm->uang_makan;
													$divisi_kerja 			= $tm->divisi;
												}

											if($divisi_kerja == $divisi_karyawan || $divisi_kerja == "SEMUA DIVISI")
												{
													$transport 		= $transport_karyawan;
													$uang_makan 	= $uang_makan_karyawan;
												}
											else
												{
													$transport 		= 0;
													$uang_makan 	= 0;
												}

											



											
											// echo $abs->id_karyawan.'<br>';
											# cek apakah karyawan sudah dilakukan proses penggajian atau belum
											if(!in_array($abs->id_karyawan, $data_gaji_kar))
												{
													# input pegawai ke data gaji 
													# untuk pengecekan apakah karyawan sudah di lakukan
													# proses penggajian atau belum
													array_push($data_gaji_kar, $abs->id_karyawan);


													# cek apakah karyawan ada di data penggajian atau tidak
													$jumlah_data_penggajian = $CI->M_penggajian->tampil_gaji_karyawan(
															"id_karyawan='".$abs->id_karyawan."' AND (tgl_awal BETWEEN '".$tanggal_awal."' AND '".$tanggal_akhir."' OR tgl_akhir BETWEEN '".$tanggal_awal."' AND '".$tanggal_akhir."')"
														)->order_by('tgl_akhir','desc')->count_all_results();
													
													if($jumlah_data_penggajian != 0)
														{

															# tampil gapok karyawan
															$jumlah_gapok = $CI->M_penggajian->tampil_gapok(
																array(
																	'gapok.id_karyawan'	=> $abs->id_karyawan,
																)
															);



															foreach($jumlah_gapok as $jg)
																{
																	$metode_pembayaran = $jg->jenis_pembayaran;
																	$gapok 			   = $jg->gaji_pokok;

																}

															# metode pembayaran perbulan tidak di cek
															# karena jika ada dalam tanggal yang dipilih
															# maka pembayaran perbulan sudah ada
															if($metode_pembayaran == 'perhari')
																{
																	# tentukamn tanggal terakhir karyawan mendapatkan gaji
																	$tgl_akhir_penggajian = $CI->M_penggajian->tampil_gaji_karyawan(
																		"id_karyawan='".$abs->id_karyawan."' AND (tgl_awal BETWEEN '".$tanggal_awal."' AND '".$tanggal_akhir."' OR tgl_akhir BETWEEN '".$tanggal_awal."' AND '".$tanggal_akhir."')"
																	)->order_by('tgl_akhir','desc')->limit(1)->get()->result();

																	// echo $CI->db->last_query();exit;
																	# set tanggal terakhir karyawan mendapatkan gaji
																	foreach($tgl_akhir_penggajian as $takhir)
																		{
																			$tgl_terakhir = $takhir->tgl_akhir;
																		}

																	# cek jumlah absensi karyawan
																	$jumlah_absensi = $CI->M_penggajian->tampil_absen_gaji(array(
																			'id_karyawan'	=> $abs->id_karyawan,
																			'tgl_absen >' 	=> $tgl_terakhir,
																			'tgl_absen <='	=> $tanggal_akhir,
																		))->count_all_results();



																	$gapok_karyawan 	= $gapok * $jumlah_absensi;
																	$jumlah_uang_makan 	= $uang_makan * $jumlah_absensi;
																	$jumlah_transport	= $transport * $jumlah_absensi;
																	
																	$jumlah_tunjangan = $CI->jumlah_tunjangan_harian($tgl_terakhir,$tanggal_akhir,$abs->id_karyawan);

																	if($abs->tgl_absen > $tgl_terakhir)
																		{
																			$upah_lemburan =  $CI->M_penggajian->jumlah_lemburan(array(
																				'karyawan.id_karyawan'	=> $abs->id_karyawan,
																				'absensi.tgl>'			=> $tgl_terakhir,
																				'absensi.tgl<='			=> $tanggal_akhir
																			));

																			foreach($upah_lemburan as $ul)
																				{
																					if($ul->jumlah != null)
																						{
																							$upah_lembur = $ul->jumlah;
																						}
																					else
																						{
																							$upah_lembur = 0;
																						}
																				}

																			$potongan_keterlambatan = $CI->M_penggajian->jumlah_potongan(array(
																				'karyawan.id_karyawan'	=> $abs->id_karyawan,
																				'absensi.tgl>'			=> $tgl_terakhir,
																				'absensi.tgl<='			=> $tanggal_akhir
																			));

																			foreach($potongan_keterlambatan as $pk)
																				{
																					if($pk->jumlah != null)
																						{
																							$potongan = $pk->jumlah;
																						}
																					else
																						{
																							$potongan = 0;
																						}
																				}
																			$data_gaji[$abs->id_karyawan]['tgl'] 			= date('Y-m-d');
																			$data_gaji[$abs->id_karyawan]['tgl_awal'] 		= $tanggal_awal;
																			$data_gaji[$abs->id_karyawan]['tgl_akhir'] 		= $tanggal_akhir;
																			$data_gaji[$abs->id_karyawan]['id_karyawan'] 	= $abs->id_karyawan;
																			$data_gaji[$abs->id_karyawan]['total_gaji'] 	= $gapok_karyawan;
																			$data_gaji[$abs->id_karyawan]['total_lemburan'] = $upah_lembur;
																			$data_gaji[$abs->id_karyawan]['total_potongan'] = $potongan;
																			$data_gaji[$abs->id_karyawan]['transport']		= $jumlah_transport;
																			$data_gaji[$abs->id_karyawan]['uang_makan']		= $jumlah_uang_makan;
																			$data_gaji[$abs->id_karyawan]['total_tunjangan'] = $jumlah_tunjangan;
																		}

																}


															
															
														}
													else
														{
															# tampil gapok karyawan
															$jumlah_gapok = $CI->M_penggajian->tampil_gapok(
																array(
																	'gapok.id_karyawan'	=> $abs->id_karyawan,
																)
															);



															foreach($jumlah_gapok as $jg)
																{
																	$metode_pembayaran = $jg->jenis_pembayaran;
																	$gapok 			   = $jg->gaji_pokok;

																}

															if($metode_pembayaran == 'perbulan')
																{
																	# cek apakah tgl yang dipilih 
																	# ada di bulan dan tahun yang sama
																	# (untuk penggajian metode perbulan)
																	$rentang_awal 		= date_format(date_create($tgl_awal),'Y-m');
																	$rentang_akhir		= date_format(date_create($tgl_akhir),'Y-m');
																	
																	if($rentang_awal == $rentang_akhir)
																		{
																			# cek jumlah absensi karyawan
																			$jumlah_absensi = $CI->M_penggajian->tampil_absen_gaji(array(
																					'id_karyawan'	=> $abs->id_karyawan,
																					'tgl_absen >=' 	=> $tgl_awal,
																					'tgl_absen <='	=> $tanggal_akhir,
																				))->count_all_results();

																			$jumlah_uang_makan 	= $uang_makan * $jumlah_absensi;
																			$jumlah_transport	= $transport * $jumlah_absensi;

																			$tahun_rentang = date_format(date_create($tgl_awal),'Y');
																			$bulan_rentang = date_format(date_create($tgl_awal),'m');

																			# cek apakah  tanggal yg di pilih sebulan atau tidak
																			# 
																			# cek jumlah hari dalam sebulan sesuai 
																			# tanggal yang dipilih
																			$jumlah_hari = cal_days_in_month(CAL_GREGORIAN,$bulan_rentang,$tahun_rentang);

																			# cek seslisih hari yang tanggal yang dipilih
																			$selisih = ((abs(strtotime($tanggal_akhir) - strtotime($tanggal_awal))) / (60*60*24));
																			$range_tanggal = $selisih +1;
																			
																			# jika absen lebih dari 24 hari 
																			# maka gaji full
																			if($jumlah_absensi > 24)
																				{
																					$gapok_karyawan = $gapok;
																				}
																			else
																				{
																					$gapok_karyawan = round(($gapok/$jumlah_hari) * $jumlah_absensi);
																				}

																			if($range_tanggal == $jumlah_hari)
																				{
																					$upah_lemburan =  $CI->M_penggajian->jumlah_lemburan(array(
																						'karyawan.id_karyawan'	=> $abs->id_karyawan,
																						'absensi.tgl>'			=> $tanggal_awal,
																						'absensi.tgl<='			=> $tanggal_akhir
																					));

																					# tunjangan _karyawan
																					$data_tunjangan = $CI->M_penggajian->jumlah_tunjangan(array(
																							'id_karyawan'	=> $abs->id_karyawan
																					));



																					foreach($data_tunjangan as $dt)
																						{
																							if($dt->jumlah != null)
																								{
																									$tunjangan = $dt->jumlah;
																								}
																							else
																								{
																									$tunjangan = 0;
																								}
																						}
																					$jumlah_tunjangan = $CI->jumlah_tunjangan_harian($tanggal_awal,$tanggal_akhir,$abs->id_karyawan);

																					#upah lemburan

																					foreach($upah_lemburan as $ul)
																						{
																							if($ul->jumlah != null)
																								{
																									$upah_lembur = $ul->jumlah;
																								}
																							else
																								{
																									$upah_lembur = 0;
																								}
																						}

																					$potongan_keterlambatan = $CI->M_penggajian->jumlah_potongan(array(
																						'karyawan.id_karyawan'	=> $abs->id_karyawan,
																						'absensi.tgl>'			=> $tanggal_awal,
																						'absensi.tgl<='			=> $tanggal_akhir
																					));

																					foreach($potongan_keterlambatan as $pk)
																						{
																							if($pk->jumlah != null)
																								{
																									$potongan = $pk->jumlah;
																								}
																							else
																								{
																									$potongan = 0;
																								}
																						}
																					$data_gaji[$abs->id_karyawan]['tgl'] 				= date('Y-m-d');
																					$data_gaji[$abs->id_karyawan]['tgl_awal'] 			= $tanggal_awal;
																					$data_gaji[$abs->id_karyawan]['tgl_akhir'] 			= $tanggal_akhir;
																					$data_gaji[$abs->id_karyawan]['id_karyawan'] 		= $abs->id_karyawan;
																					$data_gaji[$abs->id_karyawan]['total_gaji'] 		= $gapok_karyawan;
																					$data_gaji[$abs->id_karyawan]['total_lemburan'] 	= $upah_lembur;
																					$data_gaji[$abs->id_karyawan]['total_potongan'] 	= $potongan;
																					$data_gaji[$abs->id_karyawan]['transport']			= $jumlah_transport;
																					$data_gaji[$abs->id_karyawan]['uang_makan']			= $jumlah_uang_makan;
																					$data_gaji[$abs->id_karyawan]['total_tunjangan']	= $tunjangan;
																					$data_gaji[$abs->id_karyawan]['total_tunjangan'] = $jumlah_tunjangan;
																				}

																			

																		}
																}
															else if($metode_pembayaran == 'perhari')
																{
																	# tentukamn tanggal terakhir karyawan mendapatkan gaji
																	$tgl_akhir_penggajian = $CI->M_penggajian->tampil_gaji_karyawan(
																		"id_karyawan='".$abs->id_karyawan."' AND (tgl_akhir BETWEEN '".$tanggal_awal."' AND '".$tanggal_akhir."')"
																	)->order_by('tgl_akhir','desc')->limit(1)->get()->result();

																	$jumlah_tunjangan = $CI->jumlah_tunjangan_harian($tgl_awal,$tanggal_akhir,$abs->id_karyawan);

																	# set tanggal terakhir karyawan mendapatkan gaji
																	foreach($tgl_akhir_penggajian as $takhir)
																		{
																			$tgl_terakhir = $takhir->tgl_akhir;
																		}

																	# cek jumlah absensi karyawan
																	$jumlah_absensi = $CI->M_penggajian->tampil_absen_gaji(array(
																			'id_karyawan'	=> $abs->id_karyawan,
																			'tgl_absen >=' 	=> $tanggal_awal,
																			'tgl_absen <='	=> $tanggal_akhir,
																		))->count_all_results();

																	$jumlah_uang_makan 	= $uang_makan * $jumlah_absensi;
																	$jumlah_transport	= $transport * $jumlah_absensi;

																	$upah_lemburan =  $CI->M_penggajian->jumlah_lemburan(array(
																		'karyawan.id_karyawan'	=> $abs->id_karyawan,
																		'absensi.tgl>'			=> $tanggal_awal,
																		'absensi.tgl<='			=> $tanggal_akhir
																	));

																	foreach($upah_lemburan as $ul)
																		{
																			if($ul->jumlah != null)
																				{
																					$upah_lembur = $ul->jumlah;
																				}
																			else
																				{
																					$upah_lembur = 0;
																				}
																		}

																	$potongan_keterlambatan = $CI->M_penggajian->jumlah_potongan(array(
																		'karyawan.id_karyawan'	=> $abs->id_karyawan,
																		'absensi.tgl>'			=> $tanggal_awal,
																		'absensi.tgl<='			=> $tanggal_akhir
																	));

																	foreach($potongan_keterlambatan as $pk)
																		{
																			if($pk->jumlah != null)
																				{
																					$potongan = $pk->jumlah;
																				}
																			else
																				{
																					$potongan = 0;
																				}
																		}

																	$gapok_karyawan = $gapok * $jumlah_absensi;
																	$data_gaji[$abs->id_karyawan]['tgl'] 			= date('Y-m-d');
																	$data_gaji[$abs->id_karyawan]['tgl_awal'] 		= $tanggal_awal;
																	$data_gaji[$abs->id_karyawan]['tgl_akhir'] 		= $tanggal_akhir;
																	$data_gaji[$abs->id_karyawan]['id_karyawan'] 	= $abs->id_karyawan;
																	$data_gaji[$abs->id_karyawan]['total_gaji'] 	= $gapok_karyawan;
																	$data_gaji[$abs->id_karyawan]['total_lemburan'] = $upah_lembur;
																	$data_gaji[$abs->id_karyawan]['total_potongan'] = $potongan;
																	$data_gaji[$abs->id_karyawan]['transport']		= $jumlah_transport;
																	$data_gaji[$abs->id_karyawan]['uang_makan']		= $jumlah_uang_makan;
																	$data_gaji[$abs->id_karyawan]['total_tunjangan'] = $jumlah_tunjangan;

																}
														}
												}
										}
									
									

									if(empty($data_gaji))
										{
											$CI->session->set_flashdata('status_tambah_penggajian','data_kosong');
											redirect(site_url('penggajian/penggajian_karyawan'));
										}
									else
										{
											$CI->db->trans_start();

											foreach($data_gaji as $dg =>$v)
												{
													$CI->M_penggajian->tambah_penggajian($v);
													// $CI->M_penggajian->testing($v);
												}
											
											$CI->db->trans_complete();

											if($CI->db->trans_status() == false)
												{
													$CI->session->set_flashdata('status_tambah_penggajian','gagal');
													redirect(site_url('penggajian/penggajian_karyawan'));
												}
											else
												{
													$CI->session->set_flashdata('status_tambah_penggajian','berhasil');
													redirect(site_url('penggajian/penggajian_karyawan'));
												}
										}
								
								}


						}
					else
						{
							$CI->session->set_flashdata('status_tambah_penggajian','tanggal_kosong');
							redirect(site_url('penggajian/penggajian_karyawan'));
						}

					


					
				}

			# tampil uang transport dan uang makan
			public function uang_transport_makan()
				{
					$CI =& get_instance();

					$data = $CI->M_tunjangan->tampil_transport_makan();

					return $data;
				}

			# cari tgl untuk pegawai harian untuk mendapatkan tunjangan
			public static function jumlah_tunjangan_harian($tgl_awal,$tgl_akhir,$id_karyawan)
				{
					$CI =& get_instance();

					# cek apakah ada tgl di akhir bulan atau tidak
					$list_tanggal 			= $CI->list_tanggal($tgl_awal,$tgl_akhir);

					$rentang_awal 			= date_format(date_create($tgl_awal),'Y-m');
					$rentang_akhir			= date_format(date_create($tgl_akhir),'Y-m');

					$bulan_awal 			= date_format(date_create($tgl_awal),'m');
					$tahun_awal 			= date_format(date_create($tgl_awal),'Y');

					$bulan_akhir 			= date_format(date_create($tgl_akhir),'m');
					$tahun_akhir 			= date_format(date_create($tgl_awal),'Y');

					$jumlah_hari_tgl_awal	= cal_days_in_month(CAL_GREGORIAN,$bulan_awal,$bulan_awal);
					$jumlah_hari_tgl_akhir	= cal_days_in_month(CAL_GREGORIAN,$bulan_akhir,$bulan_akhir);

					$akhir_bulan_awal		= $tahun_awal."-".$bulan_awal."-".$jumlah_hari_tgl_awal;
					$akhir_bulan_akhir		= $tahun_akhir."-".$bulan_akhir."-".$jumlah_hari_tgl_akhir;

					$jumlah_tunjangan 		= 0;

				
					if(in_array($akhir_bulan_awal,$list_tanggal))
						{
							# tunjangan _karyawan
							$data_tunjangan = $CI->M_penggajian->jumlah_tunjangan(array(
									'id_karyawan'	=> $id_karyawan
							));

							foreach($data_tunjangan as $dt)
								{
									if($dt->jumlah != null)
										{
											$jumlah_tunjangan += $dt->jumlah;
										}
									else
										{
											$jumlah_tunjangan += 0;
										}
								}
						}

						
					if($rentang_awal != $rentang_akhir)
						{
							# cek jumlah absensi karyawan
							$jumlah_absensi = $CI->M_penggajian->tampil_absen_gaji(array(
									'id_karyawan'	=> $id_karyawan,
									'tgl_absen >' 	=> $rentang_akhir."-01",
									'tgl_absen <='	=> $tgl_akhir,
								))->count_all_results();
							
							
							if($jumlah_absensi > 0)
								{
									if(in_array($akhir_bulan_akhir,$list_tanggal))
										{
											$jumlah_tunjangan = $jumlah_tunjangan * 2;
										}
									
								}
							
							

							
						}
					

					return $jumlah_tunjangan;


					
				}

			
		}
