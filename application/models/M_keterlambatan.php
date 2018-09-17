<?php
	class M_keterlambatan extends CI_Model
		{
			private $tabel_potongan_keterlambatan	= "potongan_keterlambatan";
            private $tabel_keterlambatan_karawan    = 'keterlambatan';
            private $tabel_absensi                  = 'absensi';
            private $tabel_karyawan                 = 'karyawan';

			# datatables
			private $kolom_order	= array(
										null,
										'jumlah_menit',
										'jumlah_potongan',
									 );

			private $kolom_cari		= array(
										'jumlah_menit',
										'jumlah_potongan',
									 );

            # tampil data potongan keterlambatan
            # 
            public function tampil_potongan_keterlambatan($where = null)
                {
                    if($where != null)
                        {
                            $tampil = $this->db->select('*')
                                        ->from($this->tabel_potongan_keterlambatan)
                                        ->where($where)
                                        ->order_by('jumlah_menit','ASC')
                                        ->get()
                                        ->result();
                        }
                    else
                        {
                             $tampil = $this->db->select('*')
                                        ->from($this->tabel_potongan_keterlambatan)
                                        ->order_by('jumlah_menit','ASC')
                                        ->get()
                                        ->result();
                        }

                    return $tampil;
                }

            # tambah data potongan keterlambatan
			public function tambah_potongan($data = array())
				{
					return $this->db->insert($this->tabel_potongan_keterlambatan,$data);
				}

			################
			## Datatables ##
			################
			
			 # Get query datatables
            public function _get_datatables_query()
                {
                    # memilih tabel potongan keterlambatan
                    $this->db->from($this->tabel_potongan_keterlambatan);

                    $i = 0;

                    foreach($this->kolom_cari as $kc)
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

                                    if(count($this->kolom_cari)-1 == $i)
                                        {
                                            $this->db->group_end();
                                        }

                                    $i++;
                                }

                            if(isset($_POST['order']))
                                {
                                    $this->db->order_by($this->kolom_order[$_POST['order'][0]['column']],$_POST['order'][0]['dir']);

                                }
                            else if(isset($this->order))
                                {
                                    $order = $this->order;
                                    $this->db->order_by(key($order),$order[key($order)]);
                                }
                           


                        }


                }

            # Get datatables
            public function get_datatables()
                {
                    $this->_get_datatables_query();

                    if($_POST['length'] != -1)
                        {
                            $this->db->limit($_POST['length'],$_POST['start']);
                        }

                    $query = $this->db->get()->result();
                    return $query;
                }

            # count filtered datatables
            public function count_filtered()
                {
                    $this->_get_datatables_query();
                    $query = $this->db->get()->num_rows();
                    return $query;
                }

            # count all datatables
            public function count_all()
                {
                    return $this->db->from($this->tabel_potongan_keterlambatan)->count_all_results();
                }

            # tamil data potongan
            public function tampil_potongan($where = null)
            	{
            		if($where != null)
						{
							$tampil = $this->db->select('*')
										->from($this->tabel_potongan_keterlambatan)
										->where($where)
										->get()
										->result();
						}
					else
						{
							$tampil = $this->db->select('*')
										->from($this->tabel_potongan_keterlambatan)
										->get()
										->result();
						}

					return $tampil;
            	}

            # jumlah data potongan keterlambatan
            public function jumlah_potongan_keterlambatan($where = null)
            	{
            		if($where != null)
            			{
            				$tampil = $this->db->select('count(*) as jumlah')
										->from($this->tabel_potongan_keterlambatan)
										->where($where)
										->get()
										->result();
            			}
            		else
            			{
            				$tampil = $this->db->select('count(*) as jumlah')
										->from($this->tabel_potongan_keterlambatan)
										->where($where)
										->get()
										->result();
            			}

            		foreach($tampil as $tmpl)
            			{
            				$jumlah = $tmpl->jumlah;
            			}

            		return intval($jumlah);
            	}

            # cek menit potongan keterlambatan
            public function cek_menit_potongan($menit)
                {
                    $cek = $this->db->select('count(*) as jumlah')
                                    ->from($this->tabel_potongan_keterlambatan)
                                    ->where(array('jumlah_menit' => $menit))
                                    ->get()
                                    ->result();

                    foreach($cek as $c)
                        {
                            $jumlah = $c->jumlah;
                        }

                    if($jumlah == 0)
                        {
                            return true;
                        }
                    else
                        {
                            return false;
                        }
                }

            # update data potongan
            public function update_potongan_keterlambatan($where = array(),$data = array())
            	{
            		return $this->db->where($where)->update($this->tabel_potongan_keterlambatan,$data);
            	}

            # hapus potongan keterlambatan
			public function hapus_potongan_keterlambatan($where = array())
				{
					return $this->db->where($where)->delete($this->tabel_potongan_keterlambatan);
				}

            # DATATABLES KETERLAMBATAN KARYAWAN
            public function _get_datatables_query_keterlambatan_karyawan($where =  null)
                {
                    $keterlambatan  = $this->tabel_keterlambatan_karawan;
                    $absensi        = $this->tabel_absensi;
                    $karyawan       = $this->tabel_karyawan;
                    $potongan       = $this->tabel_potongan_keterlambatan;
                    if($where != null)
                        {
                            $this->db->select($keterlambatan.'.*,'.$absensi.'.*,'.$karyawan.'.*,'.$potongan.'.*')
                                    ->from($keterlambatan)
                                    ->join($potongan,$keterlambatan.'.id_potongan_keterlambatan='.$potongan.'.id_potongan_keterlambatan')
                                    ->join($absensi,$keterlambatan.".id_absensi=".$absensi.'.id_absensi')
                                    ->join($karyawan,$absensi.'.id_karyawan='.$karyawan.'.id_karyawan')
                                    ->where($where);
                        }
                    else
                        {
                             $this->db->select($keterlambatan.'.*,'.$absensi.'.*,'.$karyawan.'.*,'.$potongan.'.*')
                                    ->join($potongan,$keterlambatan.'.id_potongan_keterlambatan='.$potongan.'.id_potongan_keterlambatan')
                                    ->from($keterlambatan)
                                    ->join($absensi,$keterlambatan.".id_absensi=".$absensi.'.id_absensi')
                                    ->join($karyawan,$absensi.'.id_karyawan='.$karyawan.'.id_karyawan');
                        }

                    if(isset($_POST['order']))
                        {
                            $this->db->order_by($_POST['order'][0]['column'],$_POST['order'][0]['dir']);

                        }
                    else if(isset($this->order))
                        {
                            $order = $this->order;
                            $this->db->order_by(key($order),$order[key($order)]);
                        }
                }

            # Get datatables keterlambatan karyawan
            public function get_datatables_keterlambatan_karyawan($where = null)
                {
                    $this->_get_datatables_query_keterlambatan_karyawan($where);

                    if($_POST['length'] != -1)
                        {
                            $this->db->limit($_POST['length'],$_POST['start']);
                        }

                    $query = $this->db->get()->result();
                    return $query;
                }

            # count filtered datatables keterlambatan
            public function count_filtered_keterlambatan_karyawan($where = null)
                {
                    $this->_get_datatables_query_keterlambatan_karyawan($where);
                    $query = $this->db->get()->num_rows();
                    return $query;
                }

            # count all datatables
            public function count_all_keterlambatan_karyawan($where = null)
                {
                    $keterlambatan  = $this->tabel_keterlambatan_karawan;
                    $absensi        = $this->tabel_absensi;
                    $karyawan       = $this->tabel_karyawan;
                    $potongan       = $this->tabel_potongan_keterlambatan;

                    return $this->db->from($keterlambatan)
                                ->join($potongan,$keterlambatan.'.id_potongan_keterlambatan='.$potongan.'.id_potongan_keterlambatan')
                                ->join($absensi,$keterlambatan.".id_absensi=".$absensi.'.id_absensi')
                                ->join($karyawan,$absensi.'.id_karyawan='.$karyawan.'.id_karyawan')
                                ->count_all_results();
                }


		}