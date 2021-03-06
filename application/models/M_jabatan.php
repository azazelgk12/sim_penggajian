<?php
	class M_jabatan extends CI_Model
		{
			private $tabel_jabatan	= 'jabatan';
			private $tabel_divisi	= 'divisi';

			# datatables
			private $kolom_order	= array(
										null,
										'jabatan.kode_jabatan',
										'jabatan.nama_jabatan',
										'divisi.kode_divisi',
										'divisi.nama_divisi',
									 );

			private $kolom_cari		= array(
										'jabatan.kode_jabatan',
										'jabatan.nama_jabatan',
										'divisi.kode_divisi',
										'divisi.nama_divisi',
									 );

			# tampil data jabatan 
			public function tampil_jabatan($where = null)
				{
					if($where != null)
						{
							$tampil = $this->db->select('jabatan.*, divisi.*')
										->from($this->tabel_jabatan)
										->join($this->tabel_divisi,$this->tabel_jabatan.'.id_divisi='.$this->tabel_divisi.'.id_divisi')
										->where($where)
										->get()
										->result();
						}
					else
						{
							$tampil = $this->db->select('jabatan.*, divisi.*')
										->from($this->tabel_jabatan)
										->join($this->tabel_divisi,$this->tabel_jabatan.'.id_divisi='.$this->tabel_divisi.'.id_divisi')
										->get()
										->result();
						}

					return $tampil;
				}

			# hapus jabatan
			public function hapus_jabatan($where = array())
				{
					return $this->db->where($where)->delete($this->tabel_jabatan);
				}

			# update data jabatan
			public function update_jabatan($data = array(), $where = array())
				{
					return $this->db->where($where)->update($this->tabel_jabatan,$data);
				}

			# tambah jabatan
			public function tambah_jabatan($data = array())
				{
					return $this->db->insert($this->tabel_jabatan,$data);
				}

			################
			## Datatables ##
			################
			
			 # Get query datatables
            public function _get_datatables_query()
                {
                    # memilih tabel jabatan
                    $this->db->select($this->tabel_jabatan.'.*,'.$this->tabel_divisi.'.*');
                    $this->db->from($this->tabel_jabatan);
                    $this->db->join($this->tabel_divisi,$this->tabel_jabatan.'.id_divisi='.$this->tabel_divisi.'.id_divisi');

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

            # cek nama jabatan
             public function cek_nama_jabatan($jabatan)
                {
                    $cek = $this->db->select('count(*) as jumlah')
                                    ->from($this->tabel_jabatan)
                                    ->where(array('nama_jabatan' => $jabatan))
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