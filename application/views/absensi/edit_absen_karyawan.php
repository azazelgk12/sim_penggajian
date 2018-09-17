<?php $CI =& get_instance(); ?>

<link rel="stylesheet" href="<?= site_url('assets/datepicker/datepicker3.css');?>">
<link href="<?= site_url();?>assets/DataTables/datatables.css" rel="stylesheet">
<script src="<?= site_url();?>assets/DataTables/datatables.min.js"></script>
<script src="<?= site_url('assets/datepicker/bootstrap-datepicker.js')?>"></script>
<script>
    

    $(document).ready(function(){
      
       $("#tgl-absen").datepicker({
        format:'dd-mm-yyyy',
       });

        $('#jam-masuk,#jam-pulang').datetimepicker({
            format: 'HH:mm'
        });
      
       $("#nama-karyawan").change(function(){
            var id = $(this).val();

            if(id != '' && id.length != 0){
                 //  data karyawan
                $.ajax({
                    url:'<?= site_url("pegawai/tampil_json_pegawai");?>',
                    type:'post',
                    data:'id_karyawan='+id,
                    dataType:'json',
                    success:function(datapegawai){
                        $('#nik-karyawan').val(datapegawai.nik);
                        $("#jabatan").val(datapegawai.nama_jabatan);
                        $("#divisi").val(datapegawai.nama_divisi);
                    }
                });
            }
            else{
                $('#nik-karyawan').val('');
                $("#jabatan").val('');
                $("#divisi").val('');
            }
       });

       $("#keterangan").change(function(){
          var keterangan = $(this).val();

          if(keterangan != '' || keterangan.length != 0){
            $("#data-jam-masuk").val('');
            $("#data-jam-pulang").val('');
          }

       });



    });
</script>
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
            <h3><?= $title_page; ?> </h3>
            </div>



        </div>

        <div class="clearfix"></div>
        
         <?php
                if($CI->session->flashdata('status_absen') == 'berhasil')
                  {
              ?>    
                      <div class="alert alert-success alert-absen alert-dismissible fade in" role="alert">
                          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                          </button>
                          <strong>
                            Sukses, absen berhasil dilakukan
                          </strong>
                    </div>
              <?php
                    
                  }
                else if($CI->session->flashdata('status_absen') == 'gagal')
                  {
              ?>    
                      <div class="alert alert-danger alert-absen alert-dismissible fade in" role="alert">
                          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                          </button>
                          <strong>
                            Maaf absen gagal dilakukan
                          </strong>
                    </div>
              <?php
                    
                  }
                else if($CI->session->flashdata('status_absen') == 'sudah ada')
                  {
              ?>    
                      <div class="alert alert-danger alert-absen alert-dismissible fade in" role="alert">
                          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                          </button>
                          <strong>
                            Maaf absen sudah pernah dilakukan
                          </strong>
                    </div>
              <?php
                    
                  }
              ?>
     

        <div class="row">
        <div class="col-md-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                <h2 class="col-md-6">Tambah Absen Karyawan <small></small></h2>
                
                <div class="clearfix"></div>
                </div>
                <div class="col-md-12">
                  <form method="POST"  class="form-horizontal form-label-left" action="<?= site_url('absensi/edit_data_absen_karyawan');?>">

                    <?php
                        foreach($data_absen as $da){}

                        if($da->jam_masuk == null || $da->jam_masuk == '00:00:00')
                          {
                            $jenis_absen = 'masuk';
                          }
                        else if($da->jam_pulang == null || $da->jam_pulang == '00:00:00')
                          {
                            $jenis_absen = 'pulang';
                          }
                        else
                          {
                            $jenis_absen = "lainnya";
                          }
                    ?>

                    <input type="hidden" name="id_absensi" class="form-control" value="<?= $da->id_absensi; ?>">
                    <input type="hidden" name="id_karyawan" class="form-control" value="<?= $da->id_karyawan;?>">
                    <input type="hidden" name="jenis" class="form-control" value="<?= $jenis_absen;?>">
                    <!-- lama Keterlambatan absensi -->
                        <div class="form-group">
                            <label class="control-label col-md-2 col-sm-2 col-xs-12">Tanggal Absen</label>
                            <div class="col-md-2 col-sm-10 col-xs-10">
                                <input id="tgl-absen" name="tgl_absen" type="text" class="form-control" readonly="true" value="<?= date_format(date_create($da->tgl),'d-m-Y'); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-2 col-sm-2 col-xs-12">Nama Pegawai</label>
                            <div class="col-md-4 col-sm-7 col-xs-10">
                               <input type="text" name="nama_karyawan" id="nama-karyawan" readonly="true" value="<?= $da->nama ?>" class="form-control">
                            </div>
                            <!-- form error -->
                            <div class="col-md-10 col-xs-10 col-sm-10 col-md-offset-2 form-error">
                                <?= form_error('nama_karyawan');?>
                            </div>
                            <!-- /form error -->
                        
                        </div>
                        
                        <!-- Nik Karyawan -->
                        <div class="form-group">
                            <label class="control-label col-md-2 col-sm-2 col-xs-12">NIK</label>
                            <div class="col-md-3 col-sm-7 col-xs-10">
                               <input type="text" name="nik_karyawan" id="nik-karyawan" class="form-control" readonly="true" value="<?= $da->nik; ?>">
                            </div>                        
                        </div>

                        <!-- jabatan -->
                        <div class="form-group">
                            <label class="control-label col-md-2 col-sm-2 col-xs-12">Jabatan</label>
                            <div class="col-md-3 col-sm-7 col-xs-10">
                               <input type="text" name="jabatan" id="jabatan" class="form-control" readonly="true" value="<?= $da->nama_jabatan; ?>">
                            </div>                        
                        </div>

                        <!-- divisi -->
                        <div class="form-group">
                            <label class="control-label col-md-2 col-sm-2 col-xs-12">Divisi</label>
                            <div class="col-md-3 col-sm-7 col-xs-10">
                               <input type="text" name="divisi" id="divisi" class="form-control" readonly="true" value="<?= $da->nama_divisi; ?>">
                            </div>                        
                        </div>

                       <?php 
                          if($da->jam_masuk == null || $da->jam_masuk == '00:00:00')
                            {
                      ?>
                                  <!-- Jam Masuk -->
                              <div class="form-group">
                                  <label class="control-label col-md-2 col-sm-2 col-xs-12">Jam Masuk</label>
                                  <div class="col-md-2 col-sm-7 col-xs-10">
                                      <div class='input-group date' id='jam-pulang'>
                                          <input type='text' name="jam_masuk" id="data-jam-masuk" class="form-control" value=""/>
                                          <span class="input-group-addon">
                                             <span class="glyphicon glyphicon-calendar"></span>
                                          </span>
                                      </div>
                                  </div>
                                  <!-- form error -->
                                  <div class="col-md-10 col-xs-10 col-sm-10 col-md-offset-2 form-error">
                                      <?= form_error('jam_masuk');?>
                                  </div>
                                  <!-- /form error -->
                              
                              </div>
                      <?php
                            }
                          else
                            {
                      ?>
                                    <!-- Jam Masuk -->
                              <div class="form-group">
                                  <label class="control-label col-md-2 col-sm-2 col-xs-12">Jam Masuk</label>
                                  <div class="col-md-2 col-sm-7 col-xs-10">
                                      <div class='input-group date' id='jam-pulang'>
                                          <input type='text' name="jam_masuk" id="data-jam-masuk" class="form-control" value="<?= $da->jam_masuk; ?>" readonly='true'/>
                                          <span class="input-group-addon">
                                             <span class="glyphicon glyphicon-calendar"></span>
                                          </span>
                                      </div>
                                  </div>
                                 
                              
                              </div>
                      <?php
                            }
                       ?>

                       <?php
                          if($da->jam_pulang == null || $da->jam_pulang == '00:00:00')
                            {
                      ?>
                                 <!-- Jam Masuk -->
                              <div class="form-group">
                                  <label class="control-label col-md-2 col-sm-2 col-xs-12">Jam Pulang</label>
                                  <div class="col-md-2 col-sm-7 col-xs-10">
                                      <div class='input-group date' id='jam-pulang'>
                                          <input type='text' name="jam_pulang" id="data-jam-pulang" class="form-control" value="" />
                                          <span class="input-group-addon">
                                             <span class="glyphicon glyphicon-calendar"></span>
                                          </span>
                                      </div>
                                  </div>
                                  <!-- form error -->
                                  <div class="col-md-10 col-xs-10 col-sm-10 col-md-offset-2 form-error">
                                      <?= form_error('jam_pulang');?>
                                  </div>
                                  <!-- /form error -->
                              
                              </div>
                      <?php
                            }
                          else
                            {
                      ?>
                                 <!-- Jam Masuk -->
                        <div class="form-group">
                            <label class="control-label col-md-2 col-sm-2 col-xs-12">Jam Pulang</label>
                            <div class="col-md-2 col-sm-7 col-xs-10">
                                <div class='input-group date' id='jam-pulang'>
                                    <input type='text' name="jam_pulang" id="data-jam-pulang" class="form-control" value="<?= $da->jam_pulang;?>" readonly='true' />
                                    <span class="input-group-addon">
                                       <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        
                        </div>
                      <?php
                            }

                       ?>

                        <!-- <div class="form-group">
                            <label class="control-label col-md-2 col-sm-2 col-xs-12">Keterangan</label>
                            <div class="col-md-3 col-sm-7 col-xs-10">
                               <select name="keterangan" id="keterangan" class="form-control"> -->
                                  

                                 <?php
                                      // $keterangan = array(
                                      //   'sakit',
                                      //   'izin',
                                      // );

                                      // if($da->keterangan == '')
                                      //   {
                                      //     echo "<option value='' selected>--Pilih Keterangan</option>";
                                      //     foreach($keterangan as $key => $val)
                                      //       {
                                      //         echo "<option value='".$val."'>".ucfirst($val)."</option>";            
                                      //       }
                                      //   }
                                      // else
                                      //   {
                                      //     echo "<option value=''>--Pilih Keterangan</option>";
                                      //     foreach($keterangan as $key => $val)
                                      //       {
                                      //         if($da->keterangan == $val)
                                      //           {
                                      //             echo "<option value='".$val."' selected>".ucfirst($val)."</option>";
                                      //           }   
                                      //         else
                                      //           {
                                      //             echo "<option value='".$val."'>".ucfirst($val)."</option>";
                                      //           }         
                                      //       }
                                      //   }
                                  ?>
                                
                               <!-- </select> -->

                                <!-- form error -->
                                  <!-- <div class="col-md-10 col-xs-10 col-sm-10 col-md-offset-2 form-error">
                                      <?= form_error('keterangan');?>
                                  </div> -->
                                  <!-- /form error -->
                            </div>                        
                        </div>

                        <button type="submit" class="btn btn-primary col-md-offset-4"><i class="fa fa-save"></i> Simpan</button>

                   
                  </form>
                
                </div>
                
            </div>
            </div>
        </div>
    </div>
</div>
