<?php
	class Laporan_jurnal extends CI_Controller
		{
			private $options = array(
		  		'filename' => '',
		  		'destinationfile' => '',
		  		'paper_size'=>'F4',
		  		'orientation'=>'P'
		  	);

		  	private $folder;



			public function __construct()
				{
					parent::__construct();
					
					$this->load->library('fpdf');
					$this->load->model('M_jurnal');

					
					if(empty($this->session->userdata('username')) || $this->session->userdata('jabatan') != 'STAFF AKUNTING')
						{
							redirect(site_url());
						}

				}

			
			
			public function cetak()
				{
					$this->printPDF();
				}
			// untuk print laporan
			public function rptDetailData () {
				
				$CI =& get_instance();

				$border = 0;
				$this->fpdf->FPDFF('L','mm','A4');
				$this->fpdf->AddPage();
				$this->fpdf->SetAutoPageBreak(true,20);
				$this->fpdf->AliasNbPages();
				$left = 0;

				//header
				$this->fpdf->SetFont("times", "B", 20);
				$this->fpdf->Image(site_url('assets/images/logo.jpeg'),5,2,50,20);;
				$this->fpdf->Ln(5);
				$this->fpdf->SetX($left);
				$this->fpdf->Cell(0, 10, 'LAPORAN JURNAL ', 0, 2,'C');
				$this->fpdf->Ln(5);
				$this->fpdf->SetFont('Arial','',10);
				$this->fpdf->SetTextColor(0);
				$this->fpdf->SetX(5);
				$tglSekarang = date("d-m-Y");
				$this->fpdf->Cell(0,10,'Tanggal cetak : '.date('d-m-Y'),0,0,'L');
				$this->fpdf->Cell(0,10,'Halaman : '.$this->fpdf->PageNo(),0,0,'R');
				$this->fpdf->Ln(5);
				$this->fpdf->SetX(5);
				$this->fpdf->Cell(0,10,$CI->session->userdata('title_laporan'),0,0,'L');
				$this->fpdf->Ln(10);

				$h = 8;
				$left = 20;
				$top = 80;
				#tableheader
				$this->fpdf->SetFont('Arial','B',8);
				$this->fpdf->SetFillColor(52,126,236);
				$this->fpdf->SetTextColor(0,0,0);
				$left = $this->fpdf->GetX();
				$this->fpdf->SetX(5);
				$this->fpdf->Cell(15,$h,'NO',1,0,'C',true);
				$this->fpdf->SetX($left +=10 ); $this->fpdf->Cell(40, $h, 'Tanggal', 1, 0, 'C',true);
				$this->fpdf->SetX($left += 40); $this->fpdf->Cell(40, $h, 'Kode Jurnal', 1, 0, 'C',true);
				$this->fpdf->SetX($left += 40); $this->fpdf->Cell(90, $h, 'Nama Akun', 1, 0, 'C',true);
				$this->fpdf->SetX($left += 90); $this->fpdf->Cell(50, $h, 'Debet', 1, 0, 'C',true);
				$this->fpdf->SetX($left += 50); $this->fpdf->Cell(50, $h, 'Kredit', 1, 0, 'C',true);
			
				
				$this->fpdf->Ln(8);

				$this->fpdf->SetFont('Arial','',8);
				$this->SetWidths(array(15,40,40,90,50,50));
				$this->SetAligns(array('C','C','C','L','R','R'));
				$no = 1;
				$this->fpdf->SetFillColor(124,200,123);

				$this->fpdf->SetFillColor(230,230,0);
				$this->fpdf->SetTextColor(0,0,0);
				
				if(!empty($CI->session->userdata('filter_jurnal')))
					{
						$where = $CI->session->userdata('filter_jurnal');
						$data_jurnal = $CI->M_jurnal->tampil_jurnal($where)->get()->result();
					}
				else
					{
						$data_jurnal = $CI->M_jurnal->tampil_jurnal()->get()->result();
					}
			$kode 			= array();
			$kd_jurnal2 	= array();
			$no 			= 1;
			$gaji 			= 0;
			$total_debet 	= 0;
			$total_kredit 	= 0;

			foreach($data_jurnal as $baris)
				{
					
					if(!in_array($baris->kode_jurnal, $kode))
						{
							array_push($kode, $baris->kode_jurnal);
							
						}
				}

			foreach($kode as $kd => $value)
				{
					$data_jurnal = $data_jurnal = $CI->M_jurnal->tampil_jurnal(array('kode_jurnal'=> $value))->get()->result();

					foreach($data_jurnal as $dj)
						{
							$total_debet += $dj->debet;
							$total_kredit += $dj->kredit;
							if($dj->debet == 0)
								{
									$nama_akun = $dj->nama_akun;
									$debet ='';
								}
							else
								{
									$nama_akun = '         '.$dj->nama_akun;
									$debet = 'Rp. '.number_format($dj->debet,2,',','.');
								}

							if($dj->kredit == 0)
								{
									$nama_akun = $dj->nama_akun;
									$kredit ='';
								}
							else
								{
									$nama_akun = '         '.$dj->nama_akun;
									$kredit = 'Rp. '.number_format($dj->kredit,2,',','.');
								}

							if(!in_array($dj->kode_jurnal,$kd_jurnal2))
								{
									array_push($kd_jurnal2, $dj->kode_jurnal);
									$nomor = $no++;
									$kode_jurnal = $dj->kode_jurnal;
									$tanggal = date_format(date_create($dj->tgl),'d-m-Y');
									
								}
							else
								{
									$nomor ='';
									$kode_jurnal = '';
									$tanggal ='';
								}

							$CI->fpdf->SetX(5);
							$CI->Row(array(
								$nomor,
								$tanggal,
								$kode_jurnal,
								$nama_akun,
								$debet,
								$kredit,
								

							));
						}
				}

			$this->fpdf->SetFont('Arial','B',8);
			$this->fpdf->SetFillColor(52,126,236);
			$this->fpdf->SetTextColor(0,0,0);
			$left = $this->fpdf->GetX();
			$this->fpdf->SetX(5);
			$this->fpdf->Cell(185,$h,'Jumlah',1,0,'C',true);
			$this->fpdf->SetX($left += 180); $this->fpdf->Cell(50, $h, 'Rp. '.number_format($total_debet,2,',','.'), 1, 0, 'R',true);
			$this->fpdf->SetX($left += 50); $this->fpdf->Cell(50, $h,'Rp. '.number_format($total_kredit,2,',','.'), 1, 0, 'R',true);

				// $this->fpdf->SetFont('Arial','B',8);
				// $this->fpdf->SetFillColor(52,126,236);
				// $this->SetWidths(array(185,50,50));
				// $this->SetAligns(array('C','R','R'));
				// $CI->fpdf->SetX(5);
				// 	$CI->Row(array(
				// 		'Jumlah',
				// 		'Rp. '.number_format($total_debet,2,',','.'),
				// 		'Rp. '.number_format($total_kredit,2,',','.'),
						

				// 	));
				$this->fpdf->Ln(10);
				// $this->fpdf->SetX(230);
				// $this->fpdf->Cell(0,10,'TOTAL    :',0,0,'L');
				// $this->fpdf->Cell(0,10,'Rp. '.number_format($total_debet,2,',','.'),0,0,'R');

				$this->fpdf->Ln(15);
				$this->fpdf->SetX(40);
				$this->fpdf->Cell(0,10,'Dibuat oleh',0,0,'L');
				$this->fpdf->SetX(200);
				$this->fpdf->Cell(0,10,'Disetujui oleh',0,0,'L');

				$this->fpdf->Ln(25);
				$this->fpdf->SetX(40);
				$this->fpdf->Cell(0,10,$CI->session->userdata('nama_petugas'),0,0,'L');
				$this->fpdf->SetX(193);
				$this->fpdf->Cell(0,10,'_________________________',0,0,'L');
			
				$CI->session->unset_userdata('filter_penggajian');
			
			}

			public function printPDF () {

				if ($this->options['paper_size'] == "F4") {
					$a = 8.3 * 72; //1 inch = 72 pt
					$b = 13.0 * 72;
					$this->fpdf->FPDFF($this->options['orientation'], "pt", array($a,$b));
				} else {
					$this->fpdf->FPDFF($this->options['orientation'], "pt", $this->options['paper_size']);
				}

			    $this->fpdf->SetAutoPageBreak(true);
			    $this->fpdf->AliasNbPages();
			    $this->fpdf->SetFont("helvetica", "B", 10);
			    $this->fpdf->AddPage();

			    $this->rptDetailData();

			    $this->fpdf->Output($this->options['filename'],$this->options['destinationfile']);
		  	}

		  	private $widths;
			private $aligns;

			function SetWidths($w)
			{
				//Set the array of column widths
				$this->fpdf->widths=$w;
			}

			function SetAligns($a)
			{
				//Set the array of column alignments
				$this->fpdf->aligns=$a;
			}

			function Row($data)
			{
				//Calculate the height of the row
				$nb=0;
				for($i=0;$i<count($data);$i++)
					$nb=max($nb,$this->NbLines($this->fpdf->widths[$i],$data[$i]));
				$h=10*$nb;
				//Issue a page break first if needed
				$this->CheckPageBreak($h);

				//Draw the cells of the row
				for($i=0;$i<count($data);$i++)
				{
					$w=$this->fpdf->widths[$i];
					$a=isset($this->fpdf->aligns[$i]) ? $this->fpdf->aligns[$i] : 'L';
					//Save the current position
					$x=$this->fpdf->GetX();
					$y=$this->fpdf->GetY();
					//Draw the border
					$this->fpdf->Rect($x,$y,$w,$h);
					//Print the text
					$this->fpdf->MultiCell($w,10,$data[$i],0,$a);
					//Put the position to the right of the cell
					$this->fpdf->SetXY($x+$w,$y);
				}
				//Go to the next line
				$this->fpdf->Ln($h);

			}

			function CheckPageBreak($h)
			{

				//If the height h would cause an overflow, add a new page immediately
				if($this->fpdf->GetY()+$h>$this->fpdf->PageBreakTrigger){
					$this->fpdf->SetFont('Arial','B',8);

					$this->fpdf->SetTextColor(220,50,50);
					$this->fpdf->AddPage($this->fpdf->CurOrientation);
					$this->fpdf->Image(site_url('assets/images/logo.jpeg'),5,2,50,20);;
					$this->fpdf->Ln(20);
					
					$this->fpdf->SetFont('Arial','',10);
					$this->fpdf->SetFont('Arial','',10);
					$this->fpdf->SetTextColor(0);
					$this->fpdf->SetX(10);
					$tglSekarang = date("d-m-Y");
					$this->fpdf->Cell(0,10,'Tanggal cetak : '.date('d-m-Y'),0,0,'L');
					$this->fpdf->Cell(0,10,'Halaman : '.$this->fpdf->PageNo(),0,0,'R');
					$this->fpdf->ln(10);
					$h = 8;
					$left = 40;
					$top = 80;
					#tableheader
					$this->fpdf->SetFont('Arial','',8);
					$this->fpdf->SetFillColor(52,126,236);
					$this->fpdf->SetTextColor(0,0,0);
					$left = $this->fpdf->GetX();

					$this->fpdf->SetX(5);
					$this->fpdf->Cell(15,$h,'NO',1,0,'C',true);
					$this->fpdf->SetX($left +=10 ); $this->fpdf->Cell(40, $h, 'Tanggal', 1, 0, 'C',true);
					$this->fpdf->SetX($left += 40); $this->fpdf->Cell(40, $h, 'Kode Jurnal', 1, 0, 'C',true);
					$this->fpdf->SetX($left += 40); $this->fpdf->Cell(90, $h, 'Nama Akun', 1, 0, 'C',true);
					$this->fpdf->SetX($left += 90); $this->fpdf->Cell(50, $h, 'Debet', 1, 0, 'C',true);
					$this->fpdf->SetX($left += 50); $this->fpdf->Cell(50, $h, 'Kredit', 1, 0, 'C',true);
				
					
					$this->fpdf->Ln(8);
				
					$this->fpdf->SetX(5);
					$this->fpdf->SetTextColor(0,0,0);
					$this->fpdf->SetFont('Arial','',8);


				}

			}

			function NbLines($w,$txt)
			{
				//Computes the number of lines a MultiCell of width w will take
				$cw=&$this->fpdf->CurrentFont['cw'];
				if($w==0)
					$w=$this->fpdf->w-$this->fpdf->rMargin-$this->fpdf->x;
				$wmax=($w-2*$this->fpdf->cMargin)*1000/$this->fpdf->FontSize;
				$s=str_replace("\r",'',$txt);
				$nb=strlen($s);
				if($nb>0 and $s[$nb-1]=="\n")
					$nb--;
				$sep=-1;
				$i=0;
				$j=0;
				$l=0;
				$nl=1;
				while($i<$nb)
				{
					$c=$s[$i];
					if($c=="\n")
					{
						$i++;
						$sep=-1;
						$j=$i;
						$l=0;
						$nl++;
						continue;
					}
					if($c==' ')
						$sep=$i;
					$l+=$cw[$c];
					if($l>$wmax)
					{
						if($sep==-1)
						{
							if($i==$j)
								$i++;
						}
						else
							$i=$sep+1;
						$sep=-1;
						$j=$i;
						$l=0;
						$nl++;
					}
					else
						$i++;
				}
				return $nl;
			}


			

			
		}