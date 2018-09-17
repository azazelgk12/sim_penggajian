<?php 
	class M_absensi extends CI_Model
		{
			private $tabel_jam_kerja 		= 'shift';
			private $tabel_absensi			= 'absensi';
			private $tabel_karyawan			= 'karyawan';
			private $tabel_jabatan			= 'jabatan';
			private $tabel_divisi			= 'divisi';
			private $tabel_keterlambatan	= 'keterlambatan';
			private $tabel_lemburan			= 'lemburan_karyawan';

			public function cek_jam_kerja()
				{
					$cek = $this->db->select('count(*) as jumlah')
							->from($this->tabel_jam_kerja)
							->get()
							->result();

					foreach($cek as $c)
						{
							$jumlah = $c->jumlah;
						}

					return $jumlah;
				}

			public function tampil_jam_kerja($where = null)
				{
					if($where != null)
						{
							$tampil = $this->db->select('*')
										->from($this->tabel_jam_kerja)
										->where($where)
										->get()
										->result();
						}
					else
						{
							$tampil = $this->db->select('*')
										->from($this->tabel_jam_kerja)
										->get()
										->result();
						}

					return $tampil;

				}

			public function tambah_jam_kerja($data = array())
				{
					return $this->db->insert($this->tabel_jam_kerja,$data);
				}

			public function update_jam_kerja($data = array(), $where = array())
				{
					return $this->db->where($where)->update($this->tabel_jam_kerja,$data);
				}

			# hapus  jam kerja
			public function hapus_jam_kerja($where = array())
				{
					return $this->db->where($where)->delete($this->tabel_jam_kerja);
				}

			# jumlah  absen karyawan
			public function jumlah_absen_karyawan($where = null)
				{
					if($where != null)
						{
							$cek = $this->db->select('count(*) as jumlah')
									->from($this->tabel_absensi)
									->join($this->tabel_karyawan,$this->tabel_absensi.'.id_karyawan='.$this->tabel_karyawan.'.id_karyawan')
									->join($this->tabel_jabatan,$this->tabel_karyawan.'.id_jabatan='.$this->tabel_jabatan.'.id_jabatan')
									->join($this->tabel_divisi,$this->tabel_jabatan.'.id_divisi='.$this->tabel_divisi.'.id_divisi')
									->where($where)
									->get()
									->result();
						}
					else
						{
							$cek = $this->db->select('count(*) as jumlah')
									->from($this->tabel_absensi)
									->join($this->tabel_karyawan,$this->tabel_absensi.'.id_karyawan='.$this->tabel_karyawan.'.id_karyawan')
									->join($this->tabel_jabatan,$this->tabel_karyawan.'.id_jabatan='.$this->tabel_jabatan.'.id_jabatan')
									->join($this->tabel_divisi,$this->tabel_jabatan.'.id_divisi='.$this->tabel_divisi.'.id_divisi')
									->get()
									->result();
						}

					foreach($cek as $c)
						{
							$jumlah = $c->jumlah;
						}

					return intval($jumlah);
				}

			# input keterlambatan
			public function tambah_keterlambatan($data = array())
				{
					return $this->db->insert($this->tabel_keterlambatan,$data);
				}
			# input absensi
			public function tambah_absen($data = array())
				{
					return $this->db->insert($this->tabel_absensi,$data);
				}

			# update absensi
			public function update_absensi($data = array(), $where = array())
				{
					return $this->db->where($where)->update($this->tabel_absensi,$data);
				}


			#tampil absensi
			public function tampil_absensi($where = null)
				{
					if($where != null)
						{
							$tampil = $this->db->select('*')
										->from($this->tabel_absensi)
										->where($where)
										->get()
										->result();
						}
					else
						{
							$tampil = $this->db->select('*')
										->from($this->tabel_absensi)
										->get()
										->result();	
						}

					return $tampil;
				}

			# tambah data lemburan
			public function tambah_lemburan($data = array())
				{
					return $this->db->insert($this->tabel_lemburan,$data);
				}

			# tampil absensi karyawan
			public function tampil_absensi_karyawan($where = null)
				{
					if($where != null)
						{
							$tampil = $this->db->select($this->tabel_absensi.".*,".$this->tabel_karyawan.".*, jabatan.*,divisi.*")
										->from($this->tabel_absensi)
										->join($this->tabel_karyawan,$this->tabel_absensi.".id_karyawan=".$this->tabel_karyawan.".id_karyawan")
										->join('jabatan','karyawan.id_jabatan = jabatan.id_jabatan')
										->join('divisi','jabatan.id_divisi = divisi.id_divisi')
										->where($where)
										->get()
										->result();
						}
					else
						{
							$tampil = $this->db->select($this->tabel_absensi.".*,".$this->tabel_karyawan.".*,jabatan.*, divisi.*")
										->from($this->tabel_absensi)
										->join($this->tabel_karyawan,$this->tabel_absensi.".id_karyawan=".$this->tabel_karyawan.".id_karyawan")
										->join('jabatan','karyawan.id_jabatan = jabatan.id_jabatan')
										->join('divisi','jabatan.id_divisi = divisi.id_divisi')
										->get()
										->result();
						}

					return $tampil;
				}

			# update absensi kerja karyawan
			public function update_abseen_karyawan($where,$data = array())
				{
					return $this->db->where($where)->update($this->tabel_absensi,$data);
				}

			# get datatatables query absensi karyawan
			public function _get_datatables_query_absen_karyawan($where = null)
				{
					if($where != null)
						{
							$this->db->select($this->tabel_absensi.".*,".$this->tabel_karyawan.".*")
								->from($this->tabel_absensi)
								->join($this->tabel_karyawan,$this->tabel_absensi.".id_karyawan=".$this->tabel_karyawan.".id_karyawan")
								->where($where);
						}
					else
						{
							$this->db->select($this->tabel_absensi.".*,".$this->tabel_karyawan.".*")
								->from($this->tabel_absensi)
								->join($this->tabel_karyawan,$this->tabel_absensi.".id_karyawan=".$this->tabel_karyawan.".id_karyawan");
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

			 # Get datatables absensi karyawan
            public function get_datatables_absen_karyawan($where = null)
                {
                    $this->_get_datatables_query_absen_karyawan($where);

                    if($_POST['length'] != -1)
                        {
                            $this->db->limit($_POST['length'],$_POST['start']);
                        }

                    $query = $this->db->get()->result();
                    return $query;
                }

            # count filtered datatables lemburan karyawan
            public function count_filtered_absen_karyawan($where = null)
                {
                    $this->_get_datatables_query_absen_karyawan($where);
                    $query = $this->db->get()->num_rows();
                    return $query;
                }

            # count all datatables lemburan karyawan
            public function count_all_absen_karyawan()
                {
                    
                    return $this->db->select($this->tabel_absensi.".*,".$this->tabel_karyawan.".*")
								->from($this->tabel_absensi)
								->join($this->tabel_karyawan,$this->tabel_absensi.".id_karyawan=".$this->tabel_karyawan.".id_karyawan")
                                ->count_all_results();
                }

            # hapus absensi karyawan
            public function hapus_absensi_karyawan($where)
            	{
            		return $this->db->where($where)->delete($this->tabel_absensi);
            	}

            #edit data absen karyawan
            public function edit_absen_karyawan($where,$data = array())
            	{
            		return $this->db->where($where)->update($this->tabel_absensi,$data);
            	}

		}