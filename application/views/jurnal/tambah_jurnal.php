<?php $CI =& get_instance(); ?>

<script>
    function hapusJurnal(i){
            $("#jurnal-"+i).remove();
            var jumlahdata = parseInt($("#jumlah-data").val());
            $("#jumlah-data").val(jumlahdata-1);
    }

    function hapusInput(){
        $("#jumlah-data").val(2);
        $(".jurnal-tambahan").remove();
    }
    $(document).ready(function(){
      
       

        $("#tambah-inputan").click(function(){
            $.ajax({
                url:"<?= site_url('jurnal/data_akun')?>",
                success:function(data){
                    var lastNumber = parseInt($("#jumlah-data").val());
                    var nextNumber = lastNumber +1;
                    $("#lastNumber").removeAttr('id');
                    $("#data-jurnal").append(' <tr id="jurnal-'+nextNumber+'" class="jurnal-tambahan"><td class="text-center">'+nextNumber+'</td><td><select name="nama_akun[]" required class="form-control"><option value=""selected>--Pilih Akun--</option>'+data+'</select></td><td><input type="number" min="0" class="form-control" name="debet[]" value="0"></td><td><input type="number" min="0" class="form-control" name="kredit[]" value="0"></td><td class="text-center"><button class="btn btn-sm btn-danger" title="hapus" type="button" onclick="hapusJurnal(\''+nextNumber+'\')"><i class="fa fa-trash"></i></button></td></tr>');
                    $("#jumlah-data").val(nextNumber);
                }
            });

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

            if($CI->session->flashdata('status_tambah_jurnal')== 'berhasil')
                {
        ?>
                    <div class="alert alert-success alert-dismissible fade in" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                        </button>
                        <strong>Sukses!</strong> Data Jurnal baru berhasil ditambahkan.
                    </div>
        <?php
                }
            else if($CI->session->flashdata('status_tambah_jurnal')== "gagal")
                {
        ?>
                    <div class="alert alert-danger alert-dismissible fade in" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                        </button>
                        <strong>Maaf!</strong> Data Jurnal baru gagal ditambahkan.
                    </div>
        <?php
                }
        ?>
        
        <div class="row">
        <div class="col-md-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                  <h2>Form Tambah Jurnal <small></small></h2>
                  
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                <br />
                    <form class="form-horizontal form-label-left" method="POST" action="<?= site_url('jurnal/tambah_data_jurnal'); ?>">
                        
                        <input type="hidden" id="jumlah-data"name='jumlah_data' value="2">
                        <table class="table table-bordered table-striped">
                            <thead class="bg-primary">
                                <tr>
                                    <th class="col-md-1 text-center">No</th>
                                    <th class="col-md-3 text-center">Nama Akun</th>
                                    <th class="col-md-2 text-center">Debet</th>
                                    <th class="col-md-2 text-center">Kredit</th>
                                    <th class="col-md-1 text-center">Aksi</th>
                                </tr>
                                <tbody id="data-jurnal">
                                    <tr>
                                        <td class="text-center">1</td>
                                        <td>
                                            <select name="nama_akun[]" required class="form-control">
                                                <option value="" selected>--Pilih Akun--</option>
                                                <?php 
                                                    foreach($akun as $a)
                                                        {
                                                            echo "<option value='".$a->id_akun."'>".$a->nama_akun."</option>";
                                                        }
                                                ?>
                                            </select>
                                        </td>
                                        <td><input type="number" min="0" class="form-control" value="0" name="debet[]"></td>
                                        <td><input type="number" min="0" class="form-control" value="0" name="kredit[]"></td>
                                        <td class="text-center">-</td>
                                    </tr>

                                     <tr>
                                        <td class="text-center" id="last-number">2</td>
                                        <td>
                                            <select name="nama_akun[]" required class="form-control">
                                                <option value="" selected>--Pilih Akun--</option>
                                                <?php 
                                                    foreach($akun as $a)
                                                        {
                                                            echo "<option value='".$a->id_akun."'>".$a->nama_akun."</option>";
                                                        }
                                                ?>
                                            </select>
                                        </td>
                                        <td><input type="number" min="0" class="form-control" value="0" name="debet[]"></td>
                                        <td><input type="number" min="0" class="form-control" value="0" name="kredit[]"></td>
                                        <td class="text-center">-</td>
                                    </tr>

                                </tbody>
                            </thead>
                        </table>
                      
                        <div class="ln_solid"></div>
                        <div class="form-group">
                        <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                            <button type="button" onclick="hapusInput()" class="btn btn-primary"><span class="fa fa-refresh"></span> Ulangi</button>
                            <button type="submit" class="btn btn-success"><span class="fa fa-save"></span> Simpan</button>
                            <button id="tambah-inputan" type="button" class="btn btn-success"><span class="fa fa-plus-square"></span> Tambah Inputan</button>
                        </div>
                        </div>

                    </form>
                </div>
            </div>
            </div>
        </div>
    </div>
</div>