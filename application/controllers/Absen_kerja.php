<?php
	class Absen_kerja extends CI_Controller
		{
			public function __construct()
				{
					parent::__construct();
					$this->load->model('M_absensi');
					$this->load->model('M_pegawai');
					$this->load->model('M_keterlambatan');
					$this->load->model('M_penggajian');
				}


			# menampilkan halaman index absensi karyawan
			public static function index()
				{
					$CI =& get_instance();

					
					$CI->load->view('absensi/absen_kerja');
				}


			# cek  jam kerja dan membandingkanya 
			# dengan jam sekarang
			public static function cek_jam_kerja()
				{
					$CI =& get_instance();

					$jam_sekarang = date('H:i:s');

					$shift_kerja = $CI->M_absensi->tampil_jam_kerja();

					foreach($shift_kerja as $sk)
						{
							$jam_masuk 		= $sk->jam_masuk;
							$jam_pulang		= $sk->jam_pulang;
						}

					if($jam_sekarang <= $jam_pulang)
						{
							$absen = "masuk";
						}
					else
						{
							$absen = "pulang";
						}

					echo $absen;
				}

			# menampilkan data pegawai yg akan meakukan absensi
			public static function tampil_data_pegawai()
				{
					$CI =& get_instance();

					$data = array();



					$data_pegawai = $CI->M_pegawai->tampil_pegawai();

					foreach($data_pegawai as $dp)
						{
							array_push($data,$dp->nik.' - '.$dp->nama);
						}

					echo json_encode($data);
				}
			#tampil jam_sekarang
			public static function tampil_jam_sekarang()
				{
					echo date("H:i:s");
				}

			# input data absen masuk dan pulang karyawan
			
			public static function input_data_absen()
				{
					#	absen masuk dan pulang hanya bisa dilakukan 1 kali
					#	jika dilakukan lebih dari 1 kali maka muncul notoifikasi
					#	bahwa absen kerja sudah pernah dilakukan
					#	absen hanya bisa dilakukan dengan nik yg sudah terdaftar
					#	jika  absen dilakukan dengan nik yg tidak terdaftar
					#	maka muncul notifikasi bahwa nik tidak terdaftar
					
					$CI =& get_instance();



					$tgl_sekarang = date('Y-m-d');

					# set status absen masuk /pulang
					$status_absen 	= $CI->input->post('status_absen');
					$jam_absen 		= $CI->input->post('jam_sekarang');
					$CI->session->set_userdata('status_absen',$status_absen);
					# pecah data nik 
					
					$data_nik = $CI->input->post('nik');

					
					$CI->session->set_userdata('status_absen',$status_absen);

					# config validasi absen
					$config_validasi = array(
						array(
							'field'		=> 'nik',
							'label'		=> 'NIK',
							'rules'		=> 'required|callback_cek_status_absen',
							'errors'	=> array(
												'required'		=> "NIK tidak boleh kosong",
											),
							
						),
					);

					$CI->form_validation->set_rules($config_validasi);

					# cek status validasi
					if($CI->form_validation->run() == false)
						{
							$CI->session->set_flashdata('status_absen_karyawan','gagal');
							
							$CI->load->view('absensi/absen_kerja');
							

						}
					else
						{
							$pecah_nik = explode("-",$data_nik);
							$nik_pegawai = trim($pecah_nik[0]);

							# cari id karyawnan berdasarkan nik yang telah diinpukan
							# id_karyawan akan diinputkan ke absensi
							$cari_id = $CI->M_pegawai->tampil_pegawai(array('nik' => $nik_pegawai));

							foreach($cari_id as $cari)
								{
									$id_karyawan = $cari->id_karyawan;
								}

							

							# ambil data shift (jam masuk dan jam pulang)
							$data_jam_kerja = $CI->M_absensi->tampil_jam_kerja();

							foreach($data_jam_kerja as $jam_kerja)
								{
									$jadwal_masuk 	= $jam_kerja->jam_masuk;
									$jadwal_pulang	= $jam_kerja->jam_pulang;
								}

							# cek status absen apakah absen masuk atau absen pulang

							if($status_absen == 'masuk')
								{
									$cek_masuk = $CI->M_absensi->jumlah_absen_karyawan(array(
													'karyawan.id_karyawan'	=> $id_karyawan,
													'absensi.tgl'			=> $tgl_sekarang,
													'absensi.jam_masuk!='	=> null, 
												));
									# cek apakah sudah melakukan absen masuk ataukah belum

									if($cek_masuk == 0)
										{

											# cek  apakah karyawan telambat masuk kerja atau tidak
											if($jam_absen > $jadwal_masuk)
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
													$lama_keterlambatan = $CI->keterlambatan($jadwal_masuk,$jam_absen);

													for($i = 0 ; $i <= $no; $i++)
														{
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

													// echo $id_telat. ' => '. $telat.' => '.$potongan_telat;

													$data_absensi = array(
														'id_karyawan'		=> $id_karyawan,
														'tgl'				=> date('Y-m-d'),
														'jam_masuk'			=> $jam_absen,
													);

													$CI->db->trans_start();

													#tambah absensi
													$CI->M_absensi->tambah_absen($data_absensi);

													$cari_absensi = $CI->M_absensi->tampil_absensi(array(
																		'id_karyawan'	=> $id_karyawan,
																		'tgl'			=> date('Y-m-d')
																	));
													foreach($cari_absensi as $ta)
														{
															$id_absensi					= $ta->id_absensi;
															$id_potongan_keterlambatan	= $id_telat;
														}

													$data_keterlambatan = array(
														'id_absensi'				=> $id_absensi,
														'id_potongan_keterlambatan'	=> $id_potongan_keterlambatan,
														'lama_keterlambatan'		=> $lama_keterlambatan,
														'created_at'				=> date('Y-m-d'),
													);

													$CI->M_absensi->tambah_keterlambatan($data_keterlambatan);

													$CI->db->trans_complete();

													if($CI->db->trans_status() === FALSE)
														{
															$CI->session->set_flahhdata('status_absen','gagal');
															redirect(site_url('absen_kerja'));
														}
													else
														{
															$CI->session->set_flashdata('status_absen','berhasil');
															redirect(site_url('absen_kerja'));
														}


												}
											else
												{
													$data_absensi = array(
														'id_karyawan'		=> $id_karyawan,
														'tgl'				=> date('Y-m-d'),
														'jam_masuk'			=> $jam_absen,
													);

													$tambah = $CI->M_absensi->tambah_absen($data_absensi);

													if($tambah)
														{
															$CI->session->set_flashdata('status_absen','berhasil');
															redirect(site_url('absen_kerja'));

														}
													else
														{
															$CI->session->set_flashdata('status_absen','berhasil');
															redirect(site_url('absen_kerja'));
														}

												}

										}
									else
										{
											$CI->session->set_flashdata('status_absen','sudah ada');
											redirect(site_url('absen_kerja'));
										}
								}
							else if($status_absen == 'pulang')
								{
									$cek_pulang = $CI->M_absensi->jumlah_absen_karyawan(array(
													'karyawan.id_karyawan'	=> $id_karyawan,
													'absensi.tgl'			=> $tgl_sekarang,
													'absensi.jam_pulang!='	=> null, 
												));

									# cek apakah absen pulang sudah dilakukan atau belum
									if($cek_pulang == 0)
										{	
											# cek apakah jam pulang lebih dari jadwal pulang / tidak
											if($jam_absen > $jadwal_pulang)
												{
													$data_pegawai = $CI->M_pegawai->tampil_pegawai(array('karyawan.id_karyawan' => $id_karyawan));

													foreach($data_pegawai as $dp)
														{
															$karyawan = $dp->id_karyawan;
														}

													
													$data_gapok = $CI->M_penggajian->tampil_gapok(array('gapok.id_karyawan' => $karyawan));

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

													$jumlah_lemburan = floor($CI->jumlah_lembur($jadwal_pulang,$jam_absen));

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
													


													# input / update data dengan trasaction
													# untuk input ke tabel absensi dan ke tabel lamburan
													$CI->db->trans_start();

													# cek apakah melakukan absen masuk atau tidak
													$cek_absen_masuk = $CI->M_absensi->jumlah_absen_karyawan(array(
														'karyawan.id_karyawan'	=> $id_karyawan,
														'absensi.tgl'			=> $tgl_sekarang,
														'absensi.jam_pulang'	=> null,
														'absensi.jam_masuk!='	=> null, 
													));

													# cek data absen masuk
													# jika ada absen masuk maka dilakuan update data
													# untuk menginputkan data jam pulang
													# jika tida ada, maka hanya mengiputkan data jam pulang saja
													
													if($cek_absen_masuk == 1)
														{
															$CI->M_absensi->update_absensi(
																	array(
																		'jam_pulang'	=> $jam_absen
																	),

																	array(
																		'id_karyawan'	=> $id_karyawan,
																		'tgl'			=> $tgl_sekarang,
																	)
																);
														}
													else if($cek_absen_masuk == 0)
														{
															$data_absensi_pulang = array(
																'id_karyawan'		=> $id_karyawan,
																'tgl'				=> date('Y-m-d'),
																'jam_pulang'			=> $jam_absen,
															);

															$CI->M_absensi->tambah_absen($data_absensi_pulang);
														}

													$cari_absensi = $CI->M_absensi->tampil_absensi(array(
																		'id_karyawan'	=> $id_karyawan,
																		'tgl'			=> date('Y-m-d')
																	));
													foreach($cari_absensi as $ta)
														{
															$id_absensi					= $ta->id_absensi;
															
														}

													# tambah data lemburan 
													$CI->M_absensi->tambah_lemburan(array(
														'id_absensi'		=> $id_absensi,
														'jumlah_lemburan'	=> $jumlah_lemburan,
														'upah_lemburan'		=> $upah_lemburan,
														'created_at'		=> date('Y-m-d H:i:s'),
													));

													$CI->db->trans_complete();

													if($CI->db->trans_status() === FALSE)
														{
															$CI->session->set_flashdata('status_absen','gagal');
															redirect(site_url('absen_kerja'));
														}
													else
														{
															$CI->session->set_flashdata('status_absen','berhasil');
															redirect(site_url('absen_kerja'));
														}
													
				
												}
											else
												{
													$cek_absen_masuk = $CI->M_absensi->jumlah_absen_karyawan(array(
														'karyawan.id_karyawan'	=> $id_karyawan,
														'absensi.tgl'			=> $tgl_sekarang,
														'absensi.jam_pulang'	=> null,
														'absensi.jam_masuk!='	=> null, 
													));

													

													# cek data absen masuk
													# jika ada absen masuk maka dilakuan update data
													# untuk menginputkan data jam pulang
													# jika tida ada, maka hanya mengiputkan data jam pulang saja
													if($cek_absen_masuk == 1)
														{
															$absen_pulang = $CI->M_absensi->update_absensi(
																	array(
																		'jam_pulang'	=> $jam_absen,
																	),

																	array(
																		'id_karyawan'	=> $id_karyawan,
																		'tgl'	=> $tgl_sekarang,
																	)
																);

															if($absen_pulang)
																{
																	$CI->session->set_flashhdata('status_absen','berhasil');
																	redirect(site_url('absen_kerja'));
																}
															else
																{
																	$CI->session->set_flashdata('status_absen','gagal');
																	redirect(site_url('absen_kerja'));
																}

														}
													else if($cek_absen_masuk == 0)
														{
															
															$data_absensi_pulang = array(
																'id_karyawan'		=> $id_karyawan,
																'tgl'				=> date('Y-m-d'),
																'jam_pulang'		=> $jam_absen,
															);

															$absen_pulang =  $CI->M_absensi->tambah_absen($data_absensi_pulang);


															if($absen_pulang)
																{
																	$CI->session->set_flahhdata('status_absen','berhasil');
																	redirect(site_url('absen_kerja'));
																}
															else
																{
																	$CI->session->set_flashdata('status_absen','gagal');
																	redirect(site_url('absen_kerja'));
																}
														}
												}

										}
									else
										{
											$CI->session->set_flashdata('status_absen','sudah ada');
											redirect(site_url('absen_kerja'));
											
										}
								}
							
						}
				}

			# cek status absen karyawan apakah pernah melakukan absen / belum
			public static function cek_status_absen($nik)
				{
					$CI =& get_instance();

					$tgl_sekarang	= date('Y-m-d');
					

					# cek apakah data nik menggandung '-' atau tidak
					
					if($nik == '' || $nik == null)
						{
							$CI->form_validation->set_message('cek_status_absen','NIK tidak boleh kosong');
							return false;
							
						}
					else if(!stristr($nik, "-"))
						{
							$CI->form_validation->set_message('cek_status_absen','Maaf NIK anda tidak terdaftar');
							return false;
						}
					else if(stristr($nik,"-"))
						{
							
							$pecah_nik = explode("-",$nik);
							$nik_pegawai = trim($pecah_nik[0]);

							# cek apakah array pertama / nik adalah angka atau bukan
							if(!is_numeric($nik_pegawai))
								{
									$CI->form_validation->set_message('cek_status_absen','Maaf NIK anda salah');
									return false;
									
								}
							else
								{
									# pencarian apakah nik telah terdaftar di database atau tidak
									$cek_nik = $CI->M_pegawai->jumlah_karyawan(array('nik'=> $nik_pegawai));

									 if($cek_nik == 0)
										{
											$CI->form_validation->set_message('cek_status_absen','Maaf NIk anda tidak terdaftar');
											
											return false;
											
										}
									else
										{
											return true;
										}
								}
						}
					else
						{
							return false;
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

			# menghitung jumlah potongan gaji untuk keterlambatan
			// public static function hitung_potongan_keterlambatan($menit)
			// 	{
			// 		if($menit >= 10)
			// 			{
			// 				$potongan = 
			// 			}
			// 	}
		}