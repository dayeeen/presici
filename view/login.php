<!DOCTYPE html>
<!-- Coding by CodingNepal | www.codingnepalweb.com-->
<html lang="en" dir="ltr">

<head>
  <meta charset="UTF-8">
  <title> Login </title>
  <!-- Custom styles for this template -->
  <link href="./lib/login.css" rel="stylesheet">
  <!-- Fontawesome CDN Link -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <script src="./lib/ie-emulation-modes-warning.js"></script>
  <link rel="icon" href="./lib/img/logo.png">
</head>

<body>
  <div class="container">
    <input type="checkbox" id="flip">
    <div class="cover">
      <div class="front">
        <img src="./lib/img/wallpaper.jpg" alt="">
        <div class="text">
          <span class="text-1">Tidak ada kata terlambat dalam belajar. <br> Namun jika anda sering telat,<br>  maka anda memang kurang ajar!</span>
          <span class="text-2">Kumaha barudak? Well ah</span>
        </div>
      </div>
      <div class="back">
        <div class="text">
          <span class="text-1">Complete miles of journey <br> with one step</span>
          <span class="text-2">Let's get started</span>
        </div>
      </div>
    </div>
    <div class="forms">
      <div class="form-content">
        <div class="login-form">
          <div class="title">Login</div>
          <form class="form-signin" method="post" action="model/proses.php">
            <?php
            if (isset($_GET['log'])) {
              if ($_GET['log'] == 2) {
                echo "<div class='alert alert-danger'><strong>Periksa kembali email & katasandi Anda!</strong></div>";
              }
            }
            ?>
            <div class="input-boxes">
              <div class="input-box">
                <i class="fas fa-envelope"></i>
                <input type="email" placeholder="Masukkan email anda" name="email" id="inputEmail" required>
              </div>
              <div class="input-box">
                <i class="fas fa-lock"></i>
                <input type="password" placeholder="Masukkan kata sandi" name="pwd" id="inputPassword" required>
              </div>
              <div class="text"><a href="">Lupa katasandi?</a></div>
              <div class="button input-box">
                <input type="submit" name="login" value="Login">
              </div>
              <div class="text sign-up-text">Akun tidak terdaftar? <label for="flip">Hubungi Admin</label></div>
            </div>
          </form>
        </div>
        <div class="signup-form">
          <div class="title">Form Laporan</div>
          <form action="#">
            <div class="input-boxes">
              <div class="input-box">
                <i class="fas fa-user"></i>
                <input type="text" placeholder="Masukkan nama anda" required>
              </div>
              <div class="input-box">
                <i class="fas fa-envelope"></i>
                <input type="email" placeholder="Masukkan email anda" required>
              </div>
              <div class="input-box">
                <i class="fas fa-book"></i>
                <input type="text" placeholder="Masukkan keluhan anda" required>
              </div>
              <div class="button input-box">
                <input type="submit" value="Kirim">
              </div>
              <div class="text sign-up-text">Sudah punya akun? <label for="flip">Login sekarang</label></div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</body>

</html>