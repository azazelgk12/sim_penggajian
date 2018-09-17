<?php $CI =& get_instance(); ?>

<link rel="stylesheet" href="<?= site_url('assets/datepicker/datepicker3.css');?>">
<link href="<?= site_url();?>assets/DataTables/datatables.css" rel="stylesheet">
<script src="<?= site_url();?>assets/DataTables/datatables.min.js"></script>
<script src="<?= site_url('assets/datepicker/bootstrap-datepicker.js')?>"></script>
<script>
    
    function hapus(id){
      var hps = confirm('Apakah anda yakin akan menghapus data absensi ini?');

      if(hps == true){
        var stj = confirm('Apakah anda setuju?');
        if(stj == true){
          window.location = "<?= site_url('absensi/hapus_absensi_karyawan/'); ?>"+id;
        }
        else{
          return false;
        }
      }else{
        return false;
      }
    }
    
    $(document).ready(function(){
       var absen = $("#table-absen").DataTable({
           'dom':'lrtip',
           'processing':true,
           'serverSide':true,
            'searching':false,
               'destroy':true,
           'order':[[1,'desc']],
           'ajax':{
               'url':"<?= site_url('absensi/get_data_absen_karyawan');?>",
               'type':'POST',
               'dataType':'json',

           },

           'columnDefs':[{
               'targets':[0,7],
               'orderable':false,
           },{
               'targets':[0,1,4,5,6,7],
               'className':'text-center',
           }]
       });

       $('#btn-submit').click(function(){
          var data_filter = $('#form-filtered').serialize();
           $.ajax({
            'url':"<?= site_url('absensi/set_filter_absen_karyawan');?>",
            'type':'POST',
            'data':data_filter,
            success:function(){
              absen.ajax.reload(null,false);
            }

           });

       });

       $("#btn-refresh").click(function(){
          $("#data-tgl").val("");
          $("#tgl-awal").val("");
          $("#tgl-akhir").val("");
          $("#karyawan").val("");
          $("#jenis-absen").val("");

          absen.ajax.reload(null,false);
       });

       $("#tgl-awal,#tgl-akhir").datepicker({
        format:'dd-mm-yyyy',
       });

       //  filtering data
       $("#tgl-awal").change(function(){
          var tglawal   = $("#tgl-awal").val();
          var tglakhir  = $("#tgl-akhir").val();

          var pecahTglAwal    = tglawal.split('-');
          var pecahTglAkhir   = tglakhir.split('-');

          var tanggalAwal   = pecahTglAwal[2]+'-'+pecahTglAwal[1]+'-'+pecahTglAwal[0];
          var tanggalAkhir  = pecahTglAkhir[2]+'-'+pecahTglAkhir[1]+'-'+pecahTglAkhir[0];

          if(tglawal.length != 0 && tglakhir.length != 0){
            $("#data-tgl").val(" BETWEEN '"+tanggalAwal+"' AND '"+tanggalAkhir+"'");
          }
          else if(tglawal.length != 0 && tglakhir.length == 0){
            $("#data-tgl").val("='"+tanggalAwal+"'");
          }
          else if(tglawal.length == 0 && tglakhir.length != 0){
            $("#data-tgl").val("='"+tanggalAkhir+"'");
          }
          else{
            $("#data-tgl").val("");
          }
       });

       $("#tgl-akhir").change(function(){
          var tglawal   = $("#tgl-awal").val();
          var tglakhir  = $("#tgl-akhir").val();

          var pecahTglAwal    = tglawal.split('-');
          var pecahTglAkhir   = tglakhir.split('-');

          var tanggalAwal   = pecahTglAwal[2]+'-'+pecahTglAwal[1]+'-'+pecahTglAwal[0];
          var tanggalAkhir  = pecahTglAkhir[2]+'-'+pecahTglAkhir[1]+'-'+pecahTglAkhir[0];

          if(tglawal.length != 0 && tglakhir.length != 0){
            $("#data-tgl").val(" BETWEEN '"+tanggalAwal+"' AND '"+tanggalAkhir+"'");
          }
          else if(tglawal.length != 0 && tglakhir.length == 0){
            $("#data-tgl").val("='"+tanggalAwal+"'");
          }
          else if(tglawal.length == 0 && tglakhir.length != 0){
            $("#data-tgl").val("='"+tanggalAkhir+"'");
          }
          else{
            $("#data-tgl").val("");
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


            if($CI->session->flashdata('status_hapus')== 'gagal')
                {
        ?>
                    <div class="alert alert-success alert-dismissible fade in" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                        </button>
                        <strong>Sukses!</strong> Data absensi karyawan gagal dihapus.
                    </div>
        <?php
                }

            else if($CI->session->flashdata('status_hapus')== 'berhasil')
                {
        ?>
                    <div class="alert alert-success alert-dismissible fade in" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                        </button>
                        <strong>Sukses!</strong> Data absensi karyawan berhasil dihapus.
                    </div>
        <?php
                }

            else if($CI->session->flashdata('status_edit')== 'berhasil')
                {
        ?>
                    <div class="alert alert-success alert-dismissible fade in" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                        </button>
                        <strong>Sukses!</strong> Data absensi karyawan berhasil diubah.
                    </div>
        <?php
                }
            else if($CI->session->flashdata('status_edit')== 'gagal')
                {
        ?>
                    <div class="alert alert-success alert-dismissible fade in" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                        </button>
                        <strong>Sukses!</strong> Data absensi karyawan gagal diubah.
                    </div>
        <?php
                }
       

        ?>
     

        <div class="row">
        <div class="col-md-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                <h2 class="col-md-6">Absensi Karyawan CV [S] STUDIO <small></small></h2>
                
                <div class="clearfix"></div>
                </div>
                <div class="col-md-12">
                  <form method="POST" id="form-filtered" class="form-horizontal form-label-left">
                    <!-- lama Keterlambatan absensi -->
                        <div class="form-group">
                            <label class="control-label col-md-2 col-sm-2 col-xs-12">Tanggal awal</label>
                            <div class="col-md-2 col-sm-10 col-xs-10">
                                <input id="tgl-awal" type="text" class="form-control" readonly="true">
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="control-label col-md-2 col-sm-2 col-xs-12">Tanggal akhir</label>
                            <div class="col-md-2 col-sm-10 col-xs-10">
                                <input id="tgl-akhir" type="text" class="form-control" readonly="true">
                            </div>
                        </div>

                          <input type="hidden" id="data-tgl" name="data_tanggal" class="form-control">

                        <div class="form-group">
                            <label class="control-label col-md-2 col-sm-2 col-xs-12">Nama Karyawan</label>
                            <div class="col-md-4 col-sm-10 col-xs-10">
                                <input id="karyawan" name="karyawan" type="text" class="form-control">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-2 col-sm-2 col-xs-12">Jenis Absen</label>
                            <div class="col-md-3 col-sm-10 col-xs-10">
                                <select id="jenis-absen" name="jenis_absen" class="form-control">
                                    <option value="" selected>--Pilih Jenis Absen</option>
                                    <option value="lengkap">Lengkap</option>
                                    <option value="tidak lengkap">Tidak Lengkap</option>
                                    <option value="">Semua</option>
                                </select>
                            </div>
                        </div>

                       
                   
                  </form>
                  <button id="btn-refresh" class="btn btn-sm btn-success col-md-2 col-md-offset-2"><i class="fa fa-refresh"></i> Refresh</button>
                  <button id="btn-submit" class="btn btn-sm btn-primary col-md-2"><i class="fa fa-search"></i> CARI</button>
                </div>
                <div class="x_content col-md-12">
                  <br />
                  <br />
                  <!-- Datatable data KDD -->
                  <table id="table-absen" class="table table-striped table-bordered ">
                    <thead>
                      <tr class="bg-primary">
                        <th class="col-md-1 text-center">No</th>
                        <th class="col-md-2 text-center">Tanggal</th>
                        <th class="col-md-2 text-center">NIK</th>
                        <th class="col-md-3 text-center">Nama</th>
                        <th class="col-md-1 text-center">Masuk</th>
                        <th class="col-md-1 text-center">Pulang</th>
                        <th>Keterangan</th>
                        <th class="col-md-2 text-center">Aksi</th>
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
