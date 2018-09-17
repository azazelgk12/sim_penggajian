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
            if($CI->session->flashdata('status_edit_pegawai')== 'berhasil')
                {
        ?>
                    <div class="alert alert-success alert-dismissible fade in" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                        </button>
                        <strong>Sukses!</strong> Data pegawai berhasil diubah.
                    </div>
        <?php
                }
            else if($CI->session->flashdata('status_edit_pegawai')== "gagal")
                {
        ?>
                    <div class="alert alert-danger alert-dismissible fade in" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                        </button>
                        <strong>Maaf!</strong> Data pegawai gagal diubah.
                    </div>
        <?php
                }
        ?>
        
        
        <div class="row">
        <div class="col-md-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                  <h2>Form Edit Data Karyawan CV [S] STUDIO <small></small></h2>
                  
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                <br />
                    <form class="form-horizontal form-label-left" method="POST" action="<?= site_url('pegawai/edit_data_pegawai'); ?>">

                        <?php foreach($pegawai as $pgw){} ?>

                        <input type="hidden" name="id_karyawan" value="<?= $pgw->id_karyawan; ?>">
                        <!-- NO identitas karyawam -->
                        <div class="form-group">
                            <label class="control-label col-md-2 col-sm-2 col-xs-12">No Identitas</label>
                            <div class="col-md-4 col-sm-7 col-xs-10">
                                <input id="no-identitas" type="text" name="no_identitas" class="form-control" placeholder="No Identitas" value="<?= $pgw->no_identitas ?>"  autofocus>
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
                                <input id="nama-pegawai" type="text" name="nama" class="form-control" placeholder="Nama Pegawai" value="<?= $pgw->nama; ?>"  >
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
                                    <option value="">-- Pilih Jenis Kelamin --</option>
                                    <?php
                                        $jenis_kelamin = array('LAKI-LAKI','PEREMPUAN');
                                        foreach($jenis_kelamin as $jk => $value)
                                            {
                                                if($value == $pgw->jk)
                                                    {
                                    ?>
                                                        <option value="<?= $value;?>" selected><?= $value;?></option>
                                    <?php    
                                                    }
                                                else
                                                    {
                                    ?>
                                                        <option value="<?= $value;?>"><?= $value;?></option>
                                    <?php
                                                    }
                                            }
                                    ?>
                                  
                                  
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
                                <option value="">--Pilih Jabatan--</option>
                                <?php 
                                  foreach($jabatan as $jbtn)
                                    {
                                        if($jbtn->id_jabatan == $pgw->id_jabatan)
                                            {
                                ?>
                                                <option value="<?= $jbtn->id_jabatan; ?>" selected><?= $jbtn->nama_jabatan ?></option>
                                <?php
                                            } 
                                        else
                                            {
                                ?>
                                                <option value="<?= $jbtn->id_jabatan; ?>"><?= $jbtn->nama_jabatan ?></option>
                                <?php
                                            }    
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
                                <input id="tempat-lahir" type="text" name="tempat_lahir" class="form-control" placeholder="Tempat lahir" value="<?= $pgw->tempat_lahir; ?>"  >
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
                                <?php
                                    $tgl_lahir      = $pgw->tanggal_lahir;
                                    $pecah_tgl      = explode('-',$tgl_lahir);
                                    $tanggal_lahir  = $pecah_tgl[2].'-'.$pecah_tgl[1].'-'.$pecah_tgl[0];
                                ?>
                                <input id="tanggal-lahir" type="text" name="tanggal_lahir" class="form-control" placeholder="" value="<?= $tanggal_lahir; ?>"  >
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
                                <option value="" >--Pilih Agama--</option>
                                <?php
                                    $agama = array(
                                        'ISLAM',
                                        'KRISTEN',
                                        'KHATOLIK',
                                        'HINDU',
                                        'BUDHA',
                                        'LAIN-LAIN'
                                    );

                                    foreach($agama as $agm => $value)
                                        {
                                            if($value == $pgw->agama)
                                                {
                                ?>
                                                    <option value="<?= $value;?>" selected><?= $value; ?></option>
                                <?php
                                                }
                                            else
                                                {
                                ?>
                                                    <option value="<?= $value;?>"><?= $value; ?></option>
                                <?php
                                                }
                                        }
                                ?>
                                
                                
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
                                <textarea name="alamat" id="alamat" class="form-control"><?= $pgw->alamat; ?></textarea>
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
                                 <input id="rt" type="text" name="rt" class="form-control" placeholder="" value="<?= $pgw->rt; ?>"  >
                            </div>

                            <label class="control-label col-md-1 col-sm-2 col-xs-12">RW</label>
                            <div class="col-md-1 col-sm-7 col-xs-10">
                                 <input id="rw" type="text" name="rw" class="form-control" placeholder="" value="<?= $pgw->rw; ?>"  >
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
                                <input id="kecamatan" type="text" name="kecamatan" class="form-control" placeholder="Kecamatan" value="<?= $pgw->kecamatan; ?>"  >
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
                                <input id="kelurahan" type="text" name="kelurahan" class="form-control" placeholder="Kelurahan" value="<?= $pgw->kelurahan; ?>"  >
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
                                <input id="kota" type="text" name="kota" class="form-control" placeholder="Kota" value="<?= $pgw->kota; ?>"  >
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
                                <input id="no-tlp" type="text" name="no_tlp" class="form-control" placeholder="" value="<?= $pgw->no_tlp; ?>"  >
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
                                    <option value="">--Pilih Kewarganegaraan--</option>
                                    <?php 
                                        $kewarganegaraan = array('WNI','ASING');

                                        foreach($kewarganegaraan as $kwn => $value)
                                            {
                                                if($value == $pgw->kewarganegaraan)
                                                    {
                                    ?>
                                                        <option value="<?= $value; ?>" selected><?= $value; ?></option>
                                    <?php
                                                    }
                                                else
                                                    {
                                    ?>
                                                        <option value="<?= $value; ?>"><?= $value; ?></option>
                                    <?php
                                                    }
                                            }
                                    ?>
                                  
                                  
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
                            <button type="submit" class="btn btn-success"><span class="fa fa-pencil"></span> Ubah</button>
                        </div>
                        </div>

                    </form>
                </div>
            </div>
            </div>
        </div>
    </div>
</div>