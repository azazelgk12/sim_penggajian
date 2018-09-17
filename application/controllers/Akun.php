<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    class Akun extends CI_Controller
        {
            public function __construct()
                {
                    parent::__construct();
                    $this->load->model("M_user");
                    $this->load->model('M_pegawai');
                }
            
            public static function index()
                {
                    $CI =& get_instance();
                    $CI->load->view('user/login');
                    
                }
            
            public static function registrasi()
                {
                    $CI =& get_instance();
                    $data = array(
                        'pegawai'   => $CI->M_pegawai->tampil_pegawai(),
                    );
                    $CI->load->view('user/registrasi',$data);
                }
            
            # Enkripsi Password
            private static function enkripsi($kata)
                {
                    $encrypt = md5($kata);
                    return $encrypt;
                }
            
            # Login User
            public static function login()
                {
                    $CI =& get_instance();

                    # Data Login User
                    $data = array(
                        'username'  => $CI->input->post('username'),
                        'password'  => $CI->enkripsi($CI->input->post('password')),
                    );


                    $jumlah = $CI->M_user->jumlah_user($data);

                    if($jumlah == 1)
                        {
                            $data_user = $CI->M_user->tampil_data_user($data);

                            foreach($data_user as $du)
                                {
                                    $CI->session->set_userdata('username',$du->username);
                                    $CI->session->set_userdata('jabatan',$du->nama_jabatan);
                                    $CI->session->set_userdata('divisi',$du->nama_divisi);
                                    $CI->session->set_userdata('nama_petugas',$du->nama);

                                    if($du->nama_jabatan == 'STAFF ADMINISTRASI')
                                        {
                                            redirect(site_url('pegawai'));
                                        }
                                    else if($du->nama_jabatan == 'STAFF AKUNTING')
                                        {
                                             redirect(site_url('keuangan'));
                                        }
                                    else
                                        {
                                             redirect(site_url());
                                        }
                                }
                            // var_dump($data_user);
                        }
                    else
                        {
                            redirect(site_url());
                        }
                    # cek login sementara sebelum menggunakan database
                    // $pass = $CI->enkripsi('admin');

                    // if($data['password'] == $pass && $data['username'] == 'admin')
                    // 	{
                    // 		$CI->session->set_userdata('username',$data['username']);
                    //         redirect(site_url().'kdd');
                    // 	}
                    // else
                    //     {
                    //         $CI->session->set_flashdata('status_login','gagal');
                    //         redirect(site_url().'akun');
                    //     }

                    // # Cek Data User apakah tersedia ataukan tidak pada database
                    // $cek_data = $CI->M_user->jumlahData($data);

                    // if($cek_data == 1)
                    //     {
                    //         $CI->session->set_userdata('username',$data['username']);
                    //         redirect(site_url().'kdd');
                    //     }
                    // else
                    //     {
                    //         $CI->session->set_flashdata('status_login','gagal');
                    //         redirect(site_url().'akun');
                    //     }
                    
                    

                    
                }
            
            # register user User
            public static function register()
                {
                    $CI =& get_instance();


                    $data = array(
                        'id_karyawan'   => $CI->input->post('pegawai'),                 
                        'username'      => $CI->input->post('username'),
                      
                        'password'      => $CI->enkripsi($CI->input->post('password')),
                        'created_at'    => date("Y-m-d H:i:s"),
                       
                    );

                    
                    # Form validation
                    # $et config form validation
                    
                    $config = array(
                        # pegawai
                        array(
                            'field'     => 'pegawai',
                            'label'     => 'Pegawai',
                            'rules'     => 'required',
                            'errors'    => array(
                                                'required'      => 'Pegawai tidak boleh kosong',
                                            ),
                        ),  
                        # username
                        array(
                            'field'     => 'username',
                            'label'     => 'Username',
                            'rules'     => 'required|trim|max_length[100]|min_length[5]|is_unique[user.username]',
                            'errors'    => array(
                                'required'      => 'Username tidak boleh kosong',
                                'max_length'    => 'Username tidak boleh lebih dari 100 karakter',
                                'min_length'    => 'Username minimal harus mempunyai 5 karakter',
                                'is_unique'     => 'Username sudah digunakan, silahkan gunakan username lain',
                            ),
                        ),

                      

                        # Password
                        array(
                            'field'     => 'password',
                            'label'     => 'Password',
                            'rules'     => 'required|min_length[6]|max_length[50]|trim',
                            'errors'    => array(
                                'required'      => "Password tidak boleh kosong",
                                'min_length'    => 'Password harus mempunyai minimal 6 karakter',
                                'max_length'    => 'Password tidak boleh lebih dari 50 karakter',
                            ),
                        ),

                        # Password Conf
                        array(
                            'field'     => 'password_conf',
                            'label'     => 'Password Conf',
                            'rules'     => 'required|min_length[6]|max_length[50]|trim|matches[password]',
                            'errors'    => array(
                                'required'      => "Password tidak boleh kosong",
                                'min_length'    => 'Password harus mempunyai minimal 6 karakter',
                                'max_length'    => 'Password tidak boleh lebih dari 50 karakter',
                                'matches'       => 'Password tidak sesuai',
                            ),
                        ),
                    );

                    $CI->form_validation->set_rules($config);
                    
                    # Running form validation
                    if($CI->form_validation->run() == FALSE)
                        {
                            // $CI->session->set_flashdata('status_register','gagal');
                            $CI->session->set_flashdata('old_username',$data['username']);
                            $CI->session->set_flashdata('old_email',$data['email']);
                            $CI->session->set_flashdata('old_password',$CI->input->post('password'));
                            // redirect(site_url().'akun#signup');
                            $data = array(
                                'pegawai' => $CI->M_pegawai->tampil_pegawai(),
                            );
                            $CI->load->view('user/registrasi',$data);
                        }
                    else
                        {
                            # Tambah data User
                            $tambahUser = $CI->M_user->tambahData($data);
                   
                            if($tambahUser == true)
                                {
                                    $CI->session->set_flashdata('status_register','berhasil');
                                    redirect(site_url().'akun');
                                    
                                }
                            else
                                {
                                    $CI->session->set_flashdata('old_username',$data['username']);
                                    $CI->session->set_flashdata('old_email',$data['email']);
                                    $CI->session->set_flashdata('status_register','gagal');
                                    redirect(site_url().'akun/registrasi');
                                }

                            // print_r($data);
                        }
                    
                    
                    
                }
            
            # Logout User
            public static function logout()
                {
                    $CI =& get_instance();
                    $CI->session->unset_userdata('username');
                    $CI->session->unset_userdata('edit_id_tempat');
                    $CI->session->unset_userdata('edit_nama_tempat');
                    $CI->session->unset_userdata('edit_id_kdd');
                    $CI->session->unset_userdata('edit_nama_kdd');
                    $CI->session->unset_userdata('jabatan');
                    $CI->session->unset_userdata('divisi');
                    $CI->session->unset_userdata('nama_petugas');
                    redirect(site_url().'akun');
                }
        }