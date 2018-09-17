<?php $CI =& get_instance(); ?>
<style>

</style>
<link href="<?= site_url();?>assets/DataTables/datatables.css" rel="stylesheet">
<script src="<?= site_url();?>assets/DataTables/datatables.min.js"></script>
<script>
    function hapus(id){
      var hps = confirm('apakah anda yakin akan menghapus karyawan ini? menghapus karyawan ini akan menhapus data karyawan dan data data lain yang berhubungan dengan karyawan ini');
      if(hps == true){
        var setuju = confirm('Apakah anda setuju ?');
        if(setuju == true){
          window.location="<?= site_url('pegawai/hapus/'); ?>"+id;
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
       $("#table-pegawai").DataTable({
           'processing':true,
           'serverSide':true,
           'order':[[1,'asc']],
           'ajax':{
               'url':"<?= site_url('penggajian/get_data_pegawai');?>",
               'type':'POST',
               'dataType':'json',

           },

           'columnDefs':[{
               'targets':[0,6],
               'orderable':false,
           },{
               'targets':[0,,3,6],
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

       


        <div class="row">
        <div class="col-md-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                <h2 class="col-md-6">Karyawan CV [S] STUDIO <small></small></h2>
                
                <div class="clearfix"></div>
                </div>
                <div class="x_content col-md-12">
                  <br />
                  <br />
                  <!-- Datatable data KDD -->
                  <table id="table-pegawai" class="table table-striped table-bordered ">
                    <thead>
                      <tr class="bg-primary">
                        <th class="col-md-1 text-center">No</th>
                        <th class="col-md-1 text-center">NIK</th>
                        <th class="col-md-3 text-center">Nama</th>
                        <th class="col-md-2 text-center">Jenis Kelamin</th>
                        <th class="col-md-2 text-center">Jabatan</th>
                        <th class="col-md-2 text-center">Divisi</th>
                        <th class="col-md-1 text-center">aksi</th>
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
