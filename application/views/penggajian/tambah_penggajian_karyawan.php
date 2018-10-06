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
    $("#tgl-awal,#tgl-akhir").prop('readonly',true);
    $("#tgl-awal,#tgl-akhir").datepicker({
       format:'dd-mm-yyyy',
       autoclose:true,

    });

    // $("#tgl-awal,#tgl-akhir").change(function(){
    //     var tglakhir = $("#tgl-akhir").val();
    //     var tglawal = $("#tgl-awal").val();

    //     if(tglawal.length == 0 || tglakhir.length ==0){
    //       $("#error-tgl-akhir").html('');
    //       $("#btn-submit").prop('disabled',true);
    //     }
    //     else{
    //       if(tglakhir < tglawal){
    //         $("#error-tgl-akhir").html('Tgl akhir tidak boleh lebih kecil dari tgl awal');
    //         $("#btn-submit").prop('disabled',true);
    //       }
    //       else{
    //         $("#error-tgl-akhir").html('');
    //         $("#btn-submit").prop('disabled',false);
    //       }
    //     }
    // });
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
            // echo $CI->session->flashdata('status_tambah_penggajian');

            if($CI->session->flashdata('status_tambah_penggajian')== "gagal")
                {
        ?>
                    <div class="alert alert-danger alert-dismissible fade in" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                        </button>
                        <strong>Maaf!</strong> Data Penggajian gagal ditambahkah.
                    </div>
        <?php
              }
            else if($CI->session->flashdata('status_tambah_penggajian')== "berhasil")
                {
        ?>
                    <div class="alert alert-success alert-dismissible fade in" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                        </button>
                        <strong>Sukses!</strong> Data Penggajian dan Jurnal berhasil ditambahkan.
                    </div>
        <?php
              }
            else if($CI->session->flashdata('status_tambah_penggajian')== "tanggal_kosong")
                {
        ?>
                    <div class="alert alert-danger alert-dismissible fade in" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                        </button>
                        <strong>Maaf!</strong> tanggal tidak bolah kosong.
                    </div>
        <?php
              }
             else if($CI->session->flashdata('status_tambah_penggajian')== "data_kosong")
                {
        ?>
                    <div class="alert alert-danger alert-dismissible fade in" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                        </button>
                        <strong>Maaf!</strong> tidak ada data penggajian yang dapat ditambahkan.
                    </div>
        <?php
              }
            else if($CI->session->flashdata('status_tambah_penggajian')== "tanggal_salah")
                {
        ?>
                    <div class="alert alert-danger alert-dismissible fade in" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                        </button>
                        <strong>Maaf!</strong> silahkan pilih tanggal akhir yang lebih besar dari tanggal awal.
                    </div>
        <?php
              }
        ?>
        
        
        <div class="row">
        <div class="col-md-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                  <h2>Form Tambah Penggajian <small></small></h2>
                  
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                <br />
                    <form class="form-horizontal form-label-left" method="POST" action="<?= site_url('penggajian/tambah_penggajian_karyawan'); ?>">


                        <div class="form-group">
                            <label class="control-label col-md-2 col-sm-2 col-xs-12">Tanggal awal</label>
                            <div class="col-md-2 col-sm-10 col-xs-10">
                                <input id="tgl-awal" name="tgl_awal" type="text" class="form-control" readonly="true">
                            </div>

                            <!-- form error -->
                            <div id="error-tgl-awal" class="col-md-10 col-xs-10 col-sm-10 col-md-offset-2 form-error">
                                <?= form_error('tgl_awal');?>
                            </div>
                            <!-- /form error -->
                        </div>


                        <div class="form-group">
                            <label class="control-label col-md-2 col-sm-2 col-xs-12">Tanggal akhir</label>
                            <div class="col-md-2 col-sm-10 col-xs-10">
                                <input id="tgl-akhir" name="tgl_akhir" type="text" class="form-control" readonly="true">
                            </div>

                            <!-- form error -->
                            <div id="error-tgl-akhir" class="col-md-10 col-xs-10 col-sm-10 col-md-offset-2 form-error">
                                <?= form_error('tgl_akhir');?>
                            </div>
                            <!-- /form error -->
                        </div>
                        


                        <div class="ln_solid"></div>
                        <div class="form-group">
                        <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                           <!--  <button type="reset" class="btn btn-primary"><span class="fa fa-refresh"></span> Ulangi</button> -->
                            <button type="submit" id="btn-submit" class="btn btn-success"><span class="fa fa-refresh"></span> Proses</button>
                        </div>
                        </div>

                    </form>
                </div>
            </div>
            </div>
        </div>
    </div>
</div>