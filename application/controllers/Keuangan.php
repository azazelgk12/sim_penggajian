<?php
	class Keuangan extends CI_Controller
		{
			private $sidebar = 'template/sidebar_keuangan';

			public function __construct()
				{
					parent::__construct();

					if(empty($this->session->userdata('username')) || $this->session->userdata('jabatan') != 'STAFF AKUNTING')
						{
							redirect(site_url());
						}
				}

			public function index()
				{
					$CI =& get_instance();
					
					$data = array(
						'content'		=> 'keuangan/home',
						'sidebar'		=> $CI->sidebar,
						'title_page'	=> 'Beranda',
					);

					$CI->load->view('template/layout',$data);
				}
		}