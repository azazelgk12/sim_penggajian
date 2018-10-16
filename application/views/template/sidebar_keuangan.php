<div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <!-- <a href="<?= site_url(); ?>" class="site_title"><i class=""></i> <span></span></a> -->
              <!-- <img src="<?= site_url('assets/images/logo.jpeg');?>" alt="..." class="profile_img"> -->
            </div>

            <div class="clearfix"></div>

            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <hr></hr>
                <ul class="nav side-menu">
                  <li><a href="<?= site_url('keuangan');?>"><i class="fa fa-home"></i> Beranda </a></li>
                
                  <li><a><i class="fa fa-calendar"></i> Keterlambatan <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="<?= site_url('keterlambatan/tambah_potongan');?>"><i class="fa fa-plus-square"></i> Tambah Potongan</a></li>
                      <li><a href="<?= site_url('keterlambatan/lihat_potongan');?>"><i class="fa fa-list"></i> lihat Potongan</a></li>
                       <li><a href="<?= site_url('keterlambatan/keterlambatan_karyawan');?>"><i class="fa fa-list"></i> Keterlambatan Karyawan</a></li>
                    </ul>
                  </li>

                  <li><a><i class="fa fa-money"></i> Penggajian <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a><i class="fa fa-money"></i> Gaji Pokok<span class="fa fa-chevron-down"></span></a>
                            <ul class="nav child_menu">
                              <li>
                                <a href="<?= site_url('penggajian/tambah_gapok');?>"><i class="fa fa-plus-square"></i> Tambah Gapok</a>  
                              </li>

                               <li>
                                <a href="<?= site_url('penggajian');?>"><i class="fa fa-list"></i> Lihat Gapok</a>  
                              </li>
                              
                            </ul>
                      </li>

                      <li><a><i class="fa fa-money"></i> Tunjangan<span class="fa fa-chevron-down"></span></a>
                            <ul class="nav child_menu">
                              <li>
                                <a href="<?= site_url('tunjangan/tambah_tunjangan');?>"><i class="fa fa-plus-square"></i> Tambah Tunjangan</a>  
                              </li>

                               <li>
                                <a href="<?= site_url('tunjangan');?>"><i class="fa fa-list"></i> Lihat Tunjangan</a>  
                              </li>

                               <li>
                                <a href="<?= site_url('tunjangan/tambah_master_tunjangan');?>"><i class="fa fa-plus-square"></i> Master Tunjangan</a>  
                              </li>

                               <li>
                                <a href="<?= site_url('tunjangan/master_tunjangan');?>"><i class="fa fa-list"></i> Lihat Master</a>  
                              </li>

                               <li>
                                <a href="<?= site_url('tunjangan/tambah_transportmakan');?>"><i class="fa fa-plus-square"></i> Tambah Transport & makan</a>  
                              </li>

                              <li>
                                <a href="<?= site_url('tunjangan/transportmakan');?>"><i class="fa fa-list"></i> Transport &  makan</a>  
                              </li>
                              
                            </ul>
                      </li>

                      <li><a href="<?= site_url('lemburan');?>"><i class="fa fa-money"></i> Lemburan </a></li>
                      <li><a href="<?= site_url('penggajian/lihat_penggajian');?>"><i class="fa fa-money"></i> Lihat Penggajian </a>
                      </li>
                      <li><a href="<?= site_url('penggajian/penggajian_karyawan');?>"><i class="fa fa-plus-square"></i> Tambah Penggajian </a></li>
                    
                    </ul>
                  </li>

                 
                  <li><a><i class="fa fa-money"></i> Master Akun <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="<?= site_url('akuntansi/tambah_akun');?>"><i class="fa fa-plus-square"></i> Tambah Akun</a></li>
                      <li><a href="<?= site_url('akuntansi/lihat_akun');?>"><i class="fa fa-list"></i> lihat Akun</a></li>
                      
                    </ul>
                  </li>

                  <li><a><i class="fa fa-money"></i> Jurnal <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <!-- <li><a href="<?= site_url('jurnal/tambah_jurnal');?>"><i class="fa fa-plus-square"></i> Tambah Jurnal</a></li> -->
                      <li><a href="<?= site_url('jurnal');?>"><i class="fa fa-list"></i> lihat Jurnal</a></li>
                      
                    </ul>
                  </li>
                  

                </ul>
              </div>
             

            </div>
            <!-- /sidebar menu -->

            <!-- /menu footer buttons -->
            <div class="sidebar-footer hidden-small">
              <!-- <a data-toggle="tooltip" data-placement="top" title="Settings">
                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Lock">
                <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
              </a> -->
              <a data-toggle="tooltip" data-placement="top" title="Logout" href="<?= site_url('akun/logout');?>">
                <span class="fa fa-sign-out" aria-hidden="true"></span>
              </a>
            </div>
            <!-- /menu footer buttons -->
          </div>
        </div>