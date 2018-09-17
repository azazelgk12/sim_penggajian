<?php 
	class Jurnal extends CI_Controller
		{
			private $sidebar = 'template/sidebar_keuangan';

			public function __construct()
				{
					parent::__construct();
					$this->load->model('M_jurnal');
					$this->load->model('M_akun');
				}

			#view jurnal
			public static function index()
				{
					$CI =& get_instance();

					$data = array(
						'title_page'		=> 'Jurnal',
						'sidebar'			=> $CI->sidebar,
						
						'content'			=> 'jurnal/lihat_jurnal',
					);

					$CI->load->view('template/layout',$data);
				}

			# view tambah jurnal
			public static function tambah_jurnal()
				{
					$CI =& get_instance();

					$data = array(
						'sidebar'		=> $CI->sidebar,
						'content'		=> 'jurnal/tambah_jurnal',
						'akun'				=> $akun = $CI->M_akun->tampil_akun(),
						'title_page'	=> 'Tambah Jurnal',
					);

					$CI->load->view('template/layout',$data);
				}

			# tambah data jurnal
			public static function tambah_data_jurnal()
				{
					$CI =& get_instance();

					$kode_jurnal	= 'J'.date('YmdHis');
					$tgl			= date('Y-m-d');
					$created		= date('Y-m-d H:i:s');

					$jumlah_data 	= $CI->input->post('jumlah_data');
					$nama_akun		= $CI->input->post('nama_akun');
					$debet			= $CI->input->post('debet');
					$kredit			= $CI->input->post('kredit');


					$CI->db->trans_start();

					for($i=0;$i< $jumlah_data; $i++)
						{
							

							$data_jurnal = array(
								'kode_jurnal'		=> $kode_jurnal,
								'kode_akun'			=> $nama_akun[$i],
								'debet'				=> $debet[$i],
								'kredit'			=> $kredit[$i],
								'tgl'				=> $tgl,
								'created_at'		=> $created,
							);


							$CI->M_jurnal->tambah_jurnal($data_jurnal);
							
						}

					$CI->db->trans_complete();

					if($CI->db->trans_status() == false)
						{
							$CI->session->set_flashdata('status_tambah_jurnal','gagal');
							
							$data = array(
								'sidebar'		=> $CI->sidebar,
								'content'		=> 'jurnal/tambah_jurnal',
								'akun'				=> $akun = $CI->M_akun->tampil_akun(),
								'title_page'	=> 'Tambah Jurnal',
							);

							$CI->load->view('template/layout',$data);
						}
					else
						{
							$CI->session->set_flashdata('status_tambah_jurnal','berhasil');
							redirect(site_url('jurnal/tambah_jurnal'));
						}
				}

			# data akun
			public static function data_akun()
				{
					$CI =& get_instance();

					$akun = $CI->M_akun->tampil_akun();

					foreach($akun as $a)
						{
							echo '<option value="'.$a->id_akun.'">'.$a->nama_akun.'</option>';
						}
				}

			# get datatables jurnal
			public static function get_data_jurnal()
				{
					$CI =& get_instance();
					if(!empty($CI->session->userdata('filter_jurnal')))
						{
							$where = $CI->session->userdata('filter_jurnal');
						}
					else
						{
							$where = null;
						}
					$list_jurnal = $CI->M_jurnal->get_datatables_jurnal($where);
					$data = array();
					$no = $_POST['start'];
					$index = 0;
					foreach($list_jurnal as $field)
						{
							$no++;
							$row = array();

							$row[] = $no;
							$row[] = $field->kode_jurnal;
							$row[] = date_format(date_create($field->tgl),'d-m-Y');
							$row[] = '<button title="lihat detail" class="btn btn-sm btn-success" onclick="detail(\''.$index.'\')"><i class="fa fa-eye"></i></button><a href="'.site_url('jurnal/edit/'.$field->kode_jurnal).'" title="Edit" class="btn btn-sm btn-primary"><i class="fa fa-pencil"></i></a>
								';
							

                            $data[] = $row;
                            $index++;
						}

					$output = array(
						'draw'				=> $_POST['draw'],
						'recordsTotal'      => $CI->M_jurnal->count_all_jurnal(),
	                    'recordsFiltered'   => $CI->M_jurnal->count_filtered_jurnal($where),
	                    'data'              => $data,
					);

					echo json_encode($output);
					// echo $CI->db->last_query();
				}
			# get datatables jurnal
			public static function get_data_jurnal1()
				{
					$CI =& get_instance();

					$list_akun = $CI->M_jurnal->get_datatables();
					$data = array();
					$no = $_POST['start'];
					$index = 0;
					foreach($list_akun as $field)
						{
							$no++;
							$row = array();

							$row[] = $no;
							$row[] = $field->kode_jurnal;
							$row[] = date_format(date_create($field->tgl),'d-m-Y');
							$row[] = '<button title="lihat detail" class="btn btn-sm btn-success" onclick="detail(\''.$index.'\')"><i class="fa fa-eye"></i></button><a href="'.site_url('jurnal/edit/'.$field->kode_jurnal).'" title="Edit" class="btn btn-sm btn-primary"><i class="fa fa-pencil"></i></a>
								';
							

                            $data[] = $row;
                            $index++;
						}

					$output = array(
						'draw'				=> $_POST['draw'],
						'recordsTotal'      => $CI->M_jurnal->count_all(),
	                    'recordsFiltered'   => $CI->M_jurnal->count_filtered(),
	                    'data'              => $data,
					);

					echo json_encode($output);
				}

			# detail jurnal 
			public static function detail_jurnal()
				{
					$CI =& get_instance();
					$kode_jurnal = $_POST['kode'];

					$detail = $CI->M_jurnal->tampil_jurnal(array('kode_jurnal'=>$kode_jurnal))->get()->result();
					$no = 1;
					foreach($detail as $det)
						{
							echo "<tr>";
							echo "<td class='text-center'>".$no."</td>";
							echo "<td class='text-center'>".$det->nama_akun."</td>";
							echo "<td class='text-center'>".$det->debet."</td>";
							echo "<td class='text-center'>".$det->kredit."</td>";
							echo "</tr>";
							$no++;
						}
					// print_r($kode_jurnal);
				}

			# view edit jurnal
			public static function edit($kode_jurnal)
				{
					$CI =& get_instance();

					$data = array(
						'title_page'	=> 'Edit Jurnal',
						'sidebar'		=> $CI->sidebar,
						'jurnal'		=> $CI->M_jurnal->tampil_jurnal(array('kode_jurnal'=> $kode_jurnal))->get()->result(),
						'content'		=> 'jurnal/edit_jurnal',
						'akun'			=> $akun = $CI->M_akun->tampil_akun(),
						'jumlah_data'	=>$CI->M_jurnal->tampil_jurnal(array('kode_jurnal'=> $kode_jurnal))->count_all_results(),
						'kode_jurnal'	=> $kode_jurnal,
					);
					
					$CI->load->view('template/layout',$data);
				}

			# edit data jurnal
			public static function edit_data_jurnal()
				{
					$CI =& get_instance();

					$jumlah_data 	= $CI->input->post('jumlah_data');
					$kode_jurnal	= $CI->input->post('kode_jurnal');
					$updated		= date('Y-m-d H:i:s');

					$id_jurnal		= $CI->input->post('id_jurnal');
					$jumlah_data 	= $CI->input->post('jumlah_data');
					$nama_akun		= $CI->input->post('nama_akun');
					$debet			= $CI->input->post('debet');
					$kredit			= $CI->input->post('kredit');

					$CI->db->trans_start();

					for($i=0; $i<$jumlah_data; $i++)
						{
							$id = $id_jurnal[$i];

							$data_jurnal = array(
								'kode_akun'			=> $nama_akun[$i],
								'debet'				=> $debet[$i],
								'kredit'			=> $kredit[$i],
								'updated_at'		=> $created,
							);


							$CI->M_jurnal->edit_jurnal(array('id'=>$id),$data_jurnal);
						}

					$CI->db->trans_complete();

					if($CI->db->trans_status() == false)
						{
							$CI->session->set_flashdata('status_edit_jurnal','gagal');
							redirect(site_url('jurnal/edit/'.$kode_jurnal));
						}
					else
						{
							$CI->session->set_flashdata('status_edit_jurnal','berhasil');
							redirect(site_url('jurnal/edit/'.$kode_jurnal));
						}

				}

			# set filter jurnal
			public static function set_filter_jurnal()
				{
					$CI =& get_instance();
					$condition = array();

					$tgl_awal 	= $_POST['tgl_awal'];
					$tgl_akhir 	= $_POST['tgl_akhir'];



					if(!empty($tgl_awal) && !empty($tgl_akhir))
						{
							$pecah_tgl_awal 	= explode('-',$tgl_awal);
							$pecah_tgl_akhir	= explode('-',$tgl_akhir);

							$tanggal_awal 		= $pecah_tgl_awal[2]."-".$pecah_tgl_awal[1]."-".$pecah_tgl_awal[0];
							$tanggal_akhir		= $pecah_tgl_akhir[2]."-".$pecah_tgl_akhir[1]."-".$pecah_tgl_akhir[0];

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

									$jumlah_hari = cal_days_in_month(CAL_GREGORIAN,$pecah_tgl_awal[1],$pecah_tgl_awal[0]);

									$selisih = ((abs(strtotime($tanggal_akhir) - strtotime($tanggal_awal))) / (60*60*24));
									$range_tanggal = $selisih +1;

									if($range_tanggal == $jumlah_hari)
										{
											$CI->session->set_userdata('title_laporan','Bulan : '.$bln);
											
										}
									else
										{
											$CI->session->set_userdata('title_laporan','Periode : '.$tgl_awal.' s/d '.$tgl_akhir);
										}
								}
							else
								{
									$CI->session->set_userdata('title_laporan','Periode : '.$tgl_awal.' s/d '.$tgl_akhir);
								}
						}
					else
						{
							$CI->session->set_userdata('title_laporan','');
						}

					$data_cari = array(
						'tgl' 				=> $_POST['data_tanggal'],
						'kode_jurnal='		=> "'".$_POST['kode_jurnal']."'",
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

					$CI->session->set_userdata('filter_jurnal',$where);
					// echo $where;

				}

			# reset filter penggajian
			public static function reset_filter_jurnal()
				{
					$CI =& get_instance();

					$CI->session->unset_userdata('filter_jurnal');
				}


		}