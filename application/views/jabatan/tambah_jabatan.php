<?php $CI =& get_instance(); ?>
<style>
  #nama-jabatan{
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
            if($CI->session->flashdata('status_tambah_jabatan')== 'berhasil')
                {
        ?>
                    <div class="alert alert-success alert-dismissible fade in" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                        </button>
                        <strong>Sukses!</strong> Data jabatan baru berhasil ditambahkan.
                    </div>
        <?php
                }
            else if($CI->session->flashdata('status_tambah_jabatan')== "gagal")
                {
        ?>
                    <div class="alert alert-danger alert-dismissible fade in" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                        </button>
                        <strong>Maaf!</strong> Data jabatan baru gagal ditambahkan.
                    </div>
        <?php
                }
        ?>
        
        <div class="row">
        <div class="col-md-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                  <h2>Form Tambah Jabatan <small></small></h2>
                  
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                <br />
                    <form class="form-horizontal form-label-left" method="POST" action="<?= site_url('jabatan/tambah_data_jabatan'); ?>">

                        <!-- Nama jabatan -->
                        <div class="form-group">
                            <label class="control-label col-md-2 col-sm-2 col-xs-12">Nama Jabatan</label>
                            <div class="col-md-4 col-sm-7 col-xs-10">
                                <input id="nama-jabatan" type="text" name="nama_jabatan" class="form-control" placeholder="Nama jabatan" value="<?= $CI->session->flashdata('old_nama_jabatan'); ?>"  autofocus>
                            </div>
                            <!-- form error -->
                            <div class="col-md-10 col-xs-10 col-sm-10 col-md-offset-2 form-error">
                                <?= form_error('nama_jabatan');?>
                            </div>
                            <!-- /form error -->
                        
                        </div>

                        <!-- nama divisi -->
                        <div class="form-group">
                            <label class="control-label col-md-2 col-sm-2 col-xs-12">Divisi</label>
                            <div class="col-md-3 col-sm-7 col-xs-10">
                                <select name="divisi" id="divisi" class="form-control">
                                    <option value="" selected>--Pilih Divisi--</option>
                                    <?php
                                        foreach($divisi as $dvs)
                                            {
                                    ?>
                                                <option value="<?= $dvs->id_divisi; ?>"><?= $dvs->nama_divisi;?></option>
                                    <?php            
                                            }
                                    ?>
                                </select>
                            </div>
                            <!-- form error -->
                            <div class="col-md-10 col-xs-10 col-sm-10 col-md-offset-2 form-error">
                                <?= form_error('divisi');?>
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