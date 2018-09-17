<?php $CI =& get_instance(); ?>

<link rel="stylesheet" href="<?= site_url('assets/datepicker/datepicker3.css');?>">
<script src="<?= site_url('assets/datepicker/bootstrap-datepicker.js')?>"></script>

<style>
  input{
    text-transform: uppercase;
  }
  #alamat{
    text-transform: uppercase;
  }
</style>
<script>
  $(document).ready(function(){
    $("#tanggal-lahir").prop('readonly',true);
    $("#tanggal-lahir").datepicker({
       format:'dd-mm-yyyy',
    });
  });
</script>

<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
            <h3><?= $title_page;?> </h3>
            </div>

            
        </div>
        <div class="clearfix"></div>
        
         <?php
            if($CI->session->flashdata('status_tambah_pegawai')== 'berhasil')
                {
        ?>
                    <div class="alert alert-success alert-dismissible fade in" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                        </button>
                        <strong>Sukses!</strong> Data pegawai baru berhasil ditambahkan.
                    </div>
        <?php
                }
            else if($CI->session->flashdata('status_tambah_pegawai')== "gagal")
                {
        ?>
                    <div class="alert alert-danger alert-dismissible fade in" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                        </button>
                        <strong>Maaf!</strong> Data pegawai baru gagal ditambahkan.
                    </div>
        <?php
                }
        ?>
        
        
        <div class="row">
        <div class="col-md-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                  <h2>Form Tambah Pegawai <small></small></h2>
                  
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                <br />
                    <form class="form-horizontal form-label-left" method="POST" action="<?= site_url('pegawai/tambah_data_pegawai'); ?>">

                        <!-- NO identitas karyawam -->
                        <div class="form-group">
                            <label class="control-label col-md-2 col-sm-2 col-xs-12">No Identitas</label>
                            <div class="col-md-4 col-sm-7 col-xs-10">
                                <input id="no-identitas" type="text" name="no_identitas" class="form-control" placeholder="No Identitas" value="<?= $CI->session->flashdata('old_no_identitas'); ?>"  autofocus>
                            </div>
                            <!-- form error -->
                            <div class="col-md-10 col-xs-10 col-sm-10 col-md-offset-2 form-error">
                                <?= form_error('no_identitas');?>
                            </div>
                            <!-- /form error -->
                        
                        </div>

                        <!-- Nama Karyawan -->
                         <div class="form-group">
                            <label class="control-label col-md-2 col-sm-2 col-xs-12">Nama</label>
                            <div class="col-md-7 col-sm-7 col-xs-10">
                                <input id="nama-pegawai" type="text" name="nama" class="form-control" placeholder="Nama Pegawai" value="<?= $CI->session->flashdata('old_nama'); ?>"  >
                            </div>
                            <!-- form error -->
                            <div class="col-md-10 col-xs-10 col-sm-10 col-md-offset-2 form-error">
                                <?= form_error('nama');?>
                            </div>
                            <!-- /form error -->
                        
                        </div>
                      
                      <!-- Jenis Kelamin -->
                       <div class="form-group">
                            <label class="control-label col-md-2 col-sm-2 col-xs-12">Jenis Kelamin</label>
                            <div class="col-md-3 col-sm-3 col-xs-10">
                                <select name="jenis_kelamin" id="jenis-kelamin" class="form-control">
                                  <option value="" selected>-- Pilih Jenis Kelamin --</option>
                                  <option value="LAKI-LAKI">Laki-laki</option>
                                  <option value="PEREMPUAN">Perempuan</option>
                                </select>
                            </div>
                            <!-- form error -->
                            <div class="col-md-10 col-xs-10 col-sm-10 col-md-offset-2 form-error">
                                <?= form_error('jenis_kelamin');?>
                            </div>
                            <!-- /form error -->
                        
                        </div>

                       <!-- jabatan  -->

                       <div class="form-group">
                          <label class="control-label col-md-2 col-sm-2 col-xs-12">Jabatan</label>
                          <div class="col-md-3 col-sm-7 col-xs-10">
                              <select name="jabatan" id="jabatan" class="form-control">
                                <option value="" selected>--Pilih Jabatan--</option>
                                <?php 
                                  foreach($jabatan as $jbtn)
                                    {
                                ?>  
                                      <option value="<?= $jbtn->id_jabatan; ?>"><?= $jbtn->nama_jabatan ?></option>
                                <?php      
                                    }
                                ?>
                              </select>
                          </div>
                          <!-- form error -->
                          <div class="col-md-10 col-xs-10 col-sm-10 col-md-offset-2 form-error">
                              <?= form_error('jabatan');?>
                          </div>
                          <!-- /form error -->
                      
                      </div>   

                      <!-- tempat lahir -->
                       <div class="form-group">
                            <label class="control-label col-md-2 col-sm-2 col-xs-12">Tempat Lahir</label>
                            <div class="col-md-4 col-sm-7 col-xs-10">
                                <input id="tempat-lahir" type="text" name="tempat_lahir" class="form-control" placeholder="Tempat lahir" value="<?= $CI->session->flashdata('old_tempat_lahir'); ?>"  >
                            </div>
                            <!-- form error -->
                            <div class="col-md-10 col-xs-10 col-sm-10 col-md-offset-2 form-error">
                                <?= form_error('tempat_lahir');?>
                            </div>
                            <!-- /form error -->
                        
                        </div>

                      <!-- tanggal lahir -->
                       <div class="form-group">
                            <label class="control-label col-md-2 col-sm-2 col-xs-12">Tanggal lahir</label>
                            <div class="col-md-3 col-sm-7 col-xs-10">
                                <input id="tanggal-lahir" type="text" name="tanggal_lahir" class="form-control" placeholder="" value="<?= $CI->session->flashdata('old_tanggal_lahir'); ?>"  >
                            </div>
                            <!-- form error -->
                            <div class="col-md-10 col-xs-10 col-sm-10 col-md-offset-2 form-error">
                                <?= form_error('tanggal_lahir');?>
                            </div>
                            <!-- /form error -->
                        
                        </div>

                      <!-- agama -->
                      <div class="form-group">
                          <label class="control-label col-md-2 col-sm-2 col-xs-12">Agama</label>
                          <div class="col-md-2 col-sm-7 col-xs-10">
                              <select name="agama" id="agama" class="form-control">
                                <option value="" selected>--Pilih Agama--</option>
                                <option value="ISLAM">ISLAM</option>
                                <option value="KRISTEN">KRISTEN</option>
                                <option value="KHATOLIK">KHATOLIK</option>
                                <option value="HINDU">HINDU</option>
                                <option value="BUDHA">BUDHA</option>
                                <option value="LAIN-LAIN">LAIN_LAIN</option>
                              </select>
                          </div>
                          <!-- form error -->
                          <div class="col-md-10 col-xs-10 col-sm-10 col-md-offset-2 form-error">
                              <?= form_error('agama');?>
                          </div>
                          <!-- /form error -->
                      
                      </div>

                      <!-- alamat -->
                       <div class="form-group">
                            <label class="control-label col-md-2 col-sm-2 col-xs-12">Alamat</label>
                            <div class="col-md-7 col-sm-7 col-xs-10">
                                <textarea name="alamat" id="alamat" class="form-control"><?= $CI->session->flashdata('old_alamat'); ?></textarea>
                            </div>
                            <!-- form error -->
                            <div class="col-md-10 col-xs-10 col-sm-10 col-md-offset-2 form-error">
                                <?= form_error('alamat');?>
                            </div>
                            <!-- /form error -->
                        
                        </div>

                      <!-- rt / rw -->
                      <div class="form-group">
                            <label class="control-label col-md-2 col-sm-2 col-xs-12">RT</label>
                            <div class="col-md-1 col-sm-7 col-xs-10">
                                 <input id="rt" type="text" name="rt" class="form-control" placeholder="" value="<?= $CI->session->flashdata('old_rt'); ?>"  >
                            </div>

                            <label class="control-label col-md-1 col-sm-2 col-xs-12">RW</label>
                            <div class="col-md-1 col-sm-7 col-xs-10">
                                 <input id="rw" type="text" name="rw" class="form-control" placeholder="" value="<?= $CI->session->flashdata('old_rw'); ?>"  >
                            </div>
                            <!-- form error -->
                            <div class="col-md-10 col-xs-10 col-sm-10 col-md-offset-2 form-error">
                                <?= form_error('rt');?>
                            </div>

                            <div class="col-md-10 col-xs-10 col-sm-10 col-md-offset-2 form-error">
                                <?= form_error('rw');?>
                            </div>
                            <!-- /form error -->
                        
                        </div>

                        <!-- kecamatan -->
                        <div class="form-group">
                            <label class="control-label col-md-2 col-sm-2 col-xs-12">Kecamatan</label>
                            <div class="col-md-4 col-sm-7 col-xs-10">
                                <input id="kecamatan" type="text" name="kecamatan" class="form-control" placeholder="Kecamatan" value="<?= $CI->session->flashdata('old_kecamatan'); ?>"  >
                            </div>
                            <!-- form error -->
                            <div class="col-md-10 col-xs-10 col-sm-10 col-md-offset-2 form-error">
                                <?= form_error('kecamatan');?>
                            </div>
                            <!-- /form error -->
                        
                        </div>
                        
                        <!-- kelurahan -->
                        <div class="form-group">
                            <label class="control-label col-md-2 col-sm-2 col-xs-12">Kelurahan</label>
                            <div class="col-md-4 col-sm-7 col-xs-10">
                                <input id="kelurahan" type="text" name="kelurahan" class="form-control" placeholder="Kelurahan" value="<?= $CI->session->flashdata('old_kelurahan'); ?>"  >
                            </div>
                            <!-- form error -->
                            <div class="col-md-10 col-xs-10 col-sm-10 col-md-offset-2 form-error">
                                <?= form_error('kelurahan');?>
                            </div>
                            <!-- /form error -->
                        
                        </div>

                        <!-- kota -->
                        <div class="form-group">
                            <label class="control-label col-md-2 col-sm-2 col-xs-12">Kota</label>
                            <div class="col-md-3 col-sm-7 col-xs-10">
                                <input id="kota" type="text" name="kota" class="form-control" placeholder="Kota" value="<?= $CI->session->flashdata('old_kota'); ?>"  >
                            </div>
                            <!-- form error -->
                            <div class="col-md-10 col-xs-10 col-sm-10 col-md-offset-2 form-error">
                                <?= form_error('kota');?>
                            </div>
                            <!-- /form error -->
                        
                        </div>

                         <!-- no tlp -->
                        <div class="form-group">
                            <label class="control-label col-md-2 col-sm-2 col-xs-12">NO Tlp</label>
                            <div class="col-md-3 col-sm-7 col-xs-10">
                                <input id="no-tlp" type="text" name="no_tlp" class="form-control" placeholder="" value="<?= $CI->session->flashdata('old_no_tlp'); ?>"  >
                            </div>
                            <!-- form error -->
                            <div class="col-md-10 col-xs-10 col-sm-10 col-md-offset-2 form-error">
                                <?= form_error('no_tlp');?>
                            </div>
                            <!-- /form error -->
                        
                        </div>

                        <!-- Kewarganegaraan -->
                        <div class="form-group">
                            <label class="control-label col-md-2 col-sm-2 col-xs-12">Kewarganegaraan</label>
                            <div class="col-md-3 col-sm-7 col-xs-10">
                                <select name="kewarganegaraan" id="kewarganegaraan" class="form-control">
                                  <option value="" selected>--Pilih Kewarganegaraan--</option>
                                  <option value="WNI">WNI</option>
                                  <option value="ASING">ASING</option>
                                </select>
                            </div>
                            <!-- form error -->
                            <div class="col-md-10 col-xs-10 col-sm-10 col-md-offset-2 form-error">
                                <?= form_error('kewarganegaraan');?>
                            </div>
                            <!-- /form error -->
                        
                        </div>

                         
                        
                    


                        <div class="ln_solid"></div>
                        <div class="form-group">
                        <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                            <button type="reset" class="btn btn-primary"><span class="fa fa-refresh"></span> Ulangi</button>
                            <button type="submit" class="btn btn-success"><span class="fa fa-save"></span> Simpan</button>
                        </div>
                        </div>

                    </form>
                </div>
            </div>
            </div>
        </div>
    </div>
</div>