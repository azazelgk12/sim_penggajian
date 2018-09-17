<?php $CI =& get_instance(); ?>
<style>

</style>
<link href="<?= site_url();?>assets/DataTables/datatables.css" rel="stylesheet">
<script src="<?= site_url();?>assets/DataTables/datatables.min.js"></script>
<script>
    function hapus(id){
      var hps = confirm('apakah anda yakin akan menhapus data gaji pokok ini?');
      if(hps == true){
        var setuju = confirm('Apakah anda setuju ?');
        if(setuju == true){
          window.location="<?= site_url('penggajian/hapus_gapok/'); ?>"+id;
        }
        else{
          return false;
        }
      }
      else{
        return false;
      }
    }

    $(document).ready(function(){
       $("#table-gapok").DataTable({
           'processing':true,
           'serverSide':true,
           'order':[[1,'ASC']],
           'ajax':{
               'url':"<?= site_url('penggajian/get_data_gapok');?>",
               'type':'POST',
               'dataType':'json',

           },

           'columnDefs':[{
               'targets':[0,4],
               'orderable':false,
           },{
               'targets':[0,2,4],
               'className':'text-center',
           }]
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

        <!-- informasi berhasil atau gagal hapus data KDD -->
        <?php

            if($CI->session->flashdata('status_hapus_gapok')== 'berhasil')
                {
        ?>
                    <div class="alert alert-success alert-dismissible fade in" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                        </button>
                        <strong>Sukses!</strong> Data Gaji Pokok berhasil dihapus.
                    </div>
        <?php
                }
            else if($CI->session->flashdata('status_hapus_gapok')== "gagal")
                {
        ?>
                    <div class="alert alert-danger alert-dismissible fade in" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                        </button>
                        <strong>Maaf!</strong> Data Gaji Pokok gagal dihapus.
                    </div>
        <?php
                }

        ?>
        <!-- / informasi sukses atau gagal hapus data KDD  -->


        <div class="row">
        <div class="col-md-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                <h2 class="col-md-6">Daftar Gaji Pokok CV [S] STUDIO <small></small></h2>
                <div class="col-md-6">
                  <a href="<?= site_url('penggajian/tambah_gapok'); ?>" class="btn btn-primary pull-right"><span class="fa fa-plus" style="color:white"></span> Tambah</a>
                </div>
                <div class="clearfix"></div>
                </div>
                <div class="x_content col-md-12">
                  <br />
                  <br />
                  <!-- Datatable data KDD -->
                  <table id="table-gapok" class="table table-striped table-bordered ">
                    <thead>
                      <tr class="bg-primary">
                        <th class="col-md-1 text-center">No</th>
                        <th class="col-md-4 text-center">Nama Jabatan</th>
                        <th class="col-md-3 text-center">Gaji Pokok</th>
                        <th class="col-md-2 text-center">Jenis Pembayaran</th>
                        <th class="col-md-2 text-center">aksi</th>
                      </tr>
                    </thead>


                    <tbody>
                    </tbody>
                  </table>
                  <!-- / Datatable data KDD -->
                </div>
            </div>
            </div>
        </div>
    </div>
</div>
