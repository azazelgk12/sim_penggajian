<?php 
	class Lemburan extends CI_Controller
		{
			private $sidebar		= 'template/sidebar_keuangan';

			public function __construct()
				{
					parent::__construct();
					$this->load->model('M_lemburan');

					if(empty($this->session->userdata('username')) || $this->session->userdata('jabatan') != 'STAFF AKUNTING')
						{
							redirect(site_url());
						}

				}

			# VIEW LEMBURAN KARYAWAN
			public function index()
				{
					$CI =& get_instance();

					$data = array(
						'content'		=> 'lemburan/tampil_lemburan',
						'sidebar'		=> $CI->sidebar,
						'title_page'	=> 'Lemburan Karyawan'
					);

					$CI->load->view('template/layout',$data);
				}

			# get data lemburan karyawan
			public static function get_data_lemburan_karyawan()
				{
					$CI =& get_instance();

					if(!empty($CI->session->userdata('filter_lemburan_karyawan')))
						{
							$where = $CI->session->userdata('filter_lemburan_karyawan');
						}
					else
						{
							$where = null;
						}

					$list_lemburan = $CI->M_lemburan->get_datatables_lemburan_karyawan($where);
					$data = array();
					$no = $_POST['start'];

					foreach($list_lemburan as $lembur)
						{
							$no++;
							$row = array();

							$row[] = $no;
							$row[] = date_format(date_create($lembur->tgl),'d-m-Y');
							$row[] = $lembur->nama;
							$row[] = $lembur->jumlah_lemburan .' Jam';
							$row[] = 'Rp. '.number_format($lembur->upah_lemburan);

                            $data[] = $row;
						}

					$output = array(
						'draw'				=> $_POST['draw'],
						'recordsTotal'      => $CI->M_lemburan->count_all_lemburan_karyawan(),
	                    'recordsFiltered'   => $CI->M_lemburan->count_filtered_lemburan_karyawan($where),
	                    'data'              => $data,
					);

					$CI->session->unset_userdata('filter_lemburan_karyawan');
					echo json_encode($output);
				}

			# set filter lemburan
			public static function set_filter_lemburan()
				{
					$CI =& get_instance();
					$condition = array();

					$data_cari = array(
						'absensi.tgl' 									=> $_POST['data_tanggal'],
						'karyawan.nama='								=> "'".$_POST['karyawan']."'",
						'lemburan_karyawan.upah_lemburan='				=> "'".$_POST['upah']."'",
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

					$CI->session->set_userdata('filter_lemburan_karyawan',$where);
				}


		}