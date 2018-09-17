<?php 
	class M_penggajian extends CI_Model
		{
			private $tabel_gapok	    = "gapok";
			private $tabel_jabatan	    = 'jabatan';
            private $tabel_karyawan     = 'karyawan';
            private $tabel_penggajian   = 'penggajian_karyawan';
            private $tabel_divisi       = 'divisi';

            private $view_absen_gaji    = 'view_absen_penggajian';

			# datatables
			private $kolom_order	= array(
										null,
										'gapok.gaji_pokok',
										'karyawan.nama',
									 );

			private $kolom_cari		= array(
										'gapok.gaji_pokok',
										'karyawan.nama',
									 );

			public function tambah_gapok($data = array())
				{
					return $this->db->insert($this->tabel_gapok,$data);
				}

			################
			## Datatables ##
			################
			
			 # Get query datatables
            public function _get_datatables_query()
                {
                    # memilih tabel jabatan
                    $this->db->select($this->tabel_gapok.'.*,'.$this->tabel_karyawan.'.*');
                    $this->db->from($this->tabel_gapok);
                    $this->db->join($this->tabel_karyawan,$this->tabel_karyawan.'.id_karyawan='.$this->tabel_gapok.'.id_karyawan');

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
                    return $this->db->from($this->tabel_gapok)->count_all_results();
                }

             # tampil data gapok
             public function tampil_gapok($where = null)
             	{
             		if($where != null)
             			{
             				$tampil = $this->db->select('*')
             							->from($this->tabel_gapok)
             							->join($this->tabel_karyawan,$this->tabel_gapok.'.id_karyawan='.$this->tabel_karyawan.'.id_karyawan')
             							->where($where)
             							->get()
             							->result();
             			}
             		else
             			{
             				$tampil = $this->db->select('*')
             							->from($this->tabel_gapok)
             							->join($this->tabel_karyawan,$this->tabel_gapok.'.id_karyawan='.$this->tabel_karyawan.'.id_karyawan')
             							->get()
             							->result();
             			}

             		return $tampil;
             	}

            # jumlah data gapok 
            public function jumlah_data_gapok($where = null)
             	{
             		if($where != null)
             			{
             				$tampil = $this->db->select('count(*) as jumlah')
             							->from($this->tabel_gapok)
             							->join($this->tabel_jabatan,$this->tabel_gapok.'.id_jabatan='.$this->tabel_jabatan.'.id_jabatan')
             							->where($where)
             							->get()
             							->result();
             			}
             		else
             			{
             				$tampil = $this->db->select('count(*) as jumlah')
             							->from($this->tabel_gapok)
             							->join($this->tabel_jabatan,$this->tabel_gapok.'.id_jabatan='.$this->tabel_jabatan.'.id_jabatan')
             							->get()
             							->result();
             			}

             		foreach($tampil as $tmpl)
             			{
             				$jumlah = $tmpl->jumlah;
             			}

             		return $jumlah;
             	}

             #ubah data gapok
            public function ubah_data_gapok($where,$data = array())
            	{
            		return $this->db->where($where)->update($this->tabel_gapok,$data);
            	}

            #hapus gapok
            public function hapus_gapok($where)
            	{
            		return $this->db->where($where)->delete($this->tabel_gapok);
            	}

            # jumlah potongan
            public function jumlah_potongan($where = null)
                {
                    if($where != null)
                        {
                            $tampil = $this->db->select('sum(potongan_keterlambatan.jumlah_potongan) as jumlah')
                                        ->from('keterlambatan')
                                        ->join('potongan_keterlambatan','keterlambatan.id_potongan_keterlambatan=potongan_keterlambatan.id_potongan_keterlambatan')
                                        ->join('absensi','keterlambatan.id_absensi=absensi.id_absensi')
                                        ->join('karyawan','absensi.id_karyawan=karyawan.id_karyawan')
                                        ->where($where)
                                        ->get()
                                        ->result();

                        }
                    else
                        {  
                             $tampil =$this->db->select('sum(potongan_keterlambatan.jumlah_potongan) as jumlah')
                                        ->from('keterlambatan')
                                        ->join('potongan_keterlambatan','keterlambatan.id_potongan_keterlambatan=potongan_keterlambatan.id_potongan_keterlambatan')
                                        ->join('absensi','keterlambatan.id_absensi=absensi.id_absensi')
                                        ->join('karyawan','absensi.id_karyawan=karyawan.id_karyawan')
                                        ->get()
                                        ->result();
                        }
                    return $tampil;
                }

            # jumlah lemburan
            public function jumlah_lemburan($where = null)
                {
                     if($where != null)
                        {
                            $tampil = $this->db->select('sum(lemburan_karyawan.upah_lemburan) as jumlah')
                                        ->from('lemburan_karyawan')
                                        ->join('absensi','lemburan_karyawan.id_absensi=absensi.id_absensi')
                                        ->join('karyawan','absensi.id_karyawan=karyawan.id_karyawan')
                                        ->where($where)
                                        ->get()
                                        ->result();

                        }
                    else
                        {  
                             $tampil = $this->db->select('sum(lemburan_karyawan.upah_lemburan) as jumlah')
                                        ->from('lemburan_karyawan')
                                        ->join('absensi','lemburan_karyawan.id_absensi=absensi.id_absensi')
                                        ->join('karyawan','absensi.id_karyawan=karyawan.id_karyawan')
                                        ->get()
                                        ->result();
                        }
                    return $tampil;
                }

            # tunjangan karyawan
            public function jumlah_tunjangan($where = null)
                {
                    if($where != null)
                        {
                            $jumlah = $this->db->select('sum(jumlah_tunjangan) as jumlah')
                                        ->from('tunjangan_karyawan')
                                        ->where($where)
                                        ->get()
                                        ->result();
                        }
                    else
                        {
                            $jumlah = $this->db->select('sum(jumlah_tunjangan) as jumlah')
                                        ->from('tunjangan_karyawan')
                                        ->get()
                                        ->result();
                        }

                    return $jumlah;
                }

            # tambah penggajian karyawan
            public function tambah_penggajian($data = array())
                {
                    return $this->db->insert('penggajian_karyawan',$data);
                }

            # tampil penggajian 
            public function tampil_penggajian($where = null)
                {
                    if($where != null)
                        {
                            $tampil = $this->db->select('penggajian_karyawan.*,karyawan.*,jabatan.*,divisi.*')
                                        ->from('penggajian_karyawan')
                                        ->join('karyawan','penggajian_karyawan.id_karyawan = karyawan.id_karyawan')
                                        ->join('jabatan','karyawan.id_jabatan = jabatan.id_jabatan')
                                        ->join('divisi','jabatan.id_divisi = divisi.id_divisi')
                                        ->where($where)
                                        ->get()
                                        ->result();
                        }
                    else
                        {
                            $tampil = $this->db->select('penggajian_karyawan.*,karyawan.*,jabatan.*,divisi.*')
                                        ->from('penggajian_karyawan')
                                        ->join('karyawan','penggajian_karyawan.id_karyawan = karyawan.id_karyawan')
                                        ->join('jabatan','karyawan.id_jabatan = jabatan.id_jabatan')
                                        ->join('divisi','jabatan.id_divisi = divisi.id_divisi')
                                        ->get()
                                        ->result();
                        }
                    return $tampil;
                }

            # datatables penggajian
            public function _get_datatables_query_penggajian($where =  null)
                {
                   
                    if($where != null)
                        {
                            $this->db->select('penggajian_karyawan.*,karyawan.*,jabatan.*,divisi.*')
                                        ->from('penggajian_karyawan')
                                        ->join('karyawan','penggajian_karyawan.id_karyawan = karyawan.id_karyawan')
                                        ->join('jabatan','karyawan.id_jabatan = jabatan.id_jabatan')
                                        ->join('divisi','jabatan.id_divisi = divisi.id_divisi')
                                        ->where($where);
                        }
                    else
                        {
                             $this->db->select('penggajian_karyawan.*,karyawan.*,jabatan.*,divisi.*')
                                        ->from('penggajian_karyawan')
                                        ->join('karyawan','penggajian_karyawan.id_karyawan = karyawan.id_karyawan')
                                        ->join('jabatan','karyawan.id_jabatan = jabatan.id_jabatan')
                                        ->join('divisi','jabatan.id_divisi = divisi.id_divisi');
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
            public function get_datatables_penggajian($where = null)
                {
                    $this->_get_datatables_query_penggajian($where);

                    if($_POST['length'] != -1)
                        {
                            $this->db->limit($_POST['length'],$_POST['start']);
                        }

                    $query = $this->db->get()->result();
                    return $query;
                }

            # count filtered datatables keterlambatan
            public function count_filtered_penggajian($where = null)
                {
                    $this->_get_datatables_query_penggajian($where);
                    $query = $this->db->get()->num_rows();
                    return $query;
                }

            # count all datatables
            public function count_all_penggajian($where = null)
                {
                   
                    return $this->db->select('penggajian_karyawan.*,karyawan.*,jabatan.*,divisi.*')
                                ->from('penggajian_karyawan')
                                ->join('karyawan','penggajian_karyawan.id_karyawan = karyawan.id_karyawan')
                                ->join('jabatan','karyawan.id_jabatan = jabatan.id_jabatan')
                                ->join('divisi','jabatan.id_divisi = divisi.id_divisi')
                                ->count_all_results();
                }

             #hapus penggajian
            public function hapus_penggajian($where)
                {
                    return $this->db->where($where)->delete($this->tabel_penggajian);
                }

            # tampil penggajian_karyawan
            public function tampil_penggajian_karyawan($where = null)
                {
                    if($where != null)
                        {
                            $tampil = $this->db->select('*')
                                    ->from('view_penggajian_karyawan')
                                    ->where($where)
                                    ->get()
                                    ->result();
                        }
                    else
                        {
                            $tampil = $this->db->select('*')
                                    ->from('view_penggajian_karyawan')
                                    ->get()
                                    ->result();
                        }

                    return $tampil;
                }
            
            # DATATABLES DATA KARYAWAN
            public function _get_datatables_query_karyawan($where =  null)
                {
                   
                    if($where != null)
                        {
                            $this->db->select('karyawan.*,jabatan.*,divisi.*')
                                        ->from('karyawan')
                                       
                                        ->join('jabatan','karyawan.id_jabatan = jabatan.id_jabatan')
                                        ->join('divisi','jabatan.id_divisi = divisi.id_divisi')
                                        ->where($where);
                        }
                    else
                        {
                             $this->db->select('karyawan.*,jabatan.*,divisi.*')
                                        ->from('karyawan')
                                        ->join('jabatan','karyawan.id_jabatan = jabatan.id_jabatan')
                                        ->join('divisi','jabatan.id_divisi = divisi.id_divisi');
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

            # Get datatables  karyawan
            public function get_datatables_karyawan($where = null)
                {
                    $this->_get_datatables_query_karyawan($where);

                    if($_POST['length'] != -1)
                        {
                            $this->db->limit($_POST['length'],$_POST['start']);
                        }

                    $query = $this->db->get()->result();
                    return $query;
                }

            # count filtered datatables keterlambatan
            public function count_filtered_karyawan($where = null)
                {
                    $this->_get_datatables_query_karyawan($where);
                    $query = $this->db->get()->num_rows();
                    return $query;
                }

            # count all datatables
            public function count_all_karyawan($where = null)
                {
                   
                    return $this->db->select('karyawan.*,jabatan.*,divisi.*')
                                ->from('karyawan')
                                ->join('jabatan','karyawan.id_jabatan = jabatan.id_jabatan')
                                ->join('divisi','jabatan.id_divisi = divisi.id_divisi')
                                ->count_all_results();
                }

            # tampil absen dan penggajian (tanpa tunjangan)
            public function tampil_absen_gaji($where = null)
                {
                    if($where != null)
                        {
                            $tampil = $this->db->select('*')
                                        ->from($this->view_absen_gaji)
                                        ->where($where);
                        }
                    else
                        {
                            $tampil = $this->db->select('*')
                                        ->from($this->view_absen_gaji);
                        }

                    return $tampil;
                }

            # tampil gaji karyawan
            public function tampil_gaji_karyawan($where = null)
                {
                    if($where != null)
                        {
                            $query = $this->db->select('*')
                                        ->from('penggajian_karyawan')
                                        ->where($where);                       
                        }
                    else
                        {
                            $query = $this->db->select('*')
                                        ->from('penggajian_karyawan');
                        }

                    return $query;
                }

            public function testing($data = array())
                {
                    return $this->db->insert('testing',$data);
                }

			
		}