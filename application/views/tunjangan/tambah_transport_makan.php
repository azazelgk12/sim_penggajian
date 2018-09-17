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
            if($CI->session->flashdata('status_tambah_transport')== 'berhasil')
                {
        ?>
                    <div class="alert alert-success alert-dismissible fade in" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                        </button>
                        <strong>Sukses!</strong> Data Transport dan uang makan  berhasil ditambahkan.
                    </div>
        <?php
                }
            else if($CI->session->flashdata('status_tambah_transport')== "gagal")
                {
        ?>
                    <div class="alert alert-danger alert-dismissible fade in" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                        </button>
                        <strong>Maaf!</strong> Data Transport dan uang makan  gagal ditambahkan.
                    </div>
        <?php
                }
             else if($CI->session->flashdata('status_tambah_transport')== "sudah ada")
                {
        ?>
                    <div class="alert alert-danger alert-dismissible fade in" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                        </button>
                        <strong>Maaf!</strong> Data Transport dan uang makan sudah ada, dan tidak bisa ditambahkan.
                    </div>
        <?php
                }
        ?>
        
        <div class="row">
        <div class="col-md-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                  <h2>Form Tambah Transport dan Uang Makan <small></small></h2>
                  
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                <br />
                    <form class="form-horizontal form-label-left" method="POST" action="<?= site_url('tunjangan/tambah_data_transport_makan'); ?>">

                        <!-- uang transport -->
                        <div class="form-group">
                            <label class="control-label col-md-2 col-sm-2 col-xs-12">Transport (Rp)</label>
                            <div class="col-md-3 col-sm-7 col-xs-10">
                                <input id="transport" type="number" min="0" name="transport" class="form-control" placeholder="" value="<?= $CI->session->flashdata('old_transport'); ?>"  autofocus>
                            </div>
                            <!-- form error -->
                            <div class="col-md-10 col-xs-10 col-sm-10 col-md-offset-2 form-error">
                                <?= form_error('transport');?>
                            </div>
                            <!-- /form error -->
                        
                        </div>

                         <!-- uang transport -->
                        <div class="form-group">
                            <label class="control-label col-md-2 col-sm-2 col-xs-12">Uang Makan (Rp)</label>
                            <div class="col-md-3 col-sm-7 col-xs-10">
                                <input id="uang-makan" type="number" min="0" name="uang_makan" class="form-control" placeholder="" value="<?= $CI->session->flashdata('old_uang_makan'); ?>"  autofocus>
                            </div>
                            <!-- form error -->
                            <div class="col-md-10 col-xs-10 col-sm-10 col-md-offset-2 form-error">
                                <?= form_error('uang_makan');?>
                            </div>
                            <!-- /form error -->
                        
                        </div>
        
                        <div class="form-group">
                            <label class="control-label col-md-2 col-sm-2 col-xs-12">Divisi</label>
                            <div class="col-md-4 col-sm-7 col-xs-10">
                               <select name="divisi" id="divisi" class="form-control">
                                   <option value="SEMUA DIVISI" selected>SEMUA DIVISI</option>
                                   <?php
                                        foreach($divisi as $div)
                                            {
                                    ?>
                                                <option value="<?= $div->nama_divisi; ?>"><?= $div->nama_divisi; ?></option>
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