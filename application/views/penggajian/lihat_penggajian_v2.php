<?php $CI =& get_instance(); ?>

<link rel="stylesheet" href="<?= site_url('assets/datepicker/datepicker3.css');?>">
<link href="<?= site_url();?>assets/DataTables/datatables.css" rel="stylesheet">
<script src="<?= site_url();?>assets/DataTables/datatables.min.js"></script>
<script src="<?= site_url('assets/datepicker/bootstrap-datepicker.js')?>"></script>
<script>
    function hapus(id){
      var hps = confirm('Apakah anda akan menghapus data penggajia ini ?');

      if(hps == true){
        var stj = confirm('Apakah anda yakin ?');
        if(stj == true){
          window.location="<?= site_url('penggajian/hapus_penggajian/'); ?>"+id;
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
       var penggajian = $("#table-penggajian-karyawan").DataTable({
           'dom':'lrtip',
           'processing':true,
           'serverSide':true,
            'searching':false,
               'destroy':true,
           'order':[[1,'asc']],
           'ajax':{
               'url':"<?= site_url('penggajian/get_data_penggajian');?>",
               'type':'POST',
               'dataType':'json',

           },

           'columnDefs':[{
               'targets':[0,6],
               'orderable':false,
           },{
               'targets':[0,4,6],
               'className':'text-center',
           }]
       });

       $('#btn-submit').click(function(){
          var data_filter = $('#form-filtered').serialize();
           $.ajax({
            'url':"<?= site_url('penggajian/set_filter_penggajian');?>",
            'type':'POST',
            'data':data_filter,
            success:function(){
              penggajian.ajax.reload(null,false);
            }

           });

       });

       $("#btn-refresh").click(function(){
          $("#data-tgl").val("");
          $("#tgl-awal").val("");
          $("#tgl-akhir").val("");
          $("#karyawan").val("");
          $("#potongan").val("");
          $("#jabatan").val('');
          $("#divisi").val('');

          $.ajax({
            'url':"<?= site_url('penggajian/reset_filter_penggajian');?>",
            success:function(){
              penggajian.ajax.reload(null,false);
            }
          });
       });

       $("#tgl-awal,#tgl-akhir").datepicker({
        format:'dd-mm-yyyy',
        autoclose:true,
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

            if($CI->session->flashdata('status_hapus_penggajian')== 'berhasil')
                {
        ?>
                    <div class="alert alert-success alert-dismissible fade in" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                        </button>
                        <strong>Sukses!</strong> Data Pengggajian berhasil dihapus.
                    </div>
        <?php
                }
            else if($CI->session->flashdata('status_hapus_penggajian')== "gagal")
                {
        ?>
                    <div class="alert alert-danger alert-dismissible fade in" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                        </button>
                        <strong>Maaf!</strong> Data Penggajian gagal dihapus.
                    </div>
        <?php
              }
        ?>
           

        <div class="row">
        <div class="col-md-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                <h2 class="col-md-6">Penggajian Karyawan CV [S] STUDIO <small></small></h2>
                
                <div class="clearfix"></div>
                </div>
                <div class="col-md-12">
                  <form method="POST" id="form-filtered" class="form-horizontal form-label-left">
                    <!-- lama Keterlambatan absensi -->
                        <div class="form-group">
                            <label class="control-label col-md-2 col-sm-2 col-xs-12">Tanggal awal</label>
                            <div class="col-md-2 col-sm-10 col-xs-10">
                                <input id="tgl-awal" name="tgl_awal" type="text" class="form-control" readonly="true">
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="control-label col-md-2 col-sm-2 col-xs-12">Tanggal akhir</label>
                            <div class="col-md-2 col-sm-10 col-xs-10">
                                <input id="tgl-akhir" type="text" name="tgl_akhir" class="form-control" readonly="true">
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
                            <label class="control-label col-md-2 col-sm-2 col-xs-12">Jabatan</label>
                            <div class="col-md-4 col-sm-10 col-xs-10">
                                <select name="jabatan" id="jabatan" class="form-control">
                                  <option value="" selected>-- Pilih Jabatan --</option>
                                  <?php
                                    foreach($jabatan as $jbt)
                                      {
                                  ?>
                                        <option value="<?= $jbt->id_jabatan; ?>"><?= $jbt->nama_jabatan; ?></option>
                                  <?php      
                                      }
                                  ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-2 col-sm-2 col-xs-12">Divisi</label>
                            <div class="col-md-3 col-sm-10 col-xs-10">
                                <select name="divisi" id="divisi" class="form-control">
                                  <option value="" selected>-- Pilih Divisi --</option>
                                  <?php
                                    foreach($divisi as $div)
                                      {
                                  ?>
                                        <option value="<?= $div->id_divisi; ?>"><?= $div->nama_divisi; ?></option>
                                  <?php      
                                      }
                                  ?>
                                </select>
                            </div>
                        </div>
                   
                  </form>
                  <button id="btn-refresh" class="btn btn-sm btn-success col-md-2 col-md-offset-2"><i class="fa fa-refresh"></i> Refresh</button>
                  <button id="btn-submit" class="btn btn-sm btn-primary col-md-2"><i class="fa fa-search"></i> CARI</button>
                  <a href="<?= site_url('laporan_penggajian/cetak');?>" target='_blank' class="btn btn-sm btn-success col-md-2"><i class="fa fa-print"></i> Cetak Laporan</a>
                </div>
                <div class="x_content col-md-12">
                  <br />
                  <br />
                  <!-- Datatable data KDD -->
                  <table id="table-penggajian-karyawan" class="table table-striped table-bordered ">
                    <thead>
                      <tr class="bg-primary">
                        <th class="col-md-1 text-center">No</th>
                        <th class="col-md-1 text-center">Tanggal</th>
                        <th class="col-md-2 text-center">Periode</th>
                        <th class="col-md-2">Nama Karyawan</th>
                        <th class="col-md-2 text-center">Jabatan</th>
                        <th class="col-md-2 text-center">Divisi</th>
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
