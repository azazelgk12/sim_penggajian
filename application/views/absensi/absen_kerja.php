<?php $CI =& get_instance();?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Absensi Kerja Pegawai </title>

  
    <link href="<?= site_url();?>assets/gantelela/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="<?= site_url();?>assets/gantelela/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <!-- <link href="<?= site_url();?>assets/gantelela/vendors/nprogress/nprogress.css" rel="stylesheet"> -->
    <!-- Animate.css -->
    <!-- <link href="<?= site_url();?>assets/gantelela/vendors/animate.css/animate.min.css" rel="stylesheet"> -->

    <!-- Custom Theme Style -->
    <link href="<?= site_url();?>assets/gantelela/build/css/custom.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?= site_url();?>assets/typehead/jquery.typeahead.css">
    
    <style>
      #nik-pegawai{
        font-size: 14px;
      }

      .typeahead__list{
        font-size: 14px;
      }
      .form-error{
        color:red;
      }
    </style>
    <!-- jquery -->
    <script src="<?= site_url();?>assets/js/jquery-3.2.1.min.js"></script>

    <script type="text/javascript" src="<?= site_url();?>assets/typehead/jquery.typeahead.js"></script>
    <script>

      $(document).ready(function(){

        

        // tampil jam sekarang
        setInterval(function(){
          $.ajax({
            url:'<?= site_url("absen_kerja/tampil_jam_sekarang"); ?>',
            success:function(jam){
              $("#jam-sekarang").val(jam);
              $("#jam").html(jam);
            }
          });

          // cek status absen kerja
        $.ajax({
          url:"<?= site_url('absen_kerja/cek_jam_kerja');?>",
          success:function(status){

            if(status == "masuk"){
              $("#status-absen").val("masuk");
              $("#btn-status-absen").html("<span class='fa fa-sign-in'></span> MASUK")
            }
            else if(status == "pulang"){
              $("#status-absen").val("pulang");
              $("#btn-status-absen").html("<span class='fa fa-sign-out'></span> PULANG")
            }
            
            
          }
        });
        },1000);


        $("#nik-pegawai").typeahead({
            // input: "#nik-pegawai",
            minLength: 1,
            order: "asc",
            group: false,
            maxItemPerGroup: 5,
            // groupOrder: function (node, query, result, resultCount, resultCountPerGroup) {

            //     var scope = this,
            //         sortGroup = [];

            //     for (var i in result) {
            //         sortGroup.push({
            //             group: i,
            //             length: result[i].length
            //         });
            //     }

            //     sortGroup.sort(
            //         scope.helper.sort(
            //             ["length"],
            //             false, // false = desc, the most results on top
            //             function (a) {
            //                 return a.toString().toUpperCase()
            //             }
            //         )
            //     );

            //     return $.map(sortGroup, function (val, i) {
            //         return val.group
            //     });
            // },
            hint: true,
            // dropdownFilter: "All",
            template: "{{display}}</em></small>",
            emptyTemplate: "no result for {{query}}",
            source: {
                // country: {
                //     data: data.countries
                // },
                'Karyawan': {
                
                  ajax: {
                      type: "POST",
                       url: "<?= site_url('absen_kerja/tampil_data_pegawai'); ?>",
                      data: {
                          myKey: "nik",
                          field:"nik",
                      }
                  }
              }
            },
           
            debug: true
        });

        setTimeout(function(){
          $(".alert-absen").hide();
        },10000);

      });
    </script>
  </head>

  <body class="login">
    <div>
     

      <div class="login_wrapper">
        <div class="clearfix"></div>

         
              <?php
                if($CI->session->flashdata('status_absen') == 'berhasil')
                  {
              ?>    
                      <div class="alert alert-success alert-absen alert-dismissible fade in" role="alert">
                          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                          </button>
                          <strong>
                            Sukses, absen berhasil dilakukan
                          </strong>
                    </div>
              <?php
                    
                  }
                else if($CI->session->flashdata('status_absen') == 'gagal')
                  {
              ?>    
                      <div class="alert alert-danger alert-absen alert-dismissible fade in" role="alert">
                          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                          </button>
                          <strong>
                            Maaf absen gagal dilakukan
                          </strong>
                    </div>
              <?php
                    
                  }
                else if($CI->session->flashdata('status_absen') == 'sudah ada')
                  {
              ?>    
                      <div class="alert alert-danger alert-absen alert-dismissible fade in" role="alert">
                          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                          </button>
                          <strong>
                            Maaf absen sudah pernah dilakukan
                          </strong>
                    </div>
              <?php
                    
                  }
              ?>
            

        <div class="animate form login_form">
          <section class="login_content">
            <form class="form-horizontal col-md-12" action="<?= site_url('absen_kerja/input_data_absen');?>" method="POST">
              <h1 id="jam"></h1>
              <h1>Absensi Kerja</h1>

              <div form-group>
                <input id="status-absen" name="status_absen" type="hidden" class="form-control"/>
              </div>
              <div form-group>
                <input id="jam-sekarang" name="jam_sekarang" type="hidden" class="form-control"/>
              </div>
                
              <div class="typeahead__container">
                  <div class="typeahead__field">
                      <div class="typeahead__query form-group">
                          <input id="nik-pegawai" class="js-typeahead form-control"
                                 name="nik"
                                 type="search"
                                 autofocus
                                 autocomplete="off" placeholder="Masukan NIK / Nama">
                      </div>
                      
                  </div>
              </div>

               <!-- form error -->
                            <div class="col-md-12 col-xs-12 col-sm-12 form-error">
                                <?= form_error('nik');?>
                            </div>
                            <!-- /form error -->
              <button id="btn-status-absen" class="btn btn-primary submit"></button>
                

              <div>
                  <h1> CV [S] STUDIO</h1>
                  <p>©<?= date('Y'); ?> All Rights Reserved.</p>
                </div>
             
          
              
            </form>
            


          </section>


        </div>

        
      </div>
    </div>
  </body>
</html>
