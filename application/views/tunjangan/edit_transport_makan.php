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
                  <h2>Edit Transport dan Uang Makan <small></small></h2>
                  
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                <br />
                    <?php 
                        foreach($transport as $trans){}
                    ?>
                    <form class="form-horizontal form-label-left" method="POST" action="<?= site_url('tunjangan/edit_data_transport_makan'); ?>">

                        <input type="hidden" name="id_transport" class="form-control" value="<?= $trans->id_transport_makan; ?>">
                        <!-- uang transport -->
                        <div class="form-group">
                            <label class="control-label col-md-2 col-sm-2 col-xs-12">Transport (Rp)</label>
                            <div class="col-md-3 col-sm-7 col-xs-10">
                                <input id="transport" type="number" min="0" name="transport" class="form-control" placeholder="" value="<?= $trans->transport; ?>"  autofocus>
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
                                <input id="uang-makan" type="number" min="0" name="uang_makan" class="form-control" placeholder="" value="<?= $trans->uang_makan; ?>"  autofocus>
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
                                  
                                   <?php
                                        $set_divisi = array();
                                        foreach($divisi as $div)
                                            {
                                                array_push($set_divisi,$div->nama_divisi);           
                                            }
                                        array_push($set_divisi,'SEMUA DIVISI');

                                        foreach($set_divisi as $sd => $val)
                                            {
                                                if($val == $trans->divisi)
                                                    {
                                    ?>
                                                        <option value="<?= $val; ?>" selected><?= $val; ?></option>
                                    <?php 
                                                    }
                                                else
                                                    {
                                    ?>
                                                        <option value="<?= $val; ?>"><?= $val; ?></option>
                                    <?php
                                                    }
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