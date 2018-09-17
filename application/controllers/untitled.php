<?php
 /**
  * 
  */
 class ClassName extends AnotherClass
 {
 	
 	function __construct(argument)
 	{
 		# code...
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
 }