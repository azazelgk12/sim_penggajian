<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Login</title>

    <!-- Bootstrap -->
    <link href="<?= site_url(); ?>assets/gantelela/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="<?= site_url(); ?>assets/gantelela/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="<?= site_url(); ?>assets/gantelela/vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- Animate.css -->
    <link href="<?= site_url(); ?>assets/gantelela/vendors/animate.css/animate.min.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="<?= site_url(); ?>assets/gantelela/build/css/custom.min.css" rel="stylesheet">

    <script src="<?= site_url(); ?>assets/js/jquery-3.2.1.min.js"></script>
    
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
      
      
      
      <div class="login_wrapper">
      
        <div class="animate form login_form">
          <section class="login_content">
          <?php
            $CI =& get_instance();
            
                if($CI->session->flashdata('status_register') == 'berhasil')
                  {
          ?>
                    <div class="alert alert-success alert-dismissible fade in" role="alert">
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                      </button>
                      <strong>Sukses</strong> Registrasi berhasil dilakukan.
                    </div>
          <?php
                  }
                

                if($CI->session->flashdata('status_login') == 'gagal')
                  {
          ?>
                    <div class="alert alert-danger alert-dismissible fade in" role="alert">
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                      </button>
                      <strong>Maaf</strong> Login gagal dilakukan.
                    </div>
          <?php
                  }
                 
          ?>
            <form method="POST" action="<?= site_url();?>akun/login">
              <h1 class="title-form">LOGIN</h1>
              <div>
                <input name="username" type="text" class="form-control" placeholder="Username" required autofocus />
              </div>
              <div>
                <input name="password" type="password" class="form-control" placeholder="Password" required />
              </div>
              <div>
                <button type="submit" class="btn btn-default btn-primary submit">Log in</button>
                
              </div>

              <div class="clearfix"></div>

              <div class="separator">
                <p class="change_link">Belum mempunyai akun?
                  <a href="<?= site_url(); ?>akun/registrasi" class="" style="color:blue;"> Buat akun </a>
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

