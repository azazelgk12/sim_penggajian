<?php
	class M_divisi extends CI_Model
		{
			private $tabel_divisi	= 'divisi';

			# datatables
			private $kolom_order	= array(
										null,
										'kode_divisi',
										'nama_divisi',
									 );

			private $kolom_cari		= array(
										'kode_divisi',
										'nama_divisi',
									 );

			# tambah divisi
			public function tambah_divisi($data = array())
				{
					return $this->db->insert($this->tabel_divisi,$data);
				}

			# hapus divisi
			public function hapus_divisi($where = array())
				{
					return $this->db->where($where)->delete($this->tabel_divisi);
				}

			# update divisi
			public function update_divisi($data = array(), $where = array())
				{
					return $this->db->where($where)->update($this->tabel_divisi,$data);
				}

			# tampil data divisi
			public function tampil_divisi($where = null)
				{
					if($where != null)
						{
							$tampil = $this->db->select('*')
										->from($this->tabel_divisi)
										->where($where)
										->get()
										->result();
						}
					else
						{
							$tampil = $this->db->select('*')
										->from($this->tabel_divisi)
										->get()
										->result();
						}

					return $tampil;
				}

			################
			## Datatables ##
			################
			
			 # Get query datatables
            public function _get_datatables_query()
                {
                    # memilih tabel divisi
                    $this->db->from($this->tabel_divisi);

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
                    return $this->db->from($this->tabel_divisi)->count_all_results();
                }


            # cek nama divisi
            public function cek_nama_divisi($nama_divisi)
                {
                    $cek = $this->db->select('count(*) as jumlah')
                                    ->from($this->tabel_divisi)
                                    ->where(array('nama_divisi' => $nama_divisi))
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
			
		}