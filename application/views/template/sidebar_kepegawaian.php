<div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <!-- <a href="<?= site_url(); ?>" class="site_title"><i class=""></i> <span></span></a> -->
            </div>

            <div class="clearfix"></div>

            <!-- menu profile quick info -->
            <div class="profile clearfix">
              <div class="profile_pic">
                <!-- <img src="images/img.jpg" alt="..." class="img-circle profile_img"> -->
              </div>
              <!-- <div class="profile_info">
                <span>Welcome,</span>
                <h2>John Doe</h2>
              </div> -->
            </div>
            <!-- /menu profile quick info -->

            <br />

            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <hr></hr>
                <ul class="nav side-menu">
                  <li><a href="<?= site_url('pegawai');?>"><i class="fa fa-home"></i> Beranda </a></li>
                
                  <li><a><i class="fa fa-user"></i> Pegawai <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="<?= site_url('pegawai/tambah_pegawai');?>"><i class="fa fa-plus-square"></i> Tambah Pegawai</a></li>
                      <li><a href="<?= site_url('pegawai/lihat_pegawai');?>"><i class="fa fa-users"></i> lihat Pegawai</a></li>
                    </ul>
                  </li>

                  <li><a><i class="fa fa-black-tie"></i> Jabatan <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="<?= site_url('jabatan/tambah_jabatan');?>"><i class="fa fa-plus-square"></i> Tambah Jabatan</a></li>
                      <li><a href="<?= site_url('jabatan/lihat_jabatan');?>"><i class="fa fa-users"></i> lihat Jabatan</a></li>
                    </ul>
                  </li>

                  <li><a><i class="fa fa-universal-access"></i> Divisi <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="<?= site_url('divisi/tambah_divisi');?>"><i class="fa fa-plus-square"></i> Tambah Divisi</a></li>
                      <li><a href="<?= site_url('divisi/lihat_divisi');?>"><i class="fa fa-users"></i> lihat Divisi</a></li>
                    </ul>
                  </li>

                  <li><a><i class="fa fa-user-secret"></i> Absensi <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="<?= site_url('absensi/jam_kerja'); ?>"><i class="fa fa-calendar"></i> Jam Kerja</a></li>
                      <li><a href="<?= site_url('absensi/lihat_absen_karyawan'); ?>"><i class="fa fa-list"></i> Lihat Absensi</a></li>
                      <li><a href="<?= site_url('absensi/tambah_absen_karyawan'); ?>"><i class="fa fa-plus-square"></i> Tambah Absensi</a></li>
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