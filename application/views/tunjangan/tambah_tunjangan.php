<?php $CI =& get_instance(); ?>
<style>
  #nama-divisi{
    text-transform: uppercase;
  }
</style>

<script>
    $(document).ready(function(){

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
            if($CI->session->flashdata('status_tambah_tunjangan_karyawan')== 'berhasil')
                {
        ?>
                    <div class="alert alert-success alert-dismissible fade in" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                        </button>
                        <strong>Sukses!</strong> Tunjangan berhasil ditambahkan.
                    </div>
        <?php
                }
            else if($CI->session->flashdata('status_tambah_tunjangan_karyawan')== "gagal")
                {
        ?>
                    <div class="alert alert-danger alert-dismissible fade in" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                        </button>
                        <strong>Maaf!</strong> Tunjangan gagal ditambahkan.
                    </div>
        <?php
                }
        ?>
        
        <div class="row">
        <div class="col-md-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                  <h2>Form Tambah Tunjangan Jabatan <small></small></h2>
                  
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                <br />
                    <form class="form-horizontal form-label-left" method="POST" action="<?= site_url('tunjangan/tambah_data_tunjangan_karyawan'); ?>">

                        <!-- Nama Jabatan -->
                        <div class="form-group">
                            <label class="control-label col-md-2 col-sm-2 col-xs-12">Nama Pegawai</label>
                            <div class="col-md-4 col-sm-7 col-xs-10">
                               <select name="nama_karyawan" id="nama-karyawan" class="form-control">
                                   <option value="" selected="">--Pilih Pegawai--</option>
                                   <?php
                                    foreach($pegawai as $karyawan)
                                     {
                                   ?>
                                        <option value="<?= $karyawan->id_karyawan;?>"><?= $karyawan->nama;?></option>
                                   <?php     
                                     }
                                   ?>
                               </select>
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
                               <input type="text" name="nik_karyawan" id="nik-karyawan" class="form-control" readonly="true">
                            </div>                        
                        </div>

                        <!-- jabatan -->
                        <div class="form-group">
                            <label class="control-label col-md-2 col-sm-2 col-xs-12">Jabatan</label>
                            <div class="col-md-3 col-sm-7 col-xs-10">
                               <input type="text" name="jabatan" id="jabatan" class="form-control" readonly="true">
                            </div>                        
                        </div>

                        <!-- divisi -->
                        <div class="form-group">
                            <label class="control-label col-md-2 col-sm-2 col-xs-12">Divisi</label>
                            <div class="col-md-3 col-sm-7 col-xs-10">
                               <input type="text" name="divisi" id="divisi" class="form-control" readonly="true">
                            </div>                        
                        </div>

                        

                         <!-- Nama Tunjangan -->
                        <div class="form-group">
                            <label class="control-label col-md-2 col-sm-2 col-xs-12">Nama Tunjangan</label>
                            <div class="col-md-4 col-sm-7 col-xs-10">
                               <select name="tunjangan" id="tunjangan" class="form-control">
                                   <option value="" selected="">--Pilih Tunjangan--</option>
                                   <?php
                                    foreach($tunjangan as $tun)
                                     {
                                   ?>
                                        <option value="<?= $tun->id_master_tunjangan;?>"><?= $tun->nama_tunjangan;?></option>
                                   <?php     
                                     }
                                   ?>
                               </select>
                            </div>
                            <!-- form error -->
                            <div class="col-md-10 col-xs-10 col-sm-10 col-md-offset-2 form-error">
                                <?= form_error('tunjangan');?>
                            </div>

                            <?php
                                if($CI->session->flashdata('data_tunjangan') == "sudah ada")
                                    {
                            ?>  
                                        <div class="col-md-10 col-xs-10 col-sm-10 col-md-offset-2 form-error">
                                            Karyawan ini sudah memiliki tunjangan yg dipilih
                                        </div>
                            <?php 
                                    }
                            ?>
                            <!-- /form error -->
                        
                        </div>
                        
                      

                         <!-- jumlah Pembayaran -->
                        <div class="form-group">
                            <label class="control-label col-md-2 col-sm-2 col-xs-12">Jumlah Tunjangan (Rp)</label>
                            <div class="col-md-3 col-sm-7 col-xs-10">
                               <input type="number" min="0" name="jumlah_tunjangan" id="jumlah-tunjangan" class="form-control" value="<?= $CI->session->flashdata('old_jumlah_tunjangan'); ?>">
                            </div>
                            <!-- form error -->
                            <div class="col-md-9 col-xs-9 col-sm-9 col-md-offset-2 form-error">
                                <?= form_error('jumlah_tunjangan');?>
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