<?php
    class M_user extends CI_Model
        {
            private $table          = 'user';
            private $tabel_karyawan = 'karyawan';
            private $tabel_jabatan  = 'jabatan';
            private $tabel_divisi   = 'divisi';

            public function jumlahData($where = null)
                {
                    # Cek apakan kondisi null ataukah tidak
                    if($where != null)
                        {
                            $query = $this->db->select("count(*) as jumlah")
                                                ->from($this->table)
                                                ->where($where)
                                                ->get()
                                                ->result();
                        }
                    else
                        {
                            $query = $this->db->select("count(*) as jumlah")
                                                ->from($this->table)
                                                ->get()
                                                ->result();
                        }
                    
                    foreach($query as $q)
                        {
                            $jumlah = intval($q->jumlah);
                        }
                    
                    # Mengembalikan nilai jumlah
                    return $jumlah;
                }
            
            # Tambah data user
            public function tambahData($data = array())
                {
                    $input = $this->db->insert($this->table,$data);

                    if($input)
                        {
                            return true;
                        }
                    else
                        {
                            return false;
                        }
                }
            

            public function tampil_data_user($where = null)
                { 
                    if($where != null)
                        {
                            $tampil = $this->db->select('user.*,karyawan.*,jabatan.*,divisi.*')
                                        ->from('user')
                                        ->join('karyawan','user.id_karyawan=karyawan.id_karyawan')
                                        ->join('jabatan','karyawan.id_jabatan=jabatan.id_jabatan')
                                        ->join('divisi','jabatan.id_divisi=divisi.id_divisi')
                                        ->where($where)
                                        ->get()
                                        ->result();
                        }
                    else
                        {
                            $tampil = $this->db->select('user.*,karyawan.*,jabatan.*,divisi.*')
                                        ->from('user')
                                        ->join('karyawan','user.id_karyawan=karyawan.id_karyawan')
                                        ->join('jabatan','karyawan.id_jabatan=jabatan.id_jabatan')
                                        ->join('divisi','jabatan.id_divisi=divisi.id_divisi')
                                        ->get()
                                        ->result();
                        }

                    return $tampil;
                }

            public function jumlah_user($where = null)
                {
                    if($where != null)
                        {
                            $jumlah = $this->db->select('user.*,karyawan.*,jabatan.*,divisi.*')
                                        ->from('user')
                                        ->join('karyawan','user.id_karyawan=karyawan.id_karyawan')
                                        ->join('jabatan','karyawan.id_jabatan=jabatan.id_jabatan')
                                        ->join('divisi','jabatan.id_divisi=divisi.id_divisi')
                                        ->where($where)
                                        ->count_all_results();
                        }
                    else
                        {
                            $jumlah = $this->db->select('user.*,karyawan.*,jabatan.*,divisi.*')
                                        ->from('user')
                                        ->join('karyawan','user.id_karyawan=karyawan.id_karyawan')
                                        ->join('jabatan','karyawan.id_jabatan=jabatan.id_jabatan')
                                        ->join('divisi','jabatan.id_divisi=divisi.id_divisi')
                                        ->count_all_results();
                        }

                    return $jumlah;
                }
        }