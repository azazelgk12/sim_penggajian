<?php 
	class M_akun extends CI_Model
		{
			private $tabel_akun 	= 'akun';

			private $kolom_order	= array(
										null,
										'nama_akun',
										'keterangan',
									 );

			private $kolom_cari		= array(
										'nama_akun',
										'keterangan',
									 );

			# query akun
			public function data_akun($where = null)
				{
					if($where != null)
						{
							$query = $this->db->select('*')
									->from($this->tabel_akun)
									->where($where);
						}
					else
						{
							$query = $this->db->select('*')
									->from($this->tabel_akun);
						}

					return $query;
				}
			# tambah data akun
			public function tambah_akun($data = array())
				{
					return $this->db->insert($this->tabel_akun,$data);
				}

			# tampil akun
			public function tampil_akun($where = null)
				{
					if($where != null)
						{
							$query = $this->db->select('*')
									->from($this->tabel_akun)
									->where($where)
									->get()
									->result();
						}
					else
						{
							$query = $this->db->select('*')
									->from($this->tabel_akun)
									->get()
									->result();
						}

					return $query;
				}

			#edit akun
			public function edit_akun($where,$data = array())
				{
					return $this->db->where($where)->update($this->tabel_akun,$data);
				}

			# hapus akun
			public function hapus_akun($where)
				{
					return $this->db->where($where)->delete($this->tabel_akun);
				}

			################
			## Datatables ##
			################
			
			 # Get query datatables
            public function _get_datatables_query()
                {
                    # memilih tabel jabatan
                    $this->db->select('*');
                    $this->db->from($this->tabel_akun);
                  

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
                    return $this->db->from($this->tabel_akun)->count_all_results();
                }

		}