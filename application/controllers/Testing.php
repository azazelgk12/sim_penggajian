<?php
	class Testing extends CI_Controller
		{
			public function __construct()
				{
					parent::__construct();
					$this->load->model('M_pegawai');
				}

			public static function index()
				{
					$data = array(
						'krisna',
						'laki-laki',
					);

					echo implode(" berjenis kelamin ",$data);
				}
		}