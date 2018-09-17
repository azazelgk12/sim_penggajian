<?php $CI =& get_instance(); ?>
<style>

</style>
<link rel="stylesheet" href="<?= site_url('assets/datepicker/datepicker3.css');?>">
<link href="<?= site_url();?>assets/DataTables/datatables.css" rel="stylesheet">
<script src="<?= site_url();?>assets/DataTables/datatables.min.js"></script>
<script src="<?= site_url('assets/datepicker/bootstrap-datepicker.js')?>"></script>
<script>
    function hapus(id){
      var hps = confirm('apakah anda yakin akan menghapus data akun ini?');
      if(hps == true){
        var setuju = confirm('Apakah anda setuju ?');
        if(setuju == true){
          window.location="<?= site_url('akuntansi/hapus_akun/'); ?>"+id;
        }
        else{
          return false;
        }
      }
      else{
        return false;
      }
    }

    function detail(i){
      $("#detail-"+i).toggle();
      // var kodeJurnal = $("#kode-"+i).html();
      
      //  $.ajax({
      //   'url':"<?= site_url('jurnal/detail_jurnal');?>",
      //   'type':'POST',
      //   'data':'kode='+kodeJurnal,
      //   success:function(detail){
      //     $("#row-"+i).after("<tr><td colspan='4'><table class='table table-bordered table-striped'><thead><tr><th class='col-md-1 text-center'>No</th><th class='col-md-4 text-center'>Nama Akun</th><th class='col-md-2 text-center'>Debet</th><th class='col-md-2 text-center'>Kredit</th></tr></thead><tbody>"+detail+"</tbody></table></td></tr>");
      //   }
      //  });
      
      // $("#row-"+i).after();
    }

    $(document).ready(function(){
       var jurnal = $("#table-jurnal").DataTable({
           'processing':true,
           'serverSide':true,
           'order':[[1,'asc']],
           'ajax':{
               'url':"<?= site_url('jurnal/get_data_jurnal');?>",
               'type':'POST',
               'dataType':'json',

           },
           'createdRow':function(row,data,index){
              $(row).attr('id','row-'+index);
              $('td',row).eq(1).attr('id','kode-'+index);

              var kodeJurnal =  $('td',row).eq(1).html();
      
               $.ajax({
                'url':"<?= site_url('jurnal/detail_jurnal');?>",
                'type':'POST',
                'data':'kode='+kodeJurnal,
                success:function(detail){

                  $("#row-"+index).after("<tr id='detail-"+index+"' class='detail-jurnal'><td colspan='4'><table class='table table-bordered table-striped'><thead><tr><th class='col-md-1 text-center bg-red'>No</th><th class='col-md-4 text-center bg-red'>Nama Akun</th><th class='col-md-2 bg-red text-center bg-red'>Debet</th><th class='col-md-2 text-center bg-red'>Kredit</th></tr></thead><tbody>"+detail+"</tbody></table></td></tr>");

                  $(".detail-jurnal").css('display','none');
                }
               });
            
           },

           'columnDefs':[{
               'targets':[0,3],
               'orderable':false,
           },{
               'targets':[0,2,3],
               'className':'text-center',
           }]
       });

       // tgl
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

       // button submit
        $('#btn-submit').click(function(){
          var data_filter = $('#form-filtered').serialize();
           $.ajax({
            'url':"<?= site_url('jurnal/set_filter_jurnal');?>",
            'type':'POST',
            'data':data_filter,
            success:function(){
              jurnal.ajax.reload(null,false);
            }

           });

       });

      // button refresh
      $("#btn-refresh").click(function(){
          $("#data-tgl").val("");
          $("#tgl-awal").val("");
          $("#tgl-akhir").val("");
          $("#kode-jurnal").val("");
          

          $.ajax({
            'url':"<?= site_url('jurnal/reset_filter_jurnal');?>",
            success:function(){
              jurnal.ajax.reload(null,false);
            }
          });
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

            if($CI->session->flashdata('status_hapus_akun')== 'berhasil')
                {
        ?>
                    <div class="alert alert-success alert-dismissible fade in" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                        </button>
                        <strong>Sukses!</strong> Data Akun berhasil dihapus.
                    </div>
        <?php
                }
            else if($CI->session->flashdata('status_hapus_akun')== "gagal")
                {
        ?>
                    <div class="alert alert-danger alert-dismissible fade in" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                        </button>
                        <strong>Maaf!</strong> Data Akun gagal dihapus.
                    </div>
        <?php
                }

        ?>
        <!-- / informasi sukses atau gagal hapus data KDD  -->


        <div class="row">
        <div class="col-md-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                <h2 class="col-md-6">Daftar Jurnal CV [S] STUDIO <small></small></h2>
                <div class="col-md-6">
                  <a href="<?= site_url('jurnal/tambah_jurnal'); ?>" class="btn btn-primary pull-right"><span class="fa fa-plus" style="color:white"></span> Tambah</a>
                </div>
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
                            <label class="control-label col-md-2 col-sm-2 col-xs-12">Kode Jurnal</label>
                            <div class="col-md-4 col-sm-10 col-xs-10">
                                <input id="kode-jurnal" name="kode_jurnal" type="text" class="form-control">
                            </div>
                        </div>

                        
                   
                  </form>
                    <button id="btn-refresh" class="btn btn-sm btn-success col-md-2 col-md-offset-2"><i class="fa fa-refresh"></i> Refresh</button>
                    <button id="btn-submit" class="btn btn-sm btn-primary col-md-2"><i class="fa fa-search"></i> CARI</button>
                    <a href="<?= site_url('laporan_jurnal/cetak');?>" target='_blank' class="btn btn-sm btn-success col-md-2"><i class="fa fa-print"></i> Cetak Laporan</a>
                </div>

                <div class="x_content col-md-12">
                  <br />
                  <br />
                  <!-- Datatable data KDD -->
                  <table id="table-jurnal" class="table table-striped table-bordered ">
                    <thead>
                      <tr class="bg-primary">
                        <th class="col-md-1 text-center">No</th>
                        <th class="col-md-3 text-center">Kode Jurnal</th>
                        <th class="col-md-3 text-center">Tanggal</th>
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
