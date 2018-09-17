<?php
	class M_lemburan extends CI_Model
		{
			private $tbl_lemburan		= 'lemburan_karyawan';
			private $tbl_absensi		= 'absensi';
			private $tbl_karyawan		= 'karyawan';

			public function tampil_lemburan($where = null)
				{
					if($where != null)
						{
							$tampil = $this->db->select("a.*,b.*,c.*")
										->from($this->tbl_lemburan ." a")
										->join($this->tbl_absensi ." b",'a.id_absenssi = b,id_absensi')
										->join($this->tbl_karyawan .' c','b.id_karyawan = c.id_karyawan')
										->where($where)
										->get()
										->result();
						}
					else
						{
							$tampil = $this->db->select("a.*,b.*,c.*")
										->from($this->tbl_lemburan ." a")
										->join($this->tbl_absensi ." b",'a.id_absenssi = b,id_absensi')
										->join($this->tbl_karyawan .' c','b.id_karyawan = c.id_karyawan')
										->get()
										->result();
						}

					return $tampil;
				}
			
			# DATATABLES LEMBURAN KARYAWAN
			# DATATABLES KETERLAMBATAN KARYAWAN
            public function _get_datatables_query_lemburan_karyawan($where =  null)
                {
                    
                    if($where != null)
                        {
                            $this->db->select($this->tbl_lemburan.".*,".$this->tbl_absensi.".*,".$this->tbl_karyawan.".*")
                                    ->from($this->tbl_lemburan)
                                    ->join($this->tbl_absensi,$this->tbl_lemburan.".id_absensi = ".$this->tbl_absensi.".id_absensi")
                                    ->join($this->tbl_karyawan,$this->tbl_absensi.".id_karyawan = ".$this->tbl_karyawan.'.id_karyawan')
                                    ->where($where);

                        }
                    else
                        {
                            $this->db->select($this->tbl_lemburan.".*,".$this->tbl_absensi.".*,".$this->tbl_karyawan.".*")
                                    ->from($this->tbl_lemburan)
                                    ->join($this->tbl_absensi,$this->tbl_lemburan.".id_absensi = ".$this->tbl_absensi.".id_absensi")
                                    ->join($this->tbl_karyawan,$this->tbl_absensi.".id_karyawan = ".$this->tbl_karyawan.'.id_karyawan');
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

             # Get datatables lemburan karyawan
            public function get_datatables_lemburan_karyawan($where = null)
                {
                    $this->_get_datatables_query_lemburan_karyawan($where);

                    if($_POST['length'] != -1)
                        {
                            $this->db->limit($_POST['length'],$_POST['start']);
                        }

                    $query = $this->db->get()->result();
                    return $query;
                }

            # count filtered datatables lemburan karyawan
            public function count_filtered_lemburan_karyawan($where = null)
                {
                    $this->_get_datatables_query_lemburan_karyawan($where);
                    $query = $this->db->get()->num_rows();
                    return $query;
                }

            # count all datatables lemburan karyawan
            public function count_all_lemburan_karyawan()
                {
                    
                    return $this->db->from($this->tbl_lemburan)
                                ->join($this->tbl_absensi,$this->tbl_lemburan.".id_absensi = ".$this->tbl_absensi.".id_absensi")
                                ->join($this->tbl_karyawan,$this->tbl_absensi.".id_karyawan = ".$this->tbl_karyawan.'.id_karyawan')
                                ->count_all_results();
                }

		}