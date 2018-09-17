<?php 
	class Absensi extends CI_Controller
		{
			private $sidebar = 'template/sidebar_kepegawaian';

			public function __construct()
				{
					parent::__construct();
					$this->load->model('M_absensi');
					$this->load->model('M_pegawai');
					$this->load->model('M_keterlambatan');
					$this->load->model('M_penggajian');

					if(empty($this->session->userdata('username')) || $this->session->userdata('jabatan') != 'STAFF ADMINISTRASI')
						{
							redirect(site_url());
						}
				}

			public static function index()
				{
					
				}

			# view jam kerja
			public static function jam_kerja()
				{
					$CI =& get_instance();

					$data = array(
						'sidebar'		=> $CI->sidebar,
					);

					$cek_data_shift_kerja = $CI->M_absensi->cek_jam_kerja();
					if($cek_data_shift_kerja == 0)
						{
							$data['content']	= 'absensi/tambah_jam_kerja';
							$data['title_page']	= 'Tambah Jam kerja';
						}	
					else
						{
							$data['content']	= 'absensi/lihat_jam_kerja';
							$data['title_page']	= 'Jam kerja';
							$data['jam_kerja']	= $CI->M_absensi->tampil_jam_kerja();
						}

					$CI->load->view('template/layout',$data);
				}

			
			# tambah data jam kerja
			public static function tambah_data_jam_kerja()
				{
					$CI =& get_instance();

					$config_validasi = array(

						array(
							'field'		=>'jam_masuk',
							'label'		=> 'Jam Masuk',
							'rules'		=> 'required|min_length[5]|max_length[5]|callback_cek_jam',
							'errors'	=> array(
												'required'		=> 'Jam tidak boleh kosong',
												'min_length'	=> 'Format jam salah',
												'max_length'	=> 'Format jam salah'
											),
						),

						array(
							'field'		=>'jam_pulang',
							'label'		=> 'Jam Pulang',
							'rules'		=> 'required|min_length[5]|max_length[5]|callback_cek_jam',
							'errors'	=> array(
												'required'		=> 'Jam tidak boleh kosong',
												'min_length'	=> 'Format jam salah',
												'max_length'	=> 'Format jam salah'
											),
						),
					);

					$CI->form_validation->set_rules($config_validasi);

					if($CI->form_validation->run() == false)
						{
							$CI->session->set_flashdata('status_tambah_jam_kerja','gagal');


							# set data view
							$data = array(
								'content'		=> 'absensi/tambah_jam_kerja',
								'title_page'	=> 'Tambah Jam Kerja',
								'sidebar'		=> $CI->sidebar,

							);

							# kembalikan ke halaman tambah divisi
							$CI->load->view('template/layout',$data);
						}
					else
						{
							$data_jam_kerja = array(
								'jam_masuk'		=> $CI->input->post('jam_masuk').':00',
								'jam_pulang'	=> $CI->input->post('jam_pulang').':00',
								'created_at'	=> date('Y-m-d H:i:s'),
							);

							if($data_jam_kerja['jam_masuk'] == $data_jam_kerja['jam_pulang'] || $data_jam_kerja['jam_masuk'] > $data_jam_kerja['jam_pulang'])
								{
									$CI->session->set_flashdata('selisih_jam_kerja','Jam kerja tidak bolah sama atau tidak boleh lebih besar dari jam pulang');


									# set data view
									$data = array(
										'content'		=> 'absensi/tambah_jam_kerja',
										'title_page'	=> 'Tambah Jam Kerja',
										'sidebar'		=> $CI->sidebar,

									);

									# kembalikan ke halaman tambah divisi
									$CI->load->view('template/layout',$data);
								}
							else
								{
									$tambah = $CI->M_absensi->tambah_jam_kerja($data_jam_kerja);

									if($tambah)
										{
											$CI->session->set_flashdata('status_tambah_jam_kerja','berhasil');
											redirect(site_url('absensi/jam_kerja'));

										}
									else
										{
											$CI->session->set_flashdata('status_tambah_jam_kerja','gagal');
											$CI->jam_kerja();
										}	
								}

							
						}
				}


			# cek jam
			public static function cek_jam($str)
				{
					$CI =& get_instance();

					if($str == "" || $str == null)
						{
							$CI->form_validation->set_message('cek_jam','Format Jam salah');
									return false;
						}
					else
						{
							list($hh,$mm) = explode(':',$str);

							if(!is_numeric($hh) || !is_numeric($mm))
								{
									$CI->form_validation->set_message('cek_jam','Format Jam salah');
									return false;
								}
							else if($hh > 232 || $mm > 59)
								{
									$CI->form_validation->set_message('cek_jam','Format Jam salah');
									return false;
								}
							else
								{
									return true;
								}
						}
				}

			# view edit jam kerja
			public static function edit_jam_kerja($id)
				{
					$CI =& get_instance();

					$data = array(
						'content'		=> 'absensi/edit_jam_kerja',
						'sidebar'		=> $CI->sidebar,
						'title_page'	=> 'Edit Jam Kerja',
						'jam_kerja'		=> $CI->M_absensi->tampil_jam_kerja(array('id_shift' => $id)),
					);

					$CI->load->view('template/layout',$data);
				}

			# edit data jam kerja
			public static function edit_data_jam_kerja()
				{
					$CI =& get_instance();

					$id_shift = $CI->input->post('id_shift');

					$config_validasi = array(

						array(
							'field'		=>'jam_masuk',
							'label'		=> 'Jam Masuk',
							'rules'		=> 'required|min_length[5]|max_length[5]|callback_cek_jam',
							'errors'	=> array(
												'required'		=> 'Jam tidak boleh kosong',
												'min_length'	=> 'Format jam salah',
												'max_length'	=> 'Format jam salah'
											),
						),

						array(
							'field'		=>'jam_pulang',
							'label'		=> 'Jam Pulang',
							'rules'		=> 'required|min_length[5]|max_length[5]|callback_cek_jam',
							'errors'	=> array(
												'required'		=> 'Jam tidak boleh kosong',
												'min_length'	=> 'Format jam salah',
												'max_length'	=> 'Format jam salah'
											),
						),
					);

					$CI->form_validation->set_rules($config_validasi);

					if($CI->form_validation->run() == false)
						{
							$CI->session->set_flashdata('status_edit_jam_kerja','gagal');


							$CI->edit($id_shift);
						}
					else
						{
							$data_jam_kerja = array(
								'jam_masuk'		=> $CI->input->post('jam_masuk').':00',
								'jam_pulang'	=> $CI->input->post('jam_pulang').':00',
								'updated_at'	=> date('Y-m-d H:i:s'),
							);

							if($data_jam_kerja['jam_masuk'] == $data_jam_kerja['jam_pulang'] || $data_jam_kerja['jam_masuk'] > $data_jam_kerja['jam_pulang'])
								{
									$CI->session->set_flashdata('selisih_jam_kerja','Jam kerja tidak bolah sama atau tidak boleh lebih besar dari jam pulang');


									$CI->edit_jam_kerja($id_shift);
								}
							else
								{
									$update = $CI->M_absensi->update_jam_kerja($data_jam_kerja,array('id_shift' => $id_shift));

									if($update)
										{
											$CI->session->set_flashdata('status_edit_jam_kerja','berhasil');
											redirect(site_url('absensi/jam_kerja'));

										}
									else
										{
											$CI->session->set_flashdata('status_edit_jam_kerja','gagal');
											$CI->edit_jam_kerja($id_shift);
										}	
								}

							
						}
				}

			# hapus jam kerja
			public static function hapus_jam_kerja($id)
				{
					$CI =& get_instance();

					$hapus = $CI->M_absensi->hapus_jam_kerja(array('id_shift' => $id));

					if($hapus)
						{
							$CI->session->set_flashdata('status_hapus_jam_kerja','berhasil');
							redirect(site_url('absensi/jam_kerja'));
						}
					else
						{
							$CI->session->set_flashdata('status_hapus_jam_kerja','gagal');
							redirect(site_url('absensi/jam_kerja'));
						}
				}

			# view lihat absensi kerja karyawan
			public static function lihat_absen_karyawan()
				{
					$CI =& get_instance();

					$data = array(
						'content'		=> 'absensi/lihat_absen_karyawan',
						'sidebar'		=> $CI->sidebar,
						'title_page'	=> 'Absensi Karyawan',
					);

					$CI->load->view('template/layout',$data);
				}

			# get data karyawan yg memiliki absen masuk dan absen keluar
			public static function get_data_absen_karyawan()
				{
					$CI =& get_instance();

					if(!empty($CI->session->userdata('filter_absen_karyawan')))
						{
							$where = $CI->session->userdata('filter_absen_karyawan');
						}
					else
						{
							$where = null;
						}

					$list_absen = $CI->M_absensi->get_datatables_absen_karyawan($where);
					$data = array();
					$no = $_POST['start'];

					foreach($list_absen as $absen)
						{
							if(($absen->jam_masuk == null || $absen->jam_pulang == null || $absen->jam_masuk == '00:00:00' || $absen->jam_pulang == '00:00:00' ) && $absen->keterangan == null)
								{
									// $aksi = "<a class='btn btn-sm btn-primary' title='Edit' href='".site_url('absensi/edit_absen_karyawan/'.$absen->id_absensi)."'><i class='fa fa-pencil'></i> </a> <button class='btn btn-sm btn-danger' title='Hapus' onclick='hapus(\"".$absen->id_absensi."\")'><i class='fa fa-trash'></i></button>";
									$aksi = "<a class='btn btn-sm btn-primary' title='Edit' href='".site_url('absensi/edit_absen_karyawan/'.$absen->id_absensi)."'><i class='fa fa-pencil'></i> </a>";
								}
							else
								{
									// $aksi = "<button class='btn btn-sm btn-danger' title='Hapus' onclick='hapus(\"".$absen->id_absensi."\")'><i class='fa fa-trash'></i></button>";
									$aksi = "";
								}

							if($absen->jam_masuk == null || $absen->jam_masuk == '00:00:00')
								{
									$jam_masuk = '-';
								}
							else
								{
									$jam_masuk = $absen->jam_masuk;
								}


							if($absen->jam_pulang == null || $absen->jam_pulang == '00:00:00')
								{
									$jam_pulang = '-';
								}
							else
								{
									$jam_pulang = $absen->jam_pulang;
								}

							$no++;
							$row = array();

							$row[] = $no;
							$row[] = date_format(date_create($absen->tgl),'d-m-Y');
							$row[] = $absen->nik;
							$row[] = $absen->nama;
							$row[] = $jam_masuk;
							$row[] = $jam_pulang;
							$row[] = $absen->keterangan;
							$row[] = $aksi;

                            $data[] = $row;
						}

					$output = array(
						'draw'				=> $_POST['draw'],
						'recordsTotal'      => $CI->M_absensi->count_all_absen_karyawan(),
	                    'recordsFiltered'   => $CI->M_absensi->count_filtered_absen_karyawan($where),
	                    'data'              => $data,
					);

					$CI->session->unset_userdata('filter_absen_karyawan');
					echo json_encode($output);
				}

			
			# set filter absensi
			public static function set_filter_absen_karyawan()
				{
					$CI =& get_instance();
					$condition = array();

					$jenis_absen =$_POST['jenis_absen'];

					$data_cari = array(
						'absensi.tgl' 									=> $_POST['data_tanggal'],
						'karyawan.nama='								=> "'".$_POST['karyawan']."'",
						
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

					if($jenis_absen == "lengkap" && $where != null)
						{
							$where .= " AND absensi.jam_masuk IS NOT NULL AND absensi.jam_pulang IS NOT NULL";
						}
					else if($jenis_absen == "tidak lengkap" && $where != null)
						{
							$where .= ' AND (absensi.jam_masuk IS NULL OR absensi.jam_pulang IS NULL)';
						}
					else if($jenis_absen == "lengkap" && $where == null)
						{
							$where .= "absensi.jam_masuk IS NOT NULL AND absensi.jam_pulang IS NOT NULL";
						}
					else if($jenis_absen == "tidak lengkap" && $where == null)
						{
							$where .= "absensi.jam_masuk IS NULL OR absensi.jam_pulang IS NULL";
						}
					else
						{
							$Where = $where;
						}



					$CI->session->set_userdata('filter_absen_karyawan',$where);
					
				}

			# view tambah absen karyawan
			public static function tambah_absen_karyawan()
				{
					$CI =& get_instance();

					$data = array(
						'content'		=> 'absensi/tambah_absen_karyawan',
						'title_page'	=> 'Absensi Karyawan',
						'pegawai'		=> $CI->M_pegawai->tampil_pegawai(),
						'sidebar'		=> $CI->sidebar,
					);

					$CI->load->view('template/layout',$data);
				}

			# tambah data absen karyawan
			public static function tambah_data_absen_karyawan()
				{
					$CI =& get_instance();

					$config_validasi = array(

						array(
							'field'		=> 'tgl_absen',
							'label'		=> 'Tgl Absen',
							'rules'		=> 'required',
							'errors'	=> array(
												'required'		=> 'Tgl absen tidak boleh kosong',
											),
						),

						array(
							'field'		=> 'nama_karyawan',
							'label'		=> 'Nama Karyawan',
							'rules'		=> 'required',
							'errors'	=> array(
												'required'		=> 'Nama Karyawantidak boleh kosong',
											),
						),

						array(
							'field'		=> 'keterangan',
							'label'		=> 'Keterangan',
							'rules'		=> 'required',
							'errors'	=> array(
												'required'		=> 'Keterangan tidak boleh kosong',
											),
						),

						


					);

					$CI->form_validation->set_rules($config_validasi);

					if($CI->form_validation->run() == false)
						{
							$CI->session->set_flashdata('status_absen', 'gagal');
							
							// redirect(site_url('absensi/tambah_absen_karyawan'));
							$data = array(
								'content'		=> 'absensi/tambah_absen_karyawan',
								'title_page'	=> 'Absensi Karyawan',
								'pegawai'		=> $CI->M_pegawai->tampil_pegawai(),
								'sidebar'		=> $CI->sidebar,
							);

							$CI->load->view('template/layout',$data);
						}
					else
						{
							# ambil data shift (jam masuk dan jam pulang)
							$data_jam_kerja = $CI->M_absensi->tampil_jam_kerja();

							foreach($data_jam_kerja as $jam_kerja)
								{
									$jadwal_masuk 	= $jam_kerja->jam_masuk;
									$jadwal_pulang	= $jam_kerja->jam_pulang;
								}

							$tgl = $CI->input->post('tgl_absen');
							$pecah = explode('-', $tgl);
							$tanggal_absen = $pecah[2]."-".$pecah[1]."-".$pecah[0];

							$data = array(
								'tgl' 				=> $tanggal_absen,
								'id_karyawan'		=> $CI->input->post('nama_karyawan'),
								// 'jam_masuk'			=> $CI->input->post('jam_masuk').":00",
								// 'jam_pulang'		=> $CI->input->post('jam_pulang').":00",
								'jam_masuk'			=> '',
								'jam_pulang'		=> '',
								'keterangan'		=> $CI->input->post('keterangan'),
							);

							// var_dump($data);


							# cek apakah keterangan tidak sakit atau tidak izin
							if($data['keterangan'] != 'sakit' && $data['keterangan'] != 'izin' && $data['keterangan'] != 'alpha')
								{
									# cek keterlambatan
									if($data['jam_masuk'] != null && $data['jam_masuk'] != '')
										{
											# cek keterlambatan
											if($data['jam_masuk'] > $jadwal_masuk)
												{
													$menit_potongan = array();
													$no = -1;
													$data_index = 0;
													# data potogan keterlambatan
													$data_potongan = $CI->M_keterlambatan->tampil_potongan_keterlambatan();

													foreach($data_potongan as $dp)
														{
															$menit_potongan[$data_index]['id_potongan']		= $dp->id_potongan_keterlambatan;
															$menit_potongan[$data_index]['jumlah_menit']	= $dp->jumlah_menit;
															$menit_potongan[$data_index]['jumlah_potongan']	= $dp->jumlah_potongan;
															// array_push($menit_potongan,$dp->jumlah_menit);
															$data_index++;
															$no++;
														}

														# lama waktu keterlamabatan
														$lama_keterlambatan = $CI->keterlambatan($jadwal_masuk,$data['jam_masuk']);

														for($i = 0 ; $i <= $no; $i++)
															{
																# cek apakah keterlambatan berada di jumlah telat maksimal
																if($lama_keterlambatan >= $menit_potongan[$no]['jumlah_menit'])
																	{
																		
																		$id_telat = $menit_potongan[$no]['id_potongan'];
																		$telat = $menit_potongan[$no]['jumlah_menit'];
																		$potongan_telat = $menit_potongan[$no]['jumlah_potongan'];

																	}
																else
																	{
																		if($lama_keterlambatan >= $menit_potongan[$i]['jumlah_menit'] && $lama_keterlambatan < $menit_potongan[$i + 1]['jumlah_menit'])
																			{
																				$id_telat = $menit_potongan[$i]['id_potongan'];
																				$telat = $menit_potongan[$i]['jumlah_menit'];
																				$potongan_telat = $menit_potongan[$i]['jumlah_potongan'];

																			}
																	}
															}


													#set data keterlambatan
													$data_keterlambatan = array(
														'id_potongan_keterlambatan'	=> $id_telat,
														'lama_keterlambatan'		=> $lama_keterlambatan,
														'created_at'				=> date('Y-m-d'),
													);


												}
											else
												{
													$data_keterlambatan = null;
												}




										}
									else
										{
											$data_keterlambatan = null;
										}

									# cek lemburan
									if($data['jam_pulang'] != null && $data['jam_pulang'] != '')
										{
											# cek lembuaran
											if($data['jam_pulang'] > $jadwal_pulang)
												{
													$data_gapok = $CI->M_penggajian->tampil_gapok(array('gapok.id_karyawan' => $data['id_karyawan']));

													foreach($data_gapok as $dg)
														{
															$gapok 				= $dg->gaji_pokok;
															$jenis_pembayaran	= $dg->jenis_pembayaran;
														}
													# jumlah jam kerja
													$jumlah_jam_kerja = $CI->jumlah_lembur($jadwal_masuk,$jadwal_pulang);

													# upah jam kerja perhari jika full (untuk divisi kantor)

													if($jenis_pembayaran == "perbulan")
														{
															$upah_lembur_perjam = floor(($gapok / 30) / $jumlah_jam_kerja);
													
														}
													else if($jenis_pembayaran == "perhari")
														{
															$upah_lembur_perjam = floor($gapok / $jumlah_jam_kerja);
														}

													$jumlah_lemburan = floor($CI->jumlah_lembur($jadwal_pulang,$data['jam_pulang']));

													if($jumlah_lemburan >= 4)
														{
															if($jenis_pembayaran == 'perbulan')
																{
																	$upah_lemburan = $gapok / 30;
																}
															else if($jenis_pembayaran == 'perhari')
																{
																	$upah_lemburan = $gapok;
																}
														}
													else
														{
															# cek kembali untuk jumlah lemburan lebih dari batas maksimal
															$upah_lemburan = $upah_lembur_perjam * $jumlah_lemburan;
														}

													$data_lemburan = array(
														'id_absensi'		=> $id_absensi,
														'jumlah_lemburan'	=> $jumlah_lemburan,
														'upah_lemburan'		=> $upah_lemburan,
														'created_at'		=> date('Y-m-d H:i:s'),
													);
												}
											else
												{
													$data_lemburan = null;
												}
										}
									else
										{
											$data_lemburan = null;
										}
								}
							else
								{
									$data_keterlambatan = null;
									$data_lemburan = null;
								}

							$jumlah_absen = $CI->M_absensi->jumlah_absen_karyawan(array(
								'absensi.id_karyawan'	=> $data['id_karyawan'],
								'absensi.tgl'			=> $data['tgl'],
							));

							if($jumlah_absen != 0)
								{
									$CI->session->set_flashdata('status_absen','sudah ada');
									redirect(site_url('absensi/tambah_absen_karyawan'));
								}
							else
								{
									$CI->db->trans_start();

									$CI->M_absensi->tambah_absen($data);

									$cari_absensi = $CI->M_absensi->tampil_absensi(array(
										'id_karyawan'	=> $data['id_karyawan'],
										'tgl'			=> $data['tgl'],
									));

									foreach($cari_absensi as $ta)
										{
											$id_absensi					= $ta->id_absensi;
											
										}

									if($data_keterlambatan != null)
										{
											if(is_array($data_keterlambatan))
												{
													$data_keterlambatan['id_absensi'] = $id_absensi;

												}

											$CI->M_absensi->tambah_keterlambatan($data_keterlambatan);
										}

									if($data_lemburan != null)
										{
											if(is_array($data_lemburan))
												{
													$data_lemburan['id_absensi'] = $id_absensi;
												}

											$CI->M_absensi->tambah_lemburan($data_lemburan);
										}

									$CI->db->trans_complete();

									if($CI->db->trans_status() === FALSE)
										{
											$CI->session->set_flashhdata('status_absen','gagal');
											// redirect(site_url('absensi/tambah_absen_karyawan'));
											$data = array(
												'content'		=> 'absensi/tambah_absen_karyawan',
												'title_page'	=> 'Absensi Karyawan',
												'pegawai'		=> $CI->M_pegawai->tampil_pegawai(),
												'sidebar'		=> $CI->sidebar,
											);

											$CI->load->view('template/layout',$data);
										}
									else
										{
											$CI->session->set_flashdata('status_absen','berhasil');
											redirect(site_url('absensi/tambah_absen_karyawan'));
										}
								}
						}
				}


			# keterlambatan dalam bentuk menit
			public static function keterlambatan($jadwal_masuk,$jam_masuk)
				{
					$jadwal=$jadwal_masuk;
					$masuk=$jam_masuk;
					//list digunkaan untuk menangkap hasil
					//explode untuk membetuk array  dengan menhilangkan : pd contoh ini
					list($jam,$menit,$detik)=explode(':',$jadwal);
					//akan menghasilkan $jam=09,$menit=44,$detik=0
					//fungsi untuk membentuk format waktu
					//mktime(jam,menit,detik,bulan,tanggal,tahun
					//-----membentuk waktu mulai
					$buatWaktuMulai=mktime($jam,$menit,$detik,1,1,1);

					list($jam,$menit,$detik)=explode(':',$masuk);
					//-----membentuk waktu selesai
					$buatWaktuSelesai=mktime($jam,$menit,$detik,1,1,1);

					$selisihDetik=$buatWaktuSelesai-$buatWaktuMulai;
					$selisihMenit = $selisihDetik / 60;
					$selisihJam = $selisihMenit / 60;
					
					$keterlambatan = $selisihMenit;
					return $keterlambatan;
				}

			# lemburan dalam bentuk jam
			public static function jumlah_lembur($jadwal_pulang,$jam_pulang)
				{
					$jadwal=$jadwal_pulang;
					$masuk=$jam_pulang;
					//list digunkaan untuk menangkap hasil
					//explode untuk membetuk array  dengan menhilangkan : pd contoh ini
					list($jam,$menit,$detik)=explode(':',$jadwal);
					//akan menghasilkan $jam=09,$menit=44,$detik=0
					//fungsi untuk membentuk format waktu
					//mktime(jam,menit,detik,bulan,tanggal,tahun
					//-----membentuk waktu mulai
					$buatWaktuMulai=mktime($jam,$menit,$detik,1,1,1);

					list($jam,$menit,$detik)=explode(':',$masuk);
					//-----membentuk waktu selesai
					$buatWaktuSelesai=mktime($jam,$menit,$detik,1,1,1);

					$selisihDetik=$buatWaktuSelesai-$buatWaktuMulai;
					$selisihMenit = $selisihDetik / 60;
					$selisihJam = $selisihMenit / 60;
					
					$lemburan = $selisihJam;
					return $lemburan;
				}

			# hapus absensi karyawan
			public static function hapus_absensi_karyawan($id_absensi)
				{
					$CI =& get_instance();

					$hapus = $CI->M_absensi->hapus_absensi_karyawan(array('id_absensi' => $id_absensi));

					if($hapus)
						{
							$CI->session->set_flashdata('status_hapus','berhasil');
							redirect(site_url('absensi/lihat_absen_karyawan'));
						}
					else
						{
							$CI->session->set_flashdata('status_hapus','gagal');
							redirect(site_url('absensi/lihat_absen_karyawan'));
						}
				}

			#view edit absen karyawan
			public static function edit_absen_karyawan($id)
				{
					$CI =& get_instance();

					$data = array(
						'content'		=> 'absensi/edit_absen_karyawan',
						'sidebar'		=> $CI->sidebar,
						'title_page'	=> "Edit Absen Karyawan",
						'data_absen'	=> $CI->M_absensi->tampil_absensi_karyawan(array('absensi.id_absensi' => $id)),
					);

					$CI->load->view('template/layout',$data);
					
				}

			# edit data absen karyawan
			public static function edit_data_absen_karyawan()
				{
					$CI =& get_instance();

					$jenis_absen = $CI->input->post('jenis');
					$id_karyawan = $CI->input->post('id_karyawan');
					$id_absensi	 = $CI->input->post('id_absensi');

					if($jenis_absen == 'masuk')
						{
							$config_validasi = array(
								array(
									'field'		=> 'jam_masuk',
									'label'		=> 'Jam Masuk',
									'rules'		=> 'required',
									'errors'	=> array(
														'required'		=> "Jam Masuk tidak boleh kosong",
													),
								),
							);
						}
					else if($jenis_absen == 'pulang')
						{
							$config_validasi = array(
								array(
									'field'		=> 'jam_pulang',
									'label'		=> 'Jam Pulang',
									'rules'		=> 'required',
									'errors'	=> array(
														'required'		=> "Jam Pulang tidak boleh kosong",
													),
								),
							);
						}
					// else
					// 	{
					// 		$config_validasi = array(
					// 			array(
					// 				'field'		=> 'keterangan',
					// 				'label'		=> 'Keterangan',
					// 				'rules'		=> 'required',
					// 				'errors'	=> array(
					// 									'required'		=> "JKeterangan tidak boleh kosong",
					// 								),
					// 			),
					// 		);
					// 	}

					$CI->form_validation->set_rules($config_validasi);

					if($CI->form_validation->run() == false)
						{
							$CI->session->set_flashdata('status_Edit', 'gagal');

							$data = array(
								'content'		=> 'absensi/edit_absen_karyawan',
								'sidebar'		=> $CI->sidebar,
								'title_page'	=> "Edit Absen Karyawan",
								'data_absen'	=> $CI->M_absensi->tampil_absensi_karyawan(array('absensi.id_absensi' => $id_absensi)),
							);

							$CI->load->view('template/layout',$data);
						}
					else
						{
							# ambil data shift (jam masuk dan jam pulang)
							$data_jam_kerja = $CI->M_absensi->tampil_jam_kerja();

							foreach($data_jam_kerja as $jam_kerja)
								{
									$jadwal_masuk 	= $jam_kerja->jam_masuk;
									$jadwal_pulang	= $jam_kerja->jam_pulang;
								}

							$tgl = $CI->input->post('tgl_absen');
							$pecah = explode('-', $tgl);
							$tanggal_absen = $pecah[2]."-".$pecah[1]."-".$pecah[0];

							$data = array(
								'tgl' 				=> $tanggal_absen,
								'id_karyawan'		=> $CI->input->post('id_karyawan'),
								'jam_masuk'			=> $CI->input->post('jam_masuk').":00",
								'jam_pulang'		=> $CI->input->post('jam_pulang').":00",
								'keterangan'		=> $CI->input->post('keterangan'),
							);


								# cek apakah keterangan tidak sakit atau tidak izin
							if($data['keterangan'] != 'sakit' && $data['keterangan'] != 'izin')
								{
									# cek keterlambatan
									if($jenis_absen == 'masuk')
										{
											# cek keterlambatan
											if($data['jam_masuk'] > $jadwal_masuk)
												{
													$menit_potongan = array();
													$no = -1;
													$data_index = 0;
													# data potogan keterlambatan
													$data_potongan = $CI->M_keterlambatan->tampil_potongan_keterlambatan();

													foreach($data_potongan as $dp)
														{
															$menit_potongan[$data_index]['id_potongan']		= $dp->id_potongan_keterlambatan;
															$menit_potongan[$data_index]['jumlah_menit']	= $dp->jumlah_menit;
															$menit_potongan[$data_index]['jumlah_potongan']	= $dp->jumlah_potongan;
															// array_push($menit_potongan,$dp->jumlah_menit);
															$data_index++;
															$no++;
														}

														# lama waktu keterlamabatan
														$lama_keterlambatan = $CI->keterlambatan($jadwal_masuk,$data['jam_masuk']);

														for($i = 0 ; $i <= $no; $i++)
															{
																# cek apakah keterlambatan berada di jumlah telat maksimal
																if($lama_keterlambatan >= $menit_potongan[$no]['jumlah_menit'])
																	{
																		
																		$id_telat = $menit_potongan[$no]['id_potongan'];
																		$telat = $menit_potongan[$no]['jumlah_menit'];
																		$potongan_telat = $menit_potongan[$no]['jumlah_potongan'];

																	}
																else
																	{
																		if($lama_keterlambatan >= $menit_potongan[$i]['jumlah_menit'] && $lama_keterlambatan < $menit_potongan[$i + 1]['jumlah_menit'])
																			{
																				$id_telat = $menit_potongan[$i]['id_potongan'];
																				$telat = $menit_potongan[$i]['jumlah_menit'];
																				$potongan_telat = $menit_potongan[$i]['jumlah_potongan'];

																			}
																	}
															}


													#set data keterlambatan
													$data_keterlambatan = array(
														'id_potongan_keterlambatan'	=> $id_telat,
														'lama_keterlambatan'		=> $lama_keterlambatan,
														'created_at'				=> date('Y-m-d'),
													);


												}
											else
												{
													$data_keterlambatan = null;
												}
										}
									else if($jenis_absen =='pulang')
										{
											# cek lembuaran
											if($data['jam_pulang'] > $jadwal_pulang)
												{
													$data_gapok = $CI->M_penggajian->tampil_gapok(array('gapok.id_karyawan' => $data['id_karyawan']));

													foreach($data_gapok as $dg)
														{
															$gapok 				= $dg->gaji_pokok;
															$jenis_pembayaran	= $dg->jenis_pembayaran;
														}
													# jumlah jam kerja
													$jumlah_jam_kerja = $CI->jumlah_lembur($jadwal_masuk,$jadwal_pulang);

													# upah jam kerja perhari jika full (untuk divisi kantor)

													if($jenis_pembayaran == "perbulan")
														{
															$upah_lembur_perjam = floor(($gapok / 30) / $jumlah_jam_kerja);
													
														}
													else if($jenis_pembayaran == "perhari")
														{
															$upah_lembur_perjam = floor($gapok / $jumlah_jam_kerja);
														}

													$jumlah_lemburan = floor($CI->jumlah_lembur($jadwal_pulang,$data['jam_pulang']));

													if($jumlah_lemburan >= 4)
														{
															if($jenis_pembayaran == 'perbulan')
																{
																	$upah_lemburan = $gapok / 30;
																}
															else if($jenis_pembayaran == 'perhari')
																{
																	$upah_lemburan = $gapok;
																}
														}
													else
														{
															# cek kembali untuk jumlah lemburan lebih dari batas maksimal
															$upah_lemburan = $upah_lembur_perjam * $jumlah_lemburan;
														}

													$data_lemburan = array(
														'id_absensi'		=> $id_absensi,
														'jumlah_lemburan'	=> $jumlah_lemburan,
														'upah_lemburan'		=> $upah_lemburan,
														'created_at'		=> date('Y-m-d H:i:s'),
													);
												}
											else
												{
													$data_lemburan = null;
												}
										}
									else
										{
											$data_keterlambatan = null;
											$data_lemburan = null;
										}

									
								}
							else
								{
									$data_keterlambatan = null;
									$data_lemburan = null;
								}


							$CI->db->trans_start();

							// $CI->M_absensi->tambah_absen($data);
							$CI->M_absensi->edit_absen_karyawan(
								array(
									'id_absensi'	=> $id_absensi,
								),

								$data
							);

							$cari_absensi = $CI->M_absensi->tampil_absensi(array(
								'id_karyawan'	=> $data['id_karyawan'],
								'tgl'			=> $data['tgl'],
							));

							foreach($cari_absensi as $ta)
								{
									$id_absensi					= $ta->id_absensi;
									
								}

							if($data_keterlambatan != null)
								{
									if(is_array($data_keterlambatan))
										{
											$data_keterlambatan['id_absensi'] = $id_absensi;

										}

									$CI->M_absensi->tambah_keterlambatan($data_keterlambatan);
								}

							if($data_lemburan != null)
								{
									if(is_array($data_lemburan))
										{
											$data_lemburan['id_absensi'] = $id_absensi;
										}

									$CI->M_absensi->tambah_lemburan($data_lemburan);
								}

							$CI->db->trans_complete();

							if($CI->db->trans_status() === FALSE)
								{
									$CI->session->set_flashhdata('status_edit','gagal');
									redirect(site_url('absensi/lihat_absen_karyawan'));
								}
							else
								{
									$CI->session->set_flashdata('status_edit','berhasil');
									redirect(site_url('absensi/lihat_absen_karyawan'));
								}




						}
				}


		}