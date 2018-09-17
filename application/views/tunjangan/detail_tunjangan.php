 <?php $CI =& get_instance(); ?>
 <script>
   function hapus(id,idKaryawan){
      var hps = confirm('Apakah anda yakin akan menghapus tunjangan ini ?');

      if(hps == true){
        var conf  = confirm('Anda setuju ?');

        if(conf == true){
          window.location = "<?= site_url('tunjangan/hapus_tunjangan_karyawan/'); ?>"+id+"/"+idKaryawan;
        }
        else{
          return false;
        }
      }
      else{
        return false;
      }
   }
 </script>
 <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3><?= $title_page; ?></h3>
              </div>

             
            
            <div class="clearfix"></div>

            <div class="col-md-12">
                <?php

                if($CI->session->flashdata('status_hapus_tunjangan')== 'berhasil')
                    {
            ?>
                        <div class="alert alert-success alert-dismissible fade in" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                            </button>
                            <strong>Sukses!</strong> Data tunjangan karyawan berhasil dihapus.
                        </div>
            <?php
                    }
                else if($CI->session->flashdata('status_hapus_tunjangan')== "gagal")
                    {
            ?>
                        <div class="alert alert-danger alert-dismissible fade in" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                            </button>
                            <strong>Maaf!</strong> Data tunjangan karyawan gagal dihapus.
                        </div>
            <?php
                    }

            ?>
            </div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Daftar Tunjangan</h2>
                    

                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <div class="col-md-3 col-sm-3 col-xs-12 profile_left">
                      <?php 
                        foreach($karyawan as $k){}
                        if($k->jk == "LAKI-LAKI")
                          {
                            $image = site_url('assets/images/male.jpg');
                          }
                        else
                          {
                            $image = site_url('assets/images/female.jpg');
                          }
                      ?>
                      <div class="profile_img">
                        <div id="crop-avatar">
                          <!-- Current avatar -->
                          <img class="img-responsive avatar-view" src="<?= $image; ?>" alt="Avatar" title="Change the avatar">
                        </div>
                      </div>
                      
                      <h3><?= $k->nama; ?></h3>

                      <ul class="list-unstyled user_data">
                        <li>
                          <i class="fa fa-credit-card"></i> <?= $k->nik;?>
                        </li>
                        <li>
                          <i class="fa fa-map-marker"></i>&nbsp;&nbsp; <?= $k->alamat; ?>
                        </li>
                         
                         <li>
                          <i class="fa fa-calendar"></i> <?= $k->tempat_lahir.", ". date_format(date_create($k->tanggal_lahir),'d-m-Y');?>
                        </li>
                        <li>
                          <i class="fa fa-black-tie user-profile-icon"></i> <?= $k->nama_jabatan;?>
                        </li>
                        <li>
                          <i class="fa fa-briefcase"></i> <?= $k->nama_divisi;?>
                        </li>

                         <li>
                          <i class="fa fa-venus-mars"></i> <?= $k->jk; ?> 
                        </li>
                        <li>
                          <i class="fa fa-flag"></i> <?= $k->kewarganegaraan;?>
                        </li>

                        
                      </ul>

                      <!-- <a class="btn btn-success"><i class="fa fa-edit m-right-xs"></i>Edit Profile</a> -->
                      <br />

                      <!-- start skills -->
                     
                      <!-- end of skills -->

                    </div>
                    <div class="col-md-9 col-sm-9 col-xs-12">

                     

                      <div class="" role="tabpanel" data-example-id="togglable-tabs">
                        <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                          <li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Daftar tunjangan</a>
                          </li>
                         
                        </ul>
                        <div id="myTabContent" class="tab-content">
                          <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">

                              <!-- start user projects -->
                            <table class="data table table-striped table-bordered no-margin col-md-12">
                              <thead>
                                <tr class="bg-primary">
                                  <th class="text-center col-md-2">No</th>
                                  <th class="text-center col-md-5">Nama Tunjangan</th>
                                  <th class="text-center col-md-3">Jumlah</th>
                                  <th class="hidden-phone text-center col-md-2">Aksi</th>
                                  
                                </tr>
                              </thead>
                              <tbody>
                                <?php
                                  $no =1;
                                  $total = 0;
                                  foreach($tunjangan as $tjg)
                                    {
                                ?>
                                      <tr>
                                        <td class="text-center"><?= $no++; ?></td>
                                        <td><?= $tjg->nama_tunjangan; ?></td>
                                        <td><span class="pull-right">Rp. <?= number_format($tjg->jumlah_tunjangan);?></span></td>
                                        <td class="text-center">
                                          <a href="<?= site_url('tunjangan/edit_tunjangan/'.$tjg->id_tunjangan_karyawan); ?>" class="btn btn-sm btn-primary" title="Edit tunjangan"><i class="fa fa-pencil"></i></a>
                                          <button class="btn btn-sm btn-danger" title="hapus" onclick="hapus('<?= $tjg->id_tunjangan_karyawan; ?>','<?= $tjg->id_karyawan;?>')"><i class="fa fa-trash"></i></button>
                                        </td>
                                       
                                      </tr>
                                <?php
                                      $total = $total + $tjg->jumlah_tunjangan;
                                    }
                                ?>
                              </tbody>
                              <tfoot>
                                <tr class="bg-primary">
                                  <td colspan="2" class="text-center">Total</td>
                                  <td><span class="pull-right">Rp. <?= number_format($total); ?></span></td>
                                  <td></td>
                                  
                                </tr>
                              </tfoot>
                            </table>
                            <!-- end user projects -->

                          </div>
                          
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>