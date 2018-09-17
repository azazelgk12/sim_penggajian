<?php $CI =& get_instance(); ?>

<script type="text/javascript">
    $(document).ready(function(){


        $('#jam-masuk,#jam-pulang').datetimepicker({
            format: 'HH:mm'
        });
    });
</script>


<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
            <h3><?= $title_page;?> </h3>
            </div>

            
        </div>
        <div class="clearfix"></div>

        <?php
             if($CI->session->flashdata('status_edit_jam_kerja') == 'gagal')
                {
        ?>
                     <div class="alert alert-danger alert-dismissible fade in" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                        </button>
                        <strong>Maaf!</strong> Jam Kerja gagal diubah.
                    </div>
        <?php            
                }

            if($CI->session->flashdata('selisih_jam_kerja') != null)
                {
        ?>
                     <div class="alert alert-danger alert-dismissible fade in" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                        </button>
                        <strong>Maaf!</strong> <?= $CI->session->flashdata('selisih_jam_kerja'); ?>.
                    </div>
        <?php            
                }

            if($CI->session->flashdata('status_hapus_jam_kerja')== 'berhasil')
                {
        ?>
                    <div class="alert alert-success alert-dismissible fade in" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                        </button>
                        <strong>Sukses!</strong> Data Jam Kerja berhasil dihapus.
                    </div>
        <?php
                }
            else if($CI->session->flashdata('status_hapus_jam_kerja')== "gagal")
                {
        ?>
                    <div class="alert alert-danger alert-dismissible fade in" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                        </button>
                        <strong>Maaf!</strong> Data Jam Kerja gagal dihapus.
                    </div>
        <?php
                }
        ?>
        
        <div class="row">
        <div class="col-md-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                  <h2>Form Edit Jam Kerja <small></small></h2>
                  
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                <br />
                    <form class="form-horizontal form-label-left" method="POST" action="<?= site_url('absensi/edit_data_jam_kerja'); ?>">
                        
                        <?php foreach($jam_kerja as $jk){} ?>

                        <input type="hidden" name="id_shift" value="<?= $jk->id_shift;?>">
                        <!-- Jam Masuk -->
                        <div class="form-group">
                            <label class="control-label col-md-2 col-sm-2 col-xs-12">Jam Masuk</label>
                            <div class="col-md-2 col-sm-7 col-xs-10">
                                <div class='input-group date' id='jam-masuk'>
                                    <input type='text' name="jam_masuk" id="data-jam-masuk" class="form-control" value="<?= $jk->jam_masuk;?>" />
                                    <span class="input-group-addon">
                                       <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                            <!-- form error -->
                            <div class="col-md-10 col-xs-10 col-sm-10 col-md-offset-2 form-error">
                                <?= form_error('jam_masuk');?>
                            </div>
                            <!-- /form error -->
                        
                        </div>

                        <!-- Jam Masuk -->
                        <div class="form-group">
                            <label class="control-label col-md-2 col-sm-2 col-xs-12">Jam Pulang</label>
                            <div class="col-md-2 col-sm-7 col-xs-10">
                                <div class='input-group date' id='jam-pulang'>
                                    <input type='text' name="jam_pulang" id="data-jam-pulang" class="form-control" value="<?= $jk->jam_pulang;?>"/>
                                    <span class="input-group-addon">
                                       <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                            <!-- form error -->
                            <div class="col-md-10 col-xs-10 col-sm-10 col-md-offset-2 form-error">
                                <?= form_error('jam_pulang');?>
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