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
            if($CI->session->flashdata('status_edit_divisi')== 'berhasil')
                {
        ?>
                    <div class="alert alert-success alert-dismissible fade in" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                        </button>
                        <strong>Sukses!</strong> Data Divisi baru berhasil diubah.
                    </div>
        <?php
                }
            else if($CI->session->flashdata('status_edit_divisi')== "gagal")
                {
        ?>
                    <div class="alert alert-danger alert-dismissible fade in" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                        </button>
                        <strong>Maaf!</strong> Data Divisi baru gagal diubah.
                    </div>
        <?php
                }
        ?>
        
        <div class="row">
        <div class="col-md-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                  <h2>Form Edit Divisi <small></small></h2>
                  
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                <br />
                    <form class="form-horizontal form-label-left" method="POST" action="<?= site_url('divisi/edit_data_divisi'); ?>">
                        
                        <?php 
                            foreach($divisi as $dvs){}
                        ?>
                        <input type="hidden" name="id_divisi" value="<?= $dvs->id_divisi; ?>">
                        <!-- Nama Divisi -->
                        <div class="form-group">
                            <label class="control-label col-md-2 col-sm-2 col-xs-12">Nama Divisi</label>
                            <div class="col-md-4 col-sm-7 col-xs-10">
                                <input id="nama-divisi" type="text" name="nama_divisi" class="form-control" placeholder="Nama Divisi" value="<?= $dvs->nama_divisi; ?>"  autofocus>
                            </div>
                            <!-- form error -->
                            <div class="col-md-10 col-xs-10 col-sm-10 col-md-offset-2 form-error">
                                <?= form_error('nama_divisi');?>
                            </div>
                            <!-- /form error -->
                        
                        </div>

                        <div class="ln_solid"></div>
                        <div class="form-group">
                        <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                            <button type="reset" class="btn btn-primary"><span class="fa fa-refresh"></span> Ulangi</button>
                            <button type="submit" class="btn btn-success"><span class="fa fa-pencil"></span> Ubah</button>
                        </div>
                        </div>

                    </form>
                </div>
            </div>
            </div>
        </div>
    </div>
</div>