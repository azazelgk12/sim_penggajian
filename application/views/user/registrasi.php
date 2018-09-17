<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Registrasi</title>
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

        $("#btn-register").attr('disabled',true);

        $("#pass-reg, #pass-reg-conf").keyup(function(){
          var pass1 = $("#pass-reg").val();
          var pass2 = $("#pass-reg-conf").val();
          
          if(pass1.length != 0 && pass2.length != 0){
            if(pass1 == pass2){
              $("#btn-register").attr('disabled',false);
            }
            else{
              $("#btn-register").attr('disabled',true);
            }
          }
          
        });

         

      });
    </script>
  </head>

  <body class="login">
    <div>
      
      <a class="hiddenanchor" id="signup"></a>
      <a class="hiddenanchor" id="signin"></a>
      
      <div class="login_wrapper">
      
       

        <div id="register" class="animate form login_form">
          <section class="login_content">
          <?php
                $CI =& get_instance();
                 if($CI->session->flashdata('status_register') == 'gagal')
                  {
          ?>
                    <div class="alert alert-danger alert-dismissible fade in" role="alert">
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                      </button>
                      <strong>Maaf!</strong> Registrasi gagal dilakukan.
                    </div>
          <?php
                  }
                 
                 else if($CI->session->flashdata('status_register') == 'berhasil')
                  {
          ?>
                    <div class="alert alert-danger alert-dismissible fade in" role="alert">
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                      </button>
                      <strong>Sukses,</strong> Registrasi berhasil dilakukan.
                    </div>
          <?php
                  }
              
          ?>
          
            <form method="POST" action="<?= site_url();?>akun/register">
              
              <h1 class="title-form">Registrasi</h1>
              
              <div>
                <select name="pegawai" id="pegawai" class="form-control">
                  <option value="" selected>-- Pilih Pegawai --</option>
                  <?php
                    foreach($pegawai as $p)
                      {
                  ?>
                        <option value="<?= $p->id_karyawan; ?>"><?= $p->nama; ?></option>
                  <?php      
                      }
                  ?>
                </select>
              </div>
              <div class="clearfix"><br></div>

              <div>
                <input type="text" name="username" value="<?= @$CI->session->flashdata('old_username');?>" class="form-control" placeholder="Username" required="" autocomplete="off" />
                <?= form_error('username');?>
              </div>
              
              
             
              <div>
                <input id="pass-reg" type="password" name="password" class="form-control" placeholder="Password" required="" />
                <?= form_error('password');?>
              </div>
              <div>
                <input id="pass-reg-conf" type="password" name="password_conf" class="form-control" placeholder="Ulangi Password" required="" />
                <?= form_error('password_conf');?>
              </div>
              <div>
                <button id="btn-register" type="submit" class="btn btn-primary submit">Submit</button>
              </div>

              <div class="clearfix"></div>

              <div class="separator">
                <p class="change_link">Sudah mempunyai akun ?
                  <a href="<?= site_url();?>akun" class="" style="color:blue;"> Silahkan Log in </a>
                </p>

                <div class="clearfix"></div>
                <br />

               
              </div>
              
            </form>
          </section>
        </div>
      </div>
    </div>
  </body>
</html>

