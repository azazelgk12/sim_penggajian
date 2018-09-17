<?php $CI =& get_instance(); ?>

<link rel="stylesheet" href="<?= site_url('assets/datepicker/datepicker3.css');?>">
<link href="<?= site_url();?>assets/DataTables/datatables.css" rel="stylesheet">
<script src="<?= site_url();?>assets/DataTables/datatables.min.js"></script>
<script src="<?= site_url('assets/datepicker/bootstrap-datepicker.js')?>"></script>
<script>
    

    $(document).ready(function(){
       var karyawanTerlambat = $("#table-keterlambatan").DataTable({
           'dom':'lrtip',
           'processing':true,
           'serverSide':true,
            'searching':false,
               'destroy':true,
           'order':[[1,'asc']],
           'ajax':{
               'url':"<?= site_url('keterlambatan/get_data_keterlambatan_karyawan');?>",
               'type':'POST',
               'dataType':'json',

           },

           'columnDefs':[{
               'targets':[0],
               'orderable':false,
           },{
               'targets':[0,1,3],
               'className':'text-center',
           }]
       });

       $('#btn-submit').click(function(){
          var data_filter = $('#form-filtered').serialize();
           $.ajax({
            'url':"<?= site_url('keterlambatan/set_filter_keterlambatan');?>",
            'type':'POST',
            'data':data_filter,
            success:function(){
              karyawanTerlambat.ajax.reload(null,false);
            }

           });

       });

       $("#btn-refresh").click(function(){
          $("#data-tgl").val("");
          $("#tgl-awal").val("");
          $("#tgl-akhir").val("");
          $("#karyawan").val("");
          $("#potongan").val("");

          karyawanTerlambat.ajax.reload(null,false);
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

     

        <div class="row">
        <div class="col-md-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                <h2 class="col-md-6">Potongan Keterlambatan CV [S] STUDIO <small></small></h2>
                
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
                            <label class="control-label col-md-2 col-sm-2 col-xs-12">Potongan</label>
                            <div class="col-md-2 col-sm-10 col-xs-10">
                                <input id="potongan" name="potongan" type="number" min="0" class="form-control">
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
                  <table id="table-keterlambatan" class="table table-striped table-bordered ">
                    <thead>
                      <tr class="bg-primary">
                        <th class="col-md-1 text-center">No</th>
                        <th class="col-md-3 text-center">Tanggal</th>
                        <th class="col-md-6 text-center">Nama Karyawan</th>
                        <th class="col-md-2 text-center">Potongan</th>
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
