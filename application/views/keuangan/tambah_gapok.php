<?php $CI =& get_instance(); ?>
<style>
  #nama-divisi{
    text-transform: uppercase;
  }
</style>


<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
            <h3><?= $title_page;?> </h3>
            </div>

            
        </div>
        <div class="clearfix"></div>

        <?php
            if($CI->session->flashdata('status_tambah_gapok')== 'berhasil')
                {
        ?>
                    <div class="alert alert-success alert-dismissible fade in" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                        </button>
                        <strong>Sukses!</strong> Gaji Pokok berhasil ditambahkan.
                    </div>
        <?php
                }
            else if($CI->session->flashdata('status_tambah_gapok')== "gagal")
                {
        ?>
                    <div class="alert alert-danger alert-dismissible fade in" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                        </button>
                        <strong>Maaf!</strong> Gaji pokok gagal ditambahkan.
                    </div>
        <?php
                }
        ?>
        
        <div class="row">
        <div class="col-md-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                  <h2>Form Tambah Gaji Pokok <small></small></h2>
                  
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                <br />
                    <form class="form-horizontal form-label-left" method="POST" action="<?= site_url('penggajian/tambah_data_gapok'); ?>">

                        <!-- Nama Jabatan -->
                        <div class="form-group">
                            <label class="control-label col-md-2 col-sm-2 col-xs-12">Karyawan</label>
                            <div class="col-md-4 col-sm-7 col-xs-10">
                               <select name="karyawan" id="karyawan" class="form-control">
                                   <option value="" selected="">--Pilih karyawan</option>
                                   <?php
                                    foreach($karyawan as $kr)
                                     {
                                   ?>
                                        <option value="<?= $kr->id_karyawan;?>"><?= $kr->nama;?></option>
                                   <?php     
                                     }
                                   ?>
                               </select>
                            </div>
                            <!-- form error -->
                            <div class="col-md-10 col-xs-10 col-sm-10 col-md-offset-2 form-error">
                                <?= form_error('karyawan');?>
                            </div>
                            <!-- /form error -->
                        
                        </div>

                          <!-- Gaji POkok -->
                        <div class="form-group">
                            <label class="control-label col-md-2 col-sm-2 col-xs-12">Gaji Pokok (Rp)</label>
                            <div class="col-md-2 col-sm-7 col-xs-10">
                                <input id="gapok" type="number" min="0" name="gapok" class="form-control" value="<?= $CI->session->flashdata('old_gapok'); ?>" >
                            </div>
                            <!-- form error -->
                            <div class="col-md-9 col-xs-9 col-sm-9 col-md-offset-2 form-error">
                                <?= form_error('gapok');?>
                            </div>
                            <!-- /form error -->
                        
                        </div>

                         <!-- Jenis Pembayaran -->
                        <div class="form-group">
                            <label class="control-label col-md-2 col-sm-2 col-xs-12">Jenis Pembayaran</label>
                            <div class="col-md-3 col-sm-7 col-xs-10">
                                <select name="jenis_pembayaran" id="jenis-pembayaran" class="form-control">
                                    <option value="" selected="">--PIlih Jenis Pembayaran--</option>
                                    <option value="perbulan">Perbulan</option>
                                    <option value="perhari">Perhari</option>
                                </select>
                            </div>
                            <!-- form error -->
                            <div class="col-md-9 col-xs-9 col-sm-9 col-md-offset-2 form-error">
                                <?= form_error('jenis_pembayaran');?>
                            </div>
                            <!-- /form error -->
                        
                        </div>

                                        
                        
                    


                        <div class="ln_solid"></div>
                        <div class="form-group">
                        <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                            <button type="reset" class="btn btn-primary"><span class="fa fa-refresh"></span> Ulangi</button>
                            <button type="submit" class="btn btn-success"><span class="fa fa-save"></span> Simpan</button>
                        </div>
                        </div>

                    </form>
                </div>
            </div>
            </div>
        </div>
    </div>
</div>