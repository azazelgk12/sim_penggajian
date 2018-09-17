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
            if($CI->session->flashdata('status_edit_tunjangan')== 'berhasil')
                {
        ?>
                    <div class="alert alert-success alert-dismissible fade in" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                        </button>
                        <strong>Sukses!</strong> Tunjangan berhasil diubah.
                    </div>
        <?php
                }
            else if($CI->session->flashdata('status_edit_tunjangan')== "gagal")
                {
        ?>
                    <div class="alert alert-danger alert-dismissible fade in" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                        </button>
                        <strong>Maaf!</strong> Tunjangan gagal diubah.
                    </div>
        <?php
                }
        ?>
        
        <?php
            foreach($data_tunjangan as $dt){}
        ?>

        <div class="row">
        <div class="col-md-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                  <h2 class="co-md-9">Form Edit Tunjangan</h2>
                  <div class="col-md-10">
                      <a href="<?= site_url('tunjangan/detail_tunjangan/'.$dt->id_karyawan); ?>" class="btn btn-sm btn-primary pull-right"><i class="fa fa-arrow-left"></i> Kembali</a>
                  </div>
                  
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                <br />
                    <form class="form-horizontal form-label-left" method="POST" action="<?= site_url('tunjangan/edit_data_tunjangan_karyawan'); ?>">
                        
                       
                        <input type="hidden" name="id_tunjangan_karyawan" id="id-tunjangan-karyawan" value="<?= $dt->id_tunjangan_karyawan; ?>">
                        <input type="hidden" name="id_karyawan" id="id-karyawan" value="<?= $dt->id_karyawan; ?>">
                        <!-- Nama Jabatan -->
                        <div class="form-group">
                            <label class="control-label col-md-2 col-sm-2 col-xs-12">Nama Pegawai</label>
                            <div class="col-md-4 col-sm-7 col-xs-10">
                               <input type="text" name="nama_karyawan" id="nama_karyawan" readonly="true" value="<?= $dt->nama; ?>" class="form-control">
                            </div>
                         
                        
                        </div>
                        
                        <!-- Nik Karyawan -->
                        <div class="form-group">
                            <label class="control-label col-md-2 col-sm-2 col-xs-12">NIK</label>
                            <div class="col-md-3 col-sm-7 col-xs-10">
                               <input type="text" name="nik_karyawan" id="nik-karyawan" class="form-control" readonly="true" value="<?= $dt->nik; ?>">
                            </div>                        
                        </div>

                        <!-- jabatan -->
                        <div class="form-group">
                            <label class="control-label col-md-2 col-sm-2 col-xs-12">Jabatan</label>
                            <div class="col-md-3 col-sm-7 col-xs-10">
                               <input type="text" name="jabatan" id="jabatan" class="form-control" readonly="true" value="<?= $dt->nama_jabatan; ?>">
                            </div>                        
                        </div>

                        <!-- divisi -->
                        <div class="form-group">
                            <label class="control-label col-md-2 col-sm-2 col-xs-12">Divisi</label>
                            <div class="col-md-3 col-sm-7 col-xs-10">
                               <input type="text" name="divisi" id="divisi" class="form-control" readonly="true" value="<?= $dt->nama_divisi; ?>">
                            </div>                        
                        </div>

                        

                         <!-- Nama Tunjangan -->
                        <div class="form-group">
                            <label class="control-label col-md-2 col-sm-2 col-xs-12">Nama Tunjangan</label>
                            <div class="col-md-4 col-sm-7 col-xs-10">
                               <select name="tunjangan" id="tunjangan" class="form-control">
                                   <option value="" selected="">--Pilih Tunjangan--</option>
                                   <?php
                                    foreach($tunjangan as $tun)
                                     {
                                        if($tun->id_master_tunjangan == $dt->id_master_tunjangan)
                                            {
                                    ?>
                                                <option value="<?= $tun->id_master_tunjangan;?>" selected><?= $tun->nama_tunjangan;?></option>
                                    <?php
                                            }
                                        else
                                            {
                                    ?>
                                                <option value="<?= $tun->id_master_tunjangan;?>"><?= $tun->nama_tunjangan;?></option>
                                    <?php
                                            }  
                                     }
                                   ?>
                               </select>
                            </div>
                            <!-- form error -->
                            <div class="col-md-10 col-xs-10 col-sm-10 col-md-offset-2 form-error">
                                <?= form_error('tunjangan');?>
                            </div>

                            <?php
                                if($CI->session->flashdata('data_tunjangan') == "sudah ada")
                                    {
                            ?>  
                                        <div class="col-md-10 col-xs-10 col-sm-10 col-md-offset-2 form-error">
                                            Karyawan ini sudah memiliki tunjangan yg dipilih
                                        </div>
                            <?php 
                                    }
                            ?>
                            <!-- /form error -->
                        
                        </div>
                        
                      

                         <!-- jumlah Pembayaran -->
                        <div class="form-group">
                            <label class="control-label col-md-2 col-sm-2 col-xs-12">Jumlah Tunjangan (Rp)</label>
                            <div class="col-md-3 col-sm-7 col-xs-10">
                               <input type="number" min="0" name="jumlah_tunjangan" id="jumlah-tunjangan" class="form-control" value="<?= $dt->jumlah_tunjangan; ?>">
                            </div>
                            <!-- form error -->
                            <div class="col-md-9 col-xs-9 col-sm-9 col-md-offset-2 form-error">
                                <?= form_error('jumlah_tunjangan');?>
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