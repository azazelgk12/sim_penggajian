<?php $CI =& get_instance(); ?>
<style>

</style>
<link href="<?= site_url();?>assets/DataTables/datatables.css" rel="stylesheet">
<script src="<?= site_url();?>assets/DataTables/datatables.min.js"></script>
<script>
    function hapus(id){
      var hps = confirm('apakah anda yakin akan menghapus data jam kerja ini ?');
      if(hps == true){
        var setuju = confirm('Apakah anda setuju ?');
        if(setuju == true){
          window.location="<?= site_url('absensi/hapus_jam_kerja/'); ?>"+id;
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


            if($CI->session->flashdata('status_hapus_jam_kerja')== 'gagal')
                {
        ?>
                    <div class="alert alert-success alert-dismissible fade in" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                        </button>
                        <strong>Sukses!</strong> Data Jam Kerja gagal dihapus.
                    </div>
        <?php
                }

            if($CI->session->flashdata('status_edit_jam_kerja')== 'berhasil')
                {
        ?>
                    <div class="alert alert-success alert-dismissible fade in" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                        </button>
                        <strong>Sukses!</strong> Data Jam Kerja berhasil diubah.
                    </div>
        <?php
                }
            else if($CI->session->flashdata('status_edit_jam_kerja')== "gagal")
                {
        ?>
                    <div class="alert alert-danger alert-dismissible fade in" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                        </button>
                        <strong>Maaf!</strong> Data Jam Kerja gagal diubah.
                    </div>
        <?php
                }

        ?>

        <!-- informasi berhasil atau gagal hapus data KDD -->
        <?php

            if($CI->session->flashdata('status_tambah_jam_kerja')== 'berhasil')
                {
        ?>
                    <div class="alert alert-success alert-dismissible fade in" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                        </button>
                        <strong>Sukses!</strong> Data Jam Kerja berhasil ditambahkan.
                    </div>
        <?php
                }
            else if($CI->session->flashdata('status_tambah_jam_kerja')== "gagal")
                {
        ?>
                    <div class="alert alert-danger alert-dismissible fade in" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                        </button>
                        <strong>Maaf!</strong> Data Jam Kerja gagal ditambahkan.
                    </div>
        <?php
                }

        ?>
        <!-- / informasi sukses atau gagal hapus data KDD  -->


        <div class="row">
        <div class="col-md-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                <h2 class="">Jam Kerja CV [S] STUDIO <small></small></h2>
                
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
                        <th class="col-md-4 text-center">Jam Masuk</th>
                        <th class="col-md-5 text-center">Jam Kerja</th>
                        <th class="col-md-2 text-center">aksi</th>
                      </tr>
                    </thead>


                    <tbody>
                      <?php 
                        $no = 1;
                        foreach($jam_kerja as $jk)
                          {
                            $id_shift = $jk->id_shift;
                      ?>
                            <tr>
                              <td class="text-center"><?= $no++; ?></td>
                              <td class="text-center"><?= $jk->jam_masuk; ?></td>
                              <td class="text-center"><?= $jk->jam_pulang; ?></td>
                              <td class="text-center">
                                <a href="<?= site_url('absensi/edit_jam_kerja/'.$jk->id_shift); ?>" title="Edit" class="btn btn-success btn-sm col-md-5"><span class="fa fa-pencil"></span></a>
                                <button class="btn btn-sm btn-danger col-md-5" title="Hapus" onclick="hapus('<?= $id_shift; ?>')"><span class="fa fa-trash"></span></button>
                              </td>
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
