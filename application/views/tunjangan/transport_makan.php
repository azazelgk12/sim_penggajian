<?php $CI =& get_instance(); ?>
<style>

</style>
<link href="<?= site_url();?>assets/DataTables/datatables.css" rel="stylesheet">
<script src="<?= site_url();?>assets/DataTables/datatables.min.js"></script>
<script>
    function hapus(id){
      var hps = confirm('apakah anda yakin akan menhapus divisi ini? menghapus divisi ini akan menhapus data karyawan, jabatan dan data data lain yang berhubungan dengan divisi ini');
      if(hps == true){
        var setuju = confirm('Apakah anda setuju ?');
        if(setuju == true){
          window.location="<?= site_url('divisi/hapus/'); ?>"+id;
        }
        else{
          return false;
        }
      }
      else{
        return false;
      }
    }

   
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
            if($CI->session->flashdata('status_edit_transport')== 'berhasil')
                {
        ?>
                    <div class="alert alert-success alert-dismissible fade in" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                        </button>
                        <strong>Sukses!</strong> Data Transport dan uang makan  berhasil diubah.
                    </div>
        <?php
                }
            else if($CI->session->flashdata('status_edit_transport')== "gagal")
                {
        ?>
                    <div class="alert alert-danger alert-dismissible fade in" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                        </button>
                        <strong>Maaf!</strong> Data Transport dan uang makan  gagal diubah.
                    </div>
        <?php
                }
          
        ?>


        <div class="row">
        <div class="col-md-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                <h2 class="col-md-6">Transport dan Uang Makan <small></small></h2>
                
                <div class="clearfix"></div>
                </div>
                <div class="x_content col-md-12">
                  <br />
                  <br />
                  <!-- Datatable data KDD -->
                  <table id="table-transport" class="table table-striped table-bordered ">
                    <thead>
                      <tr class="bg-primary">
                        <th class="col-md-2 text-center">No</th>
                        <th class="col-md-2 text-center">Transport</th>
                        <th class="col-md-2 text-center">Uang Makan</th>
                        <th class="col-md-4 text-center">Divisi</th>
                        <th class="col-md-2 text-center">aksi</th>
                      </tr>
                    </thead>

                    <tbody>
                      <?php
                        $no = 1;
                        foreach($transport as $trans)
                          {
                      ?>
                            <tr>
                              <td class="text-center"><?= $no++; ?></td>
                              <td class="text-center"><?= $trans->transport; ?></td>
                              <td class="text-center"><?= $trans->uang_makan; ?></td>
                              <td class="text-center"><?= $trans->divisi; ?></td>
                              <td class="text-center"><a href="<?= site_url('tunjangan/edit_transport/'.$trans->id_transport_makan); ?>" class="btn btn-sm btn-primary" title="Edit"><i class="fa fa-pencil"></i></td>
                            </tr>
                      <?php      
                          }
                      ?>
                    </tbody>

                  </table>
                  <!-- / Datatable data KDD -->
                </div>
            </div>
            </div>
        </div>
    </div>
</div>
