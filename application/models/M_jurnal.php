<?php 
	class M_jurnal extends CI_Model
		{
			private $tabel_jurnal	= 'jurnal';
			private $view_jurnal	= 'view_jurnal';

			private $kolom_order	= array(
										null,
										'kode_jurnal',
										'kode_akun',
										'tgl',
										'debet',
										'kredit',
										'nama_akun',
									 );

			private $kolom_cari		= array(
										'kode_jurnal',
										'kode_akun',
										'tgl',
										'debet',
										'kredit',
										'nama_akun',
									 );

			public function tambah_jurnal($data = array())
				{
					return $this->db->insert($this->tabel_jurnal,$data);
				}

			public function tampil_jurnal($where = null)
				{
					if($where != null)
						{
							$query = $this->db->select('*')
									->from($this->view_jurnal)
									->where($where);
						}
					else
						{
							$query = $this->db->select('*')
									->from($this->view_jurnal);
						}

					return $query;
				}

			################
			## Datatables ##
			################
			
			 # Get query datatables
            public function _get_datatables_query()
                {
                    # memilih tabel jabatan
                    $this->db->select('*');
                    $this->db->from($this->view_jurnal);
                    $this->db->group_by('kode_jurnal');
                  

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
                    return $this->db->from($this->view_jurnal)->group_by('kode_jurnal')->count_all_results();
                }


            # update jurnal
            public function edit_jurnal($where, $data= array())
            	{
            		return $this->db->where($where)->update('jurnal',$data);
            	}

            # datatables jurnal
            # DATATABLES DATA jurnal
            public function _get_datatables_query_jurnal($where =  null)
                {
                   
                    if($where != null)
                        {
                            $this->db->select('*')
                                        ->from('view_jurnal')
                                        ->where($where)
                                        ->group_by('kode_jurnal');
                        }
                    else
                        {
                            $this->db->select('*')
                                        ->from('view_jurnal')
                                        ->group_by('kode_jurnal');
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

            # Get datatables  jurnal
            public function get_datatables_jurnal($where = null)
                {
                    $this->_get_datatables_query_jurnal($where);

                    if($_POST['length'] != -1)
                        {
                            $this->db->limit($_POST['length'],$_POST['start']);
                        }

                    $query = $this->db->get()->result();
                    return $query;
                }

            # count filtered datatables keterlambatan
            public function count_filtered_jurnal($where = null)
                {
                    
                    $this->_get_datatables_query_jurnal($where);
                    $query = $this->db->get()->num_rows();
                    return $query;
                }

            # count all datatables
            public function count_all_jurnal($where = null)
                {
                   
                    return $this->db->select('*')
                                ->from('view_jurnal')
                                ->count_all_results();
                }

		}