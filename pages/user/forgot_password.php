<?php

  if ( (isset($_SESSION['nik'])) && (isset($_SESSION['nama'])) ) {
    header("Location: ../dashboard.php");
  }

  //Import PHPMailer classes into the global namespace
  //These must be at the top of your script, not inside a function
  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\SMTP;
  use PHPMailer\PHPMailer\Exception;

  //Load Composer's autoloader
  require '../../vendor/autoload.php';

  include '../../database/config.php';

  $dotenv = Dotenv\Dotenv::createImmutable("../../");
  $dotenv->load();

  $username = getenv('mailUsername');
  $username = $_ENV['mailUsername'];
  $username = $_SERVER['mailUsername'];

  $password = getenv('mailPassword');
  $password = $_ENV['mailPassword'];
  $password = $_SERVER['mailPassword'];

  if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $code = md5(rand());

    if (mysqli_num_rows(mysqli_query($conn, "SELECT * FROM pengguna WHERE email='{$email}'")) > 0){
      $query = mysqli_query($conn, "UPDATE pengguna SET code='{$code}' WHERE email='{$email}'");

      if ($query) {
        echo "<div style='display: none;'>";
        //Create an instance; passing `true` enables exceptions
        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = $username;                     //SMTP username
            $mail->Password   = $password;                                //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom($username);
            $mail->addAddress($email);

          //Content
          $mail->isHTML(true);                                  //Set email format to HTML
          $mail->Subject = 'no reply';
          $mail->Body    = 'Here is the verification link <b><a href="http://localhost:8080/peduli_diri/pages/user/change_password.php?reset='.$code.'">http://localhost:8080/peduli_diri/pages/user/change_password.php?reset='.$code.'</a></b>';

          $mail->send();
          echo 'Message has been sent';
        } catch (Exception $e) {
          echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
        echo "</div>";
        header("Location: forgot_password.php?sukses=Kami telah mengirimkan link verifikasi ke alamat email Anda.");
        }
        
      } else {
        header("Location: forgot_password.php?gagal=$email - Alamat email ini tidak ditemukan.");
    }
  }

?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="../../css/bootstrap.min.css" rel="stylesheet">

    <!-- Sweet Alert -->
    <link href="../../assets/sweetalert/sweetalert2.min.css" rel="stylesheet" type="text/css">

    <!-- My CSS -->
    <link rel="stylesheet" href="../../css/style.css">

    <title>Forgot Password | Peduli Diri</title>
    <link rel="shortcut icon" href="../../img/favicon.png" type="image/x-icon">
  </head>
  <body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-color">
      <div class="container">
        <a class="navbar-brand nav-title my-2" href="../../index.php">
          <img src="../../img/favicon.png" alt="Peduli Diri" width="40" height="40"> Peduli Diri
        </a>
      </div>
    </nav>
    <!-- End of Navbar -->

    <!-- Form Login -->
    <div class="container">
      <div class="row my-3">
        <div class="col-12 col-sm-10 col-md-4 col-lg-4 col-xl-4 header-register my-5 offset-md-1 ">
          <div class="card card-primary cz">
            <div class="card-header"><h5>Lupa Password</h5></div>
            <div class="card-body pt-0 px-4">
              <form action="" method="POST" class="form-group needs-validation" novalidate>
                <?php if (isset($_GET['sukses'])) { ?>
                <div class="alert alert-success" role="alert">
                  <?php echo $_GET['sukses'] ?>
                </div>
                <?php } ?>
                <?php if (isset($_GET['gagal'])) { ?>
                <div class="alert alert-danger" role="alert">
                  <?php echo $_GET['gagal'] ?>
                </div>
                <?php } ?>
                <div class="form-group">
                  <label class="label" for="email" class="d-block">Email</label>
                  <input id="email" placeholder="Masukkan email anda" type="email" name="email" class="form-control form" required="" autofocus="" autocomplete="off">
                </div>
                <div class="form-group text-center pt-4">
                  <button type="submit" name="submit" class="login btn btn-primary button btn-lg btn-block">Kirim Reset Link</button>
                </div>
              </form>
              <div class="text-center pt-4">
                Kembali ke!
                <a class="p-1 link" href="../login.php">Login</a>
              </div>
            </div>
          </div>
          <div class="simple-footer text-center">
            Copyright ©Community @2022
          </div>
        </div>
        <div class="col-md-7 d-none d-md-block mt-0 pt-0 text-center">
          <h1 class="text-bold mb-0 pb-0">Mencatat Perjalanan Anda<br> dengan kemudahan</h1>
          <img src="../../img/ilustrations/login.svg" class="mt-0 pt-0" height="450">
        </div>
      </div>
    </div>
    <!-- End of Form -->

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="../../js/bootstrap.bundle.min.js"></script>
    <!-- Sweet Alert -->
    <script src="../../assets/sweetalert/sweetalert2.min.js"></script>
    <script>
      // Example starter JavaScript for disabling form submissions if there are invalid fields
    (function () {
      'use strict'

      // Fetch all the forms we want to apply custom Bootstrap validation styles to
      var forms = document.querySelectorAll('.needs-validation')

      // Loop over them and prevent submission
      Array.prototype.slice.call(forms)
        .forEach(function (form) {
          form.addEventListener('submit', function (event) {
            if (!form.checkValidity()) {
              event.preventDefault()
              event.stopPropagation()
            }

            form.classList.add('was-validated')
          }, false)
        })
    })()
    </script>
    <script>
      // const Toast = Swal.mixin({
      //   toast: true,
      //   position: 'top-end',
      //   showConfirmButton: false,
      //   timer: 3000,
      // })

      // Toast.fire({
      //   icon: 'success',
      //   title: 'Signed in successfully'
      // })

      function numericOnly(event) {
        var key = event.keyCode;
        return ((key >= 48 && key <= 57) || key == 8);
      };

      function alphaOnly(event) {
        var key = event.keyCode;
        return ((key >= 65 && key <= 90) || key == 8 || key == 32);
      };
    </script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    -->
  </body>
</html>