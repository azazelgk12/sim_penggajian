<?php
	class Slip_gaji extends CI_Controller
		{
			public function __construct()
				{
					parent::__construct();
					$this->load->model('M_penggajian');
					$this->load->model('M_tunjangan');
					$this->load->library('fpdf');

					if(empty($this->session->userdata('username')) || $this->session->userdata('jabatan') != 'STAFF AKUNTING')
						{
							redirect(site_url());
						}

				}

			public function cetak($id)
				{

					$CI =& get_instance();

					$penggajian = $CI->M_penggajian->tampil_penggajian(array('penggajian_karyawan.id_penggajian' => $id));

					foreach($penggajian as $pg){}



					$this->fpdf->FPDFF('P','mm','A4');
					$this->fpdf->AddPage();
					$this->fpdf->SetAutoPageBreak(true,2);
					$this->fpdf->SetFillColor(255,185,2);
					$this->fpdf->Image(site_url('assets/images/logo.jpeg'),5,2,50,20);
					$this->fpdf->ln(20);

					$this->fpdf->SetFont("Times", "B",20);

					$this->fpdf->setY(10);
					$this->fpdf->setX(10);
					$this->fpdf->SetTextColor(0,0,0);
					$this->fpdf->Cell(0, 5,'SLIP GAJI', 0, 2,'C');
					$this->fpdf->ln(2);
					$this->fpdf->SetFillColor(0,0,0);
					$this->fpdf->Rect(5,25,200,0.5,'F');

					$this->fpdf->Rect(5,30,200,0.5,'F');
					
					$this->fpdf->ln(2);
					$this->fpdf->setX(150);
					$this->fpdf->SetFont("Times", "B",10);
					$this->fpdf->Cell(0, 5,'Tanggal Cetak : '.date('d-m-Y'), 0, 2,'C');
				

					$this->fpdf->ln(0);
					
					$this->fpdf->SetFont("Times", "",10);
					
					
					$this->fpdf->ln(10);

					$this->fpdf->setY(35);
					$this->fpdf->setX(10);
					$this->fpdf->Cell(0, 5,'No Slip', 0, 2,'L');

					$this->fpdf->setY(35);
					$this->fpdf->setX(30);
					$this->fpdf->Cell(0, 5,': '.$pg->kode_penggajian, 0, 2,'L');

					$this->fpdf->setY(35);
					$CI->fpdf->setX(120);

					$gapok = $CI->M_penggajian->tampil_gapok(array('gapok.id_karyawan'=>$pg->id_karyawan));

					foreach($gapok as $gp)
						{
							if($gp->jenis_pembayaran == "perbulan")
								{
									$bulan = date_format(date_create($pg->tgl_awal),'m');
									switch($bulan)
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
									$CI->fpdf->Cell(0,5,'Gaji Bulan',0,2,'L');
									$this->fpdf->setY(35);
									$this->fpdf->setX(150);
									$this->fpdf->Cell(0, 5,': '.$bln, 0, 2,'L');
								}
							else if($gp->jenis_pembayaran == "perhari")
								{
									$tanggal_awal = date_format(date_create($pg->tgl_awal),'d-m-Y');
									$tanggal_akhir = date_format(date_create($pg->tgl_akhir),'d-m-Y');
									$CI->fpdf->Cell(0,5,'Gaji periode',0,2,'L');
									$this->fpdf->setY(35);
									$this->fpdf->setX(150);
									$this->fpdf->Cell(0, 5,': '.$tanggal_awal.' s/d '.$tanggal_akhir, 0, 2,'L');
								}
						}
					
					$this->fpdf->ln(10);
					$this->fpdf->setY(40);
					$this->fpdf->setX(10);
					$this->fpdf->Cell(0, 5,'NIK', 0, 2,'L');

					$this->fpdf->setY(40);
					$this->fpdf->setX(30);
					$this->fpdf->Cell(0, 5,': '.$pg->nik, 0, 2,'L');

					$this->fpdf->ln(10);
					$this->fpdf->setY(40);
					$this->fpdf->setX(120);
					$this->fpdf->Cell(0, 5,'Jabatan', 0, 2,'L');

					$this->fpdf->setY(40);
					$this->fpdf->setX(150);
					$this->fpdf->Cell(0, 5,': '.$pg->nama_jabatan, 0, 2,'L');

					$this->fpdf->ln(10);
					$this->fpdf->setY(45);
					$this->fpdf->setX(10);
					$this->fpdf->Cell(0, 5,'Nama', 0, 2,'L');

					$this->fpdf->setY(45);
					$this->fpdf->setX(30);
					$this->fpdf->Cell(0, 5,': '.$pg->nama, 0, 2,'L');

					$this->fpdf->ln(10);
					$this->fpdf->setY(45);
					$this->fpdf->setX(120);
					$this->fpdf->Cell(0, 5,'Divisi', 0, 2,'L');

					$this->fpdf->setY(45);
					$this->fpdf->setX(150);
					$this->fpdf->Cell(0, 5,': '.$pg->nama_divisi, 0, 2,'L');

					$this->fpdf->Rect(5,55,200,0.7,'F');

					$this->fpdf->SetFillColor(255,255,255);
					$this->fpdf->Rect(5,67,100,100,'');

					$this->fpdf->SetFillColor(255,255,255);
					$this->fpdf->Rect(105,67,100,100,'');

					$this->fpdf->SetFillColor(255,255,255);
					$this->fpdf->Rect(5,67,200,10,'');

					$this->fpdf->SetFont("Times", "B",14);
					$this->fpdf->setY(70);
					$this->fpdf->setX(40);
					$this->fpdf->Cell(0, 5,'Penerimaan', 0, 2,'L');

					$this->fpdf->setY(70);
					$this->fpdf->setX(145);
					$this->fpdf->Cell(0, 5,'Potongan', 0, 2,'L');


					$this->fpdf->SetFont("Times", "",10);

					$height = 80;
					$jumlah_gaji = 0;

					$this->fpdf->setY($height);
					$this->fpdf->setX(10);
					$this->fpdf->Cell(0, 5,'Gaji Pokok', 0, 2,'L');

					$this->fpdf->setY($height);
					$this->fpdf->setX(60);
					$this->fpdf->Cell(0, 5,': ', 0, 2,'L');
					$this->fpdf->setY($height);
					$this->fpdf->setX(65);
					$this->fpdf->Cell(0, 5,'Rp.', 0, 2,'L');
					$this->fpdf->setY($height);
					$this->fpdf->setX(50);
					$this->fpdf->MultiCell(50, 5,number_format($pg->total_gaji,2,',','.'),0,'R',false);
					$jumlah_gaji += $pg->total_gaji;
					
					if($pg->total_tunjangan != 0)
						{
							$tunjangan = $CI->M_tunjangan->tampil_tunjangan_karyawan(array('a.id_karyawan' => $pg->id_karyawan));

							foreach($tunjangan as $tun)
								{
									$height += 8;
									$this->fpdf->setY($height);
									$this->fpdf->setX(10);
									$this->fpdf->Cell(0, 5,$tun->nama_tunjangan, 0, 2,'L');

									$this->fpdf->setY($height);
									$this->fpdf->setX(60);
									$this->fpdf->Cell(0, 5,': ', 0, 2,'L');
									$this->fpdf->setY($height);
									$this->fpdf->setX(65);
									$this->fpdf->Cell(0, 5,'Rp.', 0, 2,'L');
									$this->fpdf->setY($height);
									$this->fpdf->setX(50);
									$this->fpdf->MultiCell(50, 5,number_format($tun->jumlah_tunjangan,2,',','.'),0,'R',false);
									$jumlah_gaji += $tun->jumlah_tunjangan;

								}
						}
					$height+=8;
					$this->fpdf->setY($height);
					$this->fpdf->setX(10);
					$this->fpdf->Cell(0, 5,'Uang Transport', 0, 2,'L');

					$this->fpdf->setY($height);
					$this->fpdf->setX(60);
					$this->fpdf->Cell(0, 5,': ', 0, 2,'L');
					$this->fpdf->setY($height);
					$this->fpdf->setX(65);
					$this->fpdf->Cell(0, 5,'Rp.', 0, 2,'L');
					$this->fpdf->setY($height);
					$this->fpdf->setX(50);
					$this->fpdf->MultiCell(50, 5,number_format($pg->transport,2,',','.'),0,'R',false);
					$jumlah_gaji += $pg->transport;

					$height+=8;
					$this->fpdf->setY($height);
					$this->fpdf->setX(10);
					$this->fpdf->Cell(0, 5,'Uang Makan', 0, 2,'L');

					$this->fpdf->setY($height);
					$this->fpdf->setX(60);
					$this->fpdf->Cell(0, 5,': ', 0, 2,'L');
					$this->fpdf->setY($height);
					$this->fpdf->setX(65);
					$this->fpdf->Cell(0, 5,'Rp.', 0, 2,'L');
					$this->fpdf->setY($height);
					$this->fpdf->setX(50);
					$this->fpdf->MultiCell(50, 5,number_format($pg->uang_makan,2,',','.'),0,'R',false);
					$jumlah_gaji += $pg->uang_makan;

					$height+=8;
					$this->fpdf->setY($height);
					$this->fpdf->setX(10);
					$this->fpdf->Cell(0, 5,'Lemburan', 0, 2,'L');

					$this->fpdf->setY($height);
					$this->fpdf->setX(60);
					$this->fpdf->Cell(0, 5,': ', 0, 2,'L');
					$this->fpdf->setY($height);
					$this->fpdf->setX(65);
					$this->fpdf->Cell(0, 5,'Rp.', 0, 2,'L');
					$this->fpdf->setY($height);
					$this->fpdf->setX(50);
					$this->fpdf->MultiCell(50, 5,number_format($pg->total_lemburan,2,',','.'),0,'R',false);
					$jumlah_gaji += $pg->total_lemburan;


					#potongan
					$height = 80;
					$jumlah_potongan = 0;

					$this->fpdf->setY($height);
					$this->fpdf->setX(110);
					$this->fpdf->Cell(0, 5,'Keterlambatan', 0, 2,'L');

					$this->fpdf->setY($height);
					$this->fpdf->setX(155);
					$this->fpdf->Cell(0, 5,': ', 0, 2,'L');
					$this->fpdf->setY($height);
					$this->fpdf->setX(160);
					$this->fpdf->Cell(0, 5,'Rp.', 0, 2,'L');
					$this->fpdf->setY($height);
					$this->fpdf->setX(150);
					$this->fpdf->MultiCell(50, 5,number_format($pg->total_potongan,2,',','.'),0,'R',false);
					$jumlah_potongan += $pg->total_potongan;

					#

					$this->fpdf->SetFont("Times", "B",10);
					$this->fpdf->setY(160);
					$this->fpdf->setX(10);
					$this->fpdf->Cell(0, 5,'Total Penerimaan', 0, 2,'L');
					$this->fpdf->setY(160);
					$this->fpdf->setX(60);
					$this->fpdf->Cell(0, 5,':', 0, 2,'L');
					$this->fpdf->setY(160);
					$this->fpdf->setX(65);
					$this->fpdf->Cell(0, 5,'Rp.', 0, 2,'L');
					$this->fpdf->setY(160);
					$this->fpdf->setX(50);
					$this->fpdf->MultiCell(50, 5,number_format($jumlah_gaji,2,',','.'),0,'R',false);

					$this->fpdf->setY(160);
					$this->fpdf->setX(115);
					$this->fpdf->Cell(0, 5,'Total Potongan', 0, 2,'L');
					$this->fpdf->setY(160);
					$this->fpdf->setX(155);
					$this->fpdf->Cell(0, 5,':', 0, 2,'L');
					$this->fpdf->setY(160);
					$this->fpdf->setX(160);
					$this->fpdf->Cell(0, 5,'Rp.', 0, 2,'L');
					$this->fpdf->setY(160);
					$this->fpdf->setX(150);
					$this->fpdf->MultiCell(50, 5,number_format($jumlah_potongan,2,',','.'),0,'R',false);

					$this->fpdf->SetFont("Times", "B",10);
					$this->fpdf->setY(170);
					$this->fpdf->setX(10);
					$this->fpdf->Cell(0, 5,'Gaji Bersih', 0, 2,'L');
					$this->fpdf->setY(170);
					$this->fpdf->setX(60);
					$this->fpdf->Cell(0, 5,':', 0, 2,'L');
					$this->fpdf->setY(170);
					$this->fpdf->setX(65);
					$this->fpdf->Cell(0, 5,'Rp.', 0, 2,'L');
					$this->fpdf->setY(170);
					$this->fpdf->setX(50);
					$this->fpdf->MultiCell(50, 5,number_format($jumlah_gaji - $jumlah_potongan,2,',','.'),0,'R',false);

					$this->fpdf->SetFillColor(255,255,255);
					$this->fpdf->Rect(5,157,200,10,'');

					$this->fpdf->setY(210);
					$this->fpdf->setX(130);
					$this->fpdf->MultiCell(50, 5,'Jakarta, '.date('d-m-Y'),0,'C',false);


					$this->fpdf->setY(245);
					$this->fpdf->setX(130);
					$this->fpdf->MultiCell(50, 5,'( '.$CI->session->userdata('nama_petugas').' )',0,'C',false);
					
					

					$this->fpdf->output();
				}

		}