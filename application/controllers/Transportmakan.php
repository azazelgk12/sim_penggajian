<?php 
	class Transportmakan extends CI_Controller
		{
			private $sidebar = 'template/sidebar_keuangan';

			public function __construct()
				{
					parent::__construct();
					$this->load->model('M_divisi');
					$this->load->model('M_transport_makan');

					if(empty($this->session->userdata('username')) || $this->session->userdata('jabatan') != 'STAFF AKUNTING')
						{
							redirect(site_url());
						}

				}

			public static function index()
				{
					$CI =& get_instance();

					$data = array(
						'content'		=> 'tunjangan/transport_makan',
						'sidebar'		=> $CI->sidebar,
						'title_page'	=> 'Transport dan Uang Makan '
					);

					$CI->load->view('template/layout',$data);
				}

			
		}