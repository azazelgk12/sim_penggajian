<?php
	class Laporan_penggajian extends CI_Controller
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
					$this->load->model('M_penggajian');

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
				$this->fpdf->Cell(0, 10, 'LAPORAN PENGGAJIAN ', 0, 2,'C');
				$this->fpdf->Ln(5);
				$this->fpdf->SetFont('Arial','',10);
				$this->fpdf->SetTextColor(0);
				$this->fpdf->SetX(5);
				$tglSekarang = date("d-m-Y");
				$this->fpdf->Cell(0,10,'Tanggal cetak : '.date('d-m-Y'),0,0,'L');
				$this->fpdf->Cell(0,10,'Halaman : '.$this->fpdf->PageNo(),0,0,'R');

				$this->fpdf->Ln(10);

				$h = 8;
				$left = 20;
				$top = 80;
				#tableheader
				$this->fpdf->SetFont('Arial','',8);
				$this->fpdf->SetFillColor(52,126,236);
				$this->fpdf->SetTextColor(0,0,0);
				$left = $this->fpdf->GetX();
				$this->fpdf->SetX(5);
				$this->fpdf->Cell(15,$h,'NO',1,0,'C',true);
				$this->fpdf->SetX($left +=10 ); $this->fpdf->Cell(40, $h, 'Tanggal', 1, 0, 'C',true);
				$this->fpdf->SetX($left += 40); $this->fpdf->Cell(40, $h, 'NIK', 1, 0, 'C',true);
				$this->fpdf->SetX($left += 40); $this->fpdf->Cell(40, $h, 'Nama', 1, 0, 'C',true);
				$this->fpdf->SetX($left += 40); $this->fpdf->Cell(40, $h, 'Total Pendapatan', 1, 0, 'C',true);
			
				
				$this->fpdf->SetX($left += 40); $this->fpdf->Cell(40, $h, 'Potongan', 1, 0, 'C',true);
				$this->fpdf->SetX($left += 40); $this->fpdf->Cell(40, $h, 'Gaji Bersih', 1, 0, 'C',true);
				$this->fpdf->SetX($left += 40); $this->fpdf->Cell(30, $h, 'Pembayaran', 1, 0, 'C',true);
			
				
				$this->fpdf->Ln(8);

				$this->fpdf->SetFont('Arial','',8);
				$this->SetWidths(array(15,40,40,40,40,40,40,30));
				$this->SetAligns(array('C','C','L','L','R','R','R','C'));
				$no = 1;
				$this->fpdf->SetFillColor(124,200,123);

				$this->fpdf->SetFillColor(230,230,0);
				$this->fpdf->SetTextColor(0,0,0);
				
				if(!empty($CI->session->userdata('filter_penggajian')))
					{
						$where = $CI->session->userdata('filter_penggajian');
						$data_penggajian = $CI->M_penggajian->tampil_penggajian($where);
					}
				else
					{
						$data_penggajian = $CI->M_penggajian->tampil_penggajian();
					}
		
			$no = 1;
			$gaji = 0;
			foreach($data_penggajian as $baris)
				{
					$total_pendapatan = $baris->total_gaji + $baris->total_tunjangan + $baris->transport + $baris->uang_makan + $baris->total_lemburan ;
					$gaji_bersih = $total_pendapatan - $baris->total_potongan;
					$CI->fpdf->SetX(5);
					$CI->Row(array(
						$no++,
						$baris->tgl,
						$baris->nik,
						$baris->nama,
						'Rp. '.number_format($total_pendapatan,2,',','.'),
						'Rp. '.number_format($baris->total_potongan,2,',','.'),
						'Rp. '.number_format($gaji_bersih,2,',','.'),
						$baris->jenis_pembayaran

					));
					$gaji += $gaji_bersih;
				}

				$this->fpdf->SetX(210);
				$this->fpdf->SetFont('Arial','B',8);
				$this->fpdf->Cell(0,10,'TOTAL    :',0,0,'L');
				$this->fpdf->SetX(235);
				$this->fpdf->Cell(0,10,'Rp. '.number_format($gaji,2,',','.'),0,0,'L');
				$this->fpdf->SetFont('Arial','',8);
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
					$this->fpdf->SetX($left += 40); $this->fpdf->Cell(40, $h, 'NIK', 1, 0, 'C',true);
					$this->fpdf->SetX($left += 40); $this->fpdf->Cell(40, $h, 'Nama', 1, 0, 'C',true);
					$this->fpdf->SetX($left += 40); $this->fpdf->Cell(40, $h, 'Total Pendapatan', 1, 0, 'C',true);
				
					
					$this->fpdf->SetX($left += 40); $this->fpdf->Cell(40, $h, 'Potongan', 1, 0, 'C',true);
					$this->fpdf->SetX($left += 40); $this->fpdf->Cell(40, $h, 'Gaji Bersih', 1, 0, 'C',true);
					$this->fpdf->SetX($left += 30); $this->fpdf->Cell(40, $h, 'Pembayaran', 1, 0, 'C',true);
				
					
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