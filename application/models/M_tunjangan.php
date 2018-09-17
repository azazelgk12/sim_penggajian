<?php
	class M_tunjangan extends CI_Model
		{
			private $tabel_master_tunjangan		= 'master_tunjangan';
			private $tabel_tunjangan_karyawan 	= 'tunjangan_karyawan';
			private $tabel_jabatan 				= 'jabatan';
            private $tabel_list_tunjangan       = 'view_tunjangan_list_karyawan';
            private $tabel_karyawan             = 'karyawan';
            private $tabel_divisi               = 'divisi';
            private $tabel_transport_makan      = 'transport_makan';

			# datatables
			private $kolom_order_master_tunjangan	   = array(
    														null,
    														'id_master_tunjangan',
    														'nama_tunjangan',
    													 );

			private $kolom_cari_master_tunjangan	    = array(
    														'id_master_tunjangan',
    														'nama_tunjangan',
    													 );

          # datatables
            private $kolom_order_tunjangan_karyawan     = array(
                                                            null,
                                                            'no_identitas',
                                                            'nama',
                                                            'jk',
                                                            'tanggal_lahir',
                                                            'nama_jabatan',
                                                            'nama_divisi',
                                                         );

            private $kolom_cari_tunjangan_karyawan      = array(
                                                            'no_identitas',
                                                            'nama',
                                                            'jk',
                                                            'tanggal_lahir',
                                                            'nama_jabatan',
                                                            'nama_divisi',
                                                         );

			public function tambah_tunjangan_karyawan($data = array())
				{
					return $this->db->insert($this->tabel_tunjangan_karyawan,$data);
				}

			# tambah master tunjangan
			public function tambah_master_tunjangan($data = array())
				{
					return $this->db->insert($this->tabel_master_tunjangan,$data);
				}

			# tampil master_tunjangan
			public function tampil_master_tunjangan($where = null)
				{
					if($where != null)
						{
							$tampil = $this->db->select('*')
										->from($this->tabel_master_tunjangan)
										->where($where)
										->get()
										->result();
						}
					else
						{
							$tampil = $this->db->select('*')
										->from($this->tabel_master_tunjangan)
										->get()
										->result();
						}

					return $tampil;
				}


			################
			## Datatables ##
			################
			
			 # Get query datatables master_tunjangan
            public function _get_datatables_query_master_tunjangan()
                {
                    # memilih tabel master tunjangan
                    $this->db->from($this->tabel_master_tunjangan);

                    $i = 0;

                    foreach($this->kolom_cari_master_tunjangan as $kc)
                        {
                            if(isset($_POST['search']['value']))
                                {
                                    if($i == 0)
                                        {
                                            $this->db->group_start();
                                            $this->db->like($kc,$_POST['search']['value']);
                                        }
                                    else
                                        {
                                            $this->db->or_like($kc,$_POST['search']['value']);
                                        }

                                    if(count($this->kolom_cari_master_tunjangan)-1 == $i)
                                        {
                                            $this->db->group_end();
                                        }

                                    $i++;
                                }

                            if(isset($_POST['order']))
                                {
                                    $this->db->order_by($this->kolom_order_master_tunjangan[$_POST['order'][0]['column']],$_POST['order'][0]['dir']);

                                }
                            else if(isset($this->order))
                                {
                                    $order = $this->order;
                                    $this->db->order_by(key($order),$order[key($order)]);
                                }
                           


                        }


                }

            # Get datatables master_tunjangan
            public function get_datatables_master_tunjangan()
                {
                    $this->_get_datatables_query_master_tunjangan();

                    if($_POST['length'] != -1)
                        {
                            $this->db->limit($_POST['length'],$_POST['start']);
                        }

                    $query = $this->db->get()->result();
                    return $query;
                }

            # count filtered datatables
            public function count_filtered_master_tunjangan()
                {
                    $this->_get_datatables_query_master_tunjangan();
                    $query = $this->db->get()->num_rows();
                    return $query;
                }

            # count all datatables
            public function count_all_master_tunjangan()
                {
                    return $this->db->from($this->tabel_master_tunjangan)->count_all_results();
                }

            # ubah master tunjangan
            public function ubah_master_tunjangan($where = array(),$data = array())
                {
                    return $this->db->where($where)->update($this->tabel_master_tunjangan,$data);
                }

            # jumlah data master tunjangan
            public function jumlah_master_tunjangan($where = null)
                {
                    if($where != null)
                        {
                            $tampil = $this->db->select('count(*) as jumlah')
                                        ->from($this->tabel_master_tunjangan)
                                        ->where($where)
                                        ->get()
                                        ->result();
                        }
                    else
                        {
                            $tampil = $this->db->select('count(*) as jumlah')
                                        ->from($this->tabel_master_tunjangan)
                                        ->get()
                                        ->result();
                        }

                    foreach($tampil as $t)
                        {
                            $jumlah = $t->jumlah;
                        }

                    return $jumlah;
                }

            # hapus data master tunjangan
            public function hapus_master_tunjangan($where)
                {
                    return $this->db->where($where)->delete($this->tabel_master_tunjangan);
                }

            # jumlah tunjangan karyawan
            public function jumlah_tunjangan_karyawan($where = null)
                {
                    if($where != null)
                        {
                            $tampil = $this->db->select('count(*) as jumlah')
                                        ->from($this->tabel_tunjangan_karyawan)
                                        ->where($where)
                                        ->get()
                                        ->result();
                        }
                    else
                        {
                            $tampil = $this->db->select('count(*) as jumlah')
                                        ->from($this->tabel_tunjangan_karyawan)
                                        ->get()
                                        ->result();
                        }

                    foreach($tampil as $t)
                        {
                            $jumlah = $t->jumlah;
                        }

                    return $jumlah;
                }

            # datatatables tunjangan 
            # hanya untuk karyawan yang memiliki tunjangan
            
             # Get query datatables karywan yang memiliki tunjangan
            public function _get_datatables_query_tunjangan_karyawan()
                {
                    # memilih tabel master tunjangan
                    $this->db->from($this->tabel_list_tunjangan);

                    $i = 0;

                    foreach($this->kolom_cari_tunjangan_karyawan as $kc)
                        {
                            if(isset($_POST['search']['value']))
                                {
                                    if($i == 0)
                                        {
                                            $this->db->group_start();
                                            $this->db->like($kc,$_POST['search']['value']);
                                        }
                                    else
                                        {
                                            $this->db->or_like($kc,$_POST['search']['value']);
                                        }

                                    if(count($this->kolom_cari_tunjangan_karyawan)-1 == $i)
                                        {
                                            $this->db->group_end();
                                        }

                                    $i++;
                                }

                            if(isset($_POST['order']))
                                {
                                    $this->db->order_by($this->kolom_order_tunjangan_karyawan[$_POST['order'][0]['column']],$_POST['order'][0]['dir']);

                                }
                            else if(isset($this->order))
                                {
                                    $order = $this->order;
                                    $this->db->order_by(key($order),$order[key($order)]);
                                }
                           


                        }


                }

            # Get datatables karyawan yang memiliki tunjangan
            public function get_datatables_tunjangan_karyawan()
                {
                    $this->_get_datatables_query_tunjangan_karyawan();

                    if($_POST['length'] != -1)
                        {
                            $this->db->limit($_POST['length'],$_POST['start']);
                        }

                    $query = $this->db->get()->result();
                    return $query;
                }

            # count filtered datatables karyawan yang meiliki tunjangan
            public function count_filtered_tunjangan_karyawan()
                {
                    $this->_get_datatables_query_tunjangan_karyawan();
                    $query = $this->db->get()->num_rows();
                    return $query;
                }

            # count all datatables karyawan yang memiliki tunjangan
            public function count_all_tunjangan_karyawan()
                {
                    return $this->db->from($this->tabel_list_tunjangan)->count_all_results();
                }

            # tampil data tunjangan karyawan
            public function tampil_tunjangan_karyawan($where = null)
                {
                    if($where != null)
                        {
                            $tampil = $this->db->select("a.*, b.*, c.*,d.*,e.*")
                                    ->from($this->tabel_tunjangan_karyawan." a")
                                    ->join($this->tabel_master_tunjangan." b",'a.id_master_tunjangan=b.id_master_tunjangan')
                                    ->join($this->tabel_karyawan." c","a.id_karyawan=c.id_karyawan")
                                    ->join($this->tabel_jabatan." d","c.id_jabatan=d.id_jabatan")
                                    ->join($this->tabel_divisi." e","d.id_divisi=e.id_divisi")
                                    ->where($where)
                                    ->get()
                                    ->result();
                        }
                    else
                        {
                            $tampil = $this->db->select("a.*, b.*, c.*")
                                    ->from($this->tabel_tunjangan_karyawan." a")
                                    ->join($this->tabel_master_tunjangan." b",'a.id_master_tunjangan=b.id_master_tunjangan')
                                    ->join($this->tabel_karyawan." c","a.id_karyawan=c.id_karyawan")
                                    ->join($this->tabel_jabatan." d","c.id_jabatan=d.id_jabatan")
                                    ->join($this->tabel_divisi." e","d.id_divisi=e.id_divisi")
                                    ->get()
                                    ->result();
                        }

                    return $tampil;
                }

            # hapus tunjangan karyawan
            public function hapus_tunjangan_karyawan($where = array())
                {
                    return $this->db->where($where)->delete($this->tabel_tunjangan_karyawan);
                }

            # ubah tunjangan karyawan
            public function update_tunjangan_karyawan($where = array(), $data= array())
                {
                    return $this->db->where($where)->update($this->tabel_tunjangan_karyawan,$data);
                }

            # tambah transport dan uang makan
            public function tambah_transport_makan($data = array())
                {
                    return $this->db->insert($this->tabel_transport_makan,$data);
                }

            # jumlah data tabel transport makan
            public function jumlah_data_trasnport($where = null)
                {   
                    if($where != null)
                        {
                            $jumlah = $this->db->select('*')
                                        ->from($this->tabel_transport_makan)
                                        ->where($where)
                                        ->count_all_results();
                        }
                    else
                        {
                            $jumlah = $this->db->select('*')
                                        ->from($this->tabel_transport_makan)
                                        ->count_all_results();
                        }

                    return $jumlah;
                }

            # tampil transport makan
            public function tampil_transport_makan($where = null)
                {
                    if($where != null)
                        {
                            $tampil = $this->db->select('*')
                                    ->from($this->tabel_transport_makan)
                                    ->where($where)
                                    ->get()
                                    ->result();
                        }
                    else
                        {
                            $tampil = $this->db->select('*')
                                    ->from($this->tabel_transport_makan)
                                    ->get()
                                    ->result();
                        }

                    return $tampil;
                }

            # edit transport makan
            public function edit_transport_makan($where,$data = array())
                {
                    return $this->db->where($where)->update($this->tabel_transport_makan,$data);
                }
			
		}