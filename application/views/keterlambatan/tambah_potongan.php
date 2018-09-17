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
            if($CI->session->flashdata('status_tambah_potongan')== 'berhasil')
                {
        ?>
                    <div class="alert alert-success alert-dismissible fade in" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                        </button>
                        <strong>Sukses!</strong> Data potongan keterlambatan berhasil ditambahkan.
                    </div>
        <?php
                }
            else if($CI->session->flashdata('status_tambah_potongan')== "gagal")
                {
        ?>
                    <div class="alert alert-danger alert-dismissible fade in" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                        </button>
                        <strong>Maaf!</strong> Data potongan keterlambatan gagal ditambahkan.
                    </div>
        <?php
                }
        ?>
        
        <div class="row">
        <div class="col-md-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                  <h2>Form Tambah Divisi <small></small></h2>
                  
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                <br />
                    <form class="form-horizontal form-label-left" method="POST" action="<?= site_url('keterlambatan/tambah_data_potongan'); ?>">

                        <!-- lama Keterlambatan absensi -->
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-2 col-xs-12">Lama Keterlambatan (menit)</label>
                            <div class="col-md-2 col-sm-7 col-xs-10">
                                <input id="lama-keterlambatan" type="number" min="0" name="lama_keterlambatan" class="form-control" value="<?= $CI->session->flashdata('old_lama_keterlambatan'); ?>"  autofocus>
                            </div>
                            <!-- form error -->
                            <div class="col-md-9 col-xs-9 col-sm-9 col-md-offset-3 form-error">
                                <?= form_error('lama_keterlambatan');?>
                            </div>
                            <!-- /form error -->
                        
                        </div>
                        

                        <!-- jumlah potongan keterlambatan -->
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-2 col-xs-12">Jumlah Potongan (Rp)</label>
                            <div class="col-md-2 col-sm-7 col-xs-10">
                                <input id="jumlah-potongan" type="number" min="0" name="jumlah_potongan" class="form-control" value="<?= $CI->session->flashdata('old_jumlah_potongan'); ?>"  autofocus>
                            </div>
                            <!-- form error -->
                            <div class="col-md-9 col-xs-9 col-sm-9 col-md-offset-3 form-error">
                                <?= form_error('jumlah_potongan');?>
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