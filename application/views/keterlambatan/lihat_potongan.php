<?php $CI =& get_instance(); ?>
<style>

</style>
<link href="<?= site_url();?>assets/DataTables/datatables.css" rel="stylesheet">
<script src="<?= site_url();?>assets/DataTables/datatables.min.js"></script>
<script>
    function hapus(id){
      var hps = confirm('Apakah anda yakin akan menghapus data potongan keterlambatan ini?');
      if(hps == true){
        var setuju = confirm('Apakah anda setuju ?');
        if(setuju == true){
          window.location="<?= site_url('keterlambatan/hapus_data_potongan/'); ?>"+id;
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
       $("#table-divisi").DataTable({
           'processing':true,
           'serverSide':true,
           'order':[[1,'asc']],
           'ajax':{
               'url':"<?= site_url('keterlambatan/get_data_potongan');?>",
               'type':'POST',
               'dataType':'json',

           },

           'columnDefs':[{
               'targets':[0,3],
               'orderable':false,
           },{
               'targets':[0,1,2,3],
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

            if($CI->session->flashdata('status_hapus_potongan_keterlambatan')== 'berhasil')
                {
        ?>
                    <div class="alert alert-success alert-dismissible fade in" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                        </button>
                        <strong>Sukses!</strong> potongan keterlambatan berhasil dihapus.
                    </div>
        <?php
                }
            else if($CI->session->flashdata('status_hapus_potongan_keterlambatan')== "gagal")
                {
        ?>
                    <div class="alert alert-danger alert-dismissible fade in" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                        </button>
                        <strong>Maaf!</strong> potongan keterlambatan gagal dihapus.
                    </div>
        <?php
                }

        ?>
        <!-- / informasi sukses atau gagal hapus data KDD  -->


        <div class="row">
        <div class="col-md-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                <h2 class="col-md-6">Potongan Keterlambatan CV [S] STUDIO <small></small></h2>
                <div class="col-md-6">
                  <a href="<?= site_url('keterlambatan/tambah_potongan'); ?>" class="btn btn-primary pull-right"><span class="fa fa-plus" style="color:white"></span> Tambah</a>
                </div>
                <div class="clearfix"></div>
                </div>
                <div class="x_content col-md-12">
                  <br />
                  <br />
                  <!-- Datatable data KDD -->
                  <table id="table-divisi" class="table table-striped table-bordered ">
                    <thead>
                      <tr class="bg-primary">
                        <th class="col-md-1 text-center">No</th>
                        <th class="col-md-4 text-center">Menit</th>
                        <th class="col-md-5 text-center">Potongan</th>
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
